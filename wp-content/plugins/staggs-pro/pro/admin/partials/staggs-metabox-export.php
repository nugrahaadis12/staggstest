<?php

/**
 * Provide a admin-facing view for the admin attribute export form of the plugin
 *
 * This file is used to markup the admin-facing attribute export form of the plugin admin side.
 *
 * @link       https://staggs.app
 * @since      1.5.0
 *
 * @package    Staggs
 * @subpackage Staggs/admin/partials
 */

// Generate a custom nonce value.
$sgg_export_attributes_form_nonce = wp_create_nonce( 'sgg_export_attributes_form_nonce' );

// Get available attributes list.
$attributes = get_configurator_attribute_values();
?>
<div id="sgg-admin-tool-export-attributes" class="postbox">
	<div class="postbox-header">
		<h2><?php esc_attr_e( 'Export', 'staggs' ); ?></h2>
	</div>
	<div class="inside">
		<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" id="sgg_export_attributes_form" enctype="multipart/form-data">
			<?php 
			if ( is_array( $attributes ) && count( $attributes ) > 0 ) : 
				?>
				<div class="sgg-field-title">
					<strong><?php esc_attr_e( 'Attribute', 'staggs' ); ?></strong><br>
					<p style="margin-top: 10px;"><?php esc_attr_e( 'Select an attribute if you want to export data from a specific attribute. Leave empty to export all.', 'staggs' ); ?></p>
					<div style="margin-bottom: 30px">
						<select id="attribute" name="attribute">
							<option value="">- Select attribute -</option>
							<?php 
							foreach ( $attributes as $attr_id => $attr_label ) : 
								?>
								<option value="<?php echo esc_attr( $attr_id ); ?>"><?php echo esc_attr( $attr_label ); ?></option>
								<?php
							endforeach;
							?>
						</select>
					</div>
				</div>
				<?php 
			endif;
			?>
			<div class="sgg-field-wrapper">
				<div class="sgg-field-title">
					<strong><?php esc_attr_e( 'Modify exported values', 'staggs' ); ?></strong>
				</div>
				<div class="sgg-field-option">
					<label for="export_group_details" style="display: block;margin-top: 8px;">
						<input type="checkbox" id="export_group_details" name="export_group[]" value="details" checked>
						<?php esc_attr_e( 'Attribute details', 'staggs' ); ?>
					</label>
					<label for="export_group_presentation" style="display: block;margin-top: 8px;">
						<input type="checkbox" id="export_group_presentation" name="export_group[]" value="presentation" checked>
						<?php esc_attr_e( 'Attribute presentation', 'staggs' ); ?>
					</label>
					<label for="export_group_calculation" style="display: block;margin-top: 8px;">
						<input type="checkbox" id="export_group_calculation" name="export_group[]" value="calculation" checked>
						<?php esc_attr_e( 'Attribute calculation', 'staggs' ); ?>
					</label>
					<label for="export_group_gallery" style="display: block;margin-top: 8px;">
						<input type="checkbox" id="export_group_gallery" name="export_group[]" value="gallery" checked>
						<?php esc_attr_e( 'Attribute gallery', 'staggs' ); ?>
					</label>
					<label for="export_group_items" style="display: block;margin-top: 8px;">
						<input type="checkbox" id="export_group_items" name="export_group[]" value="items" checked>
						<?php esc_attr_e( 'Attribute items', 'staggs' ); ?>
					</label>
				</div>
			</div>
			<div class="sgg-field-wrapper">
				<div class="sgg-field-title">
					<strong><?php esc_attr_e( 'Choose CSV separator', 'staggs' ); ?></strong>
				</div>
				<div class="sgg-field-input">
					<label for="separator">
						<select name="separator">
							<option value=",">Comma</option>
							<option value=";">Semicolon</option>
							<option value="other">Other</option>
						</select>
						<input type="text" name="other-separator" value="," disabled>
					</label>
				</div>
			</div>
			<div class="sgg-postbox-inner">
				<input type="hidden" name="sgg_export_attribute_nonce" value="<?php echo esc_attr( $sgg_export_attributes_form_nonce ); ?>">
				<div class="sgg-submit">
					<button type="submit" name="action" class="button-primary" value="sgg_handle_attribute_export"><?php esc_attr_e( 'Export attributes', 'staggs' ); ?></button>
				</div>
			</div>
		</form>
	</div>
</div>
