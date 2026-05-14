<?php
/**
 * FIC企業分析記事 追加スタイル
 *
 * テンプレート: wordpress/templates/company_analysis_template.html
 * 対象クラス:
 *   - .one-liner-summary（記事冒頭の1行サマリー、<mark>強調対応）
 *   - .definition-lead（記事概要・論点先出しブロック）
 *
 * EY風デザイントークン（黄 #ffd500 / 黒 #1f1f23 / ソフトボーダー）と整合。
 * 既存の `summary-box` `beginner-box` `table-wrapper` `disclaimer` `author-credit` と
 * 並んで違和感のないトーンで配色する。
 *
 * `mark` 自体は custom.css にFIC黄色マーカー定義あり（55%下半分黄色）なので
 * このスニペットでは再定義しない。
 */

add_action('wp_head', function () {
    ?>
<style id="fic-article-style">
/* ============== 1行サマリー（記事冒頭の核） ============== */
.one-liner-summary{position:relative;margin:24px 0 22px;padding:18px 22px 18px 26px;background:linear-gradient(90deg,rgba(255,213,0,.08),rgba(255,213,0,0) 60%),#fff;border:1px solid #d8dce3;border-left:6px solid #ffd500;border-radius:0;font-size:1.12em;font-weight:700;line-height:1.78;color:#1f1f23;letter-spacing:0;box-shadow:0 10px 22px rgba(31,31,35,.05)}
.one-liner-summary::before{content:"ONE-LINER";display:flex;width:max-content;max-width:100%;align-items:center;min-height:20px;margin:0 0 10px;padding:3px 8px;background:#1f1f23;color:#ffd500;font-size:.66em;font-weight:800;line-height:1;letter-spacing:.08em}
.one-liner-summary>br:first-child{display:none}

/* ============== 記事概要・論点先出し（definition-lead） ============== */
.definition-lead{background:#fafafa;border:1px solid #e8e8e8;border-left:4px solid #bfbfbf;border-radius:0;padding:14px 20px;margin:14px 0 28px;font-size:.96em;line-height:1.85;color:#444}
.definition-lead p{margin:0}
.definition-lead p+p{margin-top:.6em}
</style>
    <?php
}, 101);
