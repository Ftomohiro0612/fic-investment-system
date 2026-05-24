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

### 教訓即時反映の「3層型」（標準型・2026-05-24 L-021で実証・FIC評価）

段階4標準プロトコル「定義→本作業→点検→教訓即時反映」サイクルの**教訓即時反映の標準型**として、L-021（SVGデータ図の見やすさ規律）が3層構造で再現性を担保したことをFICが評価＝**次回以降の教訓記録の参照型**とする。

**3層構造**：

| 層 | ファイル | 役割 | 例（L-021） |
|---|---|---|---|
| **層1：具体ルール** | 領域別ガイド（例：`docs/data_figure_lessons.md`） | 「次に同じ作業をする時に何を守るか」を具体ルールとして書く | L-021＝注釈枠幅・viewBox高さ・略語禁止・±使用条件・ブラウザ自己検証の4セクション追補 |
| **層2：教訓本体** | `docs/chat_workflows/_analysis/review_lessons_log.md` | 「いつ・どこで・どう発見されたか・普遍性は」を教訓として記録 | L-021エントリ（日付・対象記事・指摘内容・根本原因・反映先・curation判定） |
| **層3：実装ゲート** | subagent定義（例：`.claude/agents/designer.md` §7） | 「次回 subagent が起動した時に確実に実行する」ゲートとして組み込む | designer.md §7 1a項「フェーズ1完了の前にブラウザ自己描画確認」 |

**3層分離の利点**：
- 段階3パイロット時代は教訓を1箇所に書いて終わりがちだったが、3層分離により「ルール参照（層1）・教訓追跡（層2）・実装ゲート（層3）」の役割が明確化。
- 新規 subagent作成時は層1+2でガイドを参照、改修時は層3で実装漏れを防ぐ、レビュー時は層2で教訓履歴を辿る、と各役割が独立して機能。
- §7ゲート対象は層3（`.claude/skills/` および `.claude/agents/` 編集はFIC承認）。層1・層2は §7対象外＝即時反映可。
- 「データ的一般化」（複数事例で初めて普遍性が見える教訓）はまず層2に記録、複数事例蓄積後に層1へ昇格、最後に層3に実装ゲート化、という段階的昇格パスが可能。

**運用ルール**：
- 次回以降の教訓記録（L-022以降）は、原則として「層1だけ」「層2だけ」で完結しない。少なくとも層1+層2の2層、可能なら層3まで含めた3層を意識する。
- 1事例だけの教訓は層2のみ（curation判定＝要追加観察）、複数事例で普遍性が確認できたものは層1へ追補、subagentの行動を変える必要があるものは層3まで反映。
- 層3反映はFIC承認領域（`.claude/agents/`・`.claude/skills/`）のため、提案として残し承認後に commit。

→ 本セクションは Phase 5 移行の標準資産。CLAUDE.md §3「進行管理ルール」への昇格 or 独立ドキュメント `docs/chat_workflows/_analysis/phase5_standard_protocol.md` への展開はFIC判断（優先度=中・段階4完了後でも可）。

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

### Phase 5 縦ライン1本完成宣言：**MS1 構造実証達成**（2026-05-24）

> ★ **MS1 達成・MS2/MS3 は次フェーズ** ★
> Phase 5 移行は「**構造実証（MS1）**」と「**FIC独自分析実証（MS2）**」の両軸で評価する。本日確定するのは MS1のみ。

| マイルストーン | 達成判定 | 状況 |
|---|---|---|
| **MS1：縦ライン1本完成（構造実証）** | researcher_company→writer→reviewer→designer 4段の§2継承＋3層型＋5図配置 | ✅ **2026-05-24 達成** |
| **MS2：FIC独自分析実証** | L-027（FIC意見表出）＋L-028（FIC独自ドライバー選定）の3層反映＋王子HD改訂版（部分改訂・候補3チップ感応度＋候補1一時要因クラスター） | ✅ **2026-05-24 達成** |
| **MS3：Phase 5 移行核心価値完成（両軸）** | MS1＋MS2 完了 | ✅ **2026-05-24 達成（MS1+MS2両軸完成）** |

### ★Phase 5 移行核心価値完成宣言（MS3達成・2026-05-24）★

**3861_oji_v4_pilot で「構造実証（MS1）」と「FIC独自分析実証（MS2）」の両軸が完成稿レベルで実証された**。

