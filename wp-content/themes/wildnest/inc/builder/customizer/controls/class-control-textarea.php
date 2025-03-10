<?php
class Wildnest_Customizer_Control_Textarea extends Wildnest_Customizer_Control_Base {
	static function field_template() {
		echo '<script type="text/html" id="tmpl-field-wildnest-textarea">';
		self::before_field();
		?>
		<?php echo self::field_header(); ?>
		<div class="wildnest-field-settings-inner">
			<textarea rows="10" class="wildnest-input" data-name="{{ field.name }}">{{ field.value }}</textarea>
		</div>
		<?php
		self::after_field();
		echo '</script>';
	}
}
