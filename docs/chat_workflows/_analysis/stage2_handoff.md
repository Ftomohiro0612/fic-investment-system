# 【引き継ぎ文書】FIC投資分析システム Phase 5・段階2（writer/reviewer Subagent作成）着手用

このドキュメントは、別チャットで段階2を着手するための完全引き継ぎです。冒頭でこれを読めば、背景・前提・確定事項を把握できます。詳細は各正本ファイル（リポジトリ内）を直接参照してください。

---

## ■ プロジェクト全体像と前提

### FIC概要
FIC投資研究所の **企業分析・業界分析の記事／X投稿／動画** を制作するシステム。公開先は WordPress（fic-investment.biz）。公認会計士・税理士視点と「上流環境→個別企業の因果」を強みとする投資分析メディア。

### プロジェクト目標
記事/X/動画の制作を **Make →(Codex+Claude)→ Claude Code subagents 化** へ移行する（Phase 5パイロット）。`make/` と `docs/make_*` は歴史的参照のみ（非稼働）。

### 段階マップ
- 段階0（環境準備）✅完了
- **段階1（Skill先行作成）✅完了**
- **段階2（writer/reviewer Subagent作成）✅完了**（`.claude/agents/writer.md`・`reviewer.md`）
- 段階3（キオクシア 285A パイロット）← 次
- 段階4（残り7 Subagent＋残りSkill）

正本計画：`docs/chat_workflows/_analysis/phase5_pilot_plan.md`

### プロジェクトパス
`c:\Users\tomo-\Documents\FIC\fic-investment-system`（Windows・PowerShell・git main運用）

---

## ■ 今回（段階1〜2）の混乱から得た教訓（新チャット必読）

段階1〜2で実際に起きた混乱の再発防止策。新チャットはここを最初に押さえること。

1. **決定の「背景・なぜ」を必ず引き継ぐ（結論だけ渡さない）**：段階1で3つの大見落とし（Step A発掘漏れ・新構成3章漏れ・動画SOP整合漏れ）が発生した。結論だけを引き継ぐと、新チャットが背景を知らずに前提を誤読し、確定済み事項を蒸し返す／別方向に作り直すリスクがある。本書§「主要決定の『なぜ』」を必ず読む。決定を更新するときは**結論と同時に理由も更新**する（理由のない決定は引き継ぎ failure）。

2. **Make時代の前提を引きずらない**：`make/`・`docs/make_*` は非稼働の歴史的参照のみ（Make → Codex+Claude → Subagent化へ移管済み）。旧ワークフローの制約を「現行仕様」と誤認しないこと。典型例＝**reviewer別ファイル方式**（`codex_reviewed_article.html`）は「Codexは再執筆できない」という旧制約の名残であり、writer/reviewerが両方Claudeになる段階2では**writer上書き＋差し戻しループ**が正攻法。旧方式に戻すのは設計後退。Codex時代のSOP文言（`company_02_claude_article.md`・`company_03_codex_review.md` 等）も段階4で書き換え予定の旧前提。

3. **メタ作業と本作業を区別する**：「Skill／テンプレ／handoff／チェックリストを整備する作業（＝メタ・道具づくり）」と「実際に記事を書く作業（＝本作業・道具を使う）」は別物。**段階1〜2はメタ作業、段階3が初めての本作業**。チェックリストや定義をいくら磨いても記事は1本も完成していない——メタ作業の精緻化を本作業の進捗と混同しない。段階3では「道具（Skill・テンプレ・差し戻しループ）が実際に機能するか」を本作業を通して検証する。

---

## ■ 確立済みの重要概念・ルール（段階1で確定）

> 詳細はすべて `.claude/skills/` の各 SKILL.md が正本。以下は要約。

### 記事構成・設計（正本＝article-design-principles）
- **公開15章構成**（現行標準。王子HD・日本製紙の公開記事で実証）：
  1.業界の風向き／2.投資仮説／3.業界の勝ち筋と当社ポジション／4.企業概要／5.収益構造／6.業績の全体像／7.業績ドライバー／8.中期経営計画の妥当性検証／9.業績シナリオ／10.先行指標と四半期決算の判定基準／11.競争優位性と同業比較／12.リスク／13.まとめ（投資仮説・確認ポイント・反証条件）／14.参照資料／15.FAQ。**章順は参照→FAQ**。
