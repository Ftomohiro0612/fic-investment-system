# 既存SOP vs 新4 Skill 整合性監査

作成日: 2026-05-21
作成者: Claude Code（調査自動生成）
目的: 新4 Skill体系（article-design-principles / writing-style / article-quality-checklist / fact-safety 3規律）と既存SOP群（13分割チャットワークフロー・docsドキュメント群・prompts群）のギャップを洗い出す。

---

## 1. 既存SOP全体把握（一覧表）

### 1-A. 13分割チャットワークフロー（最重要SOP群）

| ファイルパス | 概要（1〜2行） | 4 Skillとの関係 |
|---|---|---|
| `docs/chat_workflows/README.md` | 企業・業界分析の13工程分割の入口テンプレ集。1チャット=1工程の基本ルール、管理シート情報。 | 部分重複（4 Skill参照先の役員ロール構造と対応）|
| `docs/chat_workflows/company_01_codex_pack.md` | 企業分析01: PDF直読によるClaude投入パック（pdf_summary.md / claude_input_pack.md）の作成手順。 | 無関係（資料収集工程。source-hierarchyと部分的に対応） |
| `docs/chat_workflows/company_02_claude_article.md` | 企業分析02: Claudeによる記事3点セット（統合メモ・記事HTML・レビューメモ）作成工程。 | 部分重複（writing-style・article-design-principlesに対応する記事作成工程） |
| `docs/chat_workflows/company_03_codex_review.md` | 企業分析03: Codexによるレビュー・修正工程。完成前セルフチェック44項目（推奨grep含む）を含む。 | 部分重複（article-quality-checklist・fact-safety 3規律と大部分重複。推奨grepは完全一致箇所多数） |
| `docs/chat_workflows/company_04_codex_image_wp.md` | 企業分析04: AI生成画像・非AI図表の作成/挿入とWordPress反映工程。 | 無関係（4 Skillはこの領域を未カバー。画像作成・WP運用の詳細SOP） |
| `docs/chat_workflows/company_05_codex_x_post.md` | 企業分析05: X投稿用決算メモ（AU）と投稿文3本（AV）の作成工程。シート列マッピング含む。 | 部分重複（expression-strength-rules §7・writing-style §10 媒体別と対応するが、投稿タイプ/選抜基準/シート操作は未反映） |
| `docs/chat_workflows/company_06_codex_video.md` | 企業分析06: 動画（長尺・Shorts）の作成工程。尺・ストーリー展開・サムネ規格・技術仕様・完成後の管理まで詳細なSOP。 | 未反映（4 Skill は動画固有ルールをほぼカバーしていない） |
| `docs/chat_workflows/industry_01_codex_trend_candidates.md` | 業界分析01: 最新ニュースからテーマ候補を14件程度抽出しシートへ記録する工程。 | 無関係（テーマ候補生成工程。4 Skillは記事内容に集中） |
| `docs/chat_workflows/industry_02_codex_pack.md` | 業界分析02: 業界分析のClaude投入パック（industry_input_pack.md等）作成工程。関連銘柄候補リスト・サプライチェーン・先行指標の整備を含む。 | 無関係（資料収集工程） |
| `docs/chat_workflows/industry_03_claude_article.md` | 業界分析03: Claudeによる記事3点セット作成工程（業界分析版）。3タイプの記事見出しテンプレあり。 | 部分重複（writing-style・article-design-principlesと対応するが、業界分析固有の3タイプ分岐は未反映） |
| `docs/chat_workflows/industry_04_codex_review.md` | 業界分析04: Codexによるレビュー工程。供給不安テーマ・コスト上昇テーマ別の確認観点を含む。 | 部分重複（fact-safety 3規律・article-quality-checklistと対応） |
| `docs/chat_workflows/industry_05_codex_image_wp.md` | 業界分析05: AI生成画像・非AI構造図の作成/挿入とWordPress反映工程（業界分析版）。 | 無関係（4 Skillはこの領域を未カバー） |
| `docs/chat_workflows/industry_06_codex_x_post.md` | 業界分析06: 業界分析記事からのX投稿メモ・投稿文作成工程。「関連銘柄煽りではなく指標誘導」が基本方針。 | 部分重複（expression-strength-rules §7・writing-style §10と対応。業界X固有ルールは未反映） |
| `docs/chat_workflows/industry_07_codex_video.md` | 業界分析07: 業界分析記事からの動画作成工程（company_06 比で大幅に簡素。具体規格はvideo_review_notes.mdに委譲）。 | 未反映（company_06と同様） |

### 1-B. docs/ 運用ドキュメント群

