# 企業を探す固定ページ 反映手順

作成日: 2026-05-22

## 目的

トップページから直接記事へ行くだけでなく、企業名・証券コード・最新企業分析・決算予定をつなぐ中継固定ページを作る。

## 固定ページ本文

企業探索用の固定ページを作り、本文に以下を入れる。

```text
[fic_company_hub]
```

推奨ページ名:

```text
企業を探す
```

推奨スラッグ:

```text
companies
```

## 反映ファイル

- `wordpress/snippets/functions.php`
- `wordpress/snippets/fic-hub-pages.php`
- `wordpress/snippets/fic-company-hub.php`
- `wordpress/css/custom.css`
- `wordpress/css/fic-home-page-mvp.css`
- `wordpress/previews/fic-company-hub-preview.html`

Code Snippets で反映する場合は、3つの固定ページハブをまとめた `wordpress/snippets/fic-hub-pages.php` を使う。
`fic-company-hub.php` はテーマ側 `functions.php` に本体を入れる運用向けの補助ファイル。

## 確認すること

- 企業名・証券コード検索が検索結果へ遷移する
- 企業分析の記事数が表示される
- ヒーロー直下の共通ナビから、企業を探す、テーマから探す、投資の読み方へ移動できる
- 最新企業分析が表示される
- 決算スケジュール、テーマから探す、トップページへの導線が表示される
- スマホでカードが1列表示になり、文字がはみ出さない
