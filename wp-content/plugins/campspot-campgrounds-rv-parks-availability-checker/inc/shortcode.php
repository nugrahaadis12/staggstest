<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/** 
 * Table of Contents
 * 
 * 1. Shortcode
 * 2. Elementor Widget Creator
 * 3. Optional: WPBakery Mapping
 */

//1. Shortcode
function ccrpac_builder($params, $content) {
    extract( shortcode_atts( 
        array(
            'version'                    => '',
            'detailed_finder'            => '',
            'max_guests'                 => '',
            'color'                      => '',
            'color_hover'                => '',
            'bg_color'                   => '',
            'bg_color_hover'             => '',
            'submit_button_label'        => '',
            'property_id'                => '',
            'bg_form'                    => '',
            'color_label'                => '',
            'url_bnb'                    => '',

        ), $params ) ); 

        // CSS
        wp_enqueue_style( 'ccrpac-custom', plugins_url( 'assets/css/custom.css', __FILE__ ), array(), '1.0.0', 'all' );
        wp_enqueue_style( 'pignose-calendar', plugins_url( 'assets/css/pignose.calendar.min.css', __FILE__ ), array(), '1.0.0', 'all' );
        // JS
        wp_enqueue_script( 'ccrpac-custom', plugins_url( 'assets/js/custom.js', __FILE__ ), array(), '1.0.0', 'all' );
        wp_enqueue_script( 'pignose-calendar', plugins_url( 'assets/js/pignose.calendar.full.min.js', __FILE__ ), array(), '1.0.0', 'all' );
        
	    ob_start(); 
	    ?>
            <?php 
            $form_v = 'v1';
            if(isset($version) && !empty($version)){
                $form_v = $version;
            } 

            $checkin_id = uniqid('check-out-date-');
            $checkout_id = uniqid('check-out-date-');
            $adults_id = uniqid('adults-number-');
            $children_id = uniqid('children-number-');
            $infants_id = uniqid('infants-number-');
            $guests_id = uniqid('guests-number-');


            if ($url_bnb && $property_id) {
                $action = 'https://';
                $action .= esc_attr($url_bnb) . '/site/' . esc_attr($property_id);
            } else {
                $action = '#'; 
            }

            ?>
            <div class="mt-campspot-campgrounds-rv-parks-availability-checker">
                <form action="<?php echo esc_url($action); ?>" method="get">
                    <div class="ccrpac_row <?php echo esc_attr($form_v); ?>">
                        <div class="ccrpac_input_wrapper">
                            <div class="ccrpac-date-wrapper">
                                <div class="mt_single_builder_field mt_field--input_datepicker">
                                    <?php ?>
                                    <label for="<?php echo esc_attr($checkin_id); ?>"><?php echo esc_html__('Check In', 'ccrpac');?></label>
                                    <input id="<?php echo esc_attr($checkin_id); ?>" format="yy-mm-dd" autocomplete="off" id="text-calendar1" required type="text" value="" name="checkin" placeholder="eg: yy-mm-dd" class="form-control datepicker calendar-input" />
                                </div>
                                <div class="mt_single_builder_field mt_field--input_datepicker">
                                    <label for="<?php echo esc_attr($checkout_id); ?>"><?php echo esc_html__('Check Out', 'ccrpac');?></label>
                                    <input id="<?php echo esc_attr($checkout_id); ?>" format="yy-mm-dd" autocomplete="off" id="text-calendar2" required type="text" value="" name="checkout" placeholder="eg: yy-mm-dd" class="form-control datepicker calendar-input" />
                                </div>
                            </div>
                            <?php if($detailed_finder == "yes") { ?>
                                <div class="mt_single_builder_field mt_field--input_number">
                                    <label for="<?php echo esc_attr($adults_id); ?>"><?php echo esc_html__('Guests', 'ccrpac');?></label>
                                    <input id="<?php echo esc_attr($adults_id); ?>" required type="number" value name="adults" min="1" max="<?php echo esc_attr($max_guests);?>" placeholder="<?php echo esc_html__('Age 13+', 'ccrpac');?>" class="form-control" />
                                </div>
                                <div class="mt_single_builder_field mt_field--input_number">
                                    <label for="<?php echo esc_attr($children_id); ?>"><?php echo esc_html__('Children', 'ccrpac');?></label>
                                    <input id="<?php echo esc_attr($children_id); ?>" required type="number" value name="children" min="0" max="<?php echo esc_attr($max_guests);?>" placeholder="<?php echo esc_html__('Ages 2–12', 'ccrpac');?>" class="form-control" />
                                </div>
                                <div class="mt_single_builder_field mt_field--input_number infants">
                                    <label for="<?php echo esc_attr($infants_id); ?>"><?php echo esc_html__('Pets', 'ccrpac');?></label>
                                    <input id="<?php echo esc_attr($infants_id); ?>" required type="number" value name="pets" min="0" max="<?php echo esc_attr($max_guests);?>" placeholder="<?php echo esc_html__('Under 2', 'ccrpac');?>" class="form-control" />
                                </div>
                            <?php } else { ?>
                            <div class="mt_single_builder_field mt_field--input_number guests">
                                <label for="<?php echo esc_attr($guests_id); ?>"><?php echo esc_html__('Guests', 'ccrpac');?></label>
                                <input id="<?php echo esc_attr($guests_id); ?>" required type="number" value name="guests" min="1" max="<?php echo esc_attr($max_guests);?>" placeholder="<?php echo esc_html__('Age 13+', 'ccrpac');?>" class="form-control" />
                            </div>
                        <?php } ?>
                        </div>
                        <div class="ccrpac-btn-group">
                            <input type="submit" class="rippler rippler-default button-winona btn btn-lg tabs_button ccrpac-submit" style="background-color:<?php echo esc_attr($bg_color);?>; color:<?php echo esc_attr($color);?>" name="submit" name="submit" value="<?php echo esc_attr($submit_button_label);?>" />
                        </div>
                    </div>
                </form>
            </div>
            <?php

	    return ob_get_clean();
	}
add_shortcode('ccrpac-builder-shortcode', 'ccrpac_builder');


// 2. Elementor Widget Creator
if (in_array('elementor/elementor.php', apply_filters('active_plugins', get_option('active_plugins')))) {
	class APAC_Elementor_Widgets {

		protected static $instance = null;

		public static function get_instance() {
			if ( ! isset( static::$instance ) ) {
				static::$instance = new static;
			}

			return static::$instance;
		}

		protected function __construct() {
			require_once('elementor.php');

			add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
		}

		public function register_widgets() {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\APAC_Widget() );
		}

	}

	// Elementor Init
	add_action( 'init', 'ccrpac_elementor_init' );
	function ccrpac_elementor_init() {
		APAC_Elementor_Widgets::get_instance();
	}

	// Elementor Widgets Category
	function ccrpac_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'ccrpac-widgets',
			[
				'title' => esc_html__( 'Campspot Campgrounds, RV parks Availability Checker', 'ccrpac' ),
				'icon' => 'fas fa-plug',
			]
		);
	}
	add_action( 'elementor/elements/categories_registered', 'ccrpac_widget_categories' );
}

