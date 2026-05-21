# フェーズ3: 再設計の方針（FIC提供・確定版）

現状分析（[phase1_2_current_state.md](phase1_2_current_state.md)）を受けてFICが提示した再設計方針・背景・理想像の記録。
フェーズ4以降の設計判断の根拠。

---

## 1. 歴史的背景（なぜCodex主体になったか）

- 現行がCodex主体なのは、ChatGPTから「**Claudeは情報統合と記事作成が得意、それ以外はCodexでできる**」
  というアドバイスに従って設計したため（2025年〜2026年初頭の前提）。
- 現在の Claude Code はファイル操作・コード実行・API連携が可能で、Skills + Subagents による業務ルール化と
  並列実行ができ、執筆品質も最高水準。「Claudeは文章だけ」という制約はもう存在しない。
- 方針: **Codexが本当に必要な工程だけ残し、それ以外はClaude Codeへ集約**。ただし試行錯誤で培ったノウハウを
  尊重し、各工程の本質的役割を見極めて判断する（安易な全面移行はしない）。

---

## 2. 8役員（Subagent）体制

| 役員 | 役割 | 現状の対応工程 |
|---|---|---|
| scout | 企業の銘柄選定（GPTから巻き取り、候補提示まで） | テンプレ外（GPT相談→FIC判断→シート手入力） |
| theme_scout | 業界のテーマ選定 | 業界01（Codex）から移行 |
| researcher | 情報収集（企業/業界両対応） | 企業01 / 業界02（Codex） |
| writer | 記事作成（企業/業界両対応） | 企業02 / 業界03（Claude） |
| reviewer | 編集判断レビュー | 企業03 / 業界04 の編集判断部分 |
| designer | 画像作成（非AI自作・AI画像はCodex連携）＋**WordPress反映** | 企業04 / 業界05 |
| videographer | 動画台本・構成（レンダリングはCodex連携） | 企業06 / 業界07 |
| x_writer | X投稿（企業/業界両対応・**Sheets書き込みまで**） | 企業05 / 業界06 |

- 銘柄/テーマの最終採否は常にFIC。scout/theme_scoutは候補提示まで。

---

## 3. 各論点（C-1〜C-6）への回答

### C-1 ツール分担の見直し
- **X投稿**: Codexである理由は当時のアドバイスのみ。x_writer subagentで執筆品質を上げ、Sheets(AU/AV)も x_writer が直接更新。
- **動画台本とレンダリングの分割**: videographer=台本/シーン構成/素材指示書/SVG・React図解素材。Codex=TTS/レンダ/YouTubeアップ。
  台本は王子HD型標準（参考 https://youtube.com/shorts/f5ufrs-L3UI）。Shorts 50〜60秒、長尺 3:00〜4:45。
- **レビューの分離**: ファクトチェック(数値/単位/年度)=Codex継続（一次資料パック保持）。編集判断(読者の疑問/表現強度)=reviewer。

### C-1補足: 画像・WP・Sheets の役割分担（確定）
- **AI画像生成 = Codex継続**: 現状2枚のAI画像をCodexが作り品質に満足。OpenAI系画像APIとシームレス連携、FIC独自絵柄
  (`fic_impact_map_ai_style_reference_01.png` 等)を再現しやすい。designerは「AI画像発注書(プロンプト)」を作り
  `handoff_designer_to_codex_image.md` でCodexへ。生成画像をdesignerが受領・配置。新Skill `ai-image-prompt-rules`。
- **非AI図表 = designerが自作**: SVG/Reactで作成（コストゼロ）。`chart-templates` Skill参照。
  種類: ウォーターフォール図/時系列ライン/リスクマトリクス/因果構造図/業績比較バー等。
