# Change Log

## 2026-05-24
- Added `scripts/compare_seo_ctr_watchlist.mjs` and a smoke-test comparison report so future Search Console watchlist CSVs can be compared against the 2026-05-24 baseline with CTR, position, and impression deltas.
- Added `work/seo-ctr-watchlist-2026-05-24.md`, `work/seo-ctr-watchlist-baseline-2026-05-24.csv`, and `scripts/extract_seo_ctr_watchlist.mjs` so the updated SEO titles/excerpts and old-code handoff pages can be compared against future Search Console reports.
- Updated the production MTG and JAFCO company-analysis titles and excerpts after finishing the remaining new Search Console article candidates, adding clearer search-facing messages around ReFa/channel expansion/inbound demand and IPO count/AUM/investment multiple revenue drivers; verified live title, H1, meta/OG descriptions, canonical URLs, company-analysis archive visibility, and no raw shortcodes.
- Updated the production Nippon Steel company-analysis title and excerpt based on Search Console query intent, tightening the search-facing message around U.S. Steel consolidation, domestic restructuring, steel prices, raw-material costs, and strengths/weaknesses; verified live title, H1, meta/OG descriptions, canonical URL, company-analysis archive visibility, and no raw shortcodes.
- Updated the production Mitsubishi Warehouse company-analysis title and excerpt based on Search Console visibility, shortening the search-facing message around logistics income, real estate leasing, overseas subsidiaries, and policy-share sale gains; verified live title, H1, meta/OG descriptions, canonical URL, company-analysis archive visibility, and no raw shortcodes.
- Updated the production Nissan rare-earth/EV-motor theme-analysis title and excerpt based on Search Console visibility, shortening the search-facing message around rare-earth reduction, EV motors, and related-company impact; verified live title, H1, meta/OG descriptions, canonical URL, theme-analysis archive visibility, and no raw shortcodes.
- Updated the production Oriental Land company-analysis title and excerpt based on Search Console CTR findings, tightening the search-facing message around park attendance, guest spend, hotels, new-area investment, growth, and margins; verified live title, H1, meta/OG descriptions, canonical URL, and no raw shortcodes.
- Updated the production Minervini investing-strategy article title and excerpt based on Search Console visibility, changing the search-facing message from a book-note style to a practical guide around buy timing, stop losses, and stock selection; also added the current `投資の読み方` category while keeping the legacy `投資法` category.
- Added an archive handoff path for old `code-...` company pages that still receive Search Console traffic: updated Code Snippets ID 30 with an old-article archive-box fallback, manually added the archive notice to `code-4369`, `code-8253`, and `code-7033`, and verified old pages with newer replacements still show latest-analysis canonical/noindex while no-latest pages route readers to the company hub and site search.
- Updated the production China semiconductor self-sufficiency article title and excerpt based on Search Console CTR findings, narrowing the search-facing message to Japan's semiconductor equipment/material stocks and key indicators; verified live title, H1, meta/OG descriptions, canonical URL, and no raw shortcodes.
- Updated the production Kioxia company-analysis post title and excerpt based on GA4/Search Console findings, shortening the search-facing message around AI SSD demand, NAND market conditions, and profit recovery; verified live title, H1, meta/OG descriptions, canonical URL, and no raw shortcodes.
- Refreshed the GA4/Search Console report with OAuth access, added `work/ga-gsc-action-notes-2026-05-24.md`, and made the GA/GSC fetcher fall back to the known FIC GA4 property ID `367975716`.
- Updated the production handoff with the Theme Routes chip readability fix, Code Snippets ID 29 CSS parity check, and the article heading-hierarchy audit step.
- Added the heading-hierarchy audit command to the company-analysis and industry-analysis Codex review workflows so H2/H3 structure is checked before handoff.
- Updated production Code Snippets ID 29 and the local hub CSS so Theme Routes chips inside white cards use dark readable text instead of inheriting the white-on-dark hero chip style.
- Added `scripts/audit_article_heading_hierarchy.mjs` to flag article HTML where long H2-only sections should be split into H3 checkpoints, with Markdown/CSV reports under `work/`.
- Added H2/H3 hierarchy rules to the company-analysis and industry/theme-analysis article prompts so long H2-only articles are split into reader-friendly checkpoints.
- Added beginner-friendly explanation rules to the company-analysis and industry/theme-analysis article prompts, requiring plain-language term explanations, "why this number matters" sentences, and reader guide lines without reducing analytical depth.
- Added `docs/article_beginner_explanation_policy.md` with the shared FIC policy for beginner explanations, including `beginner-box` and `term-box` examples.
- Brought the legacy `業界分析` category archive (`category-98`) into the same production archive design system as the new theme/category pages, including the dark archive hero, readable card grid, hidden sidebar/tag chip, and purpose guide back to the theme hub.
- Tightened production mobile QA fixes for the earnings-schedule guide, constraining the guide to the phone viewport, strengthening Japanese line wrapping, and verifying no horizontal overflow with a 390px mobile CDP check.
- Updated production category/search archive card styling so category archive article cards follow the same readable thumbnail + white-content layout as search results.
- Reduced the single-article hero title size on production, with tighter mobile wrapping for long company-analysis titles.
- Fixed the production search-results card layout so result titles and dates render in a readable white content area below thumbnails, and tightened the mobile search-results hero copy/line wrapping.
- Added `scripts/reauthorize_google_oauth.mjs` and updated the Google access docs so the fallback for Search Console's "メールアドレスが見つかりませんでした" service-account error is owner-account OAuth reauthorization.
- Reauthorized Google OAuth, updated GA/GSC report fetching to prefer OAuth over the service account, and generated the first combined report in `work/ga-gsc-first-readout.md`.
- Updated production Code Snippets ID 31 so `fic_navigation_click` and `fic_search_submit` include `fic_page_type` and `fic_page_path`, allowing GA4 reports to split clicks by top, hub, category, article, search, and earnings surfaces.
- Checked Google Analytics/Search Console access: public HTML includes GA4 `G-8VFXTYHBV5` and GSC verification, OAuth refresh is revoked, and the service account authenticates but lacks GA/GSC permissions. Added access-check and report-fetch scripts plus `docs/google_ga_gsc_access.md`.
- Added `scripts/analyze_ga_gsc_fic_report.mjs` to turn fetched GA/GSC JSON into a first-read Markdown summary covering top pages, hub/category/article split, FIC custom events, traffic channels, GSC queries, and GSC pages.
- Added `scripts/audit_fic_measurement_coverage.mjs` and generated `work/fic-measurement-coverage.*` to inventory production `data-fic-area` coverage across top, hub, category, article, earnings, and search surfaces.
- Updated production Code Snippets ID 30 so key category archive pages get a compact purpose guide between the archive hero and article list, linking back to hubs and adjacent categories with `category_archive_guide` measurement attributes.
- Updated production Code Snippets ID 30 so article-level internal links now emit measurement attributes: context links, reading-guide bridge hub/cards, bottom related-article cards, category archive buttons, and purpose-hub buttons.
- Updated production Code Snippets ID 29 so single article pages use a narrower 960px shell and an 800px text measure for paragraphs, lists, headings, quote blocks, and reading-guide blocks while keeping tables/media from being over-constrained.
- Added production Code Snippets ID 30 support for a bottom-of-article "same category next reads" block across company analysis, theme analysis, theme-reading, and investment-reading posts, preserving the one-column article layout while restoring category/hub navigation without a sidebar.

