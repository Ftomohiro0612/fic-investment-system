# CLAUDE.md — FIC投資分析システム（Claude Code 向け内部指示書）

このファイルはセッション開始時に自動読み込みされる。**人間向けの説明は README.md**、本ファイルは**Claude Code の作業規範**。Skillの中身は再掲せず参照する（重複させない）。

---

## 1. このリポジトリは何か

FIC投資研究所の**企業分析・業界分析の記事／X投稿／動画**を制作するシステム。公開先は WordPress（fic-investment.biz）。
- 制作系譜：**Make → (Codex + Claude) → Claude Code subagents 化（移行中）**。`make/` と `docs/make_*` は歴史的参照のみ（非稼働）。
- 現在は **Phase 5（Claude Code subagents 化のパイロット）の段階1**。設計の正本は `docs/chat_workflows/_analysis/`（特に `phase5_pilot_plan.md` / `phase4_final_design.md`）。

## 2. 進行中フェーズ（2026-05時点）

- **段階1（Skill先行作成）= ステップ4まで完了**。100点像確定済み。次は**ステップ5＝テンプレ全面15章化**（スコープは `phase5_pilot_plan.md` の「ステップ4後続」節）。
- 段階2＝writer/reviewer subagent作成 → 段階3＝王子HD(3861)パイロット → 段階4＝残りロール（scout/theme_scout/researcher/designer/videographer/x_writer）と各ロールSOPのSkill化。
- 進め方は **§3 進行管理ルール** に従う。

## 3. 進行管理ルール（全作業に効く中核原則）

記事生成・コミット・Skill更新・テンプレ作業など**すべて**に適用する。段階1ステップ4で3つの大見落とし（Step A発掘漏れ・新構成3章漏れ・動画SOP整合漏れ）を発見・修正できた中核原則。

1. **各段階・各タスクでFIC確認を経る**（独断で完成・確定させない）。
2. **判断分岐は選択肢付き（A/B/折衷）でFICに問う**（独断で折衷案を作らない）。
3. **骨格・スコープに関わる判断はFIC承認後にのみ進める**。
4. 細部の表現・実装方法はClaude Code判断でよいが、**迷ったら問う**。
5. **並行運用厳守**：進行中の作業を勝手に他と統合しない。既存Codexワークフローを壊さない。
6. **機密非出力**：認証情報・トークン・鍵の値をチャットに出さない。
7. **事実確認の優先順位 ＝ ①リポジトリ内（grep/read）→ ②外部情報（web_fetch/curl/WebSearch）→ ③FIC質問**。調べれば分かる事実はFICに判断を仰がず、**自分で確認してから提示**する。設計・分析タスクは**Phase 0**（参照記事を web_fetch/curl して構造・実装を悉皆確認）から始める。

## 4. Skill 参照ルール（記事制作の中核）

記事を書く／レビューする工程では、以下を**この順で**使う。中身は各SKILL.mdが正本。
1. **article-design-principles**（上位・設計）：公開15章構成・成長テーマ2段構え(3.4/8.3)・中計あり/なし分岐・入口/中身分離。最適化（優先動線/アコーディオン/L1L2L3）は§3-future＝段階2（採用しない）。
2. **chapter_design_guide.md**（`docs/chat_workflows/_analysis/`）：各章の目的／必須要素／王子HDからの改善点／やりがちな失敗。**横串原則**（章2.3=12.4=13.3、章10.1=13.2を同一KPI閾値）。
3. **writing-style**（文体）：工夫1（言い換え）/工夫2（業界固有比喩・冒頭のみ日常比喩）/工夫3（日常接点の例示）、💡（論点）/📘（用語定義）の機能分離、業界判定の定型句、監視指標トップ3〜5の選定4基準。
4. **fact-safety 3規律**：**source-hierarchy**（出所の質）→ **factual-handling-rules**（単位・年度・感応度・会社開示/外部推計/FIC前提付き試算）→ **expression-strength-rules**（誇張・断定の抑制、為替/市況/業績見通しの2段構成）。数値は source→factual→expression の順でinvoke。
5. **article-quality-checklist**（公開前ゲート・最終防壁）：B-0（15章構成）〜B-8（日常接点）＋2系統ラベル対応表。基盤は `prompts/shared/quality_checklist.md` の44項目。
- 工程間引き継ぎ＝**handoff-templates**、Sheets俯瞰メタ＝**sheets-status-update**。
- 動画/X/画像/WP の詳細ルールは**既存SOPが正本**（§5）。これらのSkill化は段階4。

