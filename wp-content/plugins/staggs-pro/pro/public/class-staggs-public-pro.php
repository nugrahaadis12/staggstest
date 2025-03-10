<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://staggs.app
 * @since      1.5.9
 *
 * @package    Staggs
 * @subpackage Staggs/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Staggs
 * @subpackage Staggs/public
 * @author     Staggs <contact@staggs.app>
 */
class Staggs_Public_PRO {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.5.9.
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.5.9.
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since      1.5.9.
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		add_action( 'staggs_after_single_product', array( $this, 'output_configurator_summary_template_html' ) );
		add_action( 'staggs_output_public_scripts', array( $this, 'output_scripts' ) );
	}

	/**
	 * Output the configurator summary shortcode contents.
	 *
	 * @since    1.6.0.
	 */
	public function output_configurator_summary_template_html() {
		if ( 'new_page' === staggs_get_post_meta( staggs_get_theme_id(), 'sgg_configurator_summary_location' ) ) {
			include plugin_dir_path(__FILE__) . 'templates/shortcodes/template-summary.php';
		}
	}

	/**
	 * Register the configurator stylesheets for the public-facing side of the site.
	 *
	 * @since    1.5.9.
	 */
	public function enqueue_scripts() {
		/**
		 * Register plugin styles
		 */
		wp_register_style( $this->plugin_name . '_pro_picker', STAGGS_BASE_URL . 'pro/public/css/staggs-picker.min.css', array(), $this->version, 'all' );

		wp_register_script( $this->plugin_name . '_pro_public', STAGGS_BASE_URL . 'pro/modelviewer/dist/model-viewer.min.js', array( 'jquery' ), $this->version, true );
		wp_register_script( $this->plugin_name . '_pro_picker', STAGGS_BASE_URL . 'pro/public/js/staggs-picker.min.js', array( 'jquery' ), $this->version, true );
		wp_register_script( $this->plugin_name . '_pro_qr', STAGGS_BASE_URL . 'pro/public/js/staggs-qr.min.js', array( 'jquery' ), $this->version, true );
		wp_register_script( $this->plugin_name . '_pro_canvas', STAGGS_BASE_URL . 'pro/public/js/staggs-fabric.min.js', array( 'jquery' ), $this->version, true );
		wp_register_script( $this->plugin_name . '_pro_font_observer', STAGGS_BASE_URL . 'pro/public/js/staggs-font-observer.min.js', array( 'jquery' ), $this->version, true );
	}

	/**
	 * Actually output registered scripts to frontend.
	 *
	 * @since    1.5.9.
	 */
	public function output_scripts() {
		global $sgg_is_shortcode, $sgg_shortcode_id;

		$id = get_the_ID();
		if ( $sgg_is_shortcode ) {
			$id = $sgg_shortcode_id;
		}

		wp_enqueue_style( $this->plugin_name . '_pro_picker' );
		wp_enqueue_script( $this->plugin_name . '_pro_picker' );

		if ( '3dmodel' !== staggs_get_post_meta( $id, 'sgg_configurator_type' ) ) {
			return;
		}

		wp_enqueue_script( $this->plugin_name . '_pro_canvas' );
		wp_enqueue_script( $this->plugin_name . '_pro_font_observer' );
		wp_enqueue_script( $this->plugin_name . '_pro_qr' );
		wp_enqueue_script( $this->plugin_name . '_pro_public' );
		wp_add_inline_script( $this->plugin_name . '_pro_public', $this->enqueue_inline_scripts() );
	}

	/**
	 * Add module type to public script handles.
	 *
	 * @since    1.5.9.
	 */
	public function add_module_to_scripts($tag, $handle, $src)
	{
		if ( $this->plugin_name . '_pro_public' === $handle) {
			$tag = '<script type="module" src="' . esc_url($src) . '"></script>';
		}
		return $tag;
	}

	/**
	 * Register the configurator inline JavaScript for the public-facing side of the site.
	 *
	 * @since    1.5.9.
	 */
	public function enqueue_inline_scripts() {
		global $sanitized_steps, $sgg_is_shortcode, $sgg_shortcode_id;

		$id = get_the_ID();
		if ( $sgg_is_shortcode ) {
			$id = $sgg_shortcode_id;
		}

		if ( '3dmodel' !== staggs_get_post_meta( $id, 'sgg_configurator_type' ) ) {
			return;
		}

		if ( ! $sanitized_steps ) {
			$sanitized_steps = Staggs_Formatter::get_formatted_step_content($id);
		}

		$plusicon = staggs_get_icon( 'sgg_group_plus_icon', 'plus' );
		$minusicon = staggs_get_icon( 'sgg_group_minus_icon', 'minus' );

		$loaded = '';
		$startNodes = staggs_get_post_meta( $id, 'sgg_configurator_3d_nodes' );
		$startHotspots = staggs_get_post_meta( $id, 'sgg_configurator_3d_hotspots' );

		if ( $startNodes ) {
			$script_vars = ' var baseNodes = ["' . implode( '", "', array_map( 'trim', explode( ',', $startNodes ) ) ) . '"]; var visibleNodes = structuredClone( baseNodes ); var hiddenNodes = []; var childNodes = {}; var childHotspots = {}; ';
		} else {
			$script_vars = ' var baseNodes = [], visibleNodes = [], hiddenNodes = [], childNodes = {}, childHotspots = {}; ';
		}

		if ( $startHotspots ) {
			$script_vars .= ' var baseHotspots = ["' . implode( '", "', array_map( 'trim', explode( ', ', $startHotspots ) ) ) . '"], visibleHotspots = [];';
		} else {
			$script_vars .= ' var baseHotspots = [], visibleHotspots = []; ';
		}

		$theme_id = staggs_get_theme_id( $id );
		$script_vars .= ' var modelHotspotData = [';
		if ( staggs_get_post_meta( $theme_id, 'sgg_model_hotspots' ) ) {
			$hotspotFieldData = staggs_get_post_meta( $theme_id, 'sgg_model_hotspots' );

			foreach ( $hotspotFieldData as $hotspot_field ) {
				$script_vars .= "{ 'id': '" .$hotspot_field['sgg_model_hotspot_id'] . "',";
				$script_vars .= " 'content': `" . trim( $hotspot_field['sgg_model_hotspot_content'] ) . "`,";
				$script_vars .= " 'position': '" . $hotspot_field['sgg_model_hotspot_position'] . "',";
				$script_vars .= " 'normal': '" . $hotspot_field['sgg_model_hotspot_normal'] . "' },";
			}
		}
		$script_vars .= ' ];';

		$final_script = ' var sceneSym, allObjects, allGroups, allGroupNames;';
		$final_script .= ' var modelViewer = document.getElementById("product-model-view");';
		$final_script .= ' var plusicon = "<div class=\'hotspot-plus\'>' . str_replace( '"', "'", $plusicon ) . '</div>";';
		$final_script .= ' var minusicon = "<div class=\'hotspot-minus\'>' . str_replace( '"', "'", $minusicon ) . '</div>";';

		foreach ( $sanitized_steps as $step_key => $sanitized_step ) {
			$step_id = $sanitized_step['id'];

			$option_nodes_list = array();
			if ( isset( $sanitized_step['options'] ) && is_array( $sanitized_step['options'] ) ) {
				foreach ( $sanitized_step['options'] as $option ) {
					if ( isset( $option['preview_node'] ) && $option['preview_node'] ) {
						$option_nodes_list[] = sanitize_text_field( $option['preview_node'] );
					}
				}
			}
            
			$final_option_list = array();
			foreach ( $option_nodes_list as $option ) {
				if ( strpos( $option, ',' ) !== -1 ) {
					$option_items = explode( ',', $option );
					foreach ( $option_items as $item ) {
						$item = str_replace( ' ', '', $item );
						if ( ! in_array( $item, $final_option_list ) ) {
							$final_option_list[] = sanitize_text_field( $item );
						}
					}
				} else {
					$final_option_list[] = sanitize_text_field( $option );
				}
			}
            
			$option_hotspot_list = array();
			if ( isset( $sanitized_step['options'] ) && is_array( $sanitized_step['options'] ) ) {
				foreach ( $sanitized_step['options'] as $option ) {
					if ( isset( $option['preview_hotspot'] ) && $option['preview_hotspot'] ) {
						$option_hotspot_list[] = sanitize_text_field( $option['preview_hotspot'] );
					}
				}
			}
            
			$final_hotspot_list = array();
			foreach ( $option_hotspot_list as $hotspot ) {
				if ( strpos( $hotspot, ',' ) !== -1 ) {
					$hotspot_items = explode( ',', $hotspot );
					foreach ( $hotspot_items as $hotspot_item ) {
						$hotspot_item = str_replace( ' ', '', $hotspot_item );
						if ( ! in_array( $hotspot_item, $final_hotspot_list ) ) {
							$final_hotspot_list[] = sanitize_text_field( $hotspot_item );
						}
					}
				} else {
					$final_hotspot_list[] = sanitize_text_field( $hotspot );
				}
			}
            
			$script_vars .= ' childNodes[' . $step_id . '] = ["' . implode('","', $final_option_list ) . '"];';
			$script_vars .= ' childHotspots[' . $step_id . '] = ["' . implode('","', $final_hotspot_list ) . '"];';

			if ( 'dropdown' === $sanitized_step['type'] ) {
				$loaded .= " jQuery('#option-group-{$step_id} select').trigger('change');";
			} else {
				$loaded .= " jQuery('#option-group-{$step_id} input:checked').trigger('change');";
			}
		}

		/**
		 * Default script model handlers.
		 */
		$pro_script = file_get_contents( STAGGS_BASE . '/pro/public/js/staggs-public-pro.min.js');

		$final_script .= $script_vars;
		$final_script .= $pro_script;

		$final_script .= ' modelViewer.addEventListener("load", () => {';
		$final_script .= ' sceneSym = Object.getOwnPropertySymbols(modelViewer).find(x => x.description === "scene");';
		$final_script .= ' allObjects = [];';
		$final_script .= ' allGroups = [];';
		$final_script .= ' allGroupNames = [];';

		if ( staggs_get_theme_option( 'sgg_configurator_smart_nodes_lookup' ) ) {
			$final_script .= ' modelViewer[sceneSym].traverse((object) => {
				if ( object.type ) {
					if ( object.type == "Mesh" ) {
						allObjects.push(object);
					}
					if ( object.type == "Object3D" ) {
						allGroups.push(object);
						allGroupNames.push(object.name);
					}
				}
			});

			if ( baseNodes.length ) {
				for (var bn = 0; bn < baseNodes.length; bn++){
					if ( allGroups.length ) {
						var groupIndex = allGroupNames.indexOf(baseNodes[bn]);
						if ( allGroups[groupIndex] ) {
							allGroups[groupIndex].traverse((child) => {
								if ( child.type ) {
									if ( child.type == "Mesh" ) {
										if ( baseNodes.indexOf(child.name) === -1 ){
											baseNodes.push(child.name);
										}
									}
								}
							});
						}
					}
				}
				visibleNodes = structuredClone(baseNodes);
			}
			';
		} else {
			$final_script .= ' sceneSym = Object.getOwnPropertySymbols(modelViewer).find(x => x.description === "scene");';
			$final_script .= ' allObjects = modelViewer[sceneSym].children[0].children[0].children;';
		}

		$final_script .= ' jQuery(modelViewer).addClass("init");';

		$final_script .= ' if ( baseNodes.length ) { staggsUpdateNodes(); }';
		$final_script .= ' if ( baseHotspots.length ) { staggsUpdateHotspots(); }';

		$final_script .= $loaded;

		$final_script .= ' if ( jQuery(".staggs-view-gallery model-viewer").attr("camera-orbit") ) {';
		$final_script .= ' jQuery(".staggs-view-gallery").attr("data-base-orbit", jQuery(".staggs-view-gallery model-viewer").attr("camera-orbit"));';
		$final_script .= ' } if ( jQuery(".staggs-view-gallery model-viewer").attr("camera-target") ) {';
		$final_script .= ' jQuery(".staggs-view-gallery").attr("data-base-target", jQuery(".staggs-view-gallery model-viewer").attr("camera-target"));';
		$final_script .= ' } if ( jQuery(".staggs-view-gallery model-viewer").get(0).getFieldOfView() ) {';
		$final_script .= ' jQuery(".staggs-view-gallery").attr("data-base-view", jQuery(".staggs-view-gallery model-viewer").get(0).getFieldOfView() + "deg");';
		$final_script .= ' }';

		$final_script .= ' jQuery(modelViewer).removeClass("init");';
		$final_script .= ' if ( jQuery(".view-nav-buttons .selected").length ) { jQuery(".view-nav-buttons .selected").trigger("click"); }';
		$final_script .= ' });
		';

		return printf('<script type="module">%s</script>', $final_script );
	}
}