#### MS2 達成の決定的証拠（FIC評価・2026-05-24）
- **L-028 視点1（隠れドライバー＝一時要因クラスター約843億円）**：T4を T4a（資本効率改革・継続枠）/ T4b（一時要因クラスター・剥落予定）に分解し、公式中計の枠外にある「隠れドライバー」をFIC独自視点で明示。当期純利益+94億の主因をFIC見立てラベルで踏み込み。
- **L-028 視点3（実質比重＝チップ感応度46.4億 > パルプ34.3億）**：会社開示感応度を逆算し「会社の説明はパルプ市況を前面に出すが、実質的にはチップ価格変動も同等以上の監視対象」をFIC評価ラベルで明示。
- **B-10 FIC意見表出度**：FIC意見ラベル4箇所＋5論点中3点カバー（中計達成可能性／パルプ市況実質比重／一時要因クラスター見立て）＝基準クリア
- **B-11 FIC独自ドライバー視点**：4視点中2点組み込み＝基準クリア

→ 「公開IRより踏み込んだFIC独自分析」が構造的に担保され、完成稿レベルで初めて達成。「会社が言ったから」型のドライバー選定から「複数情報源分析・確度高い推測」型への転換が実証された。

#### MS3 達成の意義（Phase 5 移行核心価値の完成）
- **Make/Codex時代を超える価値を確立した決定的なマイルストーン**
- 4段縦ライン継承（researcher→writer→reviewer→designer）＋3層型教訓即時反映＋FIC独自分析の構造的担保 = 残り5ロール展開（researcher_industry／x_writer／videographer／scout／theme_scout）の土台となる Phase 5 移行核心資産
- 標準プロトコル「定義→本作業→点検→教訓即時反映」を**4回連続再現成功**（designer段階4／researcher_company／designer縦ライン検証／王子HD MS2部分改訂）

#### 達成までの commit history
- MS1 commit: 012c9d2／2dc8bc0
- L-027/L-028 規律設計: bd5f601（層1）／bf7d9d1（層3）／710450d（CLAUDE.md §3 4メタ規律統合）／3eaf5f6（3層適用整理表）
- MS2 王子HD改訂版: work/ gitignore（部分改訂はローカル保持）

#### 教訓蓄積（L-001〜L-028・28事例）
- 段階1〜段階3：L-001〜L-016（writer/reviewer 試作・本作業実証）
- 段階4 designer：L-009〜L-016（縦ライン構造の継承プロトコル・二層QA）
- 段階4 researcher_company：L-017〜L-019（鍵明示・WebSearch要約取り違え・命名統一）
- 段階4 縦ライン検証：L-020〜L-023（L-018実運用効果・SVG見やすさ3層型・AI画像配置・配置原則）
- 段階4 MS2準備：L-024〜L-027（メタ規律2件＋FIC意見表出＋FIC独自ドライバー選定）の3層反映
- 段階4 MS2達成：L-028（独立ドキュメント新設＋4ファイル層3反映＋CLAUDE.md §3原則11）

→ 次フェーズ Step 5：researcher_industry Phase 0 着手（L-028規律組み込み済の状態で開始）。Phase 0 論点5点（writer.md業界転用可否／output format整合／業界素材接続／§2継承3点／§8公式版+FIC独自版両併記）の整理から本格着手。

### 構造実証（MS1）の達成内容

| 工程 | 状況 |
|---|---|
| researcher_company | ✅ 完了（commit 608b745） |
| writer（差し戻し0周） | ✅ 完了 |
| reviewer（合格・blocker/major=0） | ✅ 完了 |
| designer フェーズ1（SVG×3＋AI仕様＋プレースホルダ） | ✅ 完了 |
| **二層QA② SVG3点**（FIC実機確認） | ✅ OK判定（L-016） |
| designer フェーズ2（AI画像差し替え＋配置パターンB最適化） | ✅ 完了 |
| **二層QA② 全5図**（FIC実機確認・配置原則検証含む） | ✅ **OK判定** |

→ **3861_oji_v4_pilot で企業分析パイプライン縦ライン1本完成**。researcher_company → writer → reviewer → designer の4段で §2継承プロトコル（L-009）が**完全機能**し、中心命題・ドライバー4本・同業比較核心の3点が全工程で一貫保持された。**Phase 5 移行の核心価値が完成稿レベルで実証**。

