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

## Future Optional Externalization
After the article-writing step is stable, consider externalizing:

- the industry memo-generation prompt
- the trend-selection prompt
- any shared FAQ / schema / formatting rules if they begin to diverge across flows