## 2026-05-23
- Updated production Code Snippets ID 28 so `/companies/`, `/themes/`, and `/learn/` each show six representative article cards, helping readers discover concrete companies, themes, and reading guides without starting from search.
- Completed production alignment for the FIC top page MVP, hiding Diver legacy top elements, page title, pickup blocks, and sidebar on the front page while widening the page shell.
- Extended the same page-shell treatment to the `/companies/`, `/themes/`, `/learn/`, and `/earnings-schedule/` fixed pages so hub and earnings views render full-width without sidebar interference.
- Updated production Code Snippets ID 28 so the theme hub links all 23 phase-1 articles and the company hub shows 12 latest company-analysis cards plus quick company-search chips.
- Added production Code Snippets ID 30 for category-aware article bridge links from company-analysis articles to investment-reading guides and from theme/industry articles to theme-reading guides.
- Extended production Code Snippets ID 30 to add one contextual "この分析を読む補助線" paragraph near the top of company-analysis and industry-analysis articles, skipping articles where that paragraph already exists in the post body.
- Added manual contextual investment-reading links to four company-analysis posts: Mercari, Sumitomo Metal Mining, JFE Holdings, and Kawasaki Heavy Industries.
- Verified all 115 production company/industry analysis pages render exactly one contextual reading-guide paragraph and one category bridge section, with no raw FIC shortcodes.
- Added production Code Snippets ID 31 for `fic_navigation_click` and `fic_search_submit` measurement events through `gtag`, `dataLayer`, and the `fic:measurement` browser event.
- Verified the production measurement script by triggering a top-page navigation click and company-hub search submit, confirming both events are pushed into `window.dataLayer` and emitted as `fic:measurement` browser events.
- Added `docs/navigation_measurement_events.md` with the current event names, triggers, parameters, and GA4/GTM follow-up notes.
- Added production Code Snippets ID 32 for an earnings-schedule page guide that routes readers from the schedule into company search and investment-reading articles for progress rate, operating margin, and orders/backlog.
- Verified the earnings-schedule guide on desktop and mobile, including tracked links, existing table/mobile-list display, hidden sidebar, and no horizontal overflow.
- Updated production Code Snippets ID 28 so the theme hub search area includes quick links to seven theme-reading guides: rates, FX, raw materials, semiconductors, policy/subsidies, logistics reform, and inbound demand.
- Verified the theme hub quick links on desktop and mobile, including tracked click events, all 11 theme-reading cards, latest theme-analysis cards, hidden sidebar, and no horizontal overflow.
- Updated production Code Snippets ID 28 so the learning hub search area includes quick links to seven investment-reading guides: earnings releases, operating margin, orders/backlog, progress rate, cash flow, ROE/ROIC, and financial safety.
- Verified the learning hub quick links on desktop and mobile, including tracked click events, topic cards, featured reading cards, latest learning cards, hidden sidebar, and no horizontal overflow.
- Added a full production regression record for the top page, three hubs, earnings schedule, and representative company/industry articles across desktop and mobile; all 14 route checks passed.
- Exported the current production FIC Code Snippets inventory to `work/production-code-snippets-2026-05-23.csv`.
- Updated production Code Snippets ID 28 so the company hub quick links for Kioxia, Nitori, Mitsubishi UFJ, Mizuho, Recruit, and ENEOS go directly to their representative company-analysis articles instead of search-result pages.
- Verified the direct company hub quick links on desktop and mobile, including tracked click events, latest company-analysis cards, hidden sidebar, and no horizontal overflow.
- Updated production Code Snippets ID 27 so top-page search chips for semiconductors, rates, FX, and earnings go directly to representative reading-guide articles, while AI remains a search-result link.
- Verified the direct top-page search chips on desktop and mobile, including tracked click events, hero actions, and no horizontal overflow.
- Updated `scripts/build_top_page_deploy_package.ps1` so the deploy package includes the current five Code Snippets paste files: top page MVP, purpose hubs, category bridge links, navigation measurement, and earnings-schedule page guide.
- Rebuilt `wordpress/deploy/top-page-mvp/` with the latest snippets and operational docs, including the handoff and navigation measurement event reference.
- Re-ran the full production regression after the top-page direct-chip update and deploy-package rebuild; all 14 desktop/mobile checks across the main routes passed.
- Exported the final production FIC Code Snippets inventory to `work/production-code-snippets-final-2026-05-23.csv`.
- Added a production/local parity check for Code Snippets ID 27/28/30/31/32 and the CSS/logo/page-shell contents of ID 29; no mismatches were found.
- Verified top, hub, earnings, and phase-1 article routes on production across desktop/mobile checks; raw shortcodes, missing phase-1 links, visible sidebars, and horizontal overflow were not found in the checked surfaces.
- Updated the top-page admin runbook, publication playbook, and rollout checklist so the operational docs match the current five-snippet production structure, including category bridge links, navigation measurement, earnings guide, and partial rollback notes.
- Marked the older top-page MVP deployment note as background material and pointed production work to the current deploy package and five-snippet runbooks.
- Updated the measurement plan to reflect the active production measurement snippet and the current `fic_navigation_click` / `fic_search_submit` event flow.
- Added a second manual internal-link batch to six production company-analysis articles: Nitori, Mizuho FG, ENEOS, Honda, SCREEN Holdings, and Daikin.
- Verified the six updated articles render exactly one "この分析を読む補助線" paragraph each, include the intended investment-reading links, and show no raw FIC shortcodes.
- Added the first manual internal-link batch to six production industry/theme-analysis articles, connecting raw-material, semiconductor, energy, policy, logistics, FX, and consumer-demand reading guides from article-specific context.
- Verified the six updated industry/theme articles render exactly one "この分析を読む補助線" paragraph each, retain the category bridge block, include theme-reading links, and show no raw FIC shortcodes.
- Added the new `テーマ分析` category to all 23 existing production `業界分析` posts while keeping the legacy category assigned, so the new taxonomy has live content without breaking old category routes.
- Verified `テーマ分析` now contains 23 posts, all 23 still retain `業界分析`, and `/themes/`, `/category/theme-analysis/`, and a representative article return HTTP 200 with no raw FIC shortcodes.
- Updated production Code Snippets ID 27 and ID 28 so category-count badges count unique posts across fallback categories, preventing `テーマ分析` and legacy `業界分析` overlap from double-counting the same 23 articles.
- Verified cache-busted production output shows `テーマ分析 23` and `/themes/` shows `34 本のテーマ記事` after combining 23 theme-analysis posts with 11 theme-reading posts.
- Added and ran a post-count/category regression check across the top page, three hubs, earnings schedule, theme-analysis category archive, and representative company/theme articles; all 8 routes returned HTTP 200 with no raw FIC shortcodes.
- Re-ran production/local snippet parity after the category-count fix; Code Snippets ID 27/28/30/31/32 all match their local managed files.
- Updated the production theme hub so the main material cards and quick chips prioritize rates, FX, raw materials, semiconductors, policy/subsidies, energy, logistics, and inbound/consumer demand, with the main material cards linking directly to representative theme-reading articles.
- Expanded the production earnings-schedule guide with a direct earnings-release reading link, a company-name/ticker search form, and quick links to representative company-analysis articles for Nitori, Mizuho FG, ENEOS, Honda, SCREEN, and Daikin.
- Verified the updated theme hub and earnings guide on production: no raw FIC shortcodes, 8 direct theme links, energy chip present, company search present, 6 tracked company-analysis links, and tracked earnings search.
- Added a `Theme Routes` section to the production theme hub, grouping reading-guide links into four lightweight theme routes: rates/FX, cost/energy/logistics, semiconductors/policy/defense, and demand/labor/inbound.
- Verified the production theme hub renders all four route groups, 11 tracked `theme_hub_cluster` links, the 34-article theme count, and no raw FIC shortcodes.
- Added an `Earnings Routes` section to the production earnings-schedule guide with before/on-day/after decision routes that link to seven investment-reading guides.
- Verified the production earnings schedule renders all three earnings routes, seven tracked `earnings_guide_route` links, the company search box, six company-analysis links, and no raw FIC shortcodes.
- Updated the navigation measurement reference and top-page measurement plan with the new `theme_hub_cluster`, `earnings_guide_route`, `earnings_guide_company`, and `earnings_guide_search` areas plus recommended GA4 report slices.
- Added and ran a combined post-theme/earnings regression check across 8 production routes and Code Snippets ID 27/28/30/31/32; routes had no raw FIC shortcodes or horizontal-risk markers, and all managed snippets matched production.
- Added a `Theme Lens` section to the production earnings-schedule guide, connecting earnings readers to six external-environment guides: rates, FX, raw materials, semiconductors, energy, and logistics.
- Verified the production earnings schedule renders the new `Theme Lens`, six tracked `earnings_guide_theme` links, the existing seven earnings-route links, company search, six company-analysis links, and no raw FIC shortcodes.
- Added a `Company Routes` section to the production company hub, grouping representative company-analysis links by finance, resources/costs, demand, investment, and mobility.
- Verified the production company hub renders all five company-route groups, 13 tracked `company_hub_route` links, the new route CSS, and no raw FIC shortcodes or horizontal-risk markers.
- Added a `Learning Routes` section to the production learning hub, grouping investment-reading links by before earnings, on announcement day, deep dive, and risk/returns.
- Verified the production learning hub renders all four learning-route groups, 12 tracked `learning_hub_route` links, the new route CSS, and no raw FIC shortcodes or horizontal-risk markers.
- Added a top-page `Purpose Routes` section that previews the four route-enabled hubs: Company Routes, Theme Routes, Learning Routes, and Earnings Routes.
- Verified the production top page renders `Purpose Routes`, four tracked `home_purpose_route` links, the new route CSS, and no raw FIC shortcodes or horizontal-risk markers.
- Updated the top-page `Market Triggers` cards so rates, FX, raw materials, AI/semiconductors, policy/subsidies, and energy link directly to representative theme-reading articles instead of search-result pages.
- Verified the production top page renders six tracked `home_market_trigger` links, includes the policy and energy direct links, and no longer uses search-result fallback links for the market-trigger cards.
- Updated the top-page search chips so all six chips link directly to representative articles: semiconductors, rates, FX, earnings, policy, and energy.
- Verified the production top page renders six tracked `home_search_chip` links, includes the policy and energy chips, and no longer uses search-result fallback links for the search-chip row.
- Updated the top-page quick navigation so it includes a direct anchor link to the `Purpose Routes` section.
- Verified the production top page renders five tracked `home_quicknav` links, the `#fic-home-purpose-routes` anchor, and the existing direct-link checks still pass.
- Uploaded a dark header logo asset and updated the managed CSS so the white-header site logo renders with the dark FIC mark.
- Removed the duplicated logo markup from the top-page hero and tightened the hero top padding so the yellow value label becomes the first hero element.
- Reduced the header-to-hero gap on the top, hub, and earnings pages by hiding Diver's blank top widget area on fixed-page hubs and tightening the managed page-shell padding.
- Restyled the earnings schedule table so it matches the FIC black/yellow system, replacing the green/purple status badges with quieter black/yellow/gray states and a flatter table frame.
- Increased the top and hub search input height so the mobile stacked search field no longer looks compressed above the submit button.
- Fixed the header navigation link color to the FIC dark navy so Diver's softer blue link color does not show in the top menu.
- Simplified the earnings schedule fixed page content to the schedule shortcode only, hid the legacy page title, and reset the earnings guide heading styles so old article `h2` yellow backgrounds no longer bleed into the guide.
- Restyled the main category archive pages for company analysis, theme analysis, theme reading, and investment reading with hub-style dark hero sections, full-width/no-sidebar layout, and card-based article grids.
- Reworked the smartphone drawer/sidebar entry so a purpose-based mobile menu appears first, linking to the top page, company hub, theme hub, learning hub, earnings schedule, YouTube, and four primary article categories while hiding the old category-count list on mobile.
- Fixed the top-page video block heading so old article `h2` yellow backgrounds no longer bleed into the dark video section, and replaced the empty upcoming-earnings sentence with a small guided empty state linking to company analysis and the earnings-release reading guide.
- Restyled WordPress search results and no-results pages with a FIC search hero, full-width/no-sidebar shell, card-based result grid, pagination styling, and a search-assist block that lets readers search again or jump to the company, theme, learning, and earnings hubs.
- Aligned single article pages with the FIC shell by hiding the old Diver category band, pickup slider, sidebar, and share blocks, then styling the article title area as a black/yellow hero with a cleaner full-width reading column.

