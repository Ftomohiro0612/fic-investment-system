import fs from "node:fs";

const reportPath = process.argv[2] || "work/ga-gsc-fic-report.json";
const outputPath = process.argv[3] || "work/ga-gsc-first-readout.md";

function readJson(path) {
  if (!fs.existsSync(path)) {
    return null;
  }

  return JSON.parse(fs.readFileSync(path, "utf8"));
}

function numberValue(value) {
  const parsed = Number(value);
  return Number.isFinite(parsed) ? parsed : 0;
}

function formatNumber(value, digits = 0) {
  return new Intl.NumberFormat("ja-JP", {
    maximumFractionDigits: digits,
    minimumFractionDigits: digits,
  }).format(numberValue(value));
}

function formatPercent(value) {
  return `${formatNumber(numberValue(value) * 100, 2)}%`;
}

function mdTable(headers, rows) {
  if (!rows.length) {
    return "_データなし_";
  }

  return [
    `| ${headers.join(" | ")} |`,
    `| ${headers.map(() => "---").join(" | ")} |`,
    ...rows.map((row) => `| ${row.join(" | ")} |`),
  ].join("\n");
}

function topRows(rows, metric, limit = 10) {
  return [...(rows || [])]
    .sort((a, b) => numberValue(b[metric]) - numberValue(a[metric]))
    .slice(0, limit);
}

function findRows(rows, predicate) {
  return (rows || []).filter(predicate);
}

const report = readJson(reportPath);
if (!report) {
  console.error(`Report not found: ${reportPath}`);
  process.exit(1);
}

const gaPages = report.analytics?.reports?.pages?.rows || [];
const gaEvents = report.analytics?.reports?.events?.rows || [];
const gaSources = report.analytics?.reports?.sources?.rows || [];
const gscQueries = report.searchConsole?.reports?.queries || [];
const gscPages = report.searchConsole?.reports?.pages || [];

const ficEventRows = findRows(gaEvents, (row) => /^fic_/.test(row.eventName || ""));
const navigationEvent = gaEvents.find((row) => row.eventName === "fic_navigation_click");
const searchEvent = gaEvents.find((row) => row.eventName === "fic_search_submit");
const hubPages = findRows(gaPages, (row) => /^\/(companies|themes|learn|earnings-schedule)\/?$/.test(row.pagePath || ""));
const categoryPages = findRows(gaPages, (row) => /^\/category\//.test(row.pagePath || ""));
const articlePages = findRows(gaPages, (row) => !/^\/($|companies|themes|learn|earnings-schedule|category)/.test(row.pagePath || ""));

const lines = [
  "# FIC GA/GSC First Readout",
  "",
  `Generated: ${new Date().toISOString()}`,
  `Date range: ${report.dateRange?.startDate || "-"} to ${report.dateRange?.endDate || "-"}`,
  "",
  "## Access Status",
  "",
  `- Search Console: ${report.searchConsole?.ok ? `OK (${report.searchConsole.selectedSite})` : "not available"}`,
  `- GA4: ${report.analytics?.ok ? `OK (property ${report.analytics.propertyId})` : "not available"}`,
  "",
  "## Executive Checks",
  "",
  `- GA4 page rows: ${gaPages.length}`,
  `- GA4 event rows: ${gaEvents.length}`,
  `- GSC query rows: ${gscQueries.length}`,
  `- GSC page rows: ${gscPages.length}`,
  `- fic_navigation_click: ${navigationEvent ? formatNumber(navigationEvent.eventCount) : "not found"}`,
  `- fic_search_submit: ${searchEvent ? formatNumber(searchEvent.eventCount) : "not found"}`,
  "",
  "## Top GA4 Pages",
  "",
  mdTable(
    ["Page", "Views", "Users"],
    topRows(gaPages, "screenPageViews", 12).map((row) => [
      row.pagePath || "",
      formatNumber(row.screenPageViews),
      formatNumber(row.activeUsers),
    ]),
  ),
  "",
  "## Hub / Category / Article Split",
  "",
  mdTable(
    ["Group", "Rows", "Views", "Users"],
    [
      ["Hubs", hubPages.length, formatNumber(hubPages.reduce((sum, row) => sum + numberValue(row.screenPageViews), 0)), formatNumber(hubPages.reduce((sum, row) => sum + numberValue(row.activeUsers), 0))],
      ["Categories", categoryPages.length, formatNumber(categoryPages.reduce((sum, row) => sum + numberValue(row.screenPageViews), 0)), formatNumber(categoryPages.reduce((sum, row) => sum + numberValue(row.activeUsers), 0))],
      ["Articles/Other", articlePages.length, formatNumber(articlePages.reduce((sum, row) => sum + numberValue(row.screenPageViews), 0)), formatNumber(articlePages.reduce((sum, row) => sum + numberValue(row.activeUsers), 0))],
    ],
  ),
  "",
  "## FIC Events",
  "",
  mdTable(
    ["Event", "Count"],
    topRows(ficEventRows, "eventCount", 20).map((row) => [
      row.eventName || "",
      formatNumber(row.eventCount),
    ]),
  ),
  "",
  "## Traffic Channels",
  "",
  mdTable(
    ["Channel", "Sessions", "Users"],
    topRows(gaSources, "sessions", 12).map((row) => [
      row.sessionDefaultChannelGroup || "",
      formatNumber(row.sessions),
      formatNumber(row.activeUsers),
    ]),
  ),
  "",
  "## Search Console Queries",
  "",
  mdTable(
    ["Query", "Clicks", "Impressions", "CTR", "Position"],
    topRows(gscQueries, "clicks", 15).map((row) => [
      row.query || "",
      formatNumber(row.clicks),
      formatNumber(row.impressions),
      formatPercent(row.ctr),
      formatNumber(row.position, 1),
    ]),
  ),
  "",
  "## Search Console Pages",
  "",
  mdTable(
    ["Page", "Clicks", "Impressions", "CTR", "Position"],
    topRows(gscPages, "clicks", 15).map((row) => [
      row.page || "",
      formatNumber(row.clicks),
      formatNumber(row.impressions),
      formatPercent(row.ctr),
      formatNumber(row.position, 1),
    ]),
  ),
  "",
  "## Interpretation Prompts",
  "",
  "- If hubs have low views but articles are strong, strengthen article-bottom hub links and header labels.",
  "- If `fic_navigation_click` is missing, confirm GA4/GTM accepts custom events from the production tag.",
  "- If `fic_search_submit` is low, make search prompts clearer on the top page and hubs.",
  "- If category pages get traffic, compare `category_archive_guide` clicks against article-card clicks.",
  "- If GSC impressions are high but CTR is low, revise titles/meta for the top affected pages.",
  "",
].join("\n");

fs.mkdirSync("work", { recursive: true });
fs.writeFileSync(outputPath, lines);

console.log(JSON.stringify({
  input: reportPath,
  output: outputPath,
  gaPages: gaPages.length,
  gaEvents: gaEvents.length,
  gscQueries: gscQueries.length,
  gscPages: gscPages.length,
}, null, 2));
