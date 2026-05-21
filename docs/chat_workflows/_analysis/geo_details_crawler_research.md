# GEO調査: `<details>`/`<summary>` アコーディオンと生成AIクローラーの扱い

調査日: 2026-05-21
対象問い: 投資分析記事の「補足/付録章」を `<details>` で初期折りたたみする設計が、生成AIの引用・インデックスを損なわないか。

> 用語注記: 本書では「生HTML（raw HTML / static HTML）」= サーバから最初に返るHTMLソース、「レンダリングDOM」= ブラウザ（またはGooglebot相当）がJavaScriptを実行した後のDOMツリー、を区別する。`<details>` は **生HTMLに最初から存在する**マークアップであり、折りたたみは `<details>` のネイティブ挙動（CSSの `content-visibility`/`display` 相当）で行われ、テキスト自体はJS実行なしでHTMLソースに含まれる。これが本調査の核心。

---

## 0. 結論サマリ（先に要点）

- 主要生成AIクローラー（GPTBot / OAI-SearchBot / ClaudeBot / PerplexityBot）は **JavaScriptを実行せず、生HTMLを取得して解析する**（複数ソースで確認できた事実）。
- `<details>` 内のテキストは **生HTMLに存在する**（JSで後挿入していない限り）。よって理屈の上では、JS非実行のAIクローラーでも **取得・解析できる**。この理解は技術的に正しい（確認できた事実）。
- ただし「取得できる＝同じ重みで引用される」ではない。**折りたたみ／CSS非表示コンテンツは、可視コンテンツより重要度が低いと扱われうる**（SEO文脈で繰り返し報告。GEOでも同方向の助言）。
- 「`<details>`内は生成AI引用の対象外」と断言する一次証拠は **見つからなかった（＝そう断言できる証拠はない）**。逆に「生HTMLに在れば取得可能」とする証拠は複数ある。ただし**各社が折りたたみ内テキストに与える重み付けの内部仕様は非公開で、保証はない（不明）**。
- 推奨は **C: ハイブリッド**（折りたたむが、各補足章の要約1行を折りたたみ外＝可視に残す）。根拠と残リスクは §4。

---

## 1. クローラー別の扱い

### 1-1. 判明した事実（複数の信頼ソースで一致）

| クローラー | JS実行 | 取得対象 | 折りたたみ(`<details>`/CSS非表示で生HTMLに在る)テキスト |
|---|---|---|---|
| OpenAI GPTBot | しない | 生HTML（HTMLが取得の57.70%）+ JSファイルをテキストとして取得するが実行しない | 生HTMLに在れば取得可（JS依存でなければ） |
| OpenAI OAI-SearchBot / ChatGPT-User | しない | 生HTML | 同上 |
| Anthropic ClaudeBot | しない | 生HTML + 画像（画像が35.17%）。JSファイルは取得(23.84%)するが実行しない | 同上 |
| Perplexity PerplexityBot | しない | 生HTML | 同上 |
| Google Gemini / AI Overviews（Googlebot経由） | **する**（Googlebotのレンダリングインフラを利用＝headless Chrome相当） | レンダリング後DOM | 取得可。JS後挿入でも見える。ただしランキング重みは可視＜非表示の傾向 |

- Vercelの実測分析（クローラーログ）: 「主要AIクローラーはいずれもJavaScriptをレンダリングしない。OpenAI(OAI-SearchBot, ChatGPT-User, GPTBot)、Anthropic(ClaudeBot)、Perplexity(PerplexityBot)を含む。JSファイルは取得するが**実行せず、クライアントサイドレンダリングのコンテンツは読めない**」。
- Search Engine Journal（"Ask An SEO"）: テストしたbotで「JSをレンダリングできたのはGemini（Googlebotのインフラ利用）、Applebot、CommonCrawlのCCbotのみ」。
- 同記事の核心助言: 「コンテンツがJS実行なしでDOMに完全にロードされるようにせよ。人間は操作して開いてよいが、**botは開く必要がない**ようにする」＝**`<details>` のように生HTMLに在ればOK**という整理。

### 1-2. 不明・保証なし

- 各生成AIエンジンが、折りたたみ／CSS非表示テキストに **可視テキストと同じ重み**を与えるかは **非公開・不明**。
- GPTBot等が取得した生HTMLの中で `<details>` の `open` 属性有無を考慮して重み付けするかは **公式言明なし（不明）**。
- Anthropic / OpenAI / Perplexity の公式クローラードキュメントは「robots.txt遵守・収集目的・UA文字列」が中心で、**折りたたみ要素の扱いに踏み込んだ公式記述は確認できなかった（不明）**。本調査の事実認定は、実測ログ系（Vercel）と業界SEO/GEO媒体の解析に依拠している。