## 2026-05-22

- フェーズ1記事パッケージ生成時に、本文末尾へ `次に読む` 導線ブロックを自動挿入するよう更新。
- `投資の読み方` 記事では企業ハブ、テーマハブ、投資の読み方ハブへ、`テーマの読み方` 記事ではテーマハブ、企業ハブ、投資の読み方ハブへ誘導。
- `wordpress/css/custom.css` と記事プレビューCSSに、記事末尾導線用の黒黄デザインを追加。
- `scripts/verify_phase1_article_package.ps1` で本文・プレビューに記事末尾導線が入っているか確認するよう更新。

## 2026-05-22

- テーマハブと投資の読み方ハブの代表記事カードについて、投稿スラッグから公開済み投稿URLを取得する `fic_get_post_url_by_slug()` を追加。
- 代表記事カードのリンクを、公開済み投稿があれば `get_permalink()`、未公開なら想定スラッグURLへフォールバックする形に変更。
- `docs/phase1_wordpress_publish_checklist.md` の公開後ハブ確認項目を、公開済み投稿URLへの遷移確認に更新。

## 2026-05-22

- フェーズ1記事パッケージに公開進捗管理用CSV `metadata/phase1-article-publish-tracker.csv` を追加。
- 同CSVには、公開バッチ、ステータス、本文ファイル、アイキャッチ、プレビュー、公開URL、公開日、メモ欄を出力。
- アップロードCSVと公開進捗管理CSVを、公開チェックリストの推奨バッチ順に並ぶよう調整。
- `scripts/verify_phase1_article_package.ps1` で公開進捗管理CSVの行数、必須列、プレビュー参照、アップロードCSVとの整合性も確認するように更新。
- `docs/phase1_wordpress_publish_checklist.md` に公開進捗管理CSVの使い方を追記。

