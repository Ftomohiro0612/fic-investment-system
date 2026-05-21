# 既知の問題

将来のクリーンアップ・検証のために、現時点で判明している `.claude/settings.json` 等の未解決・要検証事項を記録する。

## 1. settings.json の bare "Write" "Edit" がallow-allとして機能していない

### 発見日: 2026-05-21

### 状況
`.claude/settings.json` の allow リスト先頭に bare の `"Write"` と `"Edit"` が記載されているが、機能していない（機能していればファイル作成時の承認ポップアップが出ないはず）。

### 検証経緯
2026-05-21 のSkill作成時に承認ポップアップが出続けたことから発覚。Claude Code の調査により、パターンのアンカー指定（`/` プレフィックス）が必要と判明した一方、bare 表記は別の問題として残存。

### 暫定対応
個別パターン（`/.claude/skills/**`, `/.claude/agents/**` 等）で対応。bare 表記は機能していないが害もないため当面残置。

### 将来対応
時間に余裕がある時に、bare 表記を削除するか、公式仕様に沿った全文字列パターンに変更するかを検証。

---

## 2. Windows絶対パス deny の検証保留

### 発見日: 2026-05-21

### 状況
`.claude/settings.json` の deny にある `Read(C:/Users/tomo-/.codex/**)` は cwd 相対の書き方になっており、確実に効いているか未検証。

### 想定される正しい書き方
公式仕様では `//c/Users/tomo-/.codex/**` に正規化される可能性があるが、Claude Code 拡張版での実動作は要検証。

### 当面の対応
- `/.codex/**`（プロジェクト直下）のdenyは確実に効く
- Codex本体は `C:/Users/tomo-/.codex/` にあるため、万一の意図しないアクセスは Claude Code の基本動作（想定外フォルダへの書き込みは確認を求める）で防御

### 将来対応
次セッション以降で、`//c/Users/...` 形式が動作するか実地検証。動作確認できたら settings.json を更新。

---

## 3. settings.json修正の検証限界

### 状況
2026-05-21のセッション中に "Yes, allow for this session" を選んでいるため、`.claude/skills/` への書き込みはセッション内一時許可で通る状態。

### 影響
settings.json の Write/Edit パターン修正が「本当に効いているか」は、当セッション内では確実に検証できない。

### 検証方法
次セッション（VS Code再起動後）で:
1. 新規Skillファイル作成を試みる
2. 承認ポップアップが出ないことを確認
3. 出る場合: settings.jsonパターンを再調整
4. 出ない場合: 修正成功、運用継続

### 検証実施タイミング
段階1のSkill 4個目（sheets-status-update）作成時に、セッションを一度切って再起動してから作成すれば、新規セッションで検証できる。

### 検証結果（2026-05-21 セッション再起動後・実施済み）
**結論: settings.json の `Write(/.claude/skills/**)` 修正は効果なし。**
- VS Code完全終了→再起動した新セッションで、初の `.claude/skills/sheets-status-update/SKILL.md` 新規作成（Write）時に承認ポップアップが出続けた。
- ポップアップ表示パス: `c:\Users\tomo-\Documents\FIC\fic-investment-system\.claude\skills\sheets-status-update\SKILL.md`。
- FICが「Yes, allow /.claude/skills/s... for this session」を選び、当セッション中の当該フォルダ書き込みを一時許可して作業続行。
- → 先頭 `/` アンカー説（前セッションの推定・MEMORY.md記載）は**この実測で否定**された。bare `Write`（allow-all のはず）も `.claude/` には効いていない。

### 根本原因の調査（claude-code-guide / 公式仕様 2026-05-21）
1. **権限パスはgitignore準拠**。先頭 `/` は**プロジェクトルート**アンカー（ファイルシステムrootではない。root は `//`）。
2. **Windowsはmatch前にPOSIX正規化**: `C:\Users\tomo-` → `/c/Users/tomo-`。パターンは forward slash で書く。絶対指定は `//c/Users/...`。
3. **最有力原因**: `.claude/` は `.git` / `.vscode` / `.idea` / `.husky` と並ぶ**特別扱いディレクトリ**。`bypassPermissions` の説明でこれらが名指しされており、`acceptEdits` も `.claude/` 配下を自動承認しない可能性が高い。→ allow パターンの形以前に、**`.claude/` 書き込みが安全機構として恒常的にゲートされている**疑い。
4. 新規ファイル作成は mkdir（Bash）＋Write の2段になり、複合コマンドや新規親ディレクトリ作成で別途承認が要る。

