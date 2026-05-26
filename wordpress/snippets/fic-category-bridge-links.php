<?php
/**
 * FIC category bridge links.
 *
 * Adds a compact internal-link block to existing analysis articles so readers can
 * move from an article to the relevant learning or theme-reading hub.
 */

if (!function_exists('fic_bridge_has_category_name')) {
function fic_bridge_has_category_name($post_id, $category_names) {
    $category_names = is_array($category_names) ? $category_names : [$category_names];
    $categories = get_the_category($post_id);

    foreach ($categories as $category) {
        if (in_array($category->name, $category_names, true) || in_array($category->slug, $category_names, true)) {
            return true;
        }
    }

    return false;
}
}

if (!function_exists('fic_bridge_url_by_slug')) {
function fic_bridge_url_by_slug($slug, $fallback_path) {
    $post = get_page_by_path($slug, OBJECT, 'post');

    if ($post && 'publish' === get_post_status($post)) {
        return get_permalink($post);
    }

    return home_url($fallback_path);
}
}

if (!function_exists('fic_bridge_tracking_attr')) {
function fic_bridge_tracking_attr($area, $label) {
    return ' data-fic-area="' . esc_attr($area) . '" data-fic-label="' . esc_attr($label) . '"';
}
}

if (!function_exists('fic_bridge_get_stock_code_from_text')) {
function fic_bridge_get_stock_code_from_text($text) {
    if (preg_match('/(?<![0-9A-Z])([0-9]{4}|[0-9]{3}[A-Z])(?![0-9A-Z])/u', strtoupper((string) $text), $matches)) {
        return $matches[1];
    }

    return '';
}
}

if (!function_exists('fic_bridge_is_old_company_archive_post')) {
function fic_bridge_is_old_company_archive_post($post_id) {
    $post = get_post($post_id);
    if ($post && preg_match('/^code-[0-9]{4}[A-Z]?$/i', (string) $post->post_name)) {
        return true;
    }

    $categories = get_the_category($post_id);
    foreach ($categories as $category) {
        if ((int) $category->term_id === 4 || $category->name === '企業別分析（古い記事）') {
            return true;
        }
    }

    return false;
}
}

if (!function_exists('fic_bridge_render_old_article_archive_box')) {
function fic_bridge_render_old_article_archive_box($post_id) {
    $post = get_post($post_id);
    if (!$post) {
        return '';
    }

    $stock_code = fic_bridge_get_stock_code_from_text($post->post_name . ' ' . $post->post_title . ' ' . $post->post_content);
    $search_query = $stock_code !== '' ? $stock_code : $post->post_title;
    $search_url = add_query_arg('s', $search_query, home_url('/'));

    ob_start();
    echo '<div class="fic-update-box fic-update-box--archive">';
    echo '<div class="fic-update-label">ARCHIVE</div>';
    echo '<div class="fic-update-content">';
    echo '<div class="fic-update-title">この記事は過去の企業分析です</div>';
    echo '<p>最新の決算や事業環境を確認する場合は、企業ハブまたはサイト内検索から新しい分析を探せます。</p>';
    echo '<a href="' . esc_url(home_url('/companies/')) . '" class="fic-update-link"' . fic_bridge_tracking_attr('old_article_archive', '企業を探す') . '>企業を探す →</a>';
    echo '<a href="' . esc_url($search_url) . '" class="fic-update-link"' . fic_bridge_tracking_attr('old_article_archive_search', $search_query) . '>この銘柄を検索する →</a>';
    echo '</div>';
    echo '</div>';

    return ob_get_clean();
}
}

if (!function_exists('fic_bridge_insert_old_article_archive_box')) {
function fic_bridge_insert_old_article_archive_box($content) {
    if (!is_singular('post')) {
        return $content;
    }

    if (strpos($content, 'fic-update-box') !== false || strpos($content, 'fic-update-box--archive') !== false) {
        return $content;
    }

    $post_id = get_queried_object_id();
    if (!$post_id || !fic_bridge_is_old_company_archive_post($post_id)) {
        return $content;
    }

    if (function_exists('fic_get_latest_company_analysis_post_for_old_post') && fic_get_latest_company_analysis_post_for_old_post($post_id)) {
        return $content;
    }

    return fic_bridge_render_old_article_archive_box($post_id) . $content;
}
add_filter('the_content', 'fic_bridge_insert_old_article_archive_box', 9);
}