- **冒頭部**：one-liner-summary／definition-lead／💡30秒要約／（任意）動画。
- **成長テーマ2段構え**：章3.4＝戦略レイヤー（方向性2〜3軸）／章8.3＝具体案件レイヤー（提携先・投資額・収益貢献時期・量産リスク・寄与度）。3.4の各軸を8.3で個別検証。
- **中計あり/なし分岐**：目標年度＋定量目標の有無で判定。なしは章8を「経営方針と成長戦略の検証」に切替（"ハコ"維持・15章を崩さない）。
- **入口/中身の役割分離**：入口（タイトル＋30秒要約）＝数字＋疑問形で強め可／本文・締め＝誠実＋両論併記＋監視指標。禁止表現は入口でも維持。
- **横串原則**：章2.3 下振れ＝章12.4 反証条件＝章13.3 見直しシグナル を同一KPI閾値で。章10.1 最重要KPI＝章13.2 の3指標。
- **業績ドライバー定義（§3-6）**：当社の利益を「出所別」に分解した構成要素で、固有の上流環境＋固有KPIを持ち四半期観測で先回り判断できる「利益の発生源」。構造4段＝①上流環境→②企業固有KPI→③収益化メカニズム→④業績への効き方。**類型5＋横断1**（継続収入/回転収益/市況連動/営業活動/子会社・地域業績＋横断のコスト・為替型）。**判定3条件**（利益（売上でなく）構成／固有上流環境／四半期観測KPI）。**本数3〜5可変・4本推奨**。冒頭テーブル行＝各H3（7.1〜7.N）と完全一致。
- **KPI出所範囲**：②企業固有KPIの出所は (a)会社開示 (b)業界統計・外部市況 (c)FIC独自算出 の3種すべて。選定基準は「当社業績に効くか」で出所問わず（「会社開示のみ」と誤読しない）。
- **金額必須化**：④業績への効き方の列＋各H3本文に、当期実績＋翌期計画の利益寄与額（+◯◯/▲◯◯億円）を必須。④列は金額＋因果メカニズムの両方。金額が書けないドライバーは判定3条件不充足＝失格。
- **章7情報3層の書き分け**：①冒頭テーブル＝4段で俯瞰／②各H3本文＝深掘り（5段階チェーン・感応度・金額・誰が買うか）／③H4補助軸＝テーマ×上流×KPI×波及×反証の横断。
- **リスク表5列統合**：リスク項目／内容／対応上流変数／顕在化条件／対称性（強気材料との裏表）。章1/10の上流環境マップと紐付け。
- **結局締め2パターン**：全章末（章1〜12）に「結局…」を置く。(A)キーメッセージ凝縮型／(B)次章橋渡し型。章13はまとめ自体のため不要。
- **30秒要約 運用ルール**：L1速読層が主読者。平易な言葉で「本文の凝縮版」、本文にない新情報・新数値を足さない。業界判定の定型句（「業界判定：◯◯は『成熟＋構造転換期』等（後段で詳細）」）を先頭に。
- **二層読者戦略**：初心者間口拡大（工夫1-3）と分析深度・会計士信頼性の両立。深度は不変条件、変えるのは口調・表現のみ。
- **章別設計ガイド**：`docs/chat_workflows/_analysis/chapter_design_guide.md`（全15章×目的/必須要素/王子HDからの改善点/やりがちな失敗）。writer/reviewerが章ごとに参照。
- **100点像確定の経緯**：外部リサーチ（東洋経済/ダイヤモンド/四季報/みんかぶ/note）→ 公開15章を正本化。最適化（優先動線・アコーディオン・L1L2L3物理分離）は **γ＝段階的採用** で段階2以降へ退避（現行は全章展開）。

### 文体（正本＝writing-style）
- **工夫1**＝専門用語の即時言い換え（「つまり」「ざっくり言うと」＋具体例）。
- **工夫2**＝業界固有の物理概念のみ比喩（会計概念には使わない）。冒頭1〜2文のみ日常比喩解禁。
- **工夫3**＝日常接点の例示（章4.2必須・コンビニ/Amazon等の完成品。B2B専業は完成品レベルまで遡る／接点が極端に間接的なら産業レベル）。
- **💡/📘＝ともに `beginner-box`**（CSS=`wordpress/css/custom.css`・本番稼働済み）。区別は絵文字＋見出しテキストのみ。**glossary-box/term-boxは全廃**（公開HTML実査で確認）。
- **解説box新基準**：💡3〜7／📘3〜7／**総計6〜14**・各100〜220字・初出H2/H3直後。機能分離＝💡論点かみ砕き／📘用語定義。
- 数値ラベルは [[factual-handling-rules]] §6 正本（会社開示値／外部推計／FIC前提付き試算）。

