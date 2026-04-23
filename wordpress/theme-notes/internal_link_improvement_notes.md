# Internal Link Improvement Notes

## Current State
- Peer-company links are automatically inserted in comparison tables by `fic_link_peer_companies_in_comparison_section()`
- Earnings schedule cards and tables link to already-published articles by stock code
- Internal linking is strongest for structured tables, weaker for natural reading flow

## Current Strengths
- Existing published articles can be reused without manually editing each comparison table
- Link resolution is based on stock code in the slug, which is relatively stable
- The WordPress layer already handles part of the internal-link responsibility

## Main Gaps
- No automatic internal link block near the top of company analysis articles
- No guided "next read" flow for beginner-to-advanced progression
- Natural in-body contextual links are not systematically supported
- Internal links are concentrated in comparison sections rather than distributed across reader intent

## Recommended Priorities
1. Add a reusable top-of-article related-links block for company analysis pages
2. Add a bottom "related company / sector / explainer" block
3. Expand auto-linking beyond comparison tables, but keep it tightly scoped to avoid accidental links
4. Keep URL resolution in WordPress, not in the article-generation prompt

## Principle
The article prompt should decide where related reading is useful.
WordPress should decide how links are resolved and rendered.
