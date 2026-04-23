# Agent Instructions

## Project Context
This repository supports fic-investment.biz, a WordPress-based investment analysis site.
It also manages the prompt system used in Make for article generation and SEO improvement.

## Objectives
- Improve SEO performance
- Improve article readability without losing analytical depth
- Refactor prompts into reusable components
- Keep Make simple by externalizing prompt logic into GitHub-managed files
- Improve WordPress templates and snippets for article UX

## Priorities
1. SEO improvements with high impact
2. Prompt modularization
3. WordPress readability and structure improvements
4. Maintainability and simple workflows

## Important Content Principles
- Do not make the writing shallow just to simplify it
- Preserve the site's analytical differentiation
- Improve introductions, summaries, and structure before rewriting entire articles
- Prefer a two-layer structure: beginner-friendly entry plus advanced analytical depth
- Strengthen internal linking based on reader intent, not just keyword overlap

## Coding Principles
- Do not break existing behavior without explanation
- Show clear before and after reasoning
- Prefer small, safe, reversible changes
- Reuse components where possible

## Prompt Design Principles
- Separate reusable prompt blocks
- Avoid giant monolithic prompts
- Keep SEO rules separate from article logic
- Make output format explicit
- Design prompts so that intro, summary, body, and internal links can be tested independently

## When Analyzing the Repository
Always identify:
1. Current bottlenecks
2. High-impact low-risk improvements
3. Reusable systems that reduce future manual work

## Content System Heuristics
- Put the conclusion early
- Explain what the reader will learn before deep analysis
- Add a short summary block near the top
- Use internal links to move readers from beginner topics to deeper related analysis
