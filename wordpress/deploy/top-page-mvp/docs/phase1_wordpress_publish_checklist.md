# フェーズ1 WordPress公開チェックリスト

作成日: 2026-05-22

Status: phase1-wordpress-publish-checklist

## 目的

`投資の読み方` 12本と `テーマの読み方` 11本を、WordPressへ安全に投入するための実作業チェックリスト。

素材の対応表は `docs/phase1_publication_matrix.md` を正とする。このファイルでは、公開順、1記事ごとの作業、公開後のURL控え、ハブ差し替え確認を扱う。

WordPress投入用に本文HTML、アイキャッチ、CSVをまとめたパッケージは `wordpress/deploy/phase1-articles/` に生成する。

公開作業の進捗管理には、パッケージ内の `metadata/phase1-article-publish-tracker.csv` を使える。推奨公開順で並んでおり、`status`、`published_url`、`published_date`、`notes` を更新しながら進めると、23本の公開状況を一覧で追いやすい。

`status` は最初 `todo` で出力する。作業中は `drafted`、公開済みは `published`、修正待ちは `needs-fix` などに変える想定。

```powershell
powershell -ExecutionPolicy Bypass -File scripts\build_phase1_article_package.ps1
```

生成後の検証:

```powershell
powershell -ExecutionPolicy Bypass -File scripts\verify_phase1_article_package.ps1
```

ローカルプレビューサーバーを起動している場合、以下で23本を一覧確認できる。

```text
http://127.0.0.1:4291/deploy/phase1-articles/previews/index.html
```

## 公開前に作るカテゴリ

WordPress管理画面で以下のカテゴリを用意する。

| カテゴリ名 | 用途 |
| --- | --- |
| `投資の読み方` | 決算、指標、財務用語の常設基礎記事 |
| `テーマの読み方` | 金利、為替、原材料、政策などの常設テーマ解説 |
| `テーマ分析` | ニュース起点の記事。旧 `業界分析` から変更予定 |

移行中は旧カテゴリが残っていてもよい。トップページとハブは、`テーマ分析` がなければ旧 `業界分析`、`投資の読み方` がなければ旧 `基礎講座` / `ビギナーガイド` も拾う。

## 1記事ごとの投入手順

各記事で同じ手順を使う。

1. `docs/phase1_publication_matrix.md` で対象記事の行を確認する。
2. WordPressで新規投稿を作成する。
3. 投稿タイトルに `タイトル` を入れる。
4. スラッグに `スラッグ` を入れる。
5. カテゴリに `カテゴリ` を設定する。
6. `wordpress/deploy/phase1-articles/bodies/` の本文HTMLを貼り付ける。
7. `wordpress/deploy/phase1-articles/eyecatch/` の画像をアップロードしてアイキャッチに設定する。
8. メタディスクリプションは `wordpress/deploy/phase1-articles/metadata/phase1-article-upload.csv` の `description` を使う。
9. プレビューで、見出し、表、ボックス、記事末尾の `次に読む` 導線、免責文が崩れていないか確認する。
10. 公開する。
11. 公開URLを `metadata/phase1-article-publish-tracker.csv` と、このファイルの `公開URL控え` に記録する。

## 推奨公開バッチ

一度に23本すべて公開してもよいが、確認負荷を下げるなら以下の順番がよい。

### Batch 1: 企業分析の土台

| No | カテゴリ | スラッグ | 公開 |
| --- | --- | --- | --- |
| 1 | 投資の読み方 | `kessan-tanshin-reading-guide` | [ ] |
| 2 | 投資の読み方 | `operating-margin-guide` | [ ] |
| 3 | 投資の読み方 | `orders-backlog-inventory-guide` | [ ] |
| 4 | 投資の読み方 | `roe-roic-guide` | [ ] |
| 5 | 投資の読み方 | `segment-information-guide` | [ ] |

確認:

- `/learn/` の「まず読む投資の読み方」にある6枠のうち、少なくとも5本が実記事として開ける。
- トップページの `投資の読み方` 件数が増えている。

### Batch 2: トップページのテーマ入口

| No | カテゴリ | スラッグ | 公開 |
| --- | --- | --- | --- |
| 6 | テーマの読み方 | `interest-rate-impact-stocks` | [ ] |
| 7 | テーマの読み方 | `fx-impact-company-earnings` | [ ] |
| 8 | テーマの読み方 | `raw-material-cost-pass-through` | [ ] |
| 9 | テーマの読み方 | `semiconductor-investment-supply-chain` | [ ] |
| 10 | テーマの読み方 | `policy-subsidy-investment-theme` | [ ] |
| 11 | テーマの読み方 | `logistics-reform-2024-problem` | [ ] |

確認:

- `/themes/` の「テーマの読み方」にある6枠がすべて実記事として開ける。
- トップページの検索チップやMarket Triggersから検索して、関連テーマ記事が見つかる。

### Batch 3: 決算・財務の補強

| No | カテゴリ | スラッグ | 公開 |
| --- | --- | --- | --- |
| 12 | 投資の読み方 | `cash-flow-guide` | [ ] |
| 13 | 投資の読み方 | `medium-term-plan-guide` | [ ] |
| 14 | 投資の読み方 | `price-pass-through-guide` | [ ] |
| 15 | 投資の読み方 | `earnings-progress-rate-guide` | [ ] |
| 16 | 投資の読み方 | `goodwill-impairment-guide` | [ ] |
| 17 | 投資の読み方 | `payout-ratio-total-return-guide` | [ ] |
| 18 | 投資の読み方 | `equity-ratio-interest-bearing-debt-guide` | [ ] |

確認:

