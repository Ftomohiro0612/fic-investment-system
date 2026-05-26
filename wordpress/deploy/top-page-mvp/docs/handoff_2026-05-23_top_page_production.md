# 引継ぎメモ: トップページ本番投入

作成日: 2026-05-23

## 目的

FIC投資研究所サイトを、ローカルで作成した黒・黄色ベースのトップページMVPと3つの固定ページハブへ本番反映した。

本番トップ、固定ページハブ、決算予定ページのDiverテーマ干渉は抑制済み。次チャットでは、記事群の内部リンク追加やクリック計測の確認など、運用フェーズの磨き込みから再開する。

## 本番接続情報

WordPress REST API用の認証情報は以下にある。

```text
C:\Users\tomo-\.codex\.sandbox-secrets\fic-wp.json
```

中身は表示しないこと。読み込むキーは以下。

- `siteUrl`
- `username`
- `applicationPassword`

REST API疎通確認済み。

```text
site: https://fic-investment.biz
user: FIC投資研究所
```

## Google Analytics / Search Console

2026-05-24確認。

- 公開HTML上に GA4 `G-8VFXTYHBV5`、旧UA、Search Console verification meta は存在する。
- `google-oauth-token.json` は `invalid_grant` でrefresh不可。再認証が必要。
- サービスアカウントはトークン発行に成功するが、Search Console/GA4側の権限不足。
- サービスアカウントの追加先プリンシパルは `work/google-service-account-principal.txt` に保存済み。
- Search Console UI で上記プリンシパルを追加すると「メールアドレスが見つかりませんでした」になる場合がある。その場合はサービスアカウント追加を粘らず、所有者GoogleアカウントでOAuth再認証する。
- OAuth再認証は成功済み。Search Console は `https://fic-investment.biz/` を取得可能。GA4 は `GA4_PROPERTY_ID=367975716` を指定すれば Data API で取得可能。
- 初回取得済み: `work/ga-gsc-fic-report.json`、`work/ga-gsc-first-readout.md`、各CSV。
- 手順書: `docs/google_ga_gsc_access.md`
- OAuth再認証: `node scripts\reauthorize_google_oauth.mjs`
- 疎通確認: `node scripts\check_google_ga_gsc_access.mjs`
- 権限付与後のレポート取得: `node scripts\fetch_ga_gsc_fic_report.mjs`
- 取得後の初回サマリー生成: `node scripts\analyze_ga_gsc_fic_report.mjs`
- GA4権限がなくても、計測属性の出力状況は `node scripts\audit_fic_measurement_coverage.mjs` で確認可能。最新出力は `work/fic-measurement-coverage.md`。

## すでに本番反映済み

### Code Snippets

以下6本を作成・有効化済み。

| ID | 名前 | 状態 |
| --- | --- | --- |
| 27 | FIC: Home page MVP shortcode | active |
| 28 | FIC: Purpose hub shortcodes | active |
| 29 | FIC: Home page logo and CSS | active |
| 30 | FIC: Category bridge internal links | active |
| 31 | FIC: Navigation measurement events | active |
| 32 | FIC: Earnings schedule page guide | active |

スニペット27/28はショートコード本体。
スニペット29は白ロゴURL差し替えとCSS注入。
スニペット30は記事本文冒頭の読み方補助線と、記事本文末尾付近のカテゴリ別内部導線。
スニペット31はトップ/ハブ内のクリックと検索送信イベント計測。
スニペット32は決算予定ページ上部の読み方ガイドと関連導線。

2026-05-23追記:

- Code Snippets ID 27/28 のカテゴリ件数カウントは、複数カテゴリを合算するときに同じ投稿を二重カウントしない `WP_Query` ベースへ更新済み。
- 旧 `業界分析` と新 `テーマ分析` の両方が付いた23本は、トップ/ハブ上では `テーマ分析 23` として数える。
- `/themes/` のテーマ記事数は、テーマ分析23本 + テーマの読み方11本 = 34本として表示される。

### ロゴ

アップロード済み。

```text
media id: 12635
url: https://fic-investment.biz/wp-content/uploads/2026/05/fic-logo-header-white-transparent-1.png
```

ヘッダー用の濃紺ロゴもアップロード済み。

```text
media id: 12712
url: https://fic-investment.biz/wp-content/uploads/2026/05/fic-logo-header-dark-transparent.png
```

### 固定ページ

作成・公開済み。