## 5. 既存SOP（13分割ワークフロー）と正本の所在

1チャット=1工程の分割SOP：`docs/chat_workflows/company_01〜06_*.md`（企業）・`industry_01〜07_*.md`（業界）。整合監査は `_analysis/existing_sops_audit.md`。
- 記事構成/メモ：`docs/codex_company_analysis_pack_spec.md`、`docs/claude_integrated_memo_lessons.md`（統合メモ14章）。
- 動画：`docs/chat_workflows/company_06_codex_video.md`・`docs/video_review_notes.md`（尺・ストーリー・Shorts・サムネ・TTS・fic-lite-youtube-embed）。
- X投稿：`docs/x_post_company_analysis_workflow.md`・`prompts/social/x_post_*`。
- 画像/WP：`docs/non_ai_structure_chart_lessons.md`・`docs/wordpress_media_cleanup_policy.md`・`company_04`/`industry_05`。
- 編集方針：`docs/editorial_policy_final.md`。

## 6. ドメイン用語（略語の意味）

- **公開15章構成**：業界の風向き/投資仮説/勝ち筋とポジション/企業概要/収益構造/業績全体像/業績ドライバー/中計検証/業績シナリオ/先行指標と判定基準/競争優位・同業比較/リスク/まとめ/参照資料/FAQ。
- **ロール分担**：writer/reviewer＝記事制作コア（段階2）／researcher_company・industry＝投入パック作成／scout・theme_scout＝銘柄・テーマ候補選定／designer＝画像・WP反映／videographer＝動画／x_writer＝X投稿（designer・videographer・x_writerは段階4で追加）。
- **💡/📘**：💡=ワンポイント解説(beginner-box・論点のかみ砕き)、📘=用語解説(glossary-box・用語の定義)。📘はWP CSS定義（ステップ5）まで本番不使用（💡のみ）。
- **工夫1/2/3**：言い換え／業界固有比喩／日常接点の例示。**B2B対応（工夫3）**＝B2B専業は完成品レベルまで遡って例示、接点が極めて間接的なら産業レベルの存在感説明に切替。
- **2段構成**：会社前提を客観基準として明示＋FIC独自視点を補足（為替・市況・業績見通し）。
- **業界判定の定型句**：30秒要約に「業界判定：◯◯は『成熟＋構造転換期』等（後段で詳細）」を出す。
- **監視指標トップ3〜5**：選定4基準＝更新頻度・一次出典・波及ラグ・FIC試算不要（詳細 writing-style §9）。章10.1＝章13.2に同一指標。
- **横串原則**：下振れ条件＝反証条件＝見直しシグナルを同一KPI閾値で一貫。
- **株主還元方針の3要素**：配当・自社株買い・総還元性向。
- **一時要因と継続要因の区別**：本業利益（営業利益）と一時要因（特別損益・評価益・減損反動）を分けて読む。
- **γ（段階的採用）**：優先動線/アコーディオン/L1L2L3は公開標準で未実証のため段階2へ退避。
- **中計あり/なし分岐**：目標年度＋定量目標の有無で判定。なしは章8を「経営方針と成長戦略の検証」に切替。
- **fic-related-companies / fic-related-themes**：関連銘柄/テーマブロック（既存FIC記事URLがある場合のみ）。

## 7. 危険操作・ガード（`.claude/settings.json` deny と運用則）

