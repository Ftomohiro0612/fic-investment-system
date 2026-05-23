# 段階4スコープ再設計の論点メモ（FIC着手判断の材料）

作成: 2026-05-22 / 作成: Claude Code / 位置づけ: **段階4着手判断はFICが別途行う**。本メモは判断材料で、決定ではない。
背景: 段階3パイロット（285A）で writer/reviewer ＋ 教訓の即時反映（C'案）まで実証済み（[[stage2_handoff]] §段階3実行結果・`review_lessons_log.md`）。残り7 Subagent＝scout / theme_scout / researcher_company / researcher_industry / designer / videographer / x_writer。

---

## 論点1：残り7 Subagent の優先順位

**選択肢**：designer先行 ／ researcher_company先行 ／ theme_scout（上流）先行 ／ 並行。

**Claude Code 推奨：①designer → ②researcher_company → ③researcher_industry → ④scout/theme_scout → ⑤videographer/x_writer**（＝1本の縦ライン完成を優先）。

- **①designer 先行**：段階3で記事は text-only。designer（図解＋WP反映）を入れると **285Aパイロット記事が公開可能まで到達**＝「researcher→writer→reviewer→designer→公開」の縦ラインが1本通る。**reviewerが handoff_reviewer_to_designer＋図表4候補を申し送り済み**＝着手素材が揃っており低リスク・高レバレッジ。「最後の1マイル（図解・WP）」の検証になる。
- **②researcher_company**：現状パックはCodex製。researcher_company を入れると**上流（一次資料収集・pack構造化）までClaude Code化**＝企業分析パイプラインが端から端まで完成（移行の核心実証）。検証題材＝復元済みの**王子HD(3861)pack**（writer別銘柄検証も兼ねる）。
- **③researcher_industry**：今回移行した**業界分析4テーマ**が検証データ／品質目標になる（公開済み制作過程が残る）。企業ラインの後に業界ラインを通す。
- **④scout / theme_scout**：銘柄・テーマ候補選定（最上流）。パイプラインは既存候補で回るため緊急度は中。
- **⑤videographer / x_writer**：完成記事に依存する配信工程。記事→公開ラインが固まってから。

> 代替案：researcher_company を designer より先に（上流から固める）。ただし designer は素材が揃い低リスクで「公開到達」という見える成果を出せるため、Claude Code は designer 先行を推す。

## 論点2：教訓curation の位置づけ（独立フェーズ or 各Subagent作成と並走）

**Claude Code 推奨：並走を基本 ＋ 段階の節目に軽いbatch curation（独立大フェーズにはしない）**。

- **即時反映（C'案）は運用に織り込み済み**：論理的原則／両ソース裏取り済み普遍ルールはその場で Skill/guide/template へ反映（段階3で実証）。
- **データ的一般化は段階の節目に batch**：複数事例で初めて普遍性が見えるものは、`review_lessons_log.md` を一覧し、**当該Skillを所有するロールのSubagentを作るタイミング**で当該教訓をまとめて curation（例：designer導入時に図解関連教訓、researcher導入時に数値・出所教訓）。
- **独立した大curationフェーズは作らない**：メタ作業の肥大化を避ける（段階1〜2の教訓「[[meta-vs-real-work]] メタと本作業の区別」）。curation は本作業に寄生させる。

## 論点3：段階3の教訓（C'案・「賢くなる1サイクル」）の段階4活用方針

**Claude Code 推奨：各ロール導入を「定義 → 本作業1本 → 点検 → 教訓即時反映」の1サイクルで行う（段階3パターンの標準プロトコル化）**。

- 段階3で確立した「**道具を作る→本作業を1本走らせる→点検→普遍教訓を即時反映**」を、段階4の各Subagent導入の標準手順にする。
- これにより各ロールも**導入時点から賢くなる仕組み**に乗り、メタ作業（定義づくり）と本作業（実走検証）が分離しない。
- C'案の「即時反映 vs 段階4」判定基準（`review_lessons_log.md` 冒頭「教訓昇格判定基準」）を段階4でも同一運用する。
- §7ゲート（`.claude/skills/` 更新はFIC承認）も同一。docs/guide/template は§7対象外。

---

## 段階4導入プロトコル（段階3から導出・たたき台）

各Subagent（designer等）について：
1. **定義案を提示 → FIC確認**（writer/reviewer同様、1ロールずつ）。
2. **パイロット本作業を1本走らせる**（designerなら285A記事の図解＋WP draft反映）。
3. **点検**（reviewer or 自己点検＋FIC目視）。
4. **横断教訓を `review_lessons_log.md` に記録 → 普遍教訓は即時反映**（C'案）。
5. **handoff＋（必要なら）Sheets更新**、FIC確認のうえ次ロールへ。

