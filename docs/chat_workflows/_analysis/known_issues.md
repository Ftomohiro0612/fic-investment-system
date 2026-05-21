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