---

## 2. 生HTML vs レンダリングDOM の論点 — 結論

**FICの理解（「`<details>`内は生HTMLに存在するので、JSレンダリング非依存で取得できる」）は技術的に正しい。** ただし条件と留意点がある。

- **正しい前提**: `<details><summary>...</summary>本文</details>` を **HTMLソースに直接書く**（静的出力 or サーバサイドレンダリング）なら、テキストは生HTMLに存在する。折りたたみはブラウザのネイティブ挙動であり、JSを使わない。よってJS非実行のGPTBot/ClaudeBot/PerplexityBotでも **取得・解析可能**。
- **崩れる前提（やってはいけない実装）**:
  - 補足章の本文を **JavaScriptでクリック後に挿入**する（fetch/innerHTML等）→ 生HTMLに無い → JS非実行のAIクローラーには **見えない**。
  - フレームワークでクライアントサイドのみレンダリング（CSR）し、初期HTMLが空 → 同上。
  - したがって実装要件は「**`<details>` の中身を初期HTMLに含める（CSS/ネイティブで隠すだけ）**」。`display:none` 相当でも生HTMLに在れば取得自体は可能だが、重要度低下リスクは残る（§3）。
- **重み付けの留保**: 「取得可能」と「可視と同等に引用される」は別問題。生HTMLに在っても、折りたたみ／CSS非表示は **重要度が低いシグナル**と解釈されうる（SEOで繰り返し観測。GEOでも同方向の助言が主流）。Google自身は「HTMLに在れば等しく扱う」と述べてきた（Mueller, 2020）が、実地のSEO実験では **可視テキストの方が重みを持つ傾向**が報告されている。

---

## 3. GEOベストプラクティス（折りたたみの可否・引用されやすくする条件）

### 3-1. 折りたたみの可否

- **全面禁止ではない**。UX目的の折りたたみ（アコーディオン/タブ/`details`）は、(a) 中身が初期HTMLに在り、(b) 中核コンテンツを折りたたまない、限りで許容される、というのが業界コンセンサス。
- ただし **「重要な答え・要約・定義は可視（初期表示）にせよ」** が一貫した助言。折りたたみは **二次的・補足的・探索的コンテンツ**に限定する。
- 実地データ例（arcintermedia）: FAQを折りたたみから全可視化したテストで、セッション-21%・エンゲージメント-63%の悪化＝**UX観点ではむしろ折りたたみが有利な場面もある**。SEO/GEOとUXのトレードオフがあることに注意。

### 3-2. 引用されやすくする条件（GEO一般）

- **冒頭に40〜80語の「クイックアンサー（要約）」** を可視で置き、核心の問いに直接答える。これが抽出・引用されやすい。
- **見出し・要約を可視化**し、構造化（明確なH2/H3、箇条書き、定義）する。
- **引用・統計・出典の明示**は被引用率を押し上げる（GEO研究で+40%超の報告）。FAQには構造化マークアップ（FAQ schema）。
- 含意: **「各セクションの要約は可視」「詳細は折りたたみ可」** という構造が、GEOと相性が良い。

---

## 4. FICへの推奨

### 推奨: **C（ハイブリッド）** — 折りたたむが、各補足章の要約1行（できれば2〜3行）を折りたたみ外＝可視に残す

#### 根拠
1. **取得は問題ない見込み**: `<details>` の中身を初期HTMLに含める限り、GPTBot/ClaudeBot/PerplexityBotでも取得可能（§1〜2の確認事実）。Gemini/AI Overviews（Googlebot経由）はさらに確実。よって「折りたたむと一切引用されない」という最悪シナリオの確証はない。
2. **重み付けリスクへの保険**: 一方で「折りたたみ＝重要度低」と扱われうるリスクは消せない（非公開・不明）。**要約1行を可視に残せば、その要約自体は可視テキストとして引用候補に乗る**。これがGEOベストプラクティス（要約・定義は可視に）と完全に整合。
3. **UXとの両立**: 補足章を畳むことで本文の読みやすさを保ちつつ（arcintermediaの示すUX利点）、可視要約で「何が書いてあるか」をAIにも人間にも提示できる。
4. **実装が軽い**: 既存の `<details>` 設計を活かし、`<summary>` または直前に1行サマリを置くだけ。設計の作り直しが不要。

