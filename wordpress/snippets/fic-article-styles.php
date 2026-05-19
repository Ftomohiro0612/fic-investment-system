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

/* ============== 各章の導入リード（<p><em>...</em></p>を通常フォントの案内枠にする） ============== */
.single .entry-content p:has(> em:only-child),
.post-content p:has(> em:only-child),
.article-content p:has(> em:only-child),
.content p:has(> em:only-child){background:#fffdf2;border-top:1px solid #e8e8e8;border-right:1px solid #e8e8e8;border-bottom:1px solid #e8e8e8;border-left:5px solid #ffd500;color:#1f1f23;font-size:.98em;line-height:1.85;margin:20px 0 26px;padding:15px 20px}
.single .entry-content p:has(> em:only-child) em,
.post-content p:has(> em:only-child) em,
.article-content p:has(> em:only-child) em,
.content p:has(> em:only-child) em{font-style:normal}

/* ============== 表の自動幅調整（列数が多い表を無理に潰さない） ============== */
.content .table-wrapper,
.table-wrapper{display:block;width:100%;max-width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}
.content .table-wrapper table,
.table-wrapper table{width:100%!important;min-width:100%!important;table-layout:auto!important}
.table-wrapper caption,
.single .entry-content .table-wrapper caption,
.post-content .table-wrapper caption,
.article-content .table-wrapper caption{caption-side:top;text-align:left;background:#fffdf2;border-top:1px solid #e8e8e8;border-right:1px solid #e8e8e8;border-bottom:0;border-left:5px solid #ffd500;color:#1f1f23;font-size:.93em;font-weight:700;line-height:1.55;margin:0;padding:10px 14px 10px 16px}
.table-wrapper caption::before,
.single .entry-content .table-wrapper caption::before,
.post-content .table-wrapper caption::before,
.article-content .table-wrapper caption::before{content:"表";display:inline-flex;align-items:center;justify-content:center;min-width:2.4em;margin-right:.7em;padding:3px 7px;background:#1f1f23;color:#ffd500;font-size:.78em;font-weight:800;line-height:1;vertical-align:.08em}
.article-image figcaption,
.fic-article-image figcaption,
.wp-block-image figcaption,
.post_content figure figcaption,
.single .entry-content figure figcaption,
.post-content figure figcaption,
.article-content figure figcaption{display:block;margin:10px 0 0!important;padding:9px 13px!important;font-size:.84em!important;font-weight:400!important;color:#555!important;background:#f7f7f7!important;border-left:4px solid #ffd500!important;border-radius:0!important;line-height:1.65!important;text-align:left!important;font-style:normal!important}
.article-image figcaption::before,
.fic-article-image figcaption::before,
.wp-block-image figcaption::before,
.post_content figure figcaption::before,
.single .entry-content figure figcaption::before,
.post-content figure figcaption::before,
.article-content figure figcaption::before{content:"画像説明";display:inline-flex;align-items:center;margin-right:.65em;padding:3px 7px;background:#1f1f23;color:#ffd500;font-size:.78em;font-weight:800;line-height:1;vertical-align:.08em}
.content .table-wrapper table:has(tr > :nth-child(5)),
.table-wrapper table:has(tr > :nth-child(5)){min-width:900px!important}
.content .table-wrapper table:has(tr > :nth-child(6)),
.table-wrapper table:has(tr > :nth-child(6)){min-width:1050px!important}
.content .table-wrapper th,
.content .table-wrapper td,
.table-wrapper th,
.table-wrapper td{min-width:9em!important;max-width:none!important;white-space:normal!important;overflow-wrap:break-word}
@media (max-width:767px){
  .content .table-wrapper table,
  .table-wrapper table{min-width:720px!important}
  .content .table-wrapper th,
  .content .table-wrapper td,
  .table-wrapper th,
  .table-wrapper td{min-width:8em!important}
}
</style>
    <?php
}, 101);
