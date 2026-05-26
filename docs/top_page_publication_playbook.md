# トップページ改修 公開プレイブック

作成日: 2026-05-22

## 目的

トップページMVPと3つの固定ページハブを、WordPress管理画面で迷わず公開するための実務メモ。

この資料は、`docs/top_page_rollout_checklist.md` よりも実作業寄りに、管理画面で何を作り、どの順に確認するかをまとめる。
公開当日に上から順に進める用途では、`docs/top_page_admin_runbook.md` を使う。

## 公開するページ

| ページ名 | URL | 本文 |
| --- | --- | --- |
| トップページ | 既存トップ | `[fic_home_mvp]` |
| 企業を探す | `/companies/` | `[fic_company_hub]` |
| テーマから探す | `/themes/` | `[fic_theme_hub]` |
| 投資の読み方 | `/learn/` | `[fic_learning_hub]` |

配布パッケージを使う場合は、`wordpress/deploy/top-page-mvp/fixed-page-bodies/` に各固定ページへ貼る本文だけを入れたテキストファイルがある。

## Code Snippets

### 1. トップページMVP

推奨スニペット名:

```text
FIC: Home page MVP shortcode
```

貼り付けるファイル:

```text
wordpress/snippets/fic-home-page-mvp.php
```

配布パッケージを使う場合は、Code Snippets へ貼りやすい `<?php` なし版を使う。

```text
wordpress/deploy/top-page-mvp/code-snippets-paste/fic-home-page-mvp-no-open-tag.php
```

登録されるショートコード:

```text
[fic_home_mvp]
```

### 2. 固定ページハブ

推奨スニペット名:

```text
FIC: Purpose hub shortcodes
```

貼り付けるファイル:

```text
wordpress/snippets/fic-hub-pages.php
```

配布パッケージを使う場合は、Code Snippets へ貼りやすい `<?php` なし版を使う。

```text
wordpress/deploy/top-page-mvp/code-snippets-paste/fic-hub-pages-no-open-tag.php
```

登録されるショートコード:

```text
[fic_company_hub]
[fic_theme_hub]
[fic_learning_hub]
```

### 3. 記事内導線

推奨スニペット名:

```text
FIC: Category bridge internal links
```

配布パッケージを使う場合:

```text
wordpress/deploy/top-page-mvp/code-snippets-paste/fic-category-bridge-links-no-open-tag.php
```

### 4. 計測イベント

推奨スニペット名:

```text
FIC: Navigation measurement events
```

配布パッケージを使う場合:

```text
wordpress/deploy/top-page-mvp/code-snippets-paste/fic-navigation-measurement-no-open-tag.php
```

### 5. 決算予定ページガイド

推奨スニペット名:

```text
FIC: Earnings schedule page guide
```

配布パッケージを使う場合:

```text
wordpress/deploy/top-page-mvp/code-snippets-paste/fic-earnings-page-guide-no-open-tag.php
```

## 追加CSS

貼り付けるファイル:

```text
wordpress/css/fic-home-page-mvp.css
```

このCSSにはトップページMVPと3つの固定ページハブの見た目が含まれる。

## 画像

ヘッダー用ロゴ画像:

```text
wordpress/assets/fic-logo-header-dark-transparent.png
wordpress/assets/fic-logo-header-white-transparent.png
```

白背景のヘッダーでは `fic-logo-header-dark-transparent.png` を使う。
`fic-logo-header-white-transparent.png` は黒背景でロゴを出す必要がある場合の予備。
Diver側のヘッダー画像を直接差し替えられない場合は、追加CSS側で既存ヘッダー画像URLを濃紺ロゴへ置換する。
トップヒーロー内には重複ロゴを表示しない。

## 推奨公開順

1. Code Snippets に `FIC: Home page MVP shortcode` を作成し、保存だけする。
2. Code Snippets に `FIC: Purpose hub shortcodes` を作成し、保存だけする。
3. Code Snippets に `FIC: Category bridge internal links` を作成し、保存だけする。
4. Code Snippets に `FIC: Navigation measurement events` を作成し、保存だけする。
5. Code Snippets に `FIC: Earnings schedule page guide` を作成し、保存だけする。
6. 追加CSSに `fic-home-page-mvp.css` を貼る。
7. ロゴ画像を配置する。
8. 3つの固定ページを下書きで作る。
9. 各固定ページにショートコードを1つだけ貼る。
10. 下書きプレビューで、企業・テーマ・学習ハブが表示されるか確認する。
11. 3つの固定ページを公開する。
12. トップページ上部に `[fic_home_mvp]` を追加する。
13. トップページをプレビューし、問題なければ更新する。
14. WordPressメニューを目的別の名前に変更する。

