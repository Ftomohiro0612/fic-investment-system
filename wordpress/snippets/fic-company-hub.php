<?php
/**
 * FIC company hub shortcode.
 *
 * Shortcode: [fic_company_hub]
 */

if (!function_exists('fic_company_hub_shortcode')) {
    function fic_company_hub_shortcode() {
        return function_exists('fic_render_company_hub') ? fic_render_company_hub() : '';
    }
}

add_shortcode('fic_company_hub', 'fic_company_hub_shortcode');
