<?php
class Wildnest_Customizer_Control_Icon extends Wildnest_Customizer_Control_Base {
	static function field_template() {
		echo '<script type="text/html" id="tmpl-field-wildnest-icon">';
		self::before_field();
		?>
		<#
		if ( ! _.isObject( field.value ) ) {
			field.value = { };
		}
		#>
		<?php echo self::field_header(); ?>
		<div class="wildnest-field-settings-inner">
			<div class="wildnest--icon-picker">
				<div class="wildnest--icon-preview">
					<input type="hidden" class="wildnest-input wildnest--input-icon-type" data-name="{{ field.name }}-type" value="{{ field.value.type }}">
					<div class="wildnest--icon-preview-icon wildnest--pick-icon">
						<# if ( field.value.icon ) {  #>
							<i class="{{ field.value.icon }}"></i>
						<# }  #>
					</div>
				</div>
				<input type="text" readonly class="wildnest-input wildnest--pick-icon wildnest--input-icon-name" placeholder="<?php esc_attr_e( 'Pick an icon', 'wildnest' ); ?>" data-name="{{ field.name }}" value="{{ field.value.icon }}">
				<span class="wildnest--icon-remove" title="<?php esc_attr_e( 'Remove', 'wildnest' ); ?>">
					<span class="dashicons dashicons-no-alt"></span>
					<span class="screen-reader-text">
					<?php _e( 'Remove', 'wildnest' ); ?></span>
				</span>
			</div>
		</div>
		<?php
		self::after_field();
		echo '</script>';
		?>
		<div id="wildnest--sidebar-icons">
			<div class="wildnest--sidebar-header">
				<a class="customize-controls-icon-close" href="#">
					<span class="screen-reader-text"><?php _e( 'Cancel', 'wildnest' ); ?></span>
				</a>
				<div class="wildnest--icon-type-inner">
					<select id="wildnest--sidebar-icon-type">
						<option value="all"><?php _e( 'All Icon Types', 'wildnest' ); ?></option>
					</select>
				</div>
			</div>
			<div class="wildnest--sidebar-search">
				<input type="text" id="wildnest--icon-search" placeholder="<?php esc_attr_e( 'Type icon name', 'wildnest' ); ?>">
			</div>
			<div id="wildnest--icon-browser"></div>
		</div>
		<?php
	}
}
