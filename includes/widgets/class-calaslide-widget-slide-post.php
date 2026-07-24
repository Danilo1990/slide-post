<?php
/**
 * Slide Post widget.
 *
 * Widget name and control IDs are kept identical to v1.0.0
 * ('calaslide_posts' — rinominato per wp.org; 'posts', 'items', 'items_scrool', 'show_excepert', ...)
 * so existing Elementor pages keep working after the update.
 *
 * @package SlidePostsWidget
 */

namespace CalaSlide;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Widget_Slide_Post extends Widget_Base {

	public function get_name() {
		return 'calaslide_posts';
	}

	public function get_title() {
		return esc_html__( 'CalaSlide Posts', 'calaslide-posts-carousel-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-post-slider';
	}

	public function get_categories(): array {
		return array( 'calaslide' );
	}

	public function get_keywords() {
		return array( 'slider', 'carousel', 'posts', 'slick' );
	}

	/**
	 * Assets are enqueued only when the widget is present on the page.
	 */
	public function get_script_depends() {
		return array( 'calaslide-slick', 'calaslide-main' );
	}

	public function get_style_depends() {
		return array( 'calaslide-slick', 'calaslide-slick-theme', 'calaslide-style' );
	}

	/**
	 * Whether Elementor Pro query controls are available.
	 */
	protected function has_pro_query() {
		return class_exists( '\ElementorPro\Modules\QueryControl\Module' )
			&& class_exists( '\ElementorPro\Modules\QueryControl\Controls\Group_Control_Related' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_option',
			array(
				'label' => esc_html__( 'Items', 'calaslide-posts-carousel-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_image',
			array(
				'label'        => esc_html__( 'Show image', 'calaslide-posts-carousel-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'calaslide-posts-carousel-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'calaslide-posts-carousel-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_tax',
			array(
				'label'        => esc_html__( 'Show category', 'calaslide-posts-carousel-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'calaslide-posts-carousel-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'calaslide-posts-carousel-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_title',
			array(
				'label'        => esc_html__( 'Show title', 'calaslide-posts-carousel-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'calaslide-posts-carousel-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'calaslide-posts-carousel-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_excepert',
			array(
				'label'        => esc_html__( 'Show excerpt', 'calaslide-posts-carousel-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'calaslide-posts-carousel-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'calaslide-posts-carousel-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'n_charts',
			array(
				'label'     => esc_html__( 'Excerpt length (words)', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 5,
				'max'       => 100,
				'step'      => 1,
				'default'   => 10,
				'condition' => array(
					'show_excepert' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_button',
			array(
				'label'        => esc_html__( 'Show button', 'calaslide-posts-carousel-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'calaslide-posts-carousel-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'calaslide-posts-carousel-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'btn_text',
			array(
				'label'       => esc_html__( 'Button text', 'calaslide-posts-carousel-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read more', 'calaslide-posts-carousel-for-elementor' ),
				'placeholder' => esc_html__( 'Type your text here', 'calaslide-posts-carousel-for-elementor' ),
				'condition'   => array(
					'show_button' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_query',
			array(
				'label' => esc_html__( 'Query', 'calaslide-posts-carousel-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'posts',
			array(
				'label'   => esc_html__( 'Posts per page', 'calaslide-posts-carousel-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 10,
				'min'     => 1,
				'max'     => 100,
			)
		);

		if ( $this->has_pro_query() ) {
			// Elementor Pro: full query builder.
			$this->add_group_control(
				\ElementorPro\Modules\QueryControl\Controls\Group_Control_Related::get_type(),
				array(
					'name'    => 'control_name',
					'presets' => array( 'full' ),
					// phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude -- 'exclude' is an Elementor group-control config key (hides a control from the panel), not a WP_Query exclusionary parameter.
					'exclude' => array(
						'posts_per_page',
					),
				)
			);
		} else {
			// Fallback without Elementor Pro: post type + category.
			$post_types = get_post_types( array( 'public' => true ), 'objects' );
			$options    = array();
			foreach ( $post_types as $post_type ) {
				if ( 'attachment' === $post_type->name ) {
					continue;
				}
				$options[ $post_type->name ] = $post_type->labels->singular_name;
			}

			$this->add_control(
				'calaslide_post_type',
				array(
					'label'   => esc_html__( 'Post type', 'calaslide-posts-carousel-for-elementor' ),
					'type'    => Controls_Manager::SELECT,
					'options' => $options,
					'default' => 'post',
				)
			);

			$this->add_control(
				'calaslide_orderby',
				array(
					'label'   => esc_html__( 'Order by', 'calaslide-posts-carousel-for-elementor' ),
					'type'    => Controls_Manager::SELECT,
					'options' => array(
						'date'       => esc_html__( 'Date', 'calaslide-posts-carousel-for-elementor' ),
						'title'      => esc_html__( 'Title', 'calaslide-posts-carousel-for-elementor' ),
						'menu_order' => esc_html__( 'Menu order', 'calaslide-posts-carousel-for-elementor' ),
						'rand'       => esc_html__( 'Random', 'calaslide-posts-carousel-for-elementor' ),
					),
					'default' => 'date',
				)
			);
		}

		$this->end_controls_section();

		$this->start_controls_section(
			'section_option_slide',
			array(
				'label' => esc_html__( 'Slide options', 'calaslide-posts-carousel-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_responsive_control(
			'items',
			array(
				'label'   => esc_html__( 'Items to show', 'calaslide-posts-carousel-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 10,
			)
		);

		$this->add_control(
			'items_scrool',
			array(
				'label'   => esc_html__( 'Items to scroll', 'calaslide-posts-carousel-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 10,
			)
		);

		$this->add_control(
			'show_arrow',
			array(
				'label'        => esc_html__( 'Show arrows', 'calaslide-posts-carousel-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'calaslide-posts-carousel-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'calaslide-posts-carousel-for-elementor' ),
				'return_value' => 'true',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_dots',
			array(
				'label'        => esc_html__( 'Show dots', 'calaslide-posts-carousel-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'calaslide-posts-carousel-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'calaslide-posts-carousel-for-elementor' ),
				'return_value' => 'true',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'item_style',
			array(
				'label' => esc_html__( 'Item', 'calaslide-posts-carousel-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'image_options',
			array(
				'label'     => esc_html__( 'Image', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'image_height',
			array(
				'label'      => esc_html__( 'Image height', 'calaslide-posts-carousel-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 250,
				),
				'selectors'  => array(
					'{{WRAPPER}} .slide-post-thumb' => 'min-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'items_options',
			array(
				'label'     => esc_html__( 'Items', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} .slide-post-item',
			)
		);

		$this->add_control(
			'border_radius_item',
			array(
				'label'      => esc_html__( 'Border radius', 'calaslide-posts-carousel-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .slide-post-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'items_height',
			array(
				'label'      => esc_html__( 'Items height', 'calaslide-posts-carousel-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 250,
				),
				'selectors'  => array(
					'{{WRAPPER}} .slide-post-item' => 'min-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'text_style',
			array(
				'label' => esc_html__( 'Content', 'calaslide-posts-carousel-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'padding_text',
			array(
				'label'      => esc_html__( 'Padding', 'calaslide-posts-carousel-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'default'    => array(
					'top'      => 10,
					'right'    => 10,
					'bottom'   => 10,
					'left'     => 10,
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .slide-item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'title_options',
			array(
				'label'     => esc_html__( 'Title', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .slide-post-title',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title color', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slide-post-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'title_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'calaslide-posts-carousel-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .slide-post-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'excepert_options',
			array(
				'label'     => esc_html__( 'Excerpt', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'excepert_typography',
				'selector' => '{{WRAPPER}} .slide-post-excerpt',
			)
		);

		$this->add_control(
			'excepert_color',
			array(
				'label'     => esc_html__( 'Excerpt color', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slide-post-excerpt' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'excepert_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'calaslide-posts-carousel-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .slide-post-excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'cat_options',
			array(
				'label'     => esc_html__( 'Categories', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'cat_typography',
				'selector' => '{{WRAPPER}} .slide-post-tax li',
			)
		);

		$this->add_control(
			'cat_color',
			array(
				'label'     => esc_html__( 'Category color', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slide-post-tax li' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'cat_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'calaslide-posts-carousel-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .slide-post-tax' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'btn_style',
			array(
				'label' => esc_html__( 'Button', 'calaslide-posts-carousel-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'btn_align',
			array(
				'label'     => esc_html__( 'Button alignment', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'calaslide-posts-carousel-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'calaslide-posts-carousel-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'calaslide-posts-carousel-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .slide-post-btn' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'btn_typography',
				'selector' => '{{WRAPPER}} .btn-slide-post',
				'global'   => array(
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT,
				),
			)
		);

		$this->start_controls_tabs( 'style_tabs_btn' );

		$this->start_controls_tab(
			'style_normal_btn',
			array(
				'label' => esc_html__( 'Normal', 'calaslide-posts-carousel-for-elementor' ),
			)
		);

		$this->add_control(
			'btn_bg_color',
			array(
				'label'     => esc_html__( 'Background color', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .btn-slide-post' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'btn_text_color',
			array(
				'label'     => esc_html__( 'Text color', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .btn-slide-post' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_hover_btn',
			array(
				'label' => esc_html__( 'Hover', 'calaslide-posts-carousel-for-elementor' ),
			)
		);

		$this->add_control(
			'btn_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background color', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .btn-slide-post:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'btn_text_color_hover',
			array(
				'label'     => esc_html__( 'Text color', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .btn-slide-post:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'hr_btn',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'border_btn',
				'selector' => '{{WRAPPER}} .btn-slide-post',
			)
		);

		$this->add_control(
			'padding_btn',
			array(
				'label'      => esc_html__( 'Padding', 'calaslide-posts-carousel-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'default'    => array(
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .btn-slide-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'navigation_style',
			array(
				'label' => esc_html__( 'Navigation', 'calaslide-posts-carousel-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'arrow_options',
			array(
				'label'     => esc_html__( 'Arrows', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'size_arrows',
			array(
				'label'      => esc_html__( 'Size', 'calaslide-posts-carousel-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 20,
				),
				'selectors'  => array(
					'{{WRAPPER}} .button-slider.slide-arrow::before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'arrow_color',
			array(
				'label'     => esc_html__( 'Color', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .button-slider.slide-arrow::before' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'hr_arrow',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'pagination_options',
			array(
				'label'     => esc_html__( 'Pagination', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'size_pagination',
			array(
				'label'      => esc_html__( 'Size', 'calaslide-posts-carousel-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 20,
				),
				'selectors'  => array(
					'{{WRAPPER}} .slick-dots li button:before' => 'font-size: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'pagination_color',
			array(
				'label'     => esc_html__( 'Active color', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-dots li.slick-active button:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pagination_color_inactive',
			array(
				'label'     => esc_html__( 'Inactive color', 'calaslide-posts-carousel-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-dots li:not(.slick-active) button:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Build WP_Query args: Elementor Pro query builder when available,
	 * simple fallback otherwise.
	 *
	 * @param array $settings Widget settings.
	 * @return array
	 */
	protected function get_query_args( $settings ) {
		$posts_per_page = ! empty( $settings['posts'] ) ? max( 1, intval( $settings['posts'] ) ) : 10;

		if ( $this->has_pro_query() ) {
			$query_args                   = \ElementorPro\Modules\QueryControl\Module::instance()->get_query_args( 'control_name', $settings );
			$query_args['posts_per_page'] = $posts_per_page;
			return $query_args;
		}

		return array(
			'post_type'           => ! empty( $settings['calaslide_post_type'] ) ? $settings['calaslide_post_type'] : 'post',
			'posts_per_page'      => $posts_per_page,
			'orderby'             => ! empty( $settings['calaslide_orderby'] ) ? $settings['calaslide_orderby'] : 'date',
			'ignore_sticky_posts' => true,
			'post_status'         => 'publish',
		);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$show_image    = $settings['show_image'];
		$show_excepert = $settings['show_excepert'];
		$show_tax      = $settings['show_tax'];
		$show_title    = $settings['show_title'];
		$show_button   = $settings['show_button'];
		$n_charts      = ! empty( $settings['n_charts'] ) ? intval( $settings['n_charts'] ) : 10;
		$btn_text      = $settings['btn_text'];

		$items        = ! empty( $settings['items'] ) ? intval( $settings['items'] ) : 3;
		$items_tablet = ! empty( $settings['items_tablet'] ) ? intval( $settings['items_tablet'] ) : 2;
		$items_mobile = ! empty( $settings['items_mobile'] ) ? intval( $settings['items_mobile'] ) : 1;
		$items_scroll = ! empty( $settings['items_scrool'] ) ? intval( $settings['items_scrool'] ) : 1;
		$show_arrow   = filter_var( $settings['show_arrow'], FILTER_VALIDATE_BOOLEAN );
		$show_dots    = filter_var( $settings['show_dots'], FILTER_VALIDATE_BOOLEAN );

		$query = new \WP_Query( $this->get_query_args( $settings ) );

		if ( ! $query->have_posts() ) {
			echo '<p>' . esc_html__( 'No posts found.', 'calaslide-posts-carousel-for-elementor' ) . '</p>';
			return;
		}

		$slick_settings = wp_json_encode(
			array(
				'slidesToShow'   => $items,
				'slidesToScroll' => $items_scroll,
				'infinite'       => true,
				'dots'           => $show_dots,
				'arrows'         => $show_arrow,
				'prevArrow'      => '<button class="button-slider slide-arrow prev-arrow" aria-label="' . esc_attr__( 'Previous', 'calaslide-posts-carousel-for-elementor' ) . '"></button>',
				'nextArrow'      => '<button class="button-slider slide-arrow next-arrow" aria-label="' . esc_attr__( 'Next', 'calaslide-posts-carousel-for-elementor' ) . '"></button>',
				'responsive'     => array(
					array(
						'breakpoint' => 1024,
						'settings'   => array(
							'slidesToShow'   => $items_tablet,
							'slidesToScroll' => 1,
						),
					),
					array(
						'breakpoint' => 767,
						'settings'   => array(
							'slidesToShow'   => $items_mobile,
							'slidesToScroll' => 1,
						),
					),
				),
			)
		);

		echo '<div class="multiple-items" data-slick="' . esc_attr( $slick_settings ) . '">';

		while ( $query->have_posts() ) {
			$query->the_post();
			?>
			<div class="slide-post-item">
				<?php if ( 'yes' === $show_image && has_post_thumbnail() ) : ?>
					<div class="slide-post-thumb" style="background-image: url(<?php echo esc_url( get_the_post_thumbnail_url( null, 'large' ) ); ?>)"></div>
				<?php endif; ?>

				<?php
				if ( 'yes' === $show_tax ) :
					$taxonomies = get_object_taxonomies( get_post_type(), 'objects' );
					foreach ( $taxonomies as $taxonomy ) {
						if ( 'post_format' === $taxonomy->name || ! $taxonomy->public ) {
							continue;
						}
						$terms = get_the_terms( get_the_ID(), $taxonomy->name );
						if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
							echo '<ul class="slide-post-tax slide-post-tax--' . esc_attr( $taxonomy->name ) . '">';
							foreach ( $terms as $term ) {
								echo '<li>' . esc_html( $term->name ) . '</li>';
							}
							echo '</ul>';
						}
					}
				endif;
				?>

				<div class="slide-item-content">
					<?php if ( 'yes' === $show_title ) : ?>
						<h3 class="slide-post-title"><?php the_title(); ?></h3>
					<?php endif; ?>

					<?php if ( 'yes' === $show_excepert ) : ?>
						<div class="slide-post-excerpt">
							<?php echo esc_html( wp_trim_words( get_the_content(), $n_charts, '...' ) ); ?>
						</div>
					<?php endif; ?>

					<?php if ( 'yes' === $show_button ) : ?>
						<div class="slide-post-btn">
							<a class="btn-slide-post" href="<?php the_permalink(); ?>"><?php echo esc_html( $btn_text ); ?></a>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php
		}

		echo '</div>';
		wp_reset_postdata();
	}
}
