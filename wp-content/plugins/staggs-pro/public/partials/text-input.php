<?php

/**
 * Provide a public-facing view for the User Input step type.
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.1.0
 *
 * @package    Staggs
 * @subpackage Staggs/public/partials
 */

global $sanitized_step;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$classes = '';
if ( isset( $sanitized_step['classes'] ) ) {
	$classes .= ' ' . $sanitized_step['classes'];
}

echo '<div class="option-group-options text-input' . esc_attr( $classes ) . '">';

foreach ( $sanitized_step['options'] as $key => $option ) {
	$option_name = staggs_sanitize_title( $option['name'] );
	$price        = $option['price'];
	$sale         = $option['sale_price'];
	$option_price = '';

	if ( 'no' === $option['base_price'] ) {
		$option_price = $sale !== -1 ? $sale : ( $price !== -1 ? $price : '' );
	}

	$supported_attributes = array(
		'sku'         => 'data-sku',
		'field_key'     => 'data-field-key',
		'material_key'  => 'data-material-key',
		'preview_top'   => 'data-preview-top',
		'preview_left'  => 'data-preview-left',
		'preview_width' => 'data-preview-width',
		'preview_height' => 'data-preview-height',
		'preview_overflow'     => 'data-preview-overflow',
		'preview_top_mobile'   => 'data-preview-top-xs',
		'preview_left_mobile'  => 'data-preview-left-xs',
		'preview_width_mobile' => 'data-preview-width-xs',
		'preview_ref_selector' => 'data-preview-selector',
		'field_min' => 'minlength',
		'field_max' => 'maxlength',
		'field_placeholder' => 'placeholder',
	);

	$required_visual_keys = array('preview_width', 'preview_height');
	$filled_visual_keys = array();

	foreach ( $supported_attributes as $field_key => $data_attribute ) {
		if ( isset( $option[ $field_key ] ) && '' !== $option[ $field_key ] && in_array( $field_key, $required_visual_keys) ) {
			$filled_visual_keys[] = $field_key;
		}
	}

	if ( 'date' === $option['field_type'] ) {
		$supported_attributes['field_min'] = 'data-date-min';
		$supported_attributes['field_max'] = 'data-date-max';
	}

	if ( $required_visual_keys === $filled_visual_keys && ( isset( $option['material_key'] ) || isset( $sanitized_step['model_group'] ) ) ) {
		$material_key = isset( $option['material_key'] ) ? $option['material_key'] : $sanitized_step['model_group'];

		if ( $material_key ) {
			echo '<canvas id="' . esc_attr( $option['id'] ) . '_canvas" class="option-group-canvas" width="' . esc_attr( $option['preview_width'] )
				. '" height="' . esc_attr( $option['preview_height'] ) . '" data-key="' . esc_attr( $material_key ) . '"></canvas>';
		}
	}

	if ( 'textarea' === $option['field_type'] ) {
		$textarea_rows = apply_filters( 'staggs_textarea_rows', 4 );
		?>
	
		<div class="input-field-wrapper">
			<?php if ( ! isset( $sanitized_step['show_input_labels'] ) || 'hide' !== $sanitized_step['show_input_labels'] ) : ?>
				<label for="<?php echo esc_attr( $option['id'] ); ?>">
					<span class="input-heading">
						<p class="input-title">
							<?php 
							echo esc_attr( $option['name'] );

							if ( isset( $option['field_required'] ) && 'yes' === $option['field_required'] ) {
								echo ' <span class="required-indicator">*</span>';
							}
							?>
						</p>
						<?php 
						if ( 'no' === $option['base_price'] && ! ( isset( $sanitized_step['show_option_price'] ) && 'hide' === $sanitized_step['show_option_price'] ) ) {
							if ( isset( $option['price_type'] ) && 'unit' === $option['price_type'] && isset( $option['unit_price'] ) && '' !== $option['unit_price'] ) {
								echo ' <span class="input-price">' . get_option_price_html_safe( $option['unit_price'], '', '' ) . esc_attr__( ' per character', 'staggs' ) . '</span>';
							} else {
								echo '<span class="input-price">' . get_option_price_html_safe( $price, $sale, $sanitized_step['inc_price_label'] ) . '</span>';
							}
						}
						?>
					</span>
				</label>
				<?php
			endif;

			if ( isset( $option['note'] ) && $option['note'] ) {
				echo '<p class="option-note">' . wp_kses_post( $option['note'] ) . '</p>';
			}
			?>
			<textarea 
				id="<?php echo esc_attr( $option['id'] ); ?>"
				name="<?php echo esc_attr( $option_name ); ?>"
				rows="<?php echo esc_attr( $textarea_rows ); ?>"
				data-step-id="<?php echo esc_attr( $sanitized_step['id'] ); ?>"
				data-option-id="<?php echo esc_attr( staggs_sanitize_title( $option['name'] ) ); ?>"
				<?php
				foreach ( $supported_attributes as $field_key => $data_attribute ) {
					if ( isset( $option[ $field_key ] ) && '' !== $option[ $field_key ] ) {
						echo ' ' . esc_attr( $data_attribute ) . '="' . esc_attr( $option[ $field_key ] ) . '"';
					}
				}

				if ( $sanitized_step['preview_index'] && 'yes' === $option['enable_preview'] ) {
					echo ' data-preview-index="' . esc_attr( $sanitized_step['preview_index'] ) . '"';
				}
				if ( isset( $option['field_required'] ) && 'yes' === $option['field_required'] ) {
					echo ' required="required"';
				}
				
				if ( 'no' === $option['base_price'] ) {
					if ( isset( $option['price_type'] ) ) {
						if ( 'unit' === $option['price_type'] && isset( $option['unit_price'] ) && '' !== $option['unit_price'] ) {
							echo ' data-unit-price="' . esc_attr( $option['unit_price'] ) . '"';
						}
						else if ( 'table' === $option['price_type'] && isset( $option['price_table'] ) && '' !== $option['price_table'] ) {
							echo ' data-table-price="' . esc_attr( $option['price_table'] ) . '"';
						}
					}
					else {
						echo ' data-price="' . esc_attr( $option_price ) . '"';
						echo ' data-alt-price="' . esc_attr( $option_price ) . '"';
					}
				}
				?>><?php 
				if ( isset( $option['field_value'] ) ) {
					echo esc_attr( $option['field_value'] );
				}
				?></textarea>
			<?php
			if ( isset( $sanitized_step[ 'field_info' ] ) && 'yes' === $sanitized_step[ 'field_info' ] ) {
				if ( isset( $option[ 'field_min' ] ) && '' !== $option[ 'field_min' ] && isset( $option[ 'field_max' ] ) && '' !== $option[ 'field_max' ] ) {
					echo '<small>' . esc_attr__( 'Min: ', 'staggs' ) . esc_attr( $option[ 'field_min' ] ) . esc_attr__( ' and max: ', 'staggs' ) . esc_attr( $option[ 'field_max' ] ) . ' ' . esc_attr__( 'characters', 'staggs' ) . '</small>';
				} else if ( isset( $option[ 'field_min' ] ) && '' !== $option[ 'field_min' ] ) {
					echo '<small>' . esc_attr__( 'Min: ', 'staggs' ) . esc_attr( $option[ 'field_min' ] ) . ' ' . esc_attr__( 'characters', 'staggs' ) . '</small>';
				} else if ( isset( $option[ 'field_max' ] ) && '' !== $option[ 'field_max' ] ) {
					echo '<small>' . esc_attr__( 'Max: ', 'staggs' ) . esc_attr( $option[ 'field_max' ] ) . ' ' . esc_attr__( 'characters', 'staggs' ) . '</small>';
				}
			}
			?>
		</div>
		<?php
	} else if ( 'text' === $option['field_type'] ) {
		?>
		<div class="input-field-wrapper">
			<?php if ( ! isset( $sanitized_step['show_input_labels'] ) || 'hide' !== $sanitized_step['show_input_labels'] ) : ?>
				<label for="<?php echo esc_attr( $option['id'] ); ?>" class="input-heading">
					<p class="input-title">
						<?php 
						echo esc_attr( $option['name'] );
						if ( isset( $option['field_required'] ) && 'yes' === $option['field_required'] ) {
							echo ' <span class="required-indicator">*</span>';
						}
						?>
					</p>
					<?php
					if ( 'no' === $option['base_price'] && ! ( isset( $sanitized_step['show_option_price'] ) && 'hide' === $sanitized_step['show_option_price'] ) ) {
						if ( isset( $option['price_type'] ) && 'unit' === $option['price_type'] && isset( $option['unit_price'] ) && '' !== $option['unit_price'] ) {
							echo ' <span class="input-price">' . get_option_price_html_safe( $option['unit_price'], '', '' ) . esc_attr__( ' per character', 'staggs' ) . '</span>';
						} else {
							echo '<span class="input-price">' . get_option_price_html_safe( $price, $sale, $sanitized_step['inc_price_label'] ) . '</span>';
						}
					}
					?>
				</label>
				<?php
			endif;

			if ( isset( $option['note'] ) && $option['note'] ) {
				echo '<p class="option-note">' . wp_kses_post( $option['note'] ) . '</p>';
			}
			?>
			<input id="<?php echo esc_attr( $option['id'] ); ?>"
				type="text"
				name="<?php echo esc_attr( $option_name ); ?>"
				value="<?php echo isset( $option['field_value'] ) ? esc_attr( $option['field_value'] ) : ''; ?>"
				data-step-id="<?php echo esc_attr( $sanitized_step['id'] ); ?>"
				data-option-id="<?php echo esc_attr( staggs_sanitize_title( $option['name'] ) ); ?>"
				<?php
				foreach ( $supported_attributes as $field_key => $data_attribute ) {
					if ( isset( $option[ $field_key ] ) && '' !== $option[ $field_key ] ) {
						echo ' ' . esc_attr( $data_attribute ) . '="' . esc_attr( $option[ $field_key ] ) . '"';
					}
				}

				if ( $sanitized_step['preview_index'] && 'yes' === $option['enable_preview'] ) {
					echo ' data-preview-index="' . esc_attr( $sanitized_step['preview_index'] ) . '"';
				}
				if ( isset( $option['field_required'] ) && 'yes' === $option['field_required'] ) {
					echo ' required="required"';
				}
				
				if ( 'no' === $option['base_price'] ) {
					if ( isset( $option['price_type'] ) ) {
						if ( 'unit' === $option['price_type'] && isset( $option['unit_price'] ) && '' !== $option['unit_price'] ) {
							echo ' data-unit-price="' . esc_attr( $option['unit_price'] ) . '"';
						}
						else if ( 'table' === $option['price_type'] && isset( $option['price_table'] ) && '' !== $option['price_table'] ) {
							echo ' data-table-price="' . esc_attr( $option['price_table'] ) . '"';
						}
						else {
							echo ' data-price="' . esc_attr( $option_price ) . '"';
							echo ' data-alt-price="' . esc_attr( $option_price ) . '"';
						}
					}
					else {
						echo ' data-price="' . esc_attr( $option_price ) . '"';
						echo ' data-alt-price="' . esc_attr( $option_price ) . '"';
					}
				}
				?>>
			<?php
			if ( isset( $sanitized_step[ 'field_info' ] ) && 'yes' === $sanitized_step[ 'field_info' ] ) {
				if ( isset( $option[ 'field_min' ] ) && '' !== $option[ 'field_min' ] && isset( $option[ 'field_max' ] ) && '' !== $option[ 'field_max' ] ) {
					echo '<small>' . esc_attr__( 'Min: ', 'staggs' ) . esc_attr( $option[ 'field_min' ] ) . esc_attr__( ' and max: ', 'staggs' ) . esc_attr( $option[ 'field_max' ] ) . ' ' . esc_attr__( 'characters', 'staggs' ) . '</small>';
				} else if ( isset( $option[ 'field_min' ] ) && '' !== $option[ 'field_min' ] ) {
					echo '<small>' . esc_attr__( 'Min: ', 'staggs' ) . esc_attr( $option[ 'field_min' ] ) . ' ' . esc_attr__( 'characters', 'staggs' ) . '</small>';
				} else if ( isset( $option[ 'field_max' ] ) && '' !== $option[ 'field_max' ] ) {
					echo '<small>' . esc_attr__( 'Max: ', 'staggs' ) . esc_attr( $option[ 'field_max' ] ) . ' ' . esc_attr__( 'characters', 'staggs' ) . '</small>';
				}
			}
			?>
		</div>
		<?php

	} else if ( 'date' === $option['field_type'] ) {

		$format = 'mm/dd/yy';
		if ( isset( $option['datepicker_format'] ) && '' !== $option['datepicker_format'] ) {
			$format = $option['datepicker_format'];
		}
		?>
		<div class="input-field-wrapper">
			<?php if ( ! isset( $sanitized_step['show_input_labels'] ) || 'hide' !== $sanitized_step['show_input_labels'] ) : ?>
				<label class="input-heading">
					<p class="input-title">
						<?php
						echo esc_attr( $option['name'] );
						if ( isset( $option['field_required'] ) && 'yes' === $option['field_required'] ) {
							echo ' <span class="required-indicator">*</span>';
						}
						?>
					</p>
					<?php
					if ( 'no' === $option['base_price'] && ! ( isset( $sanitized_step['show_option_price'] ) && 'hide' === $sanitized_step['show_option_price'] ) ) {
						if ( isset( $option['price_type'] ) && 'unit' === $option['price_type'] && isset( $option['unit_price'] ) && '' !== $option['unit_price'] ) {
							echo ' <span class="input-price">' . get_option_price_html_safe( $option['unit_price'], '', '' ) . esc_attr__( ' per character', 'staggs' ) . '</span>';
						} else {
							echo '<span class="input-price">' . get_option_price_html_safe( $price, $sale, $sanitized_step['inc_price_label'] ) . '</span>';
						}
					}
					?>
				</label>
				<?php
			endif;

			if ( isset( $option['note'] ) && $option['note'] ) {
				echo '<p class="option-note">' . wp_kses_post( $option['note'] ) . '</p>';
			}
			?>
			<span class="input-field input-field-datepicker">
				<input type="text" 
					data-type="date" 
					name="<?php echo esc_attr( $option_name ); ?>"
					class="datepicker-input"
					data-step-id="<?php echo esc_attr( $sanitized_step['id'] ); ?>"
					data-option-id="<?php echo esc_attr( staggs_sanitize_title( $option['name'] ) ); ?>"
					data-date-format="<?php echo esc_attr( $format ); ?>"
					<?php
					foreach ( $supported_attributes as $field_key => $data_attribute ) {
						if ( isset( $option[ $field_key ] ) && '' !== $option[ $field_key ] ) {
							echo ' ' . esc_attr( $data_attribute ) . '="' . esc_attr( $option[ $field_key ] ) . '"';
						}
					}
	
					if ( isset( $option['datepicker_show_inline'] ) && ( 'true' == $option['datepicker_show_inline'] || 'yes' == $option['datepicker_show_inline'] ) ) {
						echo ' data-inline="' . esc_attr( $option['id'] ) . '-inline"';
					}
					if ( $sanitized_step['preview_index'] && 'yes' === $option['enable_preview'] ) {
						echo ' data-preview-index="' . esc_attr( $sanitized_step['preview_index'] ) . '"';
					}
					if ( isset( $option['field_required'] ) && 'yes' === $option['field_required'] ) {
						echo ' required="required"';
					}
					
					if ( 'no' === $option['base_price'] ) {
						if ( isset( $option['price_type'] ) ) {
							if ( 'unit' === $option['price_type'] && isset( $option['unit_price'] ) && '' !== $option['unit_price'] ) {
								echo ' data-unit-price="' . esc_attr( $option['unit_price'] ) . '"';
							}
							else if ( 'table' === $option['price_type'] && isset( $option['price_table'] ) && '' !== $option['price_table'] ) {
								echo ' data-table-price="' . esc_attr( $option['price_table'] ) . '"';
							}
						}
						else {
							echo ' data-price="' . esc_attr( $option_price ) . '"';
							echo ' data-alt-price="' . esc_attr( $option_price ) . '"';
						}
					}
					?>>
				<?php
				$inline_div = false;
				if ( isset( $option['datepicker_show_inline'] ) && ( 'true' == $option['datepicker_show_inline'] || 'yes' == $option['datepicker_show_inline'] ) ) {
					$inline_div = true;
					echo '<div class="datepicker-input-inline"></div>';
				}
				
				if ( ! $inline_div && ( 'true' == $option['datepicker_show_icon'] || 'yes' == $option['datepicker_show_icon'] ) ) {
					echo wp_kses( staggs_get_icon( 'sgg_calendar_icon', 'calendar' ), staggs_get_icon_kses_args() );
				}
				?>
			</span>
		</div>
		<?php
	} else if ( 'color' === $option['field_type'] ) {
		?>
		<div class="input-field-wrapper">
			<?php if ( ! isset( $sanitized_step['show_input_labels'] ) || 'hide' !== $sanitized_step['show_input_labels'] ) : ?>
				<label class="input-heading">
					<p class="input-title">
						<?php
						echo esc_attr( $option['name'] );
						if ( isset( $option['field_required'] ) && 'yes' === $option['field_required'] ) {
							echo ' <span class="required-indicator">*</span>';
						}
						?>
					</p>
					<?php
					if ( 'no' === $option['base_price'] && ! ( isset( $sanitized_step['show_option_price'] ) && 'hide' === $sanitized_step['show_option_price'] ) ) {
						if ( isset( $option['price_type'] ) && 'unit' === $option['price_type'] && isset( $option['unit_price'] ) && '' !== $option['unit_price'] ) {
							echo ' <span class="input-price">' . get_option_price_html_safe( $option['unit_price'], '', '' ) . esc_attr__( ' per character', 'staggs' ) . '</span>';
						} else {
							echo '<span class="input-price">' . get_option_price_html_safe( $price, $sale, $sanitized_step['inc_price_label'] ) . '</span>';
						}
					}
					?>
				</label>
				<?php
			endif;

			if ( isset( $option['note'] ) && $option['note'] ) {
				echo '<p class="option-note">' . wp_kses_post( $option['note'] ) . '</p>';
			}
			?>
			<span class="input-field input-field-colorpicker">
				<input type="text" 
					data-type="color" 
					data-coloris
					name="<?php echo esc_attr( $option_name ); ?>"
					class="colorpicker-input"
					data-step-id="<?php echo esc_attr( $sanitized_step['id'] ); ?>"
					data-option-id="<?php echo esc_attr( staggs_sanitize_title( $option['name'] ) ); ?>"
					<?php
					foreach ( $supported_attributes as $field_key => $data_attribute ) {
						if ( isset( $option[ $field_key ] ) && '' !== $option[ $field_key ] ) {
							echo ' ' . esc_attr( $data_attribute ) . '="' . esc_attr( $option[ $field_key ] ) . '"';
						}
					}
					
					if ( isset( $option['field_value'] ) && '' !== $option['field_value'] ) {
						echo ' value="' . esc_attr( $option['field_value'] ) . '"';
					}
					if ( $sanitized_step['preview_index'] && 'yes' === $option['enable_preview'] ) {
						echo ' data-preview-index="' . esc_attr( $sanitized_step['preview_index'] ) . '"';
					}
					if ( isset( $option['field_required'] ) && 'yes' === $option['field_required'] ) {
						echo ' required="required"';
					}
					
					if ( 'no' === $option['base_price'] ) {
						echo ' data-price="' . esc_attr( $option_price ) . '"';
						echo ' data-alt-price="' . esc_attr( $option_price ) . '"';
					}
					?>>
			</span>
		</div>
		<?php
	}
}

echo '</div>';
