# Handoff: Codexレビュー → 画像/WP工程（日本製紙 3863）

## レビュー済み正本

- レビュー後HTML: `work/company_analysis/3863_nippon_paper/codex_reviewed_article.html`
- 元Claude HTML: `work/company_analysis/3863_nippon_paper/claude_article.html`
- レビューノート: `work/company_analysis/3863_nippon_paper/claude_review_notes.md`

## Codexレビュー結果

- v4試行版（13規律＋必須グラフ3箇所）・15章構造は実装済み。
- FIC主軸（製紙業界の成熟/斜陽混在 → 日本製紙の紙・板紙価格修正/生活関連海外/木材バイオマス/構造改革 → 営業利益 → 中計2030検証）は維持。
- H2 7のH3順序は「生活関連 → 紙・板紙 → 原燃料・為替 → 木材・バイオマス」で確定。画像1もこの順序に合わせる。
- 必須グラフ3箇所のHTMLコメントマーカーを確認済み:
  - H3 5.1 セグメント別売上・営業利益
  - H2 6 業績の全体像（FY21-FY30）
  - H2 8 中期経営計画の達成検証
- 為替表現を会社開示の「1円円高で+5.5億円」に整合する形へ修正。
- 王子HDへの外部企業サイトリンクを削除し、関連銘柄はテキスト表示へ統一。
- 「前提崩壊」は公開本文向けに「前提見直し」へ調整。

## 次工程への注意

- WordPress反映は `codex_reviewed_article.html` を正本にする。
- 既存の `codex_reviewed_article.with_images.html` がある場合でも、16:38更新版レビュー前HTMLに基づく可能性があるため、画像挿入HTMLは再作成する。
- 画像1（上流環境マップ）は同一ファイル名で上書きする場合も、4テーマ順序と列名を最新本文に合わせる。
- 新規グラフ3箇所は、本文表の数値・単位を正とし、画像側で数値を増やさない。
- Opal/NDPの単独利益は開示範囲に留め、画像や追加本文で過度に積み上げない。