| ファイルパス | 概要（1〜2行） | 4 Skillとの関係 |
|---|---|---|
| `docs/video_review_notes.md` | 動画品質レビューの詳細ルール。ストーリー展開・サムネ仕様・Shorts構成・TTS設定・解像度・字幕・内部事情露出禁止・公開品質基準を詳細に記述。2026-05-19以降版。 | 未反映（expression-strength-rules §7で「内部事情を出さない」のみ言及。それ以外は4 Skill未カバー） |
| `docs/wordpress_media_cleanup_policy.md` | WordPress メディアライブラリとローカル画像フォルダのクリーンアップ基準。採用画像のみ残す・完了条件・例外事項を定義。 | 無関係（4 Skillはこの領域を未カバー） |
| `docs/x_post_company_analysis_workflow.md` | X投稿作成のCodex移行メモ。Make時代の仕様から現在の「5案生成→3案選抜」運用への移行。投稿タイプ10種・選抜基準・決算メモ形式・シート列マッピング・品質ルールを詳細に定義。 | 部分重複（expression-strength-rules §7・writing-style §10と対応。投稿タイプ/決算メモ書式/選抜基準は未反映） |
| `docs/non_ai_structure_chart_lessons.md` | 非AI構造図の見やすさルール。4要素以内・矢印で読む順番固定・フォント指定・「この図で伝えたいこと」の明示などを記述。 | 無関係（4 Skillは画像・図表作成ルールを未カバー） |
| `docs/codex_company_analysis_pack_spec.md` | 企業分析Codex投入パック仕様書（1,385行）。成果物5ファイル・Claude/Codex役割境界・シート連携・v4 15章構造対応・数値抽出標準・過大表現禁止リスト・出典ルールなど全体仕様を定義。 | 詳細SOP（expression-strength-rules・factual-handling-rules・source-hierarchyの集約元。4 Skillへの抽出元ドキュメントだが、企業分析特有の詳細（感応度・セグメント・M&A）は4 Skillに未移植の部分も多い） |
| `docs/codex_industry_analysis_migration_spec.md` | 業界分析のMake→Codex移行仕様書。シナリオ1（テーマ候補）・シナリオ2（記事生成）の詳細手順、編集ポリシー、検索クエリ設計、関連銘柄候補の分類ルールなど。 | 詳細SOP（source-hierarchy・expression-strength-rulesの集約元。業界分析固有の関連銘柄分類・サプライチェーン3区分は未反映） |
| `docs/claude_integrated_memo_lessons.md` | 統合分析メモ（14章構成）のベストプラクティス。過去Makeの地雷事例から導いたルール集。非AIグラフ候補提案方法・画像役割分担・フォント仕様・14章と対応する記事章構造も記述。 | 詳細SOP（factual-handling-rulesの集約元。14章構成・非AI図表候補・統合メモ品質は4 Skillに未集約） |
| `docs/claude_industry_analysis_handoff.md` | Claude向け業界分析記事作成引き継ぎメモ。Claude/Codex役割境界・レビューメモ標準セクション・品質改善ループ・画像/非AI構造図方針を定義。 | 詳細SOP（source-hierarchy・expression-strength-rules・factual-handling-rulesの集約元）|
| `docs/editorial_policy_final.md` | FIC編集方針の公開ページ本文。因果関係重視・一次情報優先・AI活用方針・会計士視点・誠実な限界開示・投資判断免責を定義。 | 部分重複（article-design-principlesの「FIC独自視点」部分の元テキスト。4 Skillに反映済み） |
| `docs/repository_rules.md` | リポジトリ運用ルール（プロンプト管理・WP運用・SEO/GEOルール・ドキュメント運用）。 | 無関係（インフラルール。4 Skillの対象外） |
| `docs/workspace_organization_policy.md` | 作業フォルダ整理方針（正本リポジトリ・画像/動画/アーカイブの分離・Codexへの読み込み制限）。 | 無関係（運用インフラ。4 Skillの対象外） |
| `docs/roadmap.md` | Phase 1〜4のロードマップ（Foundationから最適化ループ）。現時点では更新が止まっているように見える。 | 無関係（計画文書） |
| `docs/workflow_notes.md` | ワークフローノート。MakeモジュールへのGitHub参照方法・記事作成プロンプトルール・WP決算スケジュールUI仕様など。 | 無関係（技術メモ） |
| `docs/make_company_analysis_blueprint_findings.md` | Make企業分析ブループリント読解メモ。Make→Codex移行のための設計思想整理。 | 無関係（歴史的参照） |

### 1-C. prompts/ ファイル群

| ファイルパス | 概要（1〜2行） | 4 Skillとの関係 |
|---|---|---|
| `prompts/shared/quality_checklist.md` | 記事公開前44項目チェックリスト（英語）。出典強度・表現断定・WPメタ・関連銘柄・表示崩れ等を網羅。 | 詳細SOP（article-quality-checklistの基盤。4 Skillはこれを日本語で継承・拡張している） |
| `prompts/shared/writing_style.md` | 文体基本方針（英語5行）。簡潔・分析的・投資ロジックを軸とした文体を定義。 | 部分重複（writing-styleの集約元だが内容は簡素。4 Skillでかなり拡張されている） |
| `prompts/seo/intro_rules.md` | 記事導入部のSEOルール（英語）。結論先行・2層構造・内部リンク配置を定義。 | 部分重複（article-design-principles §3-4「入口/中身の役割分離」と対応。英語版のみ存在） |
| `prompts/seo/title_rules.md` | タイトルのSEOルール（英語）。検索意図への整合・誇張回避を定義。 | 部分重複（expression-strength-rules §3「タイトルと本文の強度整合」と対応） |
| `prompts/seo/internal_link_rules.md` | 内部リンクルール（英語）。リンク追加のハードゲート・推奨配置・禁止ケースを定義。 | 無関係（4 Skillの対象外。article-quality-checklistの44項目には含まれる） |
| `prompts/social/x_post_company_analysis_main.md` | X投稿作成プロンプト（企業分析版・本番使用）。投稿タイプ定義・選抜基準・数字ルール・表現ルール・出力JSON形式を定義。 | 部分重複（expression-strength-rules §7・writing-style §10と対応。投稿タイプ10種・数字ルール・文体ガイドは4 Skillに未反映） |
| `prompts/social/x_post_industry_analysis_main.md` | X投稿作成プロンプト（業界分析版・本番使用）。4タイプ（逆説型・数字インパクト型・リスク警告型・問い型）固定で、各タイプに詳細な作成ルールあり。 | 部分重複（expression-strength-rules §7と対応。4タイプ定義と各ルールは4 Skillに未反映） |

