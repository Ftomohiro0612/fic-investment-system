# トップページMVP 反映手順

作成日: 2026-05-22

> 現在の本番運用では、この文書は初期MVP設計の背景メモとして扱う。
> 実際の反映・再反映・ロールバックは、5本のCode Snippetsを含む `wordpress/deploy/top-page-mvp/`、`docs/top_page_admin_runbook.md`、`docs/top_page_publication_playbook.md`、`docs/top_page_rollout_checklist.md` を正とする。

## 目的

トップページを「記事一覧中心」から「FIC投資研究所の読み方が伝わる入口」へ寄せる。

MVPで追加するもの:

- ヒーロー
- 黒黄グラデーションのブランド帯
- ファーストビューの記事蓄積ミニ統計
- ファーストビューの最新更新リンク
- 企業名・証券コード・テーマ検索
- 公開資料 / 会計士視点 / 編集確認 の信頼バッジ
- ページ内クイックナビ
- First Check（迷ったときの4入口）
- Market Triggers（金利・為替・原材料・AI/半導体）
- 企業分析 / テーマ分析 / 投資の読み方 / 決算予定 の4入口
- 主要入口の記事本数バッジ
- 初回訪問者向けの最初の3ステップ
- FICの読み方4ステップ
- 目的別の最新記事
- 決算で見るポイント
- 直近の分析更新予定
- 動画で見る補助導線
- About / 編集方針への信頼導線

ファーストビューの主要ボタン:

- 企業を探す
- テーマから探す
- 投資の読み方
- 決算予定

## 反映ファイル

PHPスニペット:

- `wordpress/snippets/fic-home-page-mvp.php`
- `wordpress/snippets/fic-hub-pages.php`
- `wordpress/snippets/fic-category-bridge-links.php`
- `wordpress/snippets/fic-navigation-measurement.php`
- `wordpress/snippets/fic-earnings-page-guide.php`

CSS:

- `wordpress/css/fic-home-page-mvp.css`
- 既存テーマCSSへ統合する場合は `wordpress/css/custom.css` の `.fic-home-*` 追加部分

画像:

- `wordpress/assets/fic-logo-header-white-h96.png`
- `wordpress/assets/fic-logo-header-white-transparent.png`
- `wordpress/assets/fic-logo-header-dark-transparent.png`

固定ページ本文:

```text
[fic_home_mvp]
```

ローカル静的プレビュー:

- `wordpress/previews/index.html`
- `wordpress/previews/fic-home-page-mvp-preview.html`
- `wordpress/previews/fic-company-hub-preview.html`
- `wordpress/previews/fic-theme-hub-preview.html`
- `wordpress/previews/fic-learning-hub-preview.html`
- `wordpress/previews/responsive-qa.html`

このHTMLはWordPressの動的取得を再現するものではなく、レイアウトとCSSの確認用。

## 推奨反映手順

現在の推奨は、`scripts\build_top_page_deploy_package.ps1` で生成した配布パッケージを使い、Code Snippets の独立スニペット方式で管理すること。
テーマの `functions.php` へ直接追記するより、無効化とロールバックが簡単です。

実際の本番反映順は `docs/top_page_rollout_checklist.md` を基準にする。
管理画面での貼り付け順と公開後の戻し方は `docs/top_page_publication_playbook.md` を参照する。

### 0. ローカルプレビュー確認

ローカルプレビューサーバーを起動する。

```powershell
powershell -ExecutionPolicy Bypass -File scripts\start_top_page_preview.ps1 -Restart
```

ブラウザで以下を開き、PC幅とスマホ幅の見え方を確認する。

```text
http://127.0.0.1:4291/previews/index.html
http://127.0.0.1:4291/previews/responsive-qa.html
```

確認すること:

- ヒーローの文字が大きすぎない
- First Checkの4入口が、最初に目に入る位置で分かりやすい
- 4入口カードの高さと余白が不自然でない
- トップ、企業、テーマ、学習の4プレビューを一覧から開ける
- レスポンシブ確認ページでトップと3ハブを390px幅で見られる
- FICの読み方4ステップがスマホで1列になる
- 最新記事カードのタイトルがはみ出さない
- 決算スケジュールのサンプルカードがスマホで横崩れしない

### 1. PHPスニペットを追加

WordPress管理画面の Code Snippets で新規スニペットを作成する。

本番と同じ構成にする場合は、配布パッケージ内の `wordpress/deploy/top-page-mvp/code-snippets-paste/` にある `<?php` なし版を使う。

推奨名:

```text
FIC: Home page MVP shortcode
```

内容:

