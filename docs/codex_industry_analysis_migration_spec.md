# Codex/Claude Code 業界分析移行仕様

## 目的

Makeで動かしていた業界分析の2シナリオを、CodexとClaude Code中心の運用へ移す。

- シナリオ1: どのテーマで書くかを決める「トレンド候補生成」
- シナリオ2: 選ばれたテーマを記事化する「業界分析記事生成」

Makeのblueprintは、長いプロンプトと検索・整形・シート更新の分岐が混在していた。Codex移行後は、Makeの役割をそのまま再現するのではなく、以下に分ける。

- Codex: ニュース収集、検索クエリ設計、外部情報の裏取り、準備パック作成、レビュー、画像・WordPress反映
- Claude Code: 構造化メモ作成、記事HTML作成、レビューメモ作成
- Google Sheets: ステータス、パス、WordPress ID、画像フォルダ、X投稿管理

## Blueprintから移植する最重要点

### シナリオ1: トレンド候補生成

- 候補は最新ニュース起点にする。ただし原油、LNG、半導体、Rapidus/Tenstorrentだけに偏らせない。
- 日本マクロ、消費、金利、銀行、不動産、決算、設備投資、貿易、コモディティ、物流、AIクラウド/AIソフトウェアも拾う。
- Make版が拾えていたテーマの広さをCodex側に移すため、ニュース検索クエリは8本固定ではなく14本を基本にする。賃金/消費、金利/銀行/不動産、物流/EC/観光、地政学/エネルギー、企業決算/設備投資、AI/テックを必ず見に行く。
- 企業名を事前固定しない。検索結果に自然に出てきた固有名詞だけを使う。
- 高関心イベント枠を残す。主要決算、業績ガイダンス変更、大型設備投資、戦略提携、M&A、供給契約、工場建設・停止、輸出規制、政策支援、技術転換はB評価でも候補に残す。
- `trend_name` は短く強い見出しにする。`〜による〜への影響` のような弱い説明調を避け、起点イベント、制約条件、価格変化、政策/規制、業績ドライバーが一目で分かる語にする。
- AI関連は最低2件を候補に残す。1件はRapidus/Tenstorrent系でもよいが、もう1件はAIクラウド投資、データセンター投資、半導体IP、CPU/GPU需要、AIソフトウェア、データセンター電力・冷却など別軸にする。
- 重複判定は削除判定ではない。近いテーマでも、最新ニュースに強い具体イベントがあれば `duplicate_check=要確認` または `重複あり` として候補に残してよい。

### シナリオ2: 業界分析記事生成

- 記事化用の検索クエリは12本。役割は、トレンド定義2、波及経路2、恩恵企業2、逆風企業1、反証・リスク1、先行指標1、類似過去事例1、周辺業界/二次波及1。
- 検索結果の採用順位は、公式IR、企業決算、公的統計、業界団体統計、主要メディアを優先する。
- Facebook、LinkedIn、Substack、個人ブログ、投資SNS、暗号資産系ニュース、旅行記事、テーマ不一致ページは中心根拠にしない。
- シナリオ1の企業例、driver_type、影響業種、影響方向は暫定値。記事化前に検索結果と一次情報で再評価する。
- 古いメモ値より、記事生成日に近い最新決算・最新先行指標を優先する。
- demand、order、backlog、revenue forecast、sales、profit、price、costを混同しない。
- 政策テーマは、確定事項と未確定・仮説を分ける。
- 市場全体指標を個社業績へ直結させず、中間変数を挟む。
- 反証条件、市場が織り込み済みの可能性、ボトルネックを必ず入れる。

## シナリオ1: Codex版トレンド候補生成

### 入力

- 今日の日付
- 既存記事・既存テーマ一覧
- 最新ニュース束
  - 日本マクロ/消費
  - グローバル企業決算/設備投資
  - AI/テック/産業
  - 金融/貿易/不動産
  - 地政学/サプライチェーン
  - コモディティ/エネルギー

### Codex作業

1. ニュース検索クエリを作る。
2. Web検索でカテゴリ別ニュース束を収集する。
3. 候補テーマを10〜14件作る。
4. 候補を正規化する。
5. 既存テーマと重複ラベルを付ける。
6. シートへ、候補テキストまたは候補ファイルパスを保存する。

### 出力ファイル

`work/industry_analysis/YYYY-MM-DD/trend_candidates.md`

内容:

- 3行サマリー
- ニュース束一覧
- 候補テーマ表
- 重複判定
- A/B/C評価
- 採用理由
- 除外候補と除外理由

`work/industry_analysis/YYYY-MM-DD/trend_candidates_sheet.tsv`

列:

