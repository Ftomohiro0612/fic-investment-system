---
name: handoff-templates
description: 工程間の引き継ぎファイル handoff_{from}_to_{to}.md の標準書式。各役員が1工程を完了したとき、次工程へ渡す handoff を作る。冒頭の「ステータスサマリ表（Sheets同期項目）」＋7セクション、命名規則、配置場所（各 work/{key}/ 内）、記入方法、役員別の記入例を定義する。全役員が「完了時の必須アクション」として使う。詳細な業務引き継ぎは handoff、俯瞰メタは Sheets（[[sheets-status-update]]）。
---

# handoff-templates（引き継ぎ書式）

工程をまたぐ受け渡しは、**対象案件フォルダ内の `handoff_*.md`** で行う。
このSkillは、その**形式・命名・記入方法**を全役員で統一するためのもの。

役割分担（フェーズ3確定）:
- **handoff_*.md = 詳細な業務引き継ぎ**（完了内容・判断ログ・次工程への具体指示）。
- **Sheets = 俯瞰メタのみ**（ステータス・完了時刻・成果物パス・簡単な備考）→ [[sheets-status-update]]。
- 両者をつなぐのが、handoff冒頭の「ステータスサマリ表」（＝Sheets同期項目）。

---

## 使い方（いつ・誰が・どう書くか）

**完了時の必須アクション（全役員共通）**: 工程を終えたら必ず ①handoff_*.md 作成 ②Sheets該当列更新（[[sheets-status-update]]）③reportに「handoff作成済み・Sheets更新済み」を明記。この3点セットで「人手コストゼロで両方更新」を担保する。

| 役員 | いつ書くか | 主な渡し先 |
|---|---|---|
| `researcher_company` / `researcher_industry` | 投入パック完成時 | writer |
| `writer` | 記事3点（メモ/HTML/review_notes）完成時 | reviewer |
| `reviewer` | 編集判断レビュー確定時（修正はwriterへ差し戻し） | designer |
| `designer` | 画像作成・WP反映完了時 | x_writer / videographer（＋AI画像はCodex） |
| `videographer` | 台本・図解素材・構成確定時 | Codex（TTS/レンダ/アップ） |
| `x_writer` | X投稿文確定・Sheets記録時 | （終端／FIC） |
| `scout` / `theme_scout` | 候補をFICが採択し案件化したとき（標準handoff） | researcher_company / researcher_industry |

> writer⇄reviewer の修正往復は subagent 間の内部ループで、**外部handoffは「writer→reviewer」と「reviewer→designer」の確定時のみ**作る（フェーズ4 C-2 / 6-4）。

---

## 1. 命名規則と配置場所

- 命名: **`handoff_{from}_to_{to}.md`**（from/to は役員名のsnake_case）。
- 配置: **対象案件フォルダ内**（企業 `work/company_analysis/{code}_{company}/`、業界 `work/industry_analysis/{slug}/`）。`_handoffs/` 等に集約しない（フェーズ4 7-7）。

標準 handoff 一覧（10本：パイプライン本線8 ＋ Codex連携特殊2）:

| ファイル名 | 区間 | 備考 |
|---|---|---|
| `handoff_scout_to_researcher_company.md` | 企業 銘柄採択 → 資料作成 | FIC採択時に作成 |
| `handoff_theme_scout_to_researcher_industry.md` | 業界 テーマ採択 → 資料作成 | FIC採択時に作成 |
| `handoff_researcher_company_to_writer.md` | 企業 資料作成 → 記事作成 | |
| `handoff_researcher_industry_to_writer.md` | 業界 資料作成 → 記事作成 | |
| `handoff_writer_to_reviewer.md` | 記事作成 → レビュー | |
| `handoff_reviewer_to_designer.md` | レビュー → 画像・WP反映 | |
| `handoff_designer_to_x_writer.md` | 画像・WP反映 → X投稿 | |
| `handoff_designer_to_videographer.md` | 画像・WP反映 → 動画 | |
| `handoff_designer_to_codex_image.md` | designer → Codex（AI画像生成発注） | 特殊: AI画像のプロンプト発注書（[[ai-image-prompt-rules]] 由来） |
| `handoff_videographer_to_codex_render.md` | videographer → Codex（TTS/レンダ/アップ） | 特殊: 実行系をCodexへ |

