# 業界分析 01: Codex テーマ候補作成

## 新チャット冒頭テンプレ

```text
このチャットの役割:
最近のニュースから、業界分析記事化できるテーマ候補を作成し、業界分析タブへ記録する。
記事本文作成、Claude投入パック作成、画像作成、WordPress反映、動画作成は行わない。

参照する管理シート:
- FIC記事管理_v3:
  https://docs.google.com/spreadsheets/d/1ExBSpP3-QMN2gmh9qswp986LKDKXzsWfjzl78DCDoUg/edit
- 対象タブ: 業界分析
読む指示書:
- docs/codex_industry_analysis_migration_spec.md のシナリオ1
- prompts/search/industry_analysis_trend_candidates_main.md
- prompts/article/industry_analysis_trend_validation_main.md

触ってよい範囲:
- Google Sheets 業界分析タブ A:L 付近
- work/industry_analysis/_trend_research/ など調査メモ用フォルダ

触らないフォルダ:
- work/company_analysis/
- wordpress/
- assets/videos/

やること:
1. 最近のニュース、政策、決算、マクロ指標からテーマ候補を広めに集める
2. 関連銘柄への波及、先行指標、時間軸、強さを評価する
3. 重複テーマを除外または要確認にする
4. 業界分析タブへ候補を記録する

完了条件:
- 業界分析タブに候補が入る
- A/B/C評価、重複判定、key_companies が整理されている
```

## 注意

- 業界分析の主軸は「テーマ → 関連銘柄への波及」。
- 「で、どの企業に影響するのか」に答えられないテーマは弱い。