- **本番WordPress**：既存投稿IDは**更新のみ**（新規作成しない）。**スラッグ変更禁止**。`article_title:` を `post_title` に明示（`<h1>` 抽出フォールバック禁止）。アイキャッチはユーザー明示なく変更しない。パイロットは下書き/テストIDのみ。
- **機密**：`.secrets/**`・`.codex/**`・`*credentials*`・`*-oauth-*`・`.env*` は読まない（deny済み）。値をチャットに出さない。鍵は実行時にfsで読み、内容はコンテキストに載せない（`scripts/sheets/update_sheet_row.mjs` 方式）。
- **git**：force push / reset --hard / `rm -rf` は禁止（deny）。コミット・プッシュはユーザー依頼時のみ。
- **`.claude/` 配下のWrite/Edit**：Claude Code のセキュリティ設計で**恒常的に承認ゲート**される（settings.jsonでは抑止不可・既知事項）。ポップアップは正常。セッション一時許可で進む。
- **`.claude/skills/` は読み取り専用扱い**：Skill本体は段階・ステップの承認を経てのみ更新する（勝手に書き換えない）。
- **`docs/chat_workflows/_analysis/` は追記専用**：既存の分析ファイルを削除しない（履歴・遡及参照のため）。
- **handoff_*.md は前工程の引き継ぎを尊重**：独自判断で書き換えない。
- **📘 glossary-box は WP CSS定義（ステップ5）まで本番不使用**（💡のみ運用）＝段階1ステップ4確定事項。
- 削除（画像・動画中間素材）は `wordpress_media_cleanup_policy.md` 準拠。`docs/reference_images/` は削除不可。

## 8. 出力フォーマット

- **記事**：`wordpress/templates/company_analysis_template.html` を雛形に。冒頭にメタコメント（`article_title:` / `slug:`）。外部URLは実在確認済みのみ・確認日併記。参照資料は最大8件（章順は参照→FAQ）。
- **JSON-LD（構造化データ）は記事HTMLで手動出力しない**。WordPress側で生成される：FAQPage・BlogPosting・Organization 等は **Rank Math**（SEOプラグイン）が自動生成、BreadcrumbList は theme `functions.php`（`fic_output_breadcrumb_json_ld`）が出力。→ writerは**FAQを通常のHTML構造**（faq-section内の H3=質問／p=回答）で書けば、Rank MathがFAQPage schemaを生成する。**FAQの見出し・本文構造を崩さない**ことが重要。
- **使用可能CSSクラス**：beginner-box（💡）/ glossary-box（📘・ステップ5でCSS定義）/ summary-box（30秒要約・章要点）/ table-wrapper / one-liner-summary / definition-lead / author-credit / disclaimer / fic-related-companies・fic-related-themes / fic-detail-block（段階2）。**表は必ず `table-wrapper` で内包**。
- **公開HTMLにmemo類のコメントを残さない**（`要確認`/`要追加確認`/`TODO`/`FIXME`/内部メモは公開HTMLに出さない。判断メモは `claude_review_notes.md` へ）。テンプレの雛形コメント・空プレースホルダは差し替え後に削除。
- **数値・年度**：単位はbillion→億円×10、`FY ⇔ ◯年◯月期` を1回対応づけ全文一致。会社開示値/外部推計/FIC前提付き試算を同一文中に明示（factual-handling-rules §6）。
- **handoff**：`work/{key}/handoff_{from}_to_{to}.md`（冒頭にステータスサマリ表）。
- **Sheets**：`FIC記事管理_v3`。ファイルパス＋ステータスのみ記録（`update_sheet_row.mjs --path-mode`）。ステータス語彙は `v3_ステータス定義` 準拠。
- 締め文（「以上」「〜をまとめました」）や再要約段落を末尾に付けない。

## 9. ファイルの歩き方

- 設計・分析の作業ドキュメント：`docs/chat_workflows/_analysis/`
- プロンプト：`prompts/`（article / search / seo / shared / social）
- スクリプト：`scripts/{category}/{action}.mjs`（例 `scripts/sheets/update_sheet_row.mjs`、WPは `scripts/wordpress/`）
- パイロット成果物：`work/company_analysis/{code}_{name}/`
