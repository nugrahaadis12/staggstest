<?php
class Wildnest_Customizer_Control_Color extends Wildnest_Customizer_Control_Base {
	static function field_template() {
		?>
		<script type="text/html" id="tmpl-field-wildnest-color">
		<?php
		self::before_field();
		?>
		<?php echo self::field_header(); ?>
		<div class="wildnest-field-settings-inner">
			<div class="wildnest-input-color" data-default="{{ field.default }}">
				<input type="hidden" class="wildnest-input wildnest-input--color" data-name="{{ field.name }}" value="{{ field.value }}">
				<input type="text" class="wildnest--color-panel" placeholder="{{ field.placeholder }}" data-alpha="true" value="{{ field.value }}">
			</div>
		</div>
		<?php
		self::after_field();
		?>
		</script>
		<?php
	}
}