### 事実の安全（fact-safety 3規律）
- **source-hierarchy**：出所の質（強/中/弱）・媒体名・推測URL禁止。
- **factual-handling-rules**：単位×10／年度ラベル／感応度符号／セグメント推定禁止／会社開示値vsFIC試算／調査比率分母。
- **expression-strength-rules**：誇張・断定の抑制／禁止表現（確定/直接恩恵/V字回復/崩壊/圧倒的/独占）／タイトル整合／**2段構成ルール**（為替・市況・業績見通しは「会社前提を客観基準として明示＋FIC独自視点を補足」）。
- 数値を扱う標準invoke順＝source→factual→expression。

### 品質ゲート（正本＝article-quality-checklist）
- 基盤＝`prompts/shared/quality_checklist.md` の約44項目（英語・観点別）。
- **B-0〜B-9**（100点像の追加チェック）＋**A-map 44項目↔3規律/B項目マッピング表**。
- **マッピング表3区分**：委譲（点検実体を3規律/関連Skillが担う）／対応（B項目で拡張）／基盤（44項目単独・grep/測定基準併記）。**委譲+対応は併記**（第4区分は立てない）。集計＝委譲約18/対応約8/基盤約10/ハイブリッド約5。基盤区分のgrep基準は #5/#30/#31/#34/#36 を確定、残りは段階3で追補。**マッピング表は44項目本体を改変しない索引**。

### 工程引き継ぎ・Sheets
- **handoff-templates**：`work/{key}/handoff_{from}_to_{to}.md`。冒頭に「ステータスサマリ表（Sheets同期項目）」＋7セクション。標準handoff連鎖は既存SOP（chat_workflows/）準拠。詳細は SKILL.md 正本。
- **sheets-status-update**：スプレッドシート「FIC記事管理_v3」の俯瞰メタ更新。ステータス語彙は `v3_ステータス定義` 準拠。`scripts/sheets/update_sheet_row.mjs --path-mode` 使用。
- **6-2 スラッグ固定ガード**：既存投稿IDは更新のみ（新規作成しない）／スラッグ変更禁止／`article_title:` を `post_title` に明示（`<h1>`抽出フォールバック禁止）／アイキャッチはユーザー明示なく変更しない。パイロットはdraft/テストIDのみ。

---

## ■ 主要決定の「なぜ」（背景・理由）

新チャットで前提を誤読しないための、主要決定の理由。

