# WordPress Media Cleanup Policy

## Purpose

Company analysis articles often require multiple image drafts, replacements, and WordPress updates. The WordPress media library should not keep unused article images after a final article update.

## Rule

- When Codex uploads article images to WordPress, only images used by the final published article, featured image, X post plan, or video plan should remain in the WordPress media library.
- If an image is replaced, rejected, duplicated, or uploaded for a mistakenly created duplicate post, Codex must delete the unused WordPress media item after confirming the final article update.
- Local image files in `work/company_analysis/<company>/images/` may remain as work history. This cleanup rule is for WordPress media library assets.

## Required Check Before Marking Complete

Before setting `AW=完了`, `AN=WordPress更新済み`, or `AP=完了`, Codex must:

1. Compare the previous WordPress content and final `AX` HTML.
2. Identify WordPress media URLs or IDs uploaded during the current workflow.
3. Keep images referenced by:
   - final WordPress article content,
   - featured media,
   - X post plan,
   - video creation plan.
4. Delete current-workflow uploaded images that are not referenced anywhere above.
5. Record the result in `AS` or the workflow result JSON:
   - `unusedMediaDeleted: [...]`, or
   - `unusedMediaDeleted: none`.

## Important Exceptions

- Do not delete an existing featured image unless the user explicitly asks to replace or remove it.
- Do not delete images that are used by another published post.
- If unsure whether an image is reused elsewhere, leave it and record `要確認`.

