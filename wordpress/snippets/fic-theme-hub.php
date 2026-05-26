<?php
/**
 * FIC theme hub shortcode.
 *
 * Shortcode: [fic_theme_hub]
 */

if (!function_exists('fic_theme_hub_shortcode')) {
    function fic_theme_hub_shortcode() {
        return function_exists('fic_render_theme_hub') ? fic_render_theme_hub() : '';
    }
}

add_shortcode('fic_theme_hub', 'fic_theme_hub_shortcode');
