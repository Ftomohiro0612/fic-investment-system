# FIC Navigation Measurement Events

Checked: 2026-05-23

## Events

| Event | Trigger | Main params | Verified |
| --- | --- | --- | --- |
| `fic_navigation_click` | Click on a link with `data-fic-area` | `fic_area`, `fic_label`, `link_url`, `page_location`, `fic_page_type`, `fic_page_path` | yes |
| `fic_search_submit` | Submit `.fic-home-search` or `.fic-hub-search` | `fic_area`, `fic_label`, `search_term`, `page_location`, `fic_page_type`, `fic_page_path` | yes |

## Production Verification

- Top page hero link click produced `fic_navigation_click` in `window.dataLayer` and the `fic:measurement` browser event.
- Company hub search for `キオクシア` produced `fic_search_submit` in `window.dataLayer` and the `fic:measurement` browser event.
- Company hub route links now use `company_hub_route` for industry/material groups.
- Theme hub route links now use `theme_hub_cluster` for the four lightweight theme-route groups.
- Learning hub route links now use `learning_hub_route` for before/on-day/deep-dive/risk reading groups.
- Earnings schedule guide route links now use `earnings_guide_route`, theme-context links use `earnings_guide_theme`, and company quick links use `earnings_guide_company`.
- Article context links, reading-guide bridge links, and bottom related-article links now use article-level `fic_area` values.
- Category archive guide links now use `category_archive_guide`.
- Both FIC custom events now include `fic_page_type` and `fic_page_path`.
- The script calls `gtag('event', ...)` when `window.gtag` exists.

## Page Types

| `fic_page_type` | Meaning |
| --- | --- |
| `home` | Top page |
| `hub_company` | `/companies/` |
| `hub_theme` | `/themes/` |
| `hub_learning` | `/learn/` |
| `earnings_schedule` | `/earnings-schedule/` |
| `category_theme_analysis` | Theme analysis category archive |
| `category_theme_reading` | Theme-reading category archive |
| `category_investment_reading` | Investment-reading category archive |
| `category_company_analysis` | Company-analysis category archive |
| `category` | Other category archive |
| `article` | Single post |
| `search` | Search result pages |
| `other` | Other pages |

## Key Areas

| `fic_area` | Surface | Meaning |
| --- | --- | --- |
| `home_quicknav` | `/` | Top-page internal anchor navigation |
| `home_purpose_route` | `/` | Top-page overview cards for the four purpose-route hubs |
| `home_search_chip` | `/` | Top-page direct chips to representative theme and earnings guides |
| `home_market_trigger` | `/` | Top-page market-trigger cards linking to representative theme-reading guides |
| `company_hub_search_chip` | `/companies/` | Representative company quick links under company search |
| `company_hub_route` | `/companies/` | Industry/material company-route links |
| `company_hub_latest` | `/companies/` | Latest company-analysis article cards |
| `theme_hub_search_chip` | `/themes/` | Quick chips under the theme search box |
| `theme_hub_trigger` | `/themes/` | Main material cards such as rates, FX, raw materials, semiconductors, policy, energy |
| `theme_hub_cluster` | `/themes/` | Lightweight theme-route links grouped by macro, cost, investment, and demand |
| `theme_hub_reading` | `/themes/` | Individual theme-reading guide cards |
| `theme_hub_latest` | `/themes/` | Latest theme-analysis article cards |
| `learning_hub_route` | `/learn/` | Use-case reading routes for earnings and KPI basics |
| `learning_hub_reading` | `/learn/` | Core investment-reading guide cards |
| `learning_hub_latest` | `/learn/` | Latest investment-reading article cards |
| `earnings_guide_action` | `/earnings-schedule/` | Primary actions to company search or earnings-release guide |
| `earnings_guide_card` | `/earnings-schedule/` | Core decision cards for progress rate, margin, and next KPIs |
| `earnings_guide_route` | `/earnings-schedule/` | Before/on-day/after earnings reading routes |
| `earnings_guide_theme` | `/earnings-schedule/` | Theme-context links used while reading earnings |
| `earnings_guide_company` | `/earnings-schedule/` | Representative company-analysis quick links |
| `earnings_guide_search` | `/earnings-schedule/` | Company-name/ticker search button |
| `article_context_link` | Single article pages | Inline links inside the "この分析を読む補助線" paragraph |
| `article_bridge_hub` | Single company/theme analysis pages | Hub link in the reading-guide bridge block |
| `article_bridge_card` | Single company/theme analysis pages | Reading-guide cards in the bridge block |
| `article_related_card` | Single article pages | Bottom same-category next-read article cards |
| `article_related_archive` | Single article pages | Bottom category archive button |
| `article_related_hub` | Single article pages | Bottom purpose-hub button |
| `category_archive_guide` | Main category archive pages | Guide links from category archives back to purpose hubs and adjacent categories |

## Analytics UI Follow-up

Confirm in GA4 or GTM preview that the following custom events are received:

- `fic_navigation_click`
- `fic_search_submit`

Recommended GA4 custom dimensions:

- `fic_area`
- `fic_label`
- `link_url`
- `search_term`
- `fic_page_type`
- `fic_page_path`

Recommended first reports:

- Theme route clicks: filter `fic_area = theme_hub_cluster`, group by `fic_label`.
- Top purpose-route clicks: filter `fic_area = home_purpose_route`, group by `fic_label`.
- Top search-chip clicks: filter `fic_area = home_search_chip`, group by `fic_label`.
- Top market-trigger clicks: filter `fic_area = home_market_trigger`, group by `fic_label`.
- Company route clicks: filter `fic_area = company_hub_route`, group by `fic_label`.
- Material-card clicks: filter `fic_area = theme_hub_trigger`, group by `fic_label`.
- Learning route clicks: filter `fic_area = learning_hub_route`, group by `fic_label`.
- Earnings reading-route clicks: filter `fic_area = earnings_guide_route`, group by `fic_label`.
- Earnings theme-context clicks: filter `fic_area = earnings_guide_theme`, group by `fic_label`.
- Earnings company clicks: filter `fic_area = earnings_guide_company`, group by `fic_label`.
- Article related clicks: filter `fic_area` starts with `article_`, group by `fic_area` and `fic_label`.
- Category archive guide clicks: filter `fic_area = category_archive_guide`, group by `fic_label`.
- Search submits: event `fic_search_submit`, group by `fic_area` and `search_term`.
- Page-type split: group `fic_navigation_click` by `fic_page_type`, then drill into `fic_area`.

## Coverage Audit

Production `data-fic-area` coverage can be checked without GA4 access:

```powershell
node scripts\audit_fic_measurement_coverage.mjs
```

Latest outputs:

```text
work\fic-measurement-coverage.json
work\fic-measurement-coverage.csv
work\fic-measurement-coverage.md
```

The audit distinguishes static link attributes from dynamic areas inserted by production JavaScript, such as `category_archive_guide`, `search_assist`, and `mobile_purpose_menu`.
