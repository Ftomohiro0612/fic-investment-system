<?php
/**
 * FIC記事テーブル レスポンシブ幅調整
 *
 * 列数が多い表を記事幅へ無理に圧縮せず、本文セルの内容に応じて幅を確保し、
 * 必要な場合は .table-wrapper の横スクロールで吸収する。
 */

add_action('wp_head', function () {
    ?>
<style id="fic-responsive-table-style">
.content .table-wrapper,
.table-wrapper{display:block;width:100%;max-width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}
.content .table-wrapper table,
.table-wrapper table{width:max-content!important;min-width:100%!important;table-layout:auto!important}
.content .table-wrapper th,
.content .table-wrapper td,
.table-wrapper th,
.table-wrapper td{min-width:9em!important;max-width:none!important;white-space:normal!important;overflow-wrap:break-word;word-break:normal!important;line-break:strict}
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
}, 102);