---

## 2. 標準テンプレ（コピペして使う）

```markdown
# handoff_{from}_to_{to}.md

## ステータスサマリ(Sheets同期項目)

| 項目 | 内容 |
|------|------|
| 案件キー | {例: 3861_oji_holdings} |
| 工程 | {例: 画像作成・WP反映} |
| 担当役員 | {例: designer} |
| 次工程 | {例: videographer} |
| 状態 | {完了 / 部分完了 / FIC確認待ち / エラー} |
| 完了時刻 | {YYYY-MM-DD HH:MM} |
| 所要時間 | {分} |
| 成果物パス | {主要成果物のファイルパス} |
| Sheets同期列 | {例: AM=WP投稿ID, AN=公開, AW=完了, AY=画像フォルダpath} |

---

## 1. 完了内容(何を作ったか)
- {作成・更新した成果物を箇条書き。ファイル名と1行説明}

## 2. 判断ログ(なぜそうしたか)
- {迷った点と採否理由。数値・出典・表現の判断は fact-safety 3規律に照らした結果も}

## 3. 未完了/保留事項
- {やり残し・要追加確認。無ければ「なし」}

## 4. 次工程への指示
- {次役員が最初に読むファイル、最優先タスク、守るべき制約(例: 既存スラッグ固定)}

## 5. 注意事項/リスク
- {壊してはいけない前提、既知のリスク、表示崩れ等}

## 6. 関連ファイル一覧
- {次工程が参照する全ファイルのパス}

## 7. 連絡事項(FIC向け)
- {FICの判断が要る点、承認待ち事項。無ければ「なし」}
```

---

## 3. ステータスサマリ表の書き方（Sheets連携）

- 冒頭の表は **Sheets の俯瞰メタと同期する項目**。`状態`・`完了時刻`・`成果物パス` は Sheets 側の該当列にも書く（[[sheets-status-update]]）。
- `Sheets同期列` 欄に、今回更新したシート列を明記する（例: 企業タブ `AM=WP投稿ID, AN=公開`）。これで「Sheetだけ見ても進捗が分かる／handoffを開けば詳細が分かる」の二層が成立する（フェーズ4 6-4）。
- `状態` は4値（完了 / 部分完了 / FIC確認待ち / エラー）。`部分完了`・`FIC確認待ち`・`エラー` のときは、テンプレ本文の「3. 未完了/保留事項」と「7. 連絡事項(FIC向け)」に理由と次アクションを必ず書く。`FIC確認待ち` は writerのファクト判断・reviewerの表現強度最終判断・designerの画像生成結果確認など、FICの判断を待つ状態に使う。これは「handoffという行為」の状態であり、案件全体のワークフローステータス（採用/作成中/公開済み等）は別語彙（§6参照）。

---

## 4. 7セクションの書き方

| 節 | 書くこと | よくある不足 |
|---|---|---|
| 1 完了内容 | 成果物の事実（何を作ったか） | 抽象的すぎてファイル名が無い |
| 2 判断ログ | なぜその判断をしたか（fact-safetyに照らした採否も） | 結論だけで理由が無い |
| 3 未完了/保留 | やり残し・要確認（無ければ「なし」明記） | 省略して下流が気づけない |
| 4 次工程への指示 | 次役員の最初の一歩・最優先・守る制約 | 「よろしく」だけ |
| 5 注意事項/リスク | 壊してはいけない前提（既存スラッグ固定等） | スラッグ/IDの注意が抜ける（6-2事故） |
| 6 関連ファイル一覧 | 次工程が読む全パス | パスが古い/相対不明 |
| 7 連絡事項(FIC向け) | FIC判断待ち（無ければ「なし」） | 承認待ちが埋もれる |

---

## 5. 役員ごとの記入例（バリエーション）

### 例A: `handoff_researcher_company_to_writer.md`（資料作成 → 記事作成）

