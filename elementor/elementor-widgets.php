<?php
if (!defined('ABSPATH')) {
    exit;
}

function register_widget_custom_slide() {
    require_once(plugin_dir_path(__FILE__) . '/widgets/widget-slide-post.php');
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Widget_Slide_Post());
}
add_action('elementor/widgets/widgets_registered', 'register_widget_custom_slide');

function add_elementor_widget_categories( $elements_manager ) {

	$elements_manager->add_category(
		'dc_cat',
		[
			'title' => esc_html__( 'DC Plugin', 'textdomain' ),
			'icon' => 'fa fa-plug',
		]
	);
}
add_action( 'elementor/elements/categories_registered', 'add_elementor_widget_categories' );