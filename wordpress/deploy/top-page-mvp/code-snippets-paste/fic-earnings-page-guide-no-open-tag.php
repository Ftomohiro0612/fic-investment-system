/**
 * FIC earnings page guide.
 *
 * Adds a compact guide above the earnings schedule page so readers understand
 * what to check before opening company-analysis articles.
 */

if (!function_exists('fic_is_earnings_schedule_page')) {
function fic_is_earnings_schedule_page() {
    return is_page(10631) || is_page('earnings-schedule');
}
}

if (!function_exists('fic_earnings_guide_tracking_attr')) {
function fic_earnings_guide_tracking_attr($area, $label) {
    if (function_exists('fic_tracking_attr')) {
        return fic_tracking_attr($area, $label);
    }

    return ' data-fic-area="' . esc_attr($area) . '" data-fic-label="' . esc_attr($label) . '"';
}
}

if (!function_exists('fic_earnings_guide_post_url_by_slug')) {
function fic_earnings_guide_post_url_by_slug($slug, $fallback_path = '/') {
    if (function_exists('fic_get_post_url_by_slug')) {
        return fic_get_post_url_by_slug($slug, $fallback_path);
    }

    $post = get_page_by_path($slug, OBJECT, 'post');

    if ($post && 'publish' === get_post_status($post)) {
        return get_permalink($post);
    }

    return home_url($fallback_path);
}
}

