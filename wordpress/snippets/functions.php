<?php

require get_template_directory().'/lib/assets/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
    'https://tan-taka.com/wp_diver/theme-update/update-info.json',
    __FILE__,
    'wp-theme-diver'
);

// core
require_once('lib/admin/init.php');
require_once('lib/admin/scheme.php');
require_once('lib/admin/seo.php');
require_once('lib/admin/ogp.php');

// option
require_once('lib/options/main.php');
require_once('lib/options/single.php');
require_once('lib/options/category.php');
require_once('lib/options/color.php');
require_once('lib/options/size.php');
require_once('lib/options/icon.php');
require_once('lib/options/layout.php');
require_once('lib/options/design.php');
require_once('lib/options/design2.php');
require_once('lib/options/theme.php');

// setting
require_once('lib/functions/diver_settings.php');
require_once('lib/functions/blogcard.php');
require_once('lib/functions/load-script.php');
require_once('lib/functions/custom_post.php');
require_once('lib/functions/widget.php');
require_once('lib/functions/posts.php');
require_once('lib/functions/posts-loop.php');
require_once('lib/functions/cta.php');
require_once('lib/functions/amp.php');
require_once('lib/functions/appealbox.php');
require_once('lib/functions/shortcode.php');
require_once('lib/functions/amp_convert.php');
require_once('lib/functions/lazyload.php');
require_once('lib/functions/quicktags.php');
require_once('lib/functions/adsence.php');
require_once('lib/functions/filter.php');

if (version_compare(phpversion(), '7.4.0', '>') && get_option('diver_analytics_api_propertyID') && get_option('diver_analytics_api_key_url')) {
    require_once('lib/assets/popularposts/class-popular-posts.php');
}

require_once('lib/parts/catpage_contents.php');

if (get_bloginfo('version') >= "5.0.0") {
    require_once('lib/functions/editor/gutenberg/blocks.php');
}

if (is_admin()) {
    require_once('lib/auxiliary/init.php');
}

//metabox
require_once('lib/metabox/layout.php');
require_once('lib/metabox/cta.php');
require_once('lib/metabox/widget.php');
require_once('lib/metabox/ad.php');
require_once('lib/metabox/custom_css.php');
require_once('lib/metabox/amp.php');
require_once('lib/metabox/title-count.php');
require_once('lib/metabox/appeal.php');
require_once('lib/metabox/featuredImage.php');
require_once('lib/metabox/auth-before.php');
require_once('lib/metabox/lp_header.php');
require_once('lib/metabox/lp_layout.php');
require_once('lib/metabox/catpage.php');
require_once('lib/metabox/seo.php');
require_once('lib/metabox/nextpage.php');
require_once('lib/metabox/head_inner.php');

//widget
require_once('lib/widget/ad.php');
require_once('lib/widget/newpost.php');
require_once('lib/widget/newpost_grid.php');
require_once('lib/widget/profile.php');
require_once('lib/widget/pcsp.php');
require_once('lib/widget/tab.php');
require_once('lib/widget/dpp.php');
require_once('lib/widget/search.php');

require_once(ABSPATH . 'wp-admin/includes/file.php');

/**
 * 決算スケジュール一覧
 * date は YYYY-MM-DD 形式で統一
 */
