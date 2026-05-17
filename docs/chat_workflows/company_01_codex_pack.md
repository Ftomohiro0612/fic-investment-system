# 企業分析 01: Codex 資料作成

## 新チャット冒頭テンプレ

```text
このチャットの役割:
企業分析記事について、Claudeに渡す投入パックをCodexで作成する。
記事本文の執筆、画像作成、WordPress反映、動画作成は行わない。

参照する管理シート:
- FIC記事管理_v3:
  https://docs.google.com/spreadsheets/d/1ExBSpP3-QMN2gmh9qswp986LKDKXzsWfjzl78DCDoUg/edit
- 対象タブ: 企業分析
対象:
- 企業名:
- 証券コード:
- FIC記事管理v3 企業分析 row:

読む指示書:
- docs/codex_company_analysis_pack_spec.md
- docs/claude_integrated_memo_lessons.md
- prompts/article/company_analysis_memo_main.md
- prompts/shared/quality_checklist.md

触ってよいフォルダ:
- work/company_analysis/{code}_{company}/
- docs/reference_images/ は画像方針確認が必要な場合のみ読む

触らないフォルダ:
- work/industry_analysis/
- assets/videos/
- 他企業フォルダ
- wordpress/ は読まない

やること:
1. 企業分析シートの対象行を確認する
2. 公式IR、決算短信、決算説明資料、統合報告書、有報などを収集する
3. pdf_summary.md を作る
4. claude_input_pack.md を作る
5. Claudeに渡す注意事項を CLAUDE_CODE_FIC_INSTRUCTIONS.md にまとめる
6. シートにパスとステータスを記録する

完了条件:
- pdf_summary.md
- claude_input_pack.md
- CLAUDE_CODE_FIC_INSTRUCTIONS.md
- 必要なら source_pdfs/ と extracted_text/
- 次工程への handoff_pack_to_claude.md
```

## 注意

- 数値は一次資料優先。ただし一次情報だけで不足する場合、確度の高い推定・業界統計・報道ベースも「出典階層」を明記して素材化する。
- 企業分析の主軸は「上流環境 → 対象企業の業績ドライバー」。関連銘柄は補強素材。
- Claudeが記事化しやすいよう、因果チェーン、先行指標、反証条件、3シナリオを素材として用意する。

