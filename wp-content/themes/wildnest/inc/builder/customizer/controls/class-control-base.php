<?php

class Wildnest_Customizer_Control_Base extends WP_Customize_Control {
	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'wildnest';
	/**
	 * Data type
	 *
	 * @access public
	 * @var string
	 */
	public $option_type = 'theme_mod';

	public $setting_type = 'group';
	public $fields = array();
	public $choices = array();
	public $default = null;
	public $default_value = null;
	public $device = '';
	public $devices = null;
	public $checkbox_label = '';
	public $placeholder = '';
	public $reset_controls = array();
	public $limit;


	public $min = 0;
	public $max = 700;
	public $step = 1;
	public $unit = false;

	/**
	 * @var array For CSS Ruler.
	 */
	public $fields_disabled = array();

	public $limit_msg = '';
	public $live_title_field;
	public $addable = null;
	public $title_only = null;
	public $_settings;
	public $_selective_refresh;
	public $device_settings = false;
	public $no_setup = false;
	public $_pro = false;

	/**
	 * Provide the parent, comparison operator, and value which affects the field’s visibility.
	 *
	 * @var array
	 */
	public $required;

	public $field_class = '';
	public static $_js_template_added;
	public static $_args_loaded;

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 */
	public function to_json() {
		parent::to_json();

		// Add something here.
		$value = $this->value();
		if ( 'group' == $this->setting_type ) {
			if ( ! is_array( $value ) ) {
				$value = array();
			}
			foreach ( $this->fields as $k => $f ) {
				if ( isset( $value[ $f['name'] ] ) ) {
					$this->fields[ $k ]['value'] = $value[ $f['name'] ];
				}
			}

			if ( ! is_array( $this->default ) ) {
				$this->default = array();
			}
		} elseif ( 'repeater' == $this->setting_type ) {
			if ( ! is_array( $value ) ) {
				$value = array();
			}
			if ( ! is_array( $this->default ) ) {
				$this->default = array();
			}
		}

		// Devices switcher settings = true;.
		$this->json['device_settings'] = $this->device_settings;
		if ( ! $this->device_settings && 'js_raw' != $this->setting_type ) {
			// Fallback value when device_settings from true to false.
			if ( is_array( $value ) && isset( $value['desktop'] ) ) {
				$value = $value['desktop'];
			}
		}

		if ( 'slider' == $this->setting_type ) {
			if ( ! $value || empty( $value ) ) {
				$value = $this->default_value;
			}
		}
		$this->json['value'] = $value;

		$this->json['_pro']           = class_exists( 'Wildnest_Pro' );
		$this->json['default']        = $this->default_value;
		$this->json['placeholder']    = $this->placeholder;
		$this->json['fields']         = $this->fields;
		$this->json['setting_type']   = $this->setting_type;
		$this->json['required']       = $this->required;
		$this->json['devices']        = $this->devices;
		$this->json['reset_controls'] = $this->reset_controls;

		if ( $this->no_setup ) {
			return;
		}

		$this->json['min']  = $this->min;
		$this->json['max']  = $this->max;
		$this->json['step'] = $this->step;
		$this->json['unit'] = $this->unit;
		if ( 'css_ruler' == $this->setting_type ) {
			// $disabled
			$this->json['fields_disabled'] = $this->fields_disabled;
		}

		if ( 'repeater' == $this->setting_type ) {
			$this->json['l10n']             = array(
				'untitled' => esc_html__( 'Untitled', 'wildnest' ),
			);
			$this->json['live_title_field'] = $this->live_title_field;
			$this->json['limit']            = $this->limit;
			$this->json['limit_msg']        = $this->limit_msg;
			$this->json['title_only']       = $this->title_only;
			if ( false === $this->addable ) {
				$this->json['addable'] = false;
				if ( empty( $this->json['value'] ) ) {
					$this->json['value'] = $this->default_value;
				}

				$this->json['value'] = $this->merge_items( $this->json['value'], $this->default_value );

			} else {
				$this->json['addable'] = true;
			}

			// Just make live title file translate able.
			if ( $this->title_only && $this->live_title_field ) {
				$new_array = array();
				foreach ( (array) $this->default_value as $f ) {
					if ( isset( $f['_key'] ) ) {
						if ( isset( $f[ $this->live_title_field ] ) ) {
							$new_array[ $f['_key'] ] = $f;
						}
					}
				}
				if ( ! empty( $new_array ) ) {
					$new_values = array();
					foreach ( (array) $this->json['value'] as $index => $f ) {
						if ( isset( $f['_key'] ) && $new_array[ $f['_key'] ] ) {
							$f[ $this->live_title_field ] = $new_array[ $f['_key'] ][ $this->live_title_field ];
							$new_values[ $f['_key'] ]     = $f;
						}
					}

					$new_values = array_merge( $new_array, $new_values );
					if ( ! empty( $new_values ) ) {
						$this->json['value'] = array_values( $new_values );
					}
				}
			}
		}

		if ( 'select' == $this->setting_type || 'radio' == $this->setting_type ) {
			$this->json['choices'] = $this->choices;
		}
		if ( 'checkbox' == $this->setting_type ) {
			$this->json['checkbox_label'] = $this->checkbox_label;
		}

	}

