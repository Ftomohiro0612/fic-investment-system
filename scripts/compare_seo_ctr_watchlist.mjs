#!/usr/bin/env node
import fs from "node:fs";

const baselinePath = process.argv[2] || "work/seo-ctr-watchlist-baseline-2026-05-24.csv";
const latestPath = process.argv[3] || "work/seo-ctr-watchlist-latest.csv";
const outputPath = process.argv[4] || "work/seo-ctr-watchlist-comparison.md";

function parseCsvLine(line) {
  const values = [];
  let current = "";
  let quoted = false;

  for (let i = 0; i < line.length; i += 1) {
    const char = line[i];
    const next = line[i + 1];

    if (char === '"' && quoted && next === '"') {
      current += '"';
      i += 1;
    } else if (char === '"') {
      quoted = !quoted;
    } else if (char === "," && !quoted) {
      values.push(current);
      current = "";
    } else {
      current += char;
    }
  }

  values.push(current);
  return values;
}

function readCsv(path) {
  const lines = fs.readFileSync(path, "utf8").trim().split(/\r?\n/);
  const headers = parseCsvLine(lines.shift() || "");
  const rows = new Map();

  for (const line of lines) {
    if (!line.trim()) {
      continue;
    }

    const values = parseCsvLine(line);
    const row = Object.fromEntries(headers.map((header, index) => [header, values[index] ?? ""]));
    rows.set(row.path, row);
  }

  return rows;
}

function parseNumber(value) {
  const text = String(value || "").replace(/%|,/g, "");
  const number = Number.parseFloat(text);
  return Number.isFinite(number) ? number : 0;
}

function formatDelta(value, suffix = "") {
  const sign = value > 0 ? "+" : "";
  return `${sign}${value.toFixed(2)}${suffix}`;
}

const baselineRows = readCsv(baselinePath);
const latestRows = readCsv(latestPath);
const paths = Array.from(new Set([...baselineRows.keys(), ...latestRows.keys()]));

const lines = [
  "# SEO CTR Watchlist Comparison",
  "",
  `Baseline: \`${baselinePath}\``,
  `Latest: \`${latestPath}\``,
  "",
  "| Page | Baseline CTR | Latest CTR | CTR delta | Baseline position | Latest position | Position delta | Impressions delta | Note |",
  "| --- | ---: | ---: | ---: | ---: | ---: | ---: | ---: | --- |",
];

for (const path of paths) {
  const base = baselineRows.get(path) || {};
  const latest = latestRows.get(path) || {};

  const baseCtr = parseNumber(base.ctr);
  const latestCtr = parseNumber(latest.ctr);
  const basePosition = parseNumber(base.position);
  const latestPosition = parseNumber(latest.position);
  const baseImpressions = parseNumber(base.impressions);
  const latestImpressions = parseNumber(latest.impressions);

  const ctrDelta = latestCtr - baseCtr;
  const positionDelta = latestPosition - basePosition;
  const impressionsDelta = latestImpressions - baseImpressions;

  let note = "watch";
  if (!latestRows.has(path)) {
    note = "missing in latest report";
  } else if (latestImpressions < 20) {
    note = "low latest impressions";
  } else if (ctrDelta > 0.5 && Math.abs(positionDelta) <= 2) {
    note = "CTR improved with stable position";
  } else if (ctrDelta < -0.5 && Math.abs(positionDelta) <= 2) {
    note = "CTR declined with stable position";
  } else if (positionDelta > 2) {
    note = "position worsened; inspect query mix";
  } else if (positionDelta < -2) {
    note = "position improved; CTR may shift";
  }

  lines.push(
    [
      `| \`${path}\``,
      `${baseCtr.toFixed(2)}%`,
      latestRows.has(path) ? `${latestCtr.toFixed(2)}%` : "",
      formatDelta(ctrDelta, "pt"),
      basePosition.toFixed(1),
      latestRows.has(path) ? latestPosition.toFixed(1) : "",
      formatDelta(positionDelta),
      formatDelta(impressionsDelta, ""),
      `${note} |`,
    ].join(" | "),
  );
}

fs.writeFileSync(outputPath, lines.join("\n") + "\n", "utf8");
console.log(`Wrote ${outputPath}`);
