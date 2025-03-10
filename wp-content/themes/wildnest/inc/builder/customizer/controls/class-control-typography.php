<?php
class Wildnest_Customizer_Control_Typography extends Wildnest_Customizer_Control_Base {
	static function field_template() {
		echo '<script type="text/html" id="tmpl-field-wildnest-typography">';
		self::before_field();
		?>
		<?php echo self::field_header(); ?>
		<div class="wildnest-actions">
			<a href="#" class="action--reset" data-control="{{ field.name }}" title="<?php esc_attr_e( 'Reset to default', 'wildnest' ); ?>"><span class="dashicons dashicons-image-rotate"></span></a>
			<a href="#" class="action--edit" data-control="{{ field.name }}" title="<?php esc_attr_e( 'Toggle edit panel', 'wildnest' ); ?>"><span class="dashicons dashicons-editor-textcolor"></span></a>
		</div>
		<div class="wildnest-field-settings-inner">
			<input type="hidden" class="wildnest-typography-input wildnest-only" data-name="{{ field.name }}" value="{{ JSON.stringify( field.value ) }}" data-default="{{ JSON.stringify( field.default ) }}">
		</div>
		<?php
		self::after_field();
		echo '</script>';
		?>
		<div id="wildnest-typography-panel" class="wildnest-typography-panel">
			<div class="wildnest-typography-panel--inner">
				<input type="hidden" id="wildnest--font-type">
				<div id="wildnest-typography-panel--fields"></div>
			</div>
		</div>
		<?php
	}
}
