# Change Log

## 2026-04-26
- Added externalized industry analysis article prompt at `prompts/article/industry_analysis_article_main.md`
- Added a GitHub-managed mirror of the current Make-direct industry analysis memo prompt at `prompts/article/industry_analysis_memo_main.md`
- Added GitHub-managed mirrors for the industry trend-list generation prompt and the trend validation/formatting prompt
- Added a GitHub-managed mirror for the upstream industry news search-query generation prompt at `prompts/search/industry_news_query_generation_main.md`
- Tightened the industry trend validation prompt to delete weak duplicate themes more aggressively and constrain `affected_industries`
- Further tightened the industry trend validation prompt to drop most `C` themes, handle mixed-impact themes more strictly, and enforce `driver_type` alignment
- Refined the memo prompt's leading-indicator query rules to prioritize market and industry indicators over redundant company-IR lookups
- Tightened the memo prompt ending rules to forbid disclaimers or extra notes before `SPLIT_HERE`
- Updated the industry analysis article prompt to align with SEO/GEO guidance, including early conclusion structure, FAQ fit, source visibility, and time-stamped market indicators
- Added `make/scenarios/industry_analysis_flow.md` to document the recommended Make integration for the externalized industry analysis article prompt
- Adjusted the industry analysis article prompt to be instruction-only so Make can append runtime fields in the same pattern as the company analysis flow
- Tightened the industry analysis article prompt after a live run to stabilize summary-box structure, restrict `<mark>` placement, reduce over-assertive hypothesis wording, and require `keywords` in Article schema

## 2026-04-24
- Created repository foundation files for prompt, Make, WordPress, SEO, and docs structure
- Added initial README and AGENTS instructions
- Added SEO introduction rules with two-layer article guidance
- Added initial Make flow and field definitions
- Added initial roadmap and repository rules