- **公開15章を正本化／最適化はγで段階2へ退避**：外部リサーチで15章は外部標準（2,000〜4,000字・8章前後）の約2倍と判明。だが王子HD・日本製紙の公開記事で実証済みの高品質構造のため正本化。一方、優先動線・アコーディオン折りたたみ・L1/L2/L3物理分離は**外部に前例ゼロ＝未実証**のため、拙速に独自構造を入れず段階2でパイロット検証してから採否（γ）。
- **📘＝beginner-box（glossary-box/term-box全廃）**：当初「📘＝新クラスglossary-box・要CSS定義・本番不使用ガード」としたが、**公開HTML実査で📘も💡も同一 `beginner-box`（custom.css稼働済み）**と判明。grepの部分一致だけで断定した誤りを、repo＋公開HTMLの両ソースで裏取りして修正（CLAUDE.md §3追補の契機）。
- **業績ドライバー定義（§3-6）の新設**：公開記事は7.4だけ特定名（為替・M&A）固定・本数4本固定・「ドライバーとは何か」の定義不在だった。writerごとの章7品質ブレを防ぐため、定義・構造4段・類型5+横断1・判定3条件・本数3〜5可変を明文化。
- **金額必須化**：公開記事はすべて金額付きで論証（例：王子HD7.1「FY25海外▲254億円」）。冒頭テーブルを4段構造化して当期/翌期の利益寄与額列が消えたため、④列＋各H3本文での金額必須を明文化。
- **リスク表5列統合**：規定が3系統で食い違い（pack_spec=4列／記事プロンプト=5列／公開記事=対称性列欠落の4列）。各版の長所を統合し、FIC主軸の「対応上流変数」＋一方的羅列を防ぐ「対称性」を両立。
- **writer⇄reviewer 差し戻しループの採用（Phase 5 の核心的利点）**：現行Codex運用が `codex_reviewed_article.html` の別ファイル作成方式だったのは**Codexの再執筆能力の制約**が理由。Subagent化で writer も reviewer も Claude になるため、「**記事を書いた writer に reviewer の指摘で直させる**」正攻法のワークフローが初めて可能になる。writer は `claude_article.html` を**上書き更新**、差し戻し**上限2周**、3周目になる論点は**FICエスカレーション**。現行運用の制約をそのまま継承するのは設計後退なので採らない。
- **中計あり/なし分岐**：中計未発表企業でも章8が書けるよう、章の"ハコ"を維持し素材（中計 or 経営方針）を切替（15章を崩さない）。
- **事実確認の優先順位＋両ソース要件（CLAUDE.md §3-7＋追補）**：段階1で推測判断による見落とし（動画SOP・新構成3章・📘クラス）が頻発した教訓。事実はrepo→公開HTMLで自分で確認、「修正」は両ソース裏取りが条件。
- **解説box新基準（💡3〜7／📘3〜7／総計6〜14）**：当初は日本製紙実装ベースで4〜6だったが、FIC判断で初心者間口を広げるため6〜14へ拡張。💡＝論点のかみ砕き／📘＝用語の定義、の機能分離を強化。
- **工夫3（日常接点の例示・章4.2必須）**：公開記事（王子HD・日本製紙）は投資家向けに徹し日常接点が無かった。初心者の理解を「実物の指差し」で助ける**第3の技法**として追加（比喩でも言い換えでもない）。B2B専業は完成品レベルまで遡る。
- **入口/中身の役割分離**：外部の高閲覧記事は数字＋疑問形で引き込む一方、FICの強みは誠実・抑制。タイトル＋30秒要約は強め可／本文・締めは誠実、と役割を分けて両立（禁止表現は入口でも維持）。
- **横串原則（章2.3＝12.4＝13.3、章10.1＝13.2）**：投資判断に使うKPI閾値・監視指標を複数章で同一にし論理整合を担保（writerが章ごとに再発明してブレるのを防ぐ）。
- **パイロット題材＝285A_kioxia**：当初予定の王子HD 3861は投入パックが（移行漏れで）リポジトリに無かった。Zip移行で復元後も、285Aは「v4準拠の完全な投入パック＋公開記事との同一銘柄比較（品質保証なし旧版 vs Subagent化新版）」が成立するため正式パイロットに確定。
- **writer/reviewerペア設計＋差し戻しループ**：両者がClaudeになる段階2で初めて「書いた本人に reviewer の指摘で直させる」正攻法が可能（Codex時代の別ファイル方式は再執筆制約の名残）。上限2周・3周目はFIC・2周目の新規blockerはreviewerの見落としとしてFICへ（writerの再執筆回数を増やさない）。
- **2層マッピング表（44項目は非改変）**：英語44項目＝汎用基盤（多くはfact-safety 3規律へ委譲）／日本語B-0〜B-9＝100点像拡張、の役割を1表で示す索引。既存Codex工程（44項目＋grep）を壊さないため44項目本体は改変しない（並行運用厳守）。

---

## ■ 環境・運用上の重要な制約

- **settings.json `.claude/` 恒常ゲート**：`.claude/` 配下のWrite/Editは Claude Code のセキュリティ設計で恒常的に承認ゲートされる（settings.jsonでは抑止不可・確定）。ポップアップは正常。**セッション一時許可で運用**。詳細＝`known_issues.md` ★決着テスト結果節。
- **認証（A案）**：`.secrets/` 配下8ファイル（値はチャット非出力）。鍵はスクリプトが実行時に `node:fs` で読み、RS256でJWT自前署名→access_token取得。**鍵の中身はコンテキストに載せない**。
  - ファイル一覧と用途（値は出さない）：`coastal-mercury-…json`（Sheets サービスアカウント鍵）／`wp-app-password.json`（WP Application Password）／`fic-wp.json`／`x-api.json`（X API）／`youtube-oauth-token.json`（YouTube）／`google-oauth-client.json`・`google-oauth-token.json`（Google OAuth）／`sandbox_users.json`。
  - deny済み：`.secrets/**`・`.codex/**`・`*credentials*`・`*-oauth-*`・`.env*` の読取り。
