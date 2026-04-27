# Change Log

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

## 2026-04-24
- Created repository foundation files for prompt, Make, WordPress, SEO, and docs structure
- Added initial README and AGENTS instructions
- Added SEO introduction rules with two-layer article guidance
- Added initial Make flow and field definitions
- Added initial roadmap and repository rules
- 2026-04-27: `docs/about_page_final.md` と `docs/editorial_policy_final.md` を更新し、公認会計士としての視点とAI活用・公開前確認の文言を整備。あわせて `docs/sidebar_profile_text_final.md` を追加。
