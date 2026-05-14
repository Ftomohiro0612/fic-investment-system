# Industry Analysis Flow

## Purpose
Generate a standalone industry analysis article using Make while keeping the article-writing prompt managed in GitHub.

## Current Recommended Design
1. Select an approved industry trend row from Google Sheets
2. Generate the industry analysis memo
3. Fetch the article-writing prompt from GitHub
4. Combine:
   - trend fields
   - industry analysis memo
   - latest leading-indicator data
   - GitHub-managed article prompt
5. Send the compiled prompt to the LLM
6. Store output for review
7. Publish approved output to WordPress

## Codex / Claude Code Migration Design

For the migration away from Make orchestration, split the workflow into two explicit scenarios:

1. Trend discovery
   - Codex gathers current news by category.
   - Codex uses a broader 14-query discovery pass, not the old narrow 8-query pass.
   - The discovery pass must cover AI/tech, macro/consumption, rates/banks/real estate, logistics/EC/service/tourism, geopolitics/energy, commodities/material costs, and corporate earnings/capex.
   - Codex produces `trend_candidates.md` and `trend_candidates_sheet.tsv`.
   - Codex writes 10-14 candidate rows to the industry analysis sheet B-M columns, with optional notes in N.
   - Candidate rows are not over-filtered; weak but observable themes may remain as C.
   - Duplicate checks label candidates instead of deleting them automatically.

2. Article generation
   - Codex reads an approved trend row.
   - Codex generates 12 search queries: definition/current level x2, impact path x2, beneficiary candidates x2, headwind candidates x1, risk/refutation x1, leading indicator x1, comparable past case x1, adjacent/secondary impact x1.
   - Codex creates `industry_analysis_input_pack.md`.
   - Claude Code creates `industry_analysis_memo.md`, `industry_analysis_article.html`, and `industry_analysis_review_notes.md`.
   - Codex reviews the article, creates/inserts the image, checks the existing WordPress post ID, and updates WordPress.

The canonical migration spec is:

- `docs/codex_industry_analysis_migration_spec.md`

Do not commit Make blueprint JSON files. They may contain credentials or Make-specific connection metadata.

## Recommended First GitHub-Loaded File
To keep Make simple, start by loading only this file from GitHub for the article-writing step:

- `prompts/article/industry_analysis_article_main.md`

## Why This File Was Externalized First
- This is the prompt block most likely to change during SEO / GEO tuning
- It controls introduction quality, FAQ fit, source visibility, and output structure
- It is safer to revise in GitHub than to keep editing long prompt text inside Make

## Operational Principle
Keep Make responsible for orchestration, not for storing long editorial logic.

## Notes For Make
- Preserve the existing output format:
  - `TITLE===`
  - `SLUG===`
  - `KEYWORDS===`
  - `BODY===`
- Do not reintroduce a JSON output requirement if Make expects the delimited text format above
- If the prompt is updated in GitHub, Make should automatically use the latest file contents without needing manual text edits inside the module

## Image Creation And Publishing Review
Before creating the article image and publishing, Codex should review the generated article body and make small editorial fixes when needed. This review belongs in the image creation and posting workflow, so Make does not need an extra module for every minor article-quality issue.

Check especially:

- Remove unfinished-looking expressions such as `不明`, `確認中`, `要確認`, and `取得できず` from public-facing summaries, tables, forecasts, and FAQ.
- If a numeric value cannot be confirmed, do not invent it. Replace it with the specific source the reader should check, such as `Platts JKM等の市況データで確認が必要`, `企業IRの月次資料で確認が必要`, or `公的統計の次回更新で確認が必要`.
- Soften overly strong impact labels, such as changing `直接恩恵・影響度大` to `条件付き・間接寄り・中〜大` when the effect depends on contract structure, hedging, inventory position, or segment exposure.
- Correct awkward or inaccurate business-model wording before publication. For example, use `短期スポット運賃感応型` instead of manufacturing-like wording such as `一発受注型` for LNG shipping exposure.
- Add a short latest-status note only when the article body, memo, or search results clearly support it. Do not add fresh news from inference alone.
- Keep title, 30-second summary, tables, forecasts, FAQ, references, and Article schema consistent after any body edits.

## Future Optional Externalization
After the article-writing step is stable, consider externalizing:

- the industry memo-generation prompt
- the trend-selection prompt
- any shared FAQ / schema / formatting rules if they begin to diverge across flows