## 2026-05-22

- フェーズ1記事パッケージ専用の検証スクリプト `scripts/verify_phase1_article_package.ps1` を追加。
- 検証内容として、本文23本、アイキャッチ23枚、CSV23行、プレビュー24件、CSV参照、本文メタ除去、記事プレビュー、画像サイズを確認できるようにした。
- `docs/phase1_wordpress_publish_checklist.md` に記事パッケージ検証コマンドを追加。

## 2026-05-22

- ローカルプレビュー一覧 `wordpress/previews/index.html` に、フェーズ1記事プレビュー一覧への導線を追加。
- `fic-learning-hub-preview.html` の代表リンクと最新記事カードを、フェーズ1記事プレビューへ接続。
- `fic-theme-hub-preview.html` の `テーマの読み方` 代表リンクを、フェーズ1記事プレビューへ接続。
- ブラウザで、プレビュー一覧から記事一覧、投資の読み方ハブから決算短信プレビューへ遷移できることを確認。

## 2026-05-22

- フェーズ1記事のWordPress投入用パッケージ生成スクリプト `scripts/build_phase1_article_package.ps1` を追加。
- `wordpress/deploy/phase1-articles/` に、管理メタ除去済み本文HTML、記事別アイキャッチ、CSV管理表、公開用ドキュメントを出力。
- 同パッケージに静的プレビュー一覧 `wordpress/deploy/phase1-articles/previews/index.html` と記事別プレビュー23本を追加。
- 生成物について、本文23本、アイキャッチ23枚、CSV23行、画像サイズ `1200x630 RGB` を確認。
- ブラウザでプレビュー一覧23カード、代表記事ページのアイキャッチ・本文表示、横スクロールなしを確認。

## 2026-05-22

- フェーズ1記事23本をWordPressへ投入するための `docs/phase1_wordpress_publish_checklist.md` を追加。
- 公開チェックリストには、カテゴリ作成、1記事ごとの投入手順、4つの公開バッチ、公開URL控え、ハブ確認、内部リンク方針を整理。
- `phase1_publication_matrix.md` と `phase1_wordpress_publish_checklist.md` をデプロイパッケージへ含めるよう、ビルド・検証スクリプトを更新。
- `docs/phase1_content_plan.md` と `docs/top_page_publication_playbook.md` から公開チェックリストへ導線を追加。

## 2026-05-22

- トップページ、テーマハブ、投資の読み方ハブのカテゴリ参照をフェーズ1公開構成へ更新。
  - `テーマ分析` を優先し、移行中は旧 `業界分析` もフォールバックで取得。
  - `投資の読み方` を優先し、移行中は旧 `基礎講座` / `ビギナーガイド` もフォールバックで取得。
