<?php
namespace Elementor;

if (!defined('ABSPATH')) exit;

class Metabox_Field_Tag extends \Elementor\Core\DynamicTags\Tag {

	public function get_name() {
		return 'metabox_field_tag';
	}

	public function get_title() {
		return 'Annuncio Metabox';
	}

	public function get_group() {
		return 'post'; 
	}

	public function get_categories() {
		return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
	}

	public function render() {
		$field_key = $this->get_settings('field_key');

		if (!$field_key) return;

		$value = get_post_meta(get_the_ID(), $field_key, true);

		if (is_array($value)) {
			echo esc_html(implode(', ', $value));
		} else {
			echo esc_html($value);
		}
	}

	protected function _register_controls() {
		$this->add_control(
			'field_key',
			[
				'label' => 'Campo metabox',
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '_annuncio_salary',
				'options' => [
					'_annuncio_salary'       => 'Salary',
					'_annuncio_luogo'        => 'Place',
					'_annuncio_postazione'   => 'Postazione',
					'_annuncio_expiry_date'  => 'Expiry Date',
				],
			]
		);
	}
}
