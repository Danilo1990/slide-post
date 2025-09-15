<?php

namespace Elementor;

use Elementor\Controls_Manager;
use ElementorPro\Modules\QueryControl\Module as Module_Query;
use ElementorPro\Modules\QueryControl\Controls\Group_Control_Related;
use ElementorPro\Modules\Posts\Skins;
use ElementorPro\Modules\Posts\Traits\Query_Note_Trait;
use ElementorPro\Modules\QueryControl\Module;


class Widget_Slide_Post extends \Elementor\Widget_Base {
	
	public function get_name() {
		return 'slide_post';
	}
	
	public function get_title() {
		return 'Slide Post';
	}
	
	public function get_icon() {
		return 'eicon-post-slider';
	}
	
	public function get_categories(): array {
		return [ 'dc_cat' ];
	}
		
    protected function _register_controls() {

		$this->start_controls_section(
			'section_option',
			[
				'label' => esc_html__( 'Items', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_image',
			[
				'label' => esc_html__( 'Show image', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'textdomain' ),
				'label_off' => esc_html__( 'Hide', 'textdomain' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => esc_html__( 'Show title', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'textdomain' ),
				'label_off' => esc_html__( 'Hide', 'textdomain' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_excepert',
			[
				'label' => esc_html__( 'Show excepert', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'textdomain' ),
				'label_off' => esc_html__( 'Hide', 'textdomain' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'n_charts',
			[
				'label' => esc_html__( 'Number charthers', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 10,
				'max' => 100,
				'step' => 1,
				'default' => 10,
				'condition' => [
					'show_excepert' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_button',
			[
				'label' => esc_html__( 'Show button', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'textdomain' ),
				'label_off' => esc_html__( 'Hide', 'textdomain' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label' => esc_html__( 'Button text', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Read more', 'textdomain' ),
				'placeholder' => esc_html__( 'Type your title here', 'textdomain' ),
				'condition' => [
					'show_button' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'posts',
			[
				'label' => esc_html__('Posts for page', 'your-textdomain'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 10,
				'min' => -1,
				'max' => 100,
			]
		);		


		$this->add_group_control(
			Group_Control_Related::get_type(),
			[
				'name' => 'control_name',
				'presets' => [ 'full' ],
				'exclude' => [
					'posts_per_page',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_option_slide',
			[
				'label' => esc_html__( 'Slide option', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__('Items to show', 'your-textdomain'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 3,
				'min' => 1,
				'max' => 10,
			]
		);

		$this->add_control(
			'items_scrool',
			[
				'label' => esc_html__('Items to scrool', 'your-textdomain'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 3,
				'min' => 1,
				'max' => 10,
			]
		);

		$this->add_control(
			'show_arrow',
			[
				'label' => esc_html__( 'Show arrow', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'textdomain' ),
				'label_off' => esc_html__( 'Hide', 'textdomain' ),
				'return_value' => "true",
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_dots',
			[
				'label' => esc_html__( 'Show dots', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'textdomain' ),
				'label_off' => esc_html__( 'Hide', 'textdomain' ),
				'return_value' => "true",
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'item_style',
			[
				'label' => esc_html__( 'Item', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_options',
			[
				'label' => esc_html__( 'Image', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_height',
			[
				'label' => esc_html__( 'Height image', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 250,
				],
				'selectors' => [
					'{{WRAPPER}} .slide-post-thumb' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'items_options',
			[
				'label' => esc_html__( 'Items', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_shadow',
				'selector' => '{{WRAPPER}} .slide-post-item',
			]
		);

		$this->add_control(
			'border_radius_item',
			[
				'label' => esc_html__( 'Border radius', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .slide-post-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'items_height',
			[
				'label' => esc_html__( 'Items height', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 250,
				],
				'selectors' => [
					'{{WRAPPER}} .slide-post-item' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'text_style',
			[
				'label' => esc_html__( 'Content', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'padding_text',
			[
				'label' => esc_html__( 'Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 10,
					'right' => 10,
					'bottom' => 10,
					'left' => 10,
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .slide-item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_options',
			[
				'label' => esc_html__( 'Title', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .slide-post-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .slide-post-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label' => esc_html__( 'Spacing title', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .slide-post-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'excepert_options',
			[
				'label' => esc_html__( 'Excepert', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'excepert_typography',
				'selector' => '{{WRAPPER}} .slide-post-excerpt',
			]
		);

		$this->add_control(
			'excepert_color',
			[
				'label' => esc_html__( 'Excepert Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .slide-post-excerpt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'excepert_spacing',
			[
				'label' => esc_html__( 'Excepert title', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .slide-post-excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'btn_style',
			[
				'label' => esc_html__( 'Button', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'btn_align',
			[
				'label' => esc_html__( 'Alignment button', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'textdomain' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'textdomain' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'textdomain' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .slide-post-btn' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
				'selector' => '{{WRAPPER}} .btn-slide-post',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT,
				],
			]
		);

		$this->start_controls_tabs(
			'style_tabs_btn'
		);

		$this->start_controls_tab(
			'style_normal_btn',
			[
				'label' => esc_html__( 'Normal', 'textdomain' ),
			]
		);

		$this->add_control(
			'btn_bg_color',
			[
				'label' => esc_html__( 'Background color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn-slide-post' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'btn_text_color',
			[
				'label' => esc_html__( 'Text color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn-slide-post' => 'color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_hover_btn',
			[
				'label' => esc_html__( 'Hover', 'textdomain' ),
			]
		);

		$this->add_control(
			'btn_bg_color_hover',
			[
				'label' => esc_html__( 'Background color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn-slide-post:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'btn_text_color_hover',
			[
				'label' => esc_html__( 'Text color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn-slide-post:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'hr_btn',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border_btn',
				'selector' => '{{WRAPPER}} .btn-slide-post',
			]
		);

		$this->add_control(
			'padding_btn',
			[
				'label' => esc_html__( 'Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .btn-slide-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

    }
	
	protected function render() {
		$settings = $this->get_settings_for_display();
		$show_image = $settings['show_image'];
		$posts = $settings['posts'];
		$show_excepert = $settings['show_excepert'];
		$show_title = $settings['show_title'];
		$show_button = $settings['show_button'];
		$n_charts = $settings['n_charts'];
		$btn_text = $settings['btn_text'];

		$items = !empty($settings['items']) ? intval($settings['items']) : 3;
		$itemsScrool = !empty($settings['items_scrool']) ? intval($settings['items_scrool']) : 1;
		$show_arrow = filter_var($settings['show_arrow'], FILTER_VALIDATE_BOOLEAN);
		$show_dots = filter_var($settings['show_dots'], FILTER_VALIDATE_BOOLEAN);

		// Ottengo gli args
		$query_args = Module::instance()->get_query_args( 'control_name', $settings );

		// Aggiungo i parametri custom
		$query_args['posts_per_page'] = $posts;

		// Query
		$query = new \WP_Query( $query_args );
	
		if ($query->have_posts()) {
			$slick_settings = json_encode([
				'slidesToShow' => $items,
				'slidesToScroll' => $itemsScrool,
				'infinite' => true,
				'dots' => $show_dots,
				'arrows' => $show_arrow,
				'adaptiveHeight' => true,
			]);
			
			echo '<div class="multiple-items" data-slick=\'' . esc_attr($slick_settings) . '\'>';

				while ($query->have_posts()) {
					$query->the_post(); ?>
					<div class="slide-post-item">
						<?php if($show_image == 'yes') { ?>
							<?php if (has_post_thumbnail()) : ?>
								<div class="slide-post-thumb" style="background-image: url(<?php the_post_thumbnail_url('full'); ?>)"></div>
							<?php endif; ?>
						<?php } ?>
						<div class="slide-item-content">
							<?php if($show_title == 'yes') { ?>
								<h3 class="slide-post-title">
									<?php the_title(); ?>
								</h3>	
							<?php } ?>
							<?php if($show_excepert == 'yes') { ?>
								<div class="slide-post-excerpt">
									<?php $content = get_the_content(); 
									echo wp_trim_words( $content, $n_charts, '...' );?>
								</div>
							<?php } ?>
							<?php if($show_button == 'yes') { ?>
								<div class="slide-post-btn">
									<a class="btn-slide-post" href="<?php the_permalink(); ?>"><?= $btn_text ?></a>
								</div>
							<?php } ?>
						</div>
					</div>
					<?php
				}
				echo '</div>';
			wp_reset_postdata();
		} else {
			echo '<p>No posts found.</p>';
		}
	}
	

	protected function _content_template() { }	
}
