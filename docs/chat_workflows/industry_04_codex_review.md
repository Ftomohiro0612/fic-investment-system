# 業界分析 04: Codex レビュー

## 新チャット冒頭テンプレ

```text
このチャットの役割:
Claudeが作成した業界分析記事をCodexでレビューし、必要な修正を行う。
画像作成、WordPress反映、動画作成は行わない。

参照する管理シート:
- FIC記事管理_v3:
  https://docs.google.com/spreadsheets/d/1ExBSpP3-QMN2gmh9qswp986LKDKXzsWfjzl78DCDoUg/edit
- 対象タブ: 業界分析
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
4. タイトル、冒頭、30秒要約、FAQの読みやすさと表現強度を確認する
5. 必要なら codex_reviewed_article.html を作る
6. review_notes に Codexレビュー結果を追記する

完了条件:
- codex_reviewed_article.html
- Codexレビュー結果
- handoff_review_to_image_wp.md
```

## 注意

- 読者が知りたいのは「このテーマでどの企業に影響するか」。
- 根拠が弱いから全て丸めるのではなく、確度が高い推定は出典階層と注意書きを付けて残す。
- Codexレビューはファクトチェックだけで終えない。公開記事として、タイトルが検索意図に近いか、冒頭で結論と確認順が分かるか、本文が読者の疑問に沿っているかを見る。
- `直接恩恵` `確認候補` `周辺材料` が混ざっていないか確認する。正式受注・契約・供給関係がない企業を直接恩恵と書いていたら修正する。
- `始まった` `確定した` `恩恵を受ける` `転換した` など、公式発表より強い断定を探し、必要に応じて `可能性がある` `確認候補` `正式発表を待つ` に弱める。
- 周辺材料を起点イベントの直接成果のように書いていないか確認する。例: 既存工場の黒字化、類似事例、業界統計は、新規投資の直接収益化ではなく補強材料として扱う。
- 関連銘柄表には、対象工程、直接度、確認KPI、反証条件があるか確認する。
