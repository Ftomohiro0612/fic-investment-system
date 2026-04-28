Create a short summary block that appears near the top of the article.

## Goal
Help readers quickly understand the investment relevance before reading the full analysis.

## Requirements
- Use 3 to 5 bullet points
- Focus on earnings drivers, risks, valuation context, or key watch points
- Keep each bullet specific and actionable
- Avoid repeating generic statements from the title
- Do not restate quarter-end composition ratios as if they were full-year ratios
- If a bullet uses a composition ratio from `4Q時点`, keep that time scope in the same bullet
- Do not use phrases such as `profits are determined by` or `sales gains flow almost directly to profit`; use softer phrasing unless the source explicitly supports it
- If a bullet uses 65.7% or a similar quarter-end overseas composition ratio, keep 4Q時点 or 四半期末時点 in the same bullet
- Do not write ~で決まる-style summary phrasing; prefer ~に左右されやすい or ~が主要因
- Keep 社数, 拠点数, and 国数 distinct when summarizing customer base scale; do not rewrite 拠点 as 社
- If guidance is not disclosed, say so directly instead of calling the latest results a de facto guidance
- Do not assume `2025年度` means `2026年3月期` for every company; determine the fiscal year from the source material and the company's fiscal year-end month
- For March-year-end companies, `2025年度` may correspond to `2025年4月〜2026年3月 = 2026年3月期`; use this only as an example, not as a universal rule
- Do not rewrite `2025年度` as `2025年3月期`; if needed, clarify the exact fiscal period based on the source material and the company's fiscal year-end month
- If the source uses `billion yen` or `JPY B`, convert to Japanese `億円` only after multiplying by 10; never output `1,128.6億円` when the source is `1,128.6 billion yen`
- Do not call product/category breakdowns `セグメント` unless they match the company's official reporting segments
- If a profit jump includes one-off items such as impairment reversals, financial income, or divestiture gains, do not summarize it as purely structural improvement
- If using historical or regional numbers from an integrated report, do not present them as the latest actuals when newer earnings materials exist

## Reader Intent
- Make the block useful for skimming readers
- Make it complementary to the introduction, not redundant
