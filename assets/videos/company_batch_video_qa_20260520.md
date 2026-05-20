# 企業分析動画バッチ QA 記録 2026-05-20

対象:
- 日本製紙 3863
- 栗本鐵工所 5602
- 三和HD 5929
- リクルートHD 6098
- みずほFG 8411
- GMOインターネット 9449
- アインHD 9627
- ニトリHD 9843
- キオクシア 285A

## QA結果

- 旧版の尺は短めだったため、全18本を新尺で再生成した。
- 2026-05-20追加PDCA:
  - 各社専用の文字なしAI生成背景を作成。
  - AI生成背景を、長尺・Shortsとも全スライドの背景に適用。
  - YouTubeサムネイルも同じAI生成背景をベースに再作成。
  - サムネイル左上は公式FICロゴ画像に統一し、テキスト代用を避ける運用に変更。
  - 下部コピー帯は長文でも読めるように、横幅と高さを拡張し2行表示の余白を確保。
  - 長尺で本編に差し込む記事内画像は、記事で使っているAI生成画像2枚に限定。
  - 非AI生成の棒グラフ、業績推移、中計ブリッジ等は動画内から除外し、カード説明と音声説明に置換。
- 最終生成版の実測:
  - Shorts: 約54.7〜57.7秒
  - 長尺: 約4分02秒〜4分09秒
- 音声用ナレーションテキストで、以下のNG語は検出なし:
  - `グループグループ`
  - `ホールディングスホールディングス`
  - `エイチディー`
  - `HD`
  - `FG`
  - `HR`
  - `Indeed`
  - `IT`
  - `AI`
  - `DC`
  - `ROE`
  - `ROIC`
  - `PMI`
  - `CapEx`
  - `NAND`
  - `SSD`
  - `ASP`
  - `BiCS`
  - `CBA`
  - `M&A`
  - `粗利益`
  - `荒利益`
  - `本動画は情報提供`
  - `投資推奨`
  - `免責`
- Shortsは記事内AI図を使わず、大きいカードと短い説明文中心。
- 長尺は記事内AI生成画像2枚のみを使い、音声で図の読み方と見る順番を説明。
- 接触シート:
  - `assets/videos/qa_all_shorts_contact_20260520.jpg`
  - `assets/videos/qa_all_long_contact_20260520.jpg`
  - `assets/videos/qa_all_shorts_contact_ai_bg_figures_only_20260520.jpg`
  - `assets/videos/qa_all_long_contact_ai_bg_figures_only_20260520.jpg`
  - `assets/videos/qa_all_thumbnails_ai_bg_20260520.jpg`

## 反映した運用メモ

- `docs/video_review_notes.md` に尺目安を追記。
- `docs/chat_workflows/company_06_codex_video.md` に尺目安を追記。
- `assets/videos/batch_company_video_generator.py` の生成プロンプトにも尺目安を追記。
- TTS読み替えに `DC -> データセンター` を追加。
- `assets/videos/fic-logo-header-white-h96.png` をサムネ用公式ロゴ素材として保存。
- `assets/videos/compose_company_thumbnails.py` を追加し、ロゴ入りサムネを再生成できるようにした。

## YouTubeアップロード状況

2026-05-20 11:30頃、新尺18本の限定公開アップロードを開始。

APIクォータ上限により、GMOインターネット Shorts版の固定コメント追加時点で停止。

2026-05-20 12:40頃、コメントなし・最小操作でキオクシア Shorts版のアップロードを再試行したが、動画アップロード本体で `quotaExceeded` が発生。

このため、以下は未完了:
- 新規アップロード済み動画IDの完全な記録
- 新サムネイル設定
- 旧版YouTube動画削除
- ローカル完成動画・音声中間素材削除

旧版削除とローカル削除は、新旧対応と新規動画IDを確認してから行う。
