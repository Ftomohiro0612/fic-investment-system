import fs from "node:fs";

const pages = {
  themes: `https://fic-investment.biz/themes/?fic_check=${Date.now()}`,
  earnings: `https://fic-investment.biz/earnings-schedule/?fic_check=${Date.now()}`,
};

const themeTargets = [
  "interest-rate-impact-stocks",
  "fx-impact-company-earnings",
  "raw-material-cost-pass-through",
  "semiconductor-investment-supply-chain",
  "policy-subsidy-investment-theme",
  "energy-transition-power-investment",
  "logistics-reform-2024-problem",
  "inbound-demand-company-impact",
];

const earningsTargets = [
  "fic-earnings-guide-company",
  "fic-earnings-company-search",
  "kessan-tanshin-reading-guide",
  "nitori-9843-analysis",
  "mizuho-fg-8411-analysis",
  "eneos-holdings-5020-analysis",
  "honda-7267-analysis",
  "screen-holdings-7735-analysis",
  "daikin-6367-analysis",
];

const rows = [];

const themeHtml = await (await fetch(pages.themes, { headers: { "Cache-Control": "no-cache" } })).text();
const themeText = themeHtml
  .replace(/<script[\s\S]*?<\/script>/g, "")
  .replace(/<style[\s\S]*?<\/style>/g, "")
  .replace(/<[^>]+>/g, " ")
  .replace(/\s+/g, " ");
rows.push({
  page: "themes",
  rawShortcode: /\[fic_|\[\/fic_/.test(themeHtml),
  theme34: themeText.includes("34 本のテーマ記事"),
  energyChip: themeHtml.includes("energy-transition-power-investment"),
  directThemeLinks: themeTargets.filter((target) => themeHtml.includes(`/${target}/`)).length,
  hasSearchFallback: themeHtml.includes("/?s="),
});

const earningsHtml = await (await fetch(pages.earnings, { headers: { "Cache-Control": "no-cache" } })).text();
rows.push({
  page: "earnings",
  rawShortcode: /\[fic_|\[\/fic_/.test(earningsHtml),
  companySearch: earningsHtml.includes("fic-earnings-company-search"),
  companyTargets: earningsTargets.filter((target) => earningsHtml.includes(target)).length,
  trackedCompanyLinks: (earningsHtml.match(/data-fic-area="earnings_guide_company"/g) || []).length,
  trackedSearch: earningsHtml.includes('data-fic-area="earnings_guide_search"'),
});

fs.mkdirSync("work", { recursive: true });
fs.writeFileSync("work/theme-earnings-production-check-2026-05-23.json", `${JSON.stringify(rows, null, 2)}\n`);
console.table(rows);
