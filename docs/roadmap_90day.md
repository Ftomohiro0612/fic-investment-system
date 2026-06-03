# 90日ロードマップ（2026-06-03 → 2026-09-01）

> ステータス：**確定（v2・Codex条件付きGO反映済 2026-06-03）**。承認経路＝FICが判断をCodexに委任→Codex条件付きGO→条件反映で確定。
> 正本関係：charter §5 の詳細版。根幹方針＝[DEC-2026-06-03-ai-era-analysis-asset-direction](https://github.com/Ftomohiro0612/ai-agent-control-center/blob/main/docs/decision-log/2026-06-03-ai-era-analysis-asset-direction.md)。
> 実行優先順（Codex既GO）：**②構造 → ①判断 → ④ブランド → ③鮮度**。鮮度（決算速報）は最後だが90日内に「橋の試作1本」まで到達。
> 担当記号：CC=Claude Code（実装）／CX=Codex（レビュー・検証）／FIC=オーナー（承認・銘柄判断・課金）。
> ※旧 `docs/roadmap.md`（Make時代Phase1〜4）は陳腐化。本ファイルが現行の正本。

## 0. すでに終わっている土台（再計画しない）
- Astro PoC repo `kessan-yomu` ビルド成功・ステージング公開（kessan-yomu.pages.dev・3記事・noindex）
- キオクシア エバーグリーン：A（価値交換）+B（バリュエーション正常利益読替）+感応度4点セット+投資ストーリー図 … Codex全GO
- 新ドメイン kessan-yomu.com 取得・NS=Cloudflare アクティブ
- ※現 content schema はメタ中心（title/description/status/sources/updated_at）で、固定枠（thesis/drivers/KPI/valuation/反証条件）は**未schema化**＝S1-1の出発点（Codex検証で確認）

## Sprint 1（6/3〜7/3）｜②構造を確定して型にする
**依存順（直列・ゲート①のDoD）**：固定枠仕様 → Astro schema化 → キオクシア全枠充足 → build/CXレビュー → **schema凍結** → TierA最終選定

| # | 作業 | 担当 | 完了条件（DoD） |
|---|---|---|---|
| S1-1 | 固定枠スキーマの確定（thesis/drivers/KPI/valuation/反証条件/sources/updated_at＋限界明記）を文書化し Astro content collection schema に落とす | CC→CX | schema定義＋キオクシアが全枠を満たし build/astro check 通過→**schema凍結** |
| S1-2 | キオクシアのハブPoC仕上げ（要約重複整理・モジュール化・タブ詳細補助） | CC→CX | クリック地図ハブが人/AI両方から構造を引ける |
| S1-3 | 重点銘柄 Tier 設計の確定：TierA候補（5〜8社）をCCが提示→FIC選定 | CC提示／FIC選定 | schema凍結後にTierA確定（PoC3本＝kioxia/JX金属/AI-DRAM theme を起点） |

**ゲート①（要FIC承認）**：schema凍結 ＋ TierA銘柄リスト確定

## Sprint 2（7/4〜8/3）｜①判断を量産＋③鮮度の橋を試作
| # | 作業 | 担当 | DoD |
|---|---|---|---|
| S2-1 | TierA各社を固定枠で構造化（A+B+感応度をエバーグリーンに）。**5社必達／6〜8社はストレッチ**（FIC選定が8社なら上位5社100%＋残りS3継続） | CC→CX | TierA上位5社が固定枠100%実装＋CX確認 |
| S2-2 | 決算速報試作（**橋の試作**）：S2-1最低5社 or キオクシア固定枠確定後の時限タスク。キオクシア1本・noindex・相互リンク・反証条件ログに限定。**S2-1遅延時はS3へ自動繰越** | CC→CX | キオクシア速報1本・エバーグリーンと相互リンク（橋）成立 |
| S2-3 | writer/reviewer SOP に編集確定原則（γ不使用・要点1行・感応度4点セット等）を恒久ルール化 | CC | Skill/docs反映・decision-log |

**ゲート②（要FIC承認）**：決算速報の二層構造（エバーグリーン↔速報）の運用可否
※S2-2は「鮮度の運用化」ではなく「橋の試作」に限定＝優先順（構造→判断→ブランド→鮮度）の違反ではない。

## Sprint 3（8/4〜9/1）｜⑤AI引用設計＋④ブランド＋切替準備
| # | 作業 | 担当 | DoD |
|---|---|---|---|
| S3-1 | AI引用設計：llms.txt整備・JSON-LD（Article/FAQ/Organization/Breadcrumb）・可視クイックアンサー・出典機械可読化 | CC→CX | 3クローラ（GPT/Perplexity/Gemini）で引用形が成立 |
| S3-2 | リブランド体系をPoCで先行（ブランド名「会計士とよむ決算」・会計士ガイドキャラA） | CC→CX | デザイン体系PoC確定 |
| S3-3 | 旧fic-investment.biz→新URLの301マッピング設計（切替はこの90日では実施しない） | CC→CX→FIC | マッピング表＋ロールバック手順 |
| S3-4 | 資産KPIの初回ベースライン計測（先行＝固定枠実装率／遅行＝月次プロンプト監査+GSCブランドクエリ） | CC | 第1回ベースライン記録 |
| S3-5 | （繰越枠）S2-1ストレッチ残（6〜8社）・S2-2繰越分 | CC→CX | 着手分の固定枠実装 |

**ゲート③（要FIC判断）**：本番301切替の可否（90日後の次フェーズ判断）

## KPI（2系統に分ける）
**(A) 90日の実務KPI**（このロードマップで動かす作業指標）
- 固定枠実装率：0% → TierA **上位5社で100%**（6〜8社はストレッチ）＝資産化の主指標
- 決算速報の橋：0本 → **1本試作**＋相互リンク成立
- AI被引用（遅行・代理指標）：ベースライン取得開始（月次プロンプト監査＋GSCブランドクエリ）

**(B) charter §7の事業KPI目標値**（数値目標・期限）＝**未確定。[#10](https://github.com/Ftomohiro0612/fic-investment-system/issues/10) に分離**。本ロードマップでは目標値を確定しない。

**ガードレール**：GSC流入/PV/広告収益を**下げ止め**（積極追求しない）。

## このロードマップに乗らない（明示的に外す）
PV/検索流入を北極星に戻すこと・薄いSEO量産・Yahoo/株探型データportal・読者別ルート/L1L2L3/アコーディオン（γ＝段階2保留）・本番301切替（次フェーズ）

## 運用メモ
- 各ゲートのFIC承認待ち日数はバッファとして扱う（スプリント内に織り込む）。
- TierA具体選定はFICの判断責任（CC提示→FIC選定）。
- Codexレビュー記録：2026-06-03 条件付きGO（id=395応答）。条件＝S2-1の5社必達化・S2-2のスコープ限定/時限化・ゲート①へschema凍結追加・KPI 2系統分離。
