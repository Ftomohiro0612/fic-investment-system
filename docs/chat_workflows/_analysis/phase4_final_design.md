# フェーズ4: 最終確定設計（Skills / Subagents / Codex残置 / 認証 / 二重チェック）

[phase3_design_direction.md](phase3_design_direction.md) の方針と、FICによる (6)(7)(5) ＋ 認証マッピング・
handoffテンプレ・scout/pilot確定を反映した最終設計の正本記録。実装はフェーズ5（[phase5_pilot_plan.md](phase5_pilot_plan.md)）。

> すべての確定事項を反映済み。(6-4) handoff冒頭テンプレも受領・反映済み（§8）。

---

## 1. 確定した方針判断（(6)(7)(5)）

| 項目 | 確定 | 要点 |
|---|---|---|
| 6-1 ファクト規律 | 3段維持 | researcher予防→writer確認→reviewer最終ゲートで各々invoke |
| 6-2 スラッグ/ID | 最終ゲート絶対維持 | 過去にスラッグ変更でSEO/GEO評価リセットの致命事故。`wordpress-publishing`最重要事項に明記 |
| 6-3 品質チェック | 2回実行を前提化 | writer自己チェック＋reviewerゲート |
| 6-4 handoff/Sheets | 完全分離しない | handoff冒頭にステータス要約（Sheets同期項目）を必須化。テンプレ確定（§8） |
| 7-1 fact-safety粒度 | 分離維持 | source-hierarchy / expression-strength-rules / factual-handling-rules の3独立Skill |
| 7-2 writing-style | 横断Skillへ昇格＋戦略明文化 | キオさん的・初心者間口拡大。分析深度と会計士信頼性は維持 |
| 7-3/5 認証方式 | 段階的（フェーズ5=段階1直読み） | フェーズ6で実行スクリプト分離を検討 |
| 7-4 reviewer | 独立役員 | コンテキスト分離・並列実行 |
| 7-5 researcher | 企業/業界に分割 | researcher_company / researcher_industry |
| 7-7 handoff置き場 | 各 `work/{...}/{key}/` 内 | |
| 7-8 保存パス呼称 | `docs/chat_workflows/_analysis/` のまま | |

---

## 2. 最終Skillリスト（15）

| # | Skill | 役割(1行) | 集約元 | 参照役員 |
|---|---|---|---|---|
| 1 | `source-hierarchy` | 出典の品質階層と弱出典禁止 | company_spec§4, industry_spec出典節, quality_checklist | researcher_*, writer, reviewer, theme_scout, scout |
| 2 | `expression-strength-rules` | 表現強度・禁止表現と公式より強い断定の抑制 | integrated_memo§8, specs各所, quality_checklist | writer, reviewer, x_writer, videographer |
| 3 | `factual-handling-rules` | 数値/単位/会計地雷（×10換算, セグメント推定禁止, YoY±50%注記, 年度, 感応度符号） | integrated_memo§5-19, company_spec§4 | researcher_*, writer, reviewer |
| 4 | `related-stocks-classification` | 関連銘柄4分類＋サプライチェーン3区分＋接続ゲート | company_spec, industry_spec§3, internal_link_rules | researcher_*, writer, reviewer |
| 5 | `article-quality-checklist` | 公開前セルフチェック(grep含む)。企業/業界統一 | quality_checklist.md, company_03, company_spec§6, industry_04, integrated_memo§19 | writer, reviewer |
| 6 | `writing-style` | 初心者間口拡大の文体戦略（深度・信頼性は維持） | prompts/shared/writing_style, seo/intro_rules, seo/title_rules ＋新戦略 | writer, x_writer, videographer, scout, theme_scout（reviewerは基準チェック） |
| 7 | `stock-selection-criteria` | 企業の銘柄選定基準（候補提示まで） | 新規（GPT手運用の明文化） | scout |
| 8 | `theme-selection-criteria` | 業界テーマ候補生成・整形・A/B/C評価 | trend_list_main, trend_validation_main, industry_specシナリオ1 | theme_scout |
| 9 | `chart-templates` | 非AI図表(SVG/React)テンプレと見やすさ規律 | non_ai_structure_chart_lessons, industry_spec非AI節 | designer, videographer, writer(候補) |
| 10 | `ai-image-prompt-rules` | AI画像プロンプトの型とCodex発注書 | industry_spec画像プロンプト, video_review_notesサムネ | designer |
| 11 | `video-script-rules` | 王子HD型/尺/シーン毎TTS/lite embed | video_review_notes.md（VIDEO_SCRIPT_RULES.md叩き台） | videographer |
| 12 | `x-post-patterns` | post1〜4・3本選抜・文字数/タグ/決算メモ連動 | x_post_company/industry_main, x_post_workflow | x_writer |
| 13 | `handoff-templates` | `handoff_{from}_to_{to}.md` 書式・命名＋冒頭ステータス要約必須(§8) | 全handoff, §7.4品質ループ | 全役員 |
| 14 | `sheets-status-update` | Sheets俯瞰メタ更新の共通手順（列の意味/書式/エラー時） | spec各シート連携節, v3列定義, update_sheet_row.mjs | 全役員 |
| 15 | `wordpress-publishing` | WP REST反映/**既存ID更新・スラッグ絶対固定(最重要)**/アイキャッチ/メディア削除 | wordpress_media_cleanup_policy, spec§7.2/7.3, v3列 | designer |

