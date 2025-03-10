<?php
class Wildnest_Customizer_Control_Shadow extends Wildnest_Customizer_Control_Base {
	static function field_template() {
		echo '<script type="text/html" id="tmpl-field-wildnest-shadow">';
		self::before_field();
		?>
		<#
			if ( ! _.isObject( field.value ) ) {
			field.value = { };
			}

			var uniqueID = field.name + ( new Date().getTime() );
		#>
			<?php echo self::field_header(); ?>
			<div class="wildnest-field-settings-inner">

				<div class="wildnest-input-color" data-default="{{ field.default }}">
					<input type="hidden" class="wildnest-input wildnest-input--color" data-name="{{ field.name }}-color" value="{{ field.value.color }}">
					<input type="text" class="wildnest--color-panel" data-alpha="true" value="{{ field.value.color }}">
				</div>

				<div class="wildnest--gr-inputs">
					<span>
						<input type="number" class="wildnest-input wildnest-input-css change-by-js"  data-name="{{ field.name }}-x" value="{{ field.value.x }}">
						<span class="wildnest--small-label"><?php _e( 'X', 'wildnest' ); ?></span>
					</span>
					<span>
						<input type="number" class="wildnest-input wildnest-input-css change-by-js"  data-name="{{ field.name }}-y" value="{{ field.value.y }}">
						<span class="wildnest--small-label"><?php _e( 'Y', 'wildnest' ); ?></span>
					</span>
					<span>
						<input type="number" class="wildnest-input wildnest-input-css change-by-js" data-name="{{ field.name }}-blur" value="{{ field.value.blur }}">
						<span class="wildnest--small-label"><?php _e( 'Blur', 'wildnest' ); ?></span>
					</span>
					<span>
						<input type="number" class="wildnest-input wildnest-input-css change-by-js" data-name="{{ field.name }}-spread" value="{{ field.value.spread }}">
						<span class="wildnest--small-label"><?php _e( 'Spread', 'wildnest' ); ?></span>
					</span>
					<span>
						<span class="input">
							<input type="checkbox" class="wildnest-input wildnest-input-css change-by-js" <# if ( field.value.inset == 1 ){ #> checked="checked" <# } #> data-name="{{ field.name }}-inset" value="{{ field.value.inset }}">
						</span>
						<span class="wildnest--small-label"><?php _e( 'inset', 'wildnest' ); ?></span>
					</span>
				</div>
			</div>
			<?php
			self::after_field();
			echo '</script>';
	}
}
