# Legacy Master Migration Audit

旧 `FIC_HANDOFF_MASTER.md` は、日常作業の入口ではなく、過去ルールの保管資料として扱います。

旧Master:

```text
C:\Users\tomo-\Documents\FIC\fic-archive\old_codex_workspaces\2026-05-08\fic-c-users-tomo-documents-codex\FIC_HANDOFF_MASTER.md
```

現在の入口:

```text
C:\Users\tomo-\Documents\FIC\START_HERE.md
C:\Users\tomo-\Documents\FIC\fic-investment-system\docs\chat_workflows\README.md
```

## 方針

- 旧Masterを新チャットで毎回読ませない。
- 必要な規律は、現行の仕様書・プロンプト・工程別テンプレートへ移す。
- 旧Masterにしかないルールを見つけた場合は、旧Masterを参照し続けるのではなく、該当する現行ドキュメントへ抽出する。
- 旧Masterは、移行漏れ確認用としてアーカイブに残す。すぐ削除しない。

## 移行状況

| 旧Masterの主な内容 | 現在の移行先 | 状態 |
|---|---|---|
| 作業場所・正本リポジトリ | `C:\Users\tomo-\Documents\FIC\START_HERE.md` / `docs/workspace_organization_policy.md` | 移行済み |
| 新チャット分割方針 | `docs/chat_workflows/README.md` と各工程テンプレート | 移行済み |
| 企業分析の資料作成・Claude引き渡し | `docs/chat_workflows/company_01_codex_pack.md` / `docs/codex_company_analysis_pack_spec.md` | 移行済み |
| 企業分析のClaude記事作成 | `docs/chat_workflows/company_02_claude_article.md` / 企業分析 article prompt | 移行済み |
| 企業分析のCodexレビュー | `docs/chat_workflows/company_03_codex_review.md` / `claude_review_notes` 運用 | 移行済み |
| 企業分析の画像作成・WordPress反映 | `docs/chat_workflows/company_04_codex_image_wp.md` / `docs/wordpress_media_cleanup_policy.md` | 移行済み |
| 企業分析のX投稿 | `docs/chat_workflows/company_05_codex_x_post.md` / `docs/x_post_company_analysis_workflow.md` / `prompts/social/x_post_company_analysis_main.md` | 移行済み |
| 企業分析の動画作成 | `docs/chat_workflows/company_06_codex_video.md` / `docs/wordpress_media_cleanup_policy.md` | 概要移行済み |
| 業界分析テーマ候補作成 | `docs/chat_workflows/industry_01_codex_trend_candidates.md` / 業界分析プロンプト | 移行済み |
| 業界分析の資料作成 | `docs/chat_workflows/industry_02_codex_pack.md` / `docs/codex_industry_analysis_migration_spec.md` | 移行済み |
| 業界分析のClaude記事作成 | `docs/chat_workflows/industry_03_claude_article.md` / `docs/claude_industry_analysis_handoff.md` | 移行済み |
| 業界分析のCodexレビュー | `docs/chat_workflows/industry_04_codex_review.md` / `industry_analysis_review_notes.md` 運用 | 移行済み |
| 業界分析の画像作成・WordPress反映 | `docs/chat_workflows/industry_05_codex_image_wp.md` / `docs/wordpress_media_cleanup_policy.md` | 移行済み |
| 業界分析のX投稿 | `docs/chat_workflows/industry_06_codex_x_post.md` / `prompts/social/x_post_industry_analysis_main.md` | 移行済み |
| 業界分析の動画作成 | `docs/chat_workflows/industry_07_codex_video.md` / `docs/wordpress_media_cleanup_policy.md` | 概要移行済み |
| WordPressは既存IDがあれば更新、新規は最後 | `company_04_codex_image_wp.md` / `industry_05_codex_image_wp.md` | 移行済み |
| スラッグは一度決めたら変更しない | `company_04_codex_image_wp.md` / `industry_05_codex_image_wp.md` | 移行済み |
| 画像・動画の中間生成物削除 | `docs/wordpress_media_cleanup_policy.md` | 移行済み |
| 関連銘柄・関連記事の自動挿入方針 | `wordpress/snippets/functions.php` / 企業・業界分析プロンプト | 移行済み |
| 英字付き証券コード対応 | `wordpress/snippets/functions.php` | 移行済み |
| GA4 / Search Console / SEO確認 | なし | 未移行 |
| X返信・引用運用 | なし | 未移行 |
| 個別記事ごとの完了メモ・作業ログ | アーカイブ保管のみ | 日常運用には移行しない |
| 認証情報・APIキー・Cookie等 | 現行ドキュメントへ値を移さない | 移行禁止 |

## 残タスク

1. GA4 / Search Console / SEO確認を続けるなら、独立した `docs/chat_workflows/` テンプレートを作る。
2. X返信・引用運用を続けるなら、X投稿とは別の軽いテンプレートを作る。
3. 動画作成の詳細ノウハウは、必要時に旧Masterから抽出し、会社・業界それぞれの動画テンプレートへ移す。
4. Google Sheetsに残る旧絶対パスは、対象行の作業時に新パスへ更新する。
5. 古い個別記事ログは、検索が必要な時だけアーカイブから読む。新チャットの標準入力にはしない。

## 判断ルール

旧Masterと現行ドキュメントが矛盾する場合は、現行ドキュメントを優先します。

旧Masterにしかない重要ルールを見つけた場合は、次の順で処理します。

1. どの工程に関係するかを決める。
2. 該当する `docs/chat_workflows/*.md`、仕様書、またはプロンプトへ移す。
3. 必要ならこの監査メモの移行状況を更新する。