`trend_name | trend_theme | strength | strength_reason | time_horizon | driver_type | affected_industries | impact_direction | key_companies | summary | recommended | duplicate_check`

### 判断基準

- A: 最新ニュース起点が明確で、日本企業への一次影響と業績ドライバーが具体的。
- B: ニュース起点はあるが、個社への接続・時点・数値の一部に確認余地がある。
- C: 弱いが観測価値がある。候補段階では残してよい。

## シナリオ2: Codex/Claude Code版記事生成

### 入力

- シート上の採用テーマ行
- 既存記事タイトル一覧
- 既存関連記事URL
- 記事生成日

### Codex作業

1. 採用テーマ行を読む。
2. 検索クエリ12本を作る。
3. 検索し、URL付き外部検索結果を保存する。
4. 先行指標の追加検索を行う。
5. 業界分析準備パックを作る。
6. Claude Codeへ渡す。

### Claude Code作業

1. `industry_analysis_memo.md` を作る。
2. `industry_analysis_article.html` を作る。
3. `industry_analysis_review_notes.md` を作る。

### Codexレビュー

1. ファクト、時点、因果、個社名、URL、schemaを確認する。
2. 必要なら `codex_reviewed_article.html` を作る。
3. 画像作成前に本文レビューを完了する。
4. 画像を作成し、ローカル画像フォルダをシートに保存する。
5. WordPressは既存投稿IDを確認し、あれば必ずその投稿を更新する。投稿IDが空欄の場合のみ既存投稿検索を行い、見つからなければ新規作成する。
6. スラッグは一度決めてシートに入力されたら固定する。既存スラッグがある場合、Claude/Codexは新しいスラッグを再生成せず、schemaの `mainEntityOfPage` も既存スラッグに合わせる。

### 業界分析の画像作成方針

業界分析記事の本文内画像は、Codexレビュー後の最終HTMLを起点に、原則として**生成AI画像**で作る。単なる装飾画像ではなく、読者が画像だけを見ても「何が起点で、どの業界に効き、どの指標を見ればよいか」が分かる投資インフォグラフィックにする。

- 画像は生成AIでゼロベース作成する。参考画像、IR資料、記事中の表、既存メディア画像をそのまま模写しない。
- 参考画像は「情報設計の型」を見るために使う。具体的には、強いタイトル、因果フロー、追い風/注意点のブロック、見る指標の整理、短い日本語ラベル、大きな文字、読みやすい階層を参考にする。
- 参考画像と同じレイアウト、色、アイコン、地図、構図をコピーしない。テーマごとにオリジナルの構成へ組み替える。
- 画像内には、記事を読まなくても意味が通る文言を入れる。最低限、`タイトル`、`起点イベント`、`因果フロー`、`追い風`、`注意点`、`見る指標` を短い日本語で入れる。
- 画像内テキストは短く大きくする。長文説明や細かい数値表は入れない。日本語が崩れた場合、誤字や意味不明ラベルが残った場合は不採用として再生成する。
- 正確な売上・利益・構成比などの数値グラフは生成AI画像で作らない。表データから機械的に作るHTML/CSS/SVG/PNGを使う。
- 画像作成時点で、`AW: 画像格納フォルダ` にローカル画像フォルダのフルパスを必ず保存する。

#### 非AIグラフ・構造図の扱い

業界分析記事では、生成AI画像とは別に、必要に応じて非AIのグラフ・構造図を追加する。生成AI画像は概念理解、非AIグラフは数値理解と比較判断のために使い分ける。

- Claudeは、記事の流れを見て「どこに何の非AI図表があると理解しやすいか」を `industry_analysis_review_notes.md` に提案する。
- Claudeは、図表そのものを作らない。提案するのは、図表名、挿入位置、使う数値、出典、読者に伝える一言、実装優先度まで。
- Codexは、Claude提案と元データを確認し、HTML/CSS/SVG/PNGのいずれかで実装する。実装後は、数値整合、出典、スマホ表示、WordPress表示を確認する。
- 追加候補は原則1〜3個に絞る。読者が読み飛ばすだけの図表は入れない。
- 正確な数値を読ませるものは、生成AIではなく非AI図表にする。

非AI図表の候補:

| 図表タイプ | 使う場面 | 例 |
|---|---|---|
| 横棒グラフ | 企業別・セグメント別の規模差を見せる | 主要企業の売上高、受注残、設備投資額 |
| 積み上げ棒/構成比 | 業界内の売上構成・需要構成を見る | 電力需要の内訳、用途別市場構成 |
| ウォーターフォール | 増減要因を分解する | 営業利益の前年差、コスト増減要因 |
| ロードマップ | 時間軸の階段を見せる | 政策決定、発注、建設、売上計上 |
| 感応度表/マトリクス | 価格・為替・金利などの前提差を見る | 原油価格×為替、金利×不動産利回り |
| 先行指標ダッシュボード | 今後見るべき指標を整理する | 受注残、価格指数、稼働率、PMI |

