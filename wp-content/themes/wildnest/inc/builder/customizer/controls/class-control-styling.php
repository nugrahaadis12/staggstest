<?php
class Wildnest_Customizer_Control_Styling extends Wildnest_Customizer_Control_Modal {
	static function field_template() {
		echo '<script type="text/html" id="tmpl-field-wildnest-styling">';
		self::before_field();
		?>
		<?php echo self::field_header(); ?>
		<div class="wildnest-actions">
			<a href="#" title="<?php esc_attr_e( 'Reset to default', 'wildnest' ); ?>" class="action--reset" data-control="{{ field.name }}"><span class="dashicons dashicons-image-rotate"></span></a>
			<a href="#" title="<?php esc_attr_e( 'Toggle edit panel', 'wildnest' ); ?>" class="action--edit" data-control="{{ field.name }}"><span class="dashicons dashicons-admin-customizer"></span></a>
		</div>
		<div class="wildnest-field-settings-inner">
			<input type="hidden" class="wildnest-hidden-modal-input wildnest-only" data-name="{{ field.name }}" value="{{ JSON.stringify( field.value ) }}" data-default="{{ JSON.stringify( field.default ) }}">
		</div>
		<?php
		self::after_field();
		echo '</script>';
		?>
		<script type="text/html" id="tmpl-wildnest-modal-settings">
			<div class="wildnest-modal-settings">
				<div class="wildnest-modal-settings--inner">
					<div class="wildnest-modal-settings--fields"></div>
				</div>
			</div>
		</script>
		<?php
	}
}
