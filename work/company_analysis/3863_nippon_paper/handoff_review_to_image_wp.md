# Handoff: Codexレビュー → 画像作成・WordPress反映

対象: 日本製紙（3863） row 78

## 正本

- レビュー済みHTML: `work/company_analysis/3863_nippon_paper/codex_reviewed_article.html`
- Claude元HTML: `work/company_analysis/3863_nippon_paper/claude_article.html`
- レビューノート: `work/company_analysis/3863_nippon_paper/claude_review_notes.md`

## WordPressタイトル

- article_title: 日本製紙（3863）の企業分析｜業界トレンド・中計2030の構造改革ブリッジを読む
- slug: nippon-paper-3863-analysis

WordPress反映時は、本文に `<h1>` が無い前提で、必ず `article_title:` を `post_title` に明示セットしてください。反映後にREST応答または管理画面で `title.rendered` が上記タイトルと一致することを確認してください。

## Codexレビューでの主な修正

- 会社為替前提に対する円高/円安方向へ表現を修正
- 王子HDの外部企業リンクをテキスト化
- 強すぎる「前提崩壊」を緩和

## 画像・グラフ工程への注意

- 既存の画像挿入済みHTMLがある場合でも旧版由来の可能性があるため、今回の `codex_reviewed_article.html` を起点に再作成してください。
- 8列以上の表は次工程で横スクロール表示を維持してください。特に英字・社名・KPIが長い表では、スマホ/サイドバー環境で1文字折返しが出ないか目視確認してください。
- 横長表はtable-wrapper付きのため次工程で横スクロール表示を維持。

## WordPress反映後チェック

- `post_title` が `article_title:` と一致
- 本文内に `<h1>` がない
- 画像alt属性が会社名・論点に対応
- 参照資料リンクがクリック可能
- 表がサイドバーへ潜り込まない
