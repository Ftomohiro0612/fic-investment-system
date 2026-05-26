/**
 * FIC purpose hub shortcodes.
 *
 * Shortcodes: [fic_company_hub], [fic_theme_hub], [fic_learning_hub]
 *
 * Code Snippets-ready bundle for the three fixed-page hub shortcodes.
 */

if (!function_exists('fic_get_category_url_by_name')) {
function fic_get_category_url_by_name($category_name, $fallback_path = '/') {
    $category_id = get_cat_ID($category_name);

    if ($category_id) {
        $category_url = get_category_link($category_id);

        if (!is_wp_error($category_url)) {
            return $category_url;
        }
    }

    return home_url($fallback_path);
}
}

if (!function_exists('fic_get_latest_posts_by_category_name')) {
function fic_get_latest_posts_by_category_name($category_name, $limit = 3) {
    $category_names = is_array($category_name) ? $category_name : [$category_name];
    $category_ids = [];

    foreach ($category_names as $name) {
        $category_id = get_cat_ID($name);
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
        'category__in'        => $category_ids,
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
    ]);
}
}

if (!function_exists('fic_get_category_post_count_by_name')) {
function fic_get_category_post_count_by_name($category_name) {
    $category_names = is_array($category_name) ? $category_name : [$category_name];
    $category_ids = [];

    foreach ($category_names as $name) {
        $category_id = get_cat_ID($name);
        if ($category_id) {
            $category_ids[] = $category_id;
        }
    }

    $category_ids = array_values(array_unique(array_filter($category_ids)));

    if (empty($category_ids)) {
        return 0;
    }

    $count_query = new WP_Query([
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => 1,
        'fields'              => 'ids',
        'category__in'        => $category_ids,
        'ignore_sticky_posts' => true,
        'no_found_rows'       => false,
    ]);
    $count = (int) $count_query->found_posts;
    wp_reset_postdata();

    return $count;
}
}

