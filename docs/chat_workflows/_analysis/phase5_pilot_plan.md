# フェーズ5: パイロット計画（段階的承認方式）

[phase4_final_design.md](phase4_final_design.md) の確定設計を、**都度FIC確認しながら段階的に**実装する計画。
**進め方の原則: 各段階で必ずFIC確認。「進めていいですか?」と毎回明示的に聞き、「次へ」が出るまで次段階に進まない。
エラーや判断迷いは即停止しFICに相談。機密値はチャットに出さない。既存Codexワークフローを壊さない（並行運用厳守）。**

---

## ★最重要プロセス則: 資料発掘は Phase 0（公開記事の構造ベースライン化）から始める

**「100点像」や記事設計に関わる発掘・分析タスクでは、最初に必ず Phase 0 を実施する。** これは Step A（資料発掘）の前提工程であり、省略禁止。

1. 参照記事の**公開URLを web_fetch**（内部リポジトリのドラフトだけに依存しない）。
2. **H2/H3章構造を Markdown 表で悉皆列挙**し、`docs/chat_workflows/_analysis/` にファイル保存。
3. これを「**100点像の基準ベースライン**」と明示し、以降の設計はこのベースラインとの差分で語る。
4. **内部ドラフトと公開版が食い違う場合は公開版を正**とする（公開版がFIC標準の最新実装）。

> 経緯: 段階1ステップ4で Phase 0 を欠いたため、王子HD・日本製紙の公開標準15章構成（新構成3章ほか）を見落とした。詳細は [known_issues.md](known_issues.md) プロセス改善節 と [published_article_structure_audit.md](published_article_structure_audit.md)。**Step Aレベルの抜けは下流工程すべてに波及する**ため、最重要のプロセス則として固定する。

---

## 段階0: 環境準備

【FIC手動完了済み】
- ✅ `.secrets/` フォルダ作成
- ✅ 8つのJSON認証ファイル配置（マッピングは phase4_final_design §5）

【Claude Codeに依頼（着手前に「これから段階0を実施します。変更内容は以下です。よろしいですか?」と確認）】
1. `.gitignore` に追記（既存に追記）:
   `.secrets/` / `*.env` / `credentials.json` / `*-credentials.json` / `*-oauth-*.json` / `wp-app-password.json` / `x-api.json`
2. `.claude/settings.json` の allow/deny を調整（phase4 §5）:
   - allow: `Read(.secrets/coastal-mercury-495123-k5-83baf0c72a93.json)`, `Read(.secrets/wp-app-password.json)`
   - deny: `Read(.secrets/fic-wp.json)`, `Read(.secrets/sandbox_users.json)`, `Read(.secrets/x-api.json)`, `Read(.secrets/youtube-oauth-token.json)`, `Read(.codex/**)`, `Read(C:/Users/tomo-/.codex/**)`, `Read(./.env*)`, `Read(./data/.gcp-sheets-credentials.json)`
3. `coastal-mercury-...json` でSheets API読み込みテスト（FIC記事管理_v3 のタブ一覧取得程度。値はチャットに出さない）
4. `wp-app-password.json` は読み込み可否のみ確認（WP実接続テストは段階3まで保留）
5. テスト結果をFICに報告 → FIC確認 → 段階1へ

---

## 段階1: Skill先行作成（順序改訂版）

1個ずつ作成し、各完成ごとに内容提示 → FIC確認 → 修正 → 承認 → 次へ。

1. `fact-safety-rules`（3分割確定 / 7-1）
   - `source-hierarchy` ✅（v2承認・コミット済み 2026-05-21）
   - `expression-strength-rules` ← 次
   - `factual-handling-rules`
2. `handoff-templates`（phase4 §8 のテンプレを組み込む）
3. `sheets-status-update`
4. ★ **100点像の確定**（資料発掘 → Claude提案 → FICレビュー）。理想の最終成果物像（記事・X・動画の「100点」）を定義する工程。後続の writing-style と article-quality-checklist はこの像を基準に作る。
5. `writing-style`（**100点像を反映**。初心者間口拡大の文体戦略＝phase4 §2 目次）
6. `article-quality-checklist`（**最小骨子**。100点像を反映）

→ FIC確認 → 段階2へ

### ステップ4後続：テンプレ全面15章化（FIC命名「段階1ステップ5」・2026-05-21確定）

