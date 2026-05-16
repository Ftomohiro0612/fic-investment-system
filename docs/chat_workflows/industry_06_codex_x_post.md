# 業界分析 06: Codex X投稿

## 新チャット冒頭テンプレ

```text
このチャットの役割:
公開直前または公開済みの業界分析記事をもとに、X投稿用メモと投稿文を作る。
記事本文の修正、画像作成、WordPress反映、動画作成は行わない。

対象:
- 業界分析タブ row:
- テーマ名:
- 対象フォルダ:
- 記事URL:
- WP投稿ID:

読む指示書:
- docs/x_post_company_analysis_workflow.md（投稿の型・文字数・URL/ハッシュタグ確認ルールを流用）
- prompts/social/x_post_company_analysis_main.md（企業分析用のため、決算メモ表現は業界テーマ用に読み替える）
- docs/codex_industry_analysis_migration_spec.md の「テーマ→関連銘柄への波及」方針

読むファイル:
- work/industry_analysis/{slug}/codex_reviewed_article.with_images.html
- なければ codex_reviewed_article.html / industry_analysis_article.html
- work/industry_analysis/{slug}/industry_analysis_memo.md
- work/industry_analysis/{slug}/industry_analysis_review_notes.md

触ってよい範囲:
- Google Sheets 業界分析タブのX投稿関連列（列が未作成なら、次アクション/メモ欄へ記録し、列追加は別工程に渡す）
- work/industry_analysis/{slug}/ はメモ保存が必要な場合のみ

触らないフォルダ:
- wordpress/
- work/company_analysis/
- assets/videos/

やること:
1. X投稿用テーマメモを作る
2. 5案程度を検討し、採用3本だけを保存する
3. 投稿は「テーマの起点 → 波及する業界/企業群 → 見る指標」まで入れる
4. URL、ハッシュタグ、未確認数値、文字数を確認する
5. シートへ投稿メモ・投稿文・ステータスを記録する

完了条件:
- X投稿用テーマメモ
- 投稿3本
- シート更新または更新先未整備の場合のhandoff作成
```

## 注意

- 業界分析のX投稿は「関連銘柄煽り」ではなく、投資家が次に見る指標へ誘導する。
- 1投稿1メッセージ。
- 記事にない数字は足さない。
- 公式発表/報道ベース/FIC推定の区別を崩さない。
- FICらしい「起点イベント → 影響経路 → 関連業界/企業 → 先行指標」の因果を入れる。
