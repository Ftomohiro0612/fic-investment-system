<?php
add_filter('the_content', 'fic_alpha_insert_related_company_links', 21);
add_filter('the_content', 'fic_alpha_insert_related_theme_links', 22);

function fic_alpha_normalize_stock_code($stock_code) {
    $stock_code = strtoupper(trim((string) $stock_code));

    if (preg_match('/^([0-9]{3}[0-9A-Z]|[0-9]{4})(?:\.[A-Z]+)?$/u', $stock_code, $matches)) {
        return $matches[1];
    }

    return '';
}

function fic_alpha_stock_code_regex() {
    return '/(?<![0-9A-Z])([0-9]{3}[0-9A-Z]|[0-9]{4})(?:\.[A-Z]+)?(?![0-9A-Z])/iu';
}

function fic_alpha_current_stock_code() {
    $post = get_post();
    if (!$post) {
        return '';
    }

    foreach ([$post->post_name, $post->post_title] as $text) {
        if (preg_match(fic_alpha_stock_code_regex(), strtoupper((string) $text), $matches)) {
            return fic_alpha_normalize_stock_code($matches[1]);
        }
    }

    return '';
}

function fic_alpha_get_post_by_code($stock_code) {
    global $wpdb;

    $stock_code = fic_alpha_normalize_stock_code($stock_code);
    if ($stock_code === '') {
        return null;
    }

    $current_id = get_queried_object_id();
    $post_id = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT ID FROM {$wpdb->posts}
             WHERE post_type = 'post'
               AND post_status = 'publish'
               AND post_name LIKE %s
               AND ID <> %d
             ORDER BY post_date DESC
             LIMIT 1",
            '%' . $wpdb->esc_like(strtolower($stock_code)) . '%',
            (int) $current_id
        )
    );

    return $post_id ? get_post((int) $post_id) : null;
}

function fic_alpha_related_company_groups() {
    $groups = [];

    $semiconductor_memory = ['285A', '8035', '7735', '6146', '6857', '4063', '3436'];
    $semiconductor_equipment = ['8035', '7735', '6146', '6857', '6920'];

    foreach ([$semiconductor_memory, $semiconductor_equipment] as $group) {
        foreach ($group as $code) {
            if (!isset($groups[$code])) {
                $groups[$code] = [];
            }

            $groups[$code] = array_values(array_unique(array_merge(
                $groups[$code],
                array_values(array_diff($group, [$code]))
            )));
        }
    }

    return $groups;
}

function fic_alpha_company_name_map() {
    return [
        '285A' => 'キオクシアホールディングス',
        '8035' => '東京エレクトロン',
        '7735' => 'SCREENホールディングス',
        '6146' => 'ディスコ',
        '6857' => 'アドバンテスト',
        '6920' => 'レーザーテック',
        '4063' => '信越化学工業',
        '3436' => 'SUMCO',
    ];
}

function fic_alpha_render_related_companies($current_code) {
    $groups = fic_alpha_related_company_groups();
    if (!isset($groups[$current_code])) {
        return '';
    }

    $name_map = fic_alpha_company_name_map();
    $items = [];

    foreach ($groups[$current_code] as $related_code) {
        $post = fic_alpha_get_post_by_code($related_code);
        if (!$post) {
            continue;
        }

        $items[] = [
            'name' => $name_map[$related_code] ?? get_the_title($post->ID),
            'code' => $related_code,
            'url'  => get_permalink($post->ID),
        ];
    }

    if (empty($items)) {
        return '';
    }

    ob_start();
    echo '<div class="fic-related-companies">';
    echo '<p><strong>関連銘柄分析</strong></p>';
    echo '<div class="fic-related-companies-description">同じ業界・テーマで比較しやすい分析記事です。</div>';
    echo '<ul>';
    foreach ($items as $item) {
        echo '<li><a href="' . esc_url($item['url']) . '">' . esc_html($item['name']) . '（' . esc_html($item['code']) . '）</a></li>';
    }
    echo '</ul>';
    echo '</div>';

    return ob_get_clean();
}

