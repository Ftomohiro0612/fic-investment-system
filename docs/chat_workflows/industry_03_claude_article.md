# 業界分析 03: Claude 記事作成

## 新チャット冒頭テンプレ

```text
このチャットの役割:
Codexが作成した業界分析投入パックをもとに、Claude Codeで記事3点セットを作成する。
外部検索、WordPress反映、画像作成、動画作成は行わない。

参照する管理シート:
- FIC記事管理_v3:
  https://docs.google.com/spreadsheets/d/1ExBSpP3-QMN2gmh9qswp986LKDKXzsWfjzl78DCDoUg/edit
- 対象タブ: 業界分析
対象:
- 業界分析タブ row:
- テーマ名:
- 対象フォルダ:

読むファイル:
- work/industry_analysis/{slug}/CLAUDE_INDUSTRY_CODE_INSTRUCTIONS.md
- work/industry_analysis/{slug}/industry_input_pack.md
- work/industry_analysis/{slug}/source_search_results.md
- prompts/article/industry_analysis_article_main.md
- prompts/article/industry_analysis_memo_main.md
- prompts/shared/quality_checklist.md

触ってよいフォルダ:
- work/industry_analysis/{slug}/

触らないフォルダ:
- work/company_analysis/
- wordpress/
- assets/videos/

作るもの:
1. industry_analysis_memo.md
2. industry_analysis_article.html
3. industry_analysis_review_notes.md

完了条件:
- 記事HTMLが公開本文として読める
- review_notes に判断論点、非AI図表候補、Codexレビュー依頼がある
- handoff_claude_to_codex_review.md
```

## 注意

- 業界分析は「ニュース紹介」ではなく「関連企業にどう波及するか」を主役にする。
- 起点イベント型の記事では、冒頭で何がわかる記事かを説明し、30秒要約、全体像H2、影響マップの順で入る。

