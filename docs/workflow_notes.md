# Workflow Notes

## Industry Analysis Flow

- The article generation module reads the GitHub-managed prompt file `prompts/article/industry_analysis_article_main.md`.
- The memo generation module is operated as Make direct input, with the same prompt mirrored in `prompts/article/industry_analysis_memo_main.md`.
- The trend list generation module is operated as Make direct input, with the same prompt mirrored in `prompts/article/industry_analysis_trend_list_main.md`.
- The trend validation module is operated as Make direct input, with the same prompt mirrored in `prompts/article/industry_analysis_trend_validation_main.md`.

## Make Variable Notes

- Module 34 is a `Tools > Set variable` step for `existing_titles_clean`.
- Module 34 is not a prompt module.
- Module 34 currently uses:

```text
join(map(16.array; "0"); decodeURL("%0A"))
```

- The trend list generation prompt should reference `{{34.existing_titles_clean}}` for the existing article title list, not the raw `16.array`.

## Working Rules

- Do not assume module references from memory; verify the actual Make mapping before advising changes.
- Keep GitHub prompt mirrors aligned with real Make references when a prompt depends on module outputs.
- Treat the article generation module as GitHub-read, not Make direct text.
