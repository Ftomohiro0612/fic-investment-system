import fs from "node:fs";

const html = await (
  await fetch(`https://fic-investment.biz/themes/?fic_check=${Date.now()}`, {
    headers: { "Cache-Control": "no-cache" },
  })
).text();

const text = html
  .replace(/<script[\s\S]*?<\/script>/g, "")
  .replace(/<style[\s\S]*?<\/style>/g, "")
  .replace(/<[^>]+>/g, " ")
  .replace(/\s+/g, " ");

const checks = {
  rawShortcode: /\[fic_|\[\/fic_/.test(html),
  themeRoutes: html.includes("Theme Routes"),
  clusterLinks: (html.match(/data-fic-area="theme_hub_cluster"/g) || []).length,
  macro: html.includes("金利・為替"),
  cost: html.includes("原材料・エネルギー・物流"),
  investment: html.includes("半導体・政策・防衛"),
  demand: html.includes("消費・人手不足・インバウンド"),
  theme34: text.includes("34 本のテーマ記事"),
  readableClusterChips:
    html.includes(".fic-hub-card .fic-home-search-chips a") &&
    html.includes("color: #1f1f23 !important;"),
};

fs.mkdirSync("work", { recursive: true });
fs.writeFileSync("work/theme-cluster-production-check-2026-05-23.json", `${JSON.stringify(checks, null, 2)}\n`);
console.table([checks]);