| ページ | URL | ショートコード |
| --- | --- | --- |
| FIC投資研究所 | https://fic-investment.biz/home/ | `[fic_home_mvp]` |
| 企業を探す | https://fic-investment.biz/companies/ | `[fic_company_hub]` |
| テーマから探す | https://fic-investment.biz/themes/ | `[fic_theme_hub]` |
| 投資の読み方 | https://fic-investment.biz/learn/ | `[fic_learning_hub]` |
| 決算予定 | https://fic-investment.biz/earnings-schedule/ | `[earnings_schedule_table]` |

WordPress設定も変更済み。

```text
show_on_front: page
page_on_front: 12636
```

つまり `https://fic-investment.biz/` は固定ページ `FIC投資研究所` を表示する状態。

### ヘッダーメニュー

ヘッダーメニュー `menu id: 40` は更新済み。

| 表示名 | URL | order |
| --- | --- | --- |
| 企業を探す | `/companies/` | 1 |
| テーマから探す | `/themes/` | 2 |
| 投資の読み方 | `/learn/` | 3 |
| 決算予定 | `/earnings-schedule/` | 4 |
| YouTube | `https://www.youtube.com/@FICInvestmentBiz` | 5 |

旧メニューの `企業分析` / `業界分析` はヘッダーから削除済み。

### フェーズ1記事

23本を本番投稿として公開済み。

- `投資の読み方`: 12本
- `テーマの読み方`: 11本

カテゴリも作成済み。

- `投資の読み方`
- `テーマの読み方`
- `テーマ分析`

旧 `業界分析` 23本には、新カテゴリ `テーマ分析` も追加済み。旧カテゴリは外していないため、既存カテゴリURLや旧導線は維持される。

公開結果CSVを出力済み。

```text
wordpress/deploy/phase1-articles/metadata/phase1-article-published-result.csv
```

投入時に全23本の進捗ログが出ている。

## ローカル側の主なファイル

トップページ/ハブ:

```text
wordpress/snippets/fic-home-page-mvp.php
wordpress/snippets/fic-hub-pages.php
wordpress/snippets/fic-category-bridge-links.php
wordpress/snippets/fic-navigation-measurement.php
wordpress/snippets/fic-earnings-page-guide.php
wordpress/css/fic-home-page-mvp.css
wordpress/css/custom.css
wordpress/deploy/top-page-mvp/
```

フェーズ1記事:

```text
wordpress/deploy/phase1-articles/
wordpress/deploy/phase1-articles/metadata/phase1-article-upload.csv
wordpress/deploy/phase1-articles/metadata/phase1-article-publish-tracker.csv
wordpress/deploy/phase1-articles/metadata/phase1-article-published-result.csv
```