推奨メニュー名:

- 企業を探す
- テーマから探す
- 投資の読み方
- 決算予定

配布パッケージを使う場合は、`wordpress/deploy/top-page-mvp/fixed-page-bodies/recommended-menu.md` でリンク先を確認できる。

## 公開直後に残すもの

すぐ残す:

- 既存の決算スケジュールページ
- 既存の企業分析カテゴリ
- 既存のテーマ分析カテゴリ
- YouTube導線
- About / 編集方針

すぐ消さない:

- 既存トップページ下部の記事一覧
- 既存サイドバー
- 既存カテゴリ一覧

理由:

公開直後は、検索流入・内部リンク・読者の慣れを壊さないことを優先する。
新トップと固定ページハブが安定してから、重複して見える導線を段階的に下げる。

## 公開後に下げる候補

表示確認と数日間の様子見後に検討:

- トップページ上の重複したカテゴリリンク
- 意味が近い記事一覧ブロック
- 主ナビの `企業分析` / `テーマ分析`
- サイドバーの長すぎるカテゴリ一覧

置き換え先:

- `企業分析` は `/companies/` へ
- `テーマ分析` は `/themes/` へ
- 初心者向け説明は `/learn/` へ

## 公開確認チェック

ローカル側で先に確認:

```powershell
powershell -ExecutionPolicy Bypass -File scripts\verify_top_page_mvp.ps1
powershell -ExecutionPolicy Bypass -File scripts\start_top_page_preview.ps1 -Restart
powershell -ExecutionPolicy Bypass -File scripts\build_top_page_deploy_package.ps1
```

- ヘッダーのロゴが白背景で濃紺に見える。
- トップヒーロー内に重複ロゴが出ていない。
- `企業を探す` が `/companies/` に移動する。
- `テーマから探す` が `/themes/` に移動する。
- `投資の読み方` が `/learn/` に移動する。
- 3ハブの上部に `トップページへ` が表示される。
- 3ハブの共通ナビに `現在地` が表示される。
- 検索フォームの送信先がサイト内検索になっている。
- 最新記事がないカテゴリでも準備中表示になる。
- スマホでボタン・カード・検索フォームがはみ出さない。
- YouTubeリンクが別タブで開く。

## 問題が出たとき

トップだけ崩れた場合:

1. トップページ本文から `[fic_home_mvp]` を外す。
2. トップページを更新する。

ハブだけ崩れた場合:

1. 3つの固定ページを下書きに戻す。
2. メニューから該当ページを外す。

全体で崩れた場合:

1. 追加CSSから `fic-home` 関連CSSを外す。
2. Code Snippets のトップ/ハブ用スニペットを無効化する。
3. 固定ページ本文のショートコードを外す。

部分的に戻す場合:

- 記事内導線だけ戻す: `FIC: Category bridge internal links` を無効化する。
- 計測だけ戻す: `FIC: Navigation measurement events` を無効化する。
- 決算予定ページ上部ガイドだけ戻す: `FIC: Earnings schedule page guide` を無効化する。

## 次に改善する順番

公開後の次作業は、次の順番がよい。

1. トップページ下部の旧記事一覧を整理する。
2. `/learn/` に投資の読み方記事を増やす。
3. 人気記事を「読者の疑問別」に並べ替える。
4. Search Console と GA4 で、トップから4入口への遷移を見る。
5. クリックが弱い入口の文言や位置を調整する。

旧トップ本文、カテゴリ導線、サイドバーを下げる具体的な順番は `docs/top_page_legacy_cleanup_plan.md` を参照する。
公開後に増やす記事とハブ改善の優先順位は `docs/top_page_content_growth_plan.md` を参照する。
フェーズ1記事23本のWordPress投入順、公開URL控え、内部リンク方針は `docs/phase1_wordpress_publish_checklist.md` を参照する。
本文HTML、アイキャッチ、CSVをまとめて使う場合は `scripts/build_phase1_article_package.ps1` で `wordpress/deploy/phase1-articles/` を生成する。
