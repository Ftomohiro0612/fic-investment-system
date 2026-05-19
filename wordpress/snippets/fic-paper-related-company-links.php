<?php
/**
 * FIC paper sector related company links.
 *
 * Ensures paper/packaging company analyses link to each other before generic
 * related-link snippets can insert less relevant candidates.
 */

add_filter('the_content', 'fic_paper_insert_related_company_links', 20);

function fic_paper_normalize_stock_code($stock_code) {
    $stock_code = strtoupper(trim((string) $stock_code));
    if (preg_match('/([0-9]{4})/', $stock_code, $matches)) {
        return $matches[1];
    }

    return '';
}

function fic_paper_current_stock_code() {
    if (function_exists('fic_get_stock_code_from_post')) {
        $code = fic_paper_normalize_stock_code(fic_get_stock_code_from_post());
        if ($code !== '') {
            return $code;
        }
    }

    $post = get_post();
    if (!$post) {
        return '';
    }

    foreach ([$post->post_name, $post->post_title] as $text) {
        if (preg_match('/([0-9]{4})/', (string) $text, $matches)) {
            return $matches[1];
        }
    }

    return '';
}

function fic_paper_get_post_by_code($stock_code) {
    $stock_code = fic_paper_normalize_stock_code($stock_code);
    if ($stock_code === '') {
        return null;
    }

    if (function_exists('fic_get_post_by_stock_code_in_slug')) {
        $post = fic_get_post_by_stock_code_in_slug($stock_code);
        if ($post) {
            return $post;
        }
    }

    global $wpdb;
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

function fic_paper_related_company_group($current_code) {
    $groups = [
        '3861' => ['3863', '3941', '3880', '3865'],
        '3863' => ['3861', '3941', '3880', '3865'],
        '3941' => ['3861', '3863', '3880', '3865'],
        '3880' => ['3861', '3863', '3941', '3865'],
        '3865' => ['3861', '3863', '3941', '3880'],
    ];

    return $groups[$current_code] ?? [];
}

function fic_paper_company_name_map() {
    return [
        '3861' => '王子ホールディングス',
        '3863' => '日本製紙',
        '3941' => 'レンゴー',
        '3880' => '大王製紙',
        '3865' => '北越コーポレーション',
    ];
}

function fic_paper_render_related_company_links($current_code) {
    $related_codes = fic_paper_related_company_group($current_code);
    if (empty($related_codes)) {
        return '';
    }

    $name_map = fic_paper_company_name_map();
    $items = [];

    foreach ($related_codes as $related_code) {
        $post = fic_paper_get_post_by_code($related_code);
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
    echo '<div class="fic-related-companies-description">同じ製紙・包装業界で比較しやすい分析記事です。</div>';
    echo '<ul>';
    foreach ($items as $item) {
        echo '<li><a href="' . esc_url($item['url']) . '">' . esc_html($item['name']) . '（' . esc_html($item['code']) . '）</a></li>';
    }
    echo '</ul>';
    echo '</div>';

    return ob_get_clean();
}

function fic_paper_insert_related_company_links($content) {
    if (!is_singular('post') || strpos($content, 'fic-related-companies') !== false) {
        return $content;
    }

    $current_code = fic_paper_current_stock_code();
    if ($current_code === '') {
        return $content;
    }

    $block = fic_paper_render_related_company_links($current_code);
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