- **WordPress反映 = Claude Codeに完全集約（一気に全移行）**: designerが WP REST API を直接叩く。
  記事本文・画像メディアアップロード・メタ情報(title/slug/category/eyecatch)すべて。既存IDあれば更新・なければ新規（原則更新）。
  タイトルはHTML冒頭メタコメント `article_title:` を最優先（`<h1>`から抽出しない）。アイキャッチは指定なければ変更しない。
  スラッグは決定済みなら絶対変更しない。WP認証は現Codex使用の Application Password を流用。
  配置: `fic-investment-system/.secrets/wordpress.env`（gitignore対象外、settings.json deny例外）。
- **Google Sheets更新 = Claude Codeに完全集約**: 各subagentが完了時に直接更新。`.gcp-sheets-credentials.json` を流用（配置別途確認）。

### 更新内容の役割分担
- **スプレッドシート = 俯瞰用メタのみ**（ステータス/完了時刻/成果物パス/簡単な備考）。
- **handoff_*.md = 詳細な業務引き継ぎ**（完了内容詳細/注意事項/次工程への具体指示）。
- 新Skillを2つに分離: `handoff-templates`（書式・必須項目・命名規則）と `sheets-status-update`（列の意味・更新フォーマット・エラー時挙動）。全役員が両方参照。
- **両方更新を強制**: 各subagent定義に「完了時の必須アクション」を明示 — ①handoff作成 ②Sheets該当列更新 ③reportに両方完了を含める。人手コストゼロで両方更新。

### C-2 工程内の往復
- 現実に Claude→Codex→Claude の反復が発生。新体制では writer→reviewer→writer のループを subagent 間で完結。
  外部handoffは "writer→reviewer" と "reviewer→designer" の2点に整理。

### C-3 handoff命名の不整合
- `handoff_{from}_to_{to}.md` で統一。全工程。X投稿は企業/業界とも独立工程として明示。形式は `handoff-templates` Skillで一元管理。

### C-4 ルールの重複・分散（Skill化の本丸）
- 抽出候補: source-hierarchy / expression-strength-rules / related-stocks-classification / quality-self-check(=article-quality-checklist) / factual-handling-rules。
  業界分析にも企業03同等のセルフチェックを適用し非対称を解消。

### C-5 銘柄選定とテーマ選定
- **企業の銘柄選定**: 現状GPT相談→FIC判断→シート手入力（GPT使用は慣れの問題）。→ scout subagent新設・Claude集約。
  `stock-selection-criteria` Skill参照。最終判断FIC。出力先=企業分析タブ。
- **業界のテーマ選定**: 業界01でCodexが候補記録→FIC選択。→ theme_scout subagent新設、業界01移行。
  `theme-selection-criteria` Skill参照。最終判断FIC。

### C-6 未確認ファイル
- 必読7＋次点群を精読済み（一覧は phase1_2_current_state.md 末尾）。

---

## 4. 認証情報の配置方針

- WP: `fic-investment-system/.secrets/wordpress.env`（Application Password等）。gitignore対象外（=追跡しない）、settings.json deny例外指定。
- Google Sheets: `.gcp-sheets-credentials.json` を Claude Code から読める場所へ（`.secrets/` 集約を想定。配置別途確認）。
- 物理ファイルはフェーズ5で作成（フェーズ4では配置設計のみ）。

---

## 5. 新規Skill候補（14、整理後5〜12へ集約推奨）

stock-selection-criteria / theme-selection-criteria / article-quality-checklist / video-script-rules /
chart-templates / ai-image-prompt-rules / x-post-patterns / source-hierarchy / expression-strength-rules /
related-stocks-classification / factual-handling-rules / handoff-templates / sheets-status-update / wordpress-publishing

## 6. 制約（再設計全体）

- フェーズ4は実装しない。マッピング案まで。`.claude/agents/` `.claude/skills/` の実ファイルも認証情報の物理ファイルも作らない。
- 過去の試行錯誤で意図的に重複配置された規律（多段防御）を尊重。Codexを完全置換しない（役割分担の最適化が目的）。

## 7. 次ステップ（フェーズ5予告）

採用Skills/Subagents最終確定 → 認証情報配置（.secrets/作成）→ パイロット実装（1〜2 Skill＋2〜3 Subagent）→
過去記事の再現テスト → 全面移行。
</content>
