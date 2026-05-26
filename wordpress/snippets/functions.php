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
        ['company' => 'トリケミカル研究所', 'code' => '4369', 'date' => '2026-03-13'],
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
        ['company' => '住友林業', 'code' => '1911', 'date' => '2026-05-07'],
        ['company' => '味の素', 'code' => '2802', 'date' => '2026-05-07'],
        ['company' => 'MonotaRO', 'code' => '3064', 'date' => '2026-05-07'],
        ['company' => '横河電機', 'code' => '6841', 'date' => '2026-05-07'],
        ['company' => 'LINEヤフー', 'code' => '4689', 'date' => '2026-05-08'],
        ['company' => '任天堂', 'code' => '7974', 'date' => '2026-05-08'],
        ['company' => 'JFEホールディングス', 'code' => '5411', 'date' => '2026-05-08'],
        ['company' => 'トヨタ自動車', 'code' => '7203', 'date' => '2026-05-08'],
        ['company' => 'NTT', 'code' => '9432', 'date' => '2026-05-08'],
        ['company' => 'ソニーグループ', 'code' => '6758', 'date' => '2026-05-08'],
        ['company' => 'FOOD & LIFE COMPANIES', 'code' => '3563', 'date' => '2026-05-08'],
        ['company' => '川崎汽船', 'code' => '9107', 'date' => '2026-05-08'],
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
        ['company' => 'INPEX', 'code' => '1605', 'date' => '2026-05-13'],
        ['company' => '栗本鐵工所', 'code' => '5602', 'date' => '2026-05-14'],
        ['company' => '日本電波工業', 'code' => '6779', 'date' => '2026-05-14'],
        ['company' => 'ホンダ', 'code' => '7267', 'date' => '2026-05-14'],
        ['company' => 'ENEOSホールディングス', 'code' => '5020', 'date' => '2026-05-14'],
        ['company' => '三和ホールディングス', 'code' => '5929', 'date' => '2026-05-14'],
        ['company' => '鹿島', 'code' => '1812', 'date' => '2026-05-14'],
        ['company' => '上組', 'code' => '9364', 'date' => '2026-05-14'],
        ['company' => 'ニトリホールディングス', 'code' => '9843', 'date' => '2026-05-14'],
        ['company' => 'キオクシアホールディングス', 'code' => '285A', 'date' => '2026-05-15'],
        ['company' => '三菱UFJフィナンシャル・グループ', 'code' => '8306', 'date' => '2026-05-15'],
        ['company' => '王子ホールディングス', 'code' => '3861', 'date' => '2026-05-15'],
        ['company' => '日本製紙', 'code' => '3863', 'date' => '2026-05-15'],
        ['company' => 'リクルートホールディングス', 'code' => '6098', 'date' => '2026-05-15'],
        ['company' => 'GMOインターネットグループ', 'code' => '9449', 'date' => '2026-05-15'],
        ['company' => 'みずほフィナンシャルグループ', 'code' => '8411', 'date' => '2026-05-15'],
        ['company' => 'アインホールディングス', 'code' => '9627', 'date' => '2026-06-11'],
    ];
}

function fic_normalize_stock_code($stock_code) {
    $stock_code = strtoupper(trim((string) $stock_code));

    if (preg_match('/^([0-9]{3}[0-9A-Z]|[0-9]{4})(?:\.[A-Z]+)?$/u', $stock_code, $matches)) {
        return $matches[1];
    }

    return '';
}

function fic_stock_code_regex() {
    return '/(?<![0-9A-Z])([0-9]{3}[0-9A-Z]|[0-9]{4})(?:\.[A-Z]+)?(?![0-9A-Z])/iu';
}

