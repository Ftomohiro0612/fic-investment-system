# トップページ改修 WordPress作業ランブック

作成日: 2026-05-22

## 目的

WordPress管理画面で、トップページMVPと3つの固定ページハブを反映する当日の作業手順。

この資料だけを上から順に見れば、貼るファイル、作る固定ページ、確認するURL、戻し方が分かる状態にする。

## 使う配布パッケージ

```text
wordpress/deploy/top-page-mvp/
```

主に使うファイル:

| 用途 | ファイル |
| --- | --- |
| トップ用Code Snippets | `code-snippets-paste/fic-home-page-mvp-no-open-tag.php` |
| 3ハブ用Code Snippets | `code-snippets-paste/fic-hub-pages-no-open-tag.php` |
| 記事内導線Code Snippets | `code-snippets-paste/fic-category-bridge-links-no-open-tag.php` |
| 計測Code Snippets | `code-snippets-paste/fic-navigation-measurement-no-open-tag.php` |
| 決算予定ページガイドCode Snippets | `code-snippets-paste/fic-earnings-page-guide-no-open-tag.php` |
| 追加CSS | `css/fic-home-page-mvp.css` |
| ヘッダー用ロゴ | `assets/fic-logo-header-dark-transparent.png` |
| 予備ロゴ | `assets/fic-logo-header-white-transparent.png` |
| 固定ページ本文 | `fixed-page-bodies/*.txt` |
| メニュー案 | `fixed-page-bodies/recommended-menu.md` |

## 0. 作業前チェック

ローカルで先に実行する。

```powershell
powershell -ExecutionPolicy Bypass -File scripts\verify_top_page_mvp.ps1
powershell -ExecutionPolicy Bypass -File scripts\build_top_page_deploy_package.ps1
```

確認すること:

- `[OK] Required files exist` が出る。
- `[OK] PHP snippet brace counts match` が出る。
- `[OK] Standalone CSS is synced with custom.css` が出る。
- `[OK] Required content markers exist` が出る。
- `php command not found` は、このPCにPHP CLIがない場合は許容する。

## 1. ヘッダー用ロゴ画像を配置

WordPress管理画面で、以下のどちらかを選ぶ。

推奨:

- 子テーマの `assets/` に `fic-logo-header-dark-transparent.png` を配置する。
- 白背景のヘッダーでは濃紺ロゴを使う。

代替:

- メディアライブラリへ `fic-logo-header-dark-transparent.png` をアップロードする。
- Diver側のヘッダー画像を直接差し替えられない場合は、管理CSSで既存ヘッダー画像URLを濃紺ロゴへ置換する。
- `fic-logo-header-white-transparent.png` は、黒背景でロゴを出す必要がある場合の予備として残す。

確認:

- 白背景のヘッダー上で濃紺ロゴとして見える。
- トップヒーロー内の小さい重複ロゴは表示されない。
- 白い四角い背景が残っていない。

## 2. Code Snippetsを追加

### トップページMVP

WordPress管理画面:

```text
Code Snippets > Add New
```

スニペット名:

```text
FIC: Home page MVP shortcode
```

貼るファイル:

```text
wordpress/deploy/top-page-mvp/code-snippets-paste/fic-home-page-mvp-no-open-tag.php
```

設定:

- 実行範囲はフロントエンドのみ、またはサイト全体。
- まず保存する。
- エラーが出なければ有効化する。

登録されるショートコード:

```text
[fic_home_mvp]
```

### 3ハブ

スニペット名:

```text
FIC: Purpose hub shortcodes
```

貼るファイル:

```text
wordpress/deploy/top-page-mvp/code-snippets-paste/fic-hub-pages-no-open-tag.php
```

登録されるショートコード:

```text
[fic_company_hub]
[fic_theme_hub]
[fic_learning_hub]
```

### 記事内導線

スニペット名:

```text
FIC: Category bridge internal links
```

貼るファイル:

```text
wordpress/deploy/top-page-mvp/code-snippets-paste/fic-category-bridge-links-no-open-tag.php
```

役割:

- 企業分析記事に `投資の読み方` への補助線と記事内導線を出す。
- テーマ/業界分析記事に `テーマの読み方` への補助線と記事内導線を出す。

### 計測イベント

スニペット名:

```text
FIC: Navigation measurement events
```

貼るファイル:

```text
wordpress/deploy/top-page-mvp/code-snippets-paste/fic-navigation-measurement-no-open-tag.php
```

役割:

- `fic_navigation_click`
- `fic_search_submit`

を `gtag`、`dataLayer`、`fic:measurement` に送る。

### 決算予定ページガイド

スニペット名:

```text
FIC: Earnings schedule page guide
```

貼るファイル:

```text
wordpress/deploy/top-page-mvp/code-snippets-paste/fic-earnings-page-guide-no-open-tag.php
```

役割:

- `/earnings-schedule/` 上部に、企業分析・投資の読み方への導線を出す。

## 3. 追加CSSを反映

WordPress管理画面:

```text
外観 > カスタマイズ > 追加CSS
```

または、テーマ側のCSS編集欄に貼る。

貼るファイル:

