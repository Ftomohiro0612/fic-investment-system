# GEO Optimization Notes

## Purpose
This document defines how fic-investment.biz should improve GEO (Generative Engine Optimization) alongside traditional SEO.

GEO here means making articles easier for AI systems, search assistants, and answer engines to:
- identify the main conclusion quickly
- extract reliable facts and relationships
- quote or summarize the article accurately
- understand why the article is authoritative for investor use cases

## Core Principle
Do not make articles shallow for GEO.

The goal is to preserve analytical depth while making the structure easier for both readers and answer engines to understand.

## GEO Priority Areas
1. Put the conclusion early
2. State what the company earns from and what variables matter
3. Make entity relationships explicit
4. Separate confirmed facts from estimates
5. Use current numbers with clear provenance
6. Add FAQ-style direct answers for likely investor questions

## What Answer Engines Need
Answer engines tend to perform better when an article includes:
- a short early summary of the main thesis
- clear named entities such as company names, segments, products, customers, competitors, and macro drivers
- strong causal wording such as "X drives Y because Z"
- short direct answers before deeper explanation
- structured tables that pair metrics with meaning
- consistent terminology across summary, body, FAQ, and schema

## Required GEO Structure For Company Analysis

### 1. One-Line Summary
- Must appear at the top
- Must explain what variables determine earnings
- Should be specific enough that it can stand alone in an AI summary

Example pattern:
- "Company X is a business whose earnings are driven by A, B, and C"

### 2. Definition Lead
- Immediately after the one-line summary
- Explain what the article will clarify and why it matters
- Keep it short and concrete

### 3. Summary Box
- Tell the reader what they will learn
- Use 2 to 3 bullets only
- Prefer investor questions over generic overview bullets

### 4. Early Entity Framing
- Identify the key segments, customers, and demand drivers early
- Name real entities whenever the source material supports it
- Prefer explicit relationships such as:
  - "WM serves affluent households"
  - "WS revenue depends on institutional trading activity"
  - "IM revenue rises with AUM growth"

### 5. FAQ Section
- Include 3 direct investor-style questions
- Answers must start with the conclusion in the first sentence
- FAQ wording should reflect realistic search and answer-engine prompts

## GEO Writing Rules

### Put the short answer first
- The first useful paragraph should answer the likely query, not introduce the company in generic terms
- Avoid long scene-setting intros

### Prefer explicit causality
- Use phrasing that makes relationships easy to extract
- Good:
  - "Higher AUM increases management fees because fees are charged on assets under management"
- Weak:
  - "AUM is important for the business"

### Prefer named entities over vague categories
- Good:
  - "regional banks such as Hyakugo Bank and Sanin Godo Bank"
- Weak:
  - "financial partners"

### Distinguish facts from estimates
- If a value is estimated, mark it clearly
- Do not let estimates read like disclosed facts
- This is important for both reader trust and AI citation quality

### Keep terminology consistent
- Use the same label across:
  - one-line summary
  - section headers
  - tables
  - FAQ
  - schema
- Example:
  - do not alternate between "wealth", "retail", and "client assets" unless the distinctions are deliberate

## GEO Table Guidance
Use tables when they make extraction easier, not just for decoration.

High-value GEO tables:
- performance trend
- segment breakdown with customers
- driver formula table
- leading indicator table
- scenario table
- risk table

Each table should make the relationship between metric and meaning obvious.

Good table columns:
- metric
- current level
- recent change
- why it matters
- impact on revenue or profit

## GEO-Sensitive Content Patterns

### Strong patterns
- "The key question for investors is..."
- "Revenue rises when..."
- "The most important indicator is..."
- "This matters because..."
- "The company benefits when..."

### Weak patterns
- generic company introductions
- long history sections near the top
- unexplained jargon in the intro
- tables with numbers but no interpretation

## Source and Freshness Rules
- Prefer first-party IR sources whenever available
- If the article uses current macro or market indicators, include the current level and direction of change
- Make sure the latest value used in the body also appears in the leading indicator table
- If a number is old or uncertain, say so clearly rather than implying freshness

## GEO and Schema
- FAQPage schema should match the visible FAQ exactly
- Article schema headline should match the actual article title
- Article schema description should match the one-line summary in substance
- Dates must use the actual generation or publication date, not a guessed date

## GEO Review Checklist
Before publishing, confirm:
- Can the first screen explain what drives earnings?
- Can an AI system identify the top 3 drivers quickly?
- Are the core entities explicitly named?
- Are direct answers available for likely investor questions?
- Are facts and estimates clearly separated?
- Are the most important current indicators easy to extract?

## Current GEO Focus For This Repository
1. Improve top-of-article answers
2. Improve FAQ quality
3. Improve consistency between body and schema
4. Improve extractability of leading indicators
5. Improve internal links that move readers from beginner context to deeper analysis
