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
- Standard thumbnail pattern: dark AI background, large left-aligned short title, yellow accent, small label, topic tags, and a bottom white takeaway strip. This follows the best-performing AI memory shortage thumbnail pattern.
- Do not make the video look like plain white presentation slides only. Use the AI background with blur/wash so text remains readable.
- If article AI diagrams or maps are used in the long video, the narration must explain how to read the diagram, including the viewing order and what each block means.
- Shorts do not need article AI-generated diagrams. Prefer simple, instantly readable cards with the main finding and three check points. Keep AI diagrams mainly for the long video where narration can explain how to read them.
- Avoid boxes with only keywords. Put a short beginner-friendly explanation inside each box.
- Avoid color-only circles, squares, or legends. If a marker has meaning, write the meaning directly as a heading or label.
- Keep badges and labels away from YouTube overlay areas. Leave enough top/right margin.
- Use Edge TTS `ja-JP-NanamiNeural` as the standard voice. Keep a reading dictionary for terms such as `粗利益 -> あらりえき`, `王子HD -> 王子ホールディングス`, `LBKP -> エルビーケーピー`, and `M&A -> エムアンドエー`.
- Prefer faster narration for YouTube. Current useful baseline: Shorts `rate=+15%`, long `rate=+10%`.
- For both Shorts and long videos, do not generate one full narration file and proportionally scale scene durations. Generate TTS per scene and set each visual scene duration from its audio segment to avoid voice/screen mismatch.
- Do not include the final spoken/on-screen disclaimer line in the video body. Keep the pacing clean; put necessary caution text in the description or article context instead.
- After each upload cycle, delete obsolete YouTube versions. Only the final long video and final Shorts should remain.
- Keep the YouTube OAuth token at `C:\Users\tomo-\.codex\.sandbox-secrets\youtube-oauth-token.json` and do not delete it as a local intermediate file.
- When embedding a published video into WordPress, use the lightweight YouTube embed pattern, not a direct MP4 upload and not an initially loaded iframe. Show only the thumbnail/play button first, then create the iframe on click. Use `fic-lite-youtube-embed`, embed the long video as the main article video, and keep Shorts as a supporting link. Back up the WordPress HTML before updating and verify the public page contains the lite embed and video IDs.