- `/themes/` のヒーロー件数をテーマ分析とテーマの読み方を含む `テーマ記事` 表記へ変更。
- `/learn/` のヒーロー、一覧リンク、最新記事見出しを `投資の読み方` 表記へ統一。
- ローカルプレビューとデプロイパッケージを更新し、トップ・テーマ・投資の読み方プレビューで横スクロールがないことを確認。

## 2026-05-22

- `投資の読み方` 既存9本にも記事別アイキャッチを追加し、フェーズ1の全23記事で記事別アイキャッチを用意。
  - `wordpress/assets/eyecatch/investment-reading/articles/`
  - `wordpress/assets/eyecatch/theme-reading/articles/`
- WordPress投入時の取り違え防止用に `docs/phase1_publication_matrix.md` を追加。
- フェーズ1全23枚のアイキャッチが `1200x630 RGB` で出力されていることを確認。

## 2026-05-22

- `テーマの読み方` フェーズ1記事11本のメタカテゴリを `テーマの読み方` に統一。
- `テーマの読み方` フェーズ1記事11本分のアイキャッチを作成。
  - `wordpress/assets/eyecatch/theme-reading/articles/`
- `wordpress/drafts/theme_entry/README.md` と `wordpress/drafts/theme_entry/publish_plan.md` の公開カテゴリを更新。

## 2026-05-22

- `投資の読み方` フェーズ1記事として、以下の3本を追加。
  - `wordpress/drafts/beginner_guide/goodwill-impairment-guide.html`
  - `wordpress/drafts/beginner_guide/payout-ratio-total-return-guide.html`
  - `wordpress/drafts/beginner_guide/equity-ratio-interest-bearing-debt-guide.html`
- `投資の読み方` 下書き12本のメタカテゴリを `投資の読み方` に統一。
- 追加3記事分のアイキャッチを作成。
  - `wordpress/assets/eyecatch/investment-reading/articles/goodwill-impairment-guide.png`
  - `wordpress/assets/eyecatch/investment-reading/articles/payout-ratio-total-return-guide.png`
  - `wordpress/assets/eyecatch/investment-reading/articles/equity-ratio-interest-bearing-debt-guide.png`
- `docs/phase1_content_plan.md`、`wordpress/drafts/beginner_guide/README.md`、`wordpress/drafts/beginner_guide/publish_plan.md` を更新。