---

## 2. 4 Skillとの整合性ギャップ（領域別）

---

### ①動画

**既存SOPファイル:**
- `docs/chat_workflows/company_06_codex_video.md`（企業分析版・詳細）
- `docs/chat_workflows/industry_07_codex_video.md`（業界分析版・簡素）
- `docs/video_review_notes.md`（品質レビューノート・本番運用ルール正本）

**既存SOPの主要ルール:**

尺・長さ:
- Shorts: 50〜60秒
- 長尺: 3分〜3分45秒（王子HD型・ストーリーが締まっている場合）、4分〜4分45秒（図解・前提説明が多い場合）

ストーリー展開（長尺・王子HD型が標準）:
1. 表面的な見方への問いかけから入る
2. シーン2で「この投資仮説マップを見てください」とAI投資仮説マップを提示
3. 「何を買う投資か」→「利益を動かす要因」→「業績ドライバー図」→「数字の山場」→「確認ポイントと反証条件」の順

Shorts構成（王子HD型が標準）:
1. 「{企業名}で / 何を買う？」（右寄り暗いAI背景、金ライン、中央白カード、下部薄黄色カード、「保存して後で見返す」）
2. 「投資仮説は3つに分ける」（各カードは枠内に収まる短い見出し＋説明）
3. 「{企業名}は / {何へ変わる投資か}」（長期テーマ・短期リスク2行、記事・長尺動画への導線）

サムネ規格:
- 文字なしAI生成画像（暗い背景）
- 左上の公式FICロゴ（テキスト代用不可）
- 大きな左寄せタイトル
- 黄色アクセント
- 右上カテゴリラベル
- 論点タグ
- 下部コピー帯

技術仕様:
- TTS: `ja-JP-NanamiNeural`（Edge TTS）
- 読み辞書: 粗利益→あらりえき、王子HD→王子ホールディングス等
- 音声速度: Shorts `rate=+15%`、長尺 `rate=+10%`
- ビットレート: Shorts 約10Mbps、長尺1080p 約8Mbps
- シーンごとにTTS生成し音声長に画面を合わせる（一括生成＋比例割り付け禁止）
- 文字は表示幅ベースで折り返す（文字数ベース禁止）

公開基準:
- 音声なしでも要点が分かる情報量
- 一般論や「図の見方」だけで終わらせない。企業の利益ドライバー・確認する数字・反証条件を画面と音声の両方で説明
- 最後の確認ポイントは「何を確認するか」＋「いつ確認するか」を明記

管理・クリーンアップ:
- アップロード後はローカルの完成動画・没動画・音声中間素材を削除
- YouTube上に残すのは正本の長尺1本とShorts1本のみ
- 参考動画例外: キオクシア（285A）のみ完成動画をローカル保持可
- YouTubeトークン（`C:\Users\tomo-\.codex\.sandbox-secrets\youtube-oauth-token.json`）は削除不可
- ユーザー目視OKを得てから限定公開アップロード

WordPress動画埋め込み:
- `fic-lite-youtube-embed`方式（初期表示はサムネ＋再生ボタンのみ、クリック時にiframe生成）
- MP4直接アップロード禁止
- 長尺版を記事本文に埋め込み、Shortsは補助リンクとして併記
- 更新前HTML・更新後HTML・反映結果JSONをvideo/フォルダへ保存

**4 Skillへの反映状況:**
- expression-strength-rules §7「内部事情（制作側の内部事情を視聴者向けに出さない）」: 反映済み
- article-design-principles §3-5「動画セクション（⑪＝推奨）」: 配置・必須性・長さ目安（2〜5分）は反映済み
- writing-style §10「動画ナレ（videographer）」: 工夫1を口語で・耳で分かる長さ・内部事情出さない: 反映済み

**未反映の主要ルール:**
- ストーリー展開の具体（王子HD型の6ステップ順序）
- Shorts構成の3スライドテンプレート（スライド1-3の具体的デザイン仕様）
- サムネ規格の詳細（ロゴ位置・色・レイアウト要素）
- TTS音声設定（音声名・速度・読み辞書）
- 解像度・ビットレート・技術仕様
- シーンごとTTS生成のルール（一括生成禁止）
- YouTube管理（アップロード手順・参考動画例外・トークン保管）
- WordPress軽量埋め込み仕様（fic-lite-youtube-embed）
- 公開基準の確認ポイントに「いつ確認するか」を明記するルール

**反映が必要かの判断:**
動画制作ルール（尺・ストーリー・サムネ・TTS・YouTube管理）は `videographer` ロールの実作業SOPとして4 Skillに未集約。現状 `video_review_notes.md` と `company_06_codex_video.md` が正本だが、videographerロールを担うSkillがない。`article-design-principles §3-5`では「短尺2〜5分」と書いているが実際の標準は「長尺3〜4分45秒＋Shorts50〜60秒」であり数値ズレが存在する。新規Skill（`video-production-rules`）の作成、またはarticle-design-principlesの§3-5への詳細補完のいずれかが必要。

