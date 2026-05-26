import fs from "node:fs";

const routes = [
  "https://fic-investment.biz/",
  "https://fic-investment.biz/companies/",
  "https://fic-investment.biz/themes/",
  "https://fic-investment.biz/learn/",
  "https://fic-investment.biz/earnings-schedule/",
  "https://fic-investment.biz/category/theme-analysis/",
  "https://fic-investment.biz/nitori-9843-analysis/",
  "https://fic-investment.biz/construction-material-shortage-project-delay-margin-risk/",
  "https://fic-investment.biz/kessan-tanshin-reading-guide/",
  "https://fic-investment.biz/interest-rate-impact-stocks/",
];

const routeRows = [];

for (const url of routes) {
  const html = await (
    await fetch(`${url}${url.includes("?") ? "&" : "?"}fic_check=${Date.now()}`, {
      headers: { "Cache-Control": "no-cache" },
    })
  ).text();
  const text = html
    .replace(/<script[\s\S]*?<\/script>/g, "")
    .replace(/<style[\s\S]*?<\/style>/g, "")
    .replace(/<[^>]+>/g, " ")
    .replace(/\s+/g, " ");

  routeRows.push({
    url,
    statusOk: html.includes("<html") || html.includes("<!DOCTYPE html"),
    rawShortcode: /\[fic_|\[\/fic_/.test(html),
    homePurposeRoutes: html.includes("Purpose Routes"),
    homeQuickNavPurpose: html.includes('href="#fic-home-purpose-routes"'),
    homeQuickNavLinks: (html.match(/data-fic-area="home_quicknav"/g) || []).length,
    homePurposeRouteLinks: (html.match(/data-fic-area="home_purpose_route"/g) || []).length,
    homeSearchChipLinks: (html.match(/data-fic-area="home_search_chip"/g) || []).length,
    homeDirectSearchChips: !/data-fic-area="home_search_chip"[^>]+href="[^"]*\?s=/.test(html),
    homeMarketTriggerLinks: (html.match(/data-fic-area="home_market_trigger"/g) || []).length,
    homeDirectMarketTriggers: !/data-fic-area="home_market_trigger"[^>]+href="[^"]*\?s=/.test(html),
    companyRoutes: html.includes("Company Routes"),
    companyRouteLinks: (html.match(/data-fic-area="company_hub_route"/g) || []).length,
    theme34: text.includes("34 本のテーマ記事"),
    themeRoutes: html.includes("Theme Routes"),
    themeClusterLinks: (html.match(/data-fic-area="theme_hub_cluster"/g) || []).length,
    learningRoutes: html.includes("Learning Routes"),
    learningRouteLinks: (html.match(/data-fic-area="learning_hub_route"/g) || []).length,
    earningsRoutes: html.includes("Earnings Routes"),
    earningsRouteLinks: (html.match(/data-fic-area="earnings_guide_route"/g) || []).length,
    earningsThemeLens: html.includes("Theme Lens"),
    earningsThemeLinks: (html.match(/data-fic-area="earnings_guide_theme"/g) || []).length,
    companySearch: html.includes("fic-earnings-company-search"),
    contextCount: (html.match(/この分析を読む補助線/g) || []).length,
    bridge: (html.match(/<section class="fic-category-bridge"/g) || []).length,
    related: (html.match(/<section class="fic-category-related"/g) || []).length,
    relatedCards: (html.match(/<a class="fic-category-related-card"/g) || []).length,
    categoryArchiveGuideJs: html.includes("fic-category-archive-guide-js"),
    categoryArchiveGuideCss: html.includes(".fic-category-archive-guide"),
    categoryArchiveGuideLinks: (html.match(/category_archive_guide/g) || []).length,
    horizontalRisk: html.includes("width: 100vw"),
  });
}

const secret = JSON.parse(fs.readFileSync("C:/Users/tomo-/.codex/.sandbox-secrets/fic-wp.json", "utf8"));
const site = secret.siteUrl.replace(/\/$/, "");
const auth = Buffer.from(`${secret.username}:${secret.applicationPassword}`).toString("base64");
const headers = { Authorization: `Basic ${auth}` };

const snippetMap = {
  27: "wordpress/snippets/fic-home-page-mvp.php",
  28: "wordpress/snippets/fic-hub-pages.php",
  30: "wordpress/snippets/fic-category-bridge-links.php",
  31: "wordpress/snippets/fic-navigation-measurement.php",
  32: "wordpress/snippets/fic-earnings-page-guide.php",
};

