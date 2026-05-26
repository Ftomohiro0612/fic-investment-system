import { promises as fs } from "node:fs";
import path from "node:path";

const DEFAULT_TARGETS = [
  "wordpress/deploy/phase1-articles/bodies",
  "wordpress/drafts/beginner_guide",
  "wordpress/drafts/theme_entry",
];

const outputDir = "work";
const markdownPath = path.join(outputDir, "article-heading-hierarchy-audit.md");
const csvPath = path.join(outputDir, "article-heading-hierarchy-audit.csv");

function normalizePath(filePath) {
  return filePath.split(path.sep).join("/");
}

async function pathExists(targetPath) {
  try {
    await fs.access(targetPath);
    return true;
  } catch {
    return false;
  }
}

async function collectHtmlFiles(targetPath) {
  const stat = await fs.stat(targetPath);
  if (stat.isFile()) {
    return targetPath.toLowerCase().endsWith(".html") ? [targetPath] : [];
  }

  const entries = await fs.readdir(targetPath, { withFileTypes: true });
  const nested = await Promise.all(
    entries.map((entry) => collectHtmlFiles(path.join(targetPath, entry.name))),
  );
  return nested.flat();
}

function stripTags(html) {
  return html
    .replace(/<script[\s\S]*?<\/script>/gi, " ")
    .replace(/<style[\s\S]*?<\/style>/gi, " ")
    .replace(/<[^>]+>/g, " ")
    .replace(/&nbsp;/g, " ")
    .replace(/&amp;/g, "&")
    .replace(/&lt;/g, "<")
    .replace(/&gt;/g, ">")
    .replace(/\s+/g, " ")
    .trim();
}