### `writing-style` SKILL.md 目次案（詳細）

1. **戦略的背景**: 初心者投資家への間口拡大（X人気投資家「キオ」さん的）。不変条件＝分析深度（上流→KPI→業績）と会計士・税理士の信頼性。変える点＝口調と表現。
2. **工夫1（必須）専門用語の即時言い換え**: 「つまり」「ざっくり言うと」＋例（営業利益率15%改善＝100円売って15円多く残る）。
3. **工夫2（必須）例え話・メタファー**: パルプ価格＝製紙会社の小麦粉、等。
4. **トーンの境界線**: OK＝親しみやすい一人称・カジュアル接続詞・軽い疑問形／NG＝過度な感嘆符・ネットスラング・絵文字多用・タメ口。
5. **媒体別の適用度**: 記事本文＝工夫1+2全面／X＝工夫1中心・文字数内／動画ナレ＝工夫1口語・耳で分かる長さ／テロップ＝工夫1のみ極限短縮／summary-box＝工夫1中心・結論優先。
6. **役員別の使い方**: writer/x_writer/videographer/scout/theme_scout が適用。reviewerはこの基準でチェック。

---

## 3. 最終Subagentリスト（9役員）

**完了時の必須アクション（全役員共通）**: ①handoff_*.md作成（冒頭にステータス要約＝§8） ②Sheets該当列更新 ③reportに「handoff作成済み・Sheets更新済み」を明記。

