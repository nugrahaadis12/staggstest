<?php

/**
 * Provide a public-facing view for the admin form of the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin admin side.
 *
 * @link       https://staggs.app
 * @since      1.2.0
 *
 * @package    Staggs
 * @subpackage Staggs/admin/partials
 */

?>
<div class="wrap">
	<h2><?php esc_attr_e( 'Tools', 'staggs' ); ?></h2>
	<p><?php esc_attr_e( 'On this page you can easily import or export your attributes.', 'staggs' ); ?></p>
	<div class="meta-box-wrap sgg-meta-boxes">
		<h3>Attributes</h3>
		<div class="meta-box-sortables">
			<?php include 'staggs-metabox-import.php'; ?>
			<?php include 'staggs-metabox-export.php'; ?>
		</div>
		<?php
		// <h3>Generate products</h3>
		// <div class="meta-box-sortables">
		// 	 include 'staggs-metabox-generate.php';
		// </div>
		?>
	</div>
</div>