```text
wordpress/deploy/top-page-mvp/css/fic-home-page-mvp.css
```

確認:

- `.fic-home` から始まるCSSが入っている。
- 既存CSSを上書き削除しない。

## 4. 固定ページを作成

WordPress管理画面:

```text
固定ページ > 新規追加
```

作るページ:

| 固定ページ名 | スラッグ | 本文ファイル |
| --- | --- | --- |
| 企業を探す | `companies` | `fixed-page-bodies/companies.txt` |
| テーマから探す | `themes` | `fixed-page-bodies/themes.txt` |
| 投資の読み方 | `learn` | `fixed-page-bodies/learn.txt` |

本文はショートコード1行だけにする。

公開順:

1. まず下書き保存。
2. プレビューで表示確認。
3. 問題なければ公開。

確認URL:

```text
/companies/
/themes/
/learn/
```

確認すること:

- 各ページの上部に `トップページへ` がある。
- 3ハブ共通ナビが表示される。
- 現在のページに `現在地` が表示される。
- 検索フォームがある。
- 記事がない場合もレイアウトが崩れない。

## 5. トップページにショートコードを入れる

既存トップページを編集する。

追加する本文:

```text
[fic_home_mvp]
```

推奨:

- 既存本文をいきなり消さない。
- まず既存本文の上に `[fic_home_mvp]` を追加する。
- 表示確認後、重複する旧導線を下げるか削る。

確認すること:

- ファーストビューに黒黄グラデーションのヒーローが出る。
- ヘッダーのロゴが白背景で濃紺に見える。
- トップヒーロー内に重複ロゴが出ていない。
- 4入口が見える。
- 検索フォームが使える。
- 最新記事、決算予定、編集方針導線が崩れていない。

## 6. メニューを更新

WordPress管理画面:

```text
外観 > メニュー
```

推奨メニュー:

| 表示名 | リンク |
| --- | --- |
| 企業を探す | `/companies/` |
| テーマから探す | `/themes/` |
| 投資の読み方 | `/learn/` |
| 決算予定 | `/earnings-schedule/` |

残す候補:

- YouTube
- About
- 編集方針

下げる候補:

- 企業分析
- 業界分析

理由:

カテゴリ名よりも、読者の目的で入口を見せる。

## 7. 公開直後の確認

PCで確認:

- トップページのヒーローが崩れていない。
- 4入口のリンク先が正しい。
- 3ハブに移動できる。
- 3ハブからトップへ戻れる。
- 決算予定へ移動できる。
- トップ/ハブ/決算予定の主要リンクに `data-fic-area` が付いている。
- 企業分析・業界分析記事に記事内導線が1回だけ出る。

スマホで確認:

- 横スクロールが出ない。
- 検索フォームのボタンがはみ出さない。
- 4入口ボタンが1列で読める。
- 最新記事カードのタイトルがはみ出さない。

検索・外部リンク:

- トップ検索で検索結果ページへ移動する。
- ハブ検索で検索結果ページへ移動する。
- YouTubeが別タブで開く。

## 8. 公開後1週間で見ること

詳しくは `docs/top_page_measurement_plan.md` を参照する。

最初に見るもの:

- トップページから4入口へのクリック
- `企業を探す` から企業分析記事への遷移
- `テーマから探す` からテーマ分析記事への遷移
- `投資の読み方` から企業・テーマ記事への遷移
- 検索フォームと検索チップの利用
- YouTube導線のクリック

## 9. 戻し方

トップだけ戻す:

1. トップページ本文から `[fic_home_mvp]` を外す。
2. トップページを更新する。

ハブだけ戻す:

1. `/companies/`、`/themes/`、`/learn/` を下書きに戻す。
2. メニューから3ハブへのリンクを外す。

全部戻す:

1. トップページ本文から `[fic_home_mvp]` を外す。
2. 3ハブ固定ページを下書きに戻す。
3. Code Snippetsの `FIC: Home page MVP shortcode` を無効化する。
4. Code Snippetsの `FIC: Purpose hub shortcodes` を無効化する。
5. Code Snippetsの `FIC: Category bridge internal links` を無効化する。
6. Code Snippetsの `FIC: Navigation measurement events` を無効化する。
7. Code Snippetsの `FIC: Earnings schedule page guide` を無効化する。
8. 追加CSSから `.fic-home` 関連CSSを外す。

部分的に戻す:

- 記事内導線だけ戻す場合は `FIC: Category bridge internal links` を無効化する。
- 計測だけ戻す場合は `FIC: Navigation measurement events` を無効化する。
- 決算予定ページ上部ガイドだけ戻す場合は `FIC: Earnings schedule page guide` を無効化する。

## 10. 公開後の次作業

1. トップページ下部の旧記事一覧を整理する。
2. サイドバーの長いカテゴリ一覧を整理する。
3. `投資の読み方` に基礎記事を増やす。
4. 人気記事を読者の疑問別に並べ替える。
5. クリック計測を見て、4入口の文言や順番を調整する。

旧導線を下げる順番は `docs/top_page_legacy_cleanup_plan.md` を基準にする。
次に増やす記事とハブ改善の優先順位は `docs/top_page_content_growth_plan.md` を基準にする。
