# FIC Chat Workflow Templates

FIC投資研究所の作業を、Codex / Claude Code のチャット単位で分割するための入口テンプレート集です。

作業フォルダ全体の整理方針は [workspace_organization_policy.md](../workspace_organization_policy.md) を参照します。

目的は次の3つです。

- 1チャットの履歴を短く保ち、Codex Desktop / Claude Code の応答停止を減らす
- 各工程で読む指示書・触るフォルダを固定し、記事作成の迷子を防ぐ
- 企業分析、業界分析、画像、WordPress、動画の重い処理を混ぜない

## 基本ルール

- 1チャット = 1工程だけを担当する。
- 新チャットでは、該当テンプレートを最初に貼る。
- テンプレートに書かれた「読むファイル」「触ってよいフォルダ」以外は、原則読まない。
- 前工程から次工程へ渡すときは、対象フォルダ内に `handoff_*.md` を作る。
- 画像・動画・WordPress反映は重いので、記事作成チャットとは分ける。
- 仕様書やプロンプトの汎用修正は、記事作成チャットではなく別チャットで行う。

## 12分割

### 企業分析

1. [企業分析 01: Codex 資料作成](company_01_codex_pack.md)
2. [企業分析 02: Claude 記事作成](company_02_claude_article.md)
3. [企業分析 03: Codex レビュー](company_03_codex_review.md)
4. [企業分析 04: Codex 画像作成・WordPress反映](company_04_codex_image_wp.md)
5. [企業分析 05: Codex X投稿](company_05_codex_x_post.md)
6. [企業分析 06: Codex 動画作成](company_06_codex_video.md)

### 業界分析

7. [業界分析 01: Codex テーマ候補作成](industry_01_codex_trend_candidates.md)
8. [業界分析 02: Codex 資料作成](industry_02_codex_pack.md)
9. [業界分析 03: Claude 記事作成](industry_03_claude_article.md)
10. [業界分析 04: Codex レビュー](industry_04_codex_review.md)
11. [業界分析 05: Codex 画像作成・WordPress反映](industry_05_codex_image_wp.md)
12. [業界分析 06: Codex 動画作成](industry_06_codex_video.md)

## 補足

業界分析のX投稿を独立工程にしたくなった場合は、`industry_05_codex_image_wp.md` の後続工程として分離します。現時点では、まず12分割を優先し、業界分析のX投稿は記事公開後の追加工程として扱います。