| 役員 | 担当工程 | 触ってよいフォルダ | 使用Skills | 並列可能 | 入力 | 出力 |
|---|---|---|---|---|---|---|
| **scout** | 新設(企業銘柄選定) | `work/company_analysis/_candidates/`, 企業銘柄候補タブ(§6) | stock-selection-criteria, source-hierarchy, writing-style, sheets-status-update | theme_scout | FIC指示・ニュース/IR | FIC（候補）→採択後 researcher_company |
| **theme_scout** | 業界01 | `work/industry_analysis/_trend_research/`,`YYYY-MM-DD/`, 業界タブB-M | theme-selection-criteria, source-hierarchy, writing-style, sheets-status-update | scout | FIC指示・ニュース束 | FIC（A/B/C候補）→採択後 researcher_industry |
| **researcher_company** | 企業01 | `work/company_analysis/{key}/` | source-hierarchy, factual-handling-rules, related-stocks-classification, handoff-templates, sheets-status-update ＋ company_spec/v4正本 | 別案件 | 採択企業 | writerへ投入パック＋`handoff_researcher_company_to_writer.md` |
| **researcher_industry** | 業界02 | `work/industry_analysis/{slug}/` | 同上 ＋ industry_spec正本 | 別案件 | 採択テーマ | writerへ投入パック＋`handoff_researcher_industry_to_writer.md` |
| **writer** | 企業02/業界03 | 同 `{key}/` | article-quality-checklist, source-hierarchy, expression-strength-rules, factual-handling-rules, related-stocks-classification, writing-style, handoff-templates ＋記事/メモ正本 | 別案件 | 投入パック | reviewerへ記事3点＋`handoff_writer_to_reviewer.md` |
| **reviewer** | 企業03/業界04(編集判断) | 同 `{key}/` | article-quality-checklist, source-hierarchy, expression-strength-rules, factual-handling-rules, related-stocks-classification, writing-style(基準), handoff-templates | 別案件 | writer記事3点＋**Codexファクトチェック結果** | designerへ`handoff_reviewer_to_designer.md`（修正はwriter差し戻し） |
| **designer** | 企業04/業界05＋**WP反映** | `{key}/`,`{key}/images/`, wordpress/snippets(必要時) | chart-templates, ai-image-prompt-rules, wordpress-publishing, handoff-templates, sheets-status-update | videographer | reviewer確定HTML | x_writer/videographerへhandoff。AI画像は`handoff_designer_to_codex_image.md`。**WP公開実施** |
| **videographer** | 企業06/業界07(台本・図解素材) | `{key}/video/`, assets/videos | video-script-rules, chart-templates, writing-style, expression-strength-rules, handoff-templates, sheets-status-update | x_writer | designer確定HTML＋画像 | Codexへ`handoff_videographer_to_codex_render.md`(TTS/レンダ/アップ) |
| **x_writer** | 企業05/業界06 | 同 `{key}/`(メモ), 各タブX列 | x-post-patterns, expression-strength-rules, factual-handling-rules, writing-style, handoff-templates, sheets-status-update | videographer | designer確定HTML＋記事URL | **Sheets(AU/AV)に投稿文記録**（最終投稿はFIC手動・x-api.jsonは触らない）＋handoff |

**並列ペア**: ①`x_writer ∥ videographer`（designer完了後）。②案件横断で全役員（フォルダ分離）。③`scout`/`theme_scout` は本線から独立バッチ。
**直列必須**: `researcher_* → writer → reviewer → designer`。writer⇄reviewerは内部ループ。

---

## 4. Codexに残す工程（4＋1）

AI画像生成（OpenAI系API・FIC独自絵柄再現） / TTS音声生成 / 動画レンダリング / YouTubeアップロード（OAuth管理）。
補助: Codexファクトチェック（一次資料パック保持、reviewer前段）。
→ WordPress反映・Sheets更新はClaudeへ完全集約（Codex残置から除外）。

---

## 5. 認証情報の配置（確定・段階1＝フェーズ5）

`.secrets/` 配下に8つのJSONを配置済み（FIC手動完了）。Claude Codeでの扱い:

| # | ファイル | 用途 | Claude Code | 利用役員 |
|---|---|---|---|---|
| 1 | `coastal-mercury-495123-k5-83baf0c72a93.json` | GCPサービスアカウント鍵(Sheets API) | **allow(読む)** | 全役員(Sheets更新共通) |
| 2 | `wp-app-password.json` | WordPress Application Password | **allow(読む)** | designer |
| 3 | `fic-wp.json` | Codexログインキー | deny | （Codex専用） |
| 4 | `sandbox_users.json` | Codex sandbox設定 | deny | （Codex専用） |
| 5 | `x-api.json` | 現状未使用（フェーズ6再検討） | deny | （未使用） |
| 6 | `youtube-oauth-token.json` | YouTube OAuth（Codex経由） | deny | （Codex専用） |
| 7 | `google-oauth-client.json` | Claudeログイン用 | 自動利用（明示的に意識しない） | — |
| 8 | `google-oauth-token.json` | 同上 | 自動利用 | — |