100点像確定（ステップ4）後、writer/reviewer 投入前に実施する整備フェーズ。スコープ：
1. テンプレ（`wordpress/templates/company_analysis_template.html`）の**全面15章化**（雛形以外の章の本格実装・章番号振り直し・参照→FAQ順）。
2. **WP側CSS定義**：`fic-detail-block`（段階2用）のみ。📘は既存 `beginner-box`（`wordpress/css/custom.css`）で稼働済み＝CSS追加不要（2026-05-21 公開HTML検証で確認）。
3. `article-quality-checklist` に**企業分析HTML構造マーカー**（`one-liner-summary`／各章導入`<em>`／章末「結局…」／必須グラフ3／画像連動2）を**新15章版**へ振り直して反映（company_03 の旧H2 1〜12基準を更新）。
4. **英語44項目**（`prompts/shared/quality_checklist.md`）と日本語B項目の**2層明確化＋マッピング表**：44項目＝汎用基盤（多くはfact-safety 3規律へ委譲）／日本語B＝100点像拡張、と役割を article-quality-checklist 冒頭に明記し、「どの44項目がどの3規律／B項目へ対応・委譲されるか」の対応表を1つ置く（**一本化はせず**、英語44項目＋grepを使う既存Codex工程を壊さない）。

**段階4へ持ち越し（各ロールSOPのSkill化）**：動画SOP全般（videographer）・X投稿タイプ10種＋決算メモ（x_writer）・画像/WP（designer）・業界分析3タイプ構成・統合メモ14章。詳細は [existing_sops_audit.md](existing_sops_audit.md) §4。

---

## 段階2: 執筆コア役員2名作成

1名ずつ提示 → 確認 → 次へ。
1. `writer` subagent
2. `reviewer` subagent

→ FIC確認 → 段階3へ

---

## 段階3: パイロット案件起動（キオクシア 285A）

- 題材: **キオクシア（285A）**。既存の v4準拠投入パック `work/company_analysis/285A_kioxia/`（`pdf_summary.md`/`claude_input_pack.md`/`extracted_text`/`source_pdfs`）を流用（researcher出力相当）。※王子HD(3861)・日本製紙(3863)の投入パックも復元済みだが、**正式パイロットは285A**（クリーンなv4入力＋公開記事との同一銘柄比較が成立するため）。
- 出力先: 「**企業分析_pilot**」タブ（本番タブと完全隔離）＋ `work/company_analysis/285A_kioxia_pilot/`。
- 手順: writer が記事3点を生成 → reviewer が `article-quality-checklist` grep自己チェック＋編集判断 → **reviewerの指摘で writer が `claude_article.html` を上書き更新（差し戻し方式・上限2周・3周目はFICエスカレーション）** → `handoff_writer_to_reviewer.md`／`handoff_reviewer_to_designer.md`（冒頭ステータス要約付き）。
- 既存のキオクシア公開記事（ https://fic-investment.biz/kioxia-holdings-285a-analysis/ ／`work/company_analysis/285A_kioxia/codex_reviewed_article.html`）と品質比較（品質保証なし旧版 vs Subagent化新版・同一銘柄）。
- **WordPress REST API書き込みテストはこの段階で初実施**（下書き(draft)/テスト投稿IDのみ。本番ID更新・本番スラッグ反映は禁止＝6-2事故防止）。
- → FIC評価 → 次へ進むか調整するか判断。

---

## 段階4以降

パイロット結果で判断:
- 良好: 残りSkills、`scout`/`theme_scout`/`researcher_company`/`researcher_industry`/`designer`/`videographer`/`x_writer` を順次追加（1つずつ提示→確認）。
- 課題あり: writer/reviewer を改善してから次へ。

昇格ルール: ある役員が**2案件連続で現行同等以上**を満たしたら正本へ昇格。Codex残置（AI生成/TTS/レンダ/アップ/ファクトチェック）は最後まで据え置き。移行完了後、`企業分析_pilot` タブはアーカイブ（削除しない）。

---

## 隔離設計（並行運用・本番を汚さない）

- ファイル: `*_pilot/` 別フォルダ。handoffは各パイロットフォルダ内（7-7）。
- Sheets: 「企業分析_pilot」タブ（本番タブの列文字を壊さない）。scoutは「企業銘柄候補」タブ（phase4 §6）。
- WP: 下書き/テスト投稿IDのみ。本番ID更新・本番スラッグ反映はパイロット中禁止。
- 認証: 段階1直読み（phase4 §5）。

## 比較・昇格基準

`article-quality-checklist` 通過率（grep含む）／ファクト事故件数／手戻り回数／所要時間／WP正確性（title.rendered一致・スラッグ不変・既存ID更新）／writing-style適用度（工夫1+2・初心者到達度）。

## scout タブ列構成（確定・暫定列）

A 候補ID / B 銘柄コード / C 企業名 / D scout提示日 / E 評価(A/B/C) / F 選定理由 / G 関連テーマ /
H 想定インプレッション要因 / I FIC判断 / J 採用後の企業分析タブrow番号 / K メモ。

---

## 段階0 実行結果（2026-05-21 完了）

