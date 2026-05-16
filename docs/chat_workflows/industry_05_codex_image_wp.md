# 業界分析 05: Codex 画像作成・WordPress反映

## 新チャット冒頭テンプレ

```text
このチャットの役割:
レビュー済み業界分析記事に生成AI画像・非AI図表を作成/挿入し、WordPressへ反映する。
記事本文の大幅リライト、動画作成は行わない。

対象:
- 業界分析タブ row:
- テーマ名:
- 対象フォルダ:
- WP投稿ID:

読む指示書:
- docs/codex_industry_analysis_migration_spec.md の画像・WordPress反映章
- docs/non_ai_structure_chart_lessons.md
- docs/wordpress_media_cleanup_policy.md
- docs/reference_images/industry_analysis/

読むファイル:
- work/industry_analysis/{slug}/handoff_review_to_image_wp.md
- work/industry_analysis/{slug}/codex_reviewed_article.html
- work/industry_analysis/{slug}/industry_analysis_review_notes.md

触ってよいフォルダ:
- work/industry_analysis/{slug}/
- work/industry_analysis/{slug}/images/
- wordpress/snippets/ は明示的に必要な場合のみ

触らないフォルダ:
- work/company_analysis/
- assets/videos/
- 他テーマフォルダ

やること:
1. 生成AI画像を作る
2. 重要箇所には非AI図表/構造図も作る
3. 図表は「何を伝えたいか」が見ただけでわかる文言にする
4. WordPressはALの既存投稿IDを確認し、IDがあれば更新する
5. 画像フォルダ、投稿ID、ステータスをシートへ記録する
6. WordPress反映後、ローカル画像フォルダの旧版・没版・差し替え前画像を削除し、採用版だけ残す

完了条件:
- codex_reviewed_article.with_images.html
- WordPress更新済み
- シート更新
- WordPress未使用メディアとローカル旧版画像の削除結果を作業メモに記録
- handoff_image_wp_to_video.md
```

## 注意

- 図表は原則、説明対象の表より前に置く。
- AI生成画像はテーマ全体像を理解するための画像。非AI図表は数字と確認順を理解するための画像。

