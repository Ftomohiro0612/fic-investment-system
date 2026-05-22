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

---

> 本メモは判断材料。優先順位・curation方式・プロトコルの確定は段階4着手時にFICが決める。
