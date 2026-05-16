# 業界分析 02: Codex 資料作成

## 新チャット冒頭テンプレ

```text
このチャットの役割:
業界分析テーマについて、Claudeに渡す投入パックをCodexで作成する。
記事本文の執筆、画像作成、WordPress反映、動画作成は行わない。

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
5. Claudeへの作業指示を作る

完了条件:
- industry_input_pack.md
- source_search_results.md
- CLAUDE_INDUSTRY_CODE_INSTRUCTIONS.md
- handoff_pack_to_claude.md
```

## 注意

- 業界分析では関連銘柄候補リストが最重要。
- 公式情報だけで足りない場合、確度の高い推定・報道・業界資料を出典階層付きで渡す。