function fic_get_earnings_schedule() {
    return [
        ['company' => 'くら寿司', 'code' => '2695', 'date' => '2026-03-01'],
        ['company' => '霞ヶ関キャピタル', 'code' => '3498', 'date' => '2026-04-02'],
        ['company' => 'サイゼリヤ', 'code' => '7581', 'date' => '2026-04-08'],
        ['company' => 'コメダホールディングス', 'code' => '3543', 'date' => '2026-04-08'],
        ['company' => 'イオン', 'code' => '8267', 'date' => '2026-04-09'],
        ['company' => 'ファーストリテイリング', 'code' => '9983', 'date' => '2026-04-09'],
        ['company' => 'セブン&アイ・ホールディングス', 'code' => '3382', 'date' => '2026-04-09'],
        ['company' => '吉野家ホールディングス', 'code' => '9861', 'date' => '2026-04-09'],
        ['company' => '良品計画', 'code' => '7453', 'date' => '2026-04-10'],
        ['company' => 'ディスコ', 'code' => '6146', 'date' => '2026-04-22'],
        ['company' => 'シマノ', 'code' => '7309', 'date' => '2026-04-23'],
        ['company' => 'キヤノン', 'code' => '7751', 'date' => '2026-04-23'],
        ['company' => 'キーエンス', 'code' => '6861', 'date' => '2026-04-24'],
        ['company' => 'ジャフコグループ', 'code' => '8595', 'date' => '2026-04-24'],
        ['company' => '野村ホールディングス', 'code' => '8604', 'date' => '2026-04-24'],
        ['company' => 'アンリツ', 'code' => '6754', 'date' => '2026-04-27'],
        ['company' => '日立製作所', 'code' => '6501', 'date' => '2026-04-27'],
        ['company' => '第一三共', 'code' => '4568', 'date' => '2026-05-11'],
        ['company' => 'アドバンテスト', 'code' => '6857', 'date' => '2026-04-27'],
        ['company' => '信越化学工業', 'code' => '4063', 'date' => '2026-04-28'],
        ['company' => 'オリエンタルランド', 'code' => '4661', 'date' => '2026-04-28'],
        ['company' => 'レーザーテック', 'code' => '6920', 'date' => '2026-04-30'],
        ['company' => 'LIXIL', 'code' => '5938', 'date' => '2026-04-30'],
        ['company' => '三菱倉庫', 'code' => '9301', 'date' => '2026-04-30'],
        ['company' => '東日本旅客鉄道', 'code' => '9020', 'date' => '2026-04-30'],
        ['company' => '西日本旅客鉄道', 'code' => '9021', 'date' => '2026-04-30'],
        ['company' => '商船三井', 'code' => '9104', 'date' => '2026-04-30'],
        ['company' => '東京エレクトロン', 'code' => '8035', 'date' => '2026-04-30'],
        ['company' => '東京電力ホールディングス', 'code' => '9501', 'date' => '2026-04-30'],
        ['company' => '関西電力', 'code' => '9503', 'date' => '2026-04-30'],
        ['company' => 'DMG森精機', 'code' => '6141', 'date' => '2026-05-01'],
        ['company' => 'エムスリー', 'code' => '2413', 'date' => '2026-05-01'],
        ['company' => '三菱商事', 'code' => '8058', 'date' => '2026-05-01'],
        ['company' => '伊藤忠商事', 'code' => '8001', 'date' => '2026-05-01'],
        ['company' => 'SBIホールディングス', 'code' => '8473', 'date' => '2026-05-01'],
        ['company' => 'LINEヤフー', 'code' => '4689', 'date' => '2026-05-08'],
        ['company' => '任天堂', 'code' => '7974', 'date' => '2026-05-08'],
        ['company' => 'JFEホールディングス', 'code' => '5411', 'date' => '2026-05-08'],
        ['company' => 'トヨタ自動車', 'code' => '7203', 'date' => '2026-05-08'],
        ['company' => 'NTT', 'code' => '9432', 'date' => '2026-05-08'],
        ['company' => 'ソニーグループ', 'code' => '6758', 'date' => '2026-05-08'],
        ['company' => 'FOOD & LIFE COMPANIES', 'code' => '3563', 'date' => '2026-05-08'],
        ['company' => 'ソフトバンク', 'code' => '9434', 'date' => '2026-05-11'],
        ['company' => '日本板硝子', 'code' => '5202', 'date' => '2026-05-11'],
        ['company' => 'オリックス', 'code' => '8591', 'date' => '2026-05-11'],
        ['company' => '日本郵船', 'code' => '9101', 'date' => '2026-05-11'],
        ['company' => '住友金属鉱山', 'code' => '5713', 'date' => '2026-05-11'],
        ['company' => 'メルカリ', 'code' => '4385', 'date' => '2026-05-11'],
        ['company' => '川崎重工業', 'code' => '7012', 'date' => '2026-05-12'],
        ['company' => 'MTG', 'code' => '7806', 'date' => '2026-05-12'],
        ['company' => 'AGC', 'code' => '5201', 'date' => '2026-05-12'],
        ['company' => '三菱重工業', 'code' => '7011', 'date' => '2026-05-12'],
        ['company' => 'ダイキン工業', 'code' => '6367', 'date' => '2026-05-12'],
        ['company' => '日本製鉄', 'code' => '5401', 'date' => '2026-05-13'],
        ['company' => '武田薬品工業', 'code' => '4502', 'date' => '2026-05-13'],
        ['company' => 'ソフトバンクグループ', 'code' => '9984', 'date' => '2026-05-13'],
        ['company' => '大林組', 'code' => '1802', 'date' => '2026-05-13'],
        ['company' => '三菱マテリアル', 'code' => '5711', 'date' => '2026-05-13'],
        ['company' => '三井不動産', 'code' => '8801', 'date' => '2026-05-13'],
        ['company' => '三菱地所', 'code' => '8802', 'date' => '2026-05-13'],
        ['company' => '三菱ケミカルグループ', 'code' => '4188', 'date' => '2026-05-13'],
        ['company' => 'パン・パシフィック・インターナショナルHD', 'code' => '7532', 'date' => '2026-05-13'],
        ['company' => 'SCREENホールディングス', 'code' => '7735', 'date' => '2026-05-13'],
        ['company' => 'サイバーエージェント', 'code' => '4751', 'date' => '2026-05-13'],
        ['company' => 'すかいらーくホールディングス', 'code' => '3197', 'date' => '2026-05-13'],
        ['company' => '三井住友フィナンシャルグループ', 'code' => '8316', 'date' => '2026-05-13'],
        ['company' => 'バンダイナムコホールディングス', 'code' => '7832', 'date' => '2026-05-13'],
        ['company' => '栗本鐵工所', 'code' => '5602', 'date' => '2026-05-14'],
        ['company' => 'ホンダ', 'code' => '7267', 'date' => '2026-05-14'],
        ['company' => '三和ホールディングス', 'code' => '5929', 'date' => '2026-05-14'],
        ['company' => '鹿島', 'code' => '1812', 'date' => '2026-05-14'],
        ['company' => '上組', 'code' => '9364', 'date' => '2026-05-14'],
        ['company' => 'ニトリホールディングス', 'code' => '9843', 'date' => '2026-05-14'],
        ['company' => '三菱UFJフィナンシャル・グループ', 'code' => '8306', 'date' => '2026-05-15'],
        ['company' => '王子ホールディングス', 'code' => '3861', 'date' => '2026-05-15'],
        ['company' => '日本製紙', 'code' => '3863', 'date' => '2026-05-15'],
        ['company' => 'リクルートホールディングス', 'code' => '6098', 'date' => '2026-05-15'],
        ['company' => 'GMOインターネットグループ', 'code' => '9449', 'date' => '2026-05-15'],
        ['company' => 'みずほフィナンシャルグループ', 'code' => '8411', 'date' => '2026-05-15'],
    ];
}

