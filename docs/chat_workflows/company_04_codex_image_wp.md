# 企業分析 04: Codex 画像作成・WordPress反映

## 新チャット冒頭テンプレ

```text
このチャットの役割:
レビュー済み企業分析記事に画像・非AI図表を作成/挿入し、WordPressへ反映する。
記事本文の大幅リライト、動画作成、X投稿は行わない。

対象:
- 企業名:
- 証券コード:
- 対象フォルダ:
- WP投稿ID:

読む指示書:
- docs/codex_company_analysis_pack_spec.md の画像作成・WordPress反映章
- docs/non_ai_structure_chart_lessons.md
- docs/wordpress_media_cleanup_policy.md
- docs/reference_images/

読むファイル:
- work/company_analysis/{code}_{company}/handoff_review_to_image_wp.md
- work/company_analysis/{code}_{company}/codex_reviewed_article.html
- work/company_analysis/{code}_{company}/claude_review_notes.md

触ってよいフォルダ:
- work/company_analysis/{code}_{company}/
- work/company_analysis/{code}_{company}/images/
- wordpress/snippets/ は明示的に必要な場合のみ

触らないフォルダ:
- 他企業フォルダ
- work/industry_analysis/
- assets/videos/

やること:
1. 画像方針を確認する
2. AI生成画像または非AI図表を作る
3. 文字かぶり、読みやすさ、スマホ表示を確認する
4. WordPressはAMの既存投稿IDを確認し、IDがあれば更新する
5. 画像格納フォルダをAYへ記録する
6. 未使用WordPressメディアを確認し、削除対象なし/削除済みを記録する

完了条件:
- codex_reviewed_article.with_images.html
- WordPress更新済み
- シートの AW/AX/AY/AN/AP/AQ/AS 更新
- 次工程への handoff_image_wp_to_x_or_video.md
```

## 注意

- 既存投稿IDがある場合は必ず既存投稿を更新する。新規作成しない。
- スラッグは既に決まっている場合、絶対に変更しない。
- アイキャッチはユーザーが明示しない限り変更しない。