---

### ②X投稿

**既存SOPファイル:**
- `docs/chat_workflows/company_05_codex_x_post.md`
- `docs/chat_workflows/industry_06_codex_x_post.md`
- `docs/x_post_company_analysis_workflow.md`
- `prompts/social/x_post_company_analysis_main.md`
- `prompts/social/x_post_industry_analysis_main.md`

**既存SOPの主要ルール:**

投稿タイプ（企業分析版・10種）:
逆説型・数字インパクト型・リスク因果型・見落とし型・市場テーマ型・決算違和感型・中長期オプション型・比較型・先行指標型・初心者翻訳型・ざっくり比喩型

投稿タイプ（業界分析版・4種固定）:
逆説型・数字インパクト型・リスク警告型・問い型（各タイプに詳細な作成ルール・形式目安あり）

品質ルール（企業分析）:
- 各投稿200字以内・1投稿1メッセージ
- 最初の15文字でスクロールを止める
- 記事にない内容は足さない
- 数字は定義・単位・文脈が一致するものだけ
- `#日本株`と会社名ハッシュタグを末尾に付ける
- URLを各投稿末尾に入れる
- 煽りすぎ・投資助言・恐怖訴求は禁止

決算メモ（AU列）の書式:
- 一言でいうと / 決算要約 / ポジティブ / ネガティブ / 次に見る焦点 / Xで使える噛み砕き表現 / 使わない方がよい表現（の7セクション）
- 決算メモプロンプト（170行超）が `x_post_company_analysis_workflow.md` に定義済み

選抜基準（5案→3案）:
- 冒頭でスクロールを止められるか
- 記事を読みたくなる余白があるか
- 3本の切り口が重複していないか
- FICらしい「上流要因→企業KPI→業績」の因果が入っているか

シート列マッピング:
- AT=投稿フラグ、AU=X投稿用決算メモ、AV=X投稿文章（採用3本）、AQ=最終更新日、AS=レビュー担当メモ

数字ルール（詳細）:
- 1投稿で使う数字は原則1つ主役
- 2つ使う場合は同じ定義・単位・文脈のみ
- 1行目の数字は1つだけ（業界分析版の問い型に詳細ルール）

**4 Skillへの反映状況:**
- expression-strength-rules §7「X投稿：煽り/茶化し/強断定/勝ち組負け組禁止・少しカジュアルは可」: 反映済み
- writing-style §10「X（x_writer）：工夫1中心・文字数内・煽り禁止は本文と同基準」: 反映済み

**未反映の主要ルール:**
- 投稿タイプ定義（企業10種・業界4種）と各タイプの具体的作成ルール
- 5案生成→3案選抜のプロセス
- 決算メモ（AU）の7セクション書式と詳細プロンプト
- 数字ルール詳細（1行目数字は1つ・同定義・同単位の制約）
- ハッシュタグルール（`#日本株`+会社名ハッシュタグ必須、URL末尾必須）
- 文字数制約（200字以内 / 140字前後目安）
- シート列マッピング（AT/AU/AV/AQ/AS）
- 業界X固有方針（「関連銘柄煽りではなく指標誘導」）

**反映が必要かの判断:**
writing-style §10・expression-strength-rules §7 では「X投稿の煽り禁止」程度しかカバーしていない。実際のX投稿工程は、投稿タイプの選択・決算メモ書式・数字ルール・選抜基準など独立した判断軸を多数含む。既存 `x_post_company_analysis_workflow.md` と `prompts/social/x_post_*` が実質的な正本であり、4 Skillへの集約より「x_writer向けの独立Skill（x-post-rules）」新規作成のほうが整理しやすい。

---

### ③画像作成

**既存SOPファイル:**
- `docs/chat_workflows/company_04_codex_image_wp.md`
- `docs/chat_workflows/industry_05_codex_image_wp.md`
- `docs/non_ai_structure_chart_lessons.md`
- `docs/codex_company_analysis_pack_spec.md`（§ 非AIグラフ候補・画像役割分担）
- `docs/claude_integrated_memo_lessons.md`（§ 非AI構造図・画像役割分担）

**既存SOPの主要ルール:**

AI生成画像:
- 企業分析参考画像: `fic_impact_map_ai_style_reference_01.png` と `_04.png` を参考
- 業界分析参考画像: `docs/reference_images/industry_analysis/` 配下
- 企業分析: 「上流環境と業績への波及イメージ」（上流環境→先行指標→企業への効き方→業績への波及）を業績ドライバー章冒頭またはドライバー①直前に置く
- 業界分析: AI影響マップは原則 `<h2>影響経路...` の直前に置く

非AI構造図:
- 冒頭に「この図で伝えたいこと」を明示（図表タイトルではなく読者が持ち帰る結論）
- 大きな結論見出しを濃紺の帯に置き、黄色ラベルで視線を止める
- 図の要素は4つ前後（6個以上は禁止）
- 各カードは「番号」「短い見出し」「補足1-2行」の3層
- 矢印で読む順番を固定（左から右・上流要因から業績反映へ）
- フォント: `"Yu Gothic", "YuGothic", "Meiryo", "Noto Sans JP"` 基本、見出しは `font-weight:900`、PNG作成時はMeiryo標準
- 表の内容を説明する非AI図表は、対応する表の前に配置