const snippetRows = [];
for (const [id, file] of Object.entries(snippetMap)) {
  const snippet = await (await fetch(`${site}/wp-json/code-snippets/v1/snippets/${id}`, { headers })).json();
  const local = fs.readFileSync(file, "utf8").replace(/^\uFEFF/, "").replace(/^<\?php\s*/, "");
  const prod = (snippet.code || "").replace(/^\uFEFF/, "").replace(/^<\?php\s*/, "");
  snippetRows.push({
    id: Number(id),
    name: snippet.name,
    active: snippet.active,
    scope: snippet.scope,
    match: local === prod,
    localLength: local.length,
    prodLength: prod.length,
  });
}

const cssSnippet = await (await fetch(`${site}/wp-json/code-snippets/v1/snippets/29`, { headers })).json();
const localCss = fs.readFileSync("wordpress/css/fic-home-page-mvp.css", "utf8").replace(/^\uFEFF/, "").trim();
const prodCssMatch = (cssSnippet.code || "").match(/<style id="fic-home-page-mvp-css">\n([\s\S]*?)\n<\/style>/);
const prodCss = prodCssMatch ? prodCssMatch[1].trim() : "";
const cssSnippetRow = {
  id: 29,
  name: cssSnippet.name,
  active: cssSnippet.active,
  scope: cssSnippet.scope,
  match: localCss === prodCss,
  localLength: localCss.length,
  prodLength: prodCss.length,
  readableClusterChips:
    prodCss.includes(".fic-hub-card .fic-home-search-chips a") &&
    prodCss.includes("color: #1f1f23 !important;"),
};

const result = {
  checkedAt: new Date().toISOString(),
  routes: routeRows,
  snippets: snippetRows,
  cssSnippet: cssSnippetRow,
};

fs.mkdirSync("work", { recursive: true });
fs.writeFileSync("work/post-theme-earnings-regression-2026-05-24.json", `${JSON.stringify(result, null, 2)}\n`);

console.log("Routes");
console.table(routeRows);
console.log("Snippets");
console.table(snippetRows);
console.log("CSS Snippet");
console.table([cssSnippetRow]);

const badRoute = routeRows.some((row) => !row.statusOk || row.rawShortcode || row.horizontalRisk);
const badSnippet = snippetRows.some((row) => !row.active || !row.match);
const badCssSnippet = !cssSnippetRow.active || !cssSnippetRow.match || !cssSnippetRow.readableClusterChips;
const missingHomePurposeRoutes = !routeRows.find((row) => row.url === "https://fic-investment.biz/")?.homePurposeRoutes;
const missingHomeQuickNavPurpose = !routeRows.find((row) => row.url === "https://fic-investment.biz/")?.homeQuickNavPurpose;
const missingHomeDirectSearchChips = !routeRows.find((row) => row.url === "https://fic-investment.biz/")?.homeDirectSearchChips;
const missingHomeDirectMarketTriggers = !routeRows.find((row) => row.url === "https://fic-investment.biz/")?.homeDirectMarketTriggers;
const missingCompanyRoutes = !routeRows.find((row) => row.url.endsWith("/companies/"))?.companyRoutes;
const missingThemeRoutes = !routeRows.find((row) => row.url.endsWith("/themes/"))?.themeRoutes;
const missingLearningRoutes = !routeRows.find((row) => row.url.endsWith("/learn/"))?.learningRoutes;
const missingEarningsRoutes = !routeRows.find((row) => row.url.endsWith("/earnings-schedule/"))?.earningsRoutes;
const missingEarningsThemeLens = !routeRows.find((row) => row.url.endsWith("/earnings-schedule/"))?.earningsThemeLens;
const articleCheckUrls = new Set([
  "https://fic-investment.biz/nitori-9843-analysis/",
  "https://fic-investment.biz/construction-material-shortage-project-delay-margin-risk/",
  "https://fic-investment.biz/kessan-tanshin-reading-guide/",
  "https://fic-investment.biz/interest-rate-impact-stocks/",
]);
const articleRows = routeRows.filter((row) => articleCheckUrls.has(row.url));
const missingArticleRelated = articleRows.some((row) => row.related !== 1 || row.relatedCards < 1);
const categoryArchiveRows = routeRows.filter((row) => row.url.includes("/category/theme-analysis/"));
const missingCategoryArchiveGuide = categoryArchiveRows.some((row) => !row.categoryArchiveGuideJs || !row.categoryArchiveGuideCss || row.categoryArchiveGuideLinks < 3);

if (badRoute || badSnippet || badCssSnippet || missingHomePurposeRoutes || missingHomeQuickNavPurpose || missingHomeDirectSearchChips || missingHomeDirectMarketTriggers || missingCompanyRoutes || missingThemeRoutes || missingLearningRoutes || missingEarningsRoutes || missingEarningsThemeLens || missingArticleRelated || missingCategoryArchiveGuide) {
  process.exit(2);
}