if (!function_exists('fic_render_category_bridge_links')) {
function fic_render_category_bridge_links($type) {
    if ($type === 'company') {
        $items = [
            ['label' => '決算短信', 'title' => '決算短信の読み方', 'url' => fic_bridge_url_by_slug('kessan-tanshin-reading-guide', '/kessan-tanshin-reading-guide/')],
            ['label' => '利益率', 'title' => '営業利益率の見方', 'url' => fic_bridge_url_by_slug('operating-margin-guide', '/operating-margin-guide/')],
            ['label' => '先行指標', 'title' => '受注残と在庫の見方', 'url' => fic_bridge_url_by_slug('orders-backlog-inventory-guide', '/orders-backlog-inventory-guide/')],
        ];
        $lead = '企業分析で出てくる数字を先に確認する';
        $hub_url = home_url('/learn/');
        $hub_label = '投資の読み方へ';
    } else {
        $items = [
            ['label' => '金利', 'title' => '金利上昇で見る企業影響', 'url' => fic_bridge_url_by_slug('interest-rate-impact-stocks', '/interest-rate-impact-stocks/')],
            ['label' => '為替', 'title' => '為替で業績が動く企業の見方', 'url' => fic_bridge_url_by_slug('fx-impact-company-earnings', '/fx-impact-company-earnings/')],
            ['label' => '原材料', 'title' => '原材料高と価格転嫁', 'url' => fic_bridge_url_by_slug('raw-material-cost-pass-through', '/raw-material-cost-pass-through/')],
        ];
        $lead = 'ニュース材料を企業業績へつなげる読み方';
        $hub_url = home_url('/themes/');
        $hub_label = 'テーマから探すへ';
    }

    ob_start();
    echo '<section class="fic-category-bridge" aria-label="関連する読み方">';
    echo '<div class="fic-category-bridge-head">';
    echo '<p>READING GUIDE</p>';
    echo '<strong>' . esc_html($lead) . '</strong>';
    echo '<a href="' . esc_url($hub_url) . '"' . fic_bridge_tracking_attr('article_bridge_hub', $hub_label) . '>' . esc_html($hub_label) . '</a>';
    echo '</div>';
    echo '<div class="fic-category-bridge-grid">';
    foreach ($items as $item) {
        echo '<a href="' . esc_url($item['url']) . '"' . fic_bridge_tracking_attr('article_bridge_card', $item['title']) . '>';
        echo '<span>' . esc_html($item['label']) . '</span>';
        echo '<strong>' . esc_html($item['title']) . '</strong>';
        echo '</a>';
    }
    echo '</div>';
    echo '</section>';

    return ob_get_clean();
}
}

if (!function_exists('fic_render_category_context_links')) {
function fic_render_category_context_links($type) {
    if ($type === 'company') {
        $links = [
            ['text' => '決算短信の読み方', 'url' => fic_bridge_url_by_slug('kessan-tanshin-reading-guide', '/kessan-tanshin-reading-guide/')],
            ['text' => '営業利益率の見方', 'url' => fic_bridge_url_by_slug('operating-margin-guide', '/operating-margin-guide/')],
            ['text' => 'キャッシュフロー計算書の見方', 'url' => fic_bridge_url_by_slug('cash-flow-guide', '/cash-flow-guide/')],
        ];
        $text_before = '企業分析では、売上・利益・現金収支のつながりを押さえると読みやすくなります。';
        $text_after = 'もあわせて確認すると、本文中の数字を整理しやすくなります。';
    } else {
        $links = [
            ['text' => '金利上昇で見る企業影響', 'url' => fic_bridge_url_by_slug('interest-rate-impact-stocks', '/interest-rate-impact-stocks/')],
            ['text' => '為替で業績が動く企業の見方', 'url' => fic_bridge_url_by_slug('fx-impact-company-earnings', '/fx-impact-company-earnings/')],
            ['text' => '原材料高と価格転嫁', 'url' => fic_bridge_url_by_slug('raw-material-cost-pass-through', '/raw-material-cost-pass-through/')],
        ];
        $text_before = 'テーマ分析では、ニュース材料を売上・利益・バリュエーションへどうつなげるかが重要です。';
        $text_after = 'もあわせて読むと、テーマから企業業績への見方を整理しやすくなります。';
    }

    $html = '<p><strong>この分析を読む補助線：</strong>' . esc_html($text_before);
    foreach ($links as $index => $link) {
        if ($index === 0) {
            $html .= ' ';
        } elseif ($index === count($links) - 1) {
            $html .= '、';
        } else {
            $html .= '、';
        }
        $html .= '<a href="' . esc_url($link['url']) . '"' . fic_bridge_tracking_attr('article_context_link', $link['text']) . '>' . esc_html($link['text']) . '</a>';
    }
    $html .= esc_html($text_after) . '</p>';

    return $html;
}
}

