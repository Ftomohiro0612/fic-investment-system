# Change Log

## 2026-05-06
- Updated the shared WordPress table CSS so company and industry article tables wrap inside the article width on desktop, with mobile horizontal scrolling retained.
- Tightened company and industry article prompts to forbid inline table width styling and to keep multi-column table headings/cells short enough for the shared responsive table CSS.
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
