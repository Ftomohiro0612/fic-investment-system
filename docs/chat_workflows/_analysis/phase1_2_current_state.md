# フェーズ1〜2: 現行ワークフローの現状分析

対象: `docs/chat_workflows/` 配下の14ファイル（README＋企業6＋業界7）。
設計思想は「**1チャット = 1工程**」。履歴を短く保ち、各工程で読む指示書・触るフォルダを固定し、
重い処理（画像/動画/WP）を記事作成と混ぜない。工程間は対象フォルダ内の `handoff_*.md` で受け渡す。
記事管理の正本は Google Sheets「FIC記事管理_v3」（企業分析タブ／業界分析タブ）。

---

## A. 全工程フロー

### 企業分析（6工程）

```
01 Codex 資料作成
   → pdf_summary.md / claude_input_pack.md / CLAUDE_CODE_FIC_INSTRUCTIONS.md
   → handoff_pack_to_claude.md
02 Claude 記事作成
   → claude_integrated_memo.md / claude_article.html / claude_review_notes.md
   → handoff_claude_to_codex_review.md
03 Codex レビュー   ←（Claude⇄Codex 修正往復を含む）
   → codex_reviewed_article.html / handoff_review_to_image_wp.md
04 Codex 画像作成・WP反映
   → codex_reviewed_article.with_images.html / WP更新 / シート更新
   → handoff_image_wp_to_x_or_video.md
   ├─ 05 Codex X投稿（AU決算メモ / AV投稿3本 / AT=完了）
   └─ 06 Codex 動画作成（台本・動画・YouTube）
```
ツール: Codex=01,03,04,05,06 / Claude=02のみ。

### 業界分析（7工程）

```
01 Codex テーマ候補作成（ニュース起点、1回で複数候補。業界分析タブへ）
02 Codex 資料作成 → industry_input_pack.md / source_search_results.md / 指示書 / handoff
03 Claude 記事作成 → memo / article.html / review_notes / handoff
04 Codex レビュー → codex_reviewed_article.html / handoff_review_to_image_wp.md
05 Codex 画像作成・WP反映 → with_images.html / WP / シート / handoff_image_wp_to_video.md
   ├─ 06 Codex X投稿
   └─ 07 Codex 動画作成
```
ツール: Codex=01,02,04,05,06,07 / Claude=03のみ。
構造差: 業界分析だけ先頭に発見工程（01テーマ候補）を持つ。企業分析の銘柄選定は本テンプレ群の外（GPT相談→FIC判断→シート手入力）。

---

## B. 役割サマリ表

### 企業分析
| # | ツール | 主入力 | 主成果物 | 引き継ぎ |
|---|---|---|---|---|
| 01 | Codex | シート行・IR/決算/有報PDF | pdf_summary, claude_input_pack, 指示書 | handoff_pack_to_claude |
| 02 | Claude | 投入パック3点＋記事プロンプト | integrated_memo, article.html, review_notes | handoff_claude_to_codex_review |
| 03 | Codex | claude_article.html＋一次資料 | codex_reviewed_article.html, レビュー結果 | handoff_review_to_image_wp |
| 04 | Codex | reviewed_article.html | with_images.html, WP更新, シート(AW/AX/AY等) | handoff_image_wp_to_x_or_video |
| 05 | Codex | with_images.html, pdf_summary | AU決算メモ, AV投稿3本, AT=完了 | （終端） |
| 06 | Codex | with_images.html, 画像, Xメモ(任意) | 動画, 台本, 素材リスト, URL | （終端） |

### 業界分析
| # | ツール | 主入力 | 主成果物 | 引き継ぎ |
|---|---|---|---|---|
| 01 | Codex | 最新ニュース | 業界分析タブ候補(A/B/C, key_companies) | シート経由で02へ |
| 02 | Codex | 採用テーマ | industry_input_pack, source_search_results, 指示書 | handoff_pack_to_claude |
| 03 | Claude | 投入パック＋記事プロンプト | memo, article.html, review_notes | handoff_claude_to_codex_review |
| 04 | Codex | article.html＋source | codex_reviewed_article.html, レビュー結果 | handoff_review_to_image_wp |
| 05 | Codex | reviewed_article.html | with_images.html, WP更新, シート | handoff_image_wp_to_video |
| 06 | Codex | with_images.html, memo | テーマメモ, 投稿3本, シート更新 | （終端） |
| 07 | Codex | with_images.html, 画像 | 動画, 台本, 素材リスト, URL | （終端） |

共通パターン: `Codex(素材) → Claude(執筆) → Codex(検証/整形) → Codex(画像/WP) → Codex(X/動画)`。執筆だけClaude、他は全てCodex。

---

## C. 設計上の論点（フェーズ3で回答済み。詳細は phase3_design_direction.md）

