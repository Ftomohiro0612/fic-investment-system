# Make時代「企業分析_v5(codex)」フロー 設計示唆（機密抽出版）

位置づけ：Make.com の旧シナリオ「企業分析_v5 (codex)」ブループリント（FIC共有・2026-05-22）から、**researcher_company 設計に効く構造だけ**を抽出した参考資料。**生JSONはAPIキー（OpenAI/Serper/FMP）平文混入のため非保存**（CLAUDE.md §6）。生JSONを残す場合は伏字化 or `work/`（gitignore）配下に。共有時点で露出済みのため**3キーはローテーション推奨**。
出典：`企業分析_v5 (codex).blueprint.json`（Make非稼働・歴史的参照のみ。[[make-fully-migrated]]）。

## 旧フローの全体構造（モジュール順）

1. **行選択**：Sheets「企業分析」から未処理行を1件取得（FMP APIで industry/sector 補完）。
2. **PDF→テキスト→要約**：決算説明資料／中計／統合報告書／その他資料のPDF URLを PDF.co でテキスト化 → GPT-4.1-mini で各PDFを要約（年度ラベル・単位×10・タイムラグ符号・セグメント推定禁止等の**大量の数値ガードをプロンプトに内蔵**）→ シートに要約格納。
3. **検索フェーズA（統合メモ前）**：GPTが上流需要・業界指標・先行指標の**動向/トレンド**キーワードを8個生成 → Serper検索（news, gl=jp, qdr:m6）→ Claude(Sonnet)が**統合分析メモ**を作成（`最上流の需要→業界指標→企業の先行指標→売上→利益`の因果分解）。
4. **検索フェーズB（記事生成前）**：GPTが先行指標の**現在の最新値**専用キーワードを5〜8個生成 → Serper検索 → Claude(Opus)が記事本文を作成。
5. **WordPress投稿**（draft/publish）。

## researcher_company 設計に効く示唆

### 示唆1：検索は「動向」と「現在値」を2段階に分けていた（最重要）
- **フェーズA**＝ドライバー仮説を立てるための**動向/トレンド**検索。
- **フェーズB**＝記事に入れる先行指標の**現在の最新値**検索。プロンプトに明示で「現在の数値・最新値は別途検索」「KWに年度・年月をハードコードするな（"最新"で鮮度表現）」。
- → v4 spec §5「PDF直読→ドライバー仮説→先行指標リスト化→Web取得」と完全一致。researcher_company は **ドライバー仮説 → 紐づく先行指標の"現在値"取得** の2段構えを必須プロトコル化する。

### 示唆2：「PDFを読む前にWeb検索しない」が旧フローでも順序設計されていた
- シナリオ順＝PDF直読が先、Web検索が後。PDFが一次資料・Webは補強。仮説駆動（PDFでドライバー仮説→Webで補強・反証・現在値）。
- → v4 spec §5 と一致。researcher_company の必須順序：①PDF取得・直読→ドライバー仮説 ②仮説駆動Web検索（補強・反証・現在値）③pack組立。

### 示唆3：上流環境マップに紐づく構造化検索（カテゴリ並列）
- 旧フローはキーワードを5系統（最上流需要/業界指標/先行指標/リスク〔規制・競合・技術〕/競合比較）で生成。
- → researcher_company の構造化Web検索＝**6カテゴリ**（マクロ環境／業界トレンド／競合動向／技術革新／コモディティ・原材料／消費トレンド）。v4 spec §1.8「追い風逆風各5・KSF5・同業3〜5社実数・業績ドライバー候補4テーマ」と紐付け。

### 示唆4：数値ガードはプロンプトに大量内蔵されていた
- 旧GPT要約プロンプトは、単位×10／年度ラベル（FY⇔◯年◯月期・決算月別）／会計基準別ラベル／セグメント推定禁止／構成比の主語／感応度符号／一過性要因／確定値vs参考値の分離…を網羅。
- → これは現行 fact-safety 3規律（[[source-hierarchy]]/[[factual-handling-rules]]/[[expression-strength-rules]]）に**既に体系化済み**。researcher_company は新規にガードを書かず、3規律をinvokeする（重複させない）。

## 現行（Claude Code subagent化）との対応

| 旧フロー要素 | Claude Code subagentでの担い手 |
|---|---|
| PDF.co（PDF→テキスト） | researcher_company の Read（PDF視覚直読・max20頁/req）＋Bash pdftotext補助 |
| GPT PDF要約 | researcher_company が pdf_summary.md を直接生成 |
| GPTキーワード生成＋Serper検索（動向） | researcher_company の WebSearch（仮説駆動・6カテゴリ） |
| GPTキーワード生成＋Serper検索（現在値） | researcher_company の WebSearch（先行指標の現在値） |
| Claude統合メモ（Sonnet） | writer の claude_integrated_memo.md（段階3で独自価値実証） |
| Claude記事本文（Opus） | writer の claude_article.html |
| WordPress投稿 | designer（WP push整備後） |

→ **researcher_company は旧フローの「PDF要約＋2段階Web検索」を1ロールに統合**。Serper（APIキー要）は WebSearch（キー不要）に置換。
