# Company Analysis Flow

## Purpose
Generate a company analysis article using Make and externalized prompts stored in GitHub.

## Current Target Design
1. Input company data and integrated research memo
2. Load prompt files from GitHub
3. Combine prompt components
4. Send compiled prompt to the LLM
5. Receive article output
6. Store output for review
7. Publish approved output to WordPress

## Prompt Components
- Main article instruction
- Article intro rules
- Article output rules
- Intro rules
- Summary rules
- Internal link rules
- Output format rules

## Planned Improvements
- Separate article intro, summary, body, CTA, and output prompts
- Add SEO review step before publish
- Add internal link suggestion step
- Add output validation step
- Support A/B testing for introduction patterns

## Operational Principle
Keep Make responsible for orchestration, not for storing long prompt logic.

## Recommended First GitHub-Loaded Files
To avoid increasing Make complexity too quickly, start by loading only this compiled file from GitHub:
- `prompts/article/company_analysis_article_compiled.md`

This compiled file should be kept in sync whenever these source files change:
- `prompts/article/company_analysis_article_main.md`
- `prompts/article/company_analysis_article_intro_rules.md`
- `prompts/article/company_analysis_article_output_rules.md`

After the article generation path is stable, consider loading:
- `prompts/article/company_analysis_memo_main.md`
- `prompts/article/company_analysis_pdf_summary.md`

## Image Creation And Publishing Review
Before creating the article image and publishing, Codex should review the generated article body and make small editorial fixes when needed. This review belongs in the image creation and posting workflow, so Make does not need an extra module for every minor article-quality issue.

Check especially:

- Remove unfinished-looking expressions such as `不明`, `確認中`, `要確認`, and `取得できず` from public-facing summaries, tables, forecasts, and FAQ.
- If a numeric value cannot be confirmed, do not invent it. Replace it with the specific source the reader should check, such as `企業IRの月次資料で確認が必要`, `決算説明資料の次回更新で確認が必要`, or `公的統計・業界団体統計で確認が必要`.
- Soften overly strong impact labels when the effect depends on contract structure, hedging, customer mix, segment exposure, or accounting treatment.
- Correct awkward or inaccurate business-model wording before publication.
- Add a short latest-status note only when the article body, memo, or search results clearly support it. Do not add fresh news from inference alone.
- Keep title, 30-second summary, tables, forecasts, FAQ, references, and Article schema consistent after any body edits.
