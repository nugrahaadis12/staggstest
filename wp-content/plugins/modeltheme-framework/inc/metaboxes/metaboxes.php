<?php 
defined( 'ABSPATH' ) || exit;

// PAGE OPTIONS
add_action( 'cmb2_admin_init', 'modeltheme_framework_page_metaboxs' );
function modeltheme_framework_page_metaboxs() { 
      global $wpdb;

      // SIDEBARS
      $sidebar_options = array();
      $sidebars = $GLOBALS['wp_registered_sidebars'];

      if($sidebars){
            foreach ( $sidebars as $sidebar ){
                  $sidebar_options[$sidebar['id']] = $sidebar['name'];
            }
      }

      $fields_group = new_cmb2_box( array(
            'id'           => 'page_metaboxs',
            'title'        => esc_html__( 'Page Custom Options', 'modeltheme' ),
            'object_types' => array( 'page' ),
            'priority'     => 'high',
      ) );

      $fields_group->add_field( array(
            'name' => __( '<h1>Custom Header Options</h1>', 'modeltheme' ),
            'desc' => esc_html__( 'These options replaces the Theme Options for current page.', 'modeltheme' ),
            'id'   => 'mt_test_title1',
            'type' => 'title',
      ) );
      $fields_group->add_field( array(
            'name'    => esc_html__( 'Transparent Header', 'modeltheme' ),
            'desc'    => esc_html__( 'If "Yes" - Navigation will go over Header', 'modeltheme' ),
            'id'      => 'mt_metabox_header_transparent',
            'type'             => 'select',
            'show_option_none' => true,
            'options' => array(
                'yes' => esc_html__( 'Yes', 'modeltheme' ),
                'no' => esc_html__( 'No', 'modeltheme' ),
            ),
            'default' => 'no',
      ) );
      $fields_group->add_field( array(
            'name'    => esc_html__( 'Header (Texts and Nav links color)', 'modeltheme' ),
            'desc'    => esc_html__( 'This option will override the options from the Theme Panel (and will only be applied to this page only). To change it globally, please go to Theme Panel.', 'modeltheme' ),
            'id'      => 'mt_header_nav_links_color',
            'type'    => 'colorpicker',
            'default' => ''
      ) );
      $fields_group->add_field( array(
            'name'    => esc_html__( 'Header (Nav links color) - Hover', 'modeltheme' ),
            'desc'    => esc_html__( 'This option will override the options from the Theme Panel (and will only be applied to this page only). To change it globally, please go to Theme Panel.', 'modeltheme' ),
            'id'      => 'mt_header_nav_links_color_hover',
            'type'    => 'colorpicker',
            'default' => ''
      ) );
      $fields_group->add_field( array(
            'name'    => esc_html__( 'Header Top Background (Override)', 'modeltheme' ),
            'desc'    => esc_html__( 'This option will override the options from the Theme Panel (and will only be applied to this page only). To change it globally, please go to Theme Panel.', 'modeltheme' ),
            'id'      => 'mt_header_top_custom_background',
            'type'    => 'colorpicker',
            'default' => '',
            'options' => array(
               'alpha' => true, // Make this a rgba color picker.
            ),
      ) );
      $fields_group->add_field( array(
            'name'    => esc_html__( 'Header Main Background (Override)', 'modeltheme' ),
            'desc'    => esc_html__( 'This option will override the options from the Theme Panel (and will only be applied to this page only). To change it globally, please go to Theme Panel.', 'modeltheme' ),
            'id'      => 'mt_header_main_custom_background',
            'type'    => 'colorpicker',
            'default' => '',
            'options' => array(
               'alpha' => true, // Make this a rgba color picker.
            ),
      ) );
      $fields_group->add_field( array(
            'name'    => esc_html__( 'Header Main Background (Override) - Sticky', 'modeltheme' ),
            'desc'    => esc_html__( 'Only if sticky header option is enabled. This option will override the options from the Theme Panel (and will only be applied to this page only). To change it globally, please go to Theme Panel.', 'modeltheme' ),
            'id'      => 'mt_header_main_custom_background_sticky',
            'type'    => 'colorpicker',
            'default' => '',
            'options' => array(
               'alpha' => true, // Make this a rgba color picker.
            ),
      ) );
      $fields_group->add_field( array(
            'name' => esc_html__( 'Custom Logo', 'modeltheme' ),
            'desc' => esc_html__( 'Important: The logo is usually set from the Theme Panel -> Header (Only upload a custom logo here if you want to replace the global logo on this page only).', 'modeltheme' ),
            'id'   => 'mt_metabox_header_logo',
            'type' => 'file',
            'save_id' => true,
            'allow' => array( 'url', 'attachment' )
      ) );
      $fields_group->add_field( array(
            'name' => esc_html__( 'Custom Logo (Sticky Header)', 'modeltheme' ),
            'desc' => esc_html__( 'Important: The logo is usually set from the Theme Panel -> Header (Only upload a custom logo here if you want to replace the global logo on this page only).', 'modeltheme' ),
            'id'   => 'mt_metabox_header_logo_sticky',
            'type' => 'file',
            'save_id' => true,
            'allow' => array( 'url', 'attachment' )
      ) );
      $fields_group->add_field( array(
          'name'    => esc_html__('Select Header Variant','modeltheme'),
          'id'      => 'mt_header_custom_variant',
          'type'    => 'radio',
          'options' => wildnest_get_header_templates_list(),
          'default' => '',
      ) );
      $fields_group->add_field( array(
            'name'    => esc_html__( 'Page title-breadcrumbs', 'modeltheme' ),
            'desc'    => esc_html__( 'Select an option', 'modeltheme' ),
            'id'      => 'mt_breadcrumbs_on_off',
            'type'    => 'select',
            'options' => array(
                  '' => esc_html__('Default - As Selected from the Theme Panel', 'modeltheme'),
                  'no' => esc_html__( 'Off - Hide title-breadcrumbs area', 'modeltheme' ),
                  'yes' => esc_html__( 'On - Show title-breadcrumbs area', 'modeltheme' ),
            ),
            'default' => '',
      ) );


      /**
      General Page Options
      */
      $fields_group->add_field( array(
            'name' => __( '<h1>General Options</h1>', 'modeltheme' ),
            'desc' => esc_html__( 'These options replaces the Theme Options for current page.', 'modeltheme' ),
            'id'   => 'mt_test_title2',
            'type' => 'title',
      ) );
      $fields_group->add_field( array(
            'name'    => esc_html__( 'Body Background Image', 'modeltheme' ),
            'desc'    => esc_html__( 'Replaces customizer background image option', 'modeltheme' ),
            'id'      => 'mt_body_bg_image',
            'type' => 'file',
            'save_id' => true,
            'allow' => array( 'url', 'attachment' ),
            'default' => ''
      ) );
      $fields_group->add_field( array(
            'name'    => esc_html__( 'Body Background Color', 'modeltheme' ),
            'desc'    => esc_html__( '(Optional): Replaces customizer background color option', 'modeltheme' ),
            'id'      => 'mt_body_bg_color',
            'type'    => 'colorpicker',
            'default' => ''
      ) );
      $fields_group->add_field( array(
            'name'    => esc_html__( 'Page top/bottom spacing', 'modeltheme' ),
            'desc'    => esc_html__( 'Select an option', 'modeltheme' ),
            'id'      => 'mt_page_spacing',
            'type'    => 'select',
            'options' => array(
                  'high-padding' => esc_html__( 'High Padding', 'modeltheme' ),
                  'no-padding' => esc_html__( 'No Padding', 'modeltheme' ),
                  'no-padding-top' => esc_html__( 'No Padding top', 'modeltheme' ),
                  'no-padding-bottom' => esc_html__( 'No Padding bottom', 'modeltheme' ),
            ),
            'default' => 'high-padding',
      ) );
      $fields_group->add_field( array(
            'name'    => esc_html__( 'First Skin Color', 'modeltheme' ),
            'desc'    => esc_html__( 'Replaces theme options main color', 'modeltheme' ),
            'id'      => 'mt_global_page_color',
            'type'    => 'colorpicker',
            'default' => ''
      ) );
      $fields_group->add_field( array(
            'name'    => esc_html__( 'Skin Color - Hover', 'modeltheme' ),
            'desc'    => esc_html__( 'Replaces theme options main color', 'modeltheme' ),
            'id'      => 'mt_global_page_color_hover',
            'type'    => 'colorpicker',
            'default' => ''
      ) );
 
      /**
      FOOTER
      */
      $fields_group->add_field( array(
            'name' => '<h1>Custom Footer Options</h1>',
            'desc' => esc_html__('These options replaces the Theme Options for current page.','modeltheme'),
            'type' => 'title',
            'id'   => 'mt_test_title3',
      ) );
      $fields_group->add_field( array(
            'name' => esc_html__( 'Disable Footer Main', 'modeltheme' ),
            'desc' => esc_html__( 'Check to disable footer top row', 'modeltheme' ),
            'id'   => 'mt_footer_row_main_status',
            'type' => 'checkbox',
      ) );
      $fields_group->add_field( array(
            'name' => esc_html__( 'Disable Footer Bottom', 'modeltheme' ),
            'desc' => esc_html__( 'Check to disable footer bottom copyright bar', 'modeltheme' ),
            'id'   => 'mt_footer_bottom_bar',
            'type' => 'checkbox',
      ) );
      // BG color/img
      $fields_group->add_field( array(
            'name'    => esc_html__( 'Footer Background Image', 'modeltheme' ),
            'desc'    => esc_html__( 'Replaces theme panel footer background image option', 'modeltheme' ),
            'id'      => 'mt_footer_bg_image',
            'type' => 'file',
            'save_id' => true,
            'allow' => array( 'url', 'attachment' ),
            'default' => ''
      ) );
      $fields_group->add_field( array(
            'name'    => esc_html__( 'Footer Background Color', 'modeltheme' ),
            'desc'    => esc_html__( '(Optional): Replaces theme panel footer background color option', 'modeltheme' ),
            'id'      => 'mt_footer_bg_color',
            'type'    => 'colorpicker',
            'default' => ''
      ) );
      // Texts color
      $fields_group->add_field( array(
            'name'    => esc_html__( 'Footer Headings color', 'modeltheme' ),
            'desc'    => esc_html__( '(Optional): Replaces theme options color (widget titles & copyright text)', 'modeltheme' ),
            'id'      => 'mt_footer_headings_color',
            'type'    => 'colorpicker',
            'default' => ''
      ) );
      $fields_group->add_field( array(
            'name'    => esc_html__( 'Footer texts color', 'modeltheme' ),
            'desc'    => esc_html__( '(Optional): Replaces theme options color (links, social media, texts, headings and more)', 'modeltheme' ),
            'id'      => 'mt_footer_texts_color',
            'type'    => 'colorpicker',
            'default' => ''
      ) );
      $fields_group->add_field( array(
            'name'    => esc_html__( 'Footer texts color - hover', 'modeltheme' ),
            'desc'    => esc_html__( '(Optional): Replaces theme options color (links & social media)', 'modeltheme' ),
            'id'      => 'mt_footer_texts_color_hover',
            'type'    => 'colorpicker',
            'default' => ''
      ) );
      $fields_group->add_field( array(
            'name'    => esc_html__( 'Footer Bottom Border', 'modeltheme' ),
            'desc'    => esc_html__( '(Optional): Replaces theme options footer bottom border color', 'modeltheme' ),
            'id'      => 'mt_footer_bottom_border',
            'type'    => 'colorpicker',
            'default' => ''
      ) );
}