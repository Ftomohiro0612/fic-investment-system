# 固定枠スキーマ仕様（Fixed-Frame Schema）— ドラフト v1

> ステータス：**Codexレビュー依頼用ドラフト**（凍結前）。90日ロードマップ S1-1 の成果物。
> 目的：根幹方針「AI時代の資産化」の柱②「構造を資産化」。全重点銘柄ページに共通の**固定枠**を持たせ、(a)横断比較・時系列の複利的蓄積、(b)AI被引用（JSON-LD/llms.txt/可視クイックアンサーの単一ソース）を可能にする。
> 対象実装：`kessan-yomu/src/content/config.ts`（Astro content collection schema）。仕様の正本＝本ファイル（fic-investment-system/docs）。

## 1. 固定枠の7要素（charter §2/§4・DEC-2026-06-03準拠）
| 要素 | 意味 | 現状（キオクシア記事） |
|---|---|---|
| thesis | 投資仮説の核（1〜2文・結論は出さず枠組みを渡す） | 本文13章・冒頭にあるが構造化なし |
| drivers | 業績ドライバー（名前＋効き方）。3本程度 | 章7にH3 3本＋表で存在 |
| kpis | 監視指標トップ3〜5（良いサイン/悪いサイン/出典/波及ラグ） | 章10.1＋kpi-cardsで存在 |
| valuation | バリュエーションview（指標＋市況株の正常益読替＋断定しない注記） | 章11.4で存在 |
| disconfirming | 反証条件（横串原則＝下振れ条件＝見直しシグナルを同一KPI閾値で） | 章7末表・章13で存在 |
| sources | 出典（既存schemaに有） | frontmatter有（空配列） |
| limitations | 限界明記（会社非開示/前提付き試算/扱わない範囲） | 本文各所に分散 |
| updated_at | 更新日時（既存schemaに有） | frontmatter有 |

> **2026-06-03 Codexレビュー結果＝条件付きGO。採用案＝B（将来Cへ）。** §3スキーマは下記 v2 が確定版（§3旧版は経緯）。即凍結はNO-GO、build＋整合監査通過で凍結可。

## 2. 設計上の中核判断（★Codex確認ポイント）
**問い：固定枠をどこまで frontmatter で構造化するか。** 本文は既に固定枠の中身を richに保有 → 全文をfrontmatterに二重化すると**保守負担＋ドリフト risk**。一方、構造化が薄いとAI被引用・横断比較の価値が出ない。

3案：
- **案A（フル構造化）**：固定枠全文をfrontmatterに。AI/JSON-LD最適だが authoring重・本文と二重管理でドリフトしやすい。
- **案B（軽量frontmatter＋本文規約）**：frontmatterは「正準ショート版」（thesis 1〜2文／drivers名＋1行／kpis 3〜5の良い悪いサイン／valuation 1行＋正常益注記／disconfirming 3条件＋閾値／limitations 箇条書き）。深い解説は本文。**frontmatterが横断比較・AI引用・可視クイックアンサーの単一ソース**、本文は読み物。両者は同一KPI閾値を参照（横串原則）。
- **案C（frontmatter単一ソース→本文サマリを生成）**：固定枠サマリboxを frontmatter から Astroコンポーネントでレンダリング（本文に手書きしない＝ドリフト原理的に消える）。最もエレガントだが実装コスト最大。

**CC推奨＝案B（段階的にCへ）**。理由：(1)ドリフトを抑えつつ即AI引用ソースになる、(2)authoring負担が現実的でSprint2の5社展開に耐える、(3)将来 frontmatter→サマリ生成（案C）へ無改修で移行できる構造（frontmatterが既に単一ソースのため）。可視クイックアンサー/JSON-LD/llms.txt は案Bのfrontmatterから生成。

## 3. 提案スキーマ（旧・経緯／§3-v2が確定版）
<details><summary>旧版（Codex指摘前。クリックで展開）</summary>

driverSchema=name/effect(string)、kpiSchema=name/good_sign/bad_sign/source(string)/lag、disconfirmSchema=condition/kpi_threshold、metricsはstring配列、disconfirming/limitations は min緩め。→ Codex指摘＝id欠如・出典構造化不足・横串の自由文字列依存・factual-handling出典種別欠如。
</details>

