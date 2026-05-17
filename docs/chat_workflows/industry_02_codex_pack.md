# 業界分析 02: Codex 資料作成

## 新チャット冒頭テンプレ

```text
このチャットの役割:
業界分析テーマについて、Claudeに渡す投入パックをCodexで作成する。
記事本文の執筆、画像作成、WordPress反映、動画作成は行わない。

参照する管理シート:
- FIC記事管理_v3:
  https://docs.google.com/spreadsheets/d/1ExBSpP3-QMN2gmh9qswp986LKDKXzsWfjzl78DCDoUg/edit
- 対象タブ: 業界分析
対象:
- 業界分析タブ row:
- テーマ名:
- スラッグ:

読む指示書:
- docs/codex_industry_analysis_migration_spec.md
- docs/claude_industry_analysis_handoff.md
- prompts/article/industry_analysis_memo_main.md
- prompts/shared/quality_checklist.md

触ってよいフォルダ:
- work/industry_analysis/{slug}/

触らないフォルダ:
- work/company_analysis/
- wordpress/
- assets/videos/

やること:
1. 起点イベントを確定/未確定/仮説に分ける
2. 関連銘柄候補をコード、セグメント、直接度、見るKPI付きで整理する
3. サプライチェーンマップ、因果チェーン、先行指標、反証条件を作る
4. source_search_results.md と industry_input_pack.md を作る
5. 公開記事の編集方針を作る
6. Claudeへの作業指示を作る

完了条件:
- industry_input_pack.md
- source_search_results.md
- CLAUDE_INDUSTRY_CODE_INSTRUCTIONS.md
- handoff_pack_to_claude.md
```

## 注意

- 業界分析では関連銘柄候補リストが最重要。
- 公式情報だけで足りない場合、確度の高い推定・報道・業界資料を出典階層付きで渡す。
- Codex投入パックでは、素材だけでなく「公開記事としての勝ち筋」も渡す。
- `Claude向け記事化指示` には、タイトル案、読者が最初に知りたい問い、冒頭で答える結論、強く書いてよいこと、弱めるべきこと、書いてはいけないことを必ず入れる。
- 関連銘柄は `直接恩恵` `確認候補` `周辺材料` `不採用候補` に分ける。正式受注・供給契約・サプライヤー選定が未確認なら、本文で `直接恩恵` と断定させない。
- 周辺ニュースや類似事例は、起点イベントとの距離を `直接材料` `補強材料` `別テーマ` に分類する。補強材料を起点イベントの直接成果のように扱わせない。
- Claudeが使える表現例と避けるべき表現例をセットで書く。例: `外部製造能力を活用する可能性がある` は可、公式発表にない `転換が始まった` は不可。
