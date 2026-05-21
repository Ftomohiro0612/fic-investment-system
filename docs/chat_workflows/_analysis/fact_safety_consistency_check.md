# fact-safety-rules 整合性チェック（3 Skill）

対象: `source-hierarchy` / `expression-strength-rules` / `factual-handling-rules`（フェーズ5 段階1, 2026-05-21）。
3 Skill は「fact-safety 3規律」として1セットで運用する。本ファイルはその相互整合の点検記録。

## 1. 相互リンク（全ペア双方向で成立 ✅）

| from \ to | source-hierarchy | expression-strength | factual-handling |
|---|---|---|---|
| source-hierarchy | — | ✅ | ✅ |
| expression-strength | ✅ | — | ✅ |
| factual-handling | ✅ | ✅ | — |

3つとも `関連Skill` 行＋本文で相互参照。前方リンク `[[related-stocks-classification]]` `[[article-quality-checklist]]` `[[writing-style]]`（未作成）も配置済み。

## 2. 関心の分離（重複・矛盾なし ✅）

- **source-hierarchy** = 情報の**出所/信頼度/鮮度/地理/URL/確度区分ラベル**（公式発表・会社説明・報道・調査会社予測・FIC仮説）
- **expression-strength-rules** = **語調/誇張/断定の強さ/タイトル整合**、および**為替・市況・業績見通しの2段構成**（会社前提の明示＋FIC独自視点）
- **factual-handling-rules** = **数値そのもの**（単位×10/年度ラベル/会計基準/セグメント推定禁止/構成比主語/感応度符号/YoY±50%注記/会社開示値vsFIC試算/調査比率の分母）

## 3. 意図的に共有するトピック（重複でなく「別角度」）

- **シェア表現**: factual＝数値整合（+7/+10pの再計算・丸め）、expression＝定性丸めの語調（`圧倒的`→`主導的地位`）＋2段構成で順位逆転リスクを補足。→ 矛盾なし。
- **2種類の出所ラベル**: source＝主張/イベントの確度ラベル、factual＝**数値の**出所ラベル（会社開示/外部推計/FIC試算）。別軸で併存（1つの数値が両ラベルを持ち得る）。
- **2段構成の橋渡し（expression改訂で強化）**: 段階1の「会社前提＋出典」は [[source-hierarchy]]、段階2の独自試算 `FIC試算` は [[factual-handling-rules]] §6 に接続。expression が source/factual を呼ぶハブになり、3規律の連携が明確化した。

## 4. 1テーマ3 Skill横断の動線（明確 ✅）

例：ある企業の**為替感応度の数値**を本文に書く場合
1. **source-hierarchy** → 出典は会社決算説明資料（強）か報道（中）か。中心根拠可否・時点。
2. **factual-handling** → 符号（円安で＋/−）・単位（億円）・結合/単独・会社開示かFIC試算か。
3. **expression-strength** → 2段構成（段階1: 会社前提120円＋出典 / 段階2: 足元150円→+150億円アップサイド `FIC試算`）。雑表現禁止。

→ 推奨invoke順 **source（使ってよい数値か）→ factual（正しく扱う）→ expression（正しく書く）**。

## 5. 未決事項（FIC判断待ち）

1. **2種類の出所ラベルの対応表**（source側の確度ラベル × factual側の開示/試算ラベル）を `article-quality-checklist` 側に1つ置くか。
2. **数値を扱う標準invoke順（source→factual→expression）**を `writer` / `reviewer` の役員定義に明記するか。
3. expression改訂で導入した **2段構成** を、`writing-style`（文体推奨）と `article-quality-checklist`（チェック項目「2段構成か」）にも波及させる（各Skill作成時に組み込み予定）。