## 3-v2. 確定スキーマ（案B・Codex条件反映・config.ts 追加分）
```ts
// sources を id 付き＋出典種別（factual-handling整合）に拡張
const sourceSchema = z.object({
  id: z.string().trim().min(1),                 // 参照キー（kpi/metricから引く）
  title: z.string().trim().min(1),
  url: z.string().url().optional(),
  publisher: z.string().optional(),
  source_type: z.enum(["会社開示", "外部推計", "FIC前提付き試算"]).optional(),
  note: z.string().optional(),
});
const driverSchema = z.object({
  name: z.string().trim().min(1),               // 例 "NAND市況（ASP×出荷量）"
  effect: z.string().trim().min(1),             // 1行：売上・利益への効き方
});
const kpiSchema = z.object({
  id: z.string().trim().min(1),                 // 例 "asp"（disconfirmingから参照）
  name: z.string().trim().min(1),               // 例 "NAND/SSD ASP方向感"
  good_sign: z.string().trim().min(1),
  bad_sign: z.string().trim().min(1),           // ★反証閾値の単一正準ソース
  source_refs: z.array(z.string()).default([]), // sources[].id を参照
  lag: z.string().optional(),                   // 波及ラグ（即時〜1Q 等）
});
const disconfirmSchema = z.object({
  kpi_id: z.string().optional(),                // 紐づくKPI（その bad_sign が閾値＝横串原則）
  condition: z.string().trim().min(1),          // 反証条件（=下振れ=見直しシグナル）
});
const metricSchema = z.object({
  name: z.string().trim().min(1),               // 例 "予想PER"
  value: z.string().trim().min(1),              // 例 "約10倍"
  as_of: z.string().trim().min(1),              // ★時点（必須）
  source_ref: z.string().optional(),            // sources[].id
  note: z.string().optional(),
});
const fixedFrameSchema = z.object({
  thesis: z.string().trim().min(1),             // 投資仮説の核（1〜2文）
  drivers: z.array(driverSchema).min(2),        // 業績ドライバー（3本程度）
  kpis: z.array(kpiSchema).min(3).max(5),       // 監視指標トップ3〜5
  valuation: z.object({
    view: z.string().trim().min(1),             // 1行ビュー（断定しない）
    normalized_note: z.string().optional(),     // 市況株の正常益読替
    metrics: z.array(metricSchema).default([]), // 構造化（時点明記）
    caveat: z.string().trim().min(1),           // 投資助言非該当の注記（必須）
  }),
  disconfirming: z.array(disconfirmSchema).min(3),
  limitations: z.array(z.string().trim().min(1)).min(1), // 限界明記（固定枠ありなら最低1）
});
// articles schema に追加：
//   asset_tier: z.enum(["A", "B", "C"]).optional(),  // 重点度
//   fixed_frame: fixedFrameSchema.optional(),        // 移行期optional
// 整合は schema 全体の .superRefine で build時検証（下記§3-v2-refine）
```

**§3-v2-refine（build時の整合ゲート＝CI担保）**：articles schema 全体に `.superRefine()` を付け、
1. `asset_tier === "A"` なら `fixed_frame` 必須 ＋ `sources` 非空（TierA必須を運用KPIでなくbuildで強制）。
2. `fixed_frame.kpis[].id` は一意。
3. `fixed_frame.disconfirming[].kpi_id`（あれば）は `kpis[].id` に存在。
4. `kpis[].source_refs[]` ／ `valuation.metrics[].source_ref` は `sources[].id` に存在。

→ 横串原則（bad_sign＝反証閾値）は **kpi.bad_sign を単一ソース化**し disconfirming は kpi_id 参照のみ＝完全一致監査が原理的に不要。
※ `updated_at` / `last_reviewed` は既存を流用（固定枠の一部）。

## 4. DoD（ゲート①の凍結条件）＝**全達成・schema凍結（2026-06-03）**
1. ✅ 本仕様をCodexレビュー→合意（案B採用・5ラウンド全GO）。
2. ✅ config.ts に反映し `npm run build` 0 errors。
3. ✅ キオクシア frontmatter に `fixed_frame` 全枠充足（本文と完全一致・M3）。
4. ✅ 整合監査の実働実証（原則8）：kpi_id／sources[].id 重複の負テストで build EXIT=1・監査メッセージ発火を確認、復元後 0 errors。Codex独立再現でも一致。
5. ✅ Codex凍結GO（id=407 条件付き）→ 条件2点（sources[].id一意性・index_policy整合refine）を実装・実証。→ **schema凍結確定**（以後の変更はdecision-log経由）。
6. ⏭ 次＝TierA最終選定（S1-3・FIC判断）。

