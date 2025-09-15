<?php
/**
 * Plugin Name: Slide post elementor
 * Plugin URI: https://danilocalabrese.it/plugins/slide-post
 * Description: Aggiunge un widget personalizzato per Elementor che mostra i post di WordPress in uno slider responsive basato su Slick.js.
 * Version: 1.0.0
 * Author: Danilo Calabrese
 * Author URI: https://danilocalabrese.it
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domainn: slide-post-plugin
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

function slide_post_plugin_activate() {
}
register_activation_hook(__FILE__, 'slide_post_plugin_activate');

if (!function_exists('add_action')) {
    require_once(ABSPATH . 'wp-includes/plugin.php');
}
if (!function_exists('add_menu_page')) {
    require_once(ABSPATH . 'wp-admin/includes/plugin.php');
}
if (!function_exists('plugins_url')) {
    require_once(ABSPATH . 'wp-includes/link-template.php');
}
function slide_post_plugin_deactivate() {
}
register_deactivation_hook(__FILE__, 'slide_post_plugin_deactivate');


// Include file
require_once plugin_dir_path(__FILE__) . 'elementor/elementor-widgets.php';

// Includi lo stile frontend del plugin
function slide_post_plugin_enqueue_styles() {
    if (!is_admin()) {
        wp_enqueue_style(
            'slide-post-style',
            plugin_dir_url(__FILE__) . 'style.css',
            array(),
            '1.0.0'
        );
        wp_enqueue_script(
            'slide-post-script',
            plugin_dir_url(__FILE__) . '/js/main.js',
            ['jquery'],
            '1.0',
            true 
        );  
          
    }
}
add_action('wp_enqueue_scripts', 'slide_post_plugin_enqueue_styles');

add_action('elementor/frontend/after_enqueue_styles', function() {
	wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
	wp_enqueue_style('slick-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');
});

add_action('elementor/frontend/after_enqueue_scripts', function() {
	wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], null, true);
});