## 段階4着手時の追加検討（FIC提案 2026-05-22）

- **designer の教訓継承チェック（小ステップ）**：designer 完成後、writer/reviewer に反映済みの教訓（です・ます調／IFRSラベル＝親会社所有者帰属持分比率／予想範囲明示／反証のN四半期パターン）が designer 処理と矛盾しないか確認する。具体例：designer が画像キャプションやWP本文補助テキストを書く際の**文体基調（です・ます調）の扱い**を、**designer の system prompt 起草時にチェックポイント化**する。
- **C'案標準プロトコルのドキュメント位置**：「定義→本作業1本→点検→教訓即時反映」はPhase 5移行の中核資産。本メモ内記載に加え、段階4完了後の本番運用（FICが新Subagentを作る・既存Subagentを改修する）でも参照されるため、**CLAUDE.md への追記** または **独立ドキュメント `docs/chat_workflows/_analysis/phase5_standard_protocol.md` の新設**を検討（優先度=中・段階4着手後でも可）。
- **writer/reviewer 確定事項の継承プロトコル（段階4標準・L-009）**：後工程subagentは、upstream（writer/reviewer、特にFICエスカレーション結果）の**確定事項を明示継承**してから自分の出力を作る。最重要＝**業績ドライバー定義**（本数・名称・上流/KPI/収益化/効き方・統合/分離/除外）。本文と図／動画／X投稿の齟齬（読者誤読）を防ぐ。**designer定義v1に「確定事項の継承」セクションとして組み込み済み**。**段階4以降の全subagent定義v1（videographer・x_writer 等）に同セクションを標準組み込み**（videographer＝動画のドライバー図シーン、x_writer＝X投稿の因果でドライバー定義を反映）。複数ロール適用後、handoff-templates Skillへの昇格を判断。

---

> 本メモは判断材料。優先順位・curation方式・プロトコルの確定は段階4着手時にFICが決める。

---

## ■ 段階4 進捗と引き継ぎ（2026-05-22時点・新チャット用）

### 現在地（2026-05-23更新）
- 段階1（Skill）・段階2（writer/reviewer）・段階3（285Aパイロットで writer/reviewer 実証）＝完了。
- **段階4：designer 完了＋researcher_company 完了**。**主要4ロール（writer/reviewer/designer/researcher_company）＝Phase 5 移行の核心マイルストーン到達**。残り5ロール＝researcher_industry／scout／theme_scout／videographer／x_writer（主要4ロールの応用版・派生版・標準プロトコルに乗せるだけ）。
- **次アクション選択肢**：(A) researcher_industry 着手 ／ (B) writer試作（researcher_company→writer縦ライン検証＝3861 v4 packで記事生成）。

### designer で確定した成果（commit 47e4d37〜636bd6f）
- `.claude/agents/designer.md`（v1.2相当＋§7に6a追加）：データ図＝静的SVG自力／概念図＝AI画像仕様の折衷。§2「writer/reviewer確定事項の継承」。WP反映は scripts/wordpress 未整備で「公開直前」まで。
- 285Aパイロットの4図確定（`work/company_analysis/285A_kioxia_pilot/`・ローカル）：上流環境マップ(単列フロー・AI)／投資仮説マップ(2×2象限・AI)／用途別売上(SVG)／業績ウォーターフォール(SVG)。`claude_article.with_images.html` に挿入済み。
- 参考画像化：`docs/reference_images/company_analysis/`（fic_impact_map_ai_style_reference_01.png＝フロー型／fic_thesis_map_ai_style_reference_01.png＝2×2型＋README）。
- 教訓：L-009〜L-016（`review_lessons_log.md`）／`data_figure_lessons.md`（新規・SVGデータ図の見やすさ＝&エスケープ・単体XML検証・見切れ防止）。

### 段階4で確立した運用ルール（researcher以降にも適用）
- **導入プロトコル**＝「定義→本作業1本→点検→教訓即時反映」。各ロールで回す。
- **§2 確定事項の継承**＝後工程subagentは上流（writer/reviewer等）の確定事項を明示継承（L-009）。
- **二層検証**（L-016）＝subagent自己検証＋**人手の実機確認（ブラウザで開く）**の両層で初めて実配信OK判定。
- **AI画像生成フロー**＝subagentが仕様(ai_image_specs.md)出し→FICが手動でCodexに渡し生成→画像配置→subagentが挿入（2フェーズ・L-011）。
- **過去制約は原因特定後に判断**（L-012）。**教訓即時反映=C'案**（論理的原則/両ソース裏取り済みは即時、データ的一般化は段階4へ。§7ゲートは.claude/skills/のみFIC承認）。
- **環境メモ**：カスタムsubagentは本セッション環境では Agentツールから直接起動不可→general-purposeに定義を読ませて代行。SVG→PNGはChrome headlessで可。