	/**
	 * Merge 2 array width `_key` is key of each item
	 *
	 * @since 0.2.5
	 *
	 * @param array $destination
	 * @param array $new_array
	 *
	 * @return array
	 */
	function merge_items( $destination = array(), $new_array = array() ) {
		return Wildnest_Customizer::merge_items( $destination, $new_array );
	}


	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_media();
		if ( 'repeater' == $this->setting_type ) {
			wp_enqueue_script( 'jquery-ui-sortable' );
		}

		$suffix = Wildnest()->get_asset_suffix();
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_style( 'wildnest-customizer-control', esc_url( get_template_directory_uri() ) . '/assets/css/admin/customizer/customizer' . $suffix . '.css' ); // phpcs:ignore
		wp_enqueue_style( 'select2', esc_url( get_template_directory_uri() ) . '/assets/vendor/select2/select2' . $suffix . '.css' ); // phpcs:ignore
		wp_enqueue_script( 'wildnest-color-picker-alpha', esc_url( get_template_directory_uri() ) . '/assets/js/customizer/color-picker-alpha' . $suffix . '.js', array( 'wp-color-picker' ), false, true ); // phpcs:ignore
		wp_enqueue_script( 'select2', esc_url( get_template_directory_uri() ) . '/assets/vendor/select2/select2' . $suffix . '.js', array( 'jquery' ), false, true ); // phpcs:ignore
		wp_enqueue_script( // phpcs:ignore
			'wildnest-customizer-control',
			esc_url( get_template_directory_uri() ) . '/assets/js/customizer/control' . $suffix . '.js',
			array(
				'jquery',
				'customize-base',
				'jquery-ui-core',
				'jquery-ui-sortable',
			),
			false,
			true
		);
		if ( is_null( self::$_args_loaded ) ) {

			$posts_page = get_option( 'page_for_posts' );
			if ( $posts_page ) {
				$blog_url = get_permalink( $posts_page );
			} else {
				$blog_url = home_url( '/' );
			}

			$query = new WP_Query(
				array(
					'post_type'      => 'post',
					'posts_per_page' => 1,
					'orderby'        => 'rand',
				)
			);

			$posts = $query->get_posts();
			$single_post_url = home_url( '/' );
			if ( count( $posts ) ) {
				$single_post_url = get_permalink( $posts[0] );
			}

			$args = array(
				'home_url'         => esc_url( home_url( '' ) ),
				'ajax'             => admin_url( 'admin-ajax.php' ),
				'is_rtl'           => is_rtl(),
				'theme_default'    => esc_html__( 'Theme Default', 'wildnest' ),
				'reset'            => esc_html__( 'Reset this section settings', 'wildnest' ),
				'untitled'         => esc_html__( 'Untitled', 'wildnest' ),
				'confirm_reset'    => esc_html__( 'Do you want to reset this section settings?', 'wildnest' ),
				'list_font_weight' => array(
					''       => esc_html__( 'Default', 'wildnest' ),
					'normal' => _x( 'Normal', 'wildnest-font-weight', 'wildnest' ),
					'bold'   => _x( 'Bold', 'wildnest-font-weight', 'wildnest' ),
				),
				'typo_fields'      => Wildnest()->customizer->get_typo_fields(),
				'styling_config'   => Wildnest()->customizer->get_styling_config(),
				'devices'          => Wildnest()->customizer->devices,
				// Auto redirect to url when section open.
				'section_urls'     => array(
					'section_single_blog_post' => $single_post_url,
					'section_search_results'   => home_url( '/?s=a' ), // search page.
				),
				// Auto redirect to url when section panel.
				'panel_urls'       => array(
					'panel_blog_post' => $blog_url,
				),
			);

			wp_localize_script( 'wildnest-customizer-control', 'Wildnest_Control_Args', apply_filters( 'Wildnest_Control_Args', $args ) ); // phpcs:ignore

			$color_picker_l10n_args = array(
				'clear'            => esc_html__( 'Clear', 'wildnest' ),
				'clearAriaLabel'   => esc_html__( 'Clear color', 'wildnest' ),
				'defaultString'    => esc_html__( 'Default', 'wildnest' ),
				'defaultAriaLabel' => esc_html__( 'Select default color', 'wildnest' ),
				'pick'             => esc_html__( 'Select Color', 'wildnest' ),
				'defaultLabel'     => esc_html__( 'Color value', 'wildnest' ),
			);
			wp_localize_script( 'wp-color-picker', 'Wildnest_ColorPicker_L10n', apply_filters( 'Wildnest_Control_Color_Picker_L10n_Args', $color_picker_l10n_args ) ); // phpcs:ignore
			self::$_args_loaded = true;
		}
	}


	/**
	 * Renders the control wrapper and calls $this->render_content() for the internals.
	 */
	protected function render() {
		$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
		$class = 'customize-control customize-control-' . $this->type . '-' . $this->setting_type;
		if ( $this->field_class ) {
			$class = sanitize_text_field( $this->field_class ) . ' ' . $class;
		}

		?>
		<li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?><?php echo esc_html( $this->device ) ? '  wildnest--device-show wildnest--device-' . esc_attr( $this->device ) : ''; ?>">
		<?php $this->render_content(); ?>
		</li>
		<?php
	}


	/**
	 * Render the control's content.
	 * Allows the content to be overriden without having to rewrite the wrapper in $this->render().
	 *
	 * @access protected
	 */
	protected function render_content() {
		if ( 'js_raw' == $this->setting_type ) {
			return '';
		}

		if ( 'heading' == $this->setting_type ) {
			?>
			<div class="wildnest-control--heading">
				<label>
					<?php if ( ! empty( $this->label ) ) : ?>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<?php endif; ?>
				</label>
			</div>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>
			<?php
			return '';
		}

		?>
		<div class="wildnest--settings-wrapper <?php echo ( isset( $this->description ) && ! empty( $this->description ) ) ? 'show-short-desc' : ''; ?> <?php echo esc_attr( $this->label || $this->description ) ? 'has-title-desc' : 'no-title-desc'; ?>">
			<?php if ( $this->label ) { ?>
				<div data-control="<?php echo esc_attr( $this->id ); ?>" class="wildnest-control-field-header wildnest-field-heading">
					<label>
						<?php if ( ! empty( $this->label ) ) : ?>
							<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<?php endif; ?>
					</label>
				</div>
			<?php } ?>
			<?php
			if ( 'custom_html' == $this->setting_type ) {
				?>
				<div class="custom_html"><?php
					echo wp_kses_post( $this->description );
				?></div>
				<?php
			} else {
				?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
				<?php endif; ?>
			<?php } ?>

			<?php if ( 'custom_html' != $this->setting_type ) { ?>
				<div class="wildnest--settings-fields<?php echo ( 'repeater' == $this->setting_type ) ? ' wildnest--repeater-items' : ''; ?>"></div>
				<?php if ( 'repeater' == $this->setting_type ) { ?>
					<div class="wildnest--repeater-actions">
						<a href="#" class="wildnest--repeater-reorder" data-text="<?php esc_attr_e( 'Reorder', 'wildnest' ); ?>" data-done="<?php _e( 'Done', 'wildnest' ); ?>"><?php _e( 'Reorder', 'wildnest' ); ?></a>
						<?php if ( false !== $this->addable ) { ?>
							<button type="button" class="button wildnest--repeater-add-new"><?php _e( 'Add an item', 'wildnest' ); ?></button>
						<?php } ?>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
		<?php
	}

	static function before_field() {
		?>
		<#
		var required = '';
		if ( ! _.isUndefined( field.required ) ) {
		required = JSON.stringify( field.required  );
		}
		#>
		<div class="wildnest--field wildnest--field-{{ field.type }} {{ field.class }} wildnest--field-name-{{ field.original_name }}" data-required="{{ required }}" data-field-name="{{ field.name }}">
		<?php
	}

	static function after_field() {
		?>
		</div>
		<?php
	}

	static function field_header() {
		?>
		<# if ( field.label || field.description ) { #>
		<div class="wildnest-field-header">
			<# if ( field.label ) { #>
			<div class="wildnest-field-heading">
				<label class="customize-control-title">{{{ field.label }}}</label>
			</div>
			<# } #>
			<# if ( field.description ) { #>
			<p class="description">{{{ field.description }}}</p>
			<# } #>
		</div>
		<# } #>
		<?php
	}

	static function field_template() {
		?>
		<script type="text/html" id="tmpl-field-wildnest-text">
			<?php
			self::before_field();
			?>
			<?php echo self::field_header(); ?>
			<div class="wildnest-field-settings-inner">
				<input type="{{ field.type }}" class="wildnest-input wildnest-only" placeholder="{{ field.placeholder }}" data-name="{{ field.name }}" value="{{ field.value }}">
			</div>
			<?php
			self::after_field();
			?>
		</script>
		<?php
	}


}
