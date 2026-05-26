# 業界分析 04: Codex レビュー

## 新チャット冒頭テンプレ

```text
このチャットの役割:
Claudeが作成した業界分析記事をCodexでレビューし、必要な修正を行う。
画像作成、WordPress反映、動画作成は行わない。

参照する管理シート:
- FIC記事管理_v3:
  https://docs.google.com/spreadsheets/d/1ExBSpP3-QMN2gmh9qswp986LKDKXzsWfjzl78DCDoUg/edit
- 対象タブ: 業界分析
対象:
- 業界分析タブ row:
- テーマ名:
- 対象フォルダ:

読む指示書:
- docs/codex_industry_analysis_migration_spec.md
- docs/claude_industry_analysis_handoff.md
- prompts/shared/quality_checklist.md
- prompts/seo/internal_link_rules.md

読むファイル:
- work/industry_analysis/{slug}/industry_analysis_article.html
- work/industry_analysis/{slug}/industry_analysis_memo.md
- work/industry_analysis/{slug}/industry_analysis_review_notes.md
- work/industry_analysis/{slug}/source_search_results.md

触ってよいフォルダ:
- work/industry_analysis/{slug}/

触らないフォルダ:
- work/company_analysis/
- wordpress/ は読まない
- assets/videos/

やること:
1. テーマ起点、関連銘柄への波及、先行指標、リスクを確認する
2. 確定/報道/仮説の区別を確認する
3. 見出し階層、表、図表位置、参照資料形式を整える
4. タイトル、冒頭、30秒要約、FAQの読みやすさと表現強度を確認する
5. `node scripts/audit_article_heading_hierarchy.mjs work/industry_analysis/{slug}/codex_reviewed_article.html` を実行し、H2だけで長い章が残っていないか確認する
6. 必要なら codex_reviewed_article.html を作る
7. review_notes に Codexレビュー結果を追記する

完了条件:
- codex_reviewed_article.html
- Codexレビュー結果
- handoff_review_to_image_wp.md
```

## 注意

- 読者が知りたいのは「このテーマでどの企業に影響するか」。
- 根拠が弱いから全て丸めるのではなく、確度が高い推定は出典階層と注意書きを付けて残す。
- Codexレビューはファクトチェックだけで終えない。公開記事として、タイトルが検索意図に近いか、冒頭で結論と確認順が分かるか、本文が読者の疑問に沿っているかを見る。
- `直接恩恵` `確認候補` `周辺材料` が混ざっていないか確認する。正式受注・契約・供給関係がない企業を直接恩恵と書いていたら修正する。
- `始まった` `確定した` `恩恵を受ける` `転換した` など、公式発表より強い断定を探し、必要に応じて `可能性がある` `確認候補` `正式発表を待つ` に弱める。
- 周辺材料を起点イベントの直接成果のように書いていないか確認する。例: 既存工場の黒字化、類似事例、業界統計は、新規投資の直接収益化ではなく補強材料として扱う。
- 関連銘柄表には、対象工程、直接度、確認KPI、反証条件があるか確認する。
- 比較用の記事やMake記事がある場合でも、Codex資料準備→Claude記事作成→Codexレビューの記事を正本として改善する。比較記事からは、分かりやすい因果経路、検索語、読者に伝わる切り口だけを抽出し、ファクト安全性、確認候補、反証条件の整理はCodex/Claude版を優先する。
- 供給不安テーマでは、政府・業界団体・企業が供給継続、在庫、代替調達、段階的再開を説明している場合、「供給途絶」ではなく「価格、中間材、納期、価格転嫁」の問題として整理できているか確認する。
- コスト上昇テーマでは、需要側の粗利率リスク、供給側の価格転嫁余地、上流側のスプレッド/稼働率リスクを分けているか確認する。単純な「逆風」「恩恵」だけで分類しない。
- TDBなどの調査比率を使う場合、その比率が総コスト比率なのか、回答比率なのか、値上げ要因として挙げた比率なのかを本文で注釈する。
- 影響が混在するテーマでは、関連銘柄表を `需要側・逆風` `供給側・価格転嫁確認候補` `上流・スプレッド注意` `周辺材料` のように分類できないか確認する。
- タイトルの表現強度が本文の慎重さとズレていないか確認する。本文で `全国停止ではない` `一部受注方法の見合わせ` と弱めているのに、タイトルだけ `停止拡大` `危機` など強くなっている場合は、`工期遅延` `粗利率圧迫` `確認ポイント` などに寄せる。
- 企業公式が `受注方法の一時見合わせ` `生産・出荷は継続` `段階的再開` のように説明している場合、本文も公式文言に近い表現へ寄せる。`受注停止` `供給停止` などの短縮表現で危機感を強めない。
- 比較記事に分かりやすい説明パーツがある場合、因果の安全性をCodex/Claude版に合わせたうえで、用語解説、利益計算式、工程説明などの教育的パーツだけを移植できないか確認する。
- 粗利率影響、在庫月数、価格影響などの独自数値を出す場合は、会社開示値かFIC前提付き試算かを明記し、前提条件、対象売上比率、価格転嫁率、工期遅延率などを添える。根拠が弱い数値は `小幅な下押し圧力` のような定性表現に弱める。
- 先行指標表には、可能な限り `更新頻度` と `主な確認先` を入れる。読者が次にいつ、どの資料を見ればよいか分かる表にする。
- H2はテーマの大きな問い、H3は章内の確認ポイントとして使う。影響経路、関連銘柄、業績ドライバー、先行指標、3シナリオが長くなる場合はH3で分ける。
- 仕上げ時に `node scripts/audit_article_heading_hierarchy.mjs work/industry_analysis/{slug}/codex_reviewed_article.html` を実行し、`work/article-heading-hierarchy-audit.md` の `Review needed` が `None` になっていることを確認する。
