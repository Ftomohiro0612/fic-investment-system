# 30秒要約テンプレート

今後の記事冒頭では、既存の `summary-box` を使って「30秒要約」を固定表示する。

## 企業分析記事

```html
<div class="summary-box">
<p><strong>30秒要約</strong></p>
<ul>
<li><strong>事業の見方：</strong>[企業が何で稼ぐ会社か]</li>
<li><strong>業績ドライバー：</strong>[売上・利益を動かす最大要因]</li>
<li><strong>追い風：</strong>[プラス材料]</li>
<li><strong>リスク：</strong>[下振れ要因]</li>
<li><strong>見る指標：</strong>[次回決算で見る指標3つ以内]</li>
</ul>
</div>
```

## 業界分析記事

```html
<div class="summary-box">
<p><strong>30秒要約</strong></p>
<ul>
<li><strong>何が起きているか：</strong>[対象業界・テーマで起きている変化]</li>
<li><strong>追い風：</strong>[恩恵を受けやすい業界・企業・収益項目]</li>
<li><strong>逆風：</strong>[影響を受けやすい業界・企業・コスト項目]</li>
<li><strong>見る指標：</strong>[投資家が次に確認すべき先行指標3つ以内]</li>
<li><strong>注意点：</strong>[反対シナリオ、織り込み済み、持続性のうち最も重要な注意点]</li>
</ul>
</div>
```

## 運用メモ

- 既存記事への一括差し替えは、記事本文の自然さと数値整合性を確認しながら別タスクで行う。
- 新規生成・再生成記事では、旧名称の「この記事の結論」は使わない。
- `この記事でわかること` は重複しやすいため、原則任意の軽い導線ボックスとして扱う。
