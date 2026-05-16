# 業界分析 06: Codex 動画作成

## 新チャット冒頭テンプレ

```text
このチャットの役割:
公開済み業界分析記事から動画を作成する。
記事本文修正、WordPress更新、画像作成は原則行わない。

対象:
- 業界分析タブ row:
- テーマ名:
- 対象フォルダ:
- 記事URL:

読む指示書:
- docs/video_review_notes.md
- work/industry_analysis/{slug}/handoff_image_wp_to_video.md

読むファイル:
- work/industry_analysis/{slug}/codex_reviewed_article.with_images.html
- 画像フォルダ

触ってよいフォルダ:
- work/industry_analysis/{slug}/video/
- assets/videos/ または指定された動画作業フォルダ

触らないフォルダ:
- work/company_analysis/
- wordpress/ は動画埋め込み指示がある場合のみ
- 他テーマフォルダ

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

- 動画素材は重いので、記事作成チャットと混ぜない。
- 完成動画と没動画を同じ場所に積まない。没素材はアーカイブへ分ける。