画像クリーンアップ:
- WordPress反映後、中間生成物・旧版・没版・差し替え前画像を削除し採用版だけ残す
- `docs/reference_images/` 配下は削除不可
- 既存アイキャッチはユーザーが明示しない限り変更しない

WordPress反映:
- 既存投稿IDがある場合は必ず既存投稿を更新（新規作成しない）
- スラッグは一度決めたら変更しない
- WordPress更新時の投稿タイトルは `article_title:` を最優先（`<h1>` からのフォールバック禁止）
- 表の内容を説明する非AI図表は、読者が表を見る前に要点を掴めるよう、対応する表の前に配置

**4 Skillへの反映状況:**
- article-design-principles §2 裁定#9「必須グラフ3＋概念図を増やす。本文の数値を正とし、図側で独自補完しない」: 部分的に反映
- factual-handling-rules: 数値精度（図側で独自補完しない）: 反映済み

**未反映の主要ルール:**
- AI生成画像の配置ルール（企業・業界別）
- 非AI構造図の詳細仕様（フォント・色・4要素ルール・矢印順）
- 画像クリーンアップルール（詳細はwordpress_media_cleanup_policy.mdが正本）
- WordPress反映の具体手順（投稿ID・スラッグ・article_title:の扱い）
- `glossary-box`（📘用語解説）のCSS定義（`writing-style §6`では「要WP CSS定義」とのみ記載されており、実装状態が不明確）

**反映が必要かの判断:**
画像作成ルールは `image-production-rules` 相当の新規Skillとして独立させるか、既存 `non_ai_structure_chart_lessons.md` を正本として維持するかの判断が必要。4 Skillへの反映より、画像・WP工程専用のSOP（現行company_04/industry_05）の参照が引き続き有効。

---

### ④WordPress反映

**既存SOPファイル:**
- `docs/chat_workflows/company_04_codex_image_wp.md`
- `docs/chat_workflows/industry_05_codex_image_wp.md`
- `docs/wordpress_media_cleanup_policy.md`
- `docs/chat_workflows/company_03_codex_review.md`（次工程handoff必須事項）
- `docs/codex_company_analysis_pack_spec.md`（§1.4 シート連携・パスモード）

**既存SOPの主要ルール:**

投稿管理:
- 既存投稿IDがあれば必ず更新（新規作成しない）
- スラッグは変更禁止
- `article_title:` メタコメントを `post_title` に明示セット（`<h1>` からの抽出禁止）
- 反映後に REST応答または管理画面で `title.rendered` = `article_title:` であることを確認

メディア管理:
- 最終記事で使われている画像・アイキャッチ・X投稿計画・動画作成計画の画像のみ残す
- 未使用WordPressメディアはワークフロー完了前に削除
- 削除結果を `AS` または作業メモに記録（`unusedMediaDeleted: [...]` / `localOldImagesDeleted: [...]`）
- `docs/reference_images/` 配下・再利用デザインアセットは削除不可

動画埋め込み（WP側）:
- MP4直接アップロード禁止
- `fic-lite-youtube-embed`方式（初期表示サムネ＋再生ボタン、クリック時iframeのみ）
- 更新前/更新後HTML・反映結果JSONを `video/` フォルダへ保存

シート連携（v3方式）:
- シートにはファイルパス＋ステータスのみ記録（本文全文コピー廃止）
- `update_sheet_row.mjs --path-mode` を使用
- 完了列: `AW`（画像）・`AN`（WordPress更新済み）・`AP`（完了）

**4 Skillへの反映状況:**
- article-quality-checklist A（基盤44項目）: `article_title:`/`slug:`/`<h1>`有無/未解決マーカー排除を含む: 反映済み
- writing-style §6: `glossary-box`（📘）は「要WP CSS定義」とのみ記載

**未反映の主要ルール:**
- 投稿ID管理・既存更新の強制・スラッグ変更禁止
- `title.rendered` 検証手順
- メディアクリーンアップの完了条件（5ステップ）と記録方法
- `fic-lite-youtube-embed`の実装仕様
- シート列マッピング（AN/AP/AW/AY等）
- `glossary-box`（📘）のWP CSS定義状況（未定義か既定義かが4 Skill内では不明確）

**反映が必要かの判断:**
WordPress運用ルールは記事品質（4 Skill対象）ではなくインフラ運用の領域。現行SOP（company_04・wordpress_media_cleanup_policy.md）が正本として機能しており、4 Skillへの集約は不要。ただし `writing-style §6` で「📘は要WP CSS定義」と記載されている点は、CSS定義状況をSkillまたはhandoff-templatesに記録しておく必要がある。

---

### ⑤品質チェック

**既存SOPファイル:**
- `prompts/shared/quality_checklist.md`（44項目・英語・基盤）
- `docs/chat_workflows/company_03_codex_review.md`（完成前セルフチェック・推奨grep）
- `docs/chat_workflows/industry_04_codex_review.md`（業界分析版レビュー観点）
- `docs/codex_company_analysis_pack_spec.md`（E-1〜E-6 品質基準セクション）

**既存SOPの主要ルール:**

