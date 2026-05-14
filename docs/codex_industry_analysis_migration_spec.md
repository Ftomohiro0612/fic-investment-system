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
- 企業名を事前固定しない。検索結果に自然に出てきた固有名詞だけを使う。
- 高関心イベント枠を残す。主要決算、業績ガイダンス変更、大型設備投資、戦略提携、M&A、供給契約、工場建設・停止、輸出規制、政策支援、技術転換はB評価でも候補に残す。
- AI関連は最低2件を候補に残す。1件はRapidus/Tenstorrent系でもよいが、もう1件はAIクラウド投資、データセンター投資、半導体IP、CPU/GPU需要、AIソフトウェア、データセンター電力・冷却など別軸にする。
- 重複判定は削除判定ではない。近いテーマでも、最新ニュースに強い具体イベントがあれば `duplicate_check=要確認` または `重複あり` として候補に残してよい。

### シナリオ2: 業界分析記事生成

- 検索クエリは8本。役割は、トレンド定義2、波及経路2、恩恵企業2、逆風企業1、反証・リスク1。
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
3. 候補テーマを9〜12件作る。
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
2. 検索クエリ8本を作る。
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
5. WordPressは既存投稿IDを確認し、あれば更新、なければ既存投稿検索後に新規作成する。

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