### 候補パターン（FIC選択 → 適用 → 即テスト）
| 順位 | パターン | 根拠 | リスク |
|---|---|---|---|
| 1 | `Write(.claude/skills/**)`（先頭スラッシュ無し＝cwd相対） | 公式推奨・最も移植性高い。VS Code起動時 cwd=プロジェクトroot | MEMORYの旧推定では「cwd相対は不発」。要再検証 |
| 2 | `Write(//c/Users/tomo-/Documents/FIC/fic-investment-system/.claude/skills/**)`（正規化済み絶対パス） | プロジェクトroot検出のあいまいさを完全排除。最良の切り分けテスト | 冗長・パス固定（移設で壊れる） |
| 3 | `Write(**/.claude/skills/**)`（どこでもマッチ） | 深さ非依存 | 広すぎ・top-level `.claude/` で効くか不確実 |

→ いずれを入れても popup が消えなければ **原因③（`.claude/` 恒常ゲート）が確定**。その場合は `/feedback` でVS Code拡張のバグ報告＋当面はセッション一時許可で運用継続。
（Edit/agents 版も同形で同時追加する。）

### 再修正の適用と同一セッション内テスト結果（2026-05-21）
- FIC選択「**全候補を一括投入**」を採用。`settings.json` の旧 `Write/Edit(/.claude/...)` 4行を、候補3形（cwd相対 `.claude/...` / どこでも `**/.claude/...` / 正規化済み絶対 `//c/Users/.../.claude/...`）× Write/Edit × skills/agents の**計12行**に差し替え済み。
- 同一セッション内で別パス `.claude/skills/_perm_test/PERM_TEST.md` を新規作成 → **ポップアップ出た**（テスト後ファイル削除済み）。
- 解釈: 同一セッションでは settings.json 変更が**未反映の可能性**（候補D=reload要）。`.claude/` 恒常ゲート（原因③）とはまだ二分できない。

### ★次セッションで必ず実施（決着テスト手順）
1. **VS Code を完全終了→再起動**（新 settings.json をロードさせる）。
2. 新セッションで、未使用パス（例 `.claude/skills/_perm_test2/PERM_TEST.md`）を新規Write。
3. **ポップアップ無し** → 候補のいずれかが有効＝**修正成功**。不要パターンを1つずつ削って最小形に絞る（推奨残し: cwd相対 `.claude/...`）。テストファイル削除。
4. **ポップアップ有り** → **原因③（`.claude/` 恒常ゲート）確定**。`/feedback` で「allow/acceptEdits を設定しても `.claude/` 配下Writeが承認を要求する」とVS Code拡張へ報告。運用はセッション一時許可で継続（実害は軽微：1案件あたり数回の承認）。
5. 結論を本ファイルと MEMORY.md（[[claude-settings-permission-path-anchor]]）に反映し、settings.json を最小形に整える。

### ★決着テスト結果（2026-05-21 セッション再起動後・実施済み・確定）

**結論: 原因③（`.claude/` 恒常ゲート）確定。settings.json では解決不可。**

- VS Code 完全終了→再起動した新セッションで、12通りの allow パターン（bare `Write`／cwd相対 `.claude/...`／どこでも `**/.claude/...`／正規化済み絶対 `//c/Users/.../.claude/...`）を全投入した状態のまま、未使用パス `.claude/skills/_perm_test2/PERM_TEST.md` への初回新規Writeを実施。
- **承認ポップアップが出た**（FIC実機確認・許可選択）。→ どの allow 形でも `.claude/` 配下Writeのゲートは外れない＝**Claude Code のセキュリティ設計による恒常ゲート**と確定。`acceptEdits` でも自動承認されない。

**対応（実施済み）:**
1. **`/feedback` 報告**: 「Windows VS Code拡張で、`.claude/` 配下への新規Writeが settings.json の allow（`Write(.claude/skills/**)` 等）や `acceptEdits` でも承認を要求される。期待: allowで許可可能にする or 回避方法のドキュメント整備。運用制約: 大量のSkill/Subagent作成時に承認回数が増える」。報告本文は本セッションでFICへ提示済み（FICが /feedback から送信）。
2. **settings.json 最小形化**: 実験用12行 → 公式仕様準拠の cwd相対4行（`Write/Edit(.claude/skills/**)`, `Write/Edit(.claude/agents/**)`）のみ残置。理由＝将来 Claude Code が `.claude/` ゲートを緩和した際に即効くようにする「正しい意図の最小表現」。
3. **テストファイル削除済み**: `.claude/skills/_perm_test2/`（PERM_TEST.md 含む）。
4. **運用方針**: `.claude/` 書き込みは**セッション一時許可（"allow for this session"）で継続**。実害評価＝1案件あたり数回の承認で許容範囲内。

→ 本件クローズ。残課題は本ファイル §1（bare `Write`/`Edit` の allow-all 不発・無害残置）と §2（Windows絶対パス deny 検証保留）のみ。

