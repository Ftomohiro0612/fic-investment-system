# Repository Rules

## Purpose
Keep this repository easy to operate, safe to change, and useful for both humans and coding agents.

## General Rules
- Prefer small, reversible changes
- Document why a change is needed, not only what changed
- Keep source-of-truth prompt logic in repository files, not embedded in Make
- Avoid duplicating the same rule across multiple prompt files

## Prompt Rules
- Separate article logic from SEO rules
- Keep intro, summary, and output format independently editable
- Add new prompt files only when they represent a reusable responsibility

## WordPress Rules
- Document target templates before modifying snippets
- Prefer reusable snippets over one-off post-level fixes
- Keep presentation concerns in CSS and structure concerns in PHP or template logic

## SEO Rules
- Prioritize search intent alignment over cosmetic wording changes
- Put the conclusion early in investment articles
- Design internal links to guide the next best read for the user

## GEO Rules
- Optimize for answer-engine extractability without reducing analytical depth
- Make key entities, drivers, and investor conclusions explicit early
- Keep visible FAQ answers and schema answers aligned
- Separate confirmed facts from estimates clearly

## Documentation Rules
- Update roadmap when priorities materially change
- Add major structural decisions to the change log
