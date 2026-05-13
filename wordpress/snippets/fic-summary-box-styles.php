<?php

add_action('wp_head', function () {
    ?>
<style id="fic-summary-box-style">
.summary-box{position:relative;background:linear-gradient(90deg,rgba(255,213,0,.13),rgba(255,213,0,0) 42%),#fff;border:1px solid #d8dce3;border-top:4px solid #1f1f23;border-left:6px solid #ffd500;border-radius:0;padding:24px 28px 22px;margin:30px 0 38px;box-shadow:0 14px 30px rgba(31,31,35,.07)}
.summary-box::before{content:"SUMMARY";display:inline-flex;align-items:center;min-height:22px;margin:0 0 12px;padding:3px 9px;background:#1f1f23;color:#ffd500;font-size:.72em;font-weight:800;line-height:1;letter-spacing:.08em}
.summary-box p:first-child{font-size:1.08em;font-weight:700;margin:0 0 13px;color:#1f1f23;letter-spacing:0;line-height:1.65}
.summary-box ul{margin:0;padding-left:0;list-style:none}
.summary-box li{position:relative;margin-bottom:9px;padding-left:20px;line-height:1.78;color:#333}
.summary-box li::before{content:"";position:absolute;top:.78em;left:2px;width:7px;height:7px;background:#ffd500;border:2px solid #1f1f23;box-sizing:border-box}
.summary-box li:last-child{margin-bottom:0}
</style>
    <?php
}, 101);
