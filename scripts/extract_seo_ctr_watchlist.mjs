#!/usr/bin/env node
import fs from "node:fs";

const inputPath = process.argv[2] || "work/ga-gsc-fic-report.json";
const outputPath = process.argv[3] || "work/seo-ctr-watchlist-latest.csv";

const watchPaths = [
  "/kioxia-holdings-285a-analysis/",
  "/oriental-land-4661-analysis/",
  "/china-semiconductor-self-sufficiency-japan-supply-chain-impact/",
  "/minervini-investing-strategies/",
  "/nissan-rare-earth-reduction-ev-motor-supply-chain-impact/",
  "/mitsubishi-warehouse-9301-analysis/",
  "/nippon-steel-5401-analysis/",
  "/mtg-7806-analysis/",
  "/jafco-8595-analysis/",
  "/code-6920/",
  "/code-6779/",
  "/code-6754/",
  "/code-6141/",
  "/code-4369/",
  "/code-7033/",
  "/code-8253/",
];

const report = JSON.parse(fs.readFileSync(inputPath, "utf8"));
const pageRows = report.searchConsole?.reports?.pages || [];
const rowByPath = new Map();

for (const row of pageRows) {
  try {
    rowByPath.set(new URL(row.page).pathname, row);
  } catch {
    // Ignore malformed page rows from external input.
  }
}

const escapeCsv = (value) => {
  const text = String(value ?? "");
  return /[",\n]/.test(text) ? `"${text.replace(/"/g, '""')}"` : text;
};

const lines = [
  ["path", "clicks", "impressions", "ctr", "position"].map(escapeCsv).join(","),
];

for (const path of watchPaths) {
  const row = rowByPath.get(path);
  lines.push(
    [
      path,
      row?.clicks ?? 0,
      row?.impressions ?? 0,
      row ? (row.ctr * 100).toFixed(2) + "%" : "",
      row ? row.position.toFixed(1) : "",
    ]
      .map(escapeCsv)
      .join(","),
  );
}

fs.writeFileSync(outputPath, lines.join("\n") + "\n", "utf8");
console.log(`Wrote ${outputPath}`);
