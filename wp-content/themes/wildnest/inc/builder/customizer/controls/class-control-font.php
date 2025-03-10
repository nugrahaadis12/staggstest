<?php
class Wildnest_Customizer_Control_Font extends Wildnest_Customizer_Control_Base {
	static function field_template() {
		?>
		<script type="text/html" id="tmpl-field-wildnest-css-ruler">
		<?php
		self::before_field();
		?>
		<?php echo self::field_header(); ?>
		<div class="wildnest-field-settings-inner">
			<input type="hidden" class="wildnest--font-type" data-name="{{ field.name }}-type" >
			<div class="wildnest--font-families-wrapper">
				<select class="wildnest--font-families" data-value="{{ JSON.stringify( field.value ) }}" data-name="{{ field.name }}-font"></select>
			</div>
			<div class="wildnest--font-variants-wrapper">
				<label><?php _e( 'Variants', 'wildnest' ); ?></label>
				<select class="wildnest--font-variants" data-name="{{ field.name }}-variant"></select>
			</div>
			<div class="wildnest--font-subsets-wrapper">
				<label><?php _e( 'Languages', 'wildnest' ); ?></label>
				<div data-name="{{ field.name }}-subsets" class="list-subsets">
				</div>
			</div>
		</div>
		<?php
		self::after_field();
		?>
		</script>
		<?php
	}
}
