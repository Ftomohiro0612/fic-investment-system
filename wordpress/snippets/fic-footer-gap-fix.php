add_action('wp_head', function () {
    echo '<style id="fic-footer-gap-fix">#container{min-height:auto!important;}#footer{margin-top:0!important;}</style>' . "\n";
}, 100);
