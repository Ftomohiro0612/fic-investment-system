# 企業分析 05: Codex X投稿

## 新チャット冒頭テンプレ

```text
このチャットの役割:
公開直前または公開済みの企業分析記事をもとに、X投稿用決算メモと投稿文を作る。
記事本文の修正、画像作成、WordPress反映、動画作成は行わない。

参照する管理シート:
- FIC記事管理_v3:
  https://docs.google.com/spreadsheets/d/1ExBSpP3-QMN2gmh9qswp986LKDKXzsWfjzl78DCDoUg/edit
- 対象タブ: 企業分析
対象:
- 企業名:
- 証券コード:
- 対象フォルダ:
- 記事URL:

読む指示書:
- docs/x_post_company_analysis_workflow.md
- prompts/social/x_post_company_analysis_main.md

読むファイル:
- work/company_analysis/{code}_{company}/codex_reviewed_article.with_images.html
- なければ codex_reviewed_article.html / claude_article.html
- pdf_summary.md

触ってよい範囲:
- Google Sheets 企業分析タブの AT/AU/AV/AQ/AS
- work/company_analysis/{code}_{company}/ はメモ保存が必要な場合のみ

触らないフォルダ:
- wordpress/
- work/industry_analysis/
- assets/videos/

やること:
1. AU: X投稿用 決算メモを作る（決算要約だけでなく、一言でいうと、初心者向け言い換え、使わない方がよい表現も含める）
2. 5案程度を検討し、AVには採用3本だけを保存する
3. URL、ハッシュタグ、未確認数値、文字数を確認する
4. AT=完了、AQ/ASを更新する

完了条件:
- AUに決算メモ
- AVに投稿3本
- AT=完了
```

## 注意

- 1投稿1メッセージ。
- 記事にない数字は足さない。
- FICらしい「上流要因 → 企業KPI → 業績」の因果を入れる。
- 専門性は維持しつつ、Xでは初心者にもイメージできる言葉に翻訳する。
- 本文記事より少しカジュアルでよいが、強いネットスラングや銘柄を茶化す表現は避ける。
- 難しい用語は必要に応じて「つまり」「ざっくり言うと」で一言補う。
- 決算メモにも、X投稿に転用しやすい噛み砕き表現を3-5本入れる。