- **既存スクリプト資産**：`scripts/sheets/update_sheet_row.mjs`（行更新・`--dry-run`/`--path-mode`／v3企業分析タブは `--memo-col AB --article-col AD --date-col AA`）、`scripts/sheets/read_sheet_tab.mjs`（タブ読取り）。npm依存なし。命名規則 `scripts/{category}/{action}.mjs`（WPは `scripts/wordpress/`）。
- **git運用**：main直コミット。Skill/論理単位でコミット。コミットメッセージ末尾に `Co-Authored-By: Claude Opus 4.7 (1M context) <noreply@anthropic.com>`。force push/reset --hard/rm -rf は禁止（deny）。コミットはユーザー依頼時のみ。
- **FIC記事管理_v3 Sheets 主要列**：企業分析タブ＝メモAB／記事AD／日付AA。X投稿＝AT(フラグ)/AU(決算メモ)/AV(投稿文)/AQ(更新日)/AS(レビューメモ)。画像AW／WP更新AN／完了AP。scout＝企業銘柄候補タブ。「企業分析_pilot」「企業銘柄候補」は未作成（段階3/4で新設）。
- **CLAUDE.md §3 進行管理ルール 7原則（＋追補）**：①各タスクでFIC確認②判断分岐は選択肢付き（A/B/折衷）③骨格・スコープはFIC承認後④細部は判断・迷えば問う⑤並行運用厳守⑥機密非出力⑦**事実確認の優先順位＝①リポジトリ内→②外部情報→③FIC質問**。
  - **追補**：「事実に基づく誤り修正」は **①リポジトリ内＋②公開記事HTML/外部実物の両方で裏が取れた場合のみ**。repo単独の結論は「FIC確認必須の提案」扱い。grepは部分一致で誤判定しうるため class属性・CSS定義の所在まで実体確認する。

---

## ■ 段階1完了時点の成果物一覧

- **Skill 8本**（`.claude/skills/`）：source-hierarchy／factual-handling-rules／expression-strength-rules（fact-safety 3規律）／handoff-templates／sheets-status-update／article-design-principles（§3-6含む）／writing-style／article-quality-checklist（A-mapマッピング表含む）。
- **テンプレ1本**：`wordpress/templates/company_analysis_template.html`（公開15章・肉付け版）。
- **設計ドキュメント**（`docs/chat_workflows/_analysis/`）：phase5_pilot_plan／phase4各種／fact_safety_consistency_check／external_article_research(summary/full)／info_box_usage_audit／geo_details_crawler_research／published_article_structure_audit／existing_sops_audit／chapter_design_guide／factsafety_checklist_reconciliation／known_issues。＋ルート `CLAUDE.md`。
- **スクリプト**：`scripts/sheets/update_sheet_row.mjs`／`read_sheet_tab.mjs`。
- **主要コミット**：`0632647`(source-hierarchy)→`ecb3278/c3c18cd`(expression)→`2b32283`(fact-safety 3規律完成)→`c5e0307`(handoff)→`b147af1`(sheets)→`036b38f`(権限決着)→`8ceae58`(Phase1-3調査)→`218e768`(Step4 100点像)→`a9b526d`(CLAUDE.md)→`af85470`(Step5 テンプレ15章化)。

---

## ■ 段階2でやること（着手スコープ）

`phase5_pilot_plan.md` 段階2準拠。**1名ずつ提示→FIC確認→次**。

- **writer Subagent 作成**：
  - 触ってよいフォルダ＝`work/company_analysis/{key}/`。
  - 使用Skill＝article-design-principles＋chapter_design_guide（章別）＋writing-style＋fact-safety 3規律（source/factual/expression）。
  - 入力＝researcher投入パック（pdf_summary.md／claude_input_pack.md）。
  - 出力＝記事3点（claude_integrated_memo.md／記事HTML／claude_review_notes.md）＋`handoff_writer_to_reviewer.md`＋Sheets更新。