if (!function_exists('fic_render_earnings_page_guide')) {
function fic_render_earnings_page_guide() {
    $links = [
        [
            'label' => 'Before',
            'title' => '決算短信で最初に見る場所',
            'body'  => '売上、営業利益、会社予想、進捗率、配当をまず確認します。',
            'url'   => home_url('/kessan-tanshin-reading-guide/'),
            'track' => '決算短信の読み方',
        ],
        [
            'label' => 'Progress',
            'title' => 'まず会社予想とのズレを見る',
            'body'  => '売上・営業利益・通期予想に対して、今回決算が順調かを確認します。',
            'url'   => home_url('/earnings-progress-rate-guide/'),
            'track' => '進捗率の見方',
        ],
        [
            'label' => 'Margin',
            'title' => '利益率が動いた理由を見る',
            'body'  => '値上げ、原価、人件費、構成差で営業利益率がどう変わったかを見ます。',
            'url'   => home_url('/operating-margin-guide/'),
            'track' => '営業利益率の見方',
        ],
        [
            'label' => 'Next KPI',
            'title' => '先行指標を次の決算へつなぐ',
            'body'  => '受注残、在庫、客数、単価など、次の四半期に効く数字を拾います。',
            'url'   => home_url('/orders-backlog-inventory-guide/'),
            'track' => '受注残と在庫の見方',
        ],
    ];
    $company_links = [
        ['label' => 'ニトリ', 'slug' => 'nitori-9843-analysis', 'query' => 'ニトリ 9843'],
        ['label' => 'みずほFG', 'slug' => 'mizuho-fg-8411-analysis', 'query' => 'みずほ 8411'],
        ['label' => 'ENEOS', 'slug' => 'eneos-holdings-5020-analysis', 'query' => 'ENEOS 5020'],
        ['label' => 'ホンダ', 'slug' => 'honda-7267-analysis', 'query' => 'ホンダ 7267'],
        ['label' => 'SCREEN', 'slug' => 'screen-holdings-7735-analysis', 'query' => 'SCREEN 7735'],
        ['label' => 'ダイキン', 'slug' => 'daikin-6367-analysis', 'query' => 'ダイキン 6367'],
    ];
    $earnings_routes = [
        [
            'label' => 'Before',
            'title' => '決算前に予習する',
            'body'  => '前回決算と会社予想を確認し、どの数字が焦点になるかを決めます。',
            'links' => [
                ['label' => '決算短信', 'slug' => 'kessan-tanshin-reading-guide'],
                ['label' => '進捗率', 'slug' => 'earnings-progress-rate-guide'],
            ],
        ],
        [
            'label' => 'On Day',
            'title' => '発表直後に見る',
            'body'  => '売上、営業利益率、通期予想、受注・在庫の変化を短時間で確認します。',
            'links' => [
                ['label' => '営業利益率', 'slug' => 'operating-margin-guide'],
                ['label' => '受注残・在庫', 'slug' => 'orders-backlog-inventory-guide'],
            ],
        ],
        [
            'label' => 'After',
            'title' => '発表後に深掘りする',
            'body'  => 'セグメント、キャッシュフロー、財務安全性まで見て、次の確認点へつなげます。',
            'links' => [
                ['label' => 'セグメント', 'slug' => 'segment-information-guide'],
                ['label' => 'キャッシュフロー', 'slug' => 'cash-flow-guide'],
                ['label' => '財務安全性', 'slug' => 'equity-ratio-interest-bearing-debt-guide'],
            ],
        ],
    ];
    $theme_context_links = [
        [
            'label' => '金利',
            'body'  => '銀行、不動産、設備投資企業の決算を見る前に確認します。',
            'slug'  => 'interest-rate-impact-stocks',
        ],
        [
            'label' => '為替',
            'body'  => '輸出企業、海外売上比率の高い企業、原材料輸入企業で確認します。',
            'slug'  => 'fx-impact-company-earnings',
        ],
        [
            'label' => '原材料',
            'body'  => '食品、化学、素材、製造業の利益率変化を見るときに使います。',
            'slug'  => 'raw-material-cost-pass-through',
        ],
        [
            'label' => '半導体',
            'body'  => '装置、部材、電子部品、AI投資関連の受注や在庫を見るときに使います。',
            'slug'  => 'semiconductor-investment-supply-chain',
        ],
        [
            'label' => 'エネルギー',
            'body'  => '電力、燃料費、資源価格、脱炭素投資の影響を見るときに確認します。',
            'slug'  => 'energy-transition-power-investment',
        ],
        [
            'label' => '物流',
            'body'  => '小売、食品、建設、製造業のコストや供給制約を見るときに確認します。',
            'slug'  => 'logistics-reform-2024-problem',
        ],
    ];

    ob_start();
    echo '<section class="fic-earnings-guide" aria-labelledby="fic-earnings-guide-title">';
    echo '<div class="fic-earnings-guide-main">';
    echo '<p class="fic-earnings-guide-label">Earnings Watch</p>';
    echo '<h2 id="fic-earnings-guide-title">決算予定から、次に読む企業分析へ進む</h2>';
    echo '<p>このページでは、FICで分析予定・公開済みの企業決算を一覧できます。決算日だけでなく、公開済み記事、更新予定、これから作成する分析を見分けながら、次に確認する企業を選べます。</p>';
    echo '<div class="fic-earnings-guide-actions">';
    echo '<a href="' . esc_url(home_url('/companies/')) . '"' . fic_earnings_guide_tracking_attr('earnings_guide_action', '企業を探す') . '>企業を探す</a>';
    echo '<a href="' . esc_url(home_url('/kessan-tanshin-reading-guide/')) . '"' . fic_earnings_guide_tracking_attr('earnings_guide_action', '決算短信の読み方') . '>決算短信の読み方</a>';
    echo '</div>';
    echo '</div>';
    echo '<div class="fic-earnings-guide-grid">';
    foreach ($links as $link) {
        echo '<a class="fic-earnings-guide-card" href="' . esc_url($link['url']) . '"' . fic_earnings_guide_tracking_attr('earnings_guide_card', $link['track']) . '>';
        echo '<span>' . esc_html($link['label']) . '</span>';
        echo '<strong>' . esc_html($link['title']) . '</strong>';
        echo '<em>' . esc_html($link['body']) . '</em>';
        echo '</a>';
    }
    echo '</div>';
    echo '<div class="fic-earnings-guide-routes" aria-labelledby="fic-earnings-routes-title">';
    echo '<div class="fic-earnings-guide-routes-head">';
    echo '<p class="fic-earnings-guide-label">Earnings Routes</p>';
    echo '<h3 id="fic-earnings-routes-title">決算を見る順番を選ぶ</h3>';
    echo '<p>決算前、発表直後、発表後の深掘りで、見るべき読み方記事を切り替えます。</p>';
    echo '</div>';
    echo '<div class="fic-earnings-guide-routes-grid">';
    foreach ($earnings_routes as $route) {
        echo '<div class="fic-earnings-guide-route">';
        echo '<span>' . esc_html($route['label']) . '</span>';
        echo '<strong>' . esc_html($route['title']) . '</strong>';
        echo '<p>' . esc_html($route['body']) . '</p>';
        echo '<div class="fic-earnings-guide-route-links">';
        foreach ($route['links'] as $link) {
            $route_url = fic_earnings_guide_post_url_by_slug($link['slug'], '/' . $link['slug'] . '/');
            echo '<a href="' . esc_url($route_url) . '"' . fic_earnings_guide_tracking_attr('earnings_guide_route', $route['title'] . ': ' . $link['label']) . '>' . esc_html($link['label']) . '</a>';
        }
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
    echo '<div class="fic-earnings-guide-themes" aria-labelledby="fic-earnings-themes-title">';
    echo '<div class="fic-earnings-guide-themes-head">';
    echo '<p class="fic-earnings-guide-label">Theme Lens</p>';
    echo '<h3 id="fic-earnings-themes-title">決算と一緒に見る外部環境</h3>';
    echo '<p>会社の数字だけで判断しにくいときは、金利、為替、原材料、半導体、エネルギー、物流のどれが効いているかを確認します。</p>';
    echo '</div>';
    echo '<div class="fic-earnings-guide-theme-grid">';
    foreach ($theme_context_links as $theme_link) {
        $theme_url = fic_earnings_guide_post_url_by_slug($theme_link['slug'], '/' . $theme_link['slug'] . '/');
        echo '<a class="fic-earnings-guide-theme" href="' . esc_url($theme_url) . '"' . fic_earnings_guide_tracking_attr('earnings_guide_theme', $theme_link['label']) . '>';
        echo '<strong>' . esc_html($theme_link['label']) . '</strong>';
        echo '<span>' . esc_html($theme_link['body']) . '</span>';
        echo '</a>';
    }
    echo '</div>';
    echo '</div>';
    echo '<div class="fic-earnings-guide-company" aria-labelledby="fic-earnings-company-title">';
    echo '<div>';
    echo '<p class="fic-earnings-guide-label">Company Search</p>';
    echo '<h3 id="fic-earnings-company-title">決算予定から企業分析へ進む</h3>';
    echo '<p>企業名や証券コードで検索するか、公開済みの代表企業分析を直接開けます。</p>';
    echo '</div>';
    echo '<form class="fic-earnings-guide-search" role="search" method="get" action="' . esc_url(home_url('/')) . '">';
    echo '<label for="fic-earnings-company-search">企業名・証券コードを検索</label>';
    echo '<div>';
    echo '<input id="fic-earnings-company-search" type="search" name="s" placeholder="例：ニトリ、9843、みずほ" value="' . esc_attr(get_search_query()) . '">';
    echo '<button type="submit"' . fic_earnings_guide_tracking_attr('earnings_guide_search', '企業検索') . '>検索</button>';
    echo '</div>';
    echo '</form>';
    echo '<div class="fic-earnings-guide-company-links" aria-label="公開済み企業分析">'; 
    foreach ($company_links as $company) {
        $company_url = fic_earnings_guide_post_url_by_slug($company['slug'], '/?s=' . rawurlencode($company['query']));
        echo '<a href="' . esc_url($company_url) . '"' . fic_earnings_guide_tracking_attr('earnings_guide_company', $company['label']) . '>' . esc_html($company['label']) . '</a>';
    }
    echo '</div>';
    echo '</div>';
    echo '</section>';

    return ob_get_clean();
}
}

if (!function_exists('fic_prepend_earnings_page_guide')) {
function fic_prepend_earnings_page_guide($content) {
    if (!fic_is_earnings_schedule_page() || is_admin()) {
        return $content;
    }

    if (strpos($content, 'fic-earnings-guide') !== false) {
        return $content;
    }

    return fic_render_earnings_page_guide() . $content;
}
}
add_filter('the_content', 'fic_prepend_earnings_page_guide', 8);

if (!function_exists('fic_output_earnings_page_guide_css')) {
function fic_output_earnings_page_guide_css() {
    if (!fic_is_earnings_schedule_page() || is_admin()) {
        return;
    }
    ?>
    <style id="fic-earnings-page-guide-css">
      .fic-earnings-guide {
        display: grid;
        grid-template-columns: minmax(0, 0.95fr) minmax(0, 1.05fr);
        gap: 18px;
        align-items: stretch;
        margin: 0 0 28px;
        padding: 24px;
        background:
          radial-gradient(circle at 92% 12%, rgba(255, 213, 0, 0.22), transparent 28%),
          linear-gradient(135deg, #111827 0%, #1f1f23 60%, #2f2a12 100%);
        color: #ffffff;
        border: 1px solid rgba(255, 213, 0, 0.28);
        border-bottom: 5px solid #ffd500;
        border-radius: 8px;
      }

      .fic-earnings-guide-main,
      .fic-earnings-guide-card {
        min-width: 0;
      }

      .fic-earnings-guide,
      .fic-earnings-guide * {
        box-sizing: border-box;
      }

      .fic-earnings-guide-label {
        width: fit-content;
        margin: 0 0 10px;
        padding: 5px 9px;
        background: #ffd500;
        color: #1f1f23;
        border-radius: 4px;
        font-size: 0.78rem;
        font-weight: 900;
        letter-spacing: 0.08em;
        line-height: 1.25;
        text-transform: uppercase;
      }

      .fic-earnings-guide h2 {
        margin: 0 0 12px;
        padding: 0;
        background: transparent;
        color: #ffffff;
        border: 0;
        font-size: 1.7rem;
        line-height: 1.35;
        letter-spacing: 0;
        overflow-wrap: anywhere;
      }

      .fic-earnings-guide p:not(.fic-earnings-guide-label) {
        margin: 0;
        color: #eef2f7;
        line-height: 1.75;
        overflow-wrap: anywhere;
      }

      .fic-earnings-guide-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 18px;
      }

      .fic-earnings-guide-actions a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 10px 15px;
        border-radius: 5px;
        font-weight: 900;
        line-height: 1.3;
        text-decoration: none !important;
      }

      .fic-earnings-guide-actions a:first-child {
        background: #ffd500;
        color: #1f1f23 !important;
      }

      .fic-earnings-guide-actions a:last-child {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff !important;
        border: 1px solid rgba(255, 213, 0, 0.42);
      }

      .fic-earnings-guide-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
      }

      .fic-earnings-guide-card {
        display: grid;
        gap: 8px;
        padding: 16px;
        background: rgba(255, 255, 255, 0.09);
        color: #ffffff !important;
        border: 1px solid rgba(255, 213, 0, 0.32);
        border-top: 4px solid #ffd500;
        border-radius: 6px;
        text-decoration: none !important;
      }

      .fic-earnings-guide-card:hover {
        background: rgba(255, 255, 255, 0.13);
        border-color: #ffd500;
      }

      .fic-earnings-guide-card span {
        width: fit-content;
        padding: 4px 7px;
        background: #ffd500;
        color: #1f1f23;
        border-radius: 4px;
        font-size: 0.72rem;
        font-weight: 900;
        line-height: 1.2;
      }

      .fic-earnings-guide-card strong {
        color: #ffffff;
        font-size: 1rem;
        line-height: 1.45;
        overflow-wrap: anywhere;
      }

      .fic-earnings-guide-card em {
        color: #dce2ec;
        font-size: 0.9rem;
        font-style: normal;
        line-height: 1.65;
        overflow-wrap: anywhere;
      }

      .fic-earnings-guide-routes {
        grid-column: 1 / -1;
        display: grid;
        gap: 14px;
        margin-top: 4px;
        padding-top: 18px;
        border-top: 1px solid rgba(255, 213, 0, 0.28);
      }

      .fic-earnings-guide-routes-head h3 {
        margin: 0 0 8px;
        padding: 0;
        background: transparent;
        color: #ffffff;
        border: 0;
        font-size: 1.22rem;
        line-height: 1.35;
        letter-spacing: 0;
      }

      .fic-earnings-guide-routes-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
      }

      .fic-earnings-guide-route {
        display: grid;
        gap: 8px;
        min-width: 0;
        padding: 15px;
        border: 1px solid rgba(255, 213, 0, 0.28);
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.065);
      }

      .fic-earnings-guide-route > span {
        width: fit-content;
        padding: 4px 7px;
        background: rgba(255, 213, 0, 0.16);
        color: #ffe675;
        border: 1px solid rgba(255, 213, 0, 0.32);
        border-radius: 4px;
        font-size: 0.72rem;
        font-weight: 900;
        line-height: 1.2;
        text-transform: uppercase;
      }

      .fic-earnings-guide-route strong {
        color: #ffffff;
        font-size: 1rem;
        line-height: 1.45;
        overflow-wrap: anywhere;
      }

      .fic-earnings-guide-route p {
        color: #dce2ec !important;
        font-size: 0.9rem;
        line-height: 1.65 !important;
        overflow-wrap: anywhere;
      }

      .fic-earnings-guide-route-links {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
      }

      .fic-earnings-guide-route-links a {
        display: inline-flex;
        align-items: center;
        min-height: 34px;
        padding: 7px 10px;
        border-radius: 999px;
        background: #ffd500;
        color: #1f1f23 !important;
        font-size: 0.86rem;
        font-weight: 900;
        line-height: 1.2;
        text-decoration: none !important;
      }

      .fic-earnings-guide-themes {
        grid-column: 1 / -1;
        display: grid;
        gap: 14px;
        margin-top: 4px;
        padding-top: 18px;
        border-top: 1px solid rgba(255, 213, 0, 0.28);
      }

      .fic-earnings-guide-themes-head h3 {
        margin: 0 0 8px;
        padding: 0;
        background: transparent;
        color: #ffffff;
        border: 0;
        font-size: 1.22rem;
        line-height: 1.35;
        letter-spacing: 0;
      }

      .fic-earnings-guide-theme-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
      }

      .fic-earnings-guide-theme {
        display: grid;
        gap: 7px;
        min-width: 0;
        min-height: 116px;
        padding: 14px;
        border: 1px solid rgba(255, 213, 0, 0.26);
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.07);
        color: #ffffff !important;
        text-decoration: none !important;
      }

      .fic-earnings-guide-theme:hover {
        border-color: #ffd500;
        background: rgba(255, 213, 0, 0.13);
      }

      .fic-earnings-guide-theme strong {
        color: #ffe675;
        font-size: 1rem;
        line-height: 1.35;
        overflow-wrap: anywhere;
      }

      .fic-earnings-guide-theme span {
        color: #dce2ec;
        font-size: 0.88rem;
        line-height: 1.62;
        overflow-wrap: anywhere;
      }

      .fic-earnings-guide-company {
        grid-column: 1 / -1;
        display: grid;
        grid-template-columns: minmax(0, 0.85fr) minmax(280px, 1fr);
        gap: 16px;
        align-items: end;
        margin-top: 4px;
        padding-top: 18px;
        border-top: 1px solid rgba(255, 213, 0, 0.28);
      }

      .fic-earnings-guide-company h3 {
        margin: 0 0 8px;
        padding: 0;
        background: transparent;
        color: #ffffff;
        border: 0;
        font-size: 1.22rem;
        line-height: 1.35;
        letter-spacing: 0;
      }

      .fic-earnings-guide-search {
        display: grid;
        gap: 8px;
      }

      .fic-earnings-guide-search label {
        color: #f8fafc;
        font-size: 0.86rem;
        font-weight: 800;
      }

      .fic-earnings-guide-search div {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 8px;
      }

      .fic-earnings-guide-search input {
        min-width: 0;
        height: 44px;
        padding: 10px 12px;
        border: 1px solid rgba(255, 213, 0, 0.42);
        border-radius: 5px;
        background: rgba(255, 255, 255, 0.96);
        color: #1f1f23;
        font-size: 1rem;
      }

      .fic-earnings-guide-search button {
        min-height: 44px;
        padding: 10px 16px;
        border: 0;
        border-radius: 5px;
        background: #ffd500;
        color: #1f1f23;
        font-weight: 900;
        cursor: pointer;
      }

      .fic-earnings-guide-company-links {
        grid-column: 1 / -1;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
      }

      .fic-earnings-guide-company-links a {
        display: inline-flex;
        align-items: center;
        min-height: 36px;
        padding: 8px 11px;
        border: 1px solid rgba(255, 213, 0, 0.36);
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff !important;
        font-size: 0.9rem;
        font-weight: 850;
        line-height: 1.25;
        text-decoration: none !important;
      }

      .fic-earnings-guide-company-links a:hover {
        border-color: #ffd500;
        background: rgba(255, 213, 0, 0.14);
      }

      @media (max-width: 980px) {
        .fic-earnings-guide {
          grid-template-columns: 1fr;
        }

        .fic-earnings-guide-company {
          grid-template-columns: 1fr;
        }

        .fic-earnings-guide-routes-grid {
          grid-template-columns: 1fr;
        }

        .fic-earnings-guide-theme-grid {
          grid-template-columns: repeat(2, minmax(0, 1fr));
        }
      }

      @media (max-width: 760px) {
        body.page-id-10631 #main,
        body.page-id-10631 #main-wrap,
        body.page-id-10631 #content,
        body.page-id-10631 .content,
        body.page-id-10631 .main,
        body.page-id-10631 article {
          width: 100% !important;
          max-width: calc(100vw) !important;
          min-width: 0 !important;
          overflow-x: hidden !important;
        }

        .fic-earnings-guide {
          width: min(100%, calc(100vw - 40px));
          max-width: calc(100vw - 40px);
          min-width: 0;
          justify-self: center;
          padding: 20px 16px;
          overflow: hidden;
        }

        .fic-earnings-guide-main,
        .fic-earnings-guide-grid,
        .fic-earnings-guide-card,
        .fic-earnings-guide-routes,
        .fic-earnings-guide-routes-head,
        .fic-earnings-guide-routes-grid,
        .fic-earnings-guide-route,
        .fic-earnings-guide-themes,
        .fic-earnings-guide-themes-head,
        .fic-earnings-guide-theme-grid,
        .fic-earnings-guide-theme,
        .fic-earnings-guide-company,
        .fic-earnings-guide-search,
        .fic-earnings-guide-company-links {
          width: 100%;
          max-width: 100%;
          min-width: 0;
          overflow-wrap: anywhere;
          word-break: normal;
          line-break: anywhere;
        }

        .fic-earnings-guide h2 {
          font-size: 1.22rem;
          line-height: 1.42;
        }

        .fic-earnings-guide p:not(.fic-earnings-guide-label),
        .fic-earnings-guide-card em,
        .fic-earnings-guide-route p,
        .fic-earnings-guide-theme span {
          font-size: 0.86rem;
          line-height: 1.68 !important;
          overflow-wrap: anywhere;
          word-break: normal;
          line-break: anywhere;
        }

        .fic-earnings-guide-card strong,
        .fic-earnings-guide-route strong,
        .fic-earnings-guide-theme strong {
          font-size: 0.96rem;
          line-height: 1.45;
          overflow-wrap: anywhere;
          word-break: normal;
          line-break: anywhere;
        }

        .fic-earnings-guide-grid,
        .fic-earnings-guide-actions {
          grid-template-columns: 1fr;
        }

        .fic-earnings-guide-grid {
          display: grid;
        }

        .fic-earnings-guide-theme-grid {
          grid-template-columns: 1fr;
        }

        .fic-earnings-guide-actions a {
          width: 100%;
        }

        .fic-earnings-guide-search div {
          grid-template-columns: 1fr;
        }

        .fic-earnings-guide-search button {
          width: 100%;
        }
      }
    </style>
    <?php
}
}
add_action('wp_head', 'fic_output_earnings_page_guide_css', 99);

