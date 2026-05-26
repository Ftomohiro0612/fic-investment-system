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
];

const rows = [];

for (const url of routes) {
  const checkedUrl = `${url}${url.includes("?") ? "&" : "?"}fic_check=${Date.now()}`;
  const response = await fetch(checkedUrl, {
    headers: {
      "Cache-Control": "no-cache",
    },
  });
  const html = await response.text();
  const text = html
    .replace(/<script[\s\S]*?<\/script>/g, "")
    .replace(/<style[\s\S]*?<\/style>/g, "")
    .replace(/<[^>]+>/g, " ")
    .replace(/\s+/g, " ")
    .trim();

  rows.push({
    url,
    status: response.status,
    rawShortcode: /\[fic_|\[\/fic_/.test(html),
    hasTheme34: text.includes("34 本のテーマ記事"),
    hasTheme23: text.includes("テーマ分析 23"),
    contextCount: (html.match(/この分析を読む補助線/g) || []).length,
    hasBridge: html.includes("fic-category-bridge"),
    hasHorizontalRisk: html.includes("width: 100vw"),
  });
}

fs.mkdirSync("work", { recursive: true });
fs.writeFileSync("work/post-count-category-regression-2026-05-23.json", `${JSON.stringify(rows, null, 2)}\n`);
console.table(rows);
