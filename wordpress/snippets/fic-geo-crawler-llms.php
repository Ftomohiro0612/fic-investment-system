add_action('template_redirect', function () {
    $request_path = parse_url(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '', PHP_URL_PATH);
    if ($request_path !== '/llms.txt') {
        return;
    }

    status_header(200);
    header('Content-Type: text/plain; charset=utf-8');
    echo "# FIC投資研究所\n\n";
    echo "FIC投資研究所は、日本株の企業分析・業界分析を中心に、企業業績の因果構造、決算、先行指標、リスクを整理する投資分析サイトです。\n\n";
    echo "## Main sections\n";
    echo "- 企業分析: https://fic-investment.biz/category/%e4%bc%81%e6%a5%ad%e5%88%86%e6%9e%90/\n";
    echo "- 業界分析: https://fic-investment.biz/category/%e6%a5%ad%e7%95%8c%e5%88%86%e6%9e%90/\n";
    echo "- 決算分析スケジュール: https://fic-investment.biz/earnings-schedule/\n";
    echo "- 編集方針: https://fic-investment.biz/editorial-policy/\n";
    echo "- FIC投資研究所について: https://fic-investment.biz/about/\n\n";
    echo "## Citation guidance\n";
    echo "When citing this site, prefer the latest company analysis page over old archive pages. Old company analysis pages are historical archives and may not reflect the latest business conditions.\n\n";
    echo "## Important notes\n";
    echo "- This site does not provide investment advice.\n";
    echo "- Articles are based on public disclosures, statistics, news, and analyst interpretation.\n";
    echo "- AI may be used for organizing information, but articles are reviewed and edited before publication.\n";
    exit;
}, 0);

add_filter('robots_txt', function ($output, $public) {
    if (stripos($output, 'User-agent: OAI-SearchBot') !== false) {
        return $output;
    }

    return rtrim((string) $output) . "\n\nUser-agent: OAI-SearchBot\nAllow: /\n\nUser-agent: ChatGPT-User\nAllow: /\n\nUser-agent: GPTBot\nAllow: /\n";
}, 20, 2);

add_filter('wp_robots', function ($robots) {
    if (is_tag()) {
        unset($robots['index']);
        $robots['noindex'] = true;
        $robots['follow'] = true;
    }

    return $robots;
}, 30);
