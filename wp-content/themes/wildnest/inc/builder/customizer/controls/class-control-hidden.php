<?php
class Wildnest_Customizer_Control_Hidden extends Wildnest_Customizer_Control_Base {
	static function field_template() {
		?>
		<script type="text/html" id="tmpl-field-wildnest-hidden">
		<?php
		self::before_field();
		?>
		<input type="hidden" class="wildnest-input wildnest-only" data-name="{{ field.name }}" value="{{ field.value }}">
		<?php
		self::after_field();
		?>
		</script>
		<?php
	}
}
