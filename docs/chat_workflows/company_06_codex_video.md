# 企業分析 06: Codex 動画作成

## 新チャット冒頭テンプレ

```text
このチャットの役割:
公開済み企業分析記事から動画を作成する。
記事本文修正、WordPress更新、画像作成、X投稿作成は原則行わない。

対象:
- 企業名:
- 証券コード:
- 対象フォルダ:
- 記事URL:

読む指示書:
- docs/video_review_notes.md
- 対象記事の handoff_image_wp_to_x_or_video.md

読むファイル:
- work/company_analysis/{code}_{company}/codex_reviewed_article.with_images.html
- 画像フォルダ
- 必要なX投稿メモがあれば AU/AV 相当の内容

触ってよいフォルダ:
- work/company_analysis/{code}_{company}/video/
- assets/videos/ または指定された動画作業フォルダ

触らないフォルダ:
- wordpress/ は動画埋め込み指示がある場合のみ
- 他企業フォルダ
- work/industry_analysis/

やること:
1. 動画構成案を作る
2. 台本、画面テキスト、素材リストを作る
3. 動画を生成する
4. 完成物と素材パスを記録する
5. 必要ならシートの動画列を更新する

完了条件:
- 完成動画
- 台本/構成メモ
- 使用素材リスト
- 動画フォルダパスの記録
```

## 注意

- 動画は重いので、記事作成チャットでは扱わない。
- 完成動画・没動画・中間素材は、リポジトリ直下に散らばらせない。

