import fs from "node:fs";

const html = await (
  await fetch(`https://fic-investment.biz/earnings-schedule/?fic_check=${Date.now()}`, {
    headers: { "Cache-Control": "no-cache" },
  })
).text();

const checks = {
  rawShortcode: /\[fic_|\[\/fic_/.test(html),
  earningsRoutes: html.includes("Earnings Routes"),
  before: html.includes("決算前に予習する"),
  onDay: html.includes("発表直後に見る"),
  after: html.includes("発表後に深掘りする"),
  routeLinks: (html.match(/data-fic-area="earnings_guide_route"/g) || []).length,
  themeLens: html.includes("Theme Lens"),
  themeLinks: (html.match(/data-fic-area="earnings_guide_theme"/g) || []).length,
  companySearch: html.includes("fic-earnings-company-search"),
  companyLinks: (html.match(/data-fic-area="earnings_guide_company"/g) || []).length,
};

fs.mkdirSync("work", { recursive: true });
fs.writeFileSync("work/earnings-routes-production-check-2026-05-23.json", `${JSON.stringify(checks, null, 2)}\n`);
console.table([checks]);