## 2026-05-22
- Added the top-page reform roadmap and deployment notes for moving the FIC homepage from an article-listing portal toward a purpose-led entry point.
- Added the `[fic_home_mvp]` WordPress shortcode design, including hero copy, three reader entry points, the FIC four-step analysis flow, purpose-based latest article sections, upcoming earnings analysis, and editorial-policy links.
- Added standalone Code Snippets-ready PHP at `wordpress/snippets/fic-home-page-mvp.php` and standalone CSS at `wordpress/css/fic-home-page-mvp.css` for the homepage MVP.
- Added the first three beginner-guide article drafts for the planned "投資の読み方" entry point: decision-summary reading, operating margin, and orders/backlog/inventory basics.
- Updated the homepage MVP latest-post logic so the "投資の読み方" section can use 基礎講座 first and fall back to ビギナーガイド while the new category is still being populated.
- Added `function_exists()` guards to the homepage MVP functions so the theme-functions version and Code Snippets version do not fatal if both are present during deployment testing.
- Added a static local preview at `wordpress/previews/fic-home-page-mvp-preview.html` for checking the homepage MVP layout before WordPress deployment.
- Added homepage MVP sections for first-check behavior and reader-level paths so the top page can serve beginners, intermediate readers, and veteran investors from the same entry point.
- Reduced perceived text density in the homepage MVP by shortening hero/section copy and simplifying guide cards while keeping the richer latest-analysis cards.
- Added a CSS-built FIC brand mark and visual analysis-flow panel to the homepage hero so the top page has a stronger non-text identity without depending on an uploaded media asset.
- Replaced the temporary CSS brand mark with the supplied FIC logo asset, added black/yellow gradient treatment to the homepage hero and use-case band, and softened key cards/buttons with small-radius corners.
- Added a transparent-background white FIC logo asset for the homepage hero so the logo can sit directly on the black gradient background without a white box.
- Added a prominent homepage search form for company names, ticker codes, and investment themes so the top page works as a research starting point, not only an article menu.
- Added quick-search chips for common themes such as semiconductors, rates, FX, earnings, and AI to reduce friction for first-time visitors.
- Added a Market Triggers section for rates, FX, raw-material costs, and AI/semiconductors so visitors can start from the macro/news driver before choosing specific companies.
- Added a compact homepage quick navigation bar linking to First Check, Market Triggers, Latest Analysis, and Earnings Watch so the growing top page remains easy to scan and use.
- Added compact trust badges to the homepage hero's analysis-flow panel for public sources, accountant perspective, and editorial review.
- Added dynamic article-count badges to the homepage entry cards so visitors can see the depth of the company, theme, and learning archives at a glance.
- Added a first-visit reading route that guides users from basics, to one company analysis, then to broader theme analysis.
- Added earnings-check cards before the upcoming earnings schedule so users know whether to inspect sales drivers, margin changes, company guidance, or next KPIs.
- Added compact hero statistics for company analysis, theme analysis, and learning articles so first-time visitors can see the site's archive depth immediately.
- Added a dynamic latest-update strip in the homepage hero so visitors can see the newest relevant analysis from the first viewport.
- Added the `[fic_company_hub]` fixed-page shortcode, company hub preview, and deployment notes to begin the purpose-specific intermediary page layer.
- Added the `[fic_theme_hub]` fixed-page shortcode, theme hub preview, and deployment notes so visitors can start from news, macro drivers, policy, raw-material costs, and other investment themes before moving into company analysis.
- Added the `[fic_learning_hub]` fixed-page shortcode, learning hub preview, and deployment notes so beginner readers can start from financial-statement and KPI basics without making the homepage text-heavy.
- Updated the homepage MVP primary links so the main CTA, first-check cards, entry cards, reader paths, and reading route lead to the purpose-specific hub pages instead of jumping straight to category archives.
- Added a shared hub navigation strip across the company, theme, and learning fixed-page hubs so readers can switch between the three entry points from the top of each page.
- Added `wordpress/snippets/fic-hub-pages.php` as a Code Snippets-ready bundle for the company, theme, and learning fixed-page hub shortcodes.
- Reduced homepage MVP text density by removing the duplicate Use Cases and Reader Paths sections now that the fixed-page hubs carry those reader paths.
- Removed the unused homepage reader/routine CSS after those sections moved out of the top-page MVP.
- Updated the company hub's next-step link to route readers to the `themes` fixed-page hub instead of the theme category archive.
- Updated the theme hub's next-step links so readers can move to the company hub or learning hub instead of seeing a duplicate company archive link.
- Tightened the learning hub's next-step copy so beginner readers move from basics into company or theme articles with action-oriented labels.
- Added a local preview index at `wordpress/previews/index.html` so the homepage MVP and three fixed-page hubs can be checked from one place.
- Added `docs/top_page_rollout_checklist.md` to consolidate the production rollout order, page-shortcode mapping, verification checks, and rollback steps.
- Added the recommended WordPress menu structure to the rollout checklist so header navigation matches the new purpose-led hub architecture.
- Added a compact homepage video CTA linking to the FIC YouTube channel as a secondary path for readers who want a quick visual overview before reading articles.
- Added a visible top-page return button to the company, theme, and learning hub heroes so readers can recover to the main entry point without scrolling to the bottom.
- Added a compact "現在地" badge to the active hub navigation item so readers can understand which fixed-page hub they are viewing at a glance.
- Added a top-page publication playbook that consolidates the WordPress paste order, fixed-page shortcode mapping, immediate keep/remove decisions, and rollback steps.
- Expanded the homepage hero action row to include company, theme, learning, and earnings entries in the first viewport.
- Aligned the homepage First Check section with the same four-entry model: company, theme, learning, and earnings.
- Aligned rollout and publication docs around the same four top-level labels: 企業を探す, テーマから探す, 投資の読み方, 決算予定.
- Refined the homepage hero action layout so the four primary entry buttons align as a grid on desktop and tablet before stacking on mobile.
- Verified the local homepage and hub previews through a static server, then added `aria-current="page"` to active hub navigation links.
- Added a responsive QA preview page that shows the homepage and three fixed-page hubs at a 390px mobile width.
- Added `scripts/verify_top_page_mvp.ps1` to run the local top-page MVP preflight checks in one command.
- Added `scripts/start_top_page_preview.ps1` to start or restart the local static preview server with fixed top-page QA URLs.
- Added `scripts/build_top_page_deploy_package.ps1` to collect the Code Snippets PHP, CSS, logo asset, and deployment docs into `wordpress/deploy/top-page-mvp/`.
- Updated the deploy package to generate `code-snippets-paste/` files without the opening `<?php` tag for safer Code Snippets pasting.
- Updated the deploy package to generate `fixed-page-bodies/` files and a recommended menu map so WordPress fixed pages can be created without retyping shortcodes or navigation labels.
- Added `data-fic-area` / `data-fic-label` attributes to the top-page and hub-page links, plus a measurement plan for GA4/GTM click tracking after launch.
- Added a WordPress admin runbook for publication-day work, covering Code Snippets, CSS, fixed pages, menu updates, launch checks, measurement, and rollback.
- Added a post-launch legacy cleanup plan for lowering old top-page blocks, category links, and sidebar elements without breaking existing reader paths.
- Added a top-page content growth plan that prioritizes the next learning articles, theme-entry articles, company-hub improvements, and internal-link rules.
- Hardened the deploy package builder so Code Snippets paste files are read and checked as UTF-8, preventing Japanese text corruption during package generation.
- Added the `ROEとROICの違い` beginner-guide draft and updated the learning publish plan so the next learning article priority moves to segment information.
- Added the `セグメント情報の読み方` beginner-guide draft and updated the learning content plan so the next priority moves to cash-flow basics.
- Added the `キャッシュフロー計算書の見方` beginner-guide draft and updated the learning content plan so the next priority moves to medium-term plan basics.
- Added the `中期経営計画の見方` beginner-guide draft and updated the learning content plan so the next priority moves to price pass-through basics.
- Added the `価格転嫁とは何か` beginner-guide draft and updated the learning content plan so the next priority moves to earnings progress-rate basics.
- Added the `進捗率の見方` beginner-guide draft and updated the content growth plan so the next priority moves from learning basics to theme-entry articles.
- Added the `金利上昇で見る企業影響` theme-entry draft, plus theme-entry README and publication plan, and moved the next theme priority to FX impact.
- Added the `為替で業績が動く企業の見方` theme-entry draft and updated the theme-entry plan so the next priority moves to raw-material cost and pass-through.
- Added the `原材料高と価格転嫁` theme-entry draft and updated the theme-entry plan so the next priority moves to semiconductor investment spillovers.
- Added the `半導体投資の波及先` theme-entry draft and updated the content growth plan so the next theme priority moves to policy and subsidy analysis.
- Added the `政策・補助金テーマの読み方` theme-entry draft and updated the content growth plan so the next theme priority moves to energy transition and power investment.
- Added the `エネルギー転換と電力投資` theme-entry draft and updated the content growth plan so the next theme priority moves to labor shortage and automation investment.
- Added the `人手不足と省力化投資` theme-entry draft and updated the content growth plan so the next theme priority moves to price hikes and consumer demand.
- Added the `値上げと消費者需要` theme-entry draft and updated the content growth plan so the next theme priority moves to inbound demand analysis.
- Added the `インバウンド需要の読み方` theme-entry draft and updated the content growth plan so the next theme priority moves to defense and security investment.
- Added the `防衛・安全保障投資の読み方` theme-entry draft and updated the content growth plan so the next theme priority moves to logistics reform and the 2024 problem.
- Added the `物流改革と2024年問題` theme-entry draft and updated the content growth plan so the next step moves from drafting more theme entries to publishing and featuring representative links on the themes hub.
- Added the phase-1 content plan and eyecatch image plan for the `テーマの読み方` and `投資の読み方` article groups.
- Added featured phase-1 link sections to the theme and learning hub shortcodes so `/themes/` can surface `テーマの読み方` guides and `/learn/` can surface core `投資の読み方` guides.
- Generated and saved common eyecatch images for the `テーマの読み方` and `投資の読み方` article groups, including branded versions with the FIC logo and Japanese title text.

