import fs from "node:fs/promises";

const secretPath = "C:/Users/tomo-/.codex/.sandbox-secrets/fic-wp.json";
const secret = JSON.parse(await fs.readFile(secretPath, "utf8"));
const site = secret.siteUrl.replace(/\/$/, "");
const auth = Buffer.from(`${secret.username}:${secret.applicationPassword}`, "utf8").toString("base64");

const headers = {
  Authorization: `Basic ${auth}`,
};

const industryCategoryId = 98;
const themeAnalysisCategoryId = 106;

async function wpGet(path) {
  const response = await fetch(`${site}${path}`, { headers });
  if (!response.ok) {
    throw new Error(`GET ${path} failed: ${response.status} ${await response.text()}`);
  }
  return response.json();
}

async function wpPost(path, body) {
  const response = await fetch(`${site}${path}`, {
    method: "POST",
    headers: {
      ...headers,
      "Content-Type": "application/json",
    },
    body: JSON.stringify(body),
  });
  if (!response.ok) {
    throw new Error(`POST ${path} failed: ${response.status} ${await response.text()}`);
  }
  return response.json();
}

const posts = await wpGet(
  `/wp-json/wp/v2/posts?categories=${industryCategoryId}&per_page=100&context=edit&_fields=id,slug,title,categories,link`,
);

const backup = posts.map((post) => ({
  id: post.id,
  slug: post.slug,
  title: post.title.raw,
  categories: post.categories,
  link: post.link,
}));

const report = [];
for (const post of posts) {
  const categories = Array.from(new Set([...(post.categories ?? []), themeAnalysisCategoryId]));
  if ((post.categories ?? []).includes(themeAnalysisCategoryId)) {
    report.push({
      id: post.id,
      slug: post.slug,
      status: "skipped_already_has_theme_analysis",
      beforeCategories: (post.categories ?? []).join("|"),
      afterCategories: categories.join("|"),
      link: post.link,
    });
    continue;
  }

  const updated = await wpPost(`/wp-json/wp/v2/posts/${post.id}`, { categories });
  report.push({
    id: post.id,
    slug: post.slug,
    status: "updated",
    beforeCategories: (post.categories ?? []).join("|"),
    afterCategories: (updated.categories ?? []).join("|"),
    link: updated.link,
  });
}

await fs.mkdir("work", { recursive: true });
await fs.writeFile("work/theme-analysis-category-backup-2026-05-23.json", `${JSON.stringify(backup, null, 2)}\n`);
const csvLines = [
  "id,slug,status,beforeCategories,afterCategories,link",
  ...report.map((row) =>
    [row.id, row.slug, row.status, row.beforeCategories, row.afterCategories, row.link]
      .map((value) => `"${String(value).replaceAll('"', '""')}"`)
      .join(","),
  ),
];
await fs.writeFile("work/theme-analysis-category-report-2026-05-23.csv", `${csvLines.join("\n")}\n`);

console.table(report);
console.log("backup=work/theme-analysis-category-backup-2026-05-23.json");
console.log("report=work/theme-analysis-category-report-2026-05-23.csv");
