import fs from "node:fs";

const html = await (
  await fetch(`https://fic-investment.biz/?fic_check=${Date.now()}`, {
    headers: { "Cache-Control": "no-cache" },
  })
).text();

const checks = {
  rawShortcode: /\[fic_|\[\/fic_/.test(html),
  purposeRoutes: html.includes("Purpose Routes"),
  purposeRoutesAnchor: html.includes('id="fic-home-purpose-routes"'),
  quickNavPurpose: html.includes('href="#fic-home-purpose-routes"'),
  quickNavLinks: (html.match(/data-fic-area="home_quicknav"/g) || []).length,
  company: html.includes("Company Routes"),
  theme: html.includes("Theme Routes"),
  learning: html.includes("Learning Routes"),
  earnings: html.includes("Earnings Routes"),
  routeLinks: (html.match(/data-fic-area="home_purpose_route"/g) || []).length,
  searchChipLinks: (html.match(/data-fic-area="home_search_chip"/g) || []).length,
  policyChip: html.includes('/policy-subsidy-investment-theme/'),
  energyChip: html.includes('/energy-transition-power-investment/'),
  noSearchChipFallback: !/data-fic-area="home_search_chip"[^>]+href="[^"]*\?s=/.test(html),
  marketTriggerLinks: (html.match(/data-fic-area="home_market_trigger"/g) || []).length,
  policyTrigger: html.includes("/policy-subsidy-investment-theme/"),
  energyTrigger: html.includes("/energy-transition-power-investment/"),
  noTriggerSearchFallback: !/data-fic-area="home_market_trigger"[^>]+href="[^"]*\\?s=/.test(html),
  css: html.includes("fic-home-purpose-route-grid"),
  horizontalRisk: html.includes("width: 100vw"),
};

fs.mkdirSync("work", { recursive: true });
fs.writeFileSync("work/home-purpose-routes-production-check-2026-05-23.json", `${JSON.stringify(checks, null, 2)}\n`);
console.table([checks]);

if (
  checks.rawShortcode ||
  !checks.purposeRoutes ||
  !checks.purposeRoutesAnchor ||
  !checks.quickNavPurpose ||
  checks.quickNavLinks !== 5 ||
  !checks.company ||
  !checks.theme ||
  !checks.learning ||
  !checks.earnings ||
  checks.routeLinks !== 4 ||
  checks.searchChipLinks !== 6 ||
  !checks.policyChip ||
  !checks.energyChip ||
  !checks.noSearchChipFallback ||
  checks.marketTriggerLinks !== 6 ||
  !checks.policyTrigger ||
  !checks.energyTrigger ||
  !checks.noTriggerSearchFallback ||
  !checks.css ||
  checks.horizontalRisk
) {
  process.exit(2);
}