- **reviewer Subagent 作成**：
  - 使用Skill＝上記＋**article-quality-checklist（公開前ゲート・grep含む）**＋handoff-templates＋sheets-status-update。
  - **差し戻し方式**：reviewerの指摘で writer が `claude_article.html` を上書き更新（**上限2周・3周目はFICエスカレーション**）。回数カウント・指摘フォーマット・エスカレーション判定は reviewer 側が規定。出力＝`handoff_reviewer_to_designer.md`（冒頭ステータス要約付き）。
- **9役員のうち今回は2名のみ**。残り7名は段階4持ち越し。
- 認証＝A案（スクリプト経由・値非出力）。`.claude/` 書き込みはセッション一時許可で進める。
- **完了時の必須アクション（全役員共通）**：①handoff_*.md作成（冒頭ステータスサマリ）②Sheets該当列更新③reportに「handoff作成済み・Sheets更新済み」明記。

---

## ■ 段階3パイロット（キオクシア 285A）着手前の準備事項

- 題材＝**キオクシア（285A）**。既存 `work/company_analysis/285A_kioxia/`（pdf_summary・claude_input_pack・extracted_text・source_pdfs＝v4準拠）を researcher出力相当として流用。※王子HD(3861)pack も復元済みだが**正式パイロットは285A**（クリーンなv4入力＋公開記事との同一銘柄比較）。
- 出力先＝「企業分析_pilot」タブ（本番隔離・段階3でFIC新設）＋`work/company_analysis/285A_kioxia_pilot/`。
- WP＝draft/テストIDのみ（本番ID更新・スラッグ反映禁止）。既存キオクシア公開記事（kioxia-holdings-285a-analysis）と品質比較（品質保証なし旧版 vs Subagent化新版・同一銘柄）。
- **★成功判定基準（FIC合意 2026-05-22）**：
  - **成功バー＝「旧版と同等以上」で可**。旧版は品質保証なしのため、同等品質でも差し戻しループ＋チェックリスト＋再現性が加わる分が実質的な前進。**明確な品質後退のみ不合格**（＝「明確に上回る」ことは段階4進行のハードゲートにしない）。
  - **評価方法＝両方併用**：①article-quality-checklist（B-0〜B-9＋44項目）で客観点検 ＋ ②FIC目視で旧版・新版を読み比べて総合判断。客観基準と人の違和感の両取り。
- **段階3パイロットで育てる領域**：
  - article-quality-checklist の「基盤」区分 grep/測定基準の追補（現状 #5/#30/#31/#34/#36 確定）。
  - 章6.1 二軸グラフの実装方法判断（α Chart.js／β 静的SVG／γ Mermaid／δ AI画像継続）＝designer作成 or 段階3でFIC判断。
  - one-liner-summary 要素数（現テンプレ3要素 vs 公開記事4要素）の検証。
- 既存記事再校正リスト（王子HD/日本製紙＝微修正、鹿島建設＝旧構成）は段階4以降。

---

## ■ 段階4持ち越し事項

- 残り7 Subagent：scout／theme_scout／researcher_company／researcher_industry／designer／videographer／x_writer。
- 残りSkill：動画SOP／X投稿／画像・WP／業界分析3タイプ構成／統合メモ14章。正本は当面 `docs/chat_workflows/company_04〜06`・`industry_*`・`video_review_notes.md`・`x_post_company_analysis_workflow.md`・`non_ai_structure_chart_lessons.md`・`wordpress_media_cleanup_policy.md`（整合監査＝`existing_sops_audit.md`）。
- Codex工程との44項目突合（マッピング表「基盤」項目の整理余地検討）。

---

## ■ 未完了タスク・次段階への引き継ぎ（★段階3パイロット先行＝FIC決定）

**優先順位（FIC判断 2026-05-22）：段階3パイロット（285A）を先行し、下記保留タスクは段階3完了後に判断する。**
理由：①保留タスク3点は段階3パイロット（企業分析 writer/reviewer を285Aで試すだけ）の実行に影響しない／②段階3結果が writer/reviewer 設計の検証になり、問題があれば修正→その後に業界分析データ移行する方が手戻りが少ない／③writer/reviewer が「新鮮なうち」（設計直後）に検証する方が記憶バイアスを避けられる／④段階3完了後の判断材料が増えてから移行方針（v4 spec準拠の業界分析pack形式の確認等）を固める方が明確。
※Zip保管継続は「残す」で確定済み・追加作業なし（下記3点目）。

