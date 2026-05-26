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
    slug: "construction-material-shortage-project-delay-margin-risk",
    paragraph:
      '<p><strong>この分析を読む補助線：</strong>このテーマは資材不足、工期遅延、粗利率、価格転嫁を分けて見ると整理しやすくなります。あわせて<a href="https://fic-investment.biz/raw-material-cost-pass-through/">原材料高と価格転嫁</a>、<a href="https://fic-investment.biz/logistics-reform-2024-problem/">物流改革と2024年問題</a>、<a href="https://fic-investment.biz/policy-subsidy-investment-theme/">政策・補助金テーマの読み方</a>を確認すると、建設関連株への波及を追いやすくなります。</p>',
  },
  {
    slug: "naphtha-packaging-cost-food-consumer-goods",
    paragraph:
      '<p><strong>この分析を読む補助線：</strong>ナフサ高は原材料コスト、包装材、値上げ、数量減をつなげて読むテーマです。先に<a href="https://fic-investment.biz/raw-material-cost-pass-through/">原材料高と価格転嫁</a>、<a href="https://fic-investment.biz/price-hike-consumer-demand/">値上げと消費者需要</a>、<a href="https://fic-investment.biz/fx-impact-company-earnings/">為替で業績が動く企業の見方</a>を押さえると、食品・日用品株の利益率を見やすくなります。</p>',
  },
  {
    slug: "sony-tsmc-physical-ai-sensor-investment",
    paragraph:
      '<p><strong>この分析を読む補助線：</strong>ソニー×TSMCのセンサー投資は、AI需要、半導体装置、材料、検査工程への波及を段階的に確認するテーマです。あわせて<a href="https://fic-investment.biz/semiconductor-investment-supply-chain/">半導体投資の波及先</a>、<a href="https://fic-investment.biz/policy-subsidy-investment-theme/">政策・補助金テーマの読み方</a>、<a href="https://fic-investment.biz/energy-transition-power-investment/">エネルギー転換と電力投資</a>を確認すると、期待と受注確認を分けて追いやすくなります。</p>',
  },
  {
    slug: "ai-battery-power-infrastructure-softbank-sakai",
    paragraph:
      '<p><strong>この分析を読む補助線：</strong>AIデータセンターの電力制約は、蓄電池、受変電、UPS、電力管理へ広がるテーマです。あわせて<a href="https://fic-investment.biz/energy-transition-power-investment/">エネルギー転換と電力投資</a>、<a href="https://fic-investment.biz/semiconductor-investment-supply-chain/">半導体投資の波及先</a>、<a href="https://fic-investment.biz/policy-subsidy-investment-theme/">政策・補助金テーマの読み方</a>を確認すると、ニュースから受注・投資案件へのつながりを整理しやすくなります。</p>',
  },
  {
    slug: "japan-semiconductor-advanced-node-sony-tsmc-jv-impact-2026",
    paragraph:
      '<p><strong>この分析を読む補助線：</strong>先端ノード投資は、CAPEX、装置受注、材料需要、輸出規制を分けて読む必要があります。先に<a href="https://fic-investment.biz/semiconductor-investment-supply-chain/">半導体投資の波及先</a>、<a href="https://fic-investment.biz/policy-subsidy-investment-theme/">政策・補助金テーマの読み方</a>、<a href="https://fic-investment.biz/energy-transition-power-investment/">エネルギー転換と電力投資</a>を確認すると、日本の装置・材料企業への波及を追いやすくなります。</p>',
  },
  {
    slug: "middle-east-lng-supply-risk-japan-shipping-trading-companies-impact",
    paragraph:
      '<p><strong>この分析を読む補助線：</strong>LNG供給不安は、資源価格、為替、輸送運賃、電力・ガス会社の転嫁ラグを分けて見るテーマです。あわせて<a href="https://fic-investment.biz/energy-transition-power-investment/">エネルギー転換と電力投資</a>、<a href="https://fic-investment.biz/raw-material-cost-pass-through/">原材料高と価格転嫁</a>、<a href="https://fic-investment.biz/fx-impact-company-earnings/">為替で業績が動く企業の見方</a>を確認すると、海運・商社・公益株への影響を整理しやすくなります。</p>',
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
await fs.writeFile("work/theme-manual-internal-link-batch1-backup-2026-05-23.json", `${JSON.stringify(backup, null, 2)}\n`);
const csvLines = [
  "slug,id,status,beforeLength,afterLength,link",
  ...report.map((row) =>
    [row.slug, row.id, row.status, row.beforeLength, row.afterLength, row.link]
      .map((value) => `"${String(value).replaceAll('"', '""')}"`)
      .join(","),
  ),
];
await fs.writeFile("work/theme-manual-internal-link-batch1-report-2026-05-23.csv", `${csvLines.join("\n")}\n`);

console.table(report);
console.log("backup=work/theme-manual-internal-link-batch1-backup-2026-05-23.json");
console.log("report=work/theme-manual-internal-link-batch1-report-2026-05-23.csv");