if (!function_exists('fic_get_category_related_config')) {
function fic_get_category_related_config($type) {
    $configs = [
        'company' => [
            'categories' => ['企業分析'],
            'label'      => 'Company Analysis',
            'title'      => '同じ企業分析を読む',
            'lead'       => '個別企業の見方を広げたいときは、近い読み方の記事へ進めます。',
            'hub_url'    => home_url('/companies/'),
            'hub_label'  => '企業を探すへ',
            'fallback'   => '/category/company-analysis/',
        ],
        'theme' => [
            'categories' => ['テーマ分析', '業界分析', '業種別分析'],
            'label'      => 'Theme Analysis',
            'title'      => '同じテーマ分析を読む',
            'lead'       => 'ニュース材料が別の業界や企業へどう広がるかを続けて確認できます。',
            'hub_url'    => home_url('/themes/'),
            'hub_label'  => 'テーマから探すへ',
            'fallback'   => '/category/theme-analysis/',
        ],
        'theme_reading' => [
            'categories' => ['テーマの読み方'],
            'label'      => 'Theme Guides',
            'title'      => 'ほかのテーマの読み方を見る',
            'lead'       => '金利、為替、原材料など、別の材料も企業業績への通り道で確認できます。',
            'hub_url'    => home_url('/themes/'),
            'hub_label'  => 'テーマから探すへ',
            'fallback'   => '/category/theme-reading/',
        ],
        'learning' => [
            'categories' => ['投資の読み方', '基礎講座', 'ビギナーガイド'],
            'label'      => 'Reading Guides',
            'title'      => 'ほかの投資の読み方を見る',
            'lead'       => '決算や指標の見方を続けて押さえると、企業分析の記事が読みやすくなります。',
            'hub_url'    => home_url('/learn/'),
            'hub_label'  => '投資の読み方へ',
            'fallback'   => '/category/investment-reading/',
        ],
    ];

    return isset($configs[$type]) ? $configs[$type] : null;
}
}

if (!function_exists('fic_get_category_archive_url_by_names')) {
function fic_get_category_archive_url_by_names($category_names, $fallback_path = '/') {
    $category_names = is_array($category_names) ? $category_names : [$category_names];

    foreach ($category_names as $category_name) {
        $category_id = get_cat_ID($category_name);
        if ($category_id) {
            $category_url = get_category_link($category_id);
            if (!is_wp_error($category_url)) {
                return $category_url;
            }
        }
    }

    return home_url($fallback_path);
}
}

if (!function_exists('fic_get_related_posts_for_category_bridge')) {
function fic_get_related_posts_for_category_bridge($post_id, $category_names, $limit = 3) {
    $category_ids = [];

    foreach ((array) $category_names as $category_name) {
        $category_id = get_cat_ID($category_name);
        if ($category_id) {
            $category_ids[] = $category_id;
        }
    }

    $category_ids = array_values(array_unique(array_filter($category_ids)));

    if (empty($category_ids)) {
        return [];
    }

    return get_posts([
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => $limit,
        'post__not_in'        => [(int) $post_id],
        'category__in'        => $category_ids,
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
    ]);
}
}

