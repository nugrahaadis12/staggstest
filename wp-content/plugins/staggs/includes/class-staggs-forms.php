<?php

/**
 * The configurator form functions for the plugin.
 *
 * @link       https://staggs.app
 * @since      1.4.0
 *
 * @package    Staggs/
 * @subpackage Staggs/includes
 */

if ( ! defined('ABSPATH') ) {
	die();
}

/**
 * The plugin form functions
 *
 * @package    Staggs/
 * @subpackage Staggs/includes
 */
class Staggs_Forms {

	/**
	 * Add support for Contact Form 7 values.
	 *
	 * @since    1.3.7.
	 */
	public function wpcf7_fill_form_values( $scanned_tag, $replace ) {
		if ( isset( $_GET ) ) {
			$label = $this->get_form_field_label();

			foreach ( $_GET as $key => $value ) {
				if ( strtolower( $key ) === strtolower( $scanned_tag['raw_name'] ) ) {
					// $field['default_value'] = 
					$scanned_tag['values'][] = $value;
				}
			}

			if ( strtolower( $scanned_tag['raw_name'] ) === $label ) {
				$scanned_tag['values'][] = $this->format_configuration_value();
			}
		}
		
		return $scanned_tag;
	}

	/**
	 * Add support for Ninja Forms values.
	 *
	 * @since    1.3.7.
	 */
	public function na_fill_form_values( $default_value, $field_type, $field_settings ) {
		if ( isset( $_GET ) ) {
			$label = $this->get_form_field_label();
	
			foreach ( $_GET as $key => $value ) {
				if ( strtolower( $key ) === strtolower( $field_settings['label'] ) ) {
					$default_value = $value;
				}
			}

			if ( strtolower( $field_settings['label'] ) === $label ) {
				$default_value = $this->format_configuration_value();
			}
		}

		return $default_value;
	}

	/**
	 * Run smart tags on all field labels.
	 *
	 * @link   https://wpforms.com/developers/wpforms_textarea_field_display/
	 *
	 * @param  array $field        Sanitized field data.
	 * @param  array $form_data    Form data and settings.
	 *
	 * return  array
	 */
	public function wpf_fill_form_values( $field, $form_data ) {
		if ( isset( $_GET ) ) {
			$label = $this->get_form_field_label();
	
			foreach ( $_GET as $key => $value ) {
				if ( strtolower( $key ) === strtolower( $field['label'] ) ) {
					$field['default_value'] = $value;
				}
			}

			if ( strtolower( $field['label'] ) === $label ) {
				$field['default_value'] = $this->format_configuration_value();
			}
		}
		
		return $field;
	}

	/**
	 * Helper function for GravityForms formatting configuration for field.
	 * 
	 * @since 2.5.1
	 */
	function gf_add_configuration_form_value( $value, $field, $name ) {
		$label = $this->get_form_field_label();

		if ( strtolower( $name ) !== $label ) {
			return $value;
		}

		return $this->format_configuration_value();
	}

	/**
	 * Helper function for Fluent Forms formatting configuration for field.
	 * 
	 * @since 2.5.1
	 */
	public function ff_add_configuration_form_value( $field, $form ) {
		$label = $this->get_form_field_label();

		if ( \FluentForm\Framework\Helpers\ArrayHelper::get($data, 'attributes.name') != $label ) {
			return $field;
		}

		$field['attributes']['value'] = $this->format_configuration_value();

		return $field;
	}

	/**
	 * Helper function for formatting configuration for textarea field.
	 * 
	 * @since 1.10.0
	 */
	private function format_configuration_value() {
		$options_text = '';

		if ( isset( $_GET['product_name'] ) ) {
			$options_text .= 'Product: ' . esc_attr( $_GET['product_name'] ) . "\r\n";
		}
		
		$url_values = array();
		$hidden_keys = array( 'id', 'product_name', 'product_pdf', 'product_price', 'product_alt_price', 'base_price' );
		foreach ( $_GET as $name => $value ) {
			$url_values[ ucfirst( str_replace( '-', ' ', $name ) ) ] = esc_attr( $value );

			if ( in_array( strtolower( $name ), $hidden_keys ) ) {
				continue;
			}

			$options_text .= ucfirst( str_replace( '-', ' ', $name ) ) . ': ' . esc_attr( $value ) . "\r\n";
		}

		if ( isset( $_GET['product_price'] ) ) {
			$options_text .= 'Total price: ' . esc_attr( $_GET['product_price'] ) . "\r\n";
		}

		$options_text = apply_filters( 'staggs_get_configuration_form_field_value', $options_text, $url_values );

		return $options_text;
	}

	/**
	 * Helper function for getting defined configuration label.
	 * 
	 * @since 2.8.0
	 */
	private function get_form_field_label() {
		$label = 'configuration';

		if ( isset( $_GET['id'] ) && '' !== $_GET['id'] ) {
			$post_id = esc_attr( $_GET['id'] );
			$theme_id = staggs_get_theme_id( $post_id );

			if ( $field_label = staggs_get_post_meta( $theme_id, 'sgg_configurator_form_configuration_label' ) ) {
				if ( strlen( $field_label ) > 1 ) {
					$label = $field_label;
				}
			}
		}

		$label = apply_filters( 'staggs_configuration_form_label', $label );

		return $label;
	}
}