function headingText(rawHeading) {
  return stripTags(rawHeading).replace(/^#+\s*/, "").trim();
}

function countMatches(text, pattern) {
  return [...text.matchAll(pattern)].length;
}

function trimFicTail(sectionHtml) {
  const tailMarkers = [
    /<section\b[^>]*class=["'][^"']*\bfic-article-after-nav\b/gi,
    /<p\b[^>]*class=["'][^"']*\bauthor-credit\b/gi,
    /<p\b[^>]*class=["'][^"']*\bdisclaimer\b/gi,
    /<script\b[^>]*type=["']application\/ld\+json["']/gi,
  ];

  const markerIndexes = tailMarkers
    .map((pattern) => {
      pattern.lastIndex = 0;
      const match = pattern.exec(sectionHtml);
      return match ? match.index : -1;
    })
    .filter((index) => index >= 0);

  if (markerIndexes.length === 0) return sectionHtml;
  return sectionHtml.slice(0, Math.min(...markerIndexes));
}

function analyzeHtml(filePath, html) {
  const headingPattern = /<(h[23])\b[^>]*>([\s\S]*?)<\/\1>/gi;
  const matches = [...html.matchAll(headingPattern)].map((match) => ({
    level: match[1].toLowerCase(),
    title: headingText(match[2]),
    index: match.index ?? 0,
    raw: match[0],
  }));

  const sections = [];
  for (let index = 0; index < matches.length; index += 1) {
    const current = matches[index];
    if (current.level !== "h2") continue;

    const nextH2 = matches.slice(index + 1).find((item) => item.level === "h2");
    const start = current.index + current.raw.length;
    const end = nextH2 ? nextH2.index : html.length;
    const sectionHtml = trimFicTail(html.slice(start, end));
    const h3Count = countMatches(sectionHtml, /<h3\b[^>]*>/gi);
    const tableCount = countMatches(sectionHtml, /<table\b[^>]*>/gi);
    const textLength = stripTags(sectionHtml).length;

    sections.push({
      title: current.title,
      h3Count,
      tableCount,
      textLength,
      needsH3: h3Count === 0 && (textLength >= 900 || tableCount >= 2),
    });
  }

  const h3BeforeFirstH2 =
    matches.findIndex((item) => item.level === "h3") > -1 &&
    matches.findIndex((item) => item.level === "h3") <
      matches.findIndex((item) => item.level === "h2");

  const longH2WithoutH3 = sections.filter((section) => section.needsH3);
  const maxSectionText = sections.reduce(
    (max, section) => Math.max(max, section.textLength),
    0,
  );
  const maxSectionTables = sections.reduce(
    (max, section) => Math.max(max, section.tableCount),
    0,
  );

  const status =
    matches.length === 0
      ? "no-headings"
      : h3BeforeFirstH2 || longH2WithoutH3.length > 0
        ? "review"
        : "ok";

  return {
    filePath: normalizePath(filePath),
    status,
    h2Count: matches.filter((item) => item.level === "h2").length,
    h3Count: matches.filter((item) => item.level === "h3").length,
    maxSectionText,
    maxSectionTables,
    h3BeforeFirstH2,
    longH2WithoutH3,
  };
}

function csvEscape(value) {
  const text = String(value ?? "");
  return /[",\n]/.test(text) ? `"${text.replace(/"/g, '""')}"` : text;
}

function buildMarkdown(results) {
  const reviewItems = results.filter((item) => item.status === "review");
  const okItems = results.filter((item) => item.status === "ok");
  const noHeadingItems = results.filter((item) => item.status === "no-headings");

  const lines = [
    "# Article Heading Hierarchy Audit",
    "",
    `Generated: ${new Date().toISOString()}`,
    "",
    "## Summary",
    "",
    `- Files checked: ${results.length}`,
    `- Review needed: ${reviewItems.length}`,
    `- OK: ${okItems.length}`,
    `- No headings: ${noHeadingItems.length}`,
    "",
    "## Review Needed",
    "",
  ];

  if (reviewItems.length === 0) {
    lines.push("- None");
  } else {
    for (const item of reviewItems) {
      lines.push(`### ${item.filePath}`);
      lines.push("");
      lines.push(
        `- H2: ${item.h2Count}, H3: ${item.h3Count}, max section text: ${item.maxSectionText}, max tables in one H2: ${item.maxSectionTables}`,
      );
      if (item.h3BeforeFirstH2) {
        lines.push("- H3 appears before the first H2.");
      }
      for (const section of item.longH2WithoutH3) {
        lines.push(
          `- H2 without H3: ${section.title || "(untitled)"} / text ${section.textLength} chars / tables ${section.tableCount}`,
        );
      }
      lines.push("");
    }
  }

  lines.push("## Full Result");
  lines.push("");
  lines.push("| Status | H2 | H3 | Max Text | Max Tables | File |");
  lines.push("|---|---:|---:|---:|---:|---|");
  for (const item of results) {
    lines.push(
      `| ${item.status} | ${item.h2Count} | ${item.h3Count} | ${item.maxSectionText} | ${item.maxSectionTables} | ${item.filePath} |`,
    );
  }

  return `${lines.join("\n")}\n`;
}

function buildCsv(results) {
  const rows = [
    [
      "status",
      "h2_count",
      "h3_count",
      "max_section_text",
      "max_section_tables",
      "h3_before_first_h2",
      "review_sections",
      "file",
    ],
  ];

  for (const item of results) {
    rows.push([
      item.status,
      item.h2Count,
      item.h3Count,
      item.maxSectionText,
      item.maxSectionTables,
      item.h3BeforeFirstH2 ? "yes" : "no",
      item.longH2WithoutH3
        .map((section) => `${section.title} (${section.textLength} chars, ${section.tableCount} tables)`)
        .join("; "),
      item.filePath,
    ]);
  }

  return `${rows.map((row) => row.map(csvEscape).join(",")).join("\n")}\n`;
}

const targets = process.argv.slice(2);
const selectedTargets = targets.length > 0 ? targets : DEFAULT_TARGETS;
const existingTargets = [];
for (const target of selectedTargets) {
  if (await pathExists(target)) existingTargets.push(target);
}

if (existingTargets.length === 0) {
  console.error("No existing target paths found.");
  process.exit(1);
}

const files = [
  ...new Set((await Promise.all(existingTargets.map(collectHtmlFiles))).flat()),
].sort((a, b) => normalizePath(a).localeCompare(normalizePath(b)));

const results = [];
for (const filePath of files) {
  const html = await fs.readFile(filePath, "utf8");
  results.push(analyzeHtml(filePath, html));
}

await fs.mkdir(outputDir, { recursive: true });
await fs.writeFile(markdownPath, buildMarkdown(results), "utf8");
await fs.writeFile(csvPath, buildCsv(results), "utf8");

const reviewCount = results.filter((item) => item.status === "review").length;
console.log(`checked=${results.length}`);
console.log(`review=${reviewCount}`);
console.log(`markdown=${normalizePath(markdownPath)}`);
console.log(`csv=${normalizePath(csvPath)}`);
