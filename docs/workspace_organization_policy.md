# FIC作業フォルダ整理方針

目的は、Codex / Claude が毎回巨大な履歴・画像・動画・バックアップを読みに行かないようにし、作業ごとの参照範囲を小さく固定すること。

## 基本方針

- **実作業の正本**は `fic-investment-system` に寄せる。
- **画像・動画・過去素材・バックアップ**は、Codex が通常読む作業フォルダから外す。
- **画像の中間生成物・旧版・没版**は、WordPress反映後に採用版が確認できたら削除する。残すのは採用版、参考画像、再利用する設計素材だけ。
- **動画・音声中間素材**は、YouTube等へのアップロード完了後にローカルから削除してよい。完成動画、`wav/mp3/m4a` などの音声中間素材、書き出し途中の一時ファイルは保管しない。
- **チャット単位で役割を固定**し、読む指示書と触るフォルダを限定する。
- **既存の散らばったファイルは即移動しない**。まず索引化し、参照切れしない順番で移す。

## 推奨フォルダ構成

```text
FIC_WORKSPACE/
  fic-investment-system/          # 正本リポジトリ。プロンプト、仕様書、WPコード、作業メモ
  fic-assets/
    company_analysis/             # 完成画像、AI生成画像、非AI図表
    industry_analysis/
    reference_images/
  fic-video/
    company_analysis/             # 動画素材、完成動画
    industry_analysis/
  fic-archive/
    codex_old_sessions/           # 古いCodex作業フォルダ、退避した履歴
    make_blueprints/
    wordpress_backups/
```

現時点では `C:\Users\tomo-\Documents\Codex` 配下に日付別フォルダが多く残っているため、移行時は「コピーで検証 → 参照更新 → 元ファイル退避」の順に行う。

## Codexに読ませないもの

- `*.mp4`, `*.mov`, `*.avi`
- `wp-content/uploads/`
- 大量の `*.png`, `*.jpg`, `*.webp` の完成素材
- `backup`, `backups`, `archive`, `old`, `dist`, `build`
- `node_modules`, `vendor`
- WordPressバックアップZIP

必要な画像だけは、各記事の `work/...` か `fic-assets/...` のパスを明示して読む。

## 12チャット分割との関係

チャット別の開き方は `docs/chat_workflows/` を正本にする。

- 企業分析は、資料作成、Claude記事作成、Codexレビュー、画像/WP、X投稿、動画作成に分ける。
- 業界分析は、テーマ候補、資料作成、Claude記事作成、Codexレビュー、画像/WP、動画作成に分ける。
- 各チャットでは `docs/chat_workflows/*.md` の該当ファイルだけを最初に読む。

## 移行手順

1. `C:\Users\tomo-\Documents\Codex` 配下の大容量フォルダを棚卸しする。
2. 動画・完成画像・バックアップを `fic-assets` / `fic-video` / `fic-archive` へコピーする。
3. `fic-investment-system` 内に残す必要があるものだけを確認する。
4. チャットテンプレ内の参照パスを正本リポジトリ基準に揃える。
5. 問題なく運用できることを確認してから、古い日付フォルダを退避する。

## 注意点

- Claudeや別チャットが参照しているファイルを急に移動しない。
- スプレッドシートに記録済みの記事パス・画像フォルダは、移動後に必ず更新する。
- WordPress投稿ID、スラッグ、画像URLは移動の影響を受けないが、ローカル作業パスは更新が必要。
- 画像削除は、採用画像がWordPress本文・アイキャッチ・X投稿・動画作成予定で確認できた後に行う。削除対象は、生成途中の画像、旧バージョン、没案、差し替え前画像、重複エクスポート。判断できない画像は削除せず `要確認` にする。
- 動画削除は、アップロード完了とURL/投稿予定への反映を確認してから行う。削除対象はローカルの動画ファイル、音声中間素材、仮書き出しファイル。プロンプト、台本、設定JSON、サムネイル採用版は残してよい。
