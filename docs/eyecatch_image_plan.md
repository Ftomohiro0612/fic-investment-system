# フェーズ1 アイキャッチ画像計画

作成日: 2026-05-22

Status: eyecatch-plan

## 目的

`テーマの読み方` と `投資の読み方` の常設記事に、FICらしい統一感のあるアイキャッチ画像を用意する。

トップページの黒ベース、黄色アクセント、白ロゴの方向性に合わせ、記事一覧で「FICの記事だ」とすぐ分かる見た目にする。

## 基本方針

- 画像比率は WordPress / OGP で使いやすい `1200 x 630` を標準にする。
- 黒、濃紺、チャコールをベースにする。
- 黄色をアクセントに使う。
- 金融っぽいが、過度に証券会社の広告風にはしない。
- 日本語の長文を画像内に入れない。
- ロゴを入れる場合は左上に小さく配置する。
- 既存投稿のアイキャッチは、ユーザー明示なしでは変更しない。

## カテゴリー別デザイン

### テーマの読み方

用途:

- 金利
- 為替
- 原材料高
- 半導体投資
- 政策・補助金
- エネルギー
- 物流
- インバウンド

見た目:

- 黒から濃紺の背景
- 黄色の細いライン、点、グリッド
- 抽象的な産業・物流・都市・データのモチーフ
- 複数の要素が矢印や線でつながる構図

避ける:

- 特定企業ロゴ
- 実在企業名
- 株価チャートだけの汎用画像
- 読みにくい大量文字

共通プロンプト:

```text
Use case: ads-marketing
Asset type: WordPress featured image / OGP image for a Japanese investment research article
Primary request: A premium editorial featured image for FIC Investment Research, representing a permanent guide to reading investment themes and how macro/news drivers flow into company earnings.
Scene/backdrop: abstract dark financial research desk and industry network, with subtle data lines, market-grid texture, and connected nodes.
Subject: macro drivers flowing into industries and companies, shown through abstract charts, industrial silhouettes, and clean directional lines.
Style/medium: polished editorial digital illustration, realistic materials with restrained infographic feeling.
Composition/framing: 1200x630 landscape, strong visual focus in the center-right, clean negative space in the upper-left for a small FIC logo added later.
Lighting/mood: dark, intelligent, calm, premium, analytical.
Color palette: black, charcoal, deep navy, white highlights, FIC yellow accents.
Text: no text.
Constraints: no readable words, no company logos, no stock ticker symbols, no people, no watermark.
Avoid: generic bull/bear imagery, crypto coins, flashy neon trading screens, cluttered text.
```

### 投資の読み方

用途:

- 決算短信
- 営業利益率
- 受注残
- ROE/ROIC
- セグメント情報
- キャッシュフロー
- 中期経営計画
- 進捗率

見た目:

- 黒ベース
- 白い決算資料、表、数値、ペン、分析メモ
- 黄色のマーカーや付箋
- 初心者でも怖くない、整理された学習感

避ける:

- 教材っぽすぎるポップな見た目
- 安っぽい電卓・コイン画像
- 文章だらけの画像

共通プロンプト:

```text
Use case: ads-marketing
Asset type: WordPress featured image / OGP image for a Japanese investor education article
Primary request: A premium editorial featured image for FIC Investment Research, representing learning how to read financial statements and investment metrics.
Scene/backdrop: dark research desk with clean financial documents, simple tables, charts, a pen, and subtle highlighted figures.
Subject: financial statement analysis, ratios, cash flow, and decision notes represented as elegant abstract paperwork and data panels.
Style/medium: polished editorial digital illustration with realistic paper texture and restrained infographic elements.
Composition/framing: 1200x630 landscape, organized document cluster in the center, clean negative space in the upper-left for a small FIC logo added later.
Lighting/mood: calm, trustworthy, precise, beginner-friendly but professional.
Color palette: black, charcoal, white paper, muted gray, FIC yellow highlights.
Text: no text.
Constraints: no readable words, no company logos, no stock ticker symbols, no people, no watermark.
Avoid: cartoon school imagery, cheap calculator stock-photo style, crowded tiny text, aggressive trading screens.
```

## 個別テーマの差分プロンプト

必要に応じて、共通プロンプトの `Subject` に以下を足す。

| 記事 | 差分 |
| --- | --- |
| 金利 | interest-rate curve, bank building silhouette, real estate blocks |
| 為替 | yen/dollar abstract currency flow, import/export arrows |
| 原材料高 | raw materials, shipping containers, factory input costs |
| 半導体 | semiconductor wafer, clean-room equipment, data-center power lines |
| 政策・補助金 | government building silhouette, budget allocation paths, project selection nodes |
| エネルギー | power grid, transformer, battery storage, data center cooling |
| 人手不足 | automated warehouse, robot arm, staff scheduling dashboard |
| 値上げ | product shelves, price tag shapes without text, consumer demand flow |
| インバウンド | airport, hotel, rail line, shopping district, travel flow |
| 防衛 | aircraft and ship silhouettes, radar, secure communication network |
| 物流 | trucks, warehouse, route map, automated sorting lines |

## 制作順

1. `テーマの読み方` 共通アイキャッチを1枚作る。完了
2. `投資の読み方` 共通アイキャッチを1枚作る。完了
3. 公開優先上位5本だけ個別差分を作る。
4. 反応を見て、残り記事の個別アイキャッチを作る。

## 保存場所

ワークスペースに保存する場合:

- `wordpress/assets/eyecatch/theme-reading/`
- `wordpress/assets/eyecatch/investment-reading/`

ファイル名:

- `theme-reading-common.png`
- `investment-reading-common.png`
- `theme-reading-interest-rate.png`
- `theme-reading-fx.png`
- `theme-reading-raw-material.png`

## 作成済みファイル

| 用途 | ファイル |
| --- | --- |
| テーマの読み方 共通 | `wordpress/assets/eyecatch/theme-reading/theme-reading-common.png` |
| 投資の読み方 共通 | `wordpress/assets/eyecatch/investment-reading/investment-reading-common.png` |
| テーマの読み方 共通 ロゴ・文言入り | `wordpress/assets/eyecatch/theme-reading/theme-reading-common-branded.png` |
| 投資の読み方 共通 ロゴ・文言入り | `wordpress/assets/eyecatch/investment-reading/investment-reading-common-branded.png` |

## 運用メモ

- 本文内図解とアイキャッチは別物として扱う。
- 本文内図解をアイキャッチに流用しない。
- 既存投稿更新時は `featured_media` を変更しない。
- 新規公開時のみ、対象記事に合わせたアイキャッチを設定する。
- WordPress投入後は、記事一覧、OGP、X投稿プレビューで見え方を確認する。
