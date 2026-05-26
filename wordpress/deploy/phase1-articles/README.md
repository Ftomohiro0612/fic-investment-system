# FIC Phase 1 Article Publish Package

Generated: 2026-05-22 22:56:52

## Contents

- `bodies/`: WordPress-ready article HTML. The leading management metadata comment has been removed.
- `eyecatch/`: Per-article featured images.
- `metadata/phase1-article-upload.csv`: title, slug, category, description, body file, and image file.
- `metadata/phase1-article-publish-tracker.csv`: batch-by-batch publishing tracker with status and published URL fields.
- `previews/`: local static preview pages for all articles.
- `docs/phase1_publication_matrix.md`: source publication matrix.
- `docs/phase1_wordpress_publish_checklist.md`: publishing order and checks.

## Recommended Workflow

1. Follow the batches in `docs/phase1_wordpress_publish_checklist.md`.
2. Use `metadata/phase1-article-upload.csv` to confirm title, slug, category, and description.
3. Paste the matching file from `bodies/` into the WordPress post body.
4. Set the matching PNG from `eyecatch/` as the featured image.
5. Track status and published URLs in `metadata/phase1-article-publish-tracker.csv` or `docs/phase1_wordpress_publish_checklist.md`.

## Local Preview

After starting the local preview server, open:

- http://127.0.0.1:4291/deploy/phase1-articles/previews/index.html

## Counts

- Total articles: 23
- Investment reading: 12
- Theme reading: 11
