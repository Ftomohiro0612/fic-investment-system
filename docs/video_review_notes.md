# Video Review Notes

## Role Split

- Shorts: entry hook, one strong finding, and routing to the long video.
- Long: article comprehension, causal map, leading indicators, scenarios, and article routing.
- Article: detailed explanation, search asset, and GEO asset.

## Shorts Dense Maps

- A dense final map can work when it is intentionally used as a teaser for the long video.
- In that case, judge the card by whether it signals that the long video contains the full structure, not by whether every small label is readable in Shorts.
- The main Shorts finding should still be understandable before the map appears.
- Caption and narration should make the role explicit, for example: `Detailed route in the long video`.

## Company Analysis Shorts

- Start with a question or misconception that tests the viewer's investment lens.
- Good pattern: `Are you buying this stock only by looking at X?`
- For company videos, compare revenue scale and profit contribution when they differ.
- This prevents the video from reducing the company to its most visible market indicator.

## NYK 9101 Tested Structure

- Core message: shipping stocks are not only freight-rate stories.
- Stable floor: automotive shipping and LNG long-term contracts.
- Volatility: ONE and container market conditions.
- Useful viewing order: stable profit floor first, then ONE volatility.
- Key indicators: SCFI, CCFI, automotive shipment volume, Hormuz, BDI, fuel, and FX.

## Production QA

- Review the high-bitrate `*-publish.mp4` file before upload.
- The tested export settings of roughly 10 Mbps for Shorts and 8 Mbps for long 1080p videos were sufficient for text-heavy cards.
- For chart-heavy Shorts, make sure the central takeaway is large enough even if the detailed chart labels are not fully readable.
- For long videos, make the main turning-point card visually stronger than the surrounding explanation cards.

## 2026-05-19 Company Video Lessons

- Use a dedicated text-free AI-generated thumbnail/background image for each video. The image should match the company theme and should be used both as the YouTube thumbnail base and as the soft video background.
- Standard thumbnail pattern: dark AI background, official FIC logo at top-left, large left-aligned short title, yellow accent, small category label at top-right, topic tags, and a bottom white takeaway strip. This follows the best-performing AI memory shortage thumbnail pattern. Do not replace the top-left logo with plain text.
- Do not make the video look like plain white presentation slides only. Use the AI background with blur/wash so text remains readable.
- If article AI diagrams or maps are used in the long video, the narration must explain how to read the diagram, including the viewing order and what each block means.
- Shorts do not need article AI-generated diagrams. Prefer simple, instantly readable cards with the main finding and three check points. Keep AI diagrams mainly for the long video where narration can explain how to read them.
- Avoid boxes with only keywords. Put a short beginner-friendly explanation inside each box.
- Avoid color-only circles, squares, or legends. If a marker has meaning, write the meaning directly as a heading or label.
- Keep badges and labels away from YouTube overlay areas. Leave enough top/right margin.
- Use Edge TTS `ja-JP-NanamiNeural` as the standard voice. Keep a reading dictionary for terms such as `粗利益 -> あらりえき`, `王子HD -> 王子ホールディングス`, `LBKP -> エルビーケーピー`, and `M&A -> エムアンドエー`.
- Prefer faster narration for YouTube. Current useful baseline: Shorts `rate=+15%`, long `rate=+10%`.
- Target length after the 2026-05-20 batch QA: Shorts should usually land around 50-60 seconds so the hook, thesis, check points, and CTA do not feel rushed. Long company analysis videos can use the Oji Holdings pattern at around 3:00-3:45 when the story is tight; expand to 4:00-4:45 when extra diagram explanation or company context is needed.
- For both Shorts and long videos, do not generate one full narration file and proportionally scale scene durations. Generate TTS per scene and set each visual scene duration from its audio segment to avoid voice/screen mismatch.
- Do not include the final spoken/on-screen disclaimer line in the video body. Keep the pacing clean; put necessary caution text in the description or article context instead.
- After each upload cycle, delete obsolete YouTube versions. Only the final long video and final Shorts should remain.
- After upload/publication, delete local completed videos, rejected videos, audio intermediates, and temporary export files because they are heavy. Keep scripts, prompts, thumbnails, QA images, and URL records. Exception: a user-designated reference video may be kept locally; current reference exception is Kioxia (285A). Even for a reference company, delete audio intermediates and temporary exports unless explicitly needed.
- Keep the YouTube OAuth token at `C:\Users\tomo-\.codex\.sandbox-secrets\youtube-oauth-token.json` and do not delete it as a local intermediate file.
- When embedding a published video into WordPress, use the lightweight YouTube embed pattern, not a direct MP4 upload and not an initially loaded iframe. Show only the thumbnail/play button first, then create the iframe on click. Use `fic-lite-youtube-embed`, embed the long video as the main article video, and keep Shorts as a supporting link. Back up the WordPress HTML before updating and verify the public page contains the lite embed and video IDs.
- Before upload, present local videos/contact sheets for user visual review. Upload only after the user explicitly approves the current version.
- Public-quality bar: each scene must be understandable from the screen alone. Avoid generic "how to read this chart" narration; explain the actual company, the actual profit driver, and what would confirm or weaken the thesis.
- Do not show internal production phrases such as "non-AI graph", "AI-generated figure", "we do not use..." or other workflow details. Viewers only need the investment explanation.
- Badges, labels, and captions must be tested for overflow at actual video resolution. Use width-based wrapping, not character-count wrapping, when possible.
- Never draw long theme or summary text as a raw single line. Apply width-based wrapping to all large titles, including the final summary slide, and verify the rendered frame fits within the safe area.
- Long-form company videos should include at least one numeric "key point" slide when the article has useful figures. Use large before/after or target/current numbers so viewers can immediately see the investment hinge, not only repeated text-card layouts.
- Use the Oji Holdings 3861 videos as the standard story pattern. In long videos, start by correcting the common surface-level view of the company, then immediately show the investment thesis map in scene 2 ("first, look at this investment thesis map"), then state what the investor is actually buying, show the profit drivers, show the business-driver AI map when available, show a numeric turning point, and end with confirmation points plus the condition that would weaken the thesis.
- The final confirmation-points slide must state timing, not only "things to check." Use wording such as "next earnings / monthly data / medium-term-plan update" so viewers know these are post-investment monitoring points and thesis-revision signals.
- For Shorts, use the Oji pattern: "what are we buying?" -> "not the old/simple story" -> "the real transformation thesis" -> "numeric hinge or short-term swing factor" -> "three checks" -> route to long/article.
- The first Shorts slide should visually follow the Oji template: right-biased dark AI background crop, no hard left black block, gold top/bottom guide lines, right-top category badge, left-aligned "{company}で / 何を買う？", short warning copy, a central white contrast card, a lower pale-yellow takeaway card, and the footer "保存して後で見返す".
- Shorts should not use thin horizontal grid lines on any slide. Use cards, spacing, and color to separate content.
- The second Shorts slide should use the Oji wording "投資仮説は3つに分ける"; keep card text short enough to fit and use a concise bottom bar.
- The final Shorts slide should also follow the Oji pattern: a large conclusion headline ("{company}は / {what it becomes or what the thesis buys}"), one central white card with "long-term theme" and "short-term risk", then a small route line to the article and long video. Treat it as the viewer's memory anchor, not a generic CTA.
