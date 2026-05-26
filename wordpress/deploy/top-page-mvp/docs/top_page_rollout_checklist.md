# トップページ改修 本番反映チェックリスト

作成日: 2026-05-22

## 目的

トップページMVPと3つの固定ページハブを、WordPressへ安全に反映するための作業順チェックリスト。

管理画面での具体的な貼り付け順、公開直後に残すもの、問題発生時の戻し方は `docs/top_page_publication_playbook.md` も参照する。
公開当日に上から順に使う手順書は `docs/top_page_admin_runbook.md` を参照する。

## 反映するページ

| ページ | 推奨スラッグ | 本文ショートコード |
| --- | --- | --- |
| トップページ | 既存トップページ | `[fic_home_mvp]` |
| 企業を探す | `companies` | `[fic_company_hub]` |
| テーマから探す | `themes` | `[fic_theme_hub]` |
| 投資の読み方 | `learn` | `[fic_learning_hub]` |

## 反映するファイル

Code Snippets:

- `wordpress/snippets/fic-home-page-mvp.php`
- `wordpress/snippets/fic-hub-pages.php`
- `wordpress/snippets/fic-category-bridge-links.php`
- `wordpress/snippets/fic-navigation-measurement.php`
- `wordpress/snippets/fic-earnings-page-guide.php`
- 配布パッケージでは `wordpress/deploy/top-page-mvp/code-snippets-paste/` の `<?php` なし版を優先して使う。

CSS:

- `wordpress/css/fic-home-page-mvp.css`

画像:

- `wordpress/assets/fic-logo-header-dark-transparent.png`
- `wordpress/assets/fic-logo-header-white-transparent.png`

ローカル確認:

- `wordpress/previews/index.html`
- `wordpress/previews/responsive-qa.html`

公開手順:

- `docs/top_page_admin_runbook.md`
- `docs/top_page_publication_playbook.md`
- `docs/top_page_measurement_plan.md`
- `docs/top_page_legacy_cleanup_plan.md`
- `docs/top_page_content_growth_plan.md`

ローカル検証コマンド:

```powershell
powershell -ExecutionPolicy Bypass -File scripts\verify_top_page_mvp.ps1
```

ローカルプレビュー起動:

```powershell
powershell -ExecutionPolicy Bypass -File scripts\start_top_page_preview.ps1 -Restart
```

確認URL:

- `http://127.0.0.1:4291/previews/index.html`
- `http://127.0.0.1:4291/previews/responsive-qa.html`

本番反映用パッケージ生成:

```powershell
powershell -ExecutionPolicy Bypass -File scripts\build_top_page_deploy_package.ps1
```

出力先:

- `wordpress/deploy/top-page-mvp/`

固定ページ本文とメニュー案:

- `wordpress/deploy/top-page-mvp/fixed-page-bodies/top-page.txt`
- `wordpress/deploy/top-page-mvp/fixed-page-bodies/companies.txt`
- `wordpress/deploy/top-page-mvp/fixed-page-bodies/themes.txt`
- `wordpress/deploy/top-page-mvp/fixed-page-bodies/learn.txt`
- `wordpress/deploy/top-page-mvp/fixed-page-bodies/recommended-menu.md`

## 推奨作業順

1. ローカルで `wordpress/previews/index.html` を開き、トップと3ハブを確認する。
2. WordPressへヘッダー用ロゴ画像 `fic-logo-header-dark-transparent.png` を配置する。
3. Code Snippets に `FIC: Home page MVP shortcode` を作成し、`fic-home-page-mvp.php` を反映する。
4. Code Snippets に `FIC: Purpose hub shortcodes` を作成し、`fic-hub-pages.php` を反映する。
5. Code Snippets に `FIC: Category bridge internal links` を作成し、`fic-category-bridge-links.php` を反映する。
6. Code Snippets に `FIC: Navigation measurement events` を作成し、`fic-navigation-measurement.php` を反映する。
7. Code Snippets に `FIC: Earnings schedule page guide` を作成し、`fic-earnings-page-guide.php` を反映する。
8. 追加CSSへ `fic-home-page-mvp.css` を反映する。
9. 固定ページ `企業を探す` を作成し、本文に `[fic_company_hub]` を置く。
10. 固定ページ `テーマから探す` を作成し、本文に `[fic_theme_hub]` を置く。
11. 固定ページ `投資の読み方` を作成し、本文に `[fic_learning_hub]` を置く。
12. 既存トップページの上部に `[fic_home_mvp]` を追加する。
13. WordPressメニューを新しい入口名に更新する。
14. 表示確認後、旧トップ本文の重複する導線を下げるか削除する。

