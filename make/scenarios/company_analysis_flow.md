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
- Intro rules
- Summary rules
- Internal link rules
- Output format rules

## Planned Improvements
- Separate intro, summary, body, and CTA prompts
- Add SEO review step before publish
- Add internal link suggestion step
- Add output validation step
- Support A/B testing for introduction patterns

## Operational Principle
Keep Make responsible for orchestration, not for storing long prompt logic.
