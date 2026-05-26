/**
 * FIC top page MVP shortcode.
 *
 * Shortcode: [fic_home_mvp]
 *
 * Intended for the WordPress top page while the full theme/snippet structure is
 * being finalized. It reuses fic_render_upcoming_earnings_list() when available.
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

if (!function_exists('fic_tracking_attr')) {
    function fic_tracking_attr($area, $label) {
        return ' data-fic-area="' . esc_attr($area) . '" data-fic-label="' . esc_attr($label) . '"';
    }
}

if (!function_exists('fic_render_home_latest_group')) {
    function fic_render_home_latest_group($group) {
        $posts = fic_get_latest_posts_by_category_name($group['category'], 3);
        $category_names = is_array($group['category']) ? $group['category'] : [$group['category']];
        $primary_category = reset($category_names);

        ob_start();

        echo '<section class="fic-home-latest-group">';
        echo '<div class="fic-home-latest-group-head">';
        echo '<span>' . esc_html($group['label']) . '</span>';
        echo '<h3>' . esc_html($group['title']) . '</h3>';
        echo '<p>' . esc_html($group['description']) . '</p>';
        echo '</div>';

        if (!empty($posts)) {
            echo '<div class="fic-home-latest-list">';
            foreach ($posts as $post) {
                $excerpt_source = has_excerpt($post) ? $post->post_excerpt : $post->post_content;

                echo '<a class="fic-home-latest-card" href="' . esc_url(get_permalink($post)) . '"' . fic_tracking_attr('home_latest_' . strtolower($group['label']), get_the_title($post)) . '>';
                echo '<time datetime="' . esc_attr(get_the_date('c', $post)) . '">' . esc_html(get_the_date('Y年n月j日', $post)) . '</time>';
                echo '<strong>' . esc_html(get_the_title($post)) . '</strong>';
                echo '<span>' . esc_html(fic_trim_plain_text($excerpt_source, 88)) . '</span>';
                echo '</a>';
            }
            echo '</div>';
        } else {
            echo '<div class="fic-home-latest-empty">';
            echo '<strong>準備中</strong>';
            echo '<p>' . esc_html($group['empty']) . '</p>';
            echo '</div>';
        }

        echo '<a class="fic-home-latest-more" href="' . esc_url(fic_get_category_url_by_names($category_names, '/category/')) . '"' . fic_tracking_attr('home_latest_more', $group['more']) . '>' . esc_html($group['more']) . '</a>';
        echo '</section>';

        return ob_get_clean();
    }
}

if (!function_exists('fic_render_home_mvp')) {
    function fic_render_home_mvp() {
        $theme_analysis_categories = ['テーマ分析', '業界分析'];
        $learning_categories = ['投資の読み方', '基礎講座', 'ビギナーガイド'];

        $entry_cards = [
            [
                'label' => '企業分析',
                'title' => '個別企業を構造で読む',
                'body'  => '売上、利益率、中計、リスクを一気に確認。',
                'url'   => home_url('/companies/'),
                'count' => fic_get_category_post_count_by_name('企業分析'),
            ],
            [
                'label' => 'テーマ分析',
                'title' => 'ニュースの波及先を読む',
                'body'  => '金利、為替、原材料、AI投資の影響先を探す。',
                'url'   => home_url('/themes/'),
                'count' => fic_get_category_post_count_by_name($theme_analysis_categories),
            ],
            [
                'label' => '投資の読み方',
                'title' => '決算と指標の見方を学ぶ',
                'body'  => '決算、利益率、受注残、在庫などの基礎。',
                'url'   => home_url('/learn/'),
                'count' => fic_get_category_post_count_by_name($learning_categories),
            ],
        ];

        $flow_steps = [
            [
                'label' => 'Step 1',
                'title' => '上流要因',
                'body'  => '為替、金利、原材料、政策、需要。',
            ],
            [
                'label' => 'Step 2',
                'title' => '企業KPI',
                'body'  => '数量、単価、受注、在庫、稼働率。',
            ],
            [
                'label' => 'Step 3',
                'title' => '売上・利益',
                'body'  => '売上、営業利益、利益率への波及。',
            ],
            [
                'label' => 'Step 4',
                'title' => '次に見る指標',
                'body'  => '次の決算で見る確認点と反証条件。',
            ],
        ];

        $first_check_items = [
            [
                'label' => '1',
                'title' => '気になる企業を調べる',
                'body'  => '企業名や証券コードから探す。',
                'url'   => home_url('/companies/'),
            ],
            [
                'label' => '2',
                'title' => 'ニュースの波及先を見る',
                'body'  => '材料が効く業界・企業を探す。',
                'url'   => home_url('/themes/'),
            ],
            [
                'label' => '3',
                'title' => '決算と指標を学ぶ',
                'body'  => '読み方の土台を先に押さえる。',
                'url'   => home_url('/learn/'),
            ],
            [
                'label' => '4',
                'title' => '次の決算で確認する',
                'body'  => '決算日と更新予定を見る。',
                'url'   => home_url('/earnings-schedule/'),
            ],
        ];

        $route_steps = [
            [
                'label' => '01',
                'title' => '決算と指標の意味をつかむ',
                'body'  => '営業利益率、受注残、在庫など、企業分析の読み方を先に押さえます。',
                'url'   => home_url('/learn/'),
            ],
            [
                'label' => '02',
                'title' => '気になる企業を1社読む',
                'body'  => '売上、利益率、中計、リスクをつなげて、業績が動く理由を確認します。',
                'url'   => home_url('/companies/'),
            ],
            [
                'label' => '03',
                'title' => '業界・テーマへ広げる',
                'body'  => 'ニュースやマクロ変化が、どの企業に波及するかを横に広げて見ます。',
                'url'   => home_url('/themes/'),
            ],
        ];

        $purpose_routes = [
            [
                'label' => 'Company Routes',
                'title' => '業種・材料別に企業を探す',
                'body'  => '金融、資源、消費、半導体、自動車などの切り口から代表企業分析へ進みます。',
                'url'   => home_url('/companies/'),
                'chips' => ['金融', '資源', '消費', '半導体', '自動車'],
            ],
            [
                'label' => 'Theme Routes',
                'title' => 'テーマから波及先を見る',
                'body'  => '金利、為替、原材料、エネルギー、政策などの材料から企業業績への道筋を追います。',
                'url'   => home_url('/themes/'),
                'chips' => ['金利', '為替', '原材料', '政策'],
            ],
            [
                'label' => 'Learning Routes',
                'title' => '決算の読み方を場面で選ぶ',
                'body'  => '決算前、発表直後、深掘り、リスク確認の場面別に基礎記事へ進みます。',
                'url'   => home_url('/learn/'),
                'chips' => ['決算前', '発表直後', '深掘り', '還元'],
            ],
            [
                'label' => 'Earnings Routes',
                'title' => '決算予定から次に読む',
                'body'  => '決算日を確認しながら、企業分析、決算短信の読み方、外部環境テーマへ移動します。',
                'url'   => home_url('/earnings-schedule/'),
                'chips' => ['予定', '企業分析', '読み方', '外部環境'],
            ],
        ];

        $trigger_items = [
            [
                'label' => 'Rates',
                'title' => '金利',
                'body'  => '銀行、不動産、リース、成長株の前提を確認。',
                'slug'  => 'interest-rate-impact-stocks',
            ],
            [
                'label' => 'FX',
                'title' => '為替',
                'body'  => '輸出、輸入、海外売上、原価への影響を見る。',
                'slug'  => 'fx-impact-company-earnings',
            ],
            [
                'label' => 'Cost',
                'title' => '原材料',
                'body'  => '価格転嫁、粗利率、在庫評価の変化を追う。',
                'slug'  => 'raw-material-cost-pass-through',
            ],
            [
                'label' => 'AI/Semi',
                'title' => 'AI・半導体',
                'body'  => '設備投資、部材、電力、データセンターへ広げる。',
                'slug'  => 'semiconductor-investment-supply-chain',
            ],
            [
                'label' => 'Policy',
                'title' => '政策・補助金',
                'body'  => '予算、採択、受注、売上計上まで段階で見る。',
                'slug'  => 'policy-subsidy-investment-theme',
            ],
            [
                'label' => 'Energy',
                'title' => 'エネルギー',
                'body'  => '電力需要、燃料費、送配電、脱炭素投資の波及を見る。',
                'slug'  => 'energy-transition-power-investment',
            ],
        ];

        $home_search_chips = [
            ['label' => '半導体', 'url' => home_url('/semiconductor-investment-supply-chain/')],
            ['label' => '金利', 'url' => home_url('/interest-rate-impact-stocks/')],
            ['label' => '為替', 'url' => home_url('/fx-impact-company-earnings/')],
            ['label' => '決算', 'url' => home_url('/kessan-tanshin-reading-guide/')],
            ['label' => '政策', 'url' => home_url('/policy-subsidy-investment-theme/')],
            ['label' => 'エネルギー', 'url' => home_url('/energy-transition-power-investment/')],
        ];

        $earnings_checks = [
            ['label' => '売上', 'body' => '数量・単価・為替のどれで動いたか'],
            ['label' => '利益率', 'body' => '原価、人件費、販管費、価格転嫁'],
            ['label' => '会社予想', 'body' => '上方修正、据え置き、進捗率'],
            ['label' => '次のKPI', 'body' => '受注、在庫、稼働率、月次指標'],
        ];

        $latest_groups = [
            [
                'label'       => 'Company',
                'title'       => '最新の企業分析',
                'description' => '個別企業の売上ドライバー、利益構造、中計、リスクを最新資料ベースで整理します。',
                'category'    => '企業分析',
                'more'        => '企業分析をもっと見る',
                'empty'       => '企業分析の記事を準備しています。',
            ],
            [
                'label'       => 'Theme',
                'title'       => '最新のテーマ分析',
                'description' => 'ニュースやマクロ変化が、どの業界・企業に波及するかを因果構造で追います。',
                'category'    => $theme_analysis_categories,
                'more'        => 'テーマ分析をもっと見る',
                'empty'       => 'テーマ分析の記事を準備しています。',
            ],
            [
                'label'       => 'Basics',
                'title'       => '投資の読み方',
                'description' => '決算、利益率、受注残、在庫、ROEなど、企業分析を読むための土台を整えます。',
                'category'    => $learning_categories,
                'more'        => '投資の読み方を見る',
                'empty'       => '投資の読み方の記事を準備しています。まずは企業分析・テーマ分析から読み始められます。',
            ],
        ];

        $home_stat_items = [
            ['label' => '企業分析', 'count' => fic_get_category_post_count_by_name('企業分析')],
            ['label' => 'テーマ分析', 'count' => fic_get_category_post_count_by_name($theme_analysis_categories)],
            ['label' => '投資の読み方', 'count' => fic_get_category_post_count_by_name($learning_categories)],
        ];
        $home_latest_posts = fic_get_latest_posts_by_category_name(array_merge(['企業分析'], $theme_analysis_categories, $learning_categories), 1);
        $home_latest_post = !empty($home_latest_posts) ? $home_latest_posts[0] : null;

        ob_start();

        echo '<div class="fic-home">';

        echo '<section class="fic-home-hero" aria-labelledby="fic-home-hero-title">';
        echo '<div class="fic-home-hero-copy">';
        echo '<p class="fic-home-eyebrow">公開資料から、企業業績が動く理由を読む</p>';
        echo '<h1 id="fic-home-hero-title">FIC投資研究所</h1>';
        echo '<p class="fic-home-lead">公開資料をもとに、企業業績がなぜ動くのかを短く、深く整理します。</p>';
        echo '<div class="fic-home-stats" aria-label="FICの記事蓄積">';
        foreach ($home_stat_items as $stat) {
            if (!empty($stat['count'])) {
                echo '<div class="fic-home-stat"><strong>' . esc_html(number_format_i18n((int) $stat['count'])) . '</strong><span>' . esc_html($stat['label']) . '</span></div>';
            }
        }
        echo '</div>';
        if ($home_latest_post) {
            echo '<div class="fic-home-now">';
            echo '<span>最新更新</span>';
            echo '<a href="' . esc_url(get_permalink($home_latest_post)) . '"' . fic_tracking_attr('home_hero', 'latest_update') . '>';
            echo '<time datetime="' . esc_attr(get_the_date('c', $home_latest_post)) . '">' . esc_html(get_the_date('Y年n月j日', $home_latest_post)) . '</time>';
            echo '<strong>' . esc_html(get_the_title($home_latest_post)) . '</strong>';
            echo '</a>';
            echo '</div>';
        }
        echo '<form class="fic-home-search" role="search" method="get" action="' . esc_url(home_url('/')) . '">';
        echo '<label for="fic-home-search-input">企業名・証券コード・テーマを検索</label>';
        echo '<div class="fic-home-search-row">';
        echo '<input id="fic-home-search-input" type="search" name="s" placeholder="例：ニトリ、9843、半導体、金利" value="' . esc_attr(get_search_query()) . '">';
        echo '<button type="submit">検索</button>';
        echo '</div>';
        echo '<div class="fic-home-search-chips" aria-label="よく見られるテーマ">';
        foreach ($home_search_chips as $chip) {
            echo '<a href="' . esc_url($chip['url']) . '"' . fic_tracking_attr('home_search_chip', $chip['label']) . '>' . esc_html($chip['label']) . '</a>';
        }
        echo '</div>';
        echo '</form>';
        echo '<div class="fic-home-actions">';
        echo '<a class="fic-home-primary" href="' . esc_url(home_url('/companies/')) . '"' . fic_tracking_attr('home_hero_action', '企業を探す') . '>企業を探す</a>';
        echo '<a class="fic-home-secondary" href="' . esc_url(home_url('/themes/')) . '"' . fic_tracking_attr('home_hero_action', 'テーマから探す') . '>テーマから探す</a>';
        echo '<a class="fic-home-secondary" href="' . esc_url(home_url('/learn/')) . '"' . fic_tracking_attr('home_hero_action', '投資の読み方') . '>投資の読み方</a>';
        echo '<a class="fic-home-secondary" href="' . esc_url(home_url('/earnings-schedule/')) . '"' . fic_tracking_attr('home_hero_action', '決算予定') . '>決算予定</a>';
        echo '</div>';
        echo '</div>';
        echo '<div class="fic-home-hero-panel" aria-label="FICの分析フロー">';
        echo '<div class="fic-home-visual-card">';
        echo '<div class="fic-home-visual-head"><span>FIC Lens</span><strong>材料から業績へ</strong></div>';
        echo '<div class="fic-home-visual-flow" aria-hidden="true">';
        echo '<span>上流要因</span>';
        echo '<i></i>';
        echo '<span>KPI</span>';
        echo '<i></i>';
        echo '<span>売上・利益</span>';
        echo '</div>';
        echo '<div class="fic-home-visual-metrics" aria-hidden="true">';
        echo '<span>為替</span><span>受注</span><span>利益率</span><span>在庫</span><span>中計</span><span>反証</span>';
        echo '</div>';
        echo '<div class="fic-home-source-badges" aria-label="FICの分析前提">';
        echo '<span>公開資料</span><span>会計士視点</span><span>編集確認</span>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</section>';

        echo '<nav class="fic-home-quicknav" aria-label="トップページ内ナビゲーション">';
        echo '<a href="#fic-home-firstcheck"' . fic_tracking_attr('home_quicknav', 'まず見る') . '>まず見る</a>';
        echo '<a href="#fic-home-purpose-routes"' . fic_tracking_attr('home_quicknav', '目的別ルート') . '>目的別ルート</a>';
        echo '<a href="#fic-home-triggers"' . fic_tracking_attr('home_quicknav', '材料から探す') . '>材料から探す</a>';
        echo '<a href="#fic-home-latest"' . fic_tracking_attr('home_quicknav', '新着分析') . '>新着分析</a>';
        echo '<a href="#fic-home-upcoming"' . fic_tracking_attr('home_quicknav', '決算予定') . '>決算予定</a>';
        echo '</nav>';

        echo '<section id="fic-home-firstcheck" class="fic-home-section fic-home-firstcheck" aria-labelledby="fic-home-firstcheck-title">';
        echo '<div class="fic-home-section-head">';
        echo '<p class="fic-home-section-label">First Check</p>';
        echo '<h2 id="fic-home-firstcheck-title">迷ったら、まずここから見る</h2>';
        echo '<p>銘柄、ニュース、基礎、決算。入口を4つに絞りました。</p>';
        echo '</div>';
        echo '<div class="fic-home-firstcheck-grid">';
        foreach ($first_check_items as $item) {
            echo '<a class="fic-home-firstcheck-card" href="' . esc_url($item['url']) . '"' . fic_tracking_attr('home_firstcheck', $item['title']) . '>';
            echo '<span>' . esc_html($item['label']) . '</span>';
            echo '<strong>' . esc_html($item['title']) . '</strong>';
            echo '<em>' . esc_html($item['body']) . '</em>';
            echo '</a>';
        }
        echo '</div>';
        echo '</section>';

        echo '<section id="fic-home-purpose-routes" class="fic-home-section fic-home-purpose-routes" aria-labelledby="fic-home-purpose-routes-title">';
        echo '<div class="fic-home-section-head">';
        echo '<p class="fic-home-section-label">Purpose Routes</p>';
        echo '<h2 id="fic-home-purpose-routes-title">目的別ルートから始める</h2>';
        echo '<p>企業、テーマ、読み方、決算予定の各ハブに、さらに細かい入口を用意しています。</p>';
        echo '</div>';
        echo '<div class="fic-home-purpose-route-grid">';
        foreach ($purpose_routes as $route) {
            echo '<a class="fic-home-purpose-route-card" href="' . esc_url($route['url']) . '"' . fic_tracking_attr('home_purpose_route', $route['title']) . '>';
            echo '<span>' . esc_html($route['label']) . '</span>';
            echo '<strong>' . esc_html($route['title']) . '</strong>';
            echo '<em>' . esc_html($route['body']) . '</em>';
            echo '<div>';
            foreach ($route['chips'] as $chip) {
                echo '<b>' . esc_html($chip) . '</b>';
            }
            echo '</div>';
            echo '</a>';
        }
        echo '</div>';
        echo '</section>';

        echo '<section id="fic-home-triggers" class="fic-home-section fic-home-triggers" aria-labelledby="fic-home-triggers-title">';
        echo '<div class="fic-home-section-head">';
        echo '<p class="fic-home-section-label">Market Triggers</p>';
        echo '<h2 id="fic-home-triggers-title">業績を動かす材料から探す</h2>';
        echo '<p>ニュースを見たら、まず業績への通り道を確認します。</p>';
        echo '</div>';
        echo '<div class="fic-home-trigger-grid">';
        foreach ($trigger_items as $item) {
            $trigger_url = fic_get_post_url_by_slug($item['slug'], '/' . $item['slug'] . '/');
            echo '<a class="fic-home-trigger-card" href="' . esc_url($trigger_url) . '"' . fic_tracking_attr('home_market_trigger', $item['title']) . '>';
            echo '<span>' . esc_html($item['label']) . '</span>';
            echo '<strong>' . esc_html($item['title']) . '</strong>';
            echo '<em>' . esc_html($item['body']) . '</em>';
            echo '</a>';
        }
        echo '</div>';
        echo '</section>';

        echo '<section class="fic-home-section fic-home-entry" aria-labelledby="fic-home-entry-title">';
        echo '<div class="fic-home-section-head">';
        echo '<p class="fic-home-section-label">Start Here</p>';
        echo '<h2 id="fic-home-entry-title">目的別に読む</h2>';
        echo '<p>読む目的を選んでください。</p>';
        echo '</div>';
        echo '<div class="fic-home-entry-grid">';
        foreach ($entry_cards as $card) {
            echo '<a class="fic-home-entry-card" href="' . esc_url($card['url']) . '"' . fic_tracking_attr('home_entry', $card['label']) . '>';
            echo '<span class="fic-home-card-label">' . esc_html($card['label']) . '</span>';
            echo '<strong>' . esc_html($card['title']) . '</strong>';
            echo '<span>' . esc_html($card['body']) . '</span>';
            if (!empty($card['count'])) {
                echo '<em class="fic-home-entry-count">' . esc_html(number_format_i18n((int) $card['count'])) . '本の記事</em>';
            }
            echo '</a>';
        }
        echo '</div>';
        echo '</section>';

        echo '<section class="fic-home-section fic-home-route" aria-labelledby="fic-home-route-title">';
        echo '<div class="fic-home-section-head">';
        echo '<p class="fic-home-section-label">Reading Route</p>';
        echo '<h2 id="fic-home-route-title">最初の3ステップ</h2>';
        echo '<p>初めて来た人は、この順番で読むとFICの使い方がつかめます。</p>';
        echo '</div>';
        echo '<div class="fic-home-route-grid">';
        foreach ($route_steps as $step) {
            echo '<a class="fic-home-route-step" href="' . esc_url($step['url']) . '"' . fic_tracking_attr('home_reading_route', $step['title']) . '>';
            echo '<span>' . esc_html($step['label']) . '</span>';
            echo '<strong>' . esc_html($step['title']) . '</strong>';
            echo '<em>' . esc_html($step['body']) . '</em>';
            echo '</a>';
        }
        echo '</div>';
        echo '</section>';

        echo '<section class="fic-home-section fic-home-flow" aria-labelledby="fic-home-flow-title">';
        echo '<div class="fic-home-section-head">';
        echo '<p class="fic-home-section-label">FIC Method</p>';
        echo '<h2 id="fic-home-flow-title">上流要因から業績まで、一本の線で読む</h2>';
        echo '<p>材料が業績に届くまでを追います。</p>';
        echo '</div>';
        echo '<div class="fic-home-flow-grid">';
        foreach ($flow_steps as $step) {
            echo '<div class="fic-home-flow-step">';
            echo '<span>' . esc_html($step['label']) . '</span>';
            echo '<strong>' . esc_html($step['title']) . '</strong>';
            echo '<p>' . esc_html($step['body']) . '</p>';
            echo '</div>';
        }
        echo '</div>';
        echo '</section>';

        echo '<section id="fic-home-latest" class="fic-home-section fic-home-latest" aria-labelledby="fic-home-latest-title">';
        echo '<div class="fic-home-section-head">';
        echo '<p class="fic-home-section-label">Latest Analysis</p>';
        echo '<h2 id="fic-home-latest-title">いま読める分析</h2>';
        echo '<p>最新記事を、企業・テーマ・学習の3つの入口に分けて表示します。</p>';
        echo '</div>';
        echo '<div class="fic-home-latest-grid">';
        foreach ($latest_groups as $group) {
            echo fic_render_home_latest_group($group);
        }
        echo '</div>';
        echo '</section>';

        echo '<section id="fic-home-upcoming" class="fic-home-section fic-home-upcoming" aria-labelledby="fic-home-upcoming-title">';
        echo '<div class="fic-home-section-head">';
        echo '<p class="fic-home-section-label">Earnings Watch</p>';
        echo '<h2 id="fic-home-upcoming-title">直近の分析更新予定</h2>';
        echo '<p>決算発表に合わせて、売上や利益の構造に着目した分析記事を順次更新しています。</p>';
        echo '</div>';
        echo '<div class="fic-home-earnings-checks" aria-label="決算で見るポイント">';
        foreach ($earnings_checks as $check) {
            echo '<div class="fic-home-earnings-check">';
            echo '<span>' . esc_html($check['label']) . '</span>';
            echo '<strong>' . esc_html($check['body']) . '</strong>';
            echo '</div>';
        }
        echo '</div>';
        if (function_exists('fic_render_upcoming_earnings_list')) {
            echo fic_render_upcoming_earnings_list(8);
        } else {
            echo '<p class="fic-home-latest-empty">決算スケジュールは準備中です。</p>';
        }
        echo '</section>';

        echo '<section class="fic-home-section fic-home-video" aria-labelledby="fic-home-video-title">';
        echo '<div>';
        echo '<p class="fic-home-section-label">Video</p>';
        echo '<h2 id="fic-home-video-title">動画でざっくり見る</h2>';
        echo '<p>記事を読む前に全体像をつかみたい方へ。企業分析やテーマ分析の要点を、短い図解動画でも確認できます。</p>';
        echo '</div>';
        echo '<div class="fic-home-video-actions">';
        echo '<a class="fic-home-video-primary" href="' . esc_url('https://www.youtube.com/@FICInvestmentBiz') . '" target="_blank" rel="noopener"' . fic_tracking_attr('home_video', 'YouTubeを見る') . '>YouTubeを見る</a>';
        echo '<a class="fic-home-video-secondary" href="' . esc_url(home_url('/companies/')) . '"' . fic_tracking_attr('home_video', '記事で詳しく読む') . '>記事で詳しく読む</a>';
        echo '</div>';
        echo '</section>';

        echo '<section class="fic-home-section fic-home-trust" aria-labelledby="fic-home-trust-title">';
        echo '<div>';
        echo '<p class="fic-home-section-label">Editorial Policy</p>';
        echo '<h2 id="fic-home-trust-title">分析の前提を明確にします</h2>';
        echo '<p>FIC投資研究所では、公開資料を優先し、会社開示値・外部推計・FIC前提付き試算を区別します。記事は特定銘柄の売買を推奨するものではなく、投資判断の前提を整理するための情報提供です。</p>';
        echo '</div>';
        echo '<div class="fic-home-trust-links">';
        echo '<a href="' . esc_url(home_url('/about/')) . '"' . fic_tracking_attr('home_trust', 'FIC投資研究所について') . '>FIC投資研究所について</a>';
        echo '<a href="' . esc_url(home_url('/editorial-policy/')) . '"' . fic_tracking_attr('home_trust', '編集方針') . '>編集方針</a>';
        echo '<a href="' . esc_url(home_url('/learn/')) . '"' . fic_tracking_attr('home_trust', '投資の読み方') . '>投資の読み方</a>';
        echo '</div>';
        echo '</section>';

        echo '</div>';

        return ob_get_clean();
    }
}

if (!function_exists('fic_home_mvp_shortcode')) {
    function fic_home_mvp_shortcode() {
        return fic_render_home_mvp();
    }
}

add_shortcode('fic_home_mvp', 'fic_home_mvp_shortcode');