企業分析レビュー（company_03セルフチェック）:
- `article_title:` と `slug:` が冒頭メタコメントに存在するか
- `<h1>` は本文に残さない
- `one-liner-summary`・`definition-lead`・`summary-box` が各1件
- H2 1〜12の章導入 `<em>` が12件
- H2 1〜12の章末まとめ（「結局、N章のまとめは：」型）が全12章
- 必須グラフマーカー3箇所（5.1・6章・8章）
- 画像連動マーカー2箇所
- 参照リンク数がhandoffと一致
- `要確認` `要追加確認` `未確認` `リンク未取得` `TODO` `FIXME` を残さない
- 関連銘柄に外部企業サイトへのリンクを付けない
- `円高反転` `円安進行` 等の雑表現を修正
- 8列以上の横長表の処理

推奨grep（company_03）:
```
rg -n '<h1|class="one-liner-summary"|class="definition-lead"|class="summary-box"|<em>|<strong>結局、|article_title:|slug:' ...
rg -n '要確認|要追加確認|セグメント別利益|円高反転|円安進行|圧倒的|独占|崩壊|TSMC直撃|V字回復' ...
```

business_44項目（quality_checklist.md）:
- 出典強度・表現断定・WPメタ・関連銘柄分類・表示崩れ・one-shot/recurring区別・影響ステージ数・タイトル強度整合・調査比率分母等

**4 Skillへの反映状況:**
- article-quality-checklist: 44項目を継承・B-0〜B-8として新規項目を加えている: 反映済み
- fact-safety 3規律: source-hierarchy・factual-handling-rules・expression-strength-rulesに分解: 反映済み
- 推奨grepは4 Skillの各セルフチェックに類似のgrepを含む: 部分的に反映済み

**未反映の主要ルール:**
- company_03版の企業分析固有チェック（`one-liner-summary`・`definition-lead`・H2章導入 `<em>` 12件・章末「結局…」12件・必須グラフマーカー3箇所・画像連動マーカー2箇所）
- 旧15章構成から現行15章構成への移行に伴い、旧チェック項目（H2 1〜12）と現行チェック（全15章）のズレ
- industry_04版の業界分析固有観点（供給不安テーマ・コスト上昇テーマ別の分類表・先行指標表の更新頻度記載）
- 44項目の英語チェックリストと新B-0〜B-8の日本語チェック項目の2重管理（統合されていない）

**反映が必要かの判断:**
4 Skillの `article-quality-checklist` は44項目を「基盤として継承」と宣言しているが、実際の適用時は英語44項目と日本語B項目を別々に参照する必要があり非効率。また、企業分析固有のHTML構造チェック（`one-liner-summary`・H2 `<em>`・章末「結局」）は現行15章構成のチェックリストに一部未反映。article-quality-checklist に企業分析固有のHTML構造チェックを追加するか、company_03セルフチェックを正本として明示する必要がある。

---

### ⑥記事本文/構成

**既存SOPファイル:**
- `docs/codex_company_analysis_pack_spec.md`（§1.4〜1.8 v4 15章構造・記事構成詳細）
- `docs/claude_integrated_memo_lessons.md`（14章統合メモ構成・H2対応表）
- `docs/chat_workflows/industry_03_claude_article.md`（業界分析3タイプの見出しテンプレ）
- `docs/codex_industry_analysis_migration_spec.md`（シナリオ2記事生成・3タイプ分岐）
- `docs/claude_industry_analysis_handoff.md`（Claude記事作成の役割境界・品質改善ループ）
- `prompts/shared/writing_style.md`（文体基本方針・英語）
- `prompts/seo/intro_rules.md`（導入部SEOルール・英語）
- `prompts/seo/title_rules.md`（タイトルSEOルール・英語）
- `prompts/seo/internal_link_rules.md`（内部リンクルール・英語）

**既存SOPの主要ルール（article-design-principlesでカバーされていない部分）:**

業界分析3タイプの記事構成分岐:
1. 新規事業・ニュース解説型: `ニュースの概要→影響経路→関連銘柄候補→業績ドライバー→競争環境→ボトルネック→先行指標→3シナリオ→投資家が見るポイント→まとめ→FAQ→参照資料`
2. マクロ・テーマ記事型: `トレンドの概要→影響経路→恩恵セクター→主要企業で見るべきポイント→逆風セクター→ボトルネック→先行指標→3シナリオ→反対シナリオ→投資家が見るべきポイント→まとめ→FAQ→参照資料`
3. 企業群・業界比較型: `業界の現在地→収益構造→主要企業の比較→勝ち筋の違い→先行指標→3シナリオ→リスク→投資家が見るべきポイント→まとめ→FAQ→参照資料`

統合分析メモ14章構成（企業分析用）:
- メモ章0〜14の対応表（article H2との完全マッピング）
- 各章の必須要素（§2.1）
- 旧13章構成チェックリスト（§2.2）

HTML構造の要素:
- `one-liner-summary`（1行サマリー）
- `definition-lead`（定義リード）
- `beginner-box`（💡ワンポイント解説。CSS稼働済み）
- `summary-box`（30秒要約）
- H2 1〜12（旧構成）または1〜15（新構成）の各章導入 `<em>` と章末「結局…」
- `fic-related-companies` / `fic-related-themes` ブロック（既存FIC記事URLがある場合のみ）

