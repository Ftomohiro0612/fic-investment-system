# 企業分析 02: Claude 記事作成

## 新チャット冒頭テンプレ

```text
このチャットの役割:
Codexが作成した企業分析投入パックをもとに、Claude Codeで記事3点セットを作成する。
外部検索、WordPress反映、画像作成、動画作成は行わない。

対象:
- 企業名:
- 証券コード:
- 対象フォルダ:

読むファイル:
- work/company_analysis/{code}_{company}/CLAUDE_CODE_FIC_INSTRUCTIONS.md
- work/company_analysis/{code}_{company}/claude_input_pack.md
- work/company_analysis/{code}_{company}/pdf_summary.md
- prompts/article/company_analysis_article_main.md
- prompts/article/company_analysis_memo_main.md
- prompts/shared/quality_checklist.md

触ってよいフォルダ:
- work/company_analysis/{code}_{company}/

触らないフォルダ:
- work/industry_analysis/
- wordpress/
- assets/videos/
- 他企業フォルダ

作るもの:
1. claude_integrated_memo.md
2. claude_article.html
3. claude_review_notes.md

完了条件:
- 記事HTMLが公開本文として読める
- review_notes に判断論点、未確認事項、非AI図表候補、Codexレビュー依頼がある
- 次工程への handoff_claude_to_codex_review.md を作る
```

## 注意

- 記事は「公表資料の要約」ではなく、対象企業の業績が何で動くかを読者に伝える。
- 難用語は初出付近に用語メモ、投資判断上の誤読ポイントはワンポイント解説で補う。
- 関連銘柄・関連テーマは、接続理由が弱いものを公開本文に出さない。

