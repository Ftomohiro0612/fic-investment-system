# Project Charter — FIC投資研究所

## 1. 基本情報

| 項目 | 値 |
|---|---|
| 対応repo | `Ftomohiro0612/fic-investment-system` |
| オーナー | Fukunaga（info@fic-investment.biz） |
| プロジェクトPM | AI PM候補（暫定 / Claude Code） |
| 優先度 | 高（正本は [project-map.md](https://github.com/Ftomohiro0612/ai-agent-control-center/blob/main/docs/project-map.md)。[DEC-2026-06-02-project-scope-and-priority](https://github.com/Ftomohiro0612/ai-agent-control-center/blob/main/docs/decision-log/2026-06-02-project-scope-and-priority.md) で確定） |
| charter状態 | 初版完成（KPI目標値のみ §7 で確認待ち） |
| 最終更新日 | 2026-06-03 |

## 2. 目的・対象（Why / Who）

日本株の決算を、**一次資料に基づくFIC独自の会計士分析**で読み解く投資情報メディア（ブランド「会計士とよむ決算」）。**会計士視点の分析深度を保ちつつ初心者にも分かりやすく**届ける。対象は、投資判断の材料を自分で調べたい個人投資家・投資初学者。

**根幹方針（AI時代の資産化・2026-06-03オーナー承認）**：クリックを奪い合うメディアではなく、**信頼される・構造化された・更新され続ける"分析資産"**にする。**人が常連として戻り、AIが出典として引用する**二方向の依存を作ることで、AI時代に埋もれない資産を目指す。柱は①判断（責任ある会計士の見立て）②構造（ドライバー/KPI/反証条件/バリュエーション/出典/更新履歴の定型枠＝最優先）③鮮度（決算速報の定点運用）④信頼ブランド ＋⑤AI引用前提設計。正本＝[DEC-2026-06-03-ai-era-analysis-asset-direction](https://github.com/Ftomohiro0612/ai-agent-control-center/blob/main/docs/decision-log/2026-06-03-ai-era-analysis-asset-direction.md)。

## 3. 価値・収益方針

- 区分: 収益化
- **短期（燃料・最低維持ライン）**: 広告・アフィリエイト。検索流入・PVを維持し、広告／アフィ経由で収益を得る（※PVは"捨てない"が、北極星ではなく**ガードレール指標**に位置づける＝§4）。
- **中期（資産化に伴う収益）**: 更新される銘柄台帳・決算ウォッチ・反証条件アラート等を商品化できて初めて、購読・有料が現実的。スポンサーは、**投資助言でない線引き＋利益相反開示**を前提に検討余地（未確定）。

## 4. 成功条件

**北極星＝資産KPI**（資産化の進捗を測る）：①ブランド指名・常連回帰 ②AI被引用 ③決算速報の定点運用 ④判断の深さ・独自角度。AI被引用・ブランド指名は**遅行指標**のため、初期は**先行指標＝「構造化テンプレ（固定枠）の実装率」**を主に追う。具体目標値・期限はオーナー確認待ち（§7・[#10](https://github.com/Ftomohiro0612/fic-investment-system/issues/10)）。

| 区分 | 指標 | 測り方（初期） |
|---|---|---|
| 先行（資産） | 構造化テンプレ実装率 | 固定枠（thesis/drivers/KPI/valuation/反証条件/sources/updated_at）が揃う銘柄ページ比率 |
| 遅行（資産） | AI被引用・ブランド指名 | 月次手動プロンプト監査（ChatGPT/Perplexity/Gemini）＋GSCブランドクエリ＋GA4 direct/returning＋AI系referrer＋外部引用・SNS言及 |
| ガードレール | 検索流入（GSC）／月間PV（GA4）／広告・アフィ収益 | 最低維持ライン（下げ止め）。目標値はオーナー判断待ち |

## 5. 直近の重点（90日ロードマップ）

> 詳細・確定版＝[docs/roadmap_90day.md](roadmap_90day.md)（v2・Codex条件付きGO反映済 2026-06-03。FICが判断をCodexに委任→条件付きGO→条件反映で確定）。以下は要約。
> 実行優先順（Codex既GO）：**②構造 → ①判断 → ④ブランド → ③鮮度**。スプリント＝30日×3。

- **Sprint 1（6/3〜7/3）②構造**：固定枠スキーマ（thesis/drivers/KPI/valuation/反証条件/sources/updated_at＋限界明記）を確定→Astro schema化→キオクシアで全枠充足→**schema凍結**→TierA最終選定。キオクシアのハブPoC仕上げを並行。ゲート①＝schema凍結＋TierAリスト確定（要FIC承認）。
- **Sprint 2（7/4〜8/3）①判断＋③橋の試作**：TierAを固定枠で構造化（**5社必達／6〜8社ストレッチ**）。決算速報＝**橋の試作1本**（キオクシア・noindex・相互リンク・反証条件ログに限定、固定枠確定後の時限タスク、遅延時S3繰越）。編集確定原則をwriter/reviewer SOPへ恒久ルール化。ゲート②＝二層構造の運用可否（要FIC承認）。
- **Sprint 3（8/4〜9/1）⑤AI引用＋④ブランド＋切替準備**：llms.txt・JSON-LD・可視クイックアンサーで「AIに引用される側」に。リブランド体系PoC先行。旧→新301マッピング設計（切替は次フェーズ）。資産KPI初回ベースライン計測。
- **KPI 2系統**：(A)90日実務KPI＝固定枠実装率（TierA上位5社100%）／速報橋1本／AI被引用ベースライン。(B)charter §7事業KPI目標値は[#10](https://github.com/Ftomohiro0612/fic-investment-system/issues/10)に分離（本ロードマップでは確定しない）。ガードレール＝GSC流入/PV/広告収益の下げ止め。
- 並行：**Astro 移行 PoC**（[#23](https://github.com/Ftomohiro0612/fic-investment-system/issues/23)）＝資産化の"器"。記事制作フローの subagent 化（Phase 5）。
- ※すべて根幹方針（[DEC-2026-06-03-ai-era-analysis-asset-direction](https://github.com/Ftomohiro0612/ai-agent-control-center/blob/main/docs/decision-log/2026-06-03-ai-era-analysis-asset-direction.md)）に収束。

## 6. やらないこと・制約

- **投資助言・投資推奨はしない／情報提供に徹する**。個別銘柄の売買推奨や、金商法上の投資助言に該当する活動は行わない。記事は企業・業界の分析と一般的な「投資の読み方」の解説にとどめる（表現規律は既存 `expression-strength-rules` / `factual-handling-rules` / `source-hierarchy` の3規律で担保）。
- **公開プラットフォームは WordPress → Astro（静的サイトジェネレータ）へ段階的に移行する**（2026-06-02 オーナー決定・[DEC-2026-06-02-astro-migration-and-rebrand](https://github.com/Ftomohiro0612/ai-agent-control-center/blob/main/docs/decision-log/2026-06-02-astro-migration-and-rebrand.md)・追跡 [#23](https://github.com/Ftomohiro0612/fic-investment-system/issues/23)）。独自CMSは作らない方針は維持（Astro は SSG であり独自CMS開発ではない）。**即時の全面移行はしない**＝①WP維持で摩擦修正→②新ドメインで PoC（新ブランド・3記事・schema・検索・関連・計測）→③URL/SEO棚卸し＋旧→新301設計→④パリティ確認後に計画的301切替、の段階を踏む。リブランド（ブランド名「会計士とよむ決算」）は WP で作り込まず新 Astro サイト側で本実装する。
- 本番 WordPress 投稿は更新のみ（新規IDの無断作成・スラッグ変更はしない）。移行完了までは現行 WP を正本として維持する。
- 認証情報・token・secret・OAuth実体はGit管理しない。

## 7. 判断待ち（オーナー / PM 確認待ち）

- §4 KPI目標値・期限の確定（検索流入・月間PVの具体目標と達成期限。現状値は GSC/GA4 の整理後に記入）— 追跡: [#10](https://github.com/Ftomohiro0612/fic-investment-system/issues/10)（専用Issue起票後に差し替え）
- （§3 収益方針・§6 投資助言の線引きは 2026-06-02 オーナー確認により確定）

---

## フッター（本文ではなく索引・履歴）

### 関連リンク

- GitHub repo: https://github.com/Ftomohiro0612/fic-investment-system
- GitHub Project: AI Agent Control Center
- 最新の週次報告: （未作成）
- 直近の重要 decision-log: [DEC-2026-06-03-ai-era-analysis-asset-direction](https://github.com/Ftomohiro0612/ai-agent-control-center/blob/main/docs/decision-log/2026-06-03-ai-era-analysis-asset-direction.md)（**根幹方針＝AI時代の資産化**）／[DEC-2026-06-02-astro-migration-and-rebrand](https://github.com/Ftomohiro0612/ai-agent-control-center/blob/main/docs/decision-log/2026-06-02-astro-migration-and-rebrand.md)（プラットフォーム移行・リブランド）
- 追跡アンカー: [Issue #10](https://github.com/Ftomohiro0612/fic-investment-system/issues/10)

### 用語・フェーズ定義の在処（索引）

本charter・[Issue #10](https://github.com/Ftomohiro0612/fic-investment-system/issues/10) に出てくる記事制作ワークフローのフェーズ（`Phase1〜5`）の定義は下記にある（用語の中身は本フォルダが正本。ここは「どこを見れば分かるか」の索引）：

- `Phase1〜2`（現状整理） → `docs/chat_workflows/_analysis/phase1_2_current_state.md`
- `Phase3`（設計方針） → `docs/chat_workflows/_analysis/phase3_design_direction.md`
- `Phase4`（確定設計） → `docs/chat_workflows/_analysis/phase4_final_design.md`
- `Phase5`（パイロット計画＝writer/reviewer/researcher系のsubagent化） → `docs/chat_workflows/_analysis/phase5_pilot_plan.md`

### 変更履歴

| 日付 | 変更者 | 変更内容 | 紐づく decision-log |
|---|---|---|---|
| 2026-06-02 | AI PM候補（Claude Code） | charter初版ドラフト作成（§2/§5起案、§3/§4/§6/§7 確認待ち） | DEC-2026-06-02-management-fields-and-charter |
| 2026-06-02 | AI PM候補（Claude Code） | オーナー確認で §3 収益方針（収益化＝広告・アフィリエイト）・§4 KPI（検索流入・PV成長）・§6 投資助言の線引き（助言せず情報提供に徹する）を確定。残 §7＝KPI目標値 | DEC-2026-06-02-management-fields-and-charter |
| 2026-06-02 | 統括PM代行（Claude Code） | フッターに「用語・フェーズ定義の在処（索引）」を追加し Phase1〜5 の定義文書をリンク（散らばり防止の共通ルール） | DEC-2026-06-02-management-fields-and-charter |
| 2026-06-02 | 暫定PM（Claude Code） | §6 を「独自CMSは作らず既存WordPress」から「WordPress → Astro 段階移行＋リブランド」へ改訂、§5 に Astro PoC 着手を追加、フッターの直近 decision-log を差し替え | DEC-2026-06-02-astro-migration-and-rebrand |
| 2026-06-03 | 暫定PM（Claude Code） | 根幹方針「AI時代の資産化」をオーナー承認。§2 目的に資産化方針を追記、§3 を短期収益（ガードレール）＋中期収益に再構成、§4 を資産KPI（先行＝構造テンプレ実装率／遅行＝AI被引用・ブランド指名）＋PV/収益ガードレールへ、§5 を90日ロードマップ（構造テンプレPoC→重点銘柄定点→AI引用設計）へ改訂 | DEC-2026-06-03-ai-era-analysis-asset-direction |
| 2026-06-03 | 暫定PM（Claude Code） | 90日ロードマップを実行版（v2）に具体化＝[docs/roadmap_90day.md](roadmap_90day.md)新設（30日×3スプリント・依存順・判断ゲート・先行KPIベースライン）。§5 を参照型要約に更新。承認経路＝FICが判断をCodexに委任→Codex条件付きGO（S2-1の5社必達化・S2-2スコープ限定/時限化・ゲート①へschema凍結追加・KPI 2系統分離）反映 | DEC-2026-06-03-ai-era-analysis-asset-direction |
