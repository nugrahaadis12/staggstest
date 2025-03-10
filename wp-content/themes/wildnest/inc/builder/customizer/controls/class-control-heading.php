<?php
class Wildnest_Customizer_Control_Heading extends Wildnest_Customizer_Control_Base {
	static function field_template() {
		?>
		<script type="text/html" id="tmpl-field-wildnest-heading">
		<?php
		self::before_field();
		?>
		<h3 class="wildnest-field--heading">{{ field.label }}</h3>
		<?php
		self::after_field();
		?>
		</script>
		<?php
	}
}