### 4.1 凍結後の繰越事項（decision-log候補・後続実装）
- **index_policy の描画側消費（S3）**：現状は schema field のみ。getVisibleArticles/sitemap/llms/rss/[slug].astro は未参照。S1は「content_type既定と一致のみ許可」refineで矛盾防止に留め、例外index（高品質earningsのindex化）の消費はS3で実装。
- **source_type の粒度（S3）**：現enum（会社開示/外部推計/FIC前提付き試算）は株価実測（市場データ）を表現できない。将来 `市場データ` 追加 or metric側に `value_basis`（market_quote/external_estimate/fic_estimate/company_disclosure）を足す。tradersweb は暫定 `外部推計`。
- **業界版fixed_frame・用語集collection・peer map の実体（S2-S3）**：S1は `sector_ref`/`glossary_refs` の予約フィールドまで。

## 6. 外部化（業界の風向き・共有KPIの外だし）★FIC提案 2026-06-03・**Codex条件付きGO（採用案b）**
**FIC提案**：業界の風向き・先行指標/KPIのうち、同セクター他社と流用できる部分を外だし（共有化）する。
**確定（Codex 2026-06-03）**：採用案(b)。企業schemaは `sector_ref` **optional** を入れて**先行凍結OK**。業界版fixed_frameの詳細設計はS3。新規 `sectors` collection(a)は現時点で過剰正規化＝不採用。`sector_ref` の参照整合（存在・category=業界か）はAstro schema単体では厳密検証しづらいため、S1はschemaに載せ参照整合の検証はS3/別lint。

**KPI線引き基準（Codex確定）**：
- **業界KPI**＝同一セクター内の複数社に同じ方向・同じ定義で効く外部変数（NAND/SSD ASP方向感・DRAM/NAND需給・ハイパースケーラcapex・業界在庫・装置投資サイクル）。
- **企業固有KPI**＝会社の開示項目・製品構成・技術移行・顧客構成・収益性に依存（SSD & Storage売上・BiCS世代移行・個社セグメント利益率・在庫評価影響・個社バリュエーション/thesis/disconfirming）。
- 迷うKPIは「同業他社にも同じ値で引用できるか」「個社IRの開示項目名に依存するか」で判定。

**S1凍結前に仕様明記すべき最小要件（Codex条件）**：①業界記事も fixed_frame を持てる ②企業記事は `sector_ref` を持てる ③`sector_ref` あり企業は業界KPIを重複保持しない（企業固有KPIのみ）。

**kpis の min 数は条件分岐（Codex指摘）**：`sector_ref` あり企業＝企業固有KPI `min(1)`／`sector_ref` なし企業・業界記事＝`min(3)`。category/sector_ref 条件の superRefine で扱う（一律 min(3) は矛盾）。

**観察＝KPIはセクター共有と企業固有が混在**：
- 業界共有：業界判定（風向き）、NAND/SSD ASP方向感、ハイパースケーラのデータセンター投資（capex）、DRAM/NAND需給 — 同セクター全社で同値。
- 企業固有：SSD & Storage売上、BiCS世代移行、企業別バリュエーション/thesis/disconfirming。

**CC推奨＝案(b)：既存「業界(category=業界)」記事に業界版fixed_frameを持たせ、企業fixed_frameは `sector_ref`（業界記事slug）で参照＋企業固有のみ保持**。
- 業界共有KPI（ASP方向感・capex等）は業界記事の fixed_frame に一度だけ置く→メンバー企業が参照。
- 対案(a)＝新規 `sectors` データcollectionを別途新設（プロ正規化だが既存業界記事と二重）。→ (b)の方が既存collection流用でDRY。
- 効果：①一度更新→全社反映 ②セクター内横断比較 ③業界記事が被引用ハブ化（AI引用）④Sprint2の5社展開でauthoring削減。
- 影響：企業schemaは `sector_ref` を追加し、kpis は「企業固有のみ必須／業界KPIは sector_ref 経由」。横串原則は企業KPI内で維持、業界KPIは業界記事内で維持。

**凍結への影響**：本提案を織り込んでから企業schemaを凍結する（凍結後リファクタを避ける）。Codexのアーキ判定後にconfig.ts実装。

## 7. 統合アーキテクチャ（地図ベース・3層・外部化）★FIC合意 2026-06-03・Codex一括判定待ち

### 7.1 マスター地図＝投資ストーリー全体像（story-flow）
キオクシアで実装済の `.story-flow`（上流→下流の地図）を**各銘柄のマスター目次＝クリック地図ハブ（company-hub-design）**に格上げ。人のナビ＝AIの構造の二役。各ノードは「どの層に詳細があるか」をマッピングしリンクで飛ばす。
- **取捨の原則**：地図に乗る＝載せる／地図に乗らず投資仮説を動かさない情報（汎用沿革・無関係な雑情報）＝**エバーグリーンに書かない**。

