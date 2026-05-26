import fs from "node:fs/promises";

const secretPath = "C:/Users/tomo-/.codex/.sandbox-secrets/fic-wp.json";
const secret = JSON.parse(await fs.readFile(secretPath, "utf8"));
const site = secret.siteUrl.replace(/\/$/, "");
const auth = Buffer.from(`${secret.username}:${secret.applicationPassword}`, "utf8").toString("base64");

const headers = {
  Authorization: `Basic ${auth}`,
};

const items = [
  {
    slug: "nitori-9843-analysis",
    paragraph:
      '<p><strong>この分析を読む補助線：</strong>ニトリは既存店客数、荒利益率、為替、海外出店が同時に動くため、あわせて<a href="https://fic-investment.biz/operating-margin-guide/">営業利益率の見方</a>、<a href="https://fic-investment.biz/price-pass-through-guide/">価格転嫁の見方</a>、<a href="https://fic-investment.biz/segment-information-guide/">セグメント情報の読み方</a>を確認すると、減収増益の中身を追いやすくなります。</p>',
  },
  {
    slug: "mizuho-fg-8411-analysis",
    paragraph:
      '<p><strong>この分析を読む補助線：</strong>みずほFGは金利収益、非金利ビジネス、政策株売却、ROE目標を分けて見る必要があります。先に<a href="https://fic-investment.biz/roe-roic-guide/">ROEとROICの違い</a>、<a href="https://fic-investment.biz/segment-information-guide/">セグメント情報の読み方</a>、<a href="https://fic-investment.biz/kessan-tanshin-reading-guide/">決算短信の読み方</a>を押さえると、利益成長と資本効率の関係が読みやすくなります。</p>',
  },
  {
    slug: "eneos-holdings-5020-analysis",
    paragraph:
      '<p><strong>この分析を読む補助線：</strong>ENEOSは在庫影響、タイムラグ、一過性売却益、本業利益を分けて読むことが重要です。あわせて<a href="https://fic-investment.biz/operating-margin-guide/">営業利益率の見方</a>、<a href="https://fic-investment.biz/cash-flow-guide/">キャッシュフロー計算書の見方</a>、<a href="https://fic-investment.biz/segment-information-guide/">セグメント情報の読み方</a>を確認すると、市況要因と実力値を切り分けやすくなります。</p>',
  },
  {
    slug: "honda-7267-analysis",
    paragraph:
      '<p><strong>この分析を読む補助線：</strong>ホンダは二輪、四輪、金融サービスで利益率と資金の出入りが大きく違います。あわせて<a href="https://fic-investment.biz/segment-information-guide/">セグメント情報の読み方</a>、<a href="https://fic-investment.biz/operating-margin-guide/">営業利益率の見方</a>、<a href="https://fic-investment.biz/cash-flow-guide/">キャッシュフロー計算書の見方</a>を確認すると、EV関連損失と本業の稼ぐ力を分けて見やすくなります。</p>',
  },
  {
    slug: "screen-holdings-7735-analysis",
    paragraph:
      '<p><strong>この分析を読む補助線：</strong>SCREENは半導体製造装置の受注サイクル、地域別売上、中国仕向比率で利益が振れます。先に<a href="https://fic-investment.biz/orders-backlog-inventory-guide/">受注残と在庫の見方</a>、<a href="https://fic-investment.biz/earnings-progress-rate-guide/">進捗率の見方</a>、<a href="https://fic-investment.biz/operating-margin-guide/">営業利益率の見方</a>を確認すると、装置株の上振れ・下振れを追いやすくなります。</p>',
  },
  {
    slug: "daikin-6367-analysis",
    paragraph:
      '<p><strong>この分析を読む補助線：</strong>ダイキンは地域別販売台数、機種ミックス、為替、化学事業の利益率が重なって業績が動きます。あわせて<a href="https://fic-investment.biz/segment-information-guide/">セグメント情報の読み方</a>、<a href="https://fic-investment.biz/operating-margin-guide/">営業利益率の見方</a>、<a href="https://fic-investment.biz/kessan-tanshin-reading-guide/">決算短信の読み方</a>を確認すると、地域別の強弱と全社利益のつながりを整理しやすくなります。</p>',
  },
];

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

const backup = [];
const report = [];

for (const item of items) {
  const posts = await wpGet(`/wp-json/wp/v2/posts?slug=${encodeURIComponent(item.slug)}&context=edit`);
  if (!posts.length) {
    throw new Error(`Post not found: ${item.slug}`);
  }

  const post = posts[0];
  const content = post.content.raw ?? "";
  backup.push({
    id: post.id,
    slug: item.slug,
    title: post.title.raw,
    content,
  });

  if (content.includes("この分析を読む補助線")) {
    report.push({
      slug: item.slug,
      id: post.id,
      status: "skipped_existing_marker",
      beforeLength: content.length,
      afterLength: content.length,
      link: post.link,
    });
    continue;
  }

  const insertAt = content.indexOf("<h2");
  if (insertAt < 0) {
    throw new Error(`No h2 found: ${item.slug}`);
  }

  const nextContent = `${content.slice(0, insertAt)}\r\n${item.paragraph}\r\n\r\n${content.slice(insertAt)}`;
  const updated = await wpPost(`/wp-json/wp/v2/posts/${post.id}`, { content: nextContent });
  report.push({
    slug: item.slug,
    id: post.id,
    status: "updated",
    beforeLength: content.length,
    afterLength: nextContent.length,
    link: updated.link,
  });
}

await fs.mkdir("work", { recursive: true });
await fs.writeFile("work/manual-internal-link-batch2-backup-2026-05-23.json", `${JSON.stringify(backup, null, 2)}\n`);
const csvLines = [
  "slug,id,status,beforeLength,afterLength,link",
  ...report.map((row) =>
    [row.slug, row.id, row.status, row.beforeLength, row.afterLength, row.link]
      .map((value) => `"${String(value).replaceAll('"', '""')}"`)
      .join(","),
  ),
];
await fs.writeFile("work/manual-internal-link-batch2-report-2026-05-23.csv", `${csvLines.join("\n")}\n`);

console.table(report);
console.log("backup=work/manual-internal-link-batch2-backup-2026-05-23.json");
console.log("report=work/manual-internal-link-batch2-report-2026-05-23.csv");
