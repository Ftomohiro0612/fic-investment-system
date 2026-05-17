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
4. 必要なら codex_reviewed_article.html を作る
5. claude_review_notes.md 末尾に Codexレビュー結果を追記する

完了条件:
- codex_reviewed_article.html
- Codexレビュー結果
- 次工程への handoff_review_to_image_wp.md
```

## 注意

- レビューは記事の「信頼性」と「投資家向け実用性」を最優先する。
- 公開本文に未作成リンク、リンクなし関連銘柄、広すぎる関連テーマを残さない。
- WordPress更新は次工程に渡す。

