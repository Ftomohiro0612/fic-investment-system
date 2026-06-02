# Project Charter — FIC投資研究所

## 1. 基本情報

| 項目 | 値 |
|---|---|
| 対応repo | `Ftomohiro0612/fic-investment-system` |
| オーナー | Fukunaga（info@fic-investment.biz） |
| プロジェクトPM | AI PM候補（暫定 / Claude Code） |
| 優先度 | 高（正本は [project-map.md](https://github.com/Ftomohiro0612/ai-agent-control-center/blob/main/docs/project-map.md)。[DEC-2026-06-02-project-scope-and-priority](https://github.com/Ftomohiro0612/ai-agent-control-center/blob/main/docs/decision-log/2026-06-02-project-scope-and-priority.md) で確定） |
| charter状態 | 初版完成（KPI目標値のみ §7 で確認待ち） |
| 最終更新日 | 2026-06-02 |

## 2. 目的・対象（Why / Who）

`fic-investment.biz` で、企業分析・業界分析・投資の読み方を、**会計士視点の分析深度を保ちつつ初心者にも分かりやすく**届ける投資情報メディア。従来の「記事が並ぶサイト」から、読者が目的別（企業／テーマ／投資の読み方／決算予定）に入口を選べるメディアへ移行中。対象は、投資判断の材料を自分で調べたい個人投資家・投資初学者。

## 3. 価値・収益方針

- 区分: 収益化
- 補足: 広告・アフィリエイト。検索流入・PVを増やし、広告／アフィリエイト経由で収益を得る。

## 4. 成功条件

主要KPIは検索流入・PVの成長。具体的な目標値・期限はオーナー確認待ち（§7）。

| 指標 / 状態 | 現在 | 目標 | 期限 |
|---|---|---|---|
| 検索流入（GSC） | 未測定値の整理中 | 未確定（オーナー判断待ち） | 未確定 |
| 月間PV（GA4） | 未測定値の整理中 | 未確定（オーナー判断待ち） | 未確定 |

## 5. 直近の重点（1〜3か月）

- トップページ・ハブ（企業／テーマ／投資の読み方／決算予定）からの回遊導線の磨き込みと、記事本文の初心者向け説明強化（H2/H3階層化の運用定着）
- Search Console / GA4 のデータをもとにした既存記事のSEOタイトル・導入・内部リンク改善
- 記事制作フローの subagent 化（Phase 5: writer/reviewer/researcher 系の整備、業界分析パイロット）

## 6. やらないこと・制約

- **投資助言・投資推奨はしない／情報提供に徹する**。個別銘柄の売買推奨や、金商法上の投資助言に該当する活動は行わない。記事は企業・業界の分析と一般的な「投資の読み方」の解説にとどめる（表現規律は既存 `expression-strength-rules` / `factual-handling-rules` / `source-hierarchy` の3規律で担保）。
- 独自CMSは作らず、既存WordPress（fic-investment.biz）で運用する。
- 認証情報・token・secret・OAuth実体はGit管理しない。
- 本番WordPress投稿は更新のみ（新規IDの無断作成・スラッグ変更はしない）。

## 7. 判断待ち（オーナー / PM 確認待ち）

- §4 KPI目標値・期限の確定（検索流入・月間PVの具体目標と達成期限。現状値は GSC/GA4 の整理後に記入）— 追跡: [#10](https://github.com/Ftomohiro0612/fic-investment-system/issues/10)（専用Issue起票後に差し替え）
- （§3 収益方針・§6 投資助言の線引きは 2026-06-02 オーナー確認により確定）

---

## フッター（本文ではなく索引・履歴）

### 関連リンク

- GitHub repo: https://github.com/Ftomohiro0612/fic-investment-system
- GitHub Project: AI Agent Control Center
- 最新の週次報告: （未作成）
- 直近の重要 decision-log: [DEC-2026-06-02-project-scope-and-priority](https://github.com/Ftomohiro0612/ai-agent-control-center/blob/main/docs/decision-log/2026-06-02-project-scope-and-priority.md)
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