### 7.2 3層タクソノミー（content_type）
| 層 | content_type | 性質 | KPI/判断 | index |
|---|---|---|---|---|
| 業界分析 | `industry` | エバーグリーン・業界動向を上に集約 | 業界KPIを定義（単一ソース） | index |
| 企業分析 | `analysis` | エバーグリーン・判断の本体 | 企業固有KPI＋sector_refで業界KPI参照 | index |
| 決算速報 | `earnings` | 末端・日付もの | 定義せず参照（反証条件のテスト実行ログ） | noindex |
| ニュース起点 | `news` | 末端・日付もの | 定義せず参照 | noindex |

- `category=["企業","業界"]` は維持し、**`content_type` で層を区別**（`analysis`/`industry`/`earnings`/`news`）。
- 末端（earnings/news）は**自前KPIを持たない**＝エバーグリーンのKPI/反証条件を参照するのみ。

### 7.3 業績の切り分け（地図の下流ノード）
- **業績の構造・質・感応度**（ドライバー分解・利益の質・ASP感応度）＝**エバーグリーン（analysis）に残す**＝賞味期限が長い判断資産。
- **最新の実現業績の実数＋速報解説**＝**earnings（決算速報・noindex）へ**。
- エバーグリーンは**最新実数スナップショット＋updated_at**を持ち最新 earnings へリンク（橋）。

### 7.4 外部化の2段ロールアウト（前掲§6の拡張）
「複数企業/記事で同じ値・同じ説明が使い回せるもの」を外だし。判断・固有値は各記事に残す。
- **S1（枠だけ）**：①業界上流・業界KPI（実装）＋②用語集 `glossary_refs`・③同業比較peer枠（**参照フィールド予約のみ**）。
- **S2〜S3（実体）**：②共有用語集collection→④マクロ共通前提（為替/市況・期次）→③peer map→⑤規制・政策→⑥読み方メソッド（手法は共有・値は各社）。
- **残すもの**：thesis／disconfirming／企業バリュエーション値／企業固有KPI／セグメント数値／個社ドライバー収益化メカニズム。

### 7.5 S1凍結スコープ（最小・確定）
企業schema＝既存メタ＋`content_type`＋`asset_tier`＋`sector_ref`(optional)＋`evergreen_ref`(optional)＋`fixed_frame`(optional, §3-v2)＋予約フィールド(`glossary_refs`等)。業界版fixed_frame詳細・用語集・peer mapの**実体はS2-S3**。これで凍結後リファクタを避ける。

### 7.6 Codex統合判定の確定条件（2026-06-03・id=403 条件付きGO反映）
- **3層 vs 4型を明記**：役割としての層＝「エバーグリーン上流／エバーグリーン個社／日付末端」の3層。型としての `content_type` ＝ `industry`/`analysis`/`earnings`/`news` の4種。
- **7.3 スナップショット制限**：evergreen側の最新実数は「短いスナップショット＋`as_of`＋`source`＋`latest_earnings_ref`」に限定。速報解説（その場の詳しい読み）は重複させず earnings 側に置く。
- **`evergreen_ref` 予約**：末端（earnings/news）がエバーグリーンを参照するためのフィールドを予約（schema/監査で「末端は自前KPIを持たず参照のみ」を表現可能にする）。
- **content_type × category の .superRefine ルール**：
  - `industry` ⇒ `category:"業界"`、業界KPIを持てる。
  - `analysis` ⇒ `category:"企業"`、企業固有KPI＋任意 `sector_ref`。
  - `earnings` ⇒ 原則 `category:"企業"`、`evergreen_ref` 必須、`fixed_frame` 禁止、noindex。
  - `news` ⇒ `category:"企業"` or `"業界"`、`evergreen_ref` or `sector_ref` 条件付き必須、`fixed_frame` 禁止、noindex。
  - earnings/news は sitemap/llms.txt からも除外（後続実装で反映）。
- **kpis min の条件分岐**：`sector_ref` あり `analysis` ＝企業固有KPI `min(1)`／`sector_ref` なし `analysis`・`industry` ＝`min(3)`。
- **キオクシアの sector_ref＝未設定で進める**：現存の業界記事は半導体装置・材料寄りで「真のNAND/SSD業界ハブ」ではないため、無理に参照させず企業KPI `min(3)` を満たす（真のNANDハブ新設後にS3で接続）。
- **進行可否（Codex）**：config.ts実装 → キオクシアfrontmatter充足 → `npm run build` → 整合監査 へ進んでよい。

