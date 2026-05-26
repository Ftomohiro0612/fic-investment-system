<?php
/**
 * FIC learning hub shortcode.
 *
 * Shortcode: [fic_learning_hub]
 */

if (!function_exists('fic_learning_hub_shortcode')) {
    function fic_learning_hub_shortcode() {
        return function_exists('fic_render_learning_hub') ? fic_render_learning_hub() : '';
    }
}

add_shortcode('fic_learning_hub', 'fic_learning_hub_shortcode');