## 2026-05-13
- Added video review notes for article-linked Shorts and long videos, including dense-map teaser handling, company-analysis hook guidance, NYK two-layer profit structure framing, and high-bitrate publish-file review.

## 2026-05-10
- Required policy, subsidy, regulation, defense, and industrial-support industry articles to include at least one official source in references when an official source is available.
- Updated the industry memo prompt to preserve official URLs as source candidates for policy themes instead of relying only on media coverage.
- Added policy-amount disambiguation rules so total public-private investment, fund size, supplementary budget, national spending, fiscal loans, private investment, and subsidy targets are not collapsed into the same phrase.
- Added date-window checks for time-limited penalties, suspensions, sanctions, and regulatory measures so completed events are written as past events rather than current constraints.
- Added policy-theme safeguards to `prompts/article/industry_analysis_article_main.md` and `prompts/article/industry_analysis_memo_main.md`, requiring separation of confirmed facts from unconfirmed policy hypotheses.
- Tightened main-company handling for industry articles so core beneficiaries or headwind names require IR, filing, earnings-material, or major-media support for segment, revenue, order, backlog, profit, or service-revenue evidence.
- Added industry-specific earnings-driver formula requirements and stricter current-level table handling for policy themes, including fallback of weak or unverified figures into "metrics to confirm" rather than center evidence.
- Tightened `prompts/article/industry_analysis_article_main.md` so market-price data such as crude oil, naphtha, diesel, FX, rates, and freight indices must use public/official/major sources when used as central article evidence.
- Added safeguards against using weak market commentary sites as center evidence in summary boxes, current-level tables, scenarios, FAQ, or Article schema descriptions.
- Added explicit current-listed-company checks so old company names and old securities codes from scenario-1 examples are revalidated before appearing in industry articles, including the Nippon Express / NIPPON EXPRESS Holdings case.

## 2026-05-09
- Tightened `prompts/article/industry_analysis_article_main.md` with a fact-safety gate for strong numeric, policy, regulatory, shipment-stop, and future-plan claims.
- Added industry prompt rules requiring source name, timing, and scope near strong claims, with reported-language treatment for major-media-only facts.
- Added reverse-wind theme handling so headings use "逆風を相殺しやすい企業・セグメント" or equivalent instead of forcing "恩恵セクター・企業" when direct beneficiaries are structurally weak.
- Added a required "主要企業で見るべきポイント" treatment for 2-4 core companies, covering earnings variables, indicators to monitor, and downside/offset factors.
- Expanded the final self-check list to catch weakly sourced future-period company plans, unnatural benefit headings on headwind themes, and missing company-specific watchpoints.

## 2026-05-06
- Updated the shared WordPress table CSS so company and industry article tables wrap inside the article width on desktop, with mobile horizontal scrolling retained.
- Generalized desktop table layout to use `table-layout: auto` with normal wrapping, so column width is based on both header and body cell content instead of fixed column-count rules.
- Tightened company and industry article prompts to forbid inline table width styling and to keep multi-column table headings/cells short enough for the shared responsive table CSS.
- Fixed mobile table typography by locking table, cell, and child-element font sizes to a consistent 14px in the shared responsive table CSS.
- Updated sidebar CTA button styling so the Shikiho link uses Amazon orange, the YouTube link uses YouTube red, and both buttons are centered consistently.
- Added a WordPress head-cleanup guard in `wordpress/snippets/functions.php` so Rank Math is treated as the canonical source for SEO meta tags.
- The cleanup removes Diver theme duplicate OGP output plus pre-Rank-Math duplicate `description` and `canonical` tags inside `wp_head`, reducing conflicting metadata on article and archive pages.
- Installed and activated the official Code Snippets plugin on WordPress via REST API after `codex-writer` was promoted to administrator.
- Added the active snippet `FIC: Deduplicate Rank Math SEO metadata v3`, which cleans the rendered `<head>` because Diver emits duplicate SEO/OGP tags before `wp_head`.
- Verified live output on the top page, a company-analysis category page, and the Keyence article: Rank Math remains once, Diver OGP is removed, and `description`/`canonical`/OGP/Twitter metadata are no longer duplicated where Rank Math provides them.
- Replaced the live SEO snippet with `FIC: SEO metadata and Article schema cleanup`, a single rendered-document cleanup that also normalizes body-level Article JSON-LD to WordPress publication dates, modified dates, organization author, publisher, canonical page URL, and featured image.
- Updated company and industry article prompts so Article JSON-LD dates refer to WordPress publication/modified dates instead of treating Make's article generation date as the final source of truth.
- Added SEO/GEO-oriented WordPress category descriptions for the main analysis and investor-education categories, and documented the live text in `seo/category-descriptions.md`.
- Audited old company-analysis articles against the new company-analysis category. 12 old posts currently match a newer article by stock code; all 12 now show the update box, `noindex`, and a canonical link to the latest article. 88 old posts do not yet have a matching new-category article. Results are stored in `seo-audits/old-to-new-company-analysis-audit.md`.