### researcher_company で確定した成果（2026-05-23完了）
- `.claude/agents/researcher_company.md`（v1＋L-018/L-019反映）：認証鍵不要（WebSearch/WebFetch/curl/Read PDF直読/pdftotext）。§2必須順序＝PDF直読→ドライバー仮説→Web補強。§4＝6カテゴリ構造化Web検索＋先行指標現在値。§6＝v4 18セクション網羅（実数充填は非ゲート＝Codex並み）。§7＝writer §2継承の上流準備（4テーマ案・上流環境マップ・先行指標現在値を事前提示）。§8＝二層QA（L-016）＋2フェーズ運用（L-011/L-012）。fact-safety 3規律をinvoke。
- 3861_oji v4パイロット成果（`work/company_analysis/3861_oji_v4_pilot/`）：pdf_summary.md／claude_input_pack.md（18セクション全網羅＋v4§1.8）／handoff_researcher_company_to_writer.md。中心命題＝「営業利益半減（△48.9%）でも純利益増益（+20.4%）＝資産売却の一時要因」。ドライバー4テーマ（T1パルプ市況／T2国内需要×価格転嫁／T3ポートフォリオ転換／T4資本効率＝横断）。同業比較核心＝「パルプ市況の効き方が王子・北越（パルプ自社）vs 日本製紙・大王（パルプ外部調達）で逆」。
- v3 Codex pack比較：同業セル全空欄＝v4で実数充填（日本製紙252億+27.9%／大王240億+145%／北越75億△61.8%／レンゴー予想400億）。先行指標も名称止まり→現在値（パルプ$595/t・原油$106〜114・石炭$138/t・USD/JPY159・国内出荷△1.8%）取得＝**v3 Codex packの弱点を解消（Codex超え・非ゲート）**。
- 公開記事比較：公開記事も独立に4ドライバー小節（7.1パルプ／7.2国内需要／7.3原燃料／7.4為替・M&A）採用＝T1〜T4設計の独立検証完了。
- 教訓：L-017（鍵明示）／L-018（同業WebSearch要約の予実・累計取り違えリスク・一次資料再確認規律）／L-019（handoff命名はSKILL正本に統一）。

### 新subagent追加時・handoff変更時の標準チェックポイント（2026-05-23・L-019拡張）
- **handoff命名の全ロール横断照合**：新subagent作成時または既存subagentの入出力handoffを変更する際は、関連ロール全てのagent定義内handoff命名を `handoff-templates` SKILL正本（標準handoff一覧）と照合する。**本作業（writer起動・記事生成等）を始める前にPhase 0で済ませる**。L-019拡張（writer.md hotfix）の教訓：1ロール単位の修正では不十分で、上流→下流の連鎖で同じ命名が複数ロールに散在するため、新ロール追加・命名変更のたびに横断確認が必須。Phase 0をスキップすると§2継承プロトコル機能不全＝縦ライン検証の主目的崩壊リスク。

### 主要4ロール完成宣言（2026-05-23）
| ロール | 状況 |
|---|---|
| writer | ✅ 段階2・段階3パイロット実証 |
| reviewer | ✅ 段階2・段階3パイロット実証 |
| designer | ✅ 段階4パイロット縦ライン1本完成（285A） |
| researcher_company | ✅ 段階4パイロット完成（3861 v4 packゼロ生成・v3比較・公開記事比較・二層QA） |

→ **Phase 5 移行の核心マイルストーン到達**。残り5ロール（researcher_industry／scout／theme_scout／videographer／x_writer）は主要4ロールの応用・派生で、段階4標準プロトコル（定義→本作業1本→点検→教訓即時反映）に乗せるだけ。

### 保留（段階4後半 or 完了後）
- WP pushツール整備（`scripts/wordpress/` 未整備）＋データ図SVGのWP配信検証（mime/サニタイズ）。285Aの仕上げ（公開）。

### 新チャットで最初に読むファイル
`CLAUDE.md`／memory（MEMORY.md・自動読込）／本書（stage4_scope_notes.md）／`stage2_handoff.md`／`review_lessons_log.md`（L-001〜L-019）／`data_figure_lessons.md`／`.claude/agents/{writer,reviewer,designer,researcher_company}.md`／`.claude/skills/`／`work/company_analysis/3861_oji_v4_pilot/`（researcher_company実証データ）。