function fic_get_post_by_stock_code_in_slug($stock_code) {
    global $wpdb;

    $stock_code = preg_replace('/[^0-9]/', '', (string) $stock_code);
    if ($stock_code === '') {
        return null;
    }

    $post_id = $wpdb->get_var(
        $wpdb->prepare(
            "
            SELECT ID
            FROM {$wpdb->posts}
            WHERE post_type = 'post'
              AND post_status = 'publish'
              AND post_name LIKE %s
            ORDER BY post_date DESC
            LIMIT 1
            ",
            '%' . $wpdb->esc_like($stock_code) . '%'
        )
    );

    return $post_id ? get_post((int) $post_id) : null;
}

function fic_get_earnings_status_data($stock_code, $scheduled_date) {
    $post = fic_get_post_by_stock_code_in_slug($stock_code);

    $scheduled_ts = strtotime($scheduled_date . ' 15:00:00');
    $modified_ts = null;

    if ($post) {
        $modified_ts = strtotime($post->post_modified);
    }

    $status = 'pending';
    $label  = '更新予定';
    $url    = $post ? get_permalink($post->ID) : '';

    if ($post && $modified_ts >= $scheduled_ts) {
        $status = 'done';
        $label  = '公開済み';
    }

    if (!$post) {
        $status = 'missing';
        $label  = '記事作成予定';
    }

    return [
        'status' => $status,
        'label'  => $label,
        'url'    => $url,
        'post'   => $post,
    ];
}

function fic_render_status_badge($status_data) {
    $status = $status_data['status'];
    $label  = $status_data['label'];
    $url    = $status_data['url'];

    $class_map = [
        'done'    => 'fic-status-done',
        'pending' => 'fic-status-pending',
        'missing' => 'fic-status-missing',
    ];

    $class = isset($class_map[$status]) ? $class_map[$status] : 'fic-status-missing';
    $inner = '<span class="fic-status-icon" aria-hidden="true"></span><span class="fic-status-label">' . esc_html($label) . '</span>';

    if (!empty($url)) {
        return '<a class="fic-status ' . esc_attr($class) . '" href="' . esc_url($url) . '">' . $inner . '</a>';
    }

    return '<span class="fic-status ' . esc_attr($class) . '">' . $inner . '</span>';
}

