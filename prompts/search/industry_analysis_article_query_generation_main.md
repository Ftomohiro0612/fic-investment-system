あなたは投資リサーチのアナリストです。
以下の投資テーマについて、業界分析記事を書くために
必要な外部情報を収集します。
検索クエリを12本生成してください。

【投資テーマ】
トレンド名: {{1.`0`}}
投資テーマ: {{1.`1`}}
影響業種: {{1.`6`}}
影響方向: {{1.`7`}}
ドライバー種別: {{1.`5`}}
企業例: {{1.`8`}}（あくまで参考程度）

【検索クエリの役割分担（必須）】
以下の役割ごとに指定本数のクエリを生成してください。
各役割の目的を必ず意識してクエリを作ってください。

■ トレンド定義・現状確認用 × 2
そのトレンドが今どの水準にあるか、最新の統計・公式発表・一次データを取得することを目的とします。
政策金利・CPI・中央銀行見通し・政策会合がテーマに含まれる場合は、ニュース一般ではなく official statement / policy decision / outlook / statistics / data table を優先してください。
PDF本文を読めない運用のため、report だけに寄せず、HTMLで確認しやすい statement / statistics / press release / summary / data table を優先してください。

■ 影響業界特定・波及経路確認用 × 2
どの業界にどう伝播するか、業界構造・需給関係・サプライチェーンの観点から調べます。
industry outlook / supply chain / sector impact / operating rate / price index などを含むクエリを優先してください。
業界年次レポートだけでなく、業界団体統計・月次統計に到達しやすい語も使ってください。
最上流→中間→直接影響→間接影響→下流の5層サプライチェーンを描けるよう、value chain / suppliers / downstream / end market / procurement / capex などの語も使ってください。

■ 恩恵企業・セクター候補用 × 2
具体的にどの企業・セクターが恩恵を受けるか調べます。
企業例（{{1.`8`}}）は参考程度に扱い、テーマから自然に導ける一次影響企業を優先してください。
- コスト増加テーマ：素材・エネルギー直撃企業、価格転嫁力のある高機能材企業
- 輸送・航路テーマ：海運企業
- AI・半導体テーマ：製造装置・材料企業
IR / results / presentation / segment / business risks / price pass-through などを含むクエリを優先してください。
Codex投入パックで、社名/コード/対象セグメント/セグメント売上比率または代替KPI/会社コメント/直接度を埋める必要があります。企業名を入れるクエリでは、IR presentation / segment revenue / order backlog / business overview / integrated report / earnings など、個社のセグメント情報に届く語を優先してください。

■ 逆風企業・セクター候補用 × 1
具体的にどの企業・セクターが逆風を受けるか調べます。
headwinds / downside risk / margin pressure / overcapacity / operating rate などを含むクエリを優先してください。

■ 反証・リスク確認用 × 1
このトレンドが想定より早く終息する条件、市場が織り込み済みである可能性を確認します。
priced in / risk / downside scenario / policy outlook / commodity price reversal などを含むクエリを優先してください。

■ 先行指標・時系列確認用 × 1
記事の因果を支える先行指標を取得します。
価格、受注、稼働率、在庫、設備投資、PMI、賃金、金利、物流量、電力需要など、
テーマに最も近いKPIを1本で取りに行ってください。
先行指標は、市場マクロ / 業界中間 / 個社 の3階層で整理できるものを優先してください。例：市場規模・価格指数、業界受注/在庫/稼働率、個社受注残/セグメント売上/CAPEX。

■ 類似過去事例・比較軸確認用 × 1
過去に同じ構造が起きた時、どの業界・企業に効いたかを確認します。
previous cycle / past shortage / historical price spike / comparable case /
過去事例 / 前回局面 などを使ってください。
市場がどの程度織り込んだかを見るため、stock reaction / valuation / PER / consensus / target price / earnings revision などの語を必要に応じて使ってください。

■ 周辺業界・二次波及確認用 × 1
直接恩恵・直接逆風だけでなく、物流、金融、建設、素材、サービス、小売など
二次波及先がないか確認します。
secondary impact / downstream impact / adjacent industry / supply chain effect などを使ってください。

【時点整合ルール（最重要）】
- 投資テーマに政策会合・対象月・対象年度・直近イベントの時点が含まれる場合、その時点と整合するクエリを優先してください。
- latest / recent / current は使ってよいが、古い利上げ観測・別会合の予想ニュースを拾いやすい曖昧クエリは避けてください。
- BOJやCPIでは、rate hike forecast だけを狙うのではなく、BOJ policy decision official statement / BOJ outlook inflation forecast / Japan CPI official statistics のように公式情報へ寄せてください。
- 年号は原則入れない。ただし投資テーマ自体に明示された対象年度や会合時点があり、時点ズレ防止に必要な場合のみ、その時点を含めてよいです。

【地政学リスク表現ルール】
- war / invasion / freeze / cancellation / shutdown などの強い事象語を、推測でクエリに入れないこと。
- 入力テーマや検索済み情報で明示されていない場合は、Middle East tensions / geopolitical risk / supply concern / energy price risk のように丸めること。
- 強い語を含む検索結果を拾うより、価格・供給・統計に接続できる語を優先してください。

【クエリ生成のルール】
- 可能な限り具体的な数値・指標（政策金利、CPI、原油価格、ナフサ価格、稼働率、設備投資計画、スプレッド、受注、供給量など）が取得できるクエリを優先してください。
- 日本語と英語を混在させてOK。
- 単なるニュース記事ではなく、数値・データ・企業の公式見解が取れるクエリを優先すること。
- 各クエリは1行以内の文字列にすること。
- 同じ方向のクエリを重複させないこと（役割が違えば角度も変えること）。
- クエリにダブルクォート（"）を一切含めないこと。
- 一般的すぎるクエリは禁止。
  例：Japan economy latest / chemical industry latest / BOJ news latest
- 企業名を入れる場合は、企業名 + IR系語 + テーマ語にすること。
  例：Shin-Etsu Chemical IR segment price pass-through

【出力ルール（厳守）】
- カンマ区切りで12個のクエリを1行で出力すること
- クォート・括弧・番号・記号は一切含めないこと
- 前置き・説明は不要

出力例：
BOJ policy decision official statement current,BOJ outlook inflation forecast latest,Japan CPI official statistics current,Japan naphtha CFR price current,JPCA ethylene operating rate latest,chemical industry overcapacity margin pressure outlook,Shin-Etsu Chemical IR segment price pass-through,chemical sector margin pressure risk,Japan manufacturing PMI current,chemical price spike previous cycle,downstream packaging material cost impact,BOJ policy outlook priced in risk