#### 実装の必須要件（Cを採る場合）
- 補足章の本文は **初期HTMLに直書き**（JSでクリック後挿入しない）。CSR禁止、SSR/静的出力。
- 各 `<details>` の **`<summary>` を内容を表す1行要約**にする（「補足」「詳細はこちら」のような無情報ラベルは避ける）。
- 可能なら `<summary>` に加え、**折りたたみ外に2〜3行の要点**（数値の結論や論点）を可視で置く。ここがAI引用の主ターゲット。
- 記事冒頭に **40〜80語のクイックアンサー**（中核の投資判断/結論）を別途可視で置く（GEO一般原則）。

#### 残るリスク（明示）
- 各生成AIエンジンが折りたたみ内テキストに与える重みは **非公開・保証なし**。要約可視化はそのヘッジだが、完全な担保ではない。
- 将来クローラー仕様変更の可能性（現状はJS非実行だが、各社が変える可能性は否定できない）。`<details>` 直書きならどちらに転んでも不利になりにくい設計。
- SEO/GEO媒体の解析は一次仕様ではなく実測・経験則が多い。「断言」は避け、可視要約で保険をかける方針が妥当。

### 他案の評価
- **推奨A（全面折りたたみ）**: 取得自体は可能性が高いが、補足章の重み低下リスクを生で被る。要約も畳まれるため、AIが「要点」を可視テキストとして拾えない。**非推奨**（リスクをヘッジしていない）。
- **推奨B（下部集約・折りたたまず）**: GEO/引用観点では最も安全（全テキスト可視）。ただし記事が長くなりUXが落ちる（arcintermediaのデータが示す離脱増の懸念）。**次善**。GEOを最優先しUXを許容できるなら可。
- **推奨C（ハイブリッド）**: 取得確実性（B寄り）とUX（A寄り）の中間で、GEOベストプラクティス（要約は可視・詳細は補足）に最も合致。**本命**。

---

## 出典（URL）

確認できた事実の根拠:
- Vercel「The rise of the AI crawler」(AIクローラーのJS非実行・生HTML取得の実測): https://vercel.com/blog/the-rise-of-the-ai-crawler
- Search Engine Journal「Ask An SEO: Can AI Systems & LLMs Render JavaScript To Read 'Hidden' Content?」(JS非実行botの列挙／DOM直書き推奨): https://www.searchenginejournal.com/ask-an-seo-can-ai-systems-llms-render-javascript-to-read-hidden-content/563731/
- Arc Intermedia「Collapsible Content: Does Hidden Content Affect SEO/AEO/GEO?」(折りたたみのAEO/GEO影響・要約可視化・UXデータ): https://www.arcintermedia.com/shoptalk/collapsible-content-best-practices-does-hidden-content-affect-seo-aeo-geo/
- Prerender「7 Hidden Content Types That Hurt Your SEO and AEO Visibility」(CSS非表示の重要度低下リスク・FAQ初期展開推奨): https://prerender.io/blog/hidden-content-that-hurts-seo/
- Search Engine Journal「Google's Mueller on Indexing of Hidden Tab Content」(HTMLに在れば索引、ただし可視の重み傾向): https://www.searchenginejournal.com/googles-mueller-on-myth-of-hidden-tab-content/358724/

GEOベストプラクティスの根拠:
- Profound「10-step framework for generative engine optimization (2025)」(クイックアンサー40-80語・可視要約): https://www.tryprofound.com/resources/articles/generative-engine-optimization-geo-guide-2025
- Directive Consulting「A Guide to Generative Engine Optimization (GEO) Best Practices」: https://directiveconsulting.com/blog/a-guide-to-generative-engine-optimization-geo-best-practices/
- GEO学術原典 Aggarwal et al.「GEO: Generative Engine Optimization」(引用・統計で被引用+40%): https://arxiv.org/pdf/2311.09735

補足参照（SEO一般・JSレンダリング）:
- Lantern「AI Crawlers Do Not Render JavaScript」: https://www.asklantern.com/blogs/ai-crawlers-do-not-render-javascript
- Passionfruit「JavaScript Rendering and AI Crawlers: Can LLMs Read Your SPA? (2026)」: https://www.getpassionfruit.com/blog/javascript-rendering-and-ai-crawlers-can-llms-read-your-spa

> 確証の所在: 「AIクローラーはJSを実行せず生HTMLを取得」「`<details>`中身が生HTMLに在れば取得可能」は複数ソースで一致＝事実認定。「折りたたみ内が可視と同等に引用されるか」は各社非公開＝不明・保証なし。