function fic_render_earnings_schedule_mobile_cards($schedule) {
    ob_start();
    echo '<div class="fic-earnings-mobile-list">';

    foreach ($schedule as $item) {
        $status_data = fic_get_earnings_status_data($item['code'], $item['date']);
        $row_class   = 'fic-earnings-mobile-list-row fic-earnings-row-' . $status_data['status'];

        echo '<div class="' . esc_attr($row_class) . '">';
        echo '<div class="fic-earnings-mobile-main">';
        echo '<div class="fic-earnings-mobile-company-block">';
        echo '<div class="fic-earnings-mobile-label">企業名</div>';
        echo '<div class="fic-earnings-mobile-cell fic-earnings-mobile-company">' . esc_html($item['company']) . '</div>';
        echo '</div>';
        echo '<div class="fic-earnings-mobile-status-block">';
        echo '<div class="fic-earnings-mobile-label">状況</div>';
        echo '<div class="fic-earnings-mobile-cell fic-earnings-mobile-status">' . fic_render_status_badge($status_data) . '</div>';
        echo '</div>';
        echo '</div>';
        echo '<div class="fic-earnings-mobile-meta">';
        echo '<div class="fic-earnings-mobile-meta-item">';
        echo '<div class="fic-earnings-mobile-label">コード</div>';
        echo '<div class="fic-earnings-mobile-cell fic-earnings-mobile-code">' . esc_html($item['code']) . '</div>';
        echo '</div>';
        echo '<div class="fic-earnings-mobile-meta-item">';
        echo '<div class="fic-earnings-mobile-label">決算日</div>';
        echo '<div class="fic-earnings-mobile-cell fic-earnings-mobile-date">' . esc_html(date_i18n('n/j', strtotime($item['date']))) . '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
    return ob_get_clean();
}

function fic_get_earnings_schedule_period_label($schedule) {
    if (empty($schedule)) {
        return '';
    }

    $dates = array_column($schedule, 'date');
    sort($dates);

    $first_ts = strtotime(reset($dates));
    $last_ts  = strtotime(end($dates));

    if (!$first_ts || !$last_ts) {
        return '';
    }

    $first_year  = date_i18n('Y', $first_ts);
    $last_year   = date_i18n('Y', $last_ts);
    $first_month = date_i18n('n', $first_ts);
    $last_month  = date_i18n('n', $last_ts);

    if ($first_year === $last_year) {
        return sprintf('%s年%s月〜%s月', $first_year, $first_month, $last_month);
    }

    return sprintf('%s年%s月〜%s年%s月', $first_year, $first_month, $last_year, $last_month);
}

function fic_get_earnings_status_counts($schedule) {
    $counts = [
        'done'    => 0,
        'pending' => 0,
        'missing' => 0,
    ];

    foreach ($schedule as $item) {
        $status_data = fic_get_earnings_status_data($item['code'], $item['date']);
        $status      = $status_data['status'];

        if (isset($counts[$status])) {
            $counts[$status]++;
        }
    }

    return $counts;
}

function fic_render_earnings_schedule_table() {
    $schedule = fic_get_earnings_schedule();

    usort($schedule, function($a, $b) {
        return strcmp($a['date'], $b['date']);
    });

    $period_label = fic_get_earnings_schedule_period_label($schedule);
    $counts       = fic_get_earnings_status_counts($schedule);

    ob_start();
    echo '<div class="fic-earnings-table-wrap">';
    echo '<div class="fic-earnings-table-header">';
    echo '<div class="fic-earnings-table-heading">';
    echo '<p class="fic-earnings-table-eyebrow">決算分析スケジュール一覧（随時更新）</p>';
    if ($period_label !== '') {
        echo '<p class="fic-earnings-table-period">対象期間：' . esc_html($period_label) . '</p>';
    }
    echo '<p class="fic-earnings-table-note">状態表記は「公開済み」「更新予定」「記事作成予定」の3種類で統一しています。</p>';
    echo '</div>';
    echo '<div class="fic-earnings-table-summary">';
    echo '<span class="fic-earnings-summary-pill">全' . esc_html((string) count($schedule)) . '件</span>';
    echo '<span class="fic-earnings-summary-pill">公開済み ' . esc_html((string) $counts['done']) . '件</span>';
    echo '<span class="fic-earnings-summary-pill">更新予定 ' . esc_html((string) $counts['pending']) . '件</span>';
    echo '<span class="fic-earnings-summary-pill">記事作成予定 ' . esc_html((string) $counts['missing']) . '件</span>';
    echo '</div>';
    echo '</div>';
    echo '<table class="fic-earnings-table">';
    echo '<thead><tr>';
    echo '<th>企業名</th>';
    echo '<th>コード</th>';
    echo '<th>決算日</th>';
    echo '<th>状況</th>';
    echo '</tr></thead><tbody>';

    foreach ($schedule as $item) {
        $status_data = fic_get_earnings_status_data($item['code'], $item['date']);
        $row_class   = 'fic-earnings-row fic-earnings-row-' . $status_data['status'];

        echo '<tr class="' . esc_attr($row_class) . '">';
        echo '<td data-label="企業名">' . esc_html($item['company']) . '</td>';
        echo '<td data-label="コード">' . esc_html($item['code']) . '</td>';
        echo '<td data-label="決算日">' . esc_html(date_i18n('Y/n/j', strtotime($item['date']))) . '</td>';
        echo '<td data-label="状況">' . fic_render_status_badge($status_data) . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table></div>';
    echo fic_render_earnings_schedule_mobile_cards($schedule);
    return ob_get_clean();
}

function fic_render_upcoming_earnings_list($limit = 8) {
    $schedule = fic_get_earnings_schedule();

    $today = current_time('Y-m-d');
    $past_limit = date('Y-m-d', strtotime($today . ' -3 days'));

    $filtered = array_filter($schedule, function($item) use ($past_limit) {
        return $item['date'] >= $past_limit;
    });

    $filtered = array_values($filtered);
    foreach ($filtered as $index => $item) {
        $filtered[$index]['_original_index'] = $index;
    }

    usort($filtered, function($a, $b) use ($today) {
        $a_is_today = $a['date'] === $today;
        $b_is_today = $b['date'] === $today;

        if ($a_is_today && !$b_is_today) {
            return -1;
        }

        if (!$a_is_today && $b_is_today) {
            return 1;
        }

        $a_is_future = $a['date'] > $today;
        $b_is_future = $b['date'] > $today;

        if ($a_is_future && !$b_is_future) {
            return -1;
        }

        if (!$a_is_future && $b_is_future) {
            return 1;
        }

        if ($a_is_future && $b_is_future) {
            $date_compare = strcmp($a['date'], $b['date']);
            return $date_compare !== 0 ? $date_compare : ($a['_original_index'] <=> $b['_original_index']);
        }

        $date_compare = strcmp($b['date'], $a['date']);
        return $date_compare !== 0 ? $date_compare : ($a['_original_index'] <=> $b['_original_index']);
    });

    $filtered = array_slice($filtered, 0, $limit);

    if (empty($filtered)) {
        return '<p>現在、表示できる決算予定はありません。</p>';
    }

    ob_start();

    echo '<div class="fic-upcoming-cards">';

    foreach ($filtered as $item) {
        $status_data = fic_get_earnings_status_data($item['code'], $item['date']);
        $date_label = date_i18n('n/j', strtotime($item['date']));

        echo '<div class="fic-upcoming-card">';
        echo '<div class="fic-upcoming-card-inner">';

        echo '<div class="fic-upcoming-card-date">' . esc_html($date_label) . '</div>';
        echo '<div class="fic-upcoming-card-main">';
        echo '<div class="fic-upcoming-card-title">';
        echo '<div class="fic-upcoming-card-company">' . esc_html($item['company']) . '</div>';
        echo '<div class="fic-upcoming-card-code">（' . esc_html($item['code']) . '）</div>';
        echo '</div>';

        echo '<div class="fic-upcoming-card-status">';
        echo fic_render_status_badge($status_data);
        echo '</div>';

        echo '</div>';

        echo '</div>';
        echo '</div>';
    }

    echo '</div>';

    echo '<div class="fic-upcoming-more">';
    echo '<a href="/earnings-schedule/" class="fic-more-btn">決算スケジュールをもっと見る →</a>';
    echo '</div>';

    return ob_get_clean();
}

function fic_earnings_schedule_table_shortcode() {
    return fic_render_earnings_schedule_table();
}
add_shortcode('earnings_schedule_table', 'fic_earnings_schedule_table_shortcode');

function fic_upcoming_earnings_shortcode($atts) {
    $atts = shortcode_atts([
        'limit' => 8,
    ], $atts);

    return fic_render_upcoming_earnings_list((int) $atts['limit']);
}
add_shortcode('upcoming_earnings', 'fic_upcoming_earnings_shortcode');

function fic_find_post_by_company_name($company_name) {
    $posts = get_posts([
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        's'              => $company_name,
    ]);

    return !empty($posts) ? $posts[0] : null;
}

function fic_company_code_map_manual() {
    return [
        '鹿島建設' => '1812',
        '大林組'   => '1802',
        '大成建設' => '1801',
        '清水建設' => '1803',
        'ディスコ' => '6146',
        '東京精密' => '7729',
        'アドバンテスト' => '6857',
        'シマノ' => '7309',
        'キヤノン' => '7751',
        '野村HD' => '8604',
        '三井住友FG' => '8316',
        '三菱UFJFG' => '8306',
        '伊藤忠商事' => '8001',
        '三菱商事' => '8058',
        '三井物産' => '8031',
        '住友商事' => '8053',
        '丸紅' => '8002',
        '豊田通商' => '8015',
        '双日' => '2768',
    ];
}

function fic_normalize_company_name_for_map($title) {
    $title = wp_strip_all_tags($title);
    $title = html_entity_decode($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    $title = preg_replace('/【最新版】/u', '', $title);
    $title = preg_replace('/\[最新版\]/u', '', $title);

    if (preg_match('/^(.+?)[（(]\d{4}[)）]/u', $title, $matches)) {
        return trim($matches[1]);
    }

    $title = preg_replace('/（\d{4}）/u', '', $title);
    $title = preg_replace('/\(\d{4}\)/u', '', $title);
    $title = preg_replace('/の企業分析.*/u', '', $title);
    $title = preg_replace('/企業分析.*/u', '', $title);
    $title = preg_replace('/の分析.*/u', '', $title);
    $title = preg_replace('/分析.*/u', '', $title);
    $title = preg_replace('/の(利益|売上|業績|収益|株価|決算|ビジネスモデル|成長|将来性).*/u', '', $title);

    return trim($title);
}

function fic_company_code_map() {
    $map = fic_company_code_map_manual();

    $posts = get_posts([
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);

    foreach ($posts as $post) {
        if (!preg_match('/([0-9]{4})/', $post->post_name, $matches)) {
            continue;
        }

        $code = $matches[1];
        $company_name = fic_normalize_company_name_for_map($post->post_title);

        if ($company_name === '') {
            continue;
        }

        if (!isset($map[$company_name])) {
            $map[$company_name] = $code;
        }

        $short_name = preg_replace('/ホールディングス/u', '', $company_name);
        $short_name = preg_replace('/フィナンシャルグループ/u', 'FG', $short_name);
        $short_name = preg_replace('/グループ/u', '', $short_name);
        $short_name = trim($short_name);

        if ($short_name !== '' && !isset($map[$short_name])) {
            $map[$short_name] = $code;
        }

        if (mb_strpos($company_name, 'ホールディングス') !== false) {
            $hd_name = str_replace('ホールディングス', 'HD', $company_name);
            $hd_name = trim($hd_name);

            if ($hd_name !== '' && !isset($map[$hd_name])) {
                $map[$hd_name] = $code;
            }
        }
    }

    return $map;
}

function fic_link_peer_companies_in_comparison_section($content) {
    if (!is_single() || !in_the_loop() || !is_main_query()) {
        return $content;
    }

    if (!class_exists('DOMDocument')) {
        return $content;
    }

    libxml_use_internal_errors(true);

    $dom = new DOMDocument();

    $html = mb_convert_encoding(
        '<div id="fic-wrap">' . $content . '</div>',
        'HTML-ENTITIES',
        'UTF-8'
    );

    $loaded = $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    if (!$loaded) {
        return $content;
    }

    $xpath = new DOMXPath($dom);
    $company_map = fic_company_code_map();

    $tables = $xpath->query('//table');
    if (!$tables || $tables->length === 0) {
        return $content;
    }

    foreach ($tables as $table) {
        $rows = $xpath->query('.//tr', $table);
        if (!$rows || $rows->length === 0) {
            continue;
        }

        $header_cells = $xpath->query('./th | ./td', $rows->item(0));
        if (!$header_cells || $header_cells->length === 0) {
            continue;
        }

        $header_texts = [];
        foreach ($header_cells as $idx => $cell) {
            $header_texts[$idx] = trim(preg_replace('/\s+/u', '', $cell->textContent));
        }

        $target_mode = null;
        $target_columns = [];

        foreach ($header_texts as $idx => $header_text) {
            if (mb_strpos($header_text, '企業例') !== false) {
                $target_mode = 'company_example_column';
                $target_columns[] = $idx;
            }
        }

        if ($target_mode === null && isset($header_texts[0])) {
            if ($header_texts[0] === '企業名') {
                $target_mode = 'comparison_first_column';
                $target_columns[] = 0;
            }
        }

        if ($target_mode === null && isset($header_texts[0])) {
            if (in_array($header_texts[0], ['比較項目', '比較軸'], true)) {
                $target_mode = 'comparison_header_row';
                for ($i = 1; $i < count($header_texts); $i++) {
                    $target_columns[] = $i;
                }
            }
        }

        if ($target_mode === null || empty($target_columns)) {
            continue;
        }

        foreach ($rows as $row_index => $row) {
            $cells = $xpath->query('./th | ./td', $row);
            if (!$cells || $cells->length === 0) {
                continue;
            }

            if ($target_mode === 'comparison_header_row' && $row_index !== 0) {
                continue;
            }

            if ($target_mode === 'comparison_first_column' && $row_index === 0) {
                continue;
            }

            if ($target_mode === 'company_example_column' && $row_index === 0) {
                continue;
            }

            foreach ($target_columns as $col_index) {
                if ($col_index >= $cells->length) {
                    continue;
                }

                $cell = $cells->item($col_index);
                if (!$cell) {
                    continue;
                }

                if ($xpath->query('.//a', $cell)->length > 0) {
                    continue;
                }

                $text = trim($cell->textContent);
                if ($text === '') {
                    continue;
                }

                $replaced = preg_replace_callback(
                    '/([^、,・\/／\n\r]+?)\s*[（(]([0-9]{4})[)）]/u',
                    function ($matches) {
                        $company_name = trim($matches[1]);
                        $stock_code   = trim($matches[2]);
                        $label        = $company_name . '（' . $stock_code . '）';

                        $linked_post = fic_get_post_by_stock_code_in_slug($stock_code);

                        if ($linked_post && get_the_ID() !== $linked_post->ID) {
                            return '<a href="' . esc_url(get_permalink($linked_post->ID)) . '" class="fic-peer-link">' . esc_html($label) . '</a>';
                        }

                        return esc_html($label);
                    },
                    $text
                );

                if ($replaced !== null && $replaced !== $text) {
                    while ($cell->firstChild) {
                        $cell->removeChild($cell->firstChild);
                    }

                    $fragment = $dom->createDocumentFragment();
                    @$fragment->appendXML(mb_convert_encoding($replaced, 'HTML-ENTITIES', 'UTF-8'));
                    $cell->appendChild($fragment);
                    continue;
                }

                $company_name = preg_replace('/\s*[（(].*?[)）]/u', '', $text);
                $company_name = trim($company_name);

                if (isset($company_map[$company_name])) {
                    $stock_code  = $company_map[$company_name];
                    $linked_post = fic_get_post_by_stock_code_in_slug($stock_code);

                    if ($linked_post && get_the_ID() !== $linked_post->ID) {
                        while ($cell->firstChild) {
                            $cell->removeChild($cell->firstChild);
                        }

                        $a = $dom->createElement('a', $text);
                        $a->setAttribute('href', get_permalink($linked_post->ID));
                        $a->setAttribute('class', 'fic-peer-link');

                        $cell->appendChild($a);
                    }
                }
            }
        }
    }

    $wrapper = $dom->getElementById('fic-wrap');
    if (!$wrapper) {
        return $content;
    }

    $new_html = '';
    foreach ($wrapper->childNodes as $child) {
        $new_html .= $dom->saveHTML($child);
    }

    return $new_html;
}
add_filter('the_content', 'fic_link_peer_companies_in_comparison_section', 20);