**設計の肝**: 1・2を読む際も値はチャット/トランスクリプトに出さない（スクリプトが実行時に読む運用を基本）。段階2（フェーズ6）でスクリプト経由化。

### .claude/settings.json 調整（フェーズ5段階0で適用予定）
- allow 追加: `Read(.secrets/coastal-mercury-495123-k5-83baf0c72a93.json)`, `Read(.secrets/wp-app-password.json)`
- deny 追加: `Read(.secrets/fic-wp.json)`, `Read(.secrets/sandbox_users.json)`, `Read(.secrets/x-api.json)`, `Read(.secrets/youtube-oauth-token.json)`, `Read(.codex/**)`, `Read(C:/Users/tomo-/.codex/**)`, `Read(./.env*)`, `Read(./data/.gcp-sheets-credentials.json)`

### .gitignore 追加（フェーズ5段階0で適用予定）
```
.secrets/
*.env
credentials.json
*-credentials.json
*-oauth-*.json
wp-app-password.json
x-api.json
```

---

## 6. scout 出力先（確定）：新タブ「企業銘柄候補」

企業分析タブはA〜AZの工程管理用で、銘柄選定の評価/候補/見送りを記録する列が無く、列文字でスクリプト参照されるため途中挿入不可（C-5の非対称が列レベルでも実証）。→ **新タブ「企業銘柄候補」を新設**。

想定列構成（暫定）:

| 列 | 内容 |
|---|---|
| A | 候補ID |
| B | 銘柄コード |
| C | 企業名 |
| D | scout提示日 |
| E | 評価(A/B/C) |
| F | 選定理由 |
| G | 関連テーマ |
| H | 想定インプレッション要因 |
| I | FIC判断 |
| J | 採用後の企業分析タブrow番号 |
| K | メモ |

FICが「採用」にした候補だけ企業分析タブへ新規行として転記。新体制ではAF/AG「GPTレビュー」列はreviewer(Claude)が担う（リネーム任意）。

参考: 企業分析タブ実列構成（A〜AZ／取得済み）は省略。詳細は本ファイル旧版および実シート参照。要点 — 入口A/基本B-J/資料URL K-O/Codex要約 P-U/FMP・Web補足 V-Y/Claude投入 Z-AA/Claude出力 AB-AE/レビュー AF-AL/WP・シート AM-AO/状態 AP-AS/X投稿 AT-AV/画像 AW-AY/動画 AZ。

---

## 7. 二重チェック（確定・維持）

1. ファクト規律3段（researcher/writer/reviewer+Codex）= 各々invoke維持。
2. 既存ID更新・スラッグ固定 = `wordpress-publishing`最重要事項＋designer実行時最終ゲート必須。
3. writer自己チェック＋reviewerゲート = 2回実行を前提化。
4. handoff冒頭ステータス要約 ＋ Sheets俯瞰メタ = 一部重複させ、Sheetだけで進捗が分かるようにする（テンプレ§8）。

---

## 8. handoff 冒頭テンプレ（確定・handoff-templates Skill に組み込む）

```markdown
# handoff_{from}_to_{to}.md

## ステータスサマリ(Sheets同期項目)

| 項目 | 内容 |
|------|------|
| 案件キー | {例: 3861_oji_holdings} |
| 工程 | {例: 画像作成} |
| 担当役員 | {例: designer} |
| 次工程 | {例: publisher} |
| 状態 | {完了 / 部分完了 / エラー} |
| 完了時刻 | {YYYY-MM-DD HH:MM} |
| 所要時間 | {分} |
| 成果物パス | {ファイルパス} |
| Sheets同期列 | {例: AW=完了, AX=AI2+非AI3} |

---

## 1. 完了内容(何を作ったか)
## 2. 判断ログ(なぜそうしたか)
## 3. 未完了/保留事項
## 4. 次工程への指示
## 5. 注意事項/リスク
## 6. 関連ファイル一覧
## 7. 連絡事項(FIC向け)
```
</content>
