# テーマから探す固定ページ 反映手順

作成日: 2026-05-22

## 目的

トップページから記事へ直接飛ばすだけでなく、ニュース・マクロ材料・政策・原材料などを起点に、関連するテーマ分析、テーマの読み方、企業分析へ進める中継固定ページを作る。

## 固定ページ本文

テーマ探索用の固定ページを作り、本文に以下を入れる。

```text
[fic_theme_hub]
```

推奨ページ名:

```text
テーマから探す
```

推奨スラッグ:

```text
themes
```

## 反映ファイル

- `wordpress/snippets/functions.php`
- `wordpress/snippets/fic-hub-pages.php`
- `wordpress/snippets/fic-theme-hub.php`
- `wordpress/css/custom.css`
- `wordpress/css/fic-home-page-mvp.css`
- `wordpress/previews/fic-theme-hub-preview.html`

Code Snippets で反映する場合は、3つの固定ページハブをまとめた `wordpress/snippets/fic-hub-pages.php` を使う。
`fic-theme-hub.php` はテーマ側 `functions.php` に本体を入れる運用向けの補助ファイル。

## 確認すること

- テーマ・材料検索が検索結果へ遷移する
- テーマ分析の記事数が表示される
- ヒーロー直下の共通ナビから、企業を探す、テーマから探す、投資の読み方へ移動できる
- 金利、為替、原材料、AI・半導体、政策・規制、エネルギーの入口が表示される
- 最新テーマ分析が表示される
- 企業を探す、投資の読み方、トップページへの導線が表示される
- スマホでカードが1列表示になり、文字がはみ出さない

## トップページとの関係

トップページは第一印象と大きな入口、固定ページは目的別の深掘り入口として使う。

- トップページ: 何のサイトか、どこから読めばよいかを3秒で伝える
- 企業を探す: 企業名・証券コード・決算予定から入る
- テーマから探す: ニュースや材料から業界・企業への波及を探す