SEO/GEOの固有ルール（prompts/seo/）:
- `intro_rules.md`: 結論先行4段落構成（結論→説明→箇条書きサマリー→深掘り転換）
- `title_rules.md`: 検索意図整合・誇張回避
- `internal_link_rules.md`: リンク追加のハードゲート（1文で具体的ドライバーで説明できるものだけ）

**4 Skillへの反映状況:**
- article-design-principles §3（公開15章構成・入口/中身分離・成長テーマ2段構え・中計分岐）: 企業分析については詳細に反映済み
- writing-style（文体工夫1〜3・💡/📘・監視指標）: 反映済み

**未反映の主要ルール:**
- 業界分析3タイプの記事構成分岐（article-design-principlesは企業分析の15章構成に特化）
- 統合分析メモ14章構成（article-design-principlesは記事HTML構成に特化し、メモ構成は未カバー）
- HTML要素の命名仕様（`one-liner-summary`・`definition-lead`・H2章導入`<em>`・章末「結局…」の書式）
- `fic-related-companies` / `fic-related-themes` ブロックのHTML実装と採否判断基準
- SEO/GEO固有ルール（`intro_rules.md`・`title_rules.md`・`internal_link_rules.md`）は英語のみで4 Skill未統合
- `beginner-box` CSS稼働済みだが `glossary-box` は未定義（writing-style §6で「要WP CSS定義」と言及のみ）

**反映が必要かの判断:**
業界分析3タイプの見出し分岐は article-design-principles に反映されておらず、業界分析を担当する writer / reviewer が迷う可能性がある。SEO/GEOルール（prompts/seo/）は英語ドキュメントのまま4 Skillとの接合点がない。article-design-principles §3に「業界分析版」のセクションを追加するか、独立Skill（`industry-article-design`）を作るかの判断が必要。

---

### ⑦その他（handoff/Sheets/リポジトリ規則等）

**既存SOPファイル:**
- `docs/chat_workflows/README.md`（13分割の基本ルール・1チャット=1工程）
- `docs/repository_rules.md`（リポジトリ運用ルール）
- `docs/workspace_organization_policy.md`（作業フォルダ整理方針）
- `docs/roadmap.md`（ロードマップ）
- `docs/workflow_notes.md`（ワークフローノート・技術メモ）

**既存SOPの主要ルール:**

handoff（工程間引き継ぎ）:
- 各工程完了時に `handoff_*.md` を作業フォルダ内に作る
- 命名規則: `handoff_pack_to_claude.md` / `handoff_claude_to_codex_review.md` / `handoff_review_to_image_wp.md` / `handoff_image_wp_to_x_or_video.md` 等
- handoff内容: 正本HTMLパス・次工程への引き継ぎ事項・Codexレビュー結果・未解決事項

シート管理:
- 正本: `FIC記事管理_v3` スプレッドシート（企業分析タブ・業界分析タブ）
- シートへはファイルパス＋ステータスのみ記録（本文全文コピー廃止）
- `update_sheet_row.mjs --path-mode` を使用
- ステータス語彙: 既存SOP内に散在（sheets-status-update Skillで集約予定）

**4 Skillへの反映状況:**
- `handoff-templates` Skill: handoffの書式・セクション構成・命名規則・配置場所を定義: 反映済み（新Skill）
- `sheets-status-update` Skill: Sheets更新手順・認証・dry-run検証: 反映済み（新Skill）

**未反映の主要ルール:**
- 1チャット=1工程の分割ルール（chat_workflows/README.mdが正本）
- リポジトリ運用ルール（repository_rules.md）・フォルダ整理（workspace_organization_policy.md）は4 Skillの対象外であり意図的に未集約

**反映が必要かの判断:**
handoff・Sheets管理は既に専用Skillとして反映済み。リポジトリ・フォルダ規則はインフラ運用のため4 Skill対象外で問題なし。

---

## 3. 段階1ステップ4 承認への影響評価

### 前提：4 Skillのスコープは「writer/reviewerコア」で正しい
phase5_pilot_plan の段階1は **writer/reviewer 向けのSkill先行作成**（fact-safety 3規律・writing-style・article-quality-checklist・100点像）が目的。動画/X/画像/WP のSOPは **videographer / x_writer / designer** のロール領域で、これらのロールは **段階4（残りsubagent追加）** で初めて作られる（phase4_final_design の15 Skillリストにも `video-production`/`x-post`/`image`/`wordpress-publishing` 相当が後続として並ぶ）。
→ したがって **既存の動画/X/画像/WP SOPを今すぐ4 Skillへ集約する必要はない**。それらは後続ロールのSkill化時（段階4）に集約するのが設計上正しい。

### 推奨：(b) Skill記述の最小補正後に承認
**(a) 即承認でも (c) スコープ拡大でもなく、(b) 最小補正後に承認**を推奨する。理由＝4 Skillのスコープ自体は正しいが、**4 Skillが後続ロール領域に“はみ出して”書いた箇所**に既存SOPとの不整合があり、ここだけは承認前に直すべき。

