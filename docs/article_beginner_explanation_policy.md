# Article Beginner Explanation Policy

## Purpose

FIC articles should keep the depth of an analyst note while becoming easier for newer readers to follow. The goal is not to simplify the analysis itself. The goal is to add short guide rails so readers understand why each number, KPI, and theme matters.

## Required Writing Moves

- Explain the meaning of important terms at first use, either in the same paragraph or in a short `beginner-box`.
- Add one sentence on why a number matters when using sales, operating margin, backlog, inventory, FX, rates, segments, guidance, or progress rate.
- Turn number lists into interpretation: what is good, what is risky, and what to check next.
- Use a calm `です・ます` tone. Avoid hype, investment recommendations, and overly casual phrasing.
- Add a reader guide sentence at the start or end of key H2 sections when the section may feel technical.

## Heading Hierarchy

- H2 is for the reader's major question or chapter role.
- H3 is for checkpoints inside that H2, not for independent chapters.
- If one H2 contains multiple arguments, multiple tables, or a long explanation, split it with H3 headings.
- Do not create many short H2 sections in a row. Merge nearby topics under one H2 and organize them with H3.
- Keep FAQ question H3 headings separate from analysis H3 headings.

## Audit

Run `node scripts/audit_article_heading_hierarchy.mjs` after generating article HTML. The audit flags H2 sections that have no H3 even though they contain long text or multiple tables. Review items are written to `work/article-heading-hierarchy-audit.md` and `work/article-heading-hierarchy-audit.csv`.

## Example Tone

```html
<div class="beginner-box">
  <p><strong>ワンポイント解説：営業利益率を見る理由</strong></p>
  <p>営業利益率は、売上のうちどれだけ利益として残ったかを見る指標です。売上が伸びていても、原材料費や人件費がそれ以上に増えれば利益率は下がります。</p>
</div>
```

```html
<div class="beginner-box term-box">
  <p><strong>用語メモ：受注残とは</strong></p>
  <p>受注残は、まだ売上になっていない将来の仕事量を見る数字です。増えていれば先の売上を読む手がかりになりますが、納期遅れやキャンセルリスクもあわせて確認します。</p>
</div>
```

## Do Not

- Do not reduce source-backed analysis just to make the article shorter.
- Do not add broad textbook explanations that are disconnected from the company or theme.
- Do not make unverified future claims inside beginner explanations.
- Do not use beginner explanations as investment advice.
