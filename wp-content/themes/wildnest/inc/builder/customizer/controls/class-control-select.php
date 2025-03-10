<?php
class Wildnest_Customizer_Control_Select extends Wildnest_Customizer_Control_Base {
	static function field_template() {
		echo '<script type="text/html" id="tmpl-field-wildnest-select">';
		self::before_field();
		?>
		<?php echo self::field_header(); ?>
		<div class="wildnest-field-settings-inner">
			<select class="wildnest-input" data-name="{{ field.name }}">
				<# _.each( field.choices, function( label, key ){  #>
					<option <# if ( field.value == key ){ #> selected="selected" <# } #> value="{{ key }}">{{ label }}</option>
				<# } ); #>
			</select>
		</div>
		<?php
		self::after_field();
		echo '</script>';
	}
}