if (!function_exists('fic_trim_related_plain_text')) {
function fic_trim_related_plain_text($text, $length = 72) {
    $text = trim(wp_strip_all_tags(html_entity_decode((string) $text, ENT_QUOTES, get_bloginfo('charset'))));
    $text = preg_replace('/\s+/u', ' ', $text);

    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        if (mb_strlen($text, 'UTF-8') > $length) {
            return mb_substr($text, 0, $length, 'UTF-8') . '...';
        }

        return $text;
    }

    return strlen($text) > $length ? substr($text, 0, $length) . '...' : $text;
}
}

if (!function_exists('fic_render_category_related_posts')) {
function fic_render_category_related_posts($type, $post_id) {
    $config = fic_get_category_related_config($type);

    if (!$config) {
        return '';
    }

    $related_posts = fic_get_related_posts_for_category_bridge($post_id, $config['categories'], 3);
    $archive_url = fic_get_category_archive_url_by_names($config['categories'], $config['fallback']);

    ob_start();
    echo '<section class="fic-category-related" aria-label="同じカテゴリの次に読む記事">';
    echo '<div class="fic-category-related-head">';
    echo '<p>' . esc_html($config['label']) . '</p>';
    echo '<h2>' . esc_html($config['title']) . '</h2>';
    echo '<span>' . esc_html($config['lead']) . '</span>';
    echo '</div>';
    if (!empty($related_posts)) {
        echo '<div class="fic-category-related-grid">';
        foreach ($related_posts as $related_post) {
            $excerpt_source = has_excerpt($related_post) ? $related_post->post_excerpt : $related_post->post_content;
            echo '<a class="fic-category-related-card" href="' . esc_url(get_permalink($related_post)) . '"' . fic_bridge_tracking_attr('article_related_card', get_the_title($related_post)) . '>';
            echo '<time datetime="' . esc_attr(get_the_date('c', $related_post)) . '">' . esc_html(get_the_date('Y年n月j日', $related_post)) . '</time>';
            echo '<strong>' . esc_html(get_the_title($related_post)) . '</strong>';
            echo '<span>' . esc_html(fic_trim_related_plain_text($excerpt_source, 74)) . '</span>';
            echo '</a>';
        }
        echo '</div>';
    }
    echo '<div class="fic-category-related-actions">';
    echo '<a href="' . esc_url($archive_url) . '"' . fic_bridge_tracking_attr('article_related_archive', $config['title'] . ': カテゴリ一覧') . '>このカテゴリの記事一覧</a>';
    echo '<a href="' . esc_url($config['hub_url']) . '"' . fic_bridge_tracking_attr('article_related_hub', $config['hub_label']) . '>' . esc_html($config['hub_label']) . '</a>';
    echo '</div>';
    echo '</section>';

    return ob_get_clean();
}
}

if (!function_exists('fic_add_tracking_to_context_paragraph_links')) {
function fic_add_tracking_to_context_paragraph_links($content) {
    if (strpos($content, 'この分析を読む補助線') === false || strpos($content, 'article_context_link') !== false) {
        return $content;
    }

    return preg_replace_callback('/<p\b[^>]*>[^<]*<strong>この分析を読む補助線：<\/strong>[\s\S]*?<\/p>/u', function ($matches) {
        return preg_replace_callback('/<a\s+([^>]*href="[^"]+"[^>]*)>(.*?)<\/a>/u', function ($link_matches) {
            if (strpos($link_matches[1], 'data-fic-area=') !== false) {
                return $link_matches[0];
            }

            $label = wp_strip_all_tags($link_matches[2]);
            return '<a ' . $link_matches[1] . fic_bridge_tracking_attr('article_context_link', $label) . '>' . $link_matches[2] . '</a>';
        }, $matches[0]);
    }, $content);
}
}