#### 業界分析画像プロンプトの基本形

```text
Use case: infographic-diagram
Asset type: WordPress article image for a Japanese investment research article
Primary request: Create an original AI-generated Japanese investment infographic about [テーマ]. Use the reference only conceptually: a dense but readable impact map with a strong title, causal flow, benefit/risk areas, and key indicators. Do not copy the reference layout, colors, icons, maps, or composition exactly.

Text must be in Japanese and as legible as possible. Use short, large labels only.

Main title text: "[テーマ名]の影響マップ"
Subtitle text: "[起点イベント]を起点に、[業界/企業KPI]へ波及"

Core flow labels:
1. "[上流イベント]"
2. "[制約/変化]"
3. "[中間需要/設備]"
4. "[企業KPI]"
5. "[業績項目]"

Three analysis blocks:
- "追い風" with items: "[恩恵領域1]", "[恩恵領域2]", "[恩恵領域3]"
- "注意点" with items: "[ボトルネック1]", "[リスク2]", "[コスト要因3]"
- "見る指標" with items: "[先行指標1]", "[先行指標2]", "[先行指標3]"

Style/medium: polished editorial financial infographic, AI-generated, premium Japanese business media look, semi-3D icons, clean vector-like illustration, deep navy frame, white background, gold accent, green benefit area, red risk area, blue infrastructure icons.
Composition/framing: 16:9 landscape, dense but not cluttered, strong hierarchy. Put causal flow across the center with arrows. Place benefit and risk panels below, key indicators along the bottom.
Constraints: original composition, not a copy of the reference. No company logos. No real maps copied from the reference. No stock photo look. Avoid tiny text. Avoid garbled Japanese. Avoid excessive labels. No watermark.
```

#### 登録済み参考画像

- `docs/reference_images/industry_analysis/ai_power_infrastructure_map_ai_reference_01.png`
- `docs/reference_images/industry_analysis/ai_power_infrastructure_map_ai_reference_02.png`
- `docs/reference_images/industry_analysis/ai_power_infrastructure_map_ai_reference_03.png`
- `docs/reference_images/industry_analysis/ai_power_infrastructure_map_ai_reference_04.png`

これらは「AIデータセンター電力制約の影響マップ」の生成AI出力例。今後の業界分析画像では、情報密度、見出しの強さ、因果フロー、追い風/注意点/見る指標の配置を参考にする。

### 出力ファイル

`work/industry_analysis/<slug>/`

- `source_search_results.md`
- `leading_indicators.md`
- `industry_analysis_input_pack.md`
- `industry_analysis_memo.md`
- `industry_analysis_article.html`
- `industry_analysis_review_notes.md`
- `codex_reviewed_article.html`
- `codex_review_notes.md`
- `images/`

## Claude投入パック構成

```markdown
# 業界分析 Claude投入パック

## 1. 投資テーマ
- トレンド名:
- 投資テーマ:
- 強さ:
- 時間軸:
- driver_type:
- 影響業種:
- 影響方向:
- シナリオ1の企業例:
- Codex再評価後の主要企業:

## 2. 記事生成日
- YYYY-MM-DD

## 2.5 シート管理情報
- 既存WordPress投稿ID:
- 既存記事タイトル:
- 既存スラッグ:
- 既存キーワード:
- 既存スラッグがある場合は、SLUG出力とArticle schemaのURLに必ずその値を使う。新規スラッグを作らない。
- 既存WordPress投稿IDがある場合は、公開時に新規作成せず当該IDを更新する。

## 3. 3行サマリー
- 何が起きているか
- どの業界構造に効くか
- 日本企業の売上/利益にどう波及するか

## 4. 検索結果サマリー
| 役割 | クエリ | 採用ソース | URL | 採用理由 | 注意点 |

## 5. 現在の水準
| 指標 | 数値 | 時点 | 出典 | 対象範囲 | 記事での使い方 |

## 6. 因果チェーン
| 上流イベント | 行動主体 | 業界内部メカニズム | 企業KPI | 業績項目 | ラグ | 反証条件 |

## 7. 恩恵・逆風企業
| 企業 | コード | 直接/間接 | セグメント | 確認済みIR/統計 | 業績への効き方 |

## 8. ボトルネック
- 労働力
- 設備能力
- 原材料/部品
- 規制/許認可
- 需要側制約

## 9. 3シナリオ
| シナリオ | 前提 | 見る指標 | 業績への方向 | 反証条件 |

## 10. 参照資料候補
| 資料名 | URL | 種別 | 本文で使う論点 |
```

