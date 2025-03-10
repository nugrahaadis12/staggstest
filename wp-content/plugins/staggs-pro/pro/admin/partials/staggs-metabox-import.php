<?php

/**
 * Provide a admin-facing view for the admin attribute import form of the plugin
 *
 * This file is used to markup the admin-facing attribute import form of the plugin admin side.
 *
 * @link       https://staggs.app
 * @since      1.5.0
 *
 * @package    Staggs
 * @subpackage Staggs/admin/partials
 */

// Generate a custom nonce value.
$sgg_import_attributes_form_nonce = wp_create_nonce( 'sgg_import_attributes_form_nonce' );
?>
<div id="sgg-admin-tool-import-attributes" class="postbox">
	<div class="postbox-header">
		<h2><?php esc_attr_e( 'Import', 'staggs' ); ?></h2>
	</div>
	<div class="inside">
		<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" id="sgg_import_attributes_form" enctype="multipart/form-data">
			<div class="sgg-postbox-inner">
				<div class="sgg-fields">
					<div class="sgg-field-wrapper">
						<div class="sgg-field-title">
							<strong><?php esc_attr_e( 'Choose Import File', 'staggs' ); ?></strong>
						</div>
						<div class="sgg-field-input">
							<label for="importfile">
								<input type="file" id="importfile" name="importfile" value="" accept=".csv">
							</label>
						</div>
						<small><?php esc_attr_e( 'File must be of type .csv', 'staggs' ); ?></small>
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
					<div class="sgg-field-wrapper">
						<div class="sgg-field-title">
							<strong><?php esc_attr_e( 'Find existing values by', 'staggs' ); ?></strong>
						</div>
						<div class="sgg-field-option">
							<label for="update_id">
								<input type="radio" id="update_id" name="update_values" value="id" checked>
								<?php esc_attr_e( 'Attribute ID', 'staggs' ); ?>
							</label>
							<label for="update_sku" style="margin-left: 12px;">
								<input type="radio" id="update_sku" name="update_values" value="sku">
								<?php esc_attr_e( 'Attribute SKU', 'staggs' ); ?>
							</label>
						</div>
					</div>
					<div class="sgg-field-wrapper">
						<div class="sgg-field-title">
							<strong><?php esc_attr_e( 'If attribute exists', 'staggs' ); ?></strong>
						</div>
						<div class="sgg-field-option">
							<label for="exising_update">
								<input type="radio" id="exising_update" name="existing_values" value="update" checked>
								<?php esc_attr_e( 'Update', 'staggs' ); ?>
							</label>
							<label for="exising_skip" style="margin-left: 12px;">
								<input type="radio" id="exising_skip" name="existing_values" value="skip">
								<?php esc_attr_e( 'Skip', 'staggs' ); ?>
							</label>
						</div>
					</div>
					<div class="sgg-field-wrapper">
						<div class="sgg-field-title">
							<strong><?php esc_attr_e( 'Important!', 'staggs' ); ?></strong>
						</div>
						<div class="sgg-field-option">
							<label for="backup_attr_notice">
								<input type="checkbox" id="backup_attr_notice" name="backup_attr_notice" value="backup_attr_notice" required>
								<?php esc_attr_e( 'I understand that this will modify my database and have taken a full backup in case I need to roll back.', 'staggs' ); ?>
							</label>
						</div>
					</div>
				</div>
				<input type="hidden" name="sgg_import_attribute_nonce" value="<?php echo esc_attr( $sgg_import_attributes_form_nonce ); ?>">
				<div class="sgg-submit">
					<button type="submit" name="action" class="button-primary" value="sgg_handle_attribute_import"><?php esc_attr_e( 'Import attributes', 'staggs' ); ?></button>
				</div>
			</div>
		</form>
	</div>
</div>