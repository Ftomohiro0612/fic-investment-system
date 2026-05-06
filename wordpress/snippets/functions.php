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

function fic_get_stock_code_from_post($post = null) {
    if (!$post) {
        $post = get_post();
    }

    if (!$post || empty($post->post_name)) {
        return '';
    }

    if (preg_match('/([0-9]{4})/', $post->post_name, $matches)) {
        return $matches[1];
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
        if (preg_match('/([0-9]{4})/u', (string) $text, $matches)) {
            return $matches[1];
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
    $financial = ['8473', '8604', '8316', '8306', '8411', '8591'];
    $construction = ['1801', '1802', '1803', '1812'];
    $real_estate = ['8801', '8802', '3498', '9301'];

    $groups = [];
    foreach ([$trading, $rail, $shipping, $power, $semiconductor_equipment, $financial, $construction, $real_estate] as $group) {
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
 * Diverテーマ側のSEO/OGP出力とRank Mathの出力が重複すると、
 * description、canonical、OGP、Twitter Cardが二重に出る。
 * テーマ更新で関数名が変わっても壊れにくいよう、wp_head内の出力を
 * Rank Mathブロック直前で限定的に掃除する。
 */
function fic_start_rank_math_head_cleanup_buffer() {
    if (is_admin() || !defined('RANK_MATH_VERSION')) {
        return;
    }

    ob_start('fic_cleanup_duplicate_theme_seo_head');
    $GLOBALS['fic_rank_math_head_cleanup_buffer_level'] = ob_get_level();
}
add_action('wp_head', 'fic_start_rank_math_head_cleanup_buffer', -9999);

function fic_flush_rank_math_head_cleanup_buffer() {
    if (empty($GLOBALS['fic_rank_math_head_cleanup_buffer_level'])) {
        return;
    }

    $buffer_level = (int) $GLOBALS['fic_rank_math_head_cleanup_buffer_level'];
    if (ob_get_level() >= $buffer_level) {
        ob_end_flush();
    }

    unset($GLOBALS['fic_rank_math_head_cleanup_buffer_level']);
}
add_action('wp_head', 'fic_flush_rank_math_head_cleanup_buffer', 9999);

function fic_cleanup_duplicate_theme_seo_head($head_html) {
    if (strpos($head_html, 'Search Engine Optimization by Rank Math') === false) {
        return $head_html;
    }

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
        '/([^、,・\/／\n\r]+?)\s*[（(]([0-9]{4})[)）]/u',
        function ($matches) use ($current_id) {
            $company_name = trim($matches[1]);
            $stock_code   = trim($matches[2]);
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
