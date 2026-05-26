# トップページ改修 計測メモ

作成日: 2026-05-22

更新メモ: 2026-05-23時点では、Code Snippets `FIC: Navigation measurement events` が本番で有効化済み。
`[data-fic-area]` 付きリンクのクリックは `fic_navigation_click`、トップ/ハブ検索フォーム送信は `fic_search_submit` として `gtag`、`dataLayer`、ブラウザの `fic:measurement` イベントへ送信される。
イベント名・パラメータの現行仕様は `docs/navigation_measurement_events.md` を正とする。

## 目的

トップページと3つの固定ページハブを公開したあと、見た目の印象だけでなく「読者がどの入口を使っているか」を確認する。

今回のショートコードでは、主要リンクに次のHTML属性を付けている。

```html
data-fic-area="home_hero_action"
data-fic-label="企業を探す"
```

## まず見る指標

GA4 / Search Console で最初に見るもの:

- トップページから `企業を探す`、`テーマから探す`、`投資の読み方`、`決算予定` へのクリック数
- 3つの固定ページハブから記事詳細へ進んだクリック数
- トップページ公開前後の直帰率、平均エンゲージメント時間、記事詳細への遷移
- 検索フォームと検索チップの利用回数
- YouTube導線のクリック数

## GTM/GA4で確認するイベント

本番スニペット側で送信しているイベント:

| イベント名 | 発火対象 |
| --- | --- |
| `fic_navigation_click` | `[data-fic-area]` 付きリンクのクリック |
| `fic_search_submit` | `.fic-home-search` / `.fic-hub-search` の検索送信 |

GTM側で追加設定する場合の候補:

クリックトリガー条件:

```text
Click Element matches CSS selector [data-fic-area]
```

GA4イベント名:

```text
fic_navigation_click
```

イベントパラメータ候補:

| パラメータ | 値 |
| --- | --- |
| `fic_area` | `data-fic-area` の値 |
| `fic_label` | `data-fic-label` の値 |
| `link_url` | クリック先URL |
| `page_location` | クリック元ページ |

## 主な `data-fic-area`

| area | 意味 |
| --- | --- |
| `home_hero_action` | トップの4入口 |
| `home_quicknav` | トップ内ナビ |
| `home_search_chip` | トップ検索フォーム下の代表記事直リンク |
| `home_firstcheck` | 迷ったら最初に見る4入口 |
| `home_market_trigger` | 金利・為替など、代表テーマ解説への材料別入口 |
| `home_purpose_route` | トップ上の4つの目的別ルート見取り図 |
| `home_entry` | 目的別カード |
| `home_reading_route` | 初回訪問者向けの読み順 |
| `home_latest_company` / `home_latest_theme` / `home_latest_basics` | 最新記事カード |
| `home_video` | YouTube / 記事導線 |
| `home_trust` | About / 編集方針 / 学習導線 |
| `hub_nav` | 固定ページハブ間の移動 |
| `company_hub_*` | 企業ハブ内の導線 |
| `company_hub_route` | 企業ハブの業種・材料別企業ルート |
| `theme_hub_*` | テーマハブ内の導線 |
| `learning_hub_*` | 学習ハブ内の導線 |
| `learning_hub_route` | 投資の読み方ハブの場面別読み方ルート |
| `theme_hub_cluster` | テーマハブの4つの深掘り入口 |
| `earnings_guide_route` | 決算前・発表直後・発表後の読み方ルート |
| `earnings_guide_theme` | 決算予定ページ上の外部環境テーマ導線 |
| `earnings_guide_company` | 決算予定ページ上の代表企業分析リンク |
| `earnings_guide_search` | 決算予定ページ上の企業検索 |

## 改善判断の目安

公開後1〜2週間は、まずクリックの偏りを見る。

- `企業を探す` が強い: `company_hub_route` と検索語を見て、業種・材料別ルートと企業検索チップを入れ替える。
- `home_purpose_route` が強い: クリック先のハブ内ルートと合わせて、トップに出すチップ語句を入れ替える。
- `home_search_chip` が強い: 半導体、金利、為替、決算、政策、エネルギーのどれが押されるかを見て、ヒーロー直下の代表チップを入れ替える。
- `テーマから探す` が強い: `home_market_trigger`、`theme_hub_trigger`、`theme_hub_cluster` を見て、金利、為替、原材料、半導体、政策、エネルギーなどのうち、小ハブ化する優先テーマを決める。
- `投資の読み方` が弱い: トップ上の文言を「初心者向け」ではなく「決算を読む土台」に寄せ、`learning_hub_route` の押され方で導線順を調整する。
- `決算予定` が強い: `earnings_guide_route` で決算前・発表直後・発表後のどこが押されるかを見て、`earnings_guide_theme` と代表企業リンクを入れ替える。
- 検索チップが強い: チップの語句を実際の検索語に合わせて入れ替える。

## 変更時のルール

- リンク文言を変える場合も、`data-fic-area` はできるだけ維持する。
- 比較したい導線は `data-fic-label` だけ変える。
- 大きな配置変更をした日は、`docs/change_log.md` に残す。
