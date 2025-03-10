<?php

/**
 * Provide a public-facing view for the Tabs step type.
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.1.0
 *
 * @package    Staggs
 * @subpackage Staggs/public/templates/shared
 */

global $sanitized_step;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( is_array( $sanitized_step['tabs'] ) ) :
	?>
	<div class="option-group-options tabs">
		<ul class="tab-list">
			<?php
			foreach ( $sanitized_step['tabs'] as $tab ) {
				?>
				<li>
					<a href="" data-tabs="<?php echo esc_attr( implode( ',', $tab['sgg_step_tab_attribute'] ) ); ?>"
						<?php echo ( isset( $tab['sgg_step_tab_preview_slide'] ) ) ? 'data-slide-preview="' . esc_attr( $tab['sgg_step_tab_preview_slide'] ) . '"' : ''; ?>>
						<?php echo esc_attr( $tab['sgg_step_tab_title'] ); ?>
					</a>
				</li>
				<?php
			}
			?>
		</ul>
	</div>
	<?php
endif;