### 縦ライン1本完成と同時の3項目実施（2026-05-24）
1. **`docs/lessons_3layer_pattern.md` 新設**（FIC案B）：L-021/L-022/L-023を3事例として参照型で記載＋3層型の柔軟運用ルール（L-026相当：教訓の性質に応じて層を選ぶ・全層必須ではない）＋C'案基準（即時反映可／段階4送りの判定基準）も明文化。段階4以降の subagent 展開時に全 subagent が参照可能な形。
2. **L-024/L-025 を review_lessons_log.md に追記**：L-024（設計判断時の想定 vs 実装後の実態のズレ）＋L-025（bypass運用下のClaude Code自己規律）。両者ともメタ規律型＝3層型柔軟運用で層2＋α適用。CLAUDE.md追記文案は3段階フロー（起草→FIC壁打ち→FIC承認）でFIC判断待ち。
3. **残り5ロール展開順序確定（A案・順次・1ロールずつ）**：
   1. **researcher_industry**（業界分析）— 4段継承パターンを業界分析にも横展開・Phase 5核心価値「縦ライン構造の汎用性」実証
   2. **x_writer**（X投稿）— 完成記事から派生・短文制作の縦ライン
   3. **videographer**（動画）— 完成記事から派生・大型工程
   4. **scout**（銘柄選定）— 最上流（既存候補で回るため緊急度中）
   5. **theme_scout**（テーマ選定）— 同上

### researcher_industry 着手前のPhase 0論点（FIC事前提起・2026-05-24）
1. writer.md の §0入力把握・§1構成が業界分析の起点イベント型記事に転用可能か
2. researcher_industry の出力フォーマット（`industry_input_pack.md`）が writer §2継承プロトコル（中心命題・ドライバー・同業比較核心）と整合するか
3. 業界分析特有の素材（サプライチェーン3区分・直接恩恵/確認候補/周辺材料の銘柄分類・先行指標の更新頻度＋確認先）が writer 出力にどう接続するか
4. 業界分析の §2継承3点は何になるか（企業分析の「中心命題・ドライバー4本・同業比較核心」に対応する業界分析版の確定3点）

→ 上記4点を Phase 0 で整理してから researcher_industry 本作業に入る。並行展開（x_writer・videographer の並行可能性）の解禁タイミングもPhase 0で再判断。

### MS2 着手前の優先事項（2026-05-24 FIC合意）

縦ライン1本完成宣言（MS1）と並行で、FICから「**FIC意見表出度**」「**ドライバー選定の独自性**」の2論点が提起＝**Phase 5 移行核心価値の半分（FIC独自分析実証）が未達**と判明。改善のためL-027/L-028を新規教訓として記録＋3層型反映で**MS2達成**を目指す。

**L-027（FIC意見の積極的表出ルール）**：会計士視点の独自評価・複数情報源から確度高く推測できる見立てを、ガード規律と矛盾しない範囲で積極的に記事に残す。expression-strength-rules SKILL §5新設＋ writer/reviewer/article-quality-checklist の3層反映候補（C'案・即時反映可）。

**L-028（FIC独自ドライバー選定ルール）**：研究フェーズで「公式版（会社開示フレーム）」と「FIC独自版（複数情報源分析）」を両併記し、記事ではFIC独自版を優先採用。researcher_company.md §8変更＋ writer/reviewer/article-quality-checklist の3層反映候補（C'案・即時反映可）。

**MS2着手の作業順序**（D-1案・researcher_industry より先）：
1. **L-027/L-028 規律設計**（3層型反映フロー：層2即時記録、層1/層3 起草→FIC壁打ち→FIC承認）
2. **CLAUDE.md追記文案統合**：L-024/L-025/L-027/L-028の4メタ規律を §3 に統合追記（起草→FIC壁打ち→FIC承認）
3. **王子HD改訂版（部分改訂）**：候補3チップ感応度＋候補1一時要因クラスター分解の2点 → **MS2達成判定**
4. **researcher_industry Phase 0 着手**：L-028規律を組み込んだ業界分析版の公式版＋FIC独自版両併記の出力フォーマット設計（Phase 0論点5点に追加）

MS3達成は MS1＋MS2完了時点で宣言。完全改訂（4候補フル反映）は MS3 達成時点で再評価。

### 保留（段階4後半 or 完了後）
- WP pushツール整備（`scripts/wordpress/` 未整備）＋データ図SVGのWP配信検証（mime/サニタイズ）。285Aの仕上げ（公開）。

### 新チャットで最初に読むファイル
`CLAUDE.md`／memory（MEMORY.md・自動読込）／本書（stage4_scope_notes.md）／`stage2_handoff.md`／`review_lessons_log.md`（L-001〜L-019）／`data_figure_lessons.md`／`.claude/agents/{writer,reviewer,designer,researcher_company}.md`／`.claude/skills/`／`work/company_analysis/3861_oji_v4_pilot/`（researcher_company実証データ）。
