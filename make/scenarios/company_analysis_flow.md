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