## 記事品質ゲート

- 冒頭で、個別企業分析ではなくテーマ波及分析であることが分かる。
- 1行サマリー、30秒要約、現在の水準表、FAQ、schemaの主旨が一致する。
- 市場指標と個社指標を混同していない。
- 強い数値、日付、政策、規制は出典名・時点・対象範囲がある。
- 現在値として使う数値は、記事生成日時点で古すぎない。
- 未来イベントは記事生成日より後のものだけ。
- 主要企業は正式社名・現行証券コードで書く。
- 主要企業として扱うなら、最低1つはIR/決算/公的統計/主要メディアの確認材料がある。
- 反証条件とボトルネックがある。
- 読み飛ばされるだけのKPI羅列をしない。
- 弱い出典の数値をsummary-box、現在の水準表、FAQ、schemaの中心根拠にしない。

## FIC記事管理v3 業界分析タブ

v3では、企業分析タブと同じく左から右へ作業が流れる列順にする。旧v2列順のデータは `業界分析_旧列順控え_20260515` に残し、現行 `業界分析` タブは「依頼 → テーマ候補 → 記事化準備 → Claude → レビュー → WP/X/画像」の順で管理する。

### 列順

| 列 | 列名 | 用途 |
|---|---|---|
| A | Codex依頼/次アクション | 自然文で次にやることを書く入口 |
| B-M | trend_name〜duplicate_check | シナリオ1のトレンド候補生成結果 |
| N | トレンド候補生成メモ | シナリオ1のニュース束、候補生成ログ、除外理由 |
| O | ステータス | 採用、作成中、完了などの主ステータス |
| P-R | 記事タイトル、スラッグ、キーワード | 記事化時のSEO基本情報 |
| S-T | カテゴリ、カテゴリID | WordPress分類 |
| U-W | 記事検索クエリ、外部検索結果、先行指標データ | Codexの追加調査と根拠管理 |
| X-Y | Claude投入パック、Claude投入日 | Claude Codeへ渡す準備情報 |
| Z-AC | Claude出力_分析メモ、分析メモ、Claude出力_記事本文、記事本文 | Claude出力と最終本文の管理 |
| AD-AJ | GPTレビュー状態〜URL/JSON-LDチェック | Codexレビューの状態、指摘、ファクト、因果、URL、schema確認 |
| AK | Codex修正後HTML | レビュー反映後の最終HTMLまたはパス |
| AL-AN | WordPress投稿ID、WP反映ステータス、シート反映ステータス | WordPressとシート更新の完了管理 |
| AO-AQ | 最終更新日、最終レビュー日、レビュー担当メモ | 更新・レビュー履歴 |
| AR-AT | 投稿フラグ、X投稿用 業界メモ、X投稿文章 | X投稿管理 |
| AU-AX | 画像作成ステータス、画像挿入済みHTML、画像格納フォルダ、動画作成ステータス | 画像・動画管理 |
| AY-AZ | 作業フォルダ、備考 | ローカル成果物と補足 |

### 運用ルール

- フィルター対象はAZ列までとする。
- 旧本文や旧画像HTMLは残すが、新規作業では長文セルに依存しすぎず、作業フォルダとパスで追跡する。
- 画像を作成したら、必ずAW列に画像格納フォルダを書く。
- WordPress反映時はAL列の既存投稿IDを最初に確認し、IDがあれば更新する。IDが空の場合のみ既存投稿検索後に新規作成する。
- Q列のスラッグは固定値として扱う。Q列に値が入っている行では、記事再生成・レビュー・WP更新時にスラッグを変更しない。Q列が空欄の新規記事だけ、P列タイトルからスラッグを新規生成する。
- 業界分析では、読者が読み飛ばすKPI羅列を避ける。規模表は「何を判断するための数字か」が分かるものだけ残し、必要ならグラフや横比較に置き換える。

## 既存プロンプトの正本

- ニュース検索クエリ: `prompts/search/industry_news_query_generation_main.md`
- 記事検索クエリ: `prompts/search/industry_analysis_article_query_generation_main.md`
- トレンド候補生成: `prompts/article/industry_analysis_trend_list_main.md`
- トレンド候補整形: `prompts/article/industry_analysis_trend_validation_main.md`
- 業界分析メモ: `prompts/article/industry_analysis_memo_main.md`
- 業界分析記事: `prompts/article/industry_analysis_article_main.md`

## 明日やること

1. 業界分析シートの現行列を確認する。
2. シート更新スクリプトをv3列に合わせる。
3. 1テーマでブラインドテストする。
4. Make版とClaude Code版を比較する。
5. 不足した項目を本仕様とプロンプトへ戻す。