承認前に直すべき最小補正（3点）:
1. **article-design-principles §3-5 の動画の尺が誤り**：「短尺2〜5分」と書いたが、実標準は **Shorts 50〜60秒／長尺 3:00〜4:45**（company_06 / video_review_notes.md）。→ 誤った数値を削除し、「**動画詳細規格は video SOP が正本（videographer Skill化は段階4）**」へ書き換える。配置（30秒要約の直後）・推奨・必須でない点は維持。
2. **writing-style §10 媒体別（X／動画）**：現状「煽り禁止・工夫1中心」のみ。→ 「**X／動画の詳細ルールは既存SOP（x_post_company_analysis_workflow.md・prompts/social/・company_06・video_review_notes.md）が正本。x_writer/videographer Skill化は段階4**」のクロス参照注記を追加。
3. **📘 用語解説box**（※2026-05-21 公開HTML実査で訂正）：当初「📘=glossary-box・WP CSS未定義・本番不使用ガード・ステップ5でCSS定義」と判断したが、公開記事のclass実査で**📘は💡と同一クラス `beginner-box`**（CSS=`wordpress/css/custom.css`）で本番稼働済みと判明。glossary-box/term-boxは誤認・不要。📘は絵文字＋「用語メモ：」見出しで区別、新規CSS不要。ガード・ステップ5 CSS定義タスクは取り下げ。

### 承認可否
上記3点を補正すれば、**段階1ステップ4は承認可能**。残るギャップ（company_03の企業分析HTML構造チェック・英語44項目との2重管理・業界分析3タイプ・14章メモ・各ロールSOPのSkill化）は **writer/reviewerコアの外側か、テンプレ確定に依存**するため、ステップ5以降（調査4）に送る。

---

## 4. 段階1ステップ5以降のスコープ提案

### ステップ5（現スコープ＝テンプレ全面15章化）に追加すべき作業
- **article-quality-checklist に企業分析HTML構造チェックを15章版で反映**：`one-liner-summary`／`definition-lead`／各章導入`<em>`／章末「結局…」／必須グラフマーカー3箇所／画像連動マーカー。company_03の旧H2 1〜12基準を**新15章**に振り直して取り込む（テンプレ確定と同時でないとマーカー位置が決まらないため、ここが最適）。
- **英語44項目（quality_checklist.md）と日本語B項目の2重管理を解消**：役割分担を明文化（英語44＝汎用基盤／日本語B＝100点像拡張）か、日本語へ一本化。
- ~~📘 glossary-box の WP CSS定義~~ → **取り下げ**（2026-05-21検証で📘は既存 `beginner-box` 稼働済みと判明・新規CSS不要）。`fic-detail-block`（段階2）は対象外。

### ステップ6以降の新規ステップ提案（各ロールSOPのSkill化＝段階4と整合）
- **業界分析の構成Skill**（`industry-article-design` 相当）：業界分析3タイプ（新規事業/ニュース解説・マクロ/テーマ・企業群/業界比較）の章立て分岐。industry版 writer/reviewer 用。
- **統合分析メモ14章構成のSkill化**（researcher_company用）：claude_integrated_memo_lessons.md の14章・H2対応表・必須要素。
- **videographer Skill**（`video-production-rules`）：company_06 / video_review_notes.md の尺・ストーリー6ステップ・Shorts3スライド・サムネ・TTS・YouTube管理・fic-lite-youtube-embed を集約。
- **x_writer Skill**（`x-post-rules`）：x_post_company_analysis_workflow.md / prompts/social/ の投稿タイプ・決算メモ7セクション・5案→3案選抜・数字ルール・ハッシュタグを集約。
- **designer Skill**（`image-production-rules` ＋ `wordpress-publishing`）：non_ai_structure_chart_lessons.md（4要素・濃紺帯・矢印順・フォント）＋ company_04 ＋ wordpress_media_cleanup_policy.md ＋ fic-lite-youtube-embed を集約。

### 段階2（運用フェーズ）に回すべき作業
- **アコーディオン/優先動線/L1L2L3 の検証**（既にγで段階2へ退避済み）。
- **SEO/GEO英語ルール（prompts/seo/）の日本語Skill統合**（任意・優先度低）。

---

## 5. 判断分岐事項（FIC判断が必要・選択肢付き）

1. **段階1ステップ4 の承認方針**：(a) 即承認（SOP整合は段階2以降）／**(b) 最小補正後に承認（推奨）**／(c) スコープ拡大（既存SOPのSkill化を今）。
2. **article-design-principles §3-5 動画**：**(a) 既存SOP参照に書き換え＋誤った尺を削除（videographer Skillは段階4）＝推奨**／(b) 今 video-production-rules Skillを作る（スコープ拡大）／(c) 現状維持（誤った尺を残す）＝非推奨。
3. **📘 用語解説box**：※2026-05-21 公開HTML検証で解消＝📘は既存 `beginner-box` で稼働済み（glossary-box・ガード・CSS定義は不要）。当初の(a)(b)(c)は取り下げ。
4. **品質チェックの企業分析HTML構造＆44項目2重管理**：**(a) ステップ5でテンプレ確定と同時に反映・統合（推奨）**／(b) 今すぐ反映（テンプレ未確定でマーカー位置が動くリスク）／(c) company_03を正本として参照明記のみ（恒久2重管理）。
5. **業界分析の構成（3タイプ分岐）**：**(a) 段階4でindustry writer/reviewer追加時にSkill化（推奨）**／(b) ステップ5で先行追加／(c) article-design-principlesに業界版セクションを今追加。
6. **各ロールSOP（動画/X/画像/WP）のSkill化タイミング**：**(a) 段階4で該当subagent追加時（推奨・pilot_plan整合）**／(b) ステップ5〜6で先行Skill化／(c) 当面SOPのまま運用しSkill化しない。
