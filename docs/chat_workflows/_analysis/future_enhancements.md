# 将来拡張（フェーズ6以降で検討）

フェーズ5では実装しない。安定後に検討する候補の記録。

## 拡張1: X検索機能の組み込み

- 背景: NousResearch社の Hermes Agent v0.14.0 や search-x Skill (mcp.directory) など、
  Claude Code から X(Twitter) を検索する方法が複数存在。
- 候補アプローチ:
  - A. SuperGrok OAuth + Hermes Agent（X Premium+加入が前提、追加コスト実質ゼロ）
  - B. search-x Skill + xAI APIキー（月約$53、Claude Code内で完結）
- FIC方針: パイロット安定後、Claude Codeに推奨を聞いた上でどちらか採用を検討。
- 想定利用役員:
  - scout: 「今X上で話題の銘柄」リアルタイム取得
  - theme_scout: 「業界・テーマ別の最新トレンド」取得
  - x_writer: 投稿前のトレンドリサーチ

## 拡張2: X自動投稿の検討

- 現状: `x-api.json` は配置済みだが、APIコストが高く手動投稿。
- 検討タイミング: 拡張1（X検索機能導入）と合わせて自動投稿の是非を再検討。

## 拡張3: 認証情報のスクリプト経由化（段階2）

- 現状（段階1）: Claude Code が認証情報を直接読む方式。
- 将来案: `.claude/scripts/` に WP投稿/Sheets更新スクリプトを配置し、Claude Code は実行のみ・認証値を直接見ない。
- メリット: プロンプトインジェクション耐性向上。

## 拡張4: WordPress連携の最終的なCodex完全切り離し

- 現状: WP連携は段階3でClaude Code側に移行予定。
- 将来確認: `data/.gcp-sheets-credentials.json` の `.secrets/` への移動と、Codex側参照の停止。
</content>