if (!function_exists('fic_trim_plain_text')) {
function fic_trim_plain_text($text, $length = 86) {
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

if (!function_exists('fic_get_category_url_by_names')) {
function fic_get_category_url_by_names($category_names, $fallback_path = '/') {
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

if (!function_exists('fic_get_post_url_by_slug')) {
function fic_get_post_url_by_slug($slug, $fallback_path = '/') {
    $post = get_page_by_path($slug, OBJECT, 'post');

    if ($post && 'publish' === get_post_status($post)) {
        return get_permalink($post);
    }

    return home_url($fallback_path);
}
}

if (!function_exists('fic_tracking_attr')) {
function fic_tracking_attr($area, $label) {
    return ' data-fic-area="' . esc_attr($area) . '" data-fic-label="' . esc_attr($label) . '"';
}
}


if (!function_exists('fic_render_hub_nav')) {
function fic_render_hub_nav($active = '') {
    $items = [
        ['key' => 'company', 'label' => '企業を探す', 'body' => '企業名・証券コードから', 'url' => home_url('/companies/')],
        ['key' => 'theme', 'label' => 'テーマから探す', 'body' => 'ニュース材料から', 'url' => home_url('/themes/')],
        ['key' => 'learning', 'label' => '投資の読み方', 'body' => '決算と指標の基礎', 'url' => home_url('/learn/')],
    ];

    ob_start();

    echo '<nav class="fic-hub-nav" aria-label="目的別ページナビゲーション">';
    foreach ($items as $item) {
        $classes = 'fic-hub-nav-item';
        if ($active === $item['key']) {
            $classes .= ' is-active';
        }

        $aria_current = $active === $item['key'] ? ' aria-current="page"' : '';

        echo '<a class="' . esc_attr($classes) . '" href="' . esc_url($item['url']) . '"' . $aria_current . fic_tracking_attr('hub_nav', $item['label']) . '>';
        if ($active === $item['key']) {
            echo '<em>現在地</em>';
        }
        echo '<strong>' . esc_html($item['label']) . '</strong>';
        echo '<span>' . esc_html($item['body']) . '</span>';
        echo '</a>';
    }
    echo '</nav>';

    return ob_get_clean();
}
}

if (!function_exists('fic_render_company_hub')) {
function fic_render_company_hub() {
    $company_count = fic_get_category_post_count_by_name('企業分析');
    $latest_posts = fic_get_latest_posts_by_category_name('企業分析', 12);
    $company_search_chips = [
        ['label' => 'キオクシア', 'query' => 'キオクシア 285A', 'slug' => 'kioxia-holdings-285a-analysis'],
        ['label' => 'ニトリ', 'query' => 'ニトリ 9843', 'slug' => 'nitori-9843-analysis'],
        ['label' => '三菱UFJ', 'query' => '三菱UFJ 8306', 'slug' => 'mitsubishi-ufj-8306-analysis'],
        ['label' => 'みずほ', 'query' => 'みずほ 8411', 'slug' => 'mizuho-fg-8411-analysis'],
        ['label' => 'リクルート', 'query' => 'リクルート 6098', 'slug' => 'recruit-holdings-6098-analysis'],
        ['label' => 'ENEOS', 'query' => 'ENEOS 5020', 'slug' => 'eneos-holdings-5020-analysis'],
    ];
    $hub_cards = [
        [
            'label' => 'Search',
            'title' => '企業名・証券コードで探す',
            'body'  => '気になる企業がある場合は、まず検索から入れます。',
        ],
        [
            'label' => 'Latest',
            'title' => '最新の企業分析を見る',
            'body'  => '直近で更新された分析から、足元の論点を確認します。',
        ],
        [
            'label' => 'Earnings',
            'title' => '決算前後に確認する',
            'body'  => '売上、利益率、会社予想、次のKPIを決算前後で見ます。',
        ],
    ];
    $featured_company_articles = [
        ['label' => '小売', 'title' => 'ニトリの企業分析', 'body' => '客数、単価、為替、原価から小売の利益率を確認する。', 'slug' => 'nitori-9843-analysis', 'query' => 'ニトリ 9843'],
        ['label' => '金融', 'title' => '三菱UFJの企業分析', 'body' => '金利、与信費用、手数料、資本政策が業績にどう効くかを見る。', 'slug' => 'mitsubishi-ufj-8306-analysis', 'query' => '三菱UFJ 8306'],
        ['label' => '半導体', 'title' => 'キオクシアの企業分析', 'body' => 'メモリ市況、設備投資、AI需要の波及を確認する。', 'slug' => 'kioxia-holdings-285a-analysis', 'query' => 'キオクシア 285A'],
        ['label' => 'エネルギー', 'title' => 'ENEOSの企業分析', 'body' => '資源価格、精製マージン、在庫評価、投資余力を見る。', 'slug' => 'eneos-holdings-5020-analysis', 'query' => 'ENEOS 5020'],
        ['label' => '自動車', 'title' => 'ホンダの企業分析', 'body' => '販売台数、為替、原価、電動化投資の変化を追う。', 'slug' => 'honda-7267-analysis', 'query' => 'ホンダ 7267'],
        ['label' => '人材', 'title' => 'リクルートの企業分析', 'body' => '求人需要、広告、人件費、海外事業の変化を確認する。', 'slug' => 'recruit-holdings-6098-analysis', 'query' => 'リクルート 6098'],
    ];
    $check_items = [
        ['label' => '売上', 'body' => '数量、単価、為替、セグメントのどれで動いたか'],
        ['label' => '利益率', 'body' => '価格転嫁、原価、人件費、販管費の変化'],
        ['label' => '財務', 'body' => 'キャッシュフロー、自己資本比率、投資余力'],
        ['label' => '次のKPI', 'body' => '受注、在庫、稼働率、月次、会社予想'],
    ];
    $company_routes = [
        [
            'label' => 'Finance',
            'title' => '銀行・金融',
            'body'  => '金利、与信費用、手数料、資本政策から業績を見る。',
            'links' => [
                ['label' => '三菱UFJ', 'slug' => 'mitsubishi-ufj-8306-analysis', 'query' => '三菱UFJ 8306'],
                ['label' => 'みずほFG', 'slug' => 'mizuho-fg-8411-analysis', 'query' => 'みずほ 8411'],
            ],
        ],
        [
            'label' => 'Cost',
            'title' => '資源・エネルギー・素材',
            'body'  => '資源価格、原材料、為替、価格転嫁で利益率がどう動くかを見る。',
            'links' => [
                ['label' => 'ENEOS', 'slug' => 'eneos-holdings-5020-analysis', 'query' => 'ENEOS 5020'],
                ['label' => '住友金属鉱山', 'slug' => 'sumitomo-metal-mining-5713-analysis', 'query' => '住友金属鉱山 5713'],
                ['label' => 'JFE', 'slug' => 'jfe-holdings-5411-analysis', 'query' => 'JFE 5411'],
            ],
        ],
        [
            'label' => 'Demand',
            'title' => '小売・消費・人材',
            'body'  => '客数、単価、人件費、広告費、採用需要の変化を確認する。',
            'links' => [
                ['label' => 'ニトリ', 'slug' => 'nitori-9843-analysis', 'query' => 'ニトリ 9843'],
                ['label' => 'リクルート', 'slug' => 'recruit-holdings-6098-analysis', 'query' => 'リクルート 6098'],
                ['label' => 'メルカリ', 'slug' => 'mercari-4385-analysis', 'query' => 'メルカリ 4385'],
            ],
        ],
        [
            'label' => 'Investment',
            'title' => '半導体・製造装置・設備投資',
            'body'  => '受注、在庫、設備投資、AI需要の波及を追う。',
            'links' => [
                ['label' => 'キオクシア', 'slug' => 'kioxia-holdings-285a-analysis', 'query' => 'キオクシア 285A'],
                ['label' => 'SCREEN', 'slug' => 'screen-holdings-7735-analysis', 'query' => 'SCREEN 7735'],
                ['label' => 'ダイキン', 'slug' => 'daikin-6367-analysis', 'query' => 'ダイキン 6367'],
            ],
        ],
        [
            'label' => 'Mobility',
            'title' => '自動車・重工',
            'body'  => '販売台数、為替、原価、受注残、防衛・航空宇宙の変化を見る。',
            'links' => [
                ['label' => 'ホンダ', 'slug' => 'honda-7267-analysis', 'query' => 'ホンダ 7267'],
                ['label' => '川崎重工', 'slug' => 'kawasaki-heavy-industries-7012-analysis', 'query' => '川崎重工 7012'],
            ],
        ],
    ];

    ob_start();

    echo '<div class="fic-home fic-company-hub">';
    echo '<section class="fic-hub-hero" aria-labelledby="fic-company-hub-title">';
    echo '<a class="fic-hub-home-link" href="' . esc_url(home_url('/')) . '"' . fic_tracking_attr('company_hub_hero', 'トップページへ') . '>トップページへ</a>';
    echo '<p class="fic-home-section-label">Company Hub</p>';
    echo '<h1 id="fic-company-hub-title">企業を探す</h1>';
    echo '<p>企業名、証券コード、決算予定、最新分析から、個別企業の業績が動く理由を探します。</p>';
    echo '<div class="fic-hub-hero-meta">';
    if ($company_count) {
        echo '<span><strong>' . esc_html(number_format_i18n((int) $company_count)) . '</strong>本の企業分析</span>';
    }
    echo '<a href="' . esc_url(fic_get_category_url_by_name('企業分析', '/category/')) . '"' . fic_tracking_attr('company_hub_hero', '企業分析一覧') . '>企業分析一覧</a>';
    echo '</div>';
    echo '<form class="fic-home-search fic-hub-search" role="search" method="get" action="' . esc_url(home_url('/')) . '">';
    echo '<label for="fic-company-hub-search">企業名・証券コードを検索</label>';
    echo '<div class="fic-home-search-row">';
    echo '<input id="fic-company-hub-search" type="search" name="s" placeholder="例：ニトリ、9843、三菱UFJ" value="' . esc_attr(get_search_query()) . '">';
    echo '<button type="submit">検索</button>';
    echo '</div>';
    echo '<div class="fic-home-search-chips" aria-label="企業検索クイックリンク">';
    foreach ($company_search_chips as $chip) {
        $chip_url = !empty($chip['slug'])
            ? fic_get_post_url_by_slug($chip['slug'], '/?s=' . rawurlencode($chip['query']))
            : home_url('/?s=' . rawurlencode($chip['query']));
        echo '<a href="' . esc_url($chip_url) . '"' . fic_tracking_attr('company_hub_search_chip', $chip['label']) . '>' . esc_html($chip['label']) . '</a>';
    }
    echo '</div>';
    echo '</form>';
    echo '</section>';
    echo fic_render_hub_nav('company');

    echo '<section class="fic-home-section fic-hub-guide" aria-labelledby="fic-company-hub-guide-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Start</p>';
    echo '<h2 id="fic-company-hub-guide-title">企業分析の探し方</h2>';
    echo '<p>検索、最新分析、決算予定の3つから入れます。</p>';
    echo '</div>';
    echo '<div class="fic-hub-card-grid">';
    foreach ($hub_cards as $card) {
        echo '<div class="fic-hub-card">';
        echo '<span>' . esc_html($card['label']) . '</span>';
        echo '<strong>' . esc_html($card['title']) . '</strong>';
        echo '<p>' . esc_html($card['body']) . '</p>';
        echo '</div>';
    }
    echo '</div>';
    echo '</section>';

    echo '<section class="fic-home-section fic-hub-guide" aria-labelledby="fic-company-featured-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Featured Company Analysis</p>';
    echo '<h2 id="fic-company-featured-title">まず読む代表企業</h2>';
    echo '<p>企業名がまだ決まっていないときは、代表的な企業分析から業績の見方をつかめます。</p>';
    echo '</div>';
    echo '<div class="fic-hub-card-grid">';
    foreach ($featured_company_articles as $item) {
        $article_url = fic_get_post_url_by_slug($item['slug'], '/?s=' . rawurlencode($item['query']));
        echo '<a class="fic-hub-card" href="' . esc_url($article_url) . '"' . fic_tracking_attr('company_hub_featured', $item['title']) . '>';
        echo '<span>' . esc_html($item['label']) . '</span>';
        echo '<strong>' . esc_html($item['title']) . '</strong>';
        echo '<p>' . esc_html($item['body']) . '</p>';
        echo '</a>';
    }
    echo '</div>';
    echo '</section>';

    echo '<section class="fic-home-section fic-hub-guide" aria-labelledby="fic-company-routes-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Company Routes</p>';
    echo '<h2 id="fic-company-routes-title">業種・材料別に企業を探す</h2>';
    echo '<p>企業名が決まっていないときは、金利、原材料、消費、設備投資、為替などの業績ドライバーから代表企業へ進めます。</p>';
    echo '</div>';
    echo '<div class="fic-hub-card-grid fic-company-route-grid">';
    foreach ($company_routes as $route) {
        echo '<div class="fic-hub-card fic-company-route-card">';
        echo '<span>' . esc_html($route['label']) . '</span>';
        echo '<strong>' . esc_html($route['title']) . '</strong>';
        echo '<p>' . esc_html($route['body']) . '</p>';
        echo '<div class="fic-company-route-links">';
        foreach ($route['links'] as $link) {
            $company_url = fic_get_post_url_by_slug($link['slug'], '/?s=' . rawurlencode($link['query']));
            echo '<a href="' . esc_url($company_url) . '"' . fic_tracking_attr('company_hub_route', $route['title'] . ': ' . $link['label']) . '>' . esc_html($link['label']) . '</a>';
        }
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '</section>';

    echo '<section class="fic-home-section fic-hub-checks" aria-labelledby="fic-company-hub-checks-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Checklist</p>';
    echo '<h2 id="fic-company-hub-checks-title">企業分析で見るポイント</h2>';
    echo '<p>個別企業を見るときは、株価より先に業績の変化点を確認します。</p>';
    echo '</div>';
    echo '<div class="fic-home-earnings-checks">';
    foreach ($check_items as $item) {
        echo '<div class="fic-home-earnings-check">';
        echo '<span>' . esc_html($item['label']) . '</span>';
        echo '<strong>' . esc_html($item['body']) . '</strong>';
        echo '</div>';
    }
    echo '</div>';
    echo '</section>';

    echo '<section class="fic-home-section fic-home-latest" aria-labelledby="fic-company-hub-latest-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Latest Company Analysis</p>';
    echo '<h2 id="fic-company-hub-latest-title">最新の企業分析</h2>';
    echo '<p>直近で公開・更新された企業分析です。</p>';
    echo '</div>';
    if (!empty($latest_posts)) {
        echo '<div class="fic-hub-latest-grid">';
        foreach ($latest_posts as $post) {
            $excerpt_source = has_excerpt($post) ? $post->post_excerpt : $post->post_content;
            echo '<a class="fic-home-latest-card fic-hub-latest-card" href="' . esc_url(get_permalink($post)) . '"' . fic_tracking_attr('company_hub_latest', get_the_title($post)) . '>';
            echo '<time datetime="' . esc_attr(get_the_date('c', $post)) . '">' . esc_html(get_the_date('Y年n月j日', $post)) . '</time>';
            echo '<strong>' . esc_html(get_the_title($post)) . '</strong>';
            echo '<span>' . esc_html(fic_trim_plain_text($excerpt_source, 92)) . '</span>';
            echo '</a>';
        }
        echo '</div>';
    } else {
        echo '<p class="fic-home-latest-empty">企業分析の記事を準備しています。</p>';
    }
    echo '</section>';

    echo '<section class="fic-home-section fic-home-trust fic-hub-next" aria-labelledby="fic-company-hub-next-title">';
    echo '<div>';
    echo '<p class="fic-home-section-label">Next</p>';
    echo '<h2 id="fic-company-hub-next-title">決算予定とあわせて確認する</h2>';
    echo '<p>決算発表前後は、企業分析と決算スケジュールをあわせて見ると、確認すべきKPIを先回りできます。</p>';
    echo '</div>';
    echo '<div class="fic-home-trust-links">';
    echo '<a href="' . esc_url(home_url('/earnings-schedule/')) . '"' . fic_tracking_attr('company_hub_next', '決算スケジュール') . '>決算スケジュール</a>';
    echo '<a href="' . esc_url(home_url('/themes/')) . '"' . fic_tracking_attr('company_hub_next', 'テーマから探す') . '>テーマから探す</a>';
    echo '<a href="' . esc_url(home_url('/')) . '"' . fic_tracking_attr('company_hub_next', 'トップページ') . '>トップページ</a>';
    echo '</div>';
    echo '</section>';
    echo '</div>';

    return ob_get_clean();
}
}

if (!function_exists('fic_company_hub_shortcode')) {
function fic_company_hub_shortcode() {
    return fic_render_company_hub();
}
}
add_shortcode('fic_company_hub', 'fic_company_hub_shortcode');

if (!function_exists('fic_render_theme_hub')) {
function fic_render_theme_hub() {
    $theme_analysis_categories = ['テーマ分析', '業界分析'];
    $theme_reading_categories = ['テーマの読み方'];
    $theme_count = fic_get_category_post_count_by_name(array_merge($theme_analysis_categories, $theme_reading_categories));
    $latest_posts = fic_get_latest_posts_by_category_name($theme_analysis_categories, 6);
    $theme_search_chips = [
        ['label' => '金利', 'slug' => 'interest-rate-impact-stocks'],
        ['label' => '為替', 'slug' => 'fx-impact-company-earnings'],
        ['label' => '原材料', 'slug' => 'raw-material-cost-pass-through'],
        ['label' => '半導体', 'slug' => 'semiconductor-investment-supply-chain'],
        ['label' => '政策・補助金', 'slug' => 'policy-subsidy-investment-theme'],
        ['label' => 'エネルギー', 'slug' => 'energy-transition-power-investment'],
        ['label' => '物流改革', 'slug' => 'logistics-reform-2024-problem'],
        ['label' => 'インバウンド', 'slug' => 'inbound-demand-company-impact'],
    ];
    $theme_items = [
        ['label' => 'Rates', 'title' => '金利', 'body' => '銀行、不動産、リース、成長株への波及を見る。', 'slug' => 'interest-rate-impact-stocks', 'query' => '金利'],
        ['label' => 'FX', 'title' => '為替', 'body' => '輸出、輸入、海外売上、原価への影響を見る。', 'slug' => 'fx-impact-company-earnings', 'query' => '為替'],
        ['label' => 'Cost', 'title' => '原材料', 'body' => '価格転嫁、粗利率、在庫評価への影響を見る。', 'slug' => 'raw-material-cost-pass-through', 'query' => '原材料'],
        ['label' => 'AI/Semi', 'title' => '半導体', 'body' => '設備投資、部材、電力、データセンターへ広げる。', 'slug' => 'semiconductor-investment-supply-chain', 'query' => '半導体 AI'],
        ['label' => 'Policy', 'title' => '政策・補助金', 'body' => '予算、採択、受注、売上計上まで段階で見る。', 'slug' => 'policy-subsidy-investment-theme', 'query' => '政策 補助金'],
        ['label' => 'Energy', 'title' => 'エネルギー', 'body' => '電力需要、送配電、蓄電、燃料費の波及を見る。', 'slug' => 'energy-transition-power-investment', 'query' => 'エネルギー 電力'],
        ['label' => 'Logistics', 'title' => '物流改革', 'body' => '物流費、運賃、省力化、価格転嫁の変化を見る。', 'slug' => 'logistics-reform-2024-problem', 'query' => '物流 改革'],
        ['label' => 'Demand', 'title' => '消費・インバウンド', 'body' => '客数、単価、訪日客、値上げ耐性を確認する。', 'slug' => 'inbound-demand-company-impact', 'query' => 'インバウンド 消費'],
    ];
    $featured_theme_articles = [
        ['label' => '金利', 'title' => '金利上昇で見る企業影響', 'body' => '銀行、不動産、リース、成長株への波及を確認する。', 'slug' => 'interest-rate-impact-stocks'],
        ['label' => '為替', 'title' => '為替で業績が動く企業の見方', 'body' => '円安・円高が売上と利益率にどう効くかを読む。', 'slug' => 'fx-impact-company-earnings'],
        ['label' => '原材料', 'title' => '原材料高と価格転嫁', 'body' => 'コスト増を価格、数量、粗利率へ分解する。', 'slug' => 'raw-material-cost-pass-through'],
        ['label' => '半導体', 'title' => '半導体投資の波及先', 'body' => '装置、部材、電力、建設への広がりを見る。', 'slug' => 'semiconductor-investment-supply-chain'],
        ['label' => '政策', 'title' => '政策・補助金テーマの読み方', 'body' => '予算、採択、受注、売上計上まで段階で読む。', 'slug' => 'policy-subsidy-investment-theme'],
        ['label' => 'エネルギー', 'title' => 'エネルギー転換と電力投資', 'body' => '電力需要、送配電、蓄電、燃料費の波及を見る。', 'slug' => 'energy-transition-power-investment'],
    ];
    $flow_items = [
        ['label' => '1', 'body' => 'ニュースやマクロ材料を確認する'],
        ['label' => '2', 'body' => '影響を受ける業界と企業を探す'],
        ['label' => '3', 'body' => '次の決算で見るKPIへ落とす'],
    ];
    $theme_clusters = [
        [
            'label' => 'Macro',
            'title' => '金利・為替',
            'body'  => '政策金利、為替前提、海外売上、輸入原価から企業業績への影響を見る。',
            'links' => [
                ['label' => '金利', 'slug' => 'interest-rate-impact-stocks'],
                ['label' => '為替', 'slug' => 'fx-impact-company-earnings'],
            ],
        ],
        [
            'label' => 'Cost',
            'title' => '原材料・エネルギー・物流',
            'body'  => 'コスト増が価格転嫁、粗利率、工期、運賃、省力化投資へどう広がるかを見る。',
            'links' => [
                ['label' => '原材料', 'slug' => 'raw-material-cost-pass-through'],
                ['label' => 'エネルギー', 'slug' => 'energy-transition-power-investment'],
                ['label' => '物流改革', 'slug' => 'logistics-reform-2024-problem'],
            ],
        ],
        [
            'label' => 'Investment',
            'title' => '半導体・政策・防衛',
            'body'  => '大型投資、補助金、受注、サプライチェーンのどこで業績化するかを見る。',
            'links' => [
                ['label' => '半導体', 'slug' => 'semiconductor-investment-supply-chain'],
                ['label' => '政策・補助金', 'slug' => 'policy-subsidy-investment-theme'],
                ['label' => '防衛', 'slug' => 'defense-security-investment-theme'],
            ],
        ],
        [
            'label' => 'Demand',
            'title' => '消費・人手不足・インバウンド',
            'body'  => '客数、単価、値上げ耐性、省人化投資、訪日需要への波及を見る。',
            'links' => [
                ['label' => '値上げ', 'slug' => 'price-hike-consumer-demand'],
                ['label' => '人手不足', 'slug' => 'labor-shortage-automation-investment'],
                ['label' => 'インバウンド', 'slug' => 'inbound-demand-company-impact'],
            ],
        ],
    ];
    $theme_reading_items = [
        ['label' => 'Rates', 'title' => '金利上昇で見る企業影響', 'body' => '銀行、不動産、リース、成長株への波及を読む。', 'slug' => 'interest-rate-impact-stocks'],
        ['label' => 'FX', 'title' => '為替で業績が動く企業の見方', 'body' => '円安・円高が売上と利益率にどう効くかを読む。', 'slug' => 'fx-impact-company-earnings'],
        ['label' => 'Cost', 'title' => '原材料高と価格転嫁', 'body' => 'コスト増を価格・数量・粗利率へ分解する。', 'slug' => 'raw-material-cost-pass-through'],
        ['label' => 'Semi', 'title' => '半導体投資の波及先', 'body' => '装置、部材、電力、建設への広がりを見る。', 'slug' => 'semiconductor-investment-supply-chain'],
        ['label' => 'Policy', 'title' => '政策・補助金テーマの読み方', 'body' => '予算、採択、受注、売上計上まで段階で読む。', 'slug' => 'policy-subsidy-investment-theme'],
        ['label' => 'Logistics', 'title' => '物流改革と2024年問題', 'body' => '物流費、運賃、省力化、価格転嫁を確認する。', 'slug' => 'logistics-reform-2024-problem'],
        ['label' => 'Energy', 'title' => 'エネルギー転換と電力投資', 'body' => '電力需要、送配電、蓄電、燃料費の波及を読む。', 'slug' => 'energy-transition-power-investment'],
        ['label' => 'Labor', 'title' => '人手不足と省人化投資', 'body' => '人件費、採用難、自動化投資、価格転嫁を確認する。', 'slug' => 'labor-shortage-automation-investment'],
        ['label' => 'Consumer', 'title' => '値上げと消費需要', 'body' => '客数、単価、粗利率、節約志向の変化を分けて読む。', 'slug' => 'price-hike-consumer-demand'],
        ['label' => 'Inbound', 'title' => 'インバウンド需要の企業影響', 'body' => '訪日客数、単価、地域差、関連企業への波及を見る。', 'slug' => 'inbound-demand-company-impact'],
        ['label' => 'Defense', 'title' => '防衛・安全保障テーマ', 'body' => '防衛予算、受注、サプライチェーン、売上計上の時間軸を読む。', 'slug' => 'defense-security-investment-theme'],
    ];

    ob_start();

    echo '<div class="fic-home fic-theme-hub">';
    echo '<section class="fic-hub-hero" aria-labelledby="fic-theme-hub-title">';
    echo '<a class="fic-hub-home-link" href="' . esc_url(home_url('/')) . '"' . fic_tracking_attr('theme_hub_hero', 'トップページへ') . '>トップページへ</a>';
    echo '<p class="fic-home-section-label">Theme Hub</p>';
    echo '<h1 id="fic-theme-hub-title">テーマから探す</h1>';
    echo '<p>金利、為替、原材料、AI、政策などの変化が、どの業界・企業に波及するかを探します。</p>';
    echo '<div class="fic-hub-hero-meta">';
    if ($theme_count) {
        echo '<span><strong>' . esc_html(number_format_i18n((int) $theme_count)) . '</strong>本のテーマ記事</span>';
    }
    echo '<a href="' . esc_url(fic_get_category_url_by_names($theme_analysis_categories, '/category/')) . '"' . fic_tracking_attr('theme_hub_hero', 'テーマ分析一覧') . '>テーマ分析一覧</a>';
    echo '</div>';
    echo '<form class="fic-home-search fic-hub-search" role="search" method="get" action="' . esc_url(home_url('/')) . '">';
    echo '<label for="fic-theme-hub-search">テーマ・ニュース材料を検索</label>';
    echo '<div class="fic-home-search-row">';
    echo '<input id="fic-theme-hub-search" type="search" name="s" placeholder="例：金利、為替、半導体、原材料" value="' . esc_attr(get_search_query()) . '">';
    echo '<button type="submit">検索</button>';
    echo '</div>';
    echo '<div class="fic-home-search-chips" aria-label="テーマの読み方クイックリンク">';
    foreach ($theme_search_chips as $chip) {
        echo '<a href="' . esc_url(fic_get_post_url_by_slug($chip['slug'], '/' . $chip['slug'] . '/')) . '"' . fic_tracking_attr('theme_hub_search_chip', $chip['label']) . '>' . esc_html($chip['label']) . '</a>';
    }
    echo '</div>';
    echo '</form>';
    echo '</section>';
    echo fic_render_hub_nav('theme');

    echo '<section class="fic-home-section fic-home-triggers" aria-labelledby="fic-theme-hub-trigger-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Triggers</p>';
    echo '<h2 id="fic-theme-hub-trigger-title">材料別に探す</h2>';
    echo '<p>ニュースを見たら、まず業績への通り道を確認します。</p>';
    echo '</div>';
    echo '<div class="fic-home-trigger-grid fic-theme-trigger-grid">';
    foreach ($theme_items as $item) {
        $item_url = !empty($item['slug'])
            ? fic_get_post_url_by_slug($item['slug'], '/?s=' . rawurlencode($item['query']))
            : home_url('/?s=' . rawurlencode($item['query']));
        echo '<a class="fic-home-trigger-card" href="' . esc_url($item_url) . '"' . fic_tracking_attr('theme_hub_trigger', $item['title']) . '>';
        echo '<span>' . esc_html($item['label']) . '</span>';
        echo '<strong>' . esc_html($item['title']) . '</strong>';
        echo '<em>' . esc_html($item['body']) . '</em>';
        echo '</a>';
    }
    echo '</div>';
    echo '</section>';

    echo '<section class="fic-home-section fic-hub-guide" aria-labelledby="fic-theme-featured-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Featured Theme Guides</p>';
    echo '<h2 id="fic-theme-featured-title">まず読む代表テーマ</h2>';
    echo '<p>ニュース材料から入るときに、最初に押さえたい代表テーマです。</p>';
    echo '</div>';
    echo '<div class="fic-hub-card-grid">';
    foreach ($featured_theme_articles as $item) {
        echo '<a class="fic-hub-card" href="' . esc_url(fic_get_post_url_by_slug($item['slug'], '/' . $item['slug'] . '/')) . '"' . fic_tracking_attr('theme_hub_featured', $item['title']) . '>';
        echo '<span>' . esc_html($item['label']) . '</span>';
        echo '<strong>' . esc_html($item['title']) . '</strong>';
        echo '<p>' . esc_html($item['body']) . '</p>';
        echo '</a>';
    }
    echo '</div>';
    echo '</section>';

    echo '<section class="fic-home-section fic-hub-guide" aria-labelledby="fic-theme-cluster-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Theme Routes</p>';
    echo '<h2 id="fic-theme-cluster-title">テーマ別の深掘り入口</h2>';
    echo '<p>単体テーマだけでなく、近い材料をまとめて確認できます。</p>';
    echo '</div>';
    echo '<div class="fic-hub-card-grid">';
    foreach ($theme_clusters as $cluster) {
        echo '<div class="fic-hub-card">';
        echo '<span>' . esc_html($cluster['label']) . '</span>';
        echo '<strong>' . esc_html($cluster['title']) . '</strong>';
        echo '<p>' . esc_html($cluster['body']) . '</p>';
        echo '<div class="fic-home-search-chips" aria-label="' . esc_attr($cluster['title']) . 'の関連テーマ">';
        foreach ($cluster['links'] as $link) {
            echo '<a href="' . esc_url(fic_get_post_url_by_slug($link['slug'], '/' . $link['slug'] . '/')) . '"' . fic_tracking_attr('theme_hub_cluster', $cluster['title'] . ': ' . $link['label']) . '>' . esc_html($link['label']) . '</a>';
        }
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '</section>';

    echo '<section class="fic-home-section fic-home-route" aria-labelledby="fic-theme-hub-flow-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Flow</p>';
    echo '<h2 id="fic-theme-hub-flow-title">テーマ分析の読み方</h2>';
    echo '<p>材料を見つけたら、企業業績に届くまでを追います。</p>';
    echo '</div>';
    echo '<div class="fic-home-route-grid">';
    foreach ($flow_items as $item) {
        echo '<div class="fic-home-route-step">';
        echo '<span>' . esc_html($item['label']) . '</span>';
        echo '<strong>' . esc_html($item['body']) . '</strong>';
        echo '</div>';
    }
    echo '</div>';
    echo '</section>';

    echo '<section class="fic-home-section fic-hub-guide" aria-labelledby="fic-theme-reading-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Theme Guides</p>';
    echo '<h2 id="fic-theme-reading-title">テーマの読み方</h2>';
    echo '<p>ニュースを読む前後に確認したい、常設のテーマ解説です。</p>';
    echo '</div>';
    echo '<div class="fic-hub-card-grid">';
    foreach ($theme_reading_items as $item) {
        echo '<a class="fic-hub-card" href="' . esc_url(fic_get_post_url_by_slug($item['slug'], '/' . $item['slug'] . '/')) . '"' . fic_tracking_attr('theme_hub_reading', $item['title']) . '>';
        echo '<span>' . esc_html($item['label']) . '</span>';
        echo '<strong>' . esc_html($item['title']) . '</strong>';
        echo '<p>' . esc_html($item['body']) . '</p>';
        echo '</a>';
    }
    echo '</div>';
    echo '</section>';

    echo '<section class="fic-home-section fic-home-latest" aria-labelledby="fic-theme-hub-latest-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Latest Theme Analysis</p>';
    echo '<h2 id="fic-theme-hub-latest-title">最新のテーマ分析</h2>';
    echo '<p>直近で公開・更新されたテーマ分析です。</p>';
    echo '</div>';
    if (!empty($latest_posts)) {
        echo '<div class="fic-hub-latest-grid">';
        foreach ($latest_posts as $post) {
            $excerpt_source = has_excerpt($post) ? $post->post_excerpt : $post->post_content;
            echo '<a class="fic-home-latest-card fic-hub-latest-card" href="' . esc_url(get_permalink($post)) . '"' . fic_tracking_attr('theme_hub_latest', get_the_title($post)) . '>';
            echo '<time datetime="' . esc_attr(get_the_date('c', $post)) . '">' . esc_html(get_the_date('Y年n月j日', $post)) . '</time>';
            echo '<strong>' . esc_html(get_the_title($post)) . '</strong>';
            echo '<span>' . esc_html(fic_trim_plain_text($excerpt_source, 92)) . '</span>';
            echo '</a>';
        }
        echo '</div>';
    } else {
        echo '<p class="fic-home-latest-empty">テーマ分析の記事を準備しています。</p>';
    }
    echo '</section>';

    echo '<section class="fic-home-section fic-home-trust fic-hub-next" aria-labelledby="fic-theme-hub-next-title">';
    echo '<div>';
    echo '<p class="fic-home-section-label">Next</p>';
    echo '<h2 id="fic-theme-hub-next-title">企業分析へつなげる</h2>';
    echo '<p>テーマの影響先が見えたら、個別企業の記事で売上・利益率・KPIへの波及を確認します。</p>';
    echo '</div>';
    echo '<div class="fic-home-trust-links">';
    echo '<a href="' . esc_url(home_url('/companies/')) . '"' . fic_tracking_attr('theme_hub_next', '企業を探す') . '>企業を探す</a>';
    echo '<a href="' . esc_url(home_url('/learn/')) . '"' . fic_tracking_attr('theme_hub_next', '投資の読み方') . '>投資の読み方</a>';
    echo '<a href="' . esc_url(home_url('/')) . '"' . fic_tracking_attr('theme_hub_next', 'トップページ') . '>トップページ</a>';
    echo '</div>';
    echo '</section>';
    echo '</div>';

    return ob_get_clean();
}
}

if (!function_exists('fic_theme_hub_shortcode')) {
function fic_theme_hub_shortcode() {
    return fic_render_theme_hub();
}
}
add_shortcode('fic_theme_hub', 'fic_theme_hub_shortcode');

if (!function_exists('fic_render_learning_hub')) {
function fic_render_learning_hub() {
    $learning_categories = ['投資の読み方', '基礎講座', 'ビギナーガイド'];
    $learning_count = fic_get_category_post_count_by_name($learning_categories);
    $latest_posts = fic_get_latest_posts_by_category_name($learning_categories, 6);
    $learning_search_chips = [
        ['label' => '決算短信', 'slug' => 'kessan-tanshin-reading-guide'],
        ['label' => '営業利益率', 'slug' => 'operating-margin-guide'],
        ['label' => '受注残・在庫', 'slug' => 'orders-backlog-inventory-guide'],
        ['label' => '進捗率', 'slug' => 'earnings-progress-rate-guide'],
        ['label' => 'キャッシュフロー', 'slug' => 'cash-flow-guide'],
        ['label' => 'ROE・ROIC', 'slug' => 'roe-roic-guide'],
        ['label' => '財務安全性', 'slug' => 'equity-ratio-interest-bearing-debt-guide'],
    ];
    $learning_topics = [
        ['label' => 'First', 'title' => '決算短信の読み方', 'body' => '売上、営業利益、会社予想、進捗率を最初に確認する。', 'query' => '決算短信 読み方'],
        ['label' => 'Margin', 'title' => '利益率を見る', 'body' => '売上が伸びても利益が増えない理由を、粗利率と販管費から読む。', 'query' => '営業利益率 粗利率'],
        ['label' => 'KPI', 'title' => '受注残・在庫を見る', 'body' => '次の売上や値下げリスクにつながる先行指標を確認する。', 'query' => '受注残 在庫'],
        ['label' => 'Finance', 'title' => '財務とROEを見る', 'body' => '自己資本、キャッシュフロー、ROEを成長余力とリスクに分ける。', 'query' => 'ROE 財務'],
        ['label' => 'Company', 'title' => '企業分析の読み順', 'body' => '30秒要約から、売上、利益率、中計、リスクへ順番に読む。', 'query' => '企業分析 読み方'],
    ];
    $reading_steps = [
        ['label' => '01', 'title' => 'まず決算の数字を読む', 'body' => '売上、営業利益、会社予想、進捗率だけを先に確認します。'],
        ['label' => '02', 'title' => '数字が動いた理由を見る', 'body' => '数量、単価、為替、原材料、人件費など、利益の変化点を探します。'],
        ['label' => '03', 'title' => '次に確認するKPIを決める', 'body' => '受注、在庫、稼働率、月次、会社予想のどれを見るべきかを決めます。'],
    ];
    $learning_routes = [
        [
            'label' => 'Before',
            'title' => '決算前に予習する',
            'body'  => '決算発表前に、会社予想と見るべき数字を短く確認します。',
            'links' => [
                ['label' => '決算短信', 'slug' => 'kessan-tanshin-reading-guide'],
                ['label' => '進捗率', 'slug' => 'earnings-progress-rate-guide'],
                ['label' => '中期経営計画', 'slug' => 'medium-term-plan-guide'],
            ],
        ],
        [
            'label' => 'On Day',
            'title' => '発表直後に確認する',
            'body'  => '売上と利益率、受注・在庫の変化から、今回決算の焦点をつかみます。',
            'links' => [
                ['label' => '営業利益率', 'slug' => 'operating-margin-guide'],
                ['label' => '受注残・在庫', 'slug' => 'orders-backlog-inventory-guide'],
                ['label' => 'セグメント', 'slug' => 'segment-information-guide'],
            ],
        ],
        [
            'label' => 'Deep Dive',
            'title' => '発表後に深掘りする',
            'body'  => '利益と現金、資本効率、財務安全性を見て、次に追う論点を決めます。',
            'links' => [
                ['label' => 'キャッシュフロー', 'slug' => 'cash-flow-guide'],
                ['label' => 'ROE・ROIC', 'slug' => 'roe-roic-guide'],
                ['label' => '財務安全性', 'slug' => 'equity-ratio-interest-bearing-debt-guide'],
            ],
        ],
        [
            'label' => 'Risk',
            'title' => 'リスクと還元を見る',
            'body'  => 'M&A後の減損、価格転嫁、株主還元の余力を確認します。',
            'links' => [
                ['label' => 'のれん・減損', 'slug' => 'goodwill-impairment-guide'],
                ['label' => '価格転嫁', 'slug' => 'price-pass-through-guide'],
                ['label' => '株主還元', 'slug' => 'payout-ratio-total-return-guide'],
            ],
        ],
    ];
    $investment_reading_items = [
        ['label' => 'First', 'title' => '決算短信の読み方', 'body' => '売上、営業利益、会社予想、進捗率を最初に確認する。', 'slug' => 'kessan-tanshin-reading-guide'],
        ['label' => 'Margin', 'title' => '営業利益率とは何か', 'body' => '売上が伸びても利益が増えない理由を読む。', 'slug' => 'operating-margin-guide'],
        ['label' => 'KPI', 'title' => '受注残と在庫の見方', 'body' => '次の売上と値下げリスクにつながる先行指標を見る。', 'slug' => 'orders-backlog-inventory-guide'],
        ['label' => 'ROE', 'title' => 'ROEとROICの違い', 'body' => '資本効率と事業の稼ぐ力を分けて確認する。', 'slug' => 'roe-roic-guide'],
        ['label' => 'Segment', 'title' => 'セグメント情報の読み方', 'body' => 'どの事業が売上と利益を動かしたかを読む。', 'slug' => 'segment-information-guide'],
        ['label' => 'Cash', 'title' => 'キャッシュフロー計算書の見方', 'body' => '利益と現金のズレ、投資余力、財務リスクを見る。', 'slug' => 'cash-flow-guide'],
    ];

    ob_start();

    echo '<div class="fic-home fic-learning-hub">';
    echo '<section class="fic-hub-hero" aria-labelledby="fic-learning-hub-title">';
    echo '<a class="fic-hub-home-link" href="' . esc_url(home_url('/')) . '"' . fic_tracking_attr('learning_hub_hero', 'トップページへ') . '>トップページへ</a>';
    echo '<p class="fic-home-section-label">Learning Hub</p>';
    echo '<h1 id="fic-learning-hub-title">投資の読み方</h1>';
    echo '<p>企業分析を読むために必要な、決算・利益率・受注残・在庫・財務の見方を短く整理します。</p>';
    echo '<div class="fic-hub-hero-meta">';
    if ($learning_count) {
        echo '<span><strong>' . esc_html(number_format_i18n((int) $learning_count)) . '</strong>本の投資の読み方</span>';
    }
    echo '<a href="' . esc_url(fic_get_category_url_by_names($learning_categories, '/category/')) . '"' . fic_tracking_attr('learning_hub_hero', '投資の読み方一覧') . '>投資の読み方一覧</a>';
    echo '</div>';
    echo '<form class="fic-home-search fic-hub-search" role="search" method="get" action="' . esc_url(home_url('/')) . '">';
    echo '<label for="fic-learning-hub-search">知りたい指標を検索</label>';
    echo '<div class="fic-home-search-row">';
    echo '<input id="fic-learning-hub-search" type="search" name="s" placeholder="例：営業利益率、受注残、ROE、在庫" value="' . esc_attr(get_search_query()) . '">';
    echo '<button type="submit">検索</button>';
    echo '</div>';
    echo '<div class="fic-home-search-chips" aria-label="投資の読み方クイックリンク">';
    foreach ($learning_search_chips as $chip) {
        echo '<a href="' . esc_url(fic_get_post_url_by_slug($chip['slug'], '/' . $chip['slug'] . '/')) . '"' . fic_tracking_attr('learning_hub_search_chip', $chip['label']) . '>' . esc_html($chip['label']) . '</a>';
    }
    echo '</div>';
    echo '</form>';
    echo '</section>';
    echo fic_render_hub_nav('learning');

    echo '<section class="fic-home-section fic-hub-guide" aria-labelledby="fic-learning-topic-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Topics</p>';
    echo '<h2 id="fic-learning-topic-title">知りたいことから選ぶ</h2>';
    echo '<p>記事を読む前に、つまずきやすい数字の意味を先に押さえます。</p>';
    echo '</div>';
    echo '<div class="fic-hub-card-grid">';
    foreach ($learning_topics as $topic) {
        echo '<a class="fic-hub-card" href="' . esc_url(home_url('/?s=' . rawurlencode($topic['query']))) . '"' . fic_tracking_attr('learning_hub_topic', $topic['title']) . '>';
        echo '<span>' . esc_html($topic['label']) . '</span>';
        echo '<strong>' . esc_html($topic['title']) . '</strong>';
        echo '<p>' . esc_html($topic['body']) . '</p>';
        echo '</a>';
    }
    echo '</div>';
    echo '</section>';

    echo '<section class="fic-home-section fic-home-route" aria-labelledby="fic-learning-route-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Route</p>';
    echo '<h2 id="fic-learning-route-title">最初の読み順</h2>';
    echo '<p>初心者はこの順番で読むと、企業分析の記事がかなり楽になります。</p>';
    echo '</div>';
    echo '<div class="fic-home-route-grid">';
    foreach ($reading_steps as $step) {
        echo '<div class="fic-home-route-step">';
        echo '<span>' . esc_html($step['label']) . '</span>';
        echo '<strong>' . esc_html($step['title']) . '</strong>';
        echo '<p>' . esc_html($step['body']) . '</p>';
        echo '</div>';
    }
    echo '</div>';
    echo '</section>';

    echo '<section class="fic-home-section fic-hub-guide" aria-labelledby="fic-learning-routes-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Learning Routes</p>';
    echo '<h2 id="fic-learning-routes-title">使う場面から選ぶ</h2>';
    echo '<p>決算前、発表直後、発表後の深掘り、リスク確認で、読む記事を切り替えます。</p>';
    echo '</div>';
    echo '<div class="fic-hub-card-grid fic-learning-route-grid">';
    foreach ($learning_routes as $route) {
        echo '<div class="fic-hub-card fic-learning-route-card">';
        echo '<span>' . esc_html($route['label']) . '</span>';
        echo '<strong>' . esc_html($route['title']) . '</strong>';
        echo '<p>' . esc_html($route['body']) . '</p>';
        echo '<div class="fic-learning-route-links">';
        foreach ($route['links'] as $link) {
            echo '<a href="' . esc_url(fic_get_post_url_by_slug($link['slug'], '/' . $link['slug'] . '/')) . '"' . fic_tracking_attr('learning_hub_route', $route['title'] . ': ' . $link['label']) . '>' . esc_html($link['label']) . '</a>';
        }
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '</section>';

    echo '<section class="fic-home-section fic-hub-guide" aria-labelledby="fic-investment-reading-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Featured Reading Guides</p>';
    echo '<h2 id="fic-investment-reading-title">まず読む代表記事</h2>';
    echo '<p>企業分析でよく出る指標と決算用語を、先に短く確認できます。</p>';
    echo '</div>';
    echo '<div class="fic-hub-card-grid">';
    foreach ($investment_reading_items as $item) {
        echo '<a class="fic-hub-card" href="' . esc_url(fic_get_post_url_by_slug($item['slug'], '/' . $item['slug'] . '/')) . '"' . fic_tracking_attr('learning_hub_featured', $item['title']) . '>';
        echo '<span>' . esc_html($item['label']) . '</span>';
        echo '<strong>' . esc_html($item['title']) . '</strong>';
        echo '<p>' . esc_html($item['body']) . '</p>';
        echo '</a>';
    }
    echo '</div>';
    echo '</section>';

    echo '<section class="fic-home-section fic-home-latest" aria-labelledby="fic-learning-latest-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Latest Basics</p>';
    echo '<h2 id="fic-learning-latest-title">最新の投資の読み方</h2>';
    echo '<p>決算や企業分析を読むための土台になる記事です。</p>';
    echo '</div>';
    if (!empty($latest_posts)) {
        echo '<div class="fic-hub-latest-grid">';
        foreach ($latest_posts as $post) {
            $excerpt_source = has_excerpt($post) ? $post->post_excerpt : $post->post_content;
            echo '<a class="fic-home-latest-card fic-hub-latest-card" href="' . esc_url(get_permalink($post)) . '"' . fic_tracking_attr('learning_hub_latest', get_the_title($post)) . '>';
            echo '<time datetime="' . esc_attr(get_the_date('c', $post)) . '">' . esc_html(get_the_date('Y年n月j日', $post)) . '</time>';
            echo '<strong>' . esc_html(get_the_title($post)) . '</strong>';
            echo '<span>' . esc_html(fic_trim_plain_text($excerpt_source, 92)) . '</span>';
            echo '</a>';
        }
        echo '</div>';
    } else {
        echo '<p class="fic-home-latest-empty">投資の読み方の記事を準備しています。</p>';
    }
    echo '</section>';

    echo '<section class="fic-home-section fic-home-trust fic-hub-next" aria-labelledby="fic-learning-next-title">';
    echo '<div>';
    echo '<p class="fic-home-section-label">Next</p>';
    echo '<h2 id="fic-learning-next-title">実際の記事で確認する</h2>';
    echo '<p>基礎を押さえたら、気になる企業やニュース材料で、売上・利益率・KPIの変化を確認します。</p>';
    echo '</div>';
    echo '<div class="fic-home-trust-links">';
    echo '<a href="' . esc_url(home_url('/companies/')) . '"' . fic_tracking_attr('learning_hub_next', '企業で試す') . '>企業で試す</a>';
    echo '<a href="' . esc_url(home_url('/themes/')) . '"' . fic_tracking_attr('learning_hub_next', '材料で試す') . '>材料で試す</a>';
    echo '<a href="' . esc_url(home_url('/')) . '"' . fic_tracking_attr('learning_hub_next', 'トップページ') . '>トップページ</a>';
    echo '</div>';
    echo '</section>';
    echo '</div>';

    return ob_get_clean();
}
}

if (!function_exists('fic_learning_hub_shortcode')) {
function fic_learning_hub_shortcode() {
    return fic_render_learning_hub();
}
}
add_shortcode('fic_learning_hub', 'fic_learning_hub_shortcode');

