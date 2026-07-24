<?php
/**
 * Plugin Name:       CalaSlide – Posts Carousel for Elementor
 * Plugin URI:        https://danilocalabrese.it/plugin/calaslide-posts-carousel-for-elementor/
 * Description:       Elementor widget that displays WordPress posts in a responsive Slick-based carousel.
 * Version:           1.1.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Requires Plugins:  elementor
 * Author:            Danilo Calabrese
 * Author URI:        https://danilocalabrese.it
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       calaslide-posts-carousel-for-elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CALASLIDE_VERSION', '1.1.0' );
define( 'CALASLIDE_PLUGIN_FILE', __FILE__ );
define( 'CALASLIDE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CALASLIDE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CALASLIDE_MIN_ELEMENTOR', '3.5.0' );

/**
 * Admin notice when Elementor is missing or too old.
 */
function calaslide_admin_notice_missing_elementor() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	printf(
		'<div class="notice notice-warning"><p>%s</p></div>',
		esc_html__( 'Slide Posts Widget requires Elementor 3.5 or newer to be installed and active.', 'calaslide-posts-carousel-for-elementor' )
	);
}

/**
 * Bootstrap: register the widget only when Elementor is available.
 */
function calaslide_init() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'calaslide_admin_notice_missing_elementor' );
		return;
	}
	if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, CALASLIDE_MIN_ELEMENTOR, '<' ) ) {
		add_action( 'admin_notices', 'calaslide_admin_notice_missing_elementor' );
		return;
	}

	add_action( 'elementor/widgets/register', 'calaslide_register_widget' );
	add_action( 'elementor/elements/categories_registered', 'calaslide_register_widget_category' );
}
add_action( 'plugins_loaded', 'calaslide_init' );

/**
 * Register the widget (Elementor >= 3.5 API).
 *
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 */
function calaslide_register_widget( $widgets_manager ) {
	require_once CALASLIDE_PLUGIN_DIR . 'includes/widgets/class-calaslide-widget-slide-post.php';
	$widgets_manager->register( new \CalaSlide\Widget_Slide_Post() );
}

/**
 * Custom widget category.
 *
 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
 */
function calaslide_register_widget_category( $elements_manager ) {
	$elements_manager->add_category(
		'calaslide',
		array(
			'title' => esc_html__( 'CalaSlide', 'calaslide-posts-carousel-for-elementor' ),
			'icon'  => 'fa fa-plug',
		)
	);
}

/**
 * Register assets. They are only ENQUEUED when the widget is actually used
 * (via get_script_depends / get_style_depends in the widget class).
 */
function calaslide_register_assets() {
	wp_register_style(
		'calaslide-slick',
		CALASLIDE_PLUGIN_URL . 'assets/vendor/slick/slick.css',
		array(),
		'1.8.1'
	);
	wp_register_style(
		'calaslide-slick-theme',
		CALASLIDE_PLUGIN_URL . 'assets/vendor/slick/slick-theme.css',
		array( 'calaslide-slick' ),
		'1.8.1'
	);
	wp_register_style(
		'calaslide-style',
		CALASLIDE_PLUGIN_URL . 'assets/css/style.css',
		array( 'calaslide-slick' ),
		CALASLIDE_VERSION
	);
	wp_register_script(
		'calaslide-slick',
		CALASLIDE_PLUGIN_URL . 'assets/vendor/slick/slick.min.js',
		array( 'jquery' ),
		'1.8.1',
		true
	);
	wp_register_script(
		'calaslide-main',
		CALASLIDE_PLUGIN_URL . 'assets/js/main.js',
		array( 'jquery', 'calaslide-slick' ),
		CALASLIDE_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'calaslide_register_assets' );
add_action( 'elementor/editor/before_enqueue_scripts', 'calaslide_register_assets' );