- C-1 ツール分担: X投稿/動画台本/レビューがCodexである根拠は「ChatGPTの当時アドバイス」が主因。執筆寄り作業はClaude適性が高い。
- C-2 工程内往復: 企業03に「Claude修正版を取り込み再適用」とあり、02⇔03は一方向でなく反復ループ。
- C-3 handoff命名不整合: 企業04は `handoff_image_wp_to_x_or_video`（X+動画兼用）、業界05は `handoff_image_wp_to_video`（動画のみ）。業界X投稿に専用handoffなし。
- C-4 ルール重複: 出典階層・表現強度・関連銘柄4分類・数値地雷が pack_spec / integrated_memo_lessons / quality_checklist / review に分散・重複。企業03に詳細セルフチェック(grep付)があるが業界04には同等がなく非対称。
- C-5 構造非対称: 業界のみ発見工程あり。企業の銘柄選定はテンプレ外（GPT手運用）。
- C-6 仕様書実体: quality_checklist.md, codex_company_analysis_pack_spec.md(1385行), codex_industry_analysis_migration_spec.md, claude_integrated_memo_lessons.md, claude_industry_analysis_handoff.md, non_ai_structure_chart_lessons.md, video_review_notes.md ほかを精読済み。

---

## D. 依存関係マップ

- **直列（順次依存）**: 企業 01→02→03→04 / 業界 02→03→04→05。各工程が前工程成果物を入力にする。
- **並列可能**: 末端の X投稿 と 動画 は画像WP後に分岐し並列実行可（動画はXメモを任意参照する程度）。異なる企業/テーマのパイプラインはフォルダ分離のため丸ごと並列可。業界01（発見）は1→多の独立バッチ。
- **クリティカルパス**: 企業 01→02→03→(往復)→04→06動画 / 業界 02→03→04→05→07動画。終端は重い動画工程。02⇔03レビュー往復回数が実質的なパス長変動要因。重い工程（画像/WP/動画）が後段Codexに集中。

---

## 精読した主要仕様書の構造（フェーズ4マッピングの根拠）

- **prompts/shared/quality_checklist.md**: 約40項目の英語チェックリスト。導入結論先出し、関連リンクの具体因果、4分類、出典より強い断定の禁止、タイトル要件、サプライチェーン5層、出典強弱、企業分析メタ(article_title/slug)、H2章導入/まとめ、表の表示崩れ、未完成マーカー禁止 等。
- **docs/codex_company_analysis_pack_spec.md（1385行）**: 0目的/1成果物・役割境界・シート連携・全社共通テンプレ(1.5)・生資料取得標準(1.6)・v3業界トレンド標準(1.7)・v4 15章(1.8)/2 pdf_summary構成・必須抽出データ/3 input_pack構成・図表候補・禁止表現/4 数値出典管理/5 抽出ワークフロー・H2逆引きマッピング/6 完了前チェック/7 Claude後のCodex役割（7.1 WP前レビュー, 7.2 画像/WP, 7.3 アイキャッチ, 7.4 品質ループ）。
- **docs/codex_industry_analysis_migration_spec.md**: 編集ポリシー/シナリオ1トレンド候補/シナリオ2記事生成・見出し3タイプ/Codexレビュー/画像方針（AI影響マップ＋非AI構造図、参考画像）/13章Claude投入パック（3関連銘柄候補が最重要）/記事品質ゲート/v3業界分析タブ列定義。
- **docs/claude_integrated_memo_lessons.md**: 統合メモ14章構成、因果構造標準形、ビジネスモデル類型、数値/単位地雷(×10換算等)、年度/会計基準、感応度作法、業績推移、3シナリオ、出力直前横断チェック等。Claude執筆の内部規律集。
- **docs/claude_industry_analysis_handoff.md**: 業界記事のClaude向け引き継ぎ。3点セット、役割境界表、見出しタイプ、因果厚塗り、中間変数必須、未完成表現禁止。
- **docs/non_ai_structure_chart_lessons.md**: 非AI構造図の見やすさ（結論帯・黄色ラベル・4カード・矢印・見る順番バー、フォント）。
- **docs/video_review_notes.md**: 王子HD型ストーリー、Shorts/長尺の尺、TTS(ja-JP-NanamiNeural)・読み辞書、サムネ構成、シーン毎TTS、lite YouTube embed、アップ後ローカル削除。
- **prompts/article/**: company/industry の article_main・memo_main、industry trend_list・trend_validation、v4 input_pack仕様。
- **prompts/seo/**: internal_link_rules（Hard Gate）, intro_rules, title_rules。**prompts/shared/writing_style.md**。
- **prompts/social/**: x_post_company（3本選抜・11型・200字・決算メモ連動）, x_post_industry（4本固定 post1〜4・140〜220字）。
- **prompts/search/**: industry_news_query(14本), industry_analysis_article_query(12本)。
- **docs/x_post_company_analysis_workflow.md**: X投稿Codex移行メモ（5案→3案、AU決算メモ型）。
- **docs/wordpress_media_cleanup_policy.md**: 未使用メディア削除、アイキャッチ保持、参照画像保持。
</content>