- **業界分析4テーマの移行**：`FIC.zip` 内 `work/industry_analysis/`（4テーマ：ai-battery-power-infrastructure-softbank-sakai／construction-material-shortage-project-delay-margin-risk／naphtha-packaging-cost-food-consumer-goods／sony-tsmc-physical-ai-sensor-investment）をローカルへ移行（company_analysisと同方式・no-overwrite・`work/` gitignoreでローカルのみ）。段階4 researcher_industry の検証データになる。
- **`work/_sheets/`（3,064件）の扱い**：中身を1段確認し、Sheetsキャッシュなら移行不要・それ以外なら移行を判断。
- **FIC.zip（2.3GB・`C:\Users\tomo-\Documents\FIC\FIC.zip`）は保管継続**。プロジェクト全体＋.git履歴＋未移行分（industry_analysis・_sheets）の唯一のバックアップ。**FIC承認なしに削除しない**。
- **王子HD pack復元の活用**：王子HD(3861)の投入パックが今回復元済み（`work/company_analysis/3861_oji/`・ローカルのみ）。段階3パイロット（285A）完了後の**第2弾検証**（writer Subagentが別銘柄でも機能するか）や、**段階4 researcher_company の出力品質目標**として活用可能。
- **Phase 5後の chat_workflows 全面見直し（段階4）**：`company_02_claude_article.md`・`company_03_codex_review.md` はCodex+Claude時代の制約を反映。段階4で **writer⇄reviewer 差し戻し方式**（reviewer別ファイル方式→writer上書き方式）に書き換え。

> 注：今回のセッションで `work/company_analysis/`（4社：1812_kajima／285A_kioxia／3861_oji／3863_nippon_paper）をZipからローカル移行済み（約159ファイル・gitignoreでローカルのみ）。3863のvideoは削除、285A・3861のvideoは保持。

---

## ■ 進行管理ルール（継続適用・8原則）

CLAUDE.md §3 の7原則＋追補ルール（repo＋公開HTML両裏取りでのみ「修正」、repo単独は「FIC確認必須の提案」）＝計8原則を段階2以降も継続適用。判断分岐は選択肢付き（A/B/折衷）でFICに問う。

---

## ■ FICとClaudeの役割分担

- **FIC（20%）**：戦略判断・違和感の指摘・具体例の提供（事故事例・公開記事の実態・FIC独自ルール）。
- **Claude（30%）**：構造化・関係性の発見・将来予測・事実確認（repo→web）。
- **既存資料（50%）**：FIC独自ルール・事故事例・実装パターン（prompts/・docs/・公開記事）。

---

## ■ 参照すべき設計記録（新チャットで最初に読む）

1. `CLAUDE.md`（§3進行管理ルール）
2. `.claude/skills/` 全8 Skill（特に article-design-principles §3-6、article-quality-checklist A-map、writing-style）
3. `docs/chat_workflows/_analysis/`：phase5_pilot_plan／chapter_design_guide／published_article_structure_audit／existing_sops_audit／known_issues
4. `wordpress/templates/company_analysis_template.html`（公開15章・肉付け版）
5. `git log`（段階1完了までの経緯：`0632647`〜`af85470`）
6. 公開記事（実装の正解例）：王子HD https://fic-investment.biz/oji-holdings-3861-analysis/ ／日本製紙 https://fic-investment.biz/nippon-paper-3863-analysis/

---

## ■ 未確認用語（FIC定義提供待ち）

「Cアプローチ」「handoff 4値」「標準10 handoff」はFICのmemories／前チャット冒頭文書に定義があったが、本リポジトリ内に明示の定義実体を確認できなかったため本書では推測記述しない。正式定義が必要なら、新チャットでFICが提供 or 該当memoryを参照。

---

（段階2着手時の最初の一歩：上記＋CLAUDE.md＋Skillを読了 →「段階2を開始します。まず writer Subagent の定義案を提示します。よろしいですか?」とFICに確認 → 1名ずつ提示・確認・修正・承認）
