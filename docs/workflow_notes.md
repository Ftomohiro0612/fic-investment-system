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
- The Make scenario `X謚慕ｨｿ譁・ｫ閾ｪ蜍穂ｽ懈・・域･ｭ逡悟・譫撰ｼ荏 should use `prompts/social/x_post_industry_analysis_main.md` as the managed prompt source text.


## Company Analysis Prompt Notes

- prompts/article/company_analysis_article_main.md and prompts/article/company_analysis_memo_main.md now include explicit rules to prevent fiscal-period label mixups.
- Treat labels such as 2025年度, FY2025, 2025年3月期, and 2026年3月期 only after confirming the actual covered period.
- Explicitly note the common trap: 2025年度 is often 2025年4月?2026年3月, which means 2026年3月期, not 2025年3月期.
- Do not mix these concepts without an explicit label:
  - full-year results
  - standalone quarter results
  - quarter-end composition ratios
  - local-currency year-over-year growth rates
- Do not restate quarter-end composition ratios as if they were full-year composition ratios.
- Do not generalize a single quarter gross margin or operating margin into a permanent profit formula such as “profits are determined by gross margin times sales growth.”
- When explaining profit structure, check SG&A ratio, FX, product mix, regional mix, and non-operating items instead of reducing everything to one variable.
- Future logistics-center schedules, capacity-expansion claims, floor-area multiples, and similar project facts should only be stated definitively when confirmed in company primary materials.
- Third-party market forecasts must retain source identity, publication timing, and forecast target year; do not cite them only as external materials.
- If prompt rules are updated on main, mirror the operational implication in docs/workflow_notes.md in the same change set.
## Earnings Schedule UI Notes

- The earnings schedule status UI is shared conceptually between:
  - the top-page upcoming cards
  - the `/earnings-schedule/` table page
- Status badges are rendered by `wordpress/snippets/functions.php` via `fic_render_status_badge()`.
- The rendered badge HTML now assumes:
  - `<span class="fic-status-icon" aria-hidden="true"></span>`
  - `<span class="fic-status-label">...</span>`
- Do not reintroduce emoji directly into the status label strings such as `?` or `??`.
  - Icons are now handled visually by CSS.
  - Reintroducing emoji will cause duplicate icon rendering on the top-page cards.
- Badge styling is handled in `wordpress/css/custom.css`.
  - `.fic-upcoming-card .fic-status` covers the top-page card style.
  - `.fic-earnings-table .fic-status` covers the table-page style.
- If the earnings schedule page looks plain again in the future, first check whether:
  - `fic_render_status_badge()` is still outputting the `fic-status-icon` and `fic-status-label` spans
  - the status label strings remain plain text (`公開済み`, `更新予定`, `記事作成予定`)
  - the CSS selectors for both `.fic-upcoming-card` and `.fic-earnings-table` are still present
