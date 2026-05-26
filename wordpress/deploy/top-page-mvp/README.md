# FIC Top Page MVP Deploy Package

Generated: 2026-05-24 13:37:46

## 1. Code Snippets

For the Code Snippets plugin, use the files in `code-snippets-paste/` first.
These files omit the opening `<?php` tag.

### FIC: Home page MVP shortcode

- Paste: `code-snippets-paste/fic-home-page-mvp-no-open-tag.php`
- Shortcode: `[fic_home_mvp]`

### FIC: Purpose hub shortcodes

- Paste: `code-snippets-paste/fic-hub-pages-no-open-tag.php`
- Shortcodes: `[fic_company_hub]`, `[fic_theme_hub]`, `[fic_learning_hub]`

### FIC: Category bridge internal links

- Paste: `code-snippets-paste/fic-category-bridge-links-no-open-tag.php`
- Adds reading-guide context links and category bridge blocks to company/theme articles.

### FIC: Navigation measurement events

- Paste: `code-snippets-paste/fic-navigation-measurement-no-open-tag.php`
- Sends `fic_navigation_click` and `fic_search_submit` events.

### FIC: Earnings schedule page guide

- Paste: `code-snippets-paste/fic-earnings-page-guide-no-open-tag.php`
- Adds the guide section above `/earnings-schedule/`.

Original PHP files with the opening `<?php` tag are preserved in `code-snippets/` for file-based use.

## 2. CSS

Paste this file into WordPress Additional CSS or the active theme CSS:

- `css/fic-home-page-mvp.css`

## 3. Logo Asset

Upload or place these files:

- `assets/fic-logo-header-dark-transparent.png`
- `assets/fic-logo-header-white-transparent.png`

Use the dark logo on the white site header. Keep the white logo only as a spare asset for dark-background placements.
If the Diver header image cannot be changed directly, keep the managed CSS replacement that maps the old header image URL to the dark logo URL.

## 4. Fixed Pages

Use the small text files in `fixed-page-bodies/` when creating or updating WordPress pages.

| Page | URL | Body |
| --- | --- | --- |
| Top page | existing top page | `fixed-page-bodies/top-page.txt` |
| Company hub | `/companies/` | `fixed-page-bodies/companies.txt` |
| Theme hub | `/themes/` | `fixed-page-bodies/themes.txt` |
| Learning hub | `/learn/` | `fixed-page-bodies/learn.txt` |

Recommended menu: `fixed-page-bodies/recommended-menu.md`

## 5. Local Preview

Start:

```powershell
powershell -ExecutionPolicy Bypass -File scripts\start_top_page_preview.ps1 -Restart
```

Open:

- http://127.0.0.1:4291/previews/index.html
- http://127.0.0.1:4291/previews/responsive-qa.html

## 6. Local Verification

Run:

```powershell
powershell -ExecutionPolicy Bypass -File scripts\verify_top_page_mvp.ps1
```

If PHP CLI is not installed, only `php -l` is skipped. The other checks still verify the local package basics.

For Japanese admin-screen instructions, see `docs/top_page_admin_runbook.md`.
For broader publication notes, see `docs/top_page_publication_playbook.md` in this package.
For phase-1 article publishing, see `docs/phase1_wordpress_publish_checklist.md` and `docs/phase1_publication_matrix.md`.
For post-launch click measurement, see `docs/top_page_measurement_plan.md`.
For legacy navigation cleanup, see `docs/top_page_legacy_cleanup_plan.md`.
For content growth priorities, see `docs/top_page_content_growth_plan.md`.
