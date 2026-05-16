# WordPress Media Cleanup Policy

## Purpose

Company and industry analysis articles often require multiple image drafts, replacements, and WordPress updates. The WordPress media library and local work folders should not keep unused article image versions after a final article update.

## Rule

- When Codex uploads article images to WordPress, only images used by the final published article, featured image, X post plan, or video plan should remain in the WordPress media library.
- If an image is replaced, rejected, duplicated, or uploaded for a mistakenly created duplicate post, Codex must delete the unused WordPress media item after confirming the final article update.
- Local image files should follow the same practical rule: after WordPress upload and final article confirmation, keep the adopted final image files and delete old versions, rejected drafts, duplicate exports, and replaced images.
- Do not delete reference images under `docs/reference_images/` or reusable design assets unless the user explicitly asks.

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
5. Delete local old image versions from the current article's image work folder when they are clearly not the adopted final versions.
6. Record the result in `AS` or the workflow result JSON:
   - `unusedMediaDeleted: [...]`, or
   - `unusedMediaDeleted: none`.
   - `localOldImagesDeleted: [...]`, or
   - `localOldImagesDeleted: none`.

## Important Exceptions

- Do not delete an existing featured image unless the user explicitly asks to replace or remove it.
- Do not delete images that are used by another published post.
- If unsure whether an image is reused elsewhere, leave it and record `要確認`.
- Do not delete source/reference images that are intentionally kept for future image prompting.