検証/生成:

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File scripts\build_phase1_article_package.ps1
powershell -NoProfile -ExecutionPolicy Bypass -File scripts\verify_phase1_article_package.ps1
powershell -NoProfile -ExecutionPolicy Bypass -File scripts\build_top_page_deploy_package.ps1
```

## 現在の問題

当初の問題だった、本番トップページがローカルプレビューとずれている件は修正済み。

修正済みの主なズレ:

- Diverテーマの上部エリア/旧ピックアップ/旧トップ要素が残っている。
- 固定ページタイトル `FIC投資研究所` が表示されている。
- 右サイドバーが残っている。
- ローカルの全幅トップページMVPではなく、テーマのページ本文エリア内にMVPが入っている見え方になっている。

### 実施済みの修正

`wordpress/css/custom.css` と `wordpress/css/fic-home-page-mvp.css` にトップページ/ハブ/決算予定ページ専用補正CSSを追加し、Code Snippets ID 29へ反映済み。

主な対象:

```css
body.home.page-id-12636
body:is(.page-id-12638, .page-id-12639, .page-id-12640)
body.page-id-10631
```

非表示にしようとしている要素:

```css
.diver_firstview_image
.container_top_widget
#page-main > .wrap-post-title
#pickup_posts_container
.maintop-widget
.mainbottom-widget
#sidebar
```

公開HTML上には旧要素が存在するが、CSSでトップ/ハブ/決算予定だけ非表示にする方針。

## 追加で本番反映済み

- トップページ検索チップは、半導体・金利・為替・決算を代表読み方記事へ直接リンク。AIのみ検索結果へリンク。
- `/companies/`, `/themes/`, `/learn/` に代表記事カードを6件ずつ追加済み。
  - 企業ハブ: `company_hub_featured` 6件。ニトリ、三菱UFJ、キオクシア、ENEOS、ホンダ、リクルート。
  - テーマハブ: `theme_hub_featured` 6件。金利、為替、原材料、半導体、政策、エネルギー。
  - 投資の読み方ハブ: `learning_hub_featured` 6件。決算短信、営業利益率、受注残・在庫、ROE/ROIC、セグメント、キャッシュフロー。
- `/themes/` ハブにフェーズ1のテーマの読み方11本がすべて出るよう、Code Snippets ID 28を更新。
- 企業ハブ `/companies/` の最新企業分析を6件から12件へ拡張。
- 企業ハブ検索フォーム下にクイック検索チップを追加。
  - キオクシア → `kioxia-holdings-285a-analysis`
  - ニトリ → `nitori-9843-analysis`
  - 三菱UFJ → `mitsubishi-ufj-8306-analysis`
  - みずほ → `mizuho-fg-8411-analysis`
  - リクルート → `recruit-holdings-6098-analysis`
  - ENEOS → `eneos-holdings-5020-analysis`
  - 6件とも検索結果ではなく公開済み代表記事へ直接遷移。
- 企業分析記事には `投資の読み方` への内部導線を自動挿入。
- テーマ分析/業界分析/業種別分析記事には `テーマの読み方` への内部導線を自動挿入。
- 企業分析/業界分析記事の冒頭に「この分析を読む補助線」を自動挿入。既に本文へ手動挿入済みの記事では重複しない。
- 記事ページ下部に `fic-category-related` を自動挿入済み。
  - 企業分析: 同じ企業分析3件 + 企業ハブ/カテゴリ一覧。
  - テーマ分析: 同じテーマ分析3件 + テーマハブ/カテゴリ一覧。
  - テーマの読み方: ほかのテーマの読み方3件 + テーマハブ/カテゴリ一覧。
  - 投資の読み方: ほかの投資の読み方3件 + 投資の読み方ハブ/カテゴリ一覧。
  - サイドバー非表示のまま、記事末尾でカテゴリ回遊できる方針。
  - 計測属性も付与済み: `article_context_link`, `article_bridge_hub`, `article_bridge_card`, `article_related_card`, `article_related_archive`, `article_related_hub`。
- 記事ページ本文幅は Code Snippets ID 29 で調整済み。
  - `body.single-post #main-wrap`: 1040px相当から960px相当へ。
  - 段落、リスト、見出し、引用、読み方ブリッジは最大800px。
  - 記事下部のカテゴリ内回遊ブロックは最大860px。
- 主要カテゴリページには、ヒーローと記事一覧の間へ `fic-category-archive-guide` を挿入済み。
  - 対象: テーマ分析、テーマの読み方、投資の読み方、企業分析カテゴリ。
  - ハブや隣接カテゴリへ戻る案内を表示。
  - 計測属性: `category_archive_guide`。
- 企業分析4本には本文内リンクを手動挿入済み。
  - `mercari-4385-analysis`
  - `sumitomo-metal-mining-5713-analysis`
  - `jfe-holdings-5411-analysis`
  - `kawasaki-heavy-industries-7012-analysis`
- 追加で企業分析6本にも、本文冒頭付近へ文脈別の「この分析を読む補助線」を手動挿入済み。
  - `nitori-9843-analysis`
  - `mizuho-fg-8411-analysis`
  - `eneos-holdings-5020-analysis`
  - `honda-7267-analysis`
  - `screen-holdings-7735-analysis`
  - `daikin-6367-analysis`
- テーマ分析/業界分析6本にも、本文冒頭付近へ文脈別の「この分析を読む補助線」を手動挿入済み。
  - `construction-material-shortage-project-delay-margin-risk`
  - `naphtha-packaging-cost-food-consumer-goods`
  - `sony-tsmc-physical-ai-sensor-investment`
  - `ai-battery-power-infrastructure-softbank-sakai`
  - `japan-semiconductor-advanced-node-sony-tsmc-jv-impact-2026`
  - `middle-east-lng-supply-risk-japan-shipping-trading-companies-impact`
