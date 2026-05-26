import fs from "node:fs";

const html = await (
  await fetch(`https://fic-investment.biz/companies/?fic_check=${Date.now()}`, {
    headers: { "Cache-Control": "no-cache" },
  })
).text();

const checks = {
  rawShortcode: /\[fic_|\[\/fic_/.test(html),
  companyRoutes: html.includes("Company Routes"),
  finance: html.includes("銀行・金融"),
  cost: html.includes("資源・エネルギー・素材"),
  demand: html.includes("小売・消費・人材"),
  investment: html.includes("半導体・製造装置・設備投資"),
  mobility: html.includes("自動車・重工"),
  routeLinks: (html.match(/data-fic-area="company_hub_route"/g) || []).length,
  css: html.includes("fic-company-route-grid"),
  horizontalRisk: html.includes("width: 100vw"),
};

fs.mkdirSync("work", { recursive: true });
fs.writeFileSync("work/company-routes-production-check-2026-05-23.json", `${JSON.stringify(checks, null, 2)}\n`);
console.table([checks]);

if (
  checks.rawShortcode ||
  !checks.companyRoutes ||
  !checks.finance ||
  !checks.cost ||
  !checks.demand ||
  !checks.investment ||
  !checks.mobility ||
  checks.routeLinks !== 13 ||
  !checks.css ||
  checks.horizontalRisk
) {
  process.exit(2);
}
