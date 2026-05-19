# Claude Code 作業指示: キオクシアホールディングス（285A）企業分析 v4

## 作業場所

```text
C:\Users\tomo-\Documents\FIC\fic-investment-system\work\company_analysis\285A_kioxia
```

## この工程の目的

Codexが作成した準備パックを入力として、Claude側で以下を作成する。

1. `claude_integrated_memo.md`
2. `claude_article.html`
3. `claude_review_notes.md`

## 入力として読むファイル

1. `pdf_summary.md`
2. `claude_input_pack.md`
3. `handoff_pack_to_claude.md`
4. `..\..\..\docs\claude_integrated_memo_lessons.md`
5. `..\..\..\prompts\article\company_analysis_article_main.md`
6. `..\..\..\prompts\shared\quality_checklist.md`

## 読まないファイル

- 既存記事HTML
- 既存レビュー成果物
- Make要約
- 他企業フォルダ
- `wordpress/` 配下

## 記事構成

v4の「業界トレンド起点」構造を使う。

1. 業界の風向き
2. 投資仮説
3. 業界内ポジション
4. 企業概要
5. 収益構造
6. 業績全体像
7. 業績ドライバー
8. 中計/長期財務モデルの検証
9. シナリオ
10. 先行指標
11. 競合比較
12. リスク
13. 投資家向けまとめ
14. 参照資料
15. FAQ

## 最重要ルール

- キオクシアはメモリ事業の単一報告セグメント。用途別売上はあるが、用途別利益は非開示。
- `SSD & ストレージ`、`スマートデバイス`、`その他`は「用途別売上」であり、報告セグメント利益のように書かない。
- 2027年3月期について会社が開示しているのは1Q予想のみ。通期予想として扱わない。
- 5〜10期推移は一次資料だけでは不足。記事では3期推移を主表にし、上場後開示の限界を必要に応じて注記する。
- 独立した日本語中期経営計画PDFは未確認。統合報告書と戦略説明資料の長期財務モデルを検証対象にする。
- 為替感応度、NAND価格感応度、用途別利益、顧客別売上は会社非開示。推定数値で埋めない。
- AI需要は追い風だが、NAND市況・ASP・在庫調整・CapExの反証条件を必ずセットで書く。

## 公開記事で避ける表現

- `爆発`, `圧倒的`, `独占`, `必ず成長`, `市況に左右されない`
- 代替: `急拡大`, `有力`, `世界有数`, `成長余地`, `市況感応度が大きい`

## 画像連動メモ

- 画像1: `kioxia-285a-upstream-impact-map-ai.png`
  - H2 7直後
  - AI推論サーバー、データセンターSSD、スマホ/PC容量、NAND需給、ASP、bit shipment、工場稼働率、営業利益への因果マップ
- 画像2: `kioxia-285a-investment-thesis-map-ai.png`
  - H2 2直後
  - 「AIストレージ需要」「BiCS/QLC」「投資規律」「市況反落リスク」の4象限投資仮説マップ

## 完了後にユーザーへ伝える文

```text
キオクシア（285A）row31 の Claude成果物3点を作成しました。
- work/company_analysis/285A_kioxia/claude_integrated_memo.md
- work/company_analysis/285A_kioxia/claude_article.html
- work/company_analysis/285A_kioxia/claude_review_notes.md

Codexレビューに進めてください。
```
