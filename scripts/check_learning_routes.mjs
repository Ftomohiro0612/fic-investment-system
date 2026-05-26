import fs from "node:fs";

const html = await (
  await fetch(`https://fic-investment.biz/learn/?fic_check=${Date.now()}`, {
    headers: { "Cache-Control": "no-cache" },
  })
).text();

const checks = {
  rawShortcode: /\[fic_|\[\/fic_/.test(html),
  learningRoutes: html.includes("Learning Routes"),
  before: html.includes("決算前に予習する"),
  onDay: html.includes("発表直後に確認する"),
  deepDive: html.includes("発表後に深掘りする"),
  risk: html.includes("リスクと還元を見る"),
  routeLinks: (html.match(/data-fic-area="learning_hub_route"/g) || []).length,
  css: html.includes("fic-learning-route-grid"),
  horizontalRisk: html.includes("width: 100vw"),
};

fs.mkdirSync("work", { recursive: true });
fs.writeFileSync("work/learning-routes-production-check-2026-05-23.json", `${JSON.stringify(checks, null, 2)}\n`);
console.table([checks]);

if (
  checks.rawShortcode ||
  !checks.learningRoutes ||
  !checks.before ||
  !checks.onDay ||
  !checks.deepDive ||
  !checks.risk ||
  checks.routeLinks !== 12 ||
  !checks.css ||
  checks.horizontalRisk
) {
  process.exit(2);
}