- `[data-fic-area]` 付きリンククリックを `fic_navigation_click` として `gtag` / `dataLayer` / `fic:measurement` へ送信。
- `.fic-home-search` / `.fic-hub-search` の検索送信を `fic_search_submit` として計測。
- 2026-05-24更新: 両イベントに `fic_page_type` と `fic_page_path` を追加済み。トップ、ハブ、カテゴリ、記事、検索、決算予定の面別にGA4で分解できる。
- 本番ページ上で `fic_navigation_click` と `fic_search_submit` が `dataLayer` と `fic:measurement` に入ることを確認済み。
- 決算予定ページ上部に「決算予定から、次に読む企業分析へ進む」ガイドを追加。企業ハブ、投資の読み方、進捗率、営業利益率、受注残/在庫への導線を設置。
- テーマハブ検索フォーム下に、テーマの読み方記事へ直接移動するクイックリンクを追加。
  - 金利
  - 為替
  - 原材料
  - 半導体
  - 政策・補助金
  - 物流改革
  - インバウンド
- 投資の読み方ハブ検索フォーム下に、主要な読み方記事へ直接移動するクイックリンクを追加。
  - 決算短信
  - 営業利益率
  - 受注残・在庫
  - 進捗率
  - キャッシュフロー
  - ROE・ROIC
  - 財務安全性
- テーマハブを整理し、材料別カードを検索結果ではなく代表的なテーマの読み方記事へ直接リンクする構成へ更新済み。
  - 金利
  - 為替
  - 原材料
  - 半導体
  - 政策・補助金
  - エネルギー
  - 物流改革
  - 消費・インバウンド
- テーマハブに `Theme Routes` セクションを追加済み。固定ページを増やす前の軽い小ハブとして、関連テーマを4グループに束ねている。
  - 金利・為替
  - 原材料・エネルギー・物流
  - 半導体・政策・防衛
  - 消費・人手不足・インバウンド
- 決算予定ページ上部ガイドを拡張し、決算短信の読み方、企業名/証券コード検索、代表企業分析への直接リンクを追加済み。
  - ニトリ
  - みずほFG
  - ENEOS
  - ホンダ
  - SCREEN
  - ダイキン
- 決算予定ページに `Earnings Routes` セクションを追加済み。決算前、発表直後、発表後の深掘りで見る読み方記事を切り替えられる。
  - 決算前に予習する
  - 発表直後に見る
  - 発表後に深掘りする
- 決算予定ページに `Theme Lens` セクションを追加済み。決算数字だけでは判断しにくいときに、外部環境テーマへ戻れる。
  - 金利
  - 為替
  - 原材料
  - 半導体
  - エネルギー
  - 物流
- 企業ハブに `Company Routes` セクションを追加済み。企業名が決まっていない読者が、業種・材料別に代表企業分析へ進める。
  - 銀行・金融
  - 資源・エネルギー・素材
  - 小売・消費・人材
  - 半導体・製造装置・設備投資
  - 自動車・重工
- 投資の読み方ハブに `Learning Routes` セクションを追加済み。決算前、発表直後、深掘り、リスク/還元の場面別に基礎記事へ進める。
  - 決算前に予習する
  - 発表直後に確認する
  - 発表後に深掘りする
  - リスクと還元を見る
- トップページに `Purpose Routes` セクションを追加済み。4つのハブに目的別ルートがあることを、トップ上で先に見せる。
  - Company Routes
  - Theme Routes
  - Learning Routes
  - Earnings Routes
- トップページの `Market Triggers` を代表テーマ解説への直接リンクに更新済み。検索結果ページを挟まず、材料別の読み方へ進める。
  - 金利
  - 為替
  - 原材料
  - AI・半導体
  - 政策・補助金
  - エネルギー
- トップページの検索チップも全件直リンク化済み。AI検索チップは外し、公開済みの代表解説へ進めるチップに整理。
  - 半導体
  - 金利
  - 為替
  - 決算
  - 政策
  - エネルギー
