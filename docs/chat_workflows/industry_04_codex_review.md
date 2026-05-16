# 業界分析 04: Codex レビュー

## 新チャット冒頭テンプレ

```text
このチャットの役割:
Claudeが作成した業界分析記事をCodexでレビューし、必要な修正を行う。
画像作成、WordPress反映、動画作成は行わない。

対象:
- 業界分析タブ row:
- テーマ名:
- 対象フォルダ:

読む指示書:
- docs/codex_industry_analysis_migration_spec.md
- docs/claude_industry_analysis_handoff.md
- prompts/shared/quality_checklist.md
- prompts/seo/internal_link_rules.md

読むファイル:
- work/industry_analysis/{slug}/industry_analysis_article.html
- work/industry_analysis/{slug}/industry_analysis_memo.md
- work/industry_analysis/{slug}/industry_analysis_review_notes.md
- work/industry_analysis/{slug}/source_search_results.md

触ってよいフォルダ:
- work/industry_analysis/{slug}/

触らないフォルダ:
- work/company_analysis/
- wordpress/ は読まない
- assets/videos/

やること:
1. テーマ起点、関連銘柄への波及、先行指標、リスクを確認する
2. 確定/報道/仮説の区別を確認する
3. 見出し階層、表、図表位置、参照資料形式を整える
4. 必要なら codex_reviewed_article.html を作る
5. review_notes に Codexレビュー結果を追記する

完了条件:
- codex_reviewed_article.html
- Codexレビュー結果
- handoff_review_to_image_wp.md
```

## 注意

- 読者が知りたいのは「このテーマでどの企業に影響するか」。
- 根拠が弱いから全て丸めるのではなく、確度が高い推定は出典階層と注意書きを付けて残す。

