# ワークフロー再設計 分析記録（_analysis）

このフォルダは、FIC投資研究所のコンテンツ制作ワークフロー（記事・X投稿・動画）を、
Codex主体の現行体制から **Claude Code の Skills + Subagents 体制** へ再設計する際の
検討プロセスを、後から「なぜこの設計判断をしたか」を振り返れるよう残す歴史的記録です。

実体のワークフローテンプレートは親フォルダ [../](../)（`docs/chat_workflows/`）にあります。
当初メモでは `workflow_templates/` と呼ばれていましたが、リポジトリ上の実フォルダは
`docs/chat_workflows/` です。本記録もそこに同居させています。

## ファイル

| ファイル | 内容 | 対応フェーズ |
|---|---|---|
| [phase1_2_current_state.md](phase1_2_current_state.md) | 現行13工程（企業6＋業界7）の全工程フロー、役割表、設計上の論点、依存関係マップ | フェーズ1〜2（現状把握＋整理） |
| [phase3_design_direction.md](phase3_design_direction.md) | 再設計の方針。Codex主体になった歴史的背景、8役員(subagent)構想、Skill化方針、各論点(C-1〜C-6)への回答、designer責任範囲、WP/Sheets完全集約、認証方針、Codex残置候補 | フェーズ3（FICからの設計方針提供） |
| [phase4_final_design.md](phase4_final_design.md) | 最終確定設計。15 Skills／9 Subagents／Codex残置／認証マッピング（8 JSON）／scout新タブ／二重チェック確定／handoff冒頭テンプレ | フェーズ4（マッピング確定） |
| [phase5_pilot_plan.md](phase5_pilot_plan.md) | 段階的承認方式の実装計画（段階0環境準備〜段階4）。王子HD(3861)パイロット、企業分析_pilotタブ隔離、昇格基準 | フェーズ5（実装計画） |
| [future_enhancements.md](future_enhancements.md) | フェーズ6以降の拡張候補（X検索/自動投稿/認証スクリプト化/WP完全切り離し） | フェーズ6+ |

参照順: README → phase1_2 → phase3 → phase4 → phase5 → future_enhancements。

## 進め方（フェーズ）

1. **フェーズ1〜2**: 現状把握と整理 → `phase1_2_current_state.md`
2. **フェーズ3**: FICが設計方針・背景・理想像を提供 → `phase3_design_direction.md`
3. **フェーズ4**: 3層配置マッピング案／Skills・Subagents設計／Codex残置／移行計画（チャットで提示し、FICがレビュー）
4. **フェーズ5以降**: 採用確定 → パイロット実装（少数Skill＋少数Subagent）→ 過去記事での再現テスト → 全面移行

## 重要な前提（再設計を読むときの注意）

- 現行のCodex主体ワークフローは、過去の試行錯誤（事故・修正履歴）で積み上がった規律を含む。
  安易に「全部Claudeへ」と判断せず、各工程の本質的役割を見極めて再配置する。
- Codexを完全に置き換える目的ではない。役割分担の最適化が目的。
- 「重複しているルール」は、工程をまたいだ意図的な二重チェック（多段防御）の可能性がある。
  Skill化で1回に集約してよいか、各段で再チェックすべきかを区別する。
</content>
</invoke>