if (!function_exists('fic_output_category_archive_guide_script')) {
function fic_output_category_archive_guide_script() {
    if (!is_category() || is_admin()) {
        return;
    }
    ?>
    <script id="fic-category-archive-guide-js">
      (function () {
        var body = document.body;
        if (!body || document.querySelector('.fic-category-archive-guide')) {
          return;
        }

        var configs = [
          {
            test: 'category-99',
            label: 'Company Archive',
            title: '企業分析を目的別に探す',
            body: '企業名が決まっている場合は企業ハブへ、決算前後で確認したい場合は決算予定へ進めます。',
            links: [
              ['企業を探す', '/companies/', 'category_archive_guide', '企業分析: 企業を探す'],
              ['決算予定', '/earnings-schedule/', 'category_archive_guide', '企業分析: 決算予定'],
              ['投資の読み方', '/learn/', 'category_archive_guide', '企業分析: 投資の読み方']
            ]
          },
          {
            test: 'category-theme-analysis',
            label: 'Theme Archive',
            title: 'テーマ分析を入口から選び直す',
            body: '金利、為替、原材料、半導体などの材料から探す場合はテーマハブへ戻ると整理しやすくなります。',
            links: [
              ['テーマから探す', '/themes/', 'category_archive_guide', 'テーマ分析: テーマから探す'],
              ['テーマの読み方', '/category/theme-reading/', 'category_archive_guide', 'テーマ分析: テーマの読み方'],
              ['企業を探す', '/companies/', 'category_archive_guide', 'テーマ分析: 企業を探す']
            ]
          },
          {
            test: 'category-98',
            label: 'Theme Archive',
            title: '業界分析をテーマ別に探し直す',
            body: 'この旧カテゴリの記事はテーマ分析にも整理済みです。金利、為替、原材料、半導体などの入口から探す場合はテーマハブへ進めます。',
            links: [
              ['テーマから探す', '/themes/', 'category_archive_guide', '業界分析: テーマから探す'],
              ['テーマ分析', '/category/theme-analysis/', 'category_archive_guide', '業界分析: テーマ分析'],
              ['テーマの読み方', '/category/theme-reading/', 'category_archive_guide', '業界分析: テーマの読み方']
            ]
          },
          {
            test: 'category-theme-reading',
            label: 'Theme Guides',
            title: 'テーマの読み方から実例へ進む',
            body: 'テーマの基本を押さえたら、実際のテーマ分析や企業分析で業績への波及を確認できます。',
            links: [
              ['テーマから探す', '/themes/', 'category_archive_guide', 'テーマの読み方: テーマから探す'],
              ['テーマ分析', '/category/theme-analysis/', 'category_archive_guide', 'テーマの読み方: テーマ分析'],
              ['企業を探す', '/companies/', 'category_archive_guide', 'テーマの読み方: 企業を探す']
            ]
          },
          {
            test: 'category-investment-reading',
            label: 'Reading Guides',
            title: '投資の読み方を使う場所へ進む',
            body: '決算や指標の見方を確認したら、企業分析や決算予定で実際の数字にあてはめます。',
            links: [
              ['投資の読み方', '/learn/', 'category_archive_guide', '投資の読み方: ハブへ'],
              ['企業を探す', '/companies/', 'category_archive_guide', '投資の読み方: 企業を探す'],
              ['決算予定', '/earnings-schedule/', 'category_archive_guide', '投資の読み方: 決算予定']
            ]
          }
        ];

        var config = configs.find(function (item) {
          return body.classList.contains(item.test);
        });
        if (!config) {
          return;
        }

        var target = document.querySelector('.wrap-post-title') || document.querySelector('.wrap-mini-post-box');
        if (!target || !target.parentNode) {
          return;
        }

        var guide = document.createElement('section');
        guide.className = 'fic-category-archive-guide';
        guide.setAttribute('aria-label', 'カテゴリページの目的別導線');

        var links = config.links.map(function (link) {
          return '<a href="' + link[1] + '" data-fic-area="' + link[2] + '" data-fic-label="' + link[3] + '">' + link[0] + '</a>';
        }).join('');

        guide.innerHTML =
          '<div class="fic-category-archive-guide-copy">' +
            '<p>' + config.label + '</p>' +
            '<strong>' + config.title + '</strong>' +
            '<span>' + config.body + '</span>' +
          '</div>' +
          '<div class="fic-category-archive-guide-links">' + links + '</div>';

        target.parentNode.insertBefore(guide, target);
      }());
    </script>
    <?php
}
}
add_action('wp_footer', 'fic_output_category_archive_guide_script', 98);

