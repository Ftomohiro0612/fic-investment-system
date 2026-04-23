# Article Generation Overview

## Goal
Explain how article generation is orchestrated through Make while prompt logic remains managed in GitHub.

## Principle
Make should combine inputs, load prompt files, call the LLM, and route outputs.
It should not become the long-term home for editorial logic.

## Core Building Blocks
- Input fields
- Prompt files
- LLM call
- Review output
- WordPress publishing handoff