function fic_alpha_insert_before_reference($content, $block) {
    if ($block === '') {
        return $content;
    }

    $pattern = '/(<h2\b[^>]*>(?:(?!<\/h2>).)*参照資料(?:(?!<\/h2>).)*<\/h2>)/us';
    if (preg_match($pattern, $content)) {
        return preg_replace_callback(
            $pattern,
            function ($matches) use ($block) {
                return $block . $matches[1];
            },
            $content,
            1
        );
    }

    return $content . $block;
}

function fic_alpha_insert_related_company_links($content) {
    if (!is_singular('post') || strpos($content, 'fic-related-companies') !== false) {
        return $content;
    }

    $current_code = fic_alpha_current_stock_code();
    if ($current_code === '') {
        return $content;
    }

    return fic_alpha_insert_before_reference($content, fic_alpha_render_related_companies($current_code));
}

function fic_alpha_related_theme_keywords($current_code) {
    $map = [
        '285A' => ['285A', 'キオクシア', 'NAND', 'SSD', '半導体メモリ'],
    ];

    return $map[$current_code] ?? [$current_code];
}

function fic_alpha_get_related_theme_posts($current_code, $limit = 4) {
    $category_ids = [];
    foreach (['業界分析', '業種別分析'] as $category_name) {
        $category = get_category_by_slug($category_name);
        if (!$category) {
            $category = get_term_by('name', $category_name, 'category');
        }

        if ($category && !is_wp_error($category)) {
            $category_ids[] = (int) $category->term_id;
        }
    }

    if (empty($category_ids)) {
        return [];
    }

    $posts = [];
    $seen = [get_queried_object_id() => true];

    foreach (fic_alpha_related_theme_keywords($current_code) as $keyword) {
        $query = new WP_Query([
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => $limit,
            'post__not_in'        => array_keys($seen),
            'category__in'        => array_values(array_unique($category_ids)),
            's'                   => $keyword,
            'orderby'             => 'modified',
            'order'               => 'DESC',
            'ignore_sticky_posts' => true,
            'no_found_rows'       => true,
        ]);

        foreach ($query->posts as $post) {
            if (isset($seen[$post->ID])) {
                continue;
            }
            $posts[] = $post;
            $seen[$post->ID] = true;

            if (count($posts) >= $limit) {
                return $posts;
            }
        }
    }

    return $posts;
}

function fic_alpha_render_related_themes($current_code) {
    $posts = fic_alpha_get_related_theme_posts($current_code);
    if (empty($posts)) {
        return '';
    }

    ob_start();
    echo '<div class="fic-related-companies fic-related-themes">';
    echo '<p><strong>関連テーマ分析</strong></p>';
    echo '<div class="fic-related-companies-description">この企業の業績に関係しやすい業界・マクロテーマの記事です。</div>';
    echo '<ul>';
    foreach ($posts as $post) {
        echo '<li><a href="' . esc_url(get_permalink($post->ID)) . '">';
        echo '<span class="fic-related-link-title">' . esc_html(get_the_title($post->ID)) . '</span>';
        echo '<span class="fic-related-link-date">公開日：' . esc_html(get_the_date('Y年n月j日', $post->ID)) . '</span>';
        echo '</a></li>';
    }
    echo '</ul>';
    echo '</div>';

    return ob_get_clean();
}

function fic_alpha_insert_related_theme_links($content) {
    if (!is_singular('post') || strpos($content, 'fic-related-themes') !== false) {
        return $content;
    }

    $post_id = get_queried_object_id();
    $is_company_analysis = false;
    foreach (['企業分析', '企業別分析（古い記事）'] as $category_name) {
        if (function_exists('fic_is_post_in_category_name') && fic_is_post_in_category_name($post_id, $category_name)) {
            $is_company_analysis = true;
            break;
        }
    }

    if (!$is_company_analysis) {
        return $content;
    }

    $current_code = fic_alpha_current_stock_code();
    if ($current_code === '') {
        return $content;
    }

    return fic_alpha_insert_before_reference($content, fic_alpha_render_related_themes($current_code));
}