```markdown
## ステータスサマリ(Sheets同期項目)
| 案件キー | 3861_oji_holdings |
| 工程 | 企業 資料作成 |
| 担当役員 | researcher_company |
| 次工程 | writer |
| 状態 | 完了 |
| 成果物パス | work/company_analysis/3861_oji_holdings/claude_input_pack.md |
| Sheets同期列 | Z=投入パックpath, AA=2026-05-21, AP=Claude記事作成待ち |

## 4. 次工程への指示
- 最初に CLAUDE_CODE_FIC_INSTRUCTIONS.md → claude_input_pack.md → pdf_summary.md の順で読む
- v4・15章構造で記事化。過年度5期推移は H2-3 に必ずテーブルで載せる
## 5. 注意事項/リスク
- 為替/業績見通しは2段構成で（会社前提120円を明示＋FIC視点）。詳細は expression-strength-rules
```

### 例B: `handoff_designer_to_codex_image.md`（AI画像の発注、Codex宛＝特殊）

```markdown
## ステータスサマリ(Sheets同期項目)
| 案件キー | 3861_oji_holdings |
| 工程 | AI画像発注 |
| 担当役員 | designer |
| 次工程 | Codex(AI画像生成) |
| 状態 | 完了 |
| 成果物パス | work/company_analysis/3861_oji_holdings/handoff_designer_to_codex_image.md |

## 4. 次工程への指示(=AI画像プロンプト発注)
- 必要枚数・各画像のプロンプト（ai-image-prompt-rules準拠）・参考画像・配置位置・文言を記載
- 生成後の画像は designer が受領し with_images.html へ配置する
## 5. 注意事項/リスク
- FIC独自絵柄(fic_impact_map_ai_style_reference_01/04)を参考。文字崩れ時は再生成
```

> 他の区間（writer→reviewer、reviewer→designer、designer→videographer、videographer→codex_render）も同じ書式。`次工程` と `Sheets同期列` を区間に合わせて変えるだけ。

---

## 6. fact-safety 3規律との接続

handoff で**数値・出典・表現を引き継ぐ**とき、§2判断ログ・§5注意事項に、3規律に照らした判断を残す。

- 出典の質・URL・確度: [[source-hierarchy]]
- 数値・単位・年度・試算ラベル: [[factual-handling-rules]]
- 表現強度・2段構成: [[expression-strength-rules]]

特に **6-2の事故防止**（既存投稿ID更新・スラッグ絶対固定）は、`reviewer→designer` と `designer` 関連handoffの §5 注意事項に**必ず明記**する。

なお、handoff冒頭の `状態`（4値: 完了 / 部分完了 / FIC確認待ち / エラー）は「**handoffという行為**」の状態であり、**案件全体のSheets正式ステータス**（採用 / 作成中 / 公開済み / 要確認 等）とは**別語彙**。Sheets正式ステータスとの整合性は、専門Skill [[sheets-status-update]] が `v3_ステータス定義` タブに準拠して別途担保する（前方リンク）。handoff-templates は handoff 単独で完結する設計とする。

---

## 7. セルフチェック（handoff作成時）

- [ ] ファイル名が `handoff_{from}_to_{to}.md` で、対象案件フォルダ内にあるか
- [ ] ステータスサマリ表の全項目が埋まっているか（`状態`・`成果物パス`・`Sheets同期列` 必須）
- [ ] Sheets該当列を実際に更新したか（[[sheets-status-update]]）。reportに両更新を明記したか
- [ ] 7セクションが揃い、`未完了/保留`・`連絡事項` は無ければ「なし」と明記したか
- [ ] §4 次工程への指示に「最初に読むファイル」と「守る制約」があるか
- [ ] スラッグ固定・既存ID更新の注意（6-2）が必要な区間で §5 に書かれているか

---

## 集約元（このSkillの抽出元）

- `docs/chat_workflows/_analysis/phase4_final_design.md` §8 handoff冒頭テンプレ（ステータスサマリ表＋7セクション）
- `docs/chat_workflows/README.md` 工程間 handoff 受け渡しの基本ルール
- `docs/chat_workflows/*` 各工程テンプレの handoff 必須事項（特に company_03 の次工程handoff必須事項）
- `docs/codex_company_analysis_pack_spec.md` §7.4 品質改善ループ
- フェーズ3確定: handoff=詳細 / Sheets=俯瞰メタ の役割分担

関連Skill: [[sheets-status-update]] / [[source-hierarchy]] / [[factual-handling-rules]] / [[expression-strength-rules]] / [[ai-image-prompt-rules]]
</content>