## 推奨メニュー構成

主ナビゲーション:

| 表示名 | リンク先 | 役割 |
| --- | --- | --- |
| 企業を探す | `/companies/` | 企業名・証券コード起点の入口 |
| テーマから探す | `/themes/` | ニュース・マクロ材料起点の入口 |
| 投資の読み方 | `/learn/` | 初心者・基礎確認の入口 |
| 決算予定 | `/earnings-schedule/` | 決算前後の確認入口 |

残すか検討:

- `YouTube`: 動画導線を維持する場合のみ残す。
- `企業分析` / `テーマ分析`: 主ナビからは下げ、カテゴリ一覧やハブ内の「一覧」リンクで受け止める。

理由:

- 初見読者にはカテゴリ名よりも「何をしたいか」が伝わる表示名のほうが迷いにくい。
- トップページ、固定ページハブ、ヘッダーの入口名を揃えると、サイト全体が一つの道具として見える。

## 公開前確認

- ヘッダーのロゴが白背景で濃紺に見える。
- トップページのヒーロー内に重複ロゴが表示されない。
- トップページの4入口が `companies`、`themes`、`learn`、`earnings-schedule` へ移動する。
- `企業を探す`、`テーマから探す`、`投資の読み方` の共通ナビが表示される。
- ヘッダー/メニューの表示名が `企業を探す`、`テーマから探す`、`投資の読み方`、`決算予定` に揃っている。
- 各固定ページの検索フォームが検索結果へ遷移する。
- 企業・テーマ・投資の読み方・トップの主要導線に `data-fic-area` と `data-fic-label` が入っている。
- 最新記事が空の場合でも「準備中」表示になり、レイアウトが崩れない。
- PCとスマホでカードの文字がはみ出さない。
- 決算スケジュールが既存の表示を壊していない。
- 決算予定ページ上部に、企業ハブと投資の読み方へ戻るガイドが表示される。
- 代表的な企業分析・テーマ分析記事の上部と末尾に、学習記事/テーマ解説への内部リンク導線が出ている。
- 生HTMLに主要見出し、FICの読み方、編集方針導線が出ている。

## ロールバック

表示崩れやエラーが出た場合:

1. トップページ本文から `[fic_home_mvp]` を外す。
2. `企業を探す`、`テーマから探す`、`投資の読み方` の固定ページを非公開にする。
3. Code Snippets の `FIC: Home page MVP shortcode` を無効化する。
4. Code Snippets の `FIC: Purpose hub shortcodes` を無効化する。
5. Code Snippets の `FIC: Category bridge internal links` を無効化する。
6. Code Snippets の `FIC: Navigation measurement events` を無効化する。
7. Code Snippets の `FIC: Earnings schedule page guide` を無効化する。
8. 追加CSSの `.fic-home-*`、`.fic-hub-*`、`.fic-article-bridge`、`.fic-earnings-guide` ブロックを外す。

部分的に戻す場合:

- 記事内の自動導線だけを止める場合は `FIC: Category bridge internal links` のみ無効化する。
- クリック計測だけを止める場合は `FIC: Navigation measurement events` のみ無効化する。
- 決算予定ページ上部のガイドだけを止める場合は `FIC: Earnings schedule page guide` のみ無効化する。

## 反映後に見ること

- トップページから4入口へのクリックが発生しているか。
- ヘッダー/メニューから4入口へのクリックが発生しているか。
- 検索フォームが使われているか。
- `投資の読み方` から企業・テーマへ移動しているか。
- 旧カテゴリ一覧への直行より、固定ページハブ経由の回遊が増えているか。

主要リンクには `data-fic-area` と `data-fic-label` を付けているため、GTM/GA4で入口別クリックを拾える。
設定例は `docs/top_page_measurement_plan.md` を参照する。
旧トップ本文、カテゴリ導線、サイドバーを下げる順番は `docs/top_page_legacy_cleanup_plan.md` を参照する。
公開後に増やす投資の読み方・テーマの読み方・企業ハブ改善は `docs/top_page_content_growth_plan.md` を参照する。