- `wordpress/snippets/fic-home-page-mvp.php` の中身を貼る
- `<?php` は Code Snippets 側の仕様に合わせる
  - Code Snippets がPHP開始タグ不要の場合は、先頭の `<?php` を外す
  - ファイルとしてテーマへ置く場合は `<?php` を残す

実行範囲:

- フロントエンドのみ、またはサイト全体

有効化前確認:

- 保存時に構文エラーが出ないこと
- `fic_home_mvp` というショートコードが既存と衝突していないこと
- テーマ側 `functions.php` に同じ関数を入れる場合も、`function_exists()` ガード付きの状態で使うこと

目的別固定ページも同時に反映する場合は、別スニペットとして `wordpress/snippets/fic-hub-pages.php` を追加する。
この1ファイルで `[fic_company_hub]`、`[fic_theme_hub]`、`[fic_learning_hub]` をまとめて登録する。

本番運用では、以下の追加スニペットも使う。

- `FIC: Category bridge internal links`
- `FIC: Navigation measurement events`
- `FIC: Earnings schedule page guide`

### 2. CSSを追加

WordPressの追加CSS、またはテーマ側CSSに `wordpress/css/fic-home-page-mvp.css` の中身を反映する。

`custom.css` へ直接統合する場合は、同じCSSが `wordpress/css/custom.css` にも `.fic-home-*` ブロックとして入っている。

既存の決算スケジュールCSSはそのまま使う。

### 3. ヘッダー用ロゴ画像を配置

白背景のヘッダーでは `wordpress/assets/fic-logo-header-dark-transparent.png` を使う。

Diver側のヘッダー画像を直接差し替えられない場合は、追加CSS側で既存ヘッダー画像URLを濃紺ロゴへ置換する。
`wordpress/assets/fic-logo-header-white-transparent.png` は、黒背景でロゴを出す必要がある場合の予備として残す。

### 4. 固定ページ本文を更新

トップページとして使っている固定ページ本文に、MVPを表示したい位置で以下を入れる。

```text
[fic_home_mvp]
```

既存のトップ本文をいきなり削除しない。
まずは上部に追加してプレビューし、表示が安定してから旧ブロックを下げるか削除する。

### 5. プレビュー確認

PCで確認:

- ヒーローがファーストビューで見える
- ヘッダーのロゴが白背景で濃紺に見える
- ヒーロー内に重複ロゴが表示されない
- 検索フォームから検索結果ページへ移動できる
- 4入口のリンク先が `companies`、`themes`、`learn`、`earnings-schedule` へ飛ぶ
- 最新記事が企業分析/テーマ分析に表示される
- 基礎講座は記事がない場合に準備中表示になる
- 決算スケジュールカードが表示される
- `動画でざっくり見る` から YouTube チャンネルへ移動できる

スマホで確認:

- 4入口が1列で並ぶ
- FICの読み方4ステップが1列で読める
- 最新記事カードのタイトルがはみ出さない
- ボタン文字が折り返しても崩れない

SEO/GEO確認:

- ヒーロー、FICの読み方、編集方針導線が生HTMLに出ている
- JS依存で後から生成される構成になっていない

## ロールバック

表示崩れやエラーが出た場合:

1. 固定ページ本文から `[fic_home_mvp]` を外す
2. Code Snippets の `FIC: Home page MVP shortcode` を無効化する
3. 必要に応じて `FIC: Purpose hub shortcodes`、`FIC: Category bridge internal links`、`FIC: Navigation measurement events`、`FIC: Earnings schedule page guide` を無効化する
4. 追加CSSの `.fic-home-*`、`.fic-hub-*`、`.fic-article-bridge`、`.fic-earnings-guide` 部分を外す

記事内導線、計測、決算予定ガイドだけを戻す場合は、対象スニペットのみを無効化する。

## 次の改善候補

- 「投資の読み方」固定ページの基礎講座導線を育てる
- トップの旧記事一覧・サイドバー表示を整理する
- 人気記事を「読者の疑問別」に出し分ける

## 目的別固定ページ

トップページにすべてを詰め込むと文字量が多く見えやすいため、目的別の固定ページをかませる。

- 企業を探す: `[fic_company_hub]`
  - 推奨スラッグ: `companies`
  - 詳細: `docs/company_hub_deployment.md`
- テーマから探す: `[fic_theme_hub]`
  - 推奨スラッグ: `themes`
  - 詳細: `docs/theme_hub_deployment.md`
- 投資の読み方: `[fic_learning_hub]`
  - 推奨スラッグ: `learn`
  - 詳細: `docs/learning_hub_deployment.md`