## 2026-04-26
- Added externalized industry analysis article prompt at `prompts/article/industry_analysis_article_main.md`
- Added a GitHub-managed mirror of the current Make-direct industry analysis memo prompt at `prompts/article/industry_analysis_memo_main.md`
- Added GitHub-managed mirrors for the industry trend-list generation prompt and the trend validation/formatting prompt
- Added a GitHub-managed mirror for the upstream industry news search-query generation prompt at `prompts/search/industry_news_query_generation_main.md`
- Strengthened the industry trend-list generation prompt so duplicate risk, distant macro spillovers, and driver-type mismatches are handled earlier upstream
- Tightened the trend-list prompt to prefer listed Japanese companies in `key_companies`, avoid `価格転嫁` for policy/FX themes, and forbid closing summaries in output
- Finalized the scenario-1 trend-list prompt with stricter upstream handling for duplicate-risk themes and weaker use of `売上成長` / `需給逼迫` on slowdown-driven topics
- Added explicit forced-duplicate and narrowed `要確認` rules so same-company same-event themes are classified as duplicate upstream
- Updated the industry trend-list prompt to reference `{{34.existing_titles_clean}}` for deduplicated existing-article titles from Make
- Tightened the industry trend validation prompt to delete weak duplicate themes more aggressively and constrain `affected_industries`
- Further tightened the industry trend validation prompt to drop most `C` themes, handle mixed-impact themes more strictly, and enforce `driver_type` alignment
- Locked duplicate themes so they cannot be promoted back from `C`, improved driver-type handling for FX/rates/supply-chain themes, and kept `key_companies` focused on listed Japanese companies
- Tightened company-name normalization and raised the deletion bar for macro themes whose impact on Japanese companies is too indirect
- Tightened `affected_industries` formatting and raised the deletion bar for weak `B` themes without clear first-order impact on Japanese companies
- Further refined driver-type correction for risk-normalization and demand-slowdown themes, and made mixed-impact themes easier to drop when the article axis is too diffuse
- Finalized `prompts/article/industry_analysis_trend_validation_main.md` by reverting to the best-performing validated version from `6cfa97d` after later tightening proved too aggressive
- Refined the memo prompt's leading-indicator query rules to prioritize market and industry indicators over redundant company-IR lookups
- Tightened the memo prompt ending rules to forbid disclaimers or extra notes before `SPLIT_HERE`
- Updated the industry analysis article prompt to align with SEO/GEO guidance, including early conclusion structure, FAQ fit, source visibility, and time-stamped market indicators
- Split `この記事でわかること` into a lighter `takeaways-box` for both industry and company article prompts so it is visually distinct from the stronger `この記事の結論` summary box
- Added `takeaways-box` styling to `wordpress/css/custom.css` so article takeaways render with a lighter visual weight than the main conclusion box
- Standardized article-end disclaimer guidance so both industry and company prompts state that AI is used to organize source materials and that FIC reviews and edits before publication
- Added `make/scenarios/industry_analysis_flow.md` to document the recommended Make integration for the externalized industry analysis article prompt
- Adjusted the industry analysis article prompt to be instruction-only so Make can append runtime fields in the same pattern as the company analysis flow
- Tightened the industry analysis article prompt after a live run to stabilize summary-box structure, restrict `<mark>` placement, reduce over-assertive hypothesis wording, and require `keywords` in Article schema
- Updated the memo prompt to explicitly treat scenario-1 fields as provisional, keep reverse-windfall themes from forcing weak benefit names, and prefer internally consistent numeric series
- Updated the article prompt to allow `直接恩恵：該当なし` on reverse themes, prefer first-order/source-backed company selection over weak carryover from the memo, enforce more consistent numeric series, and fix Article schema `keywords` to string format
- Added `prompts/social/x_post_industry_analysis_main.md` as the managed final prompt for the industry-analysis X post generator, preserving the old version's stopping power while reducing stiffness and over-explanation
- Tightened the industry X-post prompt so `post3` stays on a single causal chain and `post4` ends in fewer lines with only one follow-up point
- Finalized the industry X-post prompt by reverting to the better-performing balanced version from `3f78b0b`, which preserved stronger stopping power while staying natural enough for X
- Restored a single fixed hashtag on industry X posts by requiring `#日本株` at the end of each post
- Tightened `post3` in the industry X-post prompt so the causal chain ends on a single company, sector, or outcome without adding a second axis
- Further tightened the industry X-post prompt so `post3` does not cram both upside and downside into one post and `post4` keeps to a single question without stacking extra angles
- Nudged the industry X-post prompt back toward the stronger old style for `post3` and `post4`, emphasizing purer causal chains and stronger number-led questions
- Further strengthened industry `post4` to prefer a single number-led hook and shorter fragment-style follow-up instead of explanatory phrasing
- Moved industry `post4` even closer to the older high-performing style: single number hook, `この数字、意味わかりますか？`, then up to two short fragments before the CTA
- Added `prompts/social/x_post_company_analysis_main.md` as the managed final prompt for the company-analysis X post generator, aligned with the stronger stop-scroll structure used for industry-analysis posts while tailoring output to company-specific drivers
- Reworked `prompts/social/x_post_company_analysis_main.md` to be old-prompt-first: stronger reverse-angle openings, sharper numeric contrast, and tighter company-specific risk/driver framing
- Pushed the company-analysis X-post prompt further toward the original high-performing style by preferring `会社名＝〇〇ではない` openings, downside-led causal chains, and single-number question hooks
- Moved company-analysis posts even closer to the original best-performing style by making `post2` prefer same-definition short numeric contrasts and reinforcing the classic `post4` single-number hook pattern
- Finalized the company-analysis X-post prompt by requiring `#日本株` plus a company-name hashtag so posts remain attributable even when the company name is less prominent in the body
- Standardized future article openings around a fixed `30秒要約` `summary-box` for both company and industry analysis articles, with item labels optimized for quick reader scanning and answer-engine extraction
- Tightened article title, description, and citation guidance so future Make outputs use shorter SEO-oriented titles and link/date-backed reference lists
- Applied selected SEO/GEO audit improvements: stronger About/editorial policy signals, live `llms.txt`, tag archive `noindex, follow`, and Article schema `about`/`citation` guidance for future outputs
- Added a Diver footer gap fix to remove the large blank area caused by the hidden search modal rendering below the footer

## 2026-04-24
- Created repository foundation files for prompt, Make, WordPress, SEO, and docs structure
- Added initial README and AGENTS instructions
- Added SEO introduction rules with two-layer article guidance
- Added initial Make flow and field definitions
- Added initial roadmap and repository rules
- 2026-04-27: `docs/about_page_final.md` と `docs/editorial_policy_final.md` を更新し、公認会計士としての視点とAI活用・公開前確認の文言を整備。あわせて `docs/sidebar_profile_text_final.md` を追加。
