<?php

/**
 * Provide a public-facing view for the option group post type.
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.1.0
 *
 * @package    Staggs
 * @subpackage Staggs/public/templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $sanitized_step, $density, $text_align, $is_horizontal_popup;

$style   = isset( $sanitized_step['style'] ) ? $sanitized_step['style'] : 'inherit';
$hidden  = isset( $sanitized_step['hidden'] ) ? $sanitized_step['hidden'] : false;
$classes = isset( $sanitized_step['classes'] ) ? $sanitized_step['classes'] : '';

if ( $density ) {
	$classes .= ' option-group-' . $density;
}
if ( $text_align ) {
	$classes .= ' option-group-' . $text_align;
}
if ( $style ) {
	$classes .= ' border-' . $style;
}
if ( $hidden ) {
	$classes .= ' always-hidden';
}
if ( isset( $sanitized_step['required'] ) && 'yes' == $sanitized_step['required'] ) {
	$classes .= ' option-group-required';
}

if ( ! $is_horizontal_popup && isset( $sanitized_step['collapsible'] ) ) {
	if ( $sanitized_step['collapsible'] ) {
		$classes .= ' collapsible';
	}

	if ( $sanitized_step['collapsible_state'] ) {
		$classes .= ' ' . $sanitized_step['collapsible_state'];
	}
}

if ( sgg_fs()->is_plan_or_trial( 'professional' ) ) {
	if ( $sanitized_step['is_conditional'] ) {
		$classes .= ' conditional';
	}
}
?>
<div 
	id="option-group-<?php echo esc_attr( $sanitized_step['id'] ); ?>" 
	class="option-group sgg-init <?php echo esc_attr( $classes ); ?>"
	data-step="<?php echo esc_attr( $sanitized_step['id'] ); ?>"
	data-step-name="<?php echo esc_attr( staggs_sanitize_title( $sanitized_step['title'] ) ); ?>"
	data-step-title="<?php echo esc_attr( $sanitized_step['title'] ); ?>"
	<?php
	if ( $sanitized_step['preview_order'] && '' !== $sanitized_step['preview_order'] ) {
		echo ' data-preview-order="' . esc_attr( $sanitized_step['preview_order'] ) . '"';
	}

	if ( isset( $sanitized_step['sku'] ) && '' !== $sanitized_step['sku'] ) {
		echo ' data-step-sku="' . esc_attr( $sanitized_step['sku'] ) . '"';
	}
	if ( isset( $sanitized_step['preview_ref'] ) && '' !== $sanitized_step['preview_ref']) {
		echo ' data-preview-ref="' . esc_attr( $sanitized_step['preview_ref'] ) . '"';
	}
	if ( isset( $sanitized_step['preview_ref_props'] ) && '' !== $sanitized_step['preview_ref_props'] ) {
		echo ' data-preview-ref-props="' . esc_attr( $sanitized_step['preview_ref_props'] ) . '"';
	}
	if ( isset( $sanitized_step['preview_slide'] ) && '' !== $sanitized_step['preview_slide'] ) {
		echo ' data-slide-preview="' . esc_attr( $sanitized_step['preview_slide'] ) . '"';
	}
	if ( isset( $sanitized_step['preview_bundle'] ) && 'yes' === $sanitized_step['preview_bundle'] ) {
		echo ' data-bundle-preview="yes"';

		if ( '' !== $sanitized_step['preview_height'] ) {
			echo ' data-bundle-height="' . esc_attr( $sanitized_step['preview_height'] ) . '"';
		}
	}

	if ( sgg_fs()->is_plan_or_trial( 'professional' ) ) {
		if ( isset( $sanitized_step['model_group'] ) && '' !== $sanitized_step['model_group'] ) {
			echo ' data-model="' . esc_attr( $sanitized_step['model_group'] ) . '"';
		}
		if ( isset( $sanitized_step['model_metalness'] ) && '' !== $sanitized_step['model_metalness'] ) {
			echo ' data-metalness="' . esc_attr( $sanitized_step['model_metalness'] ) . '"';
		}
		if ( isset( $sanitized_step['model_roughness'] ) && '' !== $sanitized_step['model_roughness'] ) {
			echo ' data-roughness="' . esc_attr( $sanitized_step['model_roughness'] ) . '"';
		}
		if ( isset( $sanitized_step['model_type'] ) && '' !== $sanitized_step['model_type'] ) {
			echo ' data-model-type="' . esc_attr( $sanitized_step['model_type'] ) . '"';
		}
		if ( isset( $sanitized_step['model_material'] ) && '' !== $sanitized_step['model_material'] ) {
			echo ' data-model-material="' . esc_attr( $sanitized_step['model_material'] ) . '"';
		}
		if ( isset( $sanitized_step['model_target'] ) && '' !== $sanitized_step['model_target'] ) {
			echo ' data-model-target="' . esc_attr( $sanitized_step['model_target'] ) . '"';
		}
		if ( isset( $sanitized_step['model_orbit'] ) && '' !== $sanitized_step['model_orbit'] ) {
			echo ' data-model-orbit="' . esc_attr( $sanitized_step['model_orbit'] ) . '"';
		}
		if ( isset( $sanitized_step['model_view'] ) && '' !== $sanitized_step['model_view'] ) {
			echo ' data-model-view="' . esc_attr( $sanitized_step['model_view'] ) . '"';
		}
		if ( isset( $sanitized_step['required'] ) && 'yes' == $sanitized_step['required'] ) {
			echo ' required="required"';
		}
		if ( isset( $sanitized_step['shared_min'] ) && '' != $sanitized_step['shared_min'] ) {
			echo ' data-shared-min="' . esc_attr( $sanitized_step['shared_min'] ) . '"';
		}
		if ( isset( $sanitized_step['shared_max'] ) && '' != $sanitized_step['shared_max'] ) {
			echo ' data-shared-max="' . esc_attr( $sanitized_step['shared_max'] ) . '"';
		}
		if ( isset( $sanitized_step['option_min'] ) && '' != $sanitized_step['option_min'] ) {
			echo ' data-option-min="' . esc_attr( $sanitized_step['option_min'] ) . '"';
		}
		if ( isset( $sanitized_step['option_max'] ) && '' != $sanitized_step['option_max'] ) {
			echo ' data-option-max="' . esc_attr( $sanitized_step['option_max'] ) . '"';
		}

		// 3D extensions
		if ( isset( $sanitized_step['model_ior'] ) && '' !== $sanitized_step['model_ior'] ) {
			echo ' data-model-ior="' . esc_attr( $sanitized_step['model_ior'] ) . '"';
		}
		if ( isset( $sanitized_step['model_clearcoat'] ) && '' !== $sanitized_step['model_clearcoat'] ) {
			echo ' data-model-clearcoat="' . esc_attr( $sanitized_step['model_clearcoat'] ) . '"';
		}
		if ( isset( $sanitized_step['model_transmission'] ) && '' !== $sanitized_step['model_transmission'] ) {
			echo ' data-model-transmission="' . esc_attr( $sanitized_step['model_transmission'] ) . '"';
		}
		if ( isset( $sanitized_step['model_thickness'] ) && '' !== $sanitized_step['model_thickness'] ) {
			echo ' data-model-thickness="' . esc_attr( $sanitized_step['model_thickness'] ) . '"';
		}
		if ( isset( $sanitized_step['model_attenuation_dist'] ) && '' !== $sanitized_step['model_attenuation_dist'] ) {
			echo ' data-model-attn-distance="' . esc_attr( $sanitized_step['model_attenuation_dist'] ) . '"';
		}
		if ( isset( $sanitized_step['model_attenuation_color'] ) && '' !== $sanitized_step['model_attenuation_color'] ) {
			echo ' data-model-attn-color="' . esc_attr( $sanitized_step['model_attenuation_color'] ) . '"';
		}
		if ( isset( $sanitized_step['model_specular'] ) && '' !== $sanitized_step['model_specular'] ) {
			echo ' data-model-specular="' . esc_attr( $sanitized_step['model_specular'] ) . '"';
		}
		if ( isset( $sanitized_step['model_specular_color'] ) && '' !== $sanitized_step['model_specular_color'] ) {
			echo ' data-model-specular-color="' . esc_attr( $sanitized_step['model_specular_color'] ) . '"';
		}
		if ( isset( $sanitized_step['model_sheen'] ) && '' !== $sanitized_step['model_sheen'] ) {
			echo ' data-model-sheen="' . esc_attr( $sanitized_step['model_sheen'] ) . '"';
		}
		if ( isset( $sanitized_step['model_sheen_color'] ) && '' !== $sanitized_step['model_sheen_color'] ) {
			echo ' data-model-sheen-color="' . esc_attr( $sanitized_step['model_sheen_color'] ) . '"';
		}
	}
	?>>

	<?php
	/**
	 * Hook: staggs_before_single_option_group.
	 *
	 * @hooked -
	 */
	do_action( 'staggs_before_single_option_group' );
	?>

	<div class="option-group-content">

		<?php
			/**
			 * Hook: staggs_single_option_group.
			 *
			 * @hooked staggs_output_option_group_header - 10
			 * @hooked staggs_output_option_group_content - 20
			 * @hooked staggs_output_option_group_summary - 30
			 */
			do_action( 'staggs_single_option_group' );
		?>

	</div>

	<?php
		/**
		 * Hook: staggs_after_single_option_group.
		 *
		 * @hooked staggs_option_group_description_panel - 10
		 */
		do_action( 'staggs_after_single_option_group' );
	?>

</div>