- トップページのクイックナビに `目的別ルート` を追加済み。`Purpose Routes` セクションへ直接ジャンプできる。
- ヘッダー用ロゴを白背景に合う濃紺版へ差し替え済み。管理CSSで既存ヘッダー画像を `fic-logo-header-dark-transparent.png` に置換する。
- ヒーロー内の小さいロゴは削除済み。ヒーロー冒頭は黄色ラベルから始まり、上部余白も少し詰めている。
- ヘッダー下の広い余白は、ハブ/決算予定ページの空 `container_top_widget` 非表示とページシェル上余白の圧縮で調整済み。
- 決算スケジュール表は黒黄FICトーンへ寄せる上書きCSSを Code Snippets ID 15 に追加済み。緑/紫の強いステータスバッジは黒黄/グレー系に変更。
- トップ/ハブの検索フォームは、スマホ幅で入力欄が潰れないよう `input` 最小高さ52px、上下paddingありへ調整済み。
- ヘッダーメニュー文字色は Diver 側の薄い青を拾わないよう、管理CSSで FIC濃紺 `#102a43` に固定済み。
- 決算予定固定ページ本文は `[earnings_schedule_table]` のみに整理済み。旧固定記事由来の「本ページの見方」「更新方針について」などは削除し、バックアップは `work/earnings-schedule-page-backup-2026-05-23.json` に保存。
- 決算予定ページの旧ページタイトルは管理CSSで非表示。決算ガイド内の見出しは、記事本文用の黄色 `h2` 背景が混ざらないよう背景/余白/枠線をリセット済み。
- 主要カテゴリ一覧ページも管理CSSでハブ風に整理済み。対象は `企業分析`、`テーマ分析`、`テーマの読み方`、`投資の読み方`。サイドバーなし、黒黄ヒーロー、カード型記事グリッドに変更。
- スマホの3本線メニューは、旧カテゴリ件数一覧を先頭に見せず、目的別メニューを先頭に差し込む形へ変更済み。`企業を探す`、`テーマから探す`、`投資の読み方`、`決算予定`、`YouTube` と主要4カテゴリへの導線を出す。
- トップページ下部の動画ブロックは、記事本文用の黄色 `h2` 背景が混ざらないよう見出し背景/余白/枠線をリセット済み。
- トップページの直近決算予定が空のときは、「現在、表示できる決算予定はありません。」だけで止めず、企業分析と決算短信の読み方へ進める空状態に変更済み。
- 検索結果ページも管理CSSでハブ風に整理済み。`body.search` を対象にサイドバーなし、黒黄検索ヒーロー、再検索フォーム、目的別ハブ導線、カード型結果グリッドへ変更。
- 記事ページも管理CSSでFICの外枠へ寄せた。`body.single-post` を対象に、旧カテゴリ帯、ピックアップスライダー、サイドバー、共有ボタンを非表示化し、記事タイトルを黒黄ヒーロー、本文を読みやすい1カラムカードへ変更。
- テーマハブの `Theme Routes` 内にある丸ボタンは、白いカード上で白文字にならないよう Code Snippets ID 29 のCSSで濃色文字へ補正済み。`.fic-hub-card .fic-home-search-chips a` が再発防止の確認ポイント。
- 記事生成プロンプトには、初心者向け解説とH2/H3階層ルールを追加済み。生成後レビューでは `scripts/audit_article_heading_hierarchy.mjs` で、長いH2だけの章が残っていないか確認する。

## 次チャットで最初にやること

1. GA4/GSCの初回レポートを見て、トップ、ハブ、カテゴリ、記事、検索、決算予定の入口別にクリック/検索流入を確認する。
2. クリック状況を見ながら、トップの `Purpose Routes`、企業ハブの `Company Routes` / 検索チップ、投資の読み方ハブの `Learning Routes`、テーマハブ/決算予定ページの代表リンク、`Theme Lens` のテーマを入れ替える。
3. 既存記事の本文中に、個別文脈に合わせた自然な内部リンクを追加していく。
4. 次の公開記事企画を、クリックが多い入口から優先する。
5. 新規の企業分析/テーマ分析を作るときは、初心者向け解説とH2/H3階層監査をレビュー工程に必ず通す。

## 本番CSSスニペット更新の方針

Code Snippets ID 29 は以下を含む。

- `fic_home_logo_url` フィルター
- `wp_head` で `<style id="fic-home-page-mvp-css">...</style>` を出力
- `wp_footer` で `<script id="fic-mobile-purpose-menu-js">...</script>` を出力し、スマホ用の目的別メニューをサイドバー/ドロワー先頭へ挿入

更新する場合は、`wordpress/css/fic-home-page-mvp.css` の内容を読み込み、スマホ用メニューJSも含めて ID 29 の `code` を更新する。
更新後は `scripts/check_post_theme_earnings_regression.mjs` を実行し、ID 29 の本番CSSとローカルCSSが一致し、`readableClusterChips` が `true` であることを確認する。

注意:

- `fic-wp.json` の中身は出さない。
- 既存スニペットを重複作成しない。ID 29を更新する。
- 本番でトップ/ハブ表示に問題が出たら、Code Snippets ID 27/28/29を無効化すれば大部分を戻せる。
- 内部導線だけ戻す場合は、Code Snippets ID 30を無効化する。
- 計測だけ戻す場合は、Code Snippets ID 31を無効化する。
- 決算予定ページ上部ガイドだけ戻す場合は、Code Snippets ID 32を無効化する。