---

## 保留タスク（段階1完了後に着手）

- [x] **CLAUDE.md の作成**（完了 2026-05-21・コミット）
  - 目的: Claude Code がセッション開始時に自動読み込みする内部指示書
  - 内容: 進行中フェーズ、Skill 参照ルール、危険操作、ドメイン用語、出力フォーマット
  - 反映: Phase 4 で確定した4 Skill 体系（article-design-principles / writing-style / article-quality-checklist ＋ fact-safety 3規律）
  - README.md との役割分離: README.md は人間向け、CLAUDE.md は Claude Code 向け
  - 着手タイミング: 段階1完了時

- [x] **📘 用語解説boxのCSS（2026-05-21 公開HTML検証で解消）**
  - 当初「📘=glossary-box・WP CSS未定義・本番不使用ガード」と懸念したが、公開HTML実査で**📘は💡と同一クラス `beginner-box`**（CSS=`wordpress/css/custom.css`）で本番稼働済みと判明。glossary-box/term-boxは不要＝誤認だった。📘は絵文字＋「用語メモ：」見出しで区別。ガード不要。

- [ ] **段階1ステップ5 スコープ（テンプレ全面15章化と同時・2026-05-21 FIC確定）**
  1. テンプレ（company_analysis_template.html）全面15章化（雛形以外の章の本格実装・章番号振り直し・参照→FAQ順）。
  2. WP側CSS定義: `fic-detail-block`（段階2用）のみ。📘は既存 `beginner-box` で稼働済み＝CSS追加不要（glossary-box不要・2026-05-21検証）。
  3. article-quality-checklist に企業分析HTML構造マーカー（`one-liner-summary`／各章導入`<em>`／章末「結局…」／必須グラフマーカー3／画像連動マーカー2）を**新15章版**へ振り直して反映（company_03 の旧H2 1〜12基準を更新）。
  4. 英語44項目（quality_checklist.md）と日本語B項目の**2層明確化＋マッピング表**（44=汎用基盤・委譲先明記／B=100点像拡張。一本化せず既存Codex工程を維持）。
  - 論点3・4＝a で確定。詳細は [existing_sops_audit.md](existing_sops_audit.md) §4。

- [ ] **各ロールSOPのSkill化（段階4）**
  - videographer（video-production-rules）/ x_writer（x-post-rules）/ designer（image-production-rules＋wordpress-publishing）/ 業界分析構成（industry-article-design・3タイプ分岐）/ 統合メモ14章（researcher_company用）。
  - 既存SOPが当面の正本。Skill化は該当subagent追加時＝段階4。詳細は [existing_sops_audit.md](existing_sops_audit.md) §4。

- [ ] **各ロールSOPのSkill化（段階4）**
  - videographer（video-production-rules）/ x_writer（x-post-rules）/ designer（image-production-rules＋wordpress-publishing）/ 業界分析構成（industry-article-design・3タイプ分岐）/ 統合メモ14章（researcher_company用）。
  - 既存SOPが当面の正本。Skill化は該当subagent追加時＝段階4。詳細は [existing_sops_audit.md](existing_sops_audit.md) §4。

---

## プロセス改善（資料発掘の必須工程化）— 2026-05-21 追記

### 背景（発生した見落とし）
段階1ステップ4 Step A（資料発掘）で、**公開記事の章構造を機械的に一覧化する工程が無かった**ため、王子HD・日本製紙の公開記事が持つ「新構成3章（業界の風向き／投資仮説／業界の勝ち筋と当社ポジション）」をはじめとする**FIC標準15章構成**を見落とした。Step A は内部リポジトリのファイル発掘（Exploreエージェント）と review_notes の要約に依存し、**公開URLの web_fetch による H2/H3 構造の悉皆列挙を行わなかった**。鹿島のみ web_fetch したが章設計に厳密反映できていなかった。詳細は [published_article_structure_audit.md](published_article_structure_audit.md)。

### 改善（今後の類似プロジェクトで必須化＝Phase 0）
資料発掘（Step A 相当）の冒頭に、以下を**Phase 0 として固定**する:
1. 参照記事の公開URLを **web_fetch**（内部ドラフトだけに依存しない）。
2. **H2/H3章構造を Markdown 表形式で悉皆列挙**し、ファイルに保存。
3. これを「**100点像の基準ベースライン**」として明示し、Step B 以降の設計はこのベースラインとの差分で語る。
4. 内部ドラフトと公開版が食い違う場合は**公開版を正**とする（公開版がFIC標準の最新実装）。

→ これにより「実装済みの標準構成を設計段階で見落とす」事故を防ぐ。