## 8. 外部化のSEO対応策（★FIC懸念 2026-06-03・Codex検証待ち）
SEOは北極星でなく**ガードレール（下げ止め）**。外だしで記事が痩せSEOが落ちる懸念への対応策。**外だしは2種類で論理が異なる**。

### 8.1 共有データ（業界KPI・用語・peer・マクロ前提）の外だし
- **★必須対応＝ソースは外だし／ページには描画（ビルド時トランスクルージョン）**。AstroはSSGなので `sector_ref`/`glossary_refs` 経由で共有データを**ビルド時に各ページHTMLへ埋め込む**。ユーザーもGooglebotも完全なページを見る＝痩せない。外だしは「執筆・管理の一元化」のみ。
- 得：重複コンテンツrisk消去／JSON-LD増でリッチリザルト適格／定義統一。
- ⚠️ NG＝クライアントJSのみ描画（Googlebot拾い損ね）。**ビルド時静的描画を死守**。

### 8.2 日付もの（earnings/news）の noindex 別カテゴリ化
- SEO的にプラス。鮮度ものの薄い/陳腐化ページがエバーグリーンと**カニバるのを防ぎ評価をハブに集約**。
- エバーグリーンは「枠組み＋最新実数スナップショット＋updated_at＋最新速報リンク」で鮮度シグナルを保ちつつ本体は痩せない。

### 8.3 SEO対応策まとめ
1. 共有データはビルド時に各ページへ描画（リンクのみにしない）。
2. 企業ページに業界サマリ＋業界ハブへのリンクを残す（「企業＋業界」意図カバー）。
3. noindexは日付ものだけ。content_typeでindex方針を機械強制（superRefineで誤noindex防止）。
4. ハブ&スポーク内部リンク（業界ハブ↔企業↔速報）でトピック権威性。
5. 移行時の301設計（S3-3）で既存評価保全。
6. GSC before/after監視（S3-4・ガードレール下げ止め）で実測確認（原則8）。

### 8.4 Codex SEO確定条件（2026-06-03・id=405 条件付きGO反映）
- **重複の言い切り修正**：ソース一元化で管理上の重複は消えるが、同一業界文を多ページに描画すればHTML重複は残る。**短い定義・KPI表は許容／長い同一文章の反復は避ける**。
- **canonical方針（明記）**：`analysis`/`industry`＝**self-canonical**。`earnings`/`news`＝noindex。**業界ハブへのcanonicalは通常使わない**（本文リンクで送る）。企業ページを業界ハブへcanonicalするのは「企業ページ自体が重複/代替」の場合のみ。
- **業界サマリは個社文脈で差別化**：企業ページの主文は「業界定義」でなく「**このKPIが当社の売上/利益/反証条件にどう効くか**」。フル説明は業界ハブ、企業ページは短い要約＋個社影響。描画量に上限。
- **`index_policy` フィールドを新設**：index方針を content_type から純粋導出せず明示管理（高品質な決算解説を例外indexできる余地）。値＝`index`/`noindex`。既定は content_type から導出（analysis/industry→index、earnings/news→noindex）し、例外のみ明示上書き。
- **noindexでもrobots.txtでブロックしない**（Googlebotがnoindexを読める必要）。noindex対象はsitemap/llms.txtから除外。既存URL移行時もrobots.txtブロック禁止。
- **鮮度維持の条件**：`updated_at` だけ変えるのは不可。最新実数スナップショット＋`as_of`＋source＋`latest_earnings_ref` を実更新する時のみ更新。
- **GSC監視項目（before/after）**：流入だけでなく、インデックス除外数・Duplicate without user-selected canonical・Crawled currently not indexed・内部リンク数。
- **進行可否（Codex）**：上記を§8に反映すれば config.ts 実装再開→凍結に進んでよい。

## 5. 横串・既存規律との整合
- `bad_sign`（KPI）＝`kpi_threshold`（反証条件）を同一値に（横串原則＝章2.3=12.4=13.3、10.1=13.2）。
- valuation.caveat は expression-strength-rules（投資助言非該当・断定回避）準拠。
- limitations は factual-handling-rules（会社開示値/外部推計/FIC前提付き試算の区別）準拠。
- 感応度4点セット（会社非開示＋観察実績＋FIC前提付き試算＋限界）は limitations と drivers.effect に分担。