## 確認済みの本番状態

トップ/ハブのHTTP確認では以下はOKだった。

```text
https://fic-investment.biz/          200 / shortcode生文字列なし / fic-homeあり
https://fic-investment.biz/companies/ 200 / shortcode生文字列なし / fic-homeあり
https://fic-investment.biz/themes/    200 / shortcode生文字列なし / fic-homeあり
https://fic-investment.biz/learn/      200 / shortcode生文字列なし / fic-homeあり
```

追加確認:

```text
トップ PC/SP: Diver旧要素・固定ページタイトル・サイドバー非表示、横スクロールなし
ハブ PC/SP: 固定ページタイトル・サイドバー非表示、横スクロールなし
決算予定 PC/SP: サイドバー非表示、表/モバイルリスト表示、横スクロールなし
フェーズ1記事23本: HTTP OK、カテゴリOK、アイキャッチOK、記事末尾導線OK、raw shortcodeなし
テーマハブ: フェーズ1記事23本へのリンク漏れなし
企業ハブ: 検索チップ6件表示、6件すべて代表記事へ直接リンク、最新企業分析12件表示、計測イベントOK、横スクロールなし
トップページ: 検索チップ5件表示、半導体・金利・為替・決算は代表記事へ直接リンク、AIは検索結果へリンク、計測イベントOK、横スクロールなし
企業分析92本/業界分析23本: 冒頭補助線1回、記事末尾ブリッジ1回、生ショートコードなし
決算予定ページガイド: PC/SP表示OK、関連リンク5件、計測イベントOK、横スクロールなし
テーマハブ: 検索チップ7件、テーマの読み方カード11件、最新テーマ分析6件、計測イベントOK、横スクロールなし
投資の読み方ハブ: 検索チップ7件、トピックカード5件、代表記事カード6件、最新記事6件、計測イベントOK、横スクロールなし
主要7ページ回帰チェック: トップ、企業ハブ、テーマハブ、投資の読み方ハブ、決算予定、代表企業分析、代表業界分析をPC/SPで確認。14/14 OK
最終回帰チェック: トップ直リンク化とデプロイパッケージ更新後に同じ主要7ページをPC/SPで再確認。14/14 OK
本番/ローカル一致確認: Code Snippets ID 27/28/30/31/32 はローカル管理ファイルと一致。ID 29 はロゴURL、CSS注入、トップ/ハブ/決算予定ページ補正を含むことを確認。
カテゴリ移行後の回帰チェック: トップ、3ハブ、決算予定、テーマ分析カテゴリ、代表企業分析、代表テーマ分析の8ルートを確認。すべてHTTP 200、生ショートコードなし。テーマハブは34本、代表記事2本は補助線1回・ブリッジあり。
カテゴリ件数修正後の本番/ローカル一致確認: Code Snippets ID 27/28/30/31/32 はローカル管理ファイルと一致。
テーマハブ/決算予定ページ改善後の確認: テーマハブは8テーマが代表記事へ直リンク、エネルギーチップあり。決算予定ページは企業検索、決算短信の読み方、代表企業分析6件へのリンク、計測属性を確認。生ショートコードなし。
テーマハブ小ハブ化後の確認: `Theme Routes` 4グループ、`theme_hub_cluster` 計測リンク11件、テーマ記事34本表示、生ショートコードなし。
決算予定ページのルート化後の確認: `Earnings Routes` 3ルート、`earnings_guide_route` 計測リンク7件、企業検索、代表企業分析6件、生ショートコードなし。
計測ドキュメント更新: `theme_hub_cluster`、`earnings_guide_route`、`earnings_guide_company`、`earnings_guide_search` を `docs/navigation_measurement_events.md` と `docs/top_page_measurement_plan.md` に反映済み。
テーマ/決算改善後の総合回帰チェック: 8ルートと Code Snippets ID 27/28/30/31/32 を確認。生ショートコードなし、横スクロールリスクなし、テーマハブ `theme_hub_cluster` 11件、決算予定 `earnings_guide_route` 7件、代表記事2本は補助線1回・ブリッジあり、本番/ローカル一致。
決算予定ページTheme Lens追加後の確認: `Theme Lens` 表示、`earnings_guide_theme` 計測リンク6件、既存 `earnings_guide_route` 7件、企業検索、代表企業分析6件、生ショートコードなし。本番/ローカル一致。
企業ハブCompany Routes追加後の確認: `Company Routes` 5グループ、`company_hub_route` 計測リンク13件、CSS反映、生ショートコードなし、横スクロールリスクなし。本番/ローカル一致。
投資の読み方ハブLearning Routes追加後の確認: `Learning Routes` 4グループ、`learning_hub_route` 計測リンク12件、CSS反映、生ショートコードなし、横スクロールリスクなし。本番/ローカル一致。
トップページPurpose Routes追加後の確認: `Purpose Routes` 4カード、`home_purpose_route` 計測リンク4件、CSS反映、生ショートコードなし、横スクロールリスクなし。本番/ローカル一致。
トップページMarket Triggers直リンク化後の確認: `home_market_trigger` 計測リンク6件、政策・エネルギー追加、検索結果フォールバックなし、生ショートコードなし、横スクロールリスクなし。本番/ローカル一致。
トップページ検索チップ直リンク化後の確認: `home_search_chip` 計測リンク6件、政策・エネルギー追加、検索結果フォールバックなし、生ショートコードなし、横スクロールリスクなし。本番/ローカル一致。
トップページクイックナビ更新後の確認: `home_quicknav` 計測リンク5件、`#fic-home-purpose-routes` アンカーあり、既存の直リンク確認も維持。本番/ローカル一致。
テーマハブTheme Routesチップ可読性修正後の確認: `/themes/` で `theme_hub_cluster` 11件、テーマ記事34本、Code Snippets ID 29の本番CSS/ローカルCSS一致、`.fic-hub-card .fic-home-search-chips a` に濃色文字指定あり、`readableClusterChips=true` を確認。
記事生成ルール更新後の確認: 企業分析/テーマ分析プロンプトに初心者向け解説、H2/H3階層ルールを追加。`docs/chat_workflows/company_03_codex_review.md` と `docs/chat_workflows/industry_04_codex_review.md` に `node scripts/audit_article_heading_hierarchy.mjs ...` をレビュー工程として追記。フェーズ1記事46本の監査は `Review needed: 0`。
ヘッダーロゴ/ヒーローロゴ調整後の確認: 濃紺ロゴ画像URL 200、管理CSSにヘッダー差し替え指定あり、ヒーロー本文マークアップ内に `fic-home-brand` なし、ヒーロー余白調整あり、生ショートコードなし、横スクロールリスクなし。
ヘッダー下余白調整後の確認: cache-busted `/themes/` で管理CSSに `container_top_widget` 非表示、ハブ `#main-wrap` 上余白12px、`.fic-hub-hero` 上マージン0を確認。通常URLはページキャッシュが古いHTMLを返す場合があるため、表示確認時は強制再読み込みまたはキャッシュ削除を行う。
決算スケジュール表デザイン調整後の確認: cache-busted `/earnings-schedule/` で `fic-earnings-schedule-visual-alignment-css`、黄色の更新予定バッジ、黒文字の公開済みバッジ、表マークアップ、生ショートコードなしを確認。総合回帰でも決算予定ルート、Theme Lens、企業検索、横スクロールリスクなしを確認。
検索フォーム高さ調整後の確認: cache-busted トップページで `.fic-home-search input` の `min-height: 52px`、`padding: 12px 16px`、検索ボタン最小高さ、スマホ用ボタン高さ50px、生ショートコードなしを確認。
ヘッダーメニュー色調整後の確認: cache-busted トップページで `#nav #fixnavul > li > a` に `color: #102a43 !important`、hoverに `#1f1f23` が出ていること、生ショートコードなしを確認。
決算予定ページ旧本文整理後の確認: cache-busted `/earnings-schedule/` で `fic-earnings-guide`、`fic-earnings-table`、ページタイトル非表示CSS、ガイド見出し背景リセットCSSを確認。旧本文の `本ページの見方`、`更新方針について`、生ショートコードなし。Code Snippets ID 32 はローカルと本番一致。
カテゴリ一覧デザイン調整後の確認: cache-busted `theme-reading`、`theme-analysis`、`企業分析`、`investment-reading` の4カテゴリで `FIC category archive alignment`、サイドバー非表示CSS、黒黄ヒーロー、3列カードグリッド、記事カード表示、生FICショートコードなしを確認。
スマホメニュー目的別化後の確認: cache-busted トップページで `FIC mobile drawer purpose menu`、`fic-mobile-purpose-menu-js`、`#fix_sidebar #categories-4` のモバイル非表示CSS、`mobile_purpose_menu` 計測属性、トップ/企業/テーマ/投資の読み方/決算予定リンク、生ショートコードなしを確認。
動画/決算空状態調整後の確認: cache-busted トップページで `.fic-home-video h2` の `background: transparent`、`.fic-home-earnings-empty` CSS、`upgradeFicEarningsEmptyState`、`直近の決算予定は更新準備中です。`、`home_earnings_empty` 計測属性、生ショートコードなしを確認。
検索結果ページ調整後の確認: cache-busted `/?s=半導体` で `FIC search results alignment`、`injectFicSearchAssist`、`検索結果：【半導体】`、`もう一度検索`、`search_assist_hub`、`body.search #sidebar` 非表示CSS、カードグリッドCSS、生ショートコードなしを確認。0件検索でも `search-no-results`、検索補助JS、raw shortcodeなしを確認。
記事ページ外枠調整後の確認: cache-busted `nitori-9843-analysis`、`construction-material-shortage-project-delay-margin-risk`、`kessan-tanshin-reading-guide` で `FIC single article shell alignment`、`body.single-post #sidebar`、`body.single-post #pickup_posts_container`、タイトルヒーローCSS、カテゴリ表示、記事内ブリッジ、生ショートコードなしを確認。
```

内部リンク確認ファイル:

```text
work/internal-link-audit-2026-05-23.csv
work/internal-link-company-backup-2026-05-23.json
work/internal-link-company-updates-2026-05-23.csv
work/internal-link-company-fix-2026-05-23.csv
work/context-link-render-check-2026-05-23.csv
work/navigation-measurement-check-2026-05-23.json
docs/navigation_measurement_events.md
work/qa-earnings-guide-pc.png
work/qa-earnings-guide-sp.png
work/qa-theme-hub-chips-pc.png
work/qa-theme-hub-chips-sp.png
work/qa-learning-hub-chips-pc.png
work/qa-learning-hub-chips-sp.png
work/full-route-regression-2026-05-23.json
work/production-code-snippets-2026-05-23.csv
work/final-route-regression-2026-05-23.json
work/production-code-snippets-final-2026-05-23.csv
work/production-local-snippet-parity-2026-05-23.json
work/qa-company-hub-direct-chips-pc.png
work/qa-company-hub-direct-chips-sp.png
work/qa-home-direct-chips-pc.png
work/qa-home-direct-chips-sp.png
work/manual-internal-link-batch2-backup-2026-05-23.json
work/manual-internal-link-batch2-report-2026-05-23.csv
work/theme-manual-internal-link-batch1-backup-2026-05-23.json
work/theme-manual-internal-link-batch1-report-2026-05-23.csv
work/theme-analysis-category-backup-2026-05-23.json
work/theme-analysis-category-report-2026-05-23.csv
work/code-snippets-count-fix-backup-2026-05-23.json
work/code-snippets-count-fix-report-2026-05-23.json
work/post-count-category-regression-2026-05-23.json
work/production-local-snippet-parity-after-count-fix-2026-05-23.json
work/theme-earnings-snippet-update-backup-2026-05-23.json
work/theme-earnings-snippet-update-report-2026-05-23.json
work/theme-earnings-production-check-2026-05-23.json
work/theme-cluster-snippet-backup-2026-05-23.json
work/theme-cluster-snippet-report-2026-05-23.json
work/theme-cluster-production-check-2026-05-23.json
work/earnings-routes-snippet-backup-2026-05-23.json
work/earnings-routes-snippet-report-2026-05-23.json
work/earnings-routes-production-check-2026-05-23.json
work/post-theme-earnings-regression-2026-05-23.json
work/post-theme-earnings-regression-2026-05-24.json
work/article-heading-hierarchy-audit.md
work/article-heading-hierarchy-audit.csv
work/code-snippets-id29-backup-2026-05-24T04-03-35-584Z.json
```

デプロイパッケージ:

```text
wordpress/deploy/top-page-mvp/code-snippets-paste/
  fic-home-page-mvp-no-open-tag.php
  fic-hub-pages-no-open-tag.php
  fic-category-bridge-links-no-open-tag.php
  fic-navigation-measurement-no-open-tag.php
  fic-earnings-page-guide-no-open-tag.php
```

`scripts/build_top_page_deploy_package.ps1` は上記5本と関連ドキュメントを含むよう更新済み。

## 補足

ユーザーは「ローカルでやったものと一致させていい」と明言済み。

トップページは「読むページ」ではなく「調べ始めるページ」として仕上げる方針。今後は見た目の大枠より、検索・ハブ・記事間導線・計測の磨き込みが中心。