- ✅ `.gitignore` に Secrets ブロック追記済み。
- ✅ `.claude/settings.json` の deny に `.secrets/` 各機密ファイル・`.codex/**` 等を追加（allowは追加せず＝A案）。
- ✅ `.secrets/` の8ファイルすべて存在確認（nodeのexistsSync、中身は読まない）: wp-app-password.json / coastal-mercury-…json / fic-wp.json / youtube-oauth-token.json / x-api.json / sandbox_users.json / google-oauth-client.json / google-oauth-token.json。
- ✅ Sheets認証テスト成功（`update_sheet_row.mjs --dry-run`）。サービスアカウント鍵で認証→タブ一覧取得→書き込みなし(`[dry-run] skipping write`)。鍵の値はチャット非出力。
- 実測タブ一覧: `企業分析 / 業界分析 / 業界分析_旧列順控え_20260515 / v3_進捗サマリー / v3_使い方 / v3_ステータス定義 / v3_Claude投入テンプレ / v3_レビュー項目 / 企業分析_旧列順控え`。
  → **「企業分析_pilot」「企業銘柄候補」タブは未作成**（段階3/4でFICが新設 or scriptで作成）。

## スクリプト資産メモ（Subagent流用情報）

- **場所**: `scripts/sheets/update_sheet_row.mjs`（リポジトリ追跡・共有資産）。
- **依存**: npm依存なし。`node:fs` / `node:crypto` / `node:path` ＋ 組込み `fetch` のみ。
- **認証関数 `getAccessToken(keyPath, scopes)`**: サービスアカウント鍵を実行時にfsで読み、RS256でJWT自前署名→`oauth2.googleapis.com/token` でaccess_token取得。**鍵の中身はコンテキストに載らない**（A案の肝）。
- **`getSheetTitles(sheetId, token)`**: `GET spreadsheets/{id}?fields=sheets.properties.title` でタブ名配列を返す。subagentの「対象タブ存在確認」に流用可。
- **モード**: `--dry-run`=認証＋タブ確認のみ（書き込みなし、read確認に最適）／`--path-mode`=セルにパス文字列を書く（俯瞰メタ運用＝sheets-status-updateの標準）。
- **列指定**: 既定は旧列順控え向け(`--memo-col AD --article-col AM`)。**v3「企業分析」タブは `--memo-col AB --article-col AD --date-col AA`**（スクリプト冒頭コメント25行目）。
- **命名規則（確定）**: `scripts/{category}/{action}.mjs`（例 `scripts/sheets/update_sheet_row.mjs`）。WPは `scripts/wordpress/` に置く。

## 段階1〜2で作成すべきWP用スクリプト（想定リスト）

`update_sheet_row.mjs` と同じ「鍵を実行時読み・値は非出力」パターンで実装（WPは Application Password の Basic認証）。
- `scripts/wordpress/wp_get_post.mjs` — 既存投稿ID/スラッグ/`title.rendered` 取得・検証（6-2ガード用）。
- `scripts/wordpress/wp_upload_media.mjs` — 画像メディアアップロード→メディアID/URL返却。
- `scripts/wordpress/wp_publish.mjs` — 記事本文HTML投稿/更新。`article_title:`→`post_title`、既存IDあれば更新・スラッグ絶対固定・アイキャッチ不変。`--draft` でパイロット下書き。
- `scripts/wordpress/wp_cleanup_media.mjs` — 未使用メディア削除（`wordpress_media_cleanup_policy` 準拠）。
- （任意）`scripts/lib/wp_auth.mjs` — WP認証ヘルパ共通化（各scriptに内包でも可）。

## Skill設計時に参照する既存シートタブ（段階0で実在確認）

今すぐ全読する必要はないが、**該当Skill作成時に対応タブを確認**する。

| タブ | 内容 | 参照する場面（Skill/Subagent） |
|---|---|---|
| `v3_使い方` | 運用マニュアル | handoff-templates / sheets-status-update 作成時、全Subagent定義の前提として |
| `v3_ステータス定義` | ステータスenum（状態ラベル正本） | sheets-status-update Skill に組み込み候補。状態文字列はここに合わせる |
| `v3_Claude投入テンプレ` | 過去のClaude投入テンプレート | researcher_company / researcher_industry 定義時 |
| `v3_レビュー項目` | レビュー項目リスト | **article-quality-checklist Skill の原型**。作成時に必ず確認 |
| `企業分析_旧列順控え` / `業界分析_旧列順控え_20260515` | 列変更履歴 | sheets-status-update / wordpress-publishing の列マッピング確認時 |

## .claude/ のバージョン管理に関する注意（要判断・段階1で表面化）

現状 `.gitignore` は `.claude/` を**まるごと除外**している。このままだと作成する Skills(`.claude/skills/`) と
Subagents(`.claude/agents/`) が**git管理外**になり、チーム共有・履歴管理ができない。
→ 推奨: `.gitignore` に `!.claude/skills/` `!.claude/agents/`（必要なら `!.claude/settings.json`）の例外を追加し、
コア資産だけ追跡する。フェーズ5の早い段階でFIC判断。
</content>
