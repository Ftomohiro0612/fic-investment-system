import fs from "node:fs";

const pages = [
  { key: "home", url: "https://fic-investment.biz/" },
  { key: "companies", url: "https://fic-investment.biz/companies/" },
  { key: "themes", url: "https://fic-investment.biz/themes/" },
  { key: "learn", url: "https://fic-investment.biz/learn/" },
  { key: "earnings", url: "https://fic-investment.biz/earnings-schedule/" },
  { key: "category_theme_analysis", url: "https://fic-investment.biz/category/theme-analysis/" },
  { key: "category_theme_reading", url: "https://fic-investment.biz/category/theme-reading/" },
  { key: "category_investment_reading", url: "https://fic-investment.biz/category/investment-reading/" },
  { key: "article_company", url: "https://fic-investment.biz/nitori-9843-analysis/" },
  { key: "article_theme", url: "https://fic-investment.biz/construction-material-shortage-project-delay-margin-risk/" },
  { key: "article_learning", url: "https://fic-investment.biz/kessan-tanshin-reading-guide/" },
  { key: "article_theme_reading", url: "https://fic-investment.biz/interest-rate-impact-stocks/" },
  { key: "search_semiconductor", url: "https://fic-investment.biz/?s=%E5%8D%8A%E5%B0%8E%E4%BD%93" },
];

function countByArea(html) {
  const counts = {};
  const staticHtml = html.replace(/<script[\s\S]*?<\/script>/gi, "");
  for (const match of staticHtml.matchAll(/data-fic-area="([^"]+)"/g)) {
    counts[match[1]] = (counts[match[1]] || 0) + 1;
  }
  return counts;
}

function labelsByArea(html) {
  const labels = {};
  const staticHtml = html.replace(/<script[\s\S]*?<\/script>/gi, "");
  for (const match of staticHtml.matchAll(/data-fic-area="([^"]+)"\s+data-fic-label="([^"]*)"/g)) {
    const area = match[1];
    labels[area] = labels[area] || new Set();
    labels[area].add(match[2]);
  }

  return Object.fromEntries(Object.entries(labels).map(([area, set]) => [area, [...set].slice(0, 8)]));
}

function dynamicAreaHints(html) {
  const hints = [];
  for (const area of ["category_archive_guide", "search_assist", "search_assist_hub", "mobile_purpose_menu", "mobile_purpose_menu_category"]) {
    if (html.includes(area)) {
      hints.push(area);
    }
  }
  return hints;
}

function csvEscape(value) {
  return `"${String(value ?? "").replace(/"/g, '""')}"`;
}

const rows = [];
const areaRows = [];

for (const page of pages) {
  const separator = page.url.includes("?") ? "&" : "?";
  const response = await fetch(`${page.url}${separator}fic_measurement_audit=${Date.now()}`, {
    headers: { "Cache-Control": "no-cache" },
  });
  const html = await response.text();
  const counts = countByArea(html);
  const labels = labelsByArea(html);
  const dynamicHints = dynamicAreaHints(html);
  const total = Object.values(counts).reduce((sum, count) => sum + count, 0);

  const pageRow = {
    key: page.key,
    url: page.url,
    status: response.status,
    totalTrackedLinks: total,
    areaCount: Object.keys(counts).length,
    hasMeasurementScript: html.includes("fic-navigation-measurement"),
    hasRawShortcode: /\[fic_|\[\/fic_/.test(html),
    dynamicAreaHints: dynamicHints,
    areas: counts,
    sampleLabels: labels,
  };
  rows.push(pageRow);

  for (const [area, count] of Object.entries(counts).sort((a, b) => a[0].localeCompare(b[0]))) {
    areaRows.push({
      page: page.key,
      url: page.url,
      area,
      count,
      sampleLabels: (labels[area] || []).join(" / "),
    });
  }
}

const totalsByArea = {};
for (const row of areaRows) {
  totalsByArea[row.area] = (totalsByArea[row.area] || 0) + row.count;
}

const report = {
  checkedAt: new Date().toISOString(),
  pages: rows,
  totalsByArea: Object.fromEntries(Object.entries(totalsByArea).sort((a, b) => b[1] - a[1] || a[0].localeCompare(b[0]))),
};

fs.mkdirSync("work", { recursive: true });
fs.writeFileSync("work/fic-measurement-coverage.json", `${JSON.stringify(report, null, 2)}\n`);

const csv = [
  ["page", "url", "area", "count", "sampleLabels"].map(csvEscape).join(","),
  ...areaRows.map((row) => [row.page, row.url, row.area, row.count, row.sampleLabels].map(csvEscape).join(",")),
].join("\n") + "\n";
fs.writeFileSync("work/fic-measurement-coverage.csv", csv);

const markdown = [
  "# FIC Measurement Coverage",
  "",
  `Checked: ${report.checkedAt}`,
  "",
  "## Page Summary",
  "",
  "| Page | Tracked links | Area count | Measurement script | Raw shortcode |",
  "| --- | ---: | ---: | --- | --- |",
  ...rows.map((row) => `| ${row.key} | ${row.totalTrackedLinks} | ${row.areaCount} | ${row.hasMeasurementScript ? "yes" : "no"} | ${row.hasRawShortcode ? "yes" : "no"} |`),
  "",
  "## Dynamic Area Hints",
  "",
  "These areas are inserted by production JavaScript and are detected from script references rather than static link attributes.",
  "",
  "| Page | Dynamic areas |",
  "| --- | --- |",
  ...rows
    .filter((row) => row.dynamicAreaHints.length)
    .map((row) => `| ${row.key} | ${row.dynamicAreaHints.join(", ")} |`),
  "",
  "## Area Totals",
  "",
  "| Area | Count |",
  "| --- | ---: |",
  ...Object.entries(report.totalsByArea).map(([area, count]) => `| ${area} | ${count} |`),
  "",
].join("\n");
fs.writeFileSync("work/fic-measurement-coverage.md", markdown);

console.log(JSON.stringify({
  pages: rows.length,
  areas: Object.keys(report.totalsByArea).length,
  totalTrackedLinks: Object.values(totalsByArea).reduce((sum, count) => sum + count, 0),
  outputs: [
    "work/fic-measurement-coverage.json",
    "work/fic-measurement-coverage.csv",
    "work/fic-measurement-coverage.md",
  ],
}, null, 2));