- 企業分析記事内で使いやすい内部リンク先がそろう。
- `投資の読み方` のカテゴリ一覧が、初心者向けだけでなく中級者の確認にも耐える並びになる。

### Batch 4: テーマの横展開

| No | カテゴリ | スラッグ | 公開 |
| --- | --- | --- | --- |
| 19 | テーマの読み方 | `energy-transition-power-investment` | [ ] |
| 20 | テーマの読み方 | `labor-shortage-automation-investment` | [ ] |
| 21 | テーマの読み方 | `price-hike-consumer-demand` | [ ] |
| 22 | テーマの読み方 | `inbound-demand-company-impact` | [ ] |
| 23 | テーマの読み方 | `defense-security-investment-theme` | [ ] |

確認:

- `/themes/` の検索起点が、金利・為替・原材料だけでなく、人手不足、値上げ、インバウンド、防衛まで広がる。
- ニュース起点の `テーマ分析` 記事から内部リンクしやすい常設記事がそろう。

## 公開URL控え

公開したら、URLをここに追記する。

| スラッグ | 公開URL | 公開日 | 備考 |
| --- | --- | --- | --- |
| `kessan-tanshin-reading-guide` |  |  |  |
| `operating-margin-guide` |  |  |  |
| `orders-backlog-inventory-guide` |  |  |  |
| `roe-roic-guide` |  |  |  |
| `segment-information-guide` |  |  |  |
| `cash-flow-guide` |  |  |  |
| `medium-term-plan-guide` |  |  |  |
| `price-pass-through-guide` |  |  |  |
| `earnings-progress-rate-guide` |  |  |  |
| `goodwill-impairment-guide` |  |  |  |
| `payout-ratio-total-return-guide` |  |  |  |
| `equity-ratio-interest-bearing-debt-guide` |  |  |  |
| `interest-rate-impact-stocks` |  |  |  |
| `fx-impact-company-earnings` |  |  |  |
| `raw-material-cost-pass-through` |  |  |  |
| `semiconductor-investment-supply-chain` |  |  |  |
| `policy-subsidy-investment-theme` |  |  |  |
| `energy-transition-power-investment` |  |  |  |
| `labor-shortage-automation-investment` |  |  |  |
| `price-hike-consumer-demand` |  |  |  |
| `inbound-demand-company-impact` |  |  |  |
| `defense-security-investment-theme` |  |  |  |
| `logistics-reform-2024-problem` |  |  |  |

## 公開後のハブ確認

### `/learn/`

- [ ] ヒーローに `投資の読み方` 件数が表示される。
- [ ] `投資の読み方一覧` がカテゴリ一覧へ移動する。
- [ ] `まず読む投資の読み方` の代表リンクが公開済み投稿URLへ移動する。
- [ ] `最新の投資の読み方` に公開記事が表示される。
- [ ] 企業ハブ、テーマハブ、トップページへ戻れる。

### `/themes/`

- [ ] ヒーローに `本のテーマ記事` が表示される。
- [ ] `テーマ分析一覧` がニュース起点カテゴリへ移動する。
- [ ] `テーマの読み方` の代表リンクが公開済み投稿URLへ移動する。
- [ ] `最新のテーマ分析` にはニュース起点の `テーマ分析` が表示される。
- [ ] 企業ハブ、投資の読み方、トップページへ戻れる。

### トップページ

- [ ] `投資の読み方` の記事数が反映される。
- [ ] `テーマ分析` の記事数が反映される。
- [ ] `投資の読み方を見る` が新カテゴリへ移動する。
- [ ] `テーマ分析をもっと見る` が `テーマ分析` または旧 `業界分析` へ移動する。
- [ ] スマホでカードや検索フォームがはみ出さない。

## 公開後の内部リンク方針

企業分析記事で以下の語句が出たら、対応する `投資の読み方` へ内部リンクする。

| 記事内の語句 | リンク先 |
| --- | --- |
| 決算短信、会社予想、進捗率 | `kessan-tanshin-reading-guide` |
| 営業利益率、粗利率、販管費 | `operating-margin-guide` |
| 受注残、在庫、先行指標 | `orders-backlog-inventory-guide` |
| ROE、ROIC、資本効率 | `roe-roic-guide` |
| セグメント、事業別利益 | `segment-information-guide` |
| 営業CF、FCF、現金 | `cash-flow-guide` |
| 中期経営計画、中計 | `medium-term-plan-guide` |
| 価格転嫁、値上げ | `price-pass-through-guide` |
| のれん、減損、M&A | `goodwill-impairment-guide` |
| 配当性向、総還元性向、自社株買い | `payout-ratio-total-return-guide` |
| 自己資本比率、有利子負債、借入 | `equity-ratio-interest-bearing-debt-guide` |

テーマ分析記事で以下の材料が出たら、対応する `テーマの読み方` へ内部リンクする。

| 記事内の材料 | リンク先 |
| --- | --- |
| 金利、利上げ、支払利息 | `interest-rate-impact-stocks` |
| 為替、円安、円高 | `fx-impact-company-earnings` |
| 原材料、コスト増、価格転嫁 | `raw-material-cost-pass-through` |
| 半導体、AI投資、データセンター | `semiconductor-investment-supply-chain` |
| 政策、補助金、国策 | `policy-subsidy-investment-theme` |
| 電力、送配電、蓄電 | `energy-transition-power-investment` |
| 人手不足、省力化、外注 | `labor-shortage-automation-investment` |
| 値上げ、客数、客単価 | `price-hike-consumer-demand` |
| インバウンド、訪日客、免税 | `inbound-demand-company-impact` |
| 防衛、安全保障、装備品 | `defense-security-investment-theme` |
| 物流費、2024年問題、運賃 | `logistics-reform-2024-problem` |
