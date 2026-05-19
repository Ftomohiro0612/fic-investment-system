# 企業分析 03: Codex レビュー

## 新チャット冒頭テンプレ

```text
このチャットの役割:
Claudeが作成した企業分析記事をCodexでレビューし、必要な修正を行う。
画像作成、WordPress反映、動画作成、X投稿は行わない。

参照する管理シート:
- FIC記事管理_v3:
  https://docs.google.com/spreadsheets/d/1ExBSpP3-QMN2gmh9qswp986LKDKXzsWfjzl78DCDoUg/edit
- 対象タブ: 企業分析
対象:
- 企業名:
- 証券コード:
- 対象フォルダ:

読む指示書:
- docs/codex_company_analysis_pack_spec.md のレビュー関連章
- docs/claude_integrated_memo_lessons.md
- prompts/shared/quality_checklist.md
- prompts/seo/internal_link_rules.md

読むファイル:
- work/company_analysis/{code}_{company}/claude_article.html
- work/company_analysis/{code}_{company}/claude_integrated_memo.md
- work/company_analysis/{code}_{company}/claude_review_notes.md
- work/company_analysis/{code}_{company}/pdf_summary.md

触ってよいフォルダ:
- work/company_analysis/{code}_{company}/

触らないフォルダ:
- work/industry_analysis/
- wordpress/ は読まない
- assets/videos/

やること:
1. 数値、単位、年度、会計指標を確認する
2. 因果関係が薄い箇所を補う
3. 表の向き、見出し、用語メモ、関連銘柄、関連テーマを確認する
4. Claudeが修正した最新版 `claude_article.html` を確認し、必要なら `codex_reviewed_article.html` へ取り込んだ上でCodex修正を再適用する
5. 必要なら codex_reviewed_article.html を作る
6. claude_review_notes.md 末尾に Codexレビュー結果を追記する

完了条件:
- codex_reviewed_article.html
- Codexレビュー結果
- 次工程への handoff_review_to_image_wp.md
```

## 注意

- レビューは記事の「信頼性」と「投資家向け実用性」を最優先する。
- 公開本文に未作成リンク、リンクなし関連銘柄、広すぎる関連テーマを残さない。
- WordPress更新は次工程に渡す。

## 完成前セルフチェック

レビュー完了前に、対象HTMLで以下を確認する。

- `article_title:` と `slug:` が冒頭メタコメントに存在する。
- `<h1>` は本文に残さない。WordPress反映工程では必ず `article_title:` を `post_title` に明示セットするよう、`handoff_review_to_image_wp.md` に書く。
- `one-liner-summary`、`definition-lead`、`summary-box` が各1件ある。
- H2 1〜12の章導入 `<em>` が12件ある。
- H2 1〜12の章末まとめが全章にある。王子HD型の `<strong>結局、N章のまとめは：</strong>` と既存インライン型のどちらでもよいが、12章カバーを確認する。
- 必須グラフマーカー3箇所（5.1、6章、8章）がある。
- 画像連動マーカー2箇所がある。
- 参照リンク数がhandoffまたは作成者申告と一致する。
- 公開本文に `要確認`、`要追加確認`、`未確認`、`リンク未取得`、`TODO`、`FIXME` を残さない。
- 関連銘柄に外部企業サイトへのリンクを付けない。内部リンクが未整備ならテキスト表示にする。
- `円高反転`、`円安進行` のような雑な為替表現は、会社為替前提がある場合は「会社前提より円高方向/円安方向」に直す。
- `崩壊`、`圧倒的`、`独占`、`V字回復` など強すぎる表現を避ける。
- 8列以上の横長表、英字が1文字ずつ折り返される表、サイドバーへはみ出す表は、列数を4〜5列へ統合するか、次工程で横スクロール表示にする旨を明記する。

### 推奨grep

```bash
rg -n '<h1|class="one-liner-summary"|class="definition-lead"|class="summary-box"|<em>|<strong>結局、|article_title:|slug:' work/company_analysis/{code}_{company}/codex_reviewed_article.html
rg -n '要確認|要追加確認|未確認|リンク未取得|TODO|FIXME|セグメント別利益|2027年3月期通期予想|円高反転|円安進行|圧倒的|独占|崩壊|TSMC直撃|V字回復' work/company_analysis/{code}_{company}/codex_reviewed_article.html
```

## 次工程handoff必須事項

`handoff_review_to_image_wp.md` には以下を必ず書く。

- 次工程は `codex_reviewed_article.html` を正本として使用する。
- WordPress反映時は `article_title:` を `post_title` に明示セットする。
- 本文に `<h1>` は置かない前提のため、`<h1>` からタイトル抽出しない。
- WordPress反映後、REST応答または管理画面で `title.rendered` が `article_title:` と一致することを確認する。
- 既存の `codex_reviewed_article.with_images.html` が旧版由来の場合は、今回の正本HTMLから画像/グラフ挿入HTMLを再作成する。