function fic_get_post_by_stock_code_in_slug($stock_code) {
    global $wpdb;

    $stock_code = fic_normalize_stock_code($stock_code);
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

    foreach ($schedule as $index => $item) {
        $schedule[$index]['_original_index'] = $index;
    }

    $upcoming = array_values(array_filter($schedule, function($item) use ($today) {
        return $item['date'] >= $today;
    }));

    $recent_past = array_values(array_filter($schedule, function($item) use ($today) {
        return $item['date'] < $today;
    }));

    usort($upcoming, function($a, $b) {
        $date_compare = strcmp($a['date'], $b['date']);
        return $date_compare !== 0 ? $date_compare : ($a['_original_index'] <=> $b['_original_index']);
    });

    usort($recent_past, function($a, $b) {
        $date_compare = strcmp($b['date'], $a['date']);
        return $date_compare !== 0 ? $date_compare : ($a['_original_index'] <=> $b['_original_index']);
    });

    $filtered = array_slice(array_merge($upcoming, $recent_past), 0, $limit);
    usort($filtered, function($a, $b) {
        $date_compare = strcmp($a['date'], $b['date']);
        return $date_compare !== 0 ? $date_compare : ($a['_original_index'] <=> $b['_original_index']);
    });

    if (empty($filtered)) {
        return '<div class="fic-home-earnings-empty"><strong>直近の決算予定は更新準備中です。</strong><p>公開済みの企業分析や、決算短信の読み方から先に確認できます。</p><div><a href="' . esc_url(home_url('/companies/')) . '" data-fic-area="home_earnings_empty" data-fic-label="企業分析を見る">企業分析を見る</a><a href="' . esc_url(home_url('/kessan-tanshin-reading-guide/')) . '" data-fic-area="home_earnings_empty" data-fic-label="決算短信の読み方">決算短信の読み方</a></div></div>';
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

if (!function_exists('fic_get_post_url_by_slug')) {
function fic_get_post_url_by_slug($slug, $fallback_path = '/') {
    $post = get_page_by_path($slug, OBJECT, 'post');

    if ($post && 'publish' === get_post_status($post)) {
        return get_permalink($post);
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

    $trigger_items = [
        [
            'label' => 'Rates',
            'title' => '金利',
            'body'  => '銀行、不動産、リース、成長株の前提を確認。',
            'query' => '金利',
        ],
        [
            'label' => 'FX',
            'title' => '為替',
            'body'  => '輸出、輸入、海外売上、原価への影響を見る。',
            'query' => '為替',
        ],
        [
            'label' => 'Cost',
            'title' => '原材料',
            'body'  => '価格転嫁、粗利率、在庫評価の変化を追う。',
            'query' => '原材料',
        ],
        [
            'label' => 'AI/Semi',
            'title' => 'AI・半導体',
            'body'  => '設備投資、部材、電力、データセンターへ広げる。',
            'query' => '半導体 AI',
        ],
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
    foreach (['半導体', '金利', '為替', '決算', 'AI'] as $keyword) {
        echo '<a href="' . esc_url(home_url('/?s=' . rawurlencode($keyword))) . '"' . fic_tracking_attr('home_search_chip', $keyword) . '>' . esc_html($keyword) . '</a>';
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

    echo '<section id="fic-home-triggers" class="fic-home-section fic-home-triggers" aria-labelledby="fic-home-triggers-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Market Triggers</p>';
    echo '<h2 id="fic-home-triggers-title">業績を動かす材料から探す</h2>';
    echo '<p>ニュースを見たら、まず業績への通り道を確認します。</p>';
    echo '</div>';
    echo '<div class="fic-home-trigger-grid">';
    foreach ($trigger_items as $item) {
        echo '<a class="fic-home-trigger-card" href="' . esc_url(home_url('/?s=' . rawurlencode($item['query']))) . '"' . fic_tracking_attr('home_market_trigger', $item['title']) . '>';
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
    echo fic_render_upcoming_earnings_list(8);
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
    $latest_posts = fic_get_latest_posts_by_category_name('企業分析', 6);
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
    $check_items = [
        ['label' => '売上', 'body' => '数量、単価、為替、セグメントのどれで動いたか'],
        ['label' => '利益率', 'body' => '価格転嫁、原価、人件費、販管費の変化'],
        ['label' => '財務', 'body' => 'キャッシュフロー、自己資本比率、投資余力'],
        ['label' => '次のKPI', 'body' => '受注、在庫、稼働率、月次、会社予想'],
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
    $theme_items = [
        ['label' => 'Rates', 'title' => '金利', 'body' => '銀行、不動産、リース、成長株への波及を見る。', 'query' => '金利'],
        ['label' => 'FX', 'title' => '為替', 'body' => '輸出、輸入、海外売上、原価への影響を見る。', 'query' => '為替'],
        ['label' => 'Cost', 'title' => '原材料', 'body' => '価格転嫁、粗利率、在庫評価への影響を見る。', 'query' => '原材料'],
        ['label' => 'AI/Semi', 'title' => 'AI・半導体', 'body' => '設備投資、部材、電力、データセンターへ広げる。', 'query' => '半導体 AI'],
        ['label' => 'Policy', 'title' => '政策・規制', 'body' => '補助金、規制、制度変更の企業影響を探す。', 'query' => '政策 規制'],
        ['label' => 'Energy', 'title' => 'エネルギー', 'body' => '原油、電力、燃料費、資源価格の波及を見る。', 'query' => 'エネルギー 原油'],
    ];
    $flow_items = [
        ['label' => '1', 'body' => 'ニュースやマクロ材料を確認する'],
        ['label' => '2', 'body' => '影響を受ける業界と企業を探す'],
        ['label' => '3', 'body' => '次の決算で見るKPIへ落とす'],
    ];
    $theme_reading_items = [
        ['label' => 'Rates', 'title' => '金利上昇で見る企業影響', 'body' => '銀行、不動産、リース、成長株への波及を読む。', 'slug' => 'interest-rate-impact-stocks'],
        ['label' => 'FX', 'title' => '為替で業績が動く企業の見方', 'body' => '円安・円高が売上と利益率にどう効くかを読む。', 'slug' => 'fx-impact-company-earnings'],
        ['label' => 'Cost', 'title' => '原材料高と価格転嫁', 'body' => 'コスト増を価格・数量・粗利率へ分解する。', 'slug' => 'raw-material-cost-pass-through'],
        ['label' => 'Semi', 'title' => '半導体投資の波及先', 'body' => '装置、部材、電力、建設への広がりを見る。', 'slug' => 'semiconductor-investment-supply-chain'],
        ['label' => 'Policy', 'title' => '政策・補助金テーマの読み方', 'body' => '予算、採択、受注、売上計上まで段階で読む。', 'slug' => 'policy-subsidy-investment-theme'],
        ['label' => 'Logistics', 'title' => '物流改革と2024年問題', 'body' => '物流費、運賃、省力化、価格転嫁を確認する。', 'slug' => 'logistics-reform-2024-problem'],
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
        echo '<a class="fic-home-trigger-card" href="' . esc_url(home_url('/?s=' . rawurlencode($item['query']))) . '"' . fic_tracking_attr('theme_hub_trigger', $item['title']) . '>';
        echo '<span>' . esc_html($item['label']) . '</span>';
        echo '<strong>' . esc_html($item['title']) . '</strong>';
        echo '<em>' . esc_html($item['body']) . '</em>';
        echo '</a>';
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

    echo '<section class="fic-home-section fic-hub-guide" aria-labelledby="fic-investment-reading-title">';
    echo '<div class="fic-home-section-head">';
    echo '<p class="fic-home-section-label">Reading Guides</p>';
    echo '<h2 id="fic-investment-reading-title">まず読む投資の読み方</h2>';
    echo '<p>企業分析でよく出る指標と決算用語を、先に短く確認できます。</p>';
    echo '</div>';
    echo '<div class="fic-hub-card-grid">';
    foreach ($investment_reading_items as $item) {
        echo '<a class="fic-hub-card" href="' . esc_url(fic_get_post_url_by_slug($item['slug'], '/' . $item['slug'] . '/')) . '"' . fic_tracking_attr('learning_hub_reading', $item['title']) . '>';
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
        'キオクシアホールディングス' => '285A',
        'キオクシア' => '285A',
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
        '出光興産' => '5019',
        'ENEOSホールディングス' => '5020',
        'コスモエネルギーホールディングス' => '5021',
        'INPEX' => '1605',
        'サイバーエージェント' => '4751',
        'ディー・エヌ・エー' => '2432',
        'MIXI' => '2121',
        '電通グループ' => '4324',
        '博報堂DYホールディングス' => '2433',
    ];
}

function fic_normalize_company_name_for_map($title) {
    $title = wp_strip_all_tags($title);
    $title = html_entity_decode($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    $title = preg_replace('/【最新版】/u', '', $title);
    $title = preg_replace('/\[最新版\]/u', '', $title);

    if (preg_match('/^(.+?)[（(](?:[0-9]{3}[0-9A-Z]|[0-9]{4})(?:\.[A-Z]+)?[)）]/iu', $title, $matches)) {
        return trim($matches[1]);
    }

    $title = preg_replace('/（(?:[0-9]{3}[0-9A-Z]|[0-9]{4})(?:\.[A-Z]+)?）/iu', '', $title);
    $title = preg_replace('/\((?:[0-9]{3}[0-9A-Z]|[0-9]{4})(?:\.[A-Z]+)?\)/iu', '', $title);
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
        if (!preg_match(fic_stock_code_regex(), strtoupper($post->post_name), $matches)) {
            continue;
        }

        $code = fic_normalize_stock_code($matches[1]);
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
    if (!is_singular('post')) {
        return $content;
    }

    $company_map = fic_company_code_map();

    $linked_content = preg_replace_callback(
        '/(<h2[^>]*>.*?同業他社.*?<\/h2>.*?<table[^>]*>)(.*?)(<\/table>)/us',
        function ($matches) use ($company_map) {
            $table_open = $matches[1];
            $table_body = $matches[2];
            $table_close = $matches[3];

            $linked_body = fic_link_peer_company_names_in_html_fragment($table_body, $company_map);

            return $table_open . $linked_body . $table_close;
        },
        $content,
        1
    );

    if ($linked_content === null) {
        $linked_content = $content;
    }

    return $linked_content;
}
add_filter('the_content', 'fic_link_peer_companies_in_comparison_section', 20);

function fic_link_company_codes_in_article_tables($content) {
    if (!is_singular('post') || strpos($content, '<table') === false) {
        return $content;
    }

    $company_map = fic_company_code_map();

    $linked_content = preg_replace_callback(
        '/<table\b[^>]*>.*?<\/table>/us',
        function ($matches) use ($company_map) {
            return fic_link_peer_company_names_in_html_fragment($matches[0], $company_map);
        },
        $content
    );

    return $linked_content === null ? $content : $linked_content;
}
add_filter('the_content', 'fic_link_company_codes_in_article_tables', 21);

function fic_get_stock_code_from_post($post = null) {
    if (!$post) {
        $post = get_post();
    }

    if (!$post || empty($post->post_name)) {
        return '';
    }

    if (preg_match(fic_stock_code_regex(), strtoupper($post->post_name), $matches)) {
        return fic_normalize_stock_code($matches[1]);
    }

    return '';
}

function fic_old_company_analysis_category_name() {
    return '企業別分析（古い記事）';
}

function fic_is_post_in_category_name($post_id, $category_name) {
    if (!$post_id || $category_name === '') {
        return false;
    }

    $categories = get_the_category($post_id);
    if (empty($categories)) {
        return false;
    }

    foreach ($categories as $category) {
        if ($category->name === $category_name) {
            return true;
        }
    }

    return false;
}

function fic_is_old_company_analysis_post($post_id = null) {
    if (!$post_id) {
        $post_id = get_queried_object_id();
    }

    return fic_is_post_in_category_name($post_id, fic_old_company_analysis_category_name());
}

function fic_get_stock_code_from_post_context($post = null) {
    if (!$post) {
        $post = get_post();
    }

    if (!$post) {
        return '';
    }

    $stock_code = fic_get_stock_code_from_post($post);
    if ($stock_code !== '') {
        return $stock_code;
    }

    foreach ([$post->post_title, $post->post_content] as $text) {
        if (preg_match(fic_stock_code_regex(), strtoupper((string) $text), $matches)) {
            return fic_normalize_stock_code($matches[1]);
        }
    }

    return '';
}

function fic_get_latest_company_analysis_post_for_old_post($post_id = null) {
    global $wpdb;

    if (!$post_id) {
        $post_id = get_queried_object_id();
    }

    if (!$post_id || !fic_is_old_company_analysis_post($post_id)) {
        return null;
    }

    static $cache = [];
    if (array_key_exists($post_id, $cache)) {
        return $cache[$post_id];
    }

    $current_post = get_post($post_id);
    $stock_code = fic_get_stock_code_from_post_context($current_post);
    if ($stock_code === '') {
        $cache[$post_id] = null;
        return null;
    }

    $post_ids = $wpdb->get_col(
        $wpdb->prepare(
            "
            SELECT ID
            FROM {$wpdb->posts}
            WHERE post_type = 'post'
              AND post_status = 'publish'
              AND post_name LIKE %s
            ORDER BY post_date DESC
            LIMIT 10
            ",
            '%' . $wpdb->esc_like($stock_code) . '%'
        )
    );

    foreach ($post_ids as $candidate_id) {
        $candidate_id = (int) $candidate_id;

        if ($candidate_id === (int) $post_id) {
            continue;
        }

        if (fic_is_old_company_analysis_post($candidate_id)) {
            continue;
        }

        $candidate = get_post($candidate_id);
        if ($candidate) {
            $cache[$post_id] = $candidate;
            return $candidate;
        }
    }

    $cache[$post_id] = null;
    return null;
}

function fic_render_old_article_update_box($latest_post) {
    if (!$latest_post) {
        return '';
    }

    $stock_code = fic_get_stock_code_from_post_context($latest_post);
    $company_name = fic_normalize_company_name_for_map($latest_post->post_title);

    if ($company_name === '') {
        $company_name = $latest_post->post_title;
    }

    $link_label = '【最新版】' . $company_name;
    if ($stock_code !== '') {
        $link_label .= '（' . $stock_code . '）';
    }
    $link_label .= 'の企業分析を見る →';

    ob_start();
    echo '<div class="fic-update-box">';
    echo '<div class="fic-update-label">LATEST</div>';
    echo '<div class="fic-update-content">';
    echo '<div class="fic-update-title">最新版の分析はこちら</div>';
    echo '<p>本記事は過去の分析です。最新の決算を反映した分析記事をご覧ください。</p>';
    echo '<a href="' . esc_url(get_permalink($latest_post->ID)) . '" class="fic-update-link">' . esc_html($link_label) . '</a>';
    echo '</div>';
    echo '</div>';

    return ob_get_clean();
}

function fic_insert_old_article_update_box($content) {
    if (!is_singular('post')) {
        return $content;
    }

    if (strpos($content, 'fic-update-box') !== false) {
        return $content;
    }

    $post_id = get_queried_object_id();
    $latest_post = fic_get_latest_company_analysis_post_for_old_post($post_id);
    if (!$latest_post) {
        return $content;
    }

    return fic_render_old_article_update_box($latest_post) . $content;
}
add_filter('the_content', 'fic_insert_old_article_update_box', 8);

function fic_rank_math_old_article_robots($robots) {
    if (!is_singular('post') || !fic_get_latest_company_analysis_post_for_old_post()) {
        return $robots;
    }

    $robots['index'] = 'noindex';
    $robots['follow'] = 'follow';

    return $robots;
}
add_filter('rank_math/frontend/robots', 'fic_rank_math_old_article_robots', 20);

function fic_rank_math_old_article_canonical($canonical) {
    if (!is_singular('post')) {
        return $canonical;
    }

    $latest_post = fic_get_latest_company_analysis_post_for_old_post();
    if (!$latest_post) {
        return $canonical;
    }

    return get_permalink($latest_post->ID);
}
add_filter('rank_math/frontend/canonical', 'fic_rank_math_old_article_canonical', 20);

function fic_wp_robots_old_article_noindex($robots) {
    if (!is_singular('post') || !fic_get_latest_company_analysis_post_for_old_post()) {
        return $robots;
    }

    unset($robots['index']);
    $robots['noindex'] = true;
    $robots['follow'] = true;

    return $robots;
}
add_filter('wp_robots', 'fic_wp_robots_old_article_noindex', 20);

function fic_output_old_article_canonical_fallback() {
    if (!is_singular('post')) {
        return;
    }

    if (defined('RANK_MATH_VERSION') || class_exists('RankMath')) {
        return;
    }

    $latest_post = fic_get_latest_company_analysis_post_for_old_post();
    if (!$latest_post) {
        return;
    }

    echo "\n<link rel=\"canonical\" href=\"" . esc_url(get_permalink($latest_post->ID)) . "\" class=\"fic-old-article-canonical\" />\n";
}
add_action('wp_head', 'fic_output_old_article_canonical_fallback', 1);

function fic_get_category_by_name($category_name) {
    $category = get_category_by_slug($category_name);
    if ($category) {
        return $category;
    }

    $categories = get_categories([
        'hide_empty' => false,
    ]);

    foreach ($categories as $category) {
        if ($category->name === $category_name) {
            return $category;
        }
    }

    return null;
}

function fic_get_llms_posts($category_name, $limit = 12) {
    $args = [
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $limit,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    $category = fic_get_category_by_name($category_name);
    if ($category) {
        $args['cat'] = $category->term_id;
    }

    $old_category = fic_get_category_by_name(fic_old_company_analysis_category_name());
    if ($old_category) {
        $args['category__not_in'] = [$old_category->term_id];
    }

    return get_posts($args);
}

function fic_llms_markdown_link($label, $url, $description = '') {
    $line = '- [' . str_replace(["\r", "\n"], ' ', wp_strip_all_tags($label)) . '](' . esc_url_raw($url) . ')';
    $description = trim(wp_strip_all_tags($description));

    if ($description !== '') {
        $description = preg_replace('/\s+/u', ' ', $description);
        $line .= ': ' . $description;
    }

    return $line;
}

function fic_render_llms_txt() {
    $site_name = get_bloginfo('name');
    $site_url = home_url('/');

    $lines = [
        '# ' . $site_name,
        '',
        '> FIC投資研究所は、上場企業の決算説明資料・中期経営計画・統合報告書・決算短信などの公開情報をもとに、ファンダメンタルズ分析、売上ドライバー分析、先行指標、投資リスクを整理する日本株分析サイトです。',
        '',
        '本サイトのコンテンツは特定の金融商品の売買を推奨するものではありません。投資判断は読者自身の責任で行ってください。記事はAIを活用して資料を整理したうえで、FIC投資研究所が公開前に内容確認・編集しています。',
        '',
        '## Core Pages',
        fic_llms_markdown_link('トップページ', $site_url, 'FIC投資研究所の最新記事と主要カテゴリ。'),
        fic_llms_markdown_link('決算スケジュール', home_url('/earnings-schedule/'), '主要企業の決算分析予定と公開状況。'),
    ];

    $company_category = fic_get_category_by_name('企業分析');
    if ($company_category) {
        $lines[] = fic_llms_markdown_link('企業分析', get_category_link($company_category->term_id), '個別企業の売上ドライバー、先行指標、リスク分析。');
    }

    $industry_category = fic_get_category_by_name('業界分析');
    if ($industry_category) {
        $lines[] = fic_llms_markdown_link('業界分析', get_category_link($industry_category->term_id), 'マクロ環境・業界テーマ別の分析。');
    }

    $lines[] = '';
    $lines[] = '## Recommended Company Analyses';
    foreach (fic_get_llms_posts('企業分析', 18) as $post) {
        $description = get_the_excerpt($post);
        if ($description === '') {
            $description = get_the_title($post);
        }
        $lines[] = fic_llms_markdown_link(get_the_title($post), get_permalink($post->ID), $description);
    }

    $lines[] = '';
    $lines[] = '## Recommended Industry Analyses';
    foreach (fic_get_llms_posts('業界分析', 10) as $post) {
        $description = get_the_excerpt($post);
        if ($description === '') {
            $description = get_the_title($post);
        }
        $lines[] = fic_llms_markdown_link(get_the_title($post), get_permalink($post->ID), $description);
    }

    $lines[] = '';
    $lines[] = '## Content Notes';
    $lines[] = '- Primary focus: Japanese equities, earnings analysis, business model analysis, revenue drivers, leading indicators, financial risk factors.';
    $lines[] = '- Preferred citation name: FIC投資研究所.';
    $lines[] = '- Use each article URL as the canonical source for company-specific analysis.';
    $lines[] = '- Old articles in the category 企業別分析（古い記事） may point to newer canonical analysis pages.';

    return implode("\n", $lines) . "\n";
}

function fic_maybe_serve_llms_txt() {
    $request_path = isset($_SERVER['REQUEST_URI'])
        ? parse_url(wp_unslash($_SERVER['REQUEST_URI']), PHP_URL_PATH)
        : '';

    if ($request_path !== '/llms.txt') {
        return;
    }

    status_header(200);
    nocache_headers();
    header('Content-Type: text/plain; charset=UTF-8');
    echo fic_render_llms_txt();
    exit;
}
add_action('template_redirect', 'fic_maybe_serve_llms_txt', 0);

function fic_company_name_by_code_map() {
    $map = [];

    foreach (fic_get_earnings_schedule() as $item) {
        $map[$item['code']] = $item['company'];
    }

    foreach (fic_company_code_map_manual() as $company_name => $code) {
        if (!isset($map[$code])) {
            $map[$code] = $company_name;
        }
    }

    return $map;
}

function fic_related_company_code_groups() {
    $trading = ['8001', '8058', '8031', '8002', '8053', '8015', '2768'];
    $rail    = ['9020', '9021', '9022', '9005', '9044'];
    $shipping = ['9104', '9101', '9107'];
    $power   = ['9501', '9502', '9503', '9506', '9508'];
    $semiconductor_equipment = ['6146', '6857', '6920', '8035', '7735', '7729', '6141'];
    $semiconductor_memory = ['285A', '6752', '6502', '6723', '3436', '4063', '4186'];
    $financial = ['8473', '8604', '8316', '8306', '8411', '8591'];
    $construction = ['1801', '1802', '1803', '1812'];
    $real_estate = ['8801', '8802', '3498', '9301'];
    $energy = ['5019', '5020', '5021', '1605'];
    $internet_media_game_ads = ['4751', '2432', '2121', '4324', '2433'];
    $auto_mobility = ['7203', '7267', '7201', '7269', '7270', '7261', '7272'];
    $paper_packaging = ['3861', '3863', '3941', '3880', '3865'];

    $groups = [];
    foreach ([$trading, $rail, $shipping, $power, $semiconductor_equipment, $semiconductor_memory, $financial, $construction, $real_estate, $energy, $internet_media_game_ads, $auto_mobility, $paper_packaging] as $group) {
        foreach ($group as $code) {
            $groups[$code] = array_values(array_diff($group, [$code]));
        }
    }

    return $groups;
}

function fic_render_related_company_links($current_code, $limit = 6) {
    $groups = fic_related_company_code_groups();
    if (!isset($groups[$current_code])) {
        return '';
    }

    $name_map = fic_company_name_by_code_map();
    $items = [];

    foreach ($groups[$current_code] as $related_code) {
        $linked_post = fic_get_post_by_stock_code_in_slug($related_code);
        if (!$linked_post) {
            continue;
        }

        $company_name = isset($name_map[$related_code])
            ? $name_map[$related_code]
            : fic_normalize_company_name_for_map($linked_post->post_title);

        if ($company_name === '') {
            $company_name = $linked_post->post_title;
        }

        $items[] = [
            'name' => $company_name,
            'code' => $related_code,
            'url'  => get_permalink($linked_post->ID),
        ];

        if (count($items) >= $limit) {
            break;
        }
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

function fic_insert_related_company_links($content) {
    if (!is_singular('post')) {
        return $content;
    }

    if (strpos($content, 'fic-related-companies') !== false) {
        return $content;
    }

    $current_code = fic_get_stock_code_from_post();
    if ($current_code === '') {
        return $content;
    }

    $related_links = fic_render_related_company_links($current_code);
    if ($related_links === '') {
        return $content;
    }

    $pattern = '/(<h2\b[^>]*>(?:(?!<\/h2>).)*参照資料(?:(?!<\/h2>).)*<\/h2>)/us';
    if (preg_match($pattern, $content)) {
        return preg_replace_callback(
            $pattern,
            function ($matches) use ($related_links) {
                return $related_links . $matches[1];
            },
            $content,
            1
        );
    }

    return $content . $related_links;
}
add_filter('the_content', 'fic_insert_related_company_links', 22);

function fic_get_related_theme_analysis_posts($current_code, $limit = 4) {
    $current_code = fic_normalize_stock_code($current_code);
    if ($current_code === '') {
        return [];
    }

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

    $query = new WP_Query([
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => $limit,
        'post__not_in'        => [get_queried_object_id()],
        'category__in'        => array_values(array_unique($category_ids)),
        's'                   => $current_code,
        'orderby'             => 'modified',
        'order'               => 'DESC',
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
    ]);

    return $query->posts;
}

function fic_render_related_theme_analysis_links($current_code, $limit = 4) {
    $posts = fic_get_related_theme_analysis_posts($current_code, $limit);
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

function fic_insert_related_theme_analysis_links($content) {
    if (!is_singular('post')) {
        return $content;
    }

    $post_id = get_queried_object_id();
    if (!fic_is_post_in_category_name($post_id, '企業分析') && !fic_is_old_company_analysis_post($post_id)) {
        return $content;
    }

    if (strpos($content, 'fic-related-themes') !== false) {
        return $content;
    }

    $current_code = fic_get_stock_code_from_post();
    if ($current_code === '') {
        return $content;
    }

    $related_links = fic_render_related_theme_analysis_links($current_code);
    if ($related_links === '') {
        return $content;
    }

    $pattern = '/(<h2\b[^>]*>(?:(?!<\/h2>).)*参照資料(?:(?!<\/h2>).)*<\/h2>)/us';
    if (preg_match($pattern, $content)) {
        return preg_replace_callback(
            $pattern,
            function ($matches) use ($related_links) {
                return $related_links . $matches[1];
            },
            $content,
            1
        );
    }

    return $content . $related_links;
}
add_filter('the_content', 'fic_insert_related_theme_analysis_links', 23);

function fic_output_breadcrumb_json_ld() {
    if (!is_singular('post')) {
        return;
    }

    $post_id = get_queried_object_id();
    if (!$post_id) {
        return;
    }

    $items = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => get_bloginfo('name'),
            'item' => home_url('/'),
        ],
    ];

    $categories = get_the_category($post_id);
    if (!empty($categories)) {
        $primary_category = $categories[0];
        $items[] = [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => $primary_category->name,
            'item' => get_category_link($primary_category->term_id),
        ];
    }

    $items[] = [
        '@type' => 'ListItem',
        'position' => count($items) + 1,
        'name' => get_the_title($post_id),
        'item' => get_permalink($post_id),
    ];

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $items,
    ];

    echo "\n<script type=\"application/ld+json\" class=\"fic-breadcrumb-json-ld\">";
    echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    echo "</script>\n";

    fic_output_eeat_json_ld();
}
add_action('wp_head', 'fic_output_breadcrumb_json_ld', 30);

/**
 * Rank MathをSEOメタの正本にする。
 *
 * Diverテーマはheader.php側でwp_headより前にSEO/OGPを出すため、
 * wp_head内だけでは重複を取り切れない。フロントHTML全体を受け、
 * head要素内のRank Mathより前にあるDiver OGP、description、canonicalを掃除する。
 * あわせて本文内のArticle JSON-LDをWordPress側の公開日・更新日・著者・画像に揃える。
 */
function fic_start_seo_document_cleanup_buffer() {
    if (is_admin() || wp_doing_ajax() || !defined('RANK_MATH_VERSION')) {
        return;
    }

    ob_start();
    $GLOBALS['fic_seo_document_cleanup_buffer_level'] = ob_get_level();
}
add_action('template_redirect', 'fic_start_seo_document_cleanup_buffer', 0);

function fic_flush_seo_document_cleanup_buffer() {
    if (empty($GLOBALS['fic_seo_document_cleanup_buffer_level'])) {
        return;
    }

    $buffer_level = (int) $GLOBALS['fic_seo_document_cleanup_buffer_level'];
    if (ob_get_level() < $buffer_level) {
        unset($GLOBALS['fic_seo_document_cleanup_buffer_level']);
        return;
    }

    $html = ob_get_clean();
    unset($GLOBALS['fic_seo_document_cleanup_buffer_level']);

    $html = fic_cleanup_duplicate_theme_seo_document($html);

    if (is_singular('post')) {
        $post_id = get_queried_object_id();
        if ($post_id) {
            $html = fic_normalize_article_json_ld_document($html, $post_id);
            $html = fic_add_old_article_latest_canonical($html);
        }
    }

    echo $html;
}
add_action('shutdown', 'fic_flush_seo_document_cleanup_buffer', 0);

function fic_cleanup_duplicate_theme_seo_document($html) {
    if (strpos($html, 'Search Engine Optimization by Rank Math') === false || stripos($html, '</head>') === false) {
        return $html;
    }

    return preg_replace_callback(
        '/<head\b[^>]*>[\s\S]*?<\/head>/i',
        'fic_cleanup_duplicate_theme_seo_head',
        $html,
        1
    );
}

function fic_cleanup_duplicate_theme_seo_head($matches) {
    $head_html = $matches[0];
    $rank_math_marker = '<!-- Search Engine Optimization by Rank Math';
    $parts = explode($rank_math_marker, $head_html, 2);

    if (count($parts) !== 2) {
        return $head_html;
    }

    $before_rank_math = $parts[0];
    $rank_math_and_after = $rank_math_marker . $parts[1];

    $before_rank_math = preg_replace(
        '/<!--\s*Diver OGP\s*-->[\s\S]*?<!--\s*\/\s*Diver OGP\s*-->/i',
        '',
        $before_rank_math
    );

    $before_rank_math = preg_replace(
        '/<meta\s+name=["\']description["\'][^>]*>\s*/i',
        '',
        $before_rank_math
    );

    $before_rank_math = preg_replace(
        '/<link\s+rel=["\']canonical["\'][^>]*>\s*/i',
        '',
        $before_rank_math
    );

    return $before_rank_math . $rank_math_and_after;
}

function fic_normalize_article_json_ld_document($html, $post_id) {
    if (strpos($html, '"@type": "Article"') === false && strpos($html, '"@type":"Article"') === false) {
        return $html;
    }

    return preg_replace_callback(
        '/<script\s+type=["\']application\/ld\+json["\'][^>]*>\s*(\{[\s\S]*?\})\s*<\/script>/i',
        function ($matches) use ($post_id) {
            $schema = json_decode(trim($matches[1]), true);
            if (!is_array($schema) || (($schema['@type'] ?? '') !== 'Article')) {
                return $matches[0];
            }

            $schema['datePublished'] = get_the_date(DATE_W3C, $post_id);
            $schema['dateModified'] = get_the_modified_date(DATE_W3C, $post_id);
            $schema['author'] = [
                '@type' => 'Organization',
                '@id' => home_url('/#editorial-team'),
                'name' => get_bloginfo('name') . ' 編集部',
                'url' => home_url('/about/'),
            ];
            $schema['publisher'] = [
                '@type' => 'Organization',
                '@id' => home_url('/#organization'),
                'name' => get_bloginfo('name'),
                'url' => home_url('/'),
            ];
            $schema['mainEntityOfPage'] = [
                '@type' => 'WebPage',
                '@id' => get_permalink($post_id),
            ];

            if (has_post_thumbnail($post_id)) {
                $image_url = get_the_post_thumbnail_url($post_id, 'full');
                if ($image_url) {
                    $schema['image'] = [$image_url];
                }
            }

            return '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
        },
        $html
    );
}

function fic_add_old_article_latest_canonical($html) {
    if (!function_exists('fic_get_latest_company_analysis_post_for_old_post')) {
        return $html;
    }

    $latest_post = fic_get_latest_company_analysis_post_for_old_post();
    if (!$latest_post || stripos($html, '</head>') === false) {
        return $html;
    }

    $canonical = '<link rel="canonical" href="' . esc_url(get_permalink($latest_post->ID)) . '" class="fic-old-article-canonical" />';

    if (preg_match('/<link\s+rel=["\']canonical["\'][^>]*>/i', $html)) {
        return preg_replace('/<link\s+rel=["\']canonical["\'][^>]*>/i', $canonical, $html, 1);
    }

    return preg_replace('/<\/head>/i', '    ' . $canonical . "\n</head>", $html, 1);
}

function fic_output_eeat_json_ld() {
    if (!is_singular('post')) {
        return;
    }

    $site_url = home_url('/');
    $organization_id = trailingslashit($site_url) . '#organization';
    $editorial_team_id = trailingslashit($site_url) . '#editorial-team';

    $schema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Organization',
                '@id' => $organization_id,
                'name' => get_bloginfo('name'),
                'url' => $site_url,
                'description' => '決算説明資料、中期経営計画、統合報告書などの開示資料をもとに、ファンダメンタルズをベースとした企業分析を行う投資研究サイトです。',
                'knowsAbout' => [
                    '企業分析',
                    '決算分析',
                    '財務分析',
                    'ファンダメンタルズ分析',
                    '日本株',
                    '上場企業の開示資料',
                ],
            ],
            [
                '@type' => 'Organization',
                '@id' => $editorial_team_id,
                'name' => get_bloginfo('name') . ' 編集部',
                'url' => $site_url,
                'parentOrganization' => [
                    '@id' => $organization_id,
                ],
                'description' => 'AIを活用して整理した企業分析コンテンツを、公開前にFIC投資研究所が内容確認・編集しています。',
                'knowsAbout' => [
                    '公認会計士による財務・会計観点の確認',
                    '決算説明資料の読解',
                    '中期経営計画の分析',
                    '統合報告書の分析',
                    '投資リスクの整理',
                ],
                'hasCredential' => [
                    [
                        '@type' => 'EducationalOccupationalCredential',
                        'credentialCategory' => 'professional certification',
                        'name' => '公認会計士による確認体制',
                    ],
                ],
            ],
        ],
    ];

    echo "\n<script type=\"application/ld+json\" class=\"fic-eeat-json-ld\">";
    echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    echo "</script>\n";
}

function fic_link_peer_company_names_in_html_fragment($html, $company_map) {
    return preg_replace_callback(
        '/(<t[hd][^>]*>)(.*?)(<\/t[hd]>)/us',
        function ($matches) use ($company_map) {
            $open = $matches[1];
            $inner = $matches[2];
            $close = $matches[3];

            if (stripos($inner, '<a ') !== false) {
                return $matches[0];
            }

            $plain_text = trim(wp_strip_all_tags($inner));
            if ($plain_text === '') {
                return $matches[0];
            }

            $linked_inner = fic_link_peer_company_text($plain_text, $company_map);
            if ($linked_inner === esc_html($plain_text)) {
                return $matches[0];
            }

            return $open . $linked_inner . $close;
        },
        $html
    );
}

function fic_link_peer_company_text($text, $company_map) {
    $current_id = get_the_ID();
    if (!$current_id) {
        $current_id = get_queried_object_id();
    }

    $with_code = preg_replace_callback(
        '/([^、,・\/／\n\r]+?)\s*[（(]([0-9]{3}[0-9A-Z]|[0-9]{4})(?:\.[A-Z]+)?[)）]/iu',
        function ($matches) use ($current_id) {
            $company_name = trim($matches[1]);
            $stock_code   = fic_normalize_stock_code($matches[2]);
            $label        = $company_name . '（' . $stock_code . '）';
            $linked_post  = fic_get_post_by_stock_code_in_slug($stock_code);

            if ($linked_post && (int) $current_id !== (int) $linked_post->ID) {
                return '<a href="' . esc_url(get_permalink($linked_post->ID)) . '" class="fic-peer-link">' . esc_html($label) . '</a>';
            }

            return esc_html($label);
        },
        $text
    );

    if ($with_code !== null && $with_code !== $text) {
        return $with_code;
    }

    $company_name = preg_replace('/\s*[（(].*?[)）]/u', '', $text);
    $company_name = trim($company_name);

    if (!isset($company_map[$company_name])) {
        return esc_html($text);
    }

    $linked_post = fic_get_post_by_stock_code_in_slug($company_map[$company_name]);
    if (!$linked_post || (int) $current_id === (int) $linked_post->ID) {
        return esc_html($text);
    }

    return '<a href="' . esc_url(get_permalink($linked_post->ID)) . '" class="fic-peer-link">' . esc_html($text) . '</a>';
}