if (!function_exists('fic_insert_after_first_h2')) {
function fic_insert_after_first_h2($content, $insert) {
    if (strpos($content, '<h2') === false) {
        return $insert . $content;
    }

    return preg_replace('/<h2\b/i', $insert . "\n\n<h2", $content, 1);
}
}

if (!function_exists('fic_insert_category_bridge_links')) {
function fic_insert_category_bridge_links($content) {
    if (!is_singular('post') || is_admin()) {
        return $content;
    }

    $post_id = get_queried_object_id();
    if (!$post_id) {
        return $content;
    }

    $type = '';
    if (fic_bridge_has_category_name($post_id, ['企業分析'])) {
        $type = 'company';
    } elseif (fic_bridge_has_category_name($post_id, ['テーマ分析', '業界分析', '業種別分析'])) {
        $type = 'theme';
    } elseif (fic_bridge_has_category_name($post_id, ['テーマの読み方'])) {
        $type = 'theme_reading';
    } elseif (fic_bridge_has_category_name($post_id, ['投資の読み方', '基礎講座', 'ビギナーガイド'])) {
        $type = 'learning';
    }

    if ($type === '') {
        return $content;
    }

    $output = $content;

    if (in_array($type, ['company', 'theme'], true) && strpos($output, 'この分析を読む補助線') === false) {
        $output = fic_insert_after_first_h2($output, fic_render_category_context_links($type));
    }

    $output = fic_add_tracking_to_context_paragraph_links($output);

    if (in_array($type, ['company', 'theme'], true) && strpos($output, 'fic-category-bridge') === false) {
        $bridge = fic_render_category_bridge_links($type);
        $summary_pos = strpos($output, 'class="summary-box"');

        if ($summary_pos !== false) {
            $summary_end = strpos($output, '</div>', $summary_pos);
            if ($summary_end !== false) {
                $insert_pos = $summary_end + strlen('</div>');
                $output = substr($output, 0, $insert_pos) . $bridge . substr($output, $insert_pos);
            }
        } else {
            $output = $bridge . $output;
        }
    }

    if (strpos($output, 'fic-category-related') !== false) {
        return $output;
    }

    return $output . fic_render_category_related_posts($type, $post_id);
}
}
add_filter('the_content', 'fic_insert_category_bridge_links', 19);

