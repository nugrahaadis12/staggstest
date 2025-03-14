<?php
class Wildnest_Customizer_Control_Checkbox extends Wildnest_Customizer_Control_Base {

	static function before_field() {
		?>
		<#
		var required = '';
		if ( ! _.isUndefined( field.required ) ) {
			required = JSON.stringify( field.required  );
		}
		#>
		<div class="wildnest--field dadsa wildnest--field-{{ field.type }} {{ field.class }} wildnest--field-name-{{ field.original_name }}" data-required="{{ required }}" data-field-name="{{ field.name }}">
		<?php
	}


	static function field_template() {
		?>
		<script type="text/html" id="tmpl-field-wildnest-checkbox">
		<?php
		self::before_field();
		?>
		<?php echo self::field_header(); ?>
		<div class="wildnest-field-settings-inner">
			<label>

				<span class="onoffswitch">
					<input type="checkbox" class="onoffswitch-checkbox wildnest-input" <# if ( field.value == 1 ){ #> checked="checked" <# } #> data-name="{{ field.name }}" value="1">
					<span class="onoffswitch-label">
						<span class="onoffswitch-inner"></span>
						<span class="onoffswitch-switch"></span>
					</span>
				</span>

				<span class="checkbox-field-text">
					{{{ field.checkbox_label }}}
				</span>
			</label>
		</div>
		<?php
		self::after_field();
		?>
		</script>
		<?php
	}
}
