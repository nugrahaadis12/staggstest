<?php

/**
 * Provide a admin-facing view for the admin attribute export form of the plugin
 *
 * This file is used to markup the admin-facing attribute export form of the plugin admin side.
 *
 * @link       https://staggs.app
 * @since      1.6.0
 *
 * @package    Staggs
 * @subpackage Staggs/admin/partials
 */

// Get available products list.
$staggs_products = get_woocommerce_staggs_product_list();

$product_id = isset( $_GET['staggs_id'] ) ? sanitize_key( $_GET['staggs_id'] ) : '';
?>
<div id="sgg-admin-tool-generate-variants" class="postbox">
	<div class="postbox-header">
		<h2><?php esc_attr_e( 'Generate variants', 'staggs' ); ?></h2>
	</div>
	<div class="inside">
		<form action="" method="get">
			<div class="sgg-field-title">
				<strong><?php esc_attr_e( 'Product', 'staggs' ); ?></strong><br>
				<p><?php esc_attr_e( 'Select product to make variations for.', 'staggs' ); ?></p>
				<div>
					<select id="staggs_id" name="staggs_id">
						<option value="">- Select product -</option>
						<?php 
						foreach ( $staggs_products as $staggs_product_id => $staggs_product_label ) :
							?>
							<option value="<?php echo esc_attr( $staggs_product_id ); ?>"<?php echo ( $staggs_product_id == $product_id ) ? ' selected="selected"' : ''; ?>>
								<?php echo esc_attr( $staggs_product_label ); ?>
							</option>
							<?php
						endforeach;
						?>
					</select>
				</div>
			</div>
			<div class="sgg-postbox-inner">
				<div class="sgg-submit">
					<input type="hidden" name="post_type" value="sgg_attribute">
					<input type="hidden" name="page" value="tools">
					<button type="submit" class="button-primary"><?php esc_attr_e( 'Load attributes', 'staggs' ); ?></button>
				</div>
			</div>
		</form>
		<?php
		if ( $product_id ) {
			$attributes = staggs_get_post_meta( $product_id, 'sgg_configurator_attributes' );

			$options = array();
			foreach ( $attributes as $attribute ) {
				if ( 'attribute' !== $attribute['_type'] ) {
					continue;
				}

				$attr_id = $attribute['sgg_step_attribute'];

				$options[ $attr_id ] = get_the_title( $attr_id );
			}
			
			$sgg_generate_nonce = wp_create_nonce( 'sgg_generate_nonce' );
			?>
			<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" id="sgg_generate_products_form" enctype="multipart/form-data">
				<div class="sgg-field-wrapper">
					<div class="sgg-field-title">
						<strong><?php esc_attr_e( 'Choose attributes', 'staggs' ); ?></strong>
					</div>
					<div class="sgg-field-input">
						<?php foreach ( $options as $attr_id => $attr_option ) : ?>
							<label for="option-<?php echo esc_attr( $attr_id ); ?>">
								<input id="option-<?php echo esc_attr( $attr_id ); ?>" type="checkbox" name="attributes[]" value="<?php echo esc_attr( $attr_id ); ?>">
								<?php echo esc_attr( $attr_option ); ?>
							</label>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="sgg-postbox-inner">
					<input type="hidden" name="product" value="<?php echo esc_attr( $product_id ); ?>">
					<input type="hidden" name="sgg_generate_nonce" value="<?php echo esc_attr( $sgg_generate_nonce ); ?>">
					<div class="sgg-submit">
						<button type="submit" name="action" class="button-primary" value="sgg_handle_product_generate"><?php esc_attr_e( 'Generate variants', 'staggs' ); ?></button>
					</div>
				</div>
			</form>
			<?php 
		}
		?>
	</div>
</div>