if (!function_exists('fic_output_category_bridge_css')) {
function fic_output_category_bridge_css() {
    if (!is_singular('post') && !is_category()) {
        return;
    }
    ?>
    <style id="fic-category-bridge-css">
      .fic-category-bridge {
        margin: 26px 0 34px;
        padding: 18px;
        background: #fffdf2;
        border: 1px solid #e8dcc0;
        border-left: 6px solid #ffd500;
      }
      .fic-category-bridge-head {
        display: grid;
        gap: 6px;
        margin-bottom: 14px;
      }
      .fic-category-bridge-head p {
        margin: 0;
        color: #8a5a00;
        font-size: 0.76em;
        font-weight: 900;
        letter-spacing: 0.08em;
      }
      .fic-category-bridge-head strong {
        color: #1f1f23;
        font-size: 1.04em;
        line-height: 1.45;
      }
      .fic-category-bridge-head a {
        width: fit-content;
        color: #1f1f23 !important;
        font-weight: 800;
        border-bottom: 2px solid #ffd500;
        text-decoration: none !important;
      }
      .fic-category-bridge-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
      }
      .fic-category-bridge-grid a {
        display: grid;
        gap: 6px;
        min-width: 0;
        padding: 13px 14px;
        background: #ffffff;
        border: 1px solid #e4e4e7;
        border-top: 4px solid #ffd500;
        color: #1f1f23 !important;
        text-decoration: none !important;
      }
      .fic-category-bridge-grid span {
        width: fit-content;
        padding: 3px 7px;
        background: #1f1f23;
        color: #ffd500;
        font-size: 0.74em;
        font-weight: 850;
        line-height: 1.2;
      }
      .fic-category-bridge-grid strong {
        color: #1f1f23;
        font-size: 0.96em;
        line-height: 1.45;
      }
      .fic-category-related {
        display: grid;
        gap: 16px;
        margin: 38px 0 10px;
        padding: 22px;
        background: #f8fafc;
        border: 1px solid #e1e7ef;
        border-top: 5px solid #ffd500;
        border-radius: 8px;
      }
      .fic-category-related-head {
        display: grid;
        gap: 8px;
      }
      .fic-category-related-head p,
      .fic-category-related-card time {
        margin: 0;
        color: #7a5f00;
        font-size: 0.76em;
        font-weight: 900;
        letter-spacing: 0.06em;
        line-height: 1.25;
        text-transform: uppercase;
      }
      .fic-category-related-head h2 {
        margin: 0 !important;
        padding: 0 !important;
        background: transparent !important;
        color: #1f1f23 !important;
        border: 0 !important;
        font-size: 1.32em !important;
        line-height: 1.35 !important;
      }
      .fic-category-related-head span {
        color: #5b6472;
        line-height: 1.7;
      }
      .fic-category-related-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
      }
      .fic-category-related-card {
        display: grid;
        gap: 8px;
        min-width: 0;
        padding: 16px;
        background: #ffffff;
        color: #1f1f23 !important;
        border: 1px solid #e4e4e7;
        border-top: 4px solid #1f1f23;
        border-radius: 7px;
        text-decoration: none !important;
        box-shadow: 0 8px 18px rgba(31, 31, 35, 0.04);
      }
      .fic-category-related-card:hover {
        background: #fffdf2;
        border-top-color: #ffd500;
      }
      .fic-category-related-card strong {
        color: #1f1f23;
        font-size: 0.98em;
        line-height: 1.5;
      }
      .fic-category-related-card span {
        color: #5b6472;
        font-size: 0.9em;
        line-height: 1.6;
      }
      .fic-category-related-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
      }
      .fic-category-related-actions a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        padding: 9px 13px;
        background: #1f1f23;
        color: #ffffff !important;
        border: 1px solid #1f1f23;
        border-radius: 999px;
        font-weight: 850;
        line-height: 1.25;
        text-decoration: none !important;
      }
      .fic-category-related-actions a:first-child {
        background: #ffd500;
        color: #1f1f23 !important;
        border-color: #d4b900;
      }
      .fic-category-archive-guide {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 18px;
        align-items: center;
        margin: 0 0 16px;
        padding: 18px;
        background: #ffffff;
        border: 1px solid #e4e4e7;
        border-left: 6px solid #ffd500;
        border-radius: 8px;
        box-shadow: 0 10px 22px rgba(31, 31, 35, 0.05);
      }
      .fic-category-archive-guide-copy {
        display: grid;
        gap: 6px;
        min-width: 0;
      }
      .fic-category-archive-guide-copy p {
        margin: 0;
        color: #7a5f00;
        font-size: 0.76rem;
        font-weight: 900;
        letter-spacing: 0.06em;
        line-height: 1.25;
        text-transform: uppercase;
      }
      .fic-category-archive-guide-copy strong {
        color: #1f1f23;
        font-size: 1.08rem;
        line-height: 1.4;
      }
      .fic-category-archive-guide-copy span {
        color: #5b6472;
        line-height: 1.65;
      }
      .fic-category-archive-guide-links {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: flex-end;
      }
      .fic-category-archive-guide-links a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        padding: 8px 12px;
        background: #1f1f23;
        color: #ffffff !important;
        border: 1px solid #1f1f23;
        border-radius: 999px;
        font-size: 0.88rem;
        font-weight: 850;
        line-height: 1.25;
        text-decoration: none !important;
      }
      .fic-category-archive-guide-links a:first-child {
        background: #ffd500;
        color: #1f1f23 !important;
        border-color: #d4b900;
      }
      @media (max-width: 760px) {
        .fic-category-bridge {
          margin: 22px 0 28px;
          padding: 16px;
        }
        .fic-category-bridge-grid,
        .fic-category-related-grid {
          grid-template-columns: 1fr;
        }
        .fic-category-related {
          margin-top: 30px;
          padding: 18px;
        }
        .fic-category-archive-guide {
          grid-template-columns: 1fr;
          padding: 16px;
        }
        .fic-category-archive-guide-links {
          justify-content: flex-start;
        }
      }
    </style>
    <?php
}
}
add_action('wp_head', 'fic_output_category_bridge_css', 99);
