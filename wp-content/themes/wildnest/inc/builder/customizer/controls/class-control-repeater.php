<?php

class Wildnest_Customizer_Control_Repeater extends Wildnest_Customizer_Control_Base {
	static function field_template() {
		?>
		<script type="text/html" id="tmpl-field-wildnest-repeater">
			<?php
			self::before_field();
			?>
			<?php echo self::field_header(); ?>
			<div class="wildnest-field-settings-inner">
			</div>
			<?php
			self::after_field();
			?>
		</script>
		<script type="text/html" id="tmpl-customize-control-repeater-item">
			<div class="wildnest--repeater-item">
				<div class="wildnest--repeater-item-heading">
					<label class="wildnest--repeater-visible" title="<?php esc_attr_e( 'Toggle item visible', 'wildnest' ); ?>">
						<input type="checkbox" class="r-visible-input">
						<span class="r-visible-icon"></span>
						<span class="screen-reader-text"><?php _e( 'Show', 'wildnest' ); ?></label>
					<span class="wildnest--repeater-live-title"></span>
					<div class="wildnest-nav-reorder">
						<span class="wildnest--down" tabindex="-1">
							<span class="screen-reader-text"><?php _e( 'Move Down', 'wildnest' ); ?></span></span>
						<span class="wildnest--up" tabindex="0">
							<span class="screen-reader-text"><?php _e( 'Move Up', 'wildnest' ); ?></span>
						</span>
					</div>
					<a href="#" class="wildnest--repeater-item-toggle">
						<span class="screen-reader-text"><?php _e( 'Close', 'wildnest' ); ?></span></a>
				</div>
				<div class="wildnest--repeater-item-settings">
					<div class="wildnest--repeater-item-inside">
						<div class="wildnest--repeater-item-inner"></div>
						<# if ( data.addable ){ #>
						<a href="#" class="wildnest--remove"><?php _e( 'Remove', 'wildnest' ); ?></a>
						<# } #>
					</div>
				</div>
			</div>
		</script>
		<script type="text/html" id="tmpl-customize-control-repeater-inner">
			<div class="wildnest--repeater-inner">
				<div class="wildnest--settings-fields wildnest--repeater-items"></div>
				<div class="wildnest--repeater-actions">
				<a href="#" class="wildnest--repeater-reorder"
				data-text="<?php esc_attr_e( 'Reorder', 'wildnest' ); ?>"
				data-done="<?php _e( 'Done', 'wildnest' ); ?>"><?php _e( 'Reorder', 'wildnest' ); ?></a>
					<# if ( data.addable ){ #>
					<button type="button"
							class="button wildnest--repeater-add-new"><?php _e( 'Add an item', 'wildnest' ); ?></button>
					<# } #>
				</div>
			</div>
		</script>
		<?php
	}
}
