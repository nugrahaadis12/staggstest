<?php

class Modeltheme_Masonry_Gallery extends \Elementor\Widget_Base {
    public function get_style_depends() {
        wp_enqueue_style( 'modeltheme-masonry-gallery', plugin_dir_url( __FILE__ ).'css/masonry-gallery.css');
        wp_enqueue_style( 'magnificpopup', plugin_dir_url( __FILE__ ).'css/magnificPopup.css');

        return [
            'modeltheme-masonry-gallery', 'magnificpopup'
        ];
    }
    public function get_script_depends() {
        wp_register_script( 'modeltheme-magnificpopup', plugin_dir_url( __FILE__ ).'js/magnificPopup/magnificPopup.js');
        wp_register_script( 'modeltheme-isotope', plugin_dir_url( __FILE__ ).'js/isotope/isotope.pkgd.js');
        wp_register_script( 'imagesLoaded', plugin_dir_url( __FILE__ ).'js/imagesLoaded/imagesloaded.pkgd.js');
        
        wp_register_script( 'modeltheme-masonry-gallery', plugin_dir_url( __FILE__ ).'js/masonry-gallery.js');
        
        return [ 'jquery', 'elementor-frontend', 'modeltheme-isotope','imagesLoaded',  'modeltheme-magnificpopup','modeltheme-masonry-gallery'];
    }
    public function get_name()
    {
        return 'mtap-masonry-gallery';
    }

    public function get_title()
    {
        return esc_html__('MT Masonry Gallery', 'modeltheme');
    }

    public function get_icon() {
        return 'eicon-gallery-masonry';
    }

    public function get_categories() {
        return [ 'mt-addons-premium' ];
    }

    public function get_keywords() {
        return [ 'masonry gallery', 'gallery' ];
    }

    protected function register_controls() {
        $this->all_controls();
    }

    private function all_controls() {
        $this->start_controls_section(
            'category_info',
            [
                'label'             => esc_html__('Content', 'modeltheme'),
                'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'gallery',
            array(
                'label'      => esc_html__( 'Add Gallery Images', 'modeltheme' ),
                'type'       => \Elementor\Controls_Manager::GALLERY,
                'show_label' => false,
                'dynamic'    => array(
                    'active' => true,
                ),
                'default'    => array(
                    array(
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id'  => 'default-image-id',
                    ),
                    array(
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id'  => 'default-image-id',
                    ),
                    array(
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id'  => 'default-image-id',
                    ),
                    array(
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id'  => 'default-image-id',
                    ),
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            array(
                'name'    => 'masonry_gallery_image_size',
                'exclude' => array( 'custom' ),
                'include' => array(),
                'default' => 'large',
            )
        );

        $gallery_columns = range( 1, 10 );
        $gallery_columns = array_combine( $gallery_columns, $gallery_columns );

        $this->add_responsive_control(
            'select_number_of_column',
            array(
                'label'          => esc_html__( 'Number Of Columns', 'modeltheme' ),
                'label_block'    => false,
                'type'           => \Elementor\Controls_Manager::SELECT,
                'options'        => $gallery_columns,
                'devices'        => array( 'desktop', 'tablet', 'mobile' ),
                'default'        => 4,
                'tablet_default' => 2,
                'render_type'    => 'template',
                'mobile_default' => 1,
                'selectors'      => array( '{{WRAPPER}} .mtap-masonry-gallery-item' => 'width : calc( calc( 100% / {{VALUE}} ) - calc( {{column_spacing_slider.size}}{{column_spacing_slider.unit}} * calc( {{VALUE}} - 1) / {{VALUE}} ) ) ;' ),
            )
        );

        $this->add_responsive_control(
            'column_spacing_slider',
            array(
                'label'          => esc_html__( 'Column Spacing', 'modeltheme' ),
                'type'           => \Elementor\Controls_Manager::SLIDER,
                'range'          => array(
                    'px' => array(
                        'min'  => 1,
                        'max'  => 100,
                        'step' => 1,
                    ),
                ),
                'devices'        => array( 'desktop', 'tablet', 'mobile' ),
                'default'        => array(
                    'size' => 30,
                    'unit' => 'px',
                ),
                'tablet_default' => array(
                    'size' => 20,
                    'unit' => 'px',
                ),
                'mobile_default' => array(
                    'size' => 10,
                    'unit' => 'px',
                ),
                'size_units'     => array( 'px' ),
                'selectors'      => array(
                    '{{WRAPPER}} .mtap-masonry-gallery-item_gutter ' => 'width: {{SIZE}}{{UNIT}};',
                    '{{Wrapper}} .mtap-masonry-gallery-item'    => 'margin-bottom: {{SIZE}}{{UNIT}};',

                ),
            )
        );

        $this->end_controls_section();

        // Gallery elements.
        $this->start_controls_section(
            'masonry_gallery_elements_settings',
            array(
                'label' => esc_html__( 'Elements', 'modeltheme' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'image_title_switcher',
            array(
                'label'                => esc_html__( 'Show Title', 'modeltheme' ),
                'separator'            => 'before',
                'type'                 => \Elementor\Controls_Manager::SWITCHER,
                'label_off'            => esc_html__( 'NO', 'modeltheme' ),
                'label_on'             => esc_html__( 'YES', 'modeltheme' ),
                'return_value'         => 'yes', 
                'default'              => 'no',
                'selectors_dictionary' => array(
                    'yes' => 'yes',
                    ''    => 'no',
                ),
            )
        );

        $this->add_control(
            'title_show_select',
            array(
                'label'       => esc_html__( 'Show Title in', 'modeltheme' ),
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::SELECT,
                'options'     => array(
                    'mtap-masonry-gallery-title-lightbox-only' => esc_html__( 'Lightbox', 'modeltheme' ),
                    'mtap-masonry-gallery-title-only'  => esc_html__( 'Gallery', 'modeltheme' ),
                    'mtap-masonry-gallery-title-both'          => esc_html__( 'Both', 'modeltheme' ),
                ),
                'default'     => 'mtap-masonry-gallery-title-both',
                'condition'   => array( 'image_title_switcher' => 'yes' ),
            )
        );

        $this->add_control(
            'caption_switcher',
            array(
                'label'                => esc_html__( 'Show Caption', 'modeltheme' ),
                'separator'            => 'before',
                'type'                 => \Elementor\Controls_Manager::SWITCHER,
                'label_off'            => esc_html__( 'NO', 'modeltheme' ),
                'label_on'             => esc_html__( 'YES', 'modeltheme' ),
                'return_value'         => 'yes', 
                'default'              => 'no',
                'selectors_dictionary' => array(
                    'yes' => 'yes',
                    ''    => 'no',
                ),
            )
        );

        $this->add_control(
            'caption_show_select',
            array(
                'label'       => esc_html__( 'Show Caption in', 'modeltheme' ),
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::SELECT,
                'options'     => array(
                    'mtap-masonry-gallery-lightbox-only' => esc_html__( 'Lightbox', 'modeltheme' ),
                    'mtap-masonry-gallery-caption-only'  => esc_html__( 'Gallery', 'modeltheme' ),
                    'mtap-masonry-gallery-caption-both'  => esc_html__( 'Both', 'modeltheme' ),
                ),
                'default'     => 'mtap-masonry-gallery-caption-both',
                'condition'   => array( 'caption_switcher' => 'yes' ),
            )
        );

        $this->add_control(
            'lightbox_switcher',
            array(
                'label'                => esc_html__( 'Enable Lightbox', 'modeltheme' ),
                'separator'            => 'before',
                'type'                 => \Elementor\Controls_Manager::SWITCHER,
                'label_off'            => esc_html__( 'NO', 'modeltheme' ),
                'label_on'             => esc_html__( 'YES', 'modeltheme' ),
                'default'              => 'no',
                'selectors_dictionary' => array(
                    'yes' => 'yes',
                    ''    => 'no',
                ),
            )
        );

        $this->add_control(
            'title_caption_style_select',
            array(
                'label'       => esc_html__( 'Title & Caption Style in Lightbox', 'modeltheme' ),
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::SELECT,
                'options'     => array(
                    'mtap-masonry-gallery-img-ovl' => esc_html__( 'Image Overlay', 'modeltheme' ),
                    'mtap-masonry-gallery-img-blw' => esc_html__( 'Below Image', 'modeltheme' ),
                ),
                'default'     => 'mtap-masonry-gallery-img-blw',
                'condition'   => array( 'lightbox_switcher' => 'yes' ),
            )
        );

        $this->add_control(
            'overlay_on_hover_switcher',
            array(
                'label'                => esc_html__( 'Overlay on Hover', 'modeltheme' ),
                'separator'            => 'before',
                'type'                 => \Elementor\Controls_Manager::SWITCHER,
                'label_off'            => esc_html__( 'NO', 'modeltheme' ),
                'label_on'             => esc_html__( 'YES', 'modeltheme' ),
                'return_value'         => 'yes', 
                'default'              => 'no',
                'selectors_dictionary' => array(
                    'yes' => 'yes',
                    ''    => 'no',
                ),
            )
        );

        $this->add_control(
            'overlay_icon_select',
            array(
                'label'     => esc_html__( 'Overlay Icon', 'modeltheme' ),
                'type'      => \Elementor\Controls_Manager::ICONS,
                'default'   => array(
                    'value'   => 'fas fa-image',
                    'library' => 'fa-solid',
                ),
                'condition' => array( 'overlay_on_hover_switcher' => 'yes' ),
            )
        );

        $this->end_controls_section();

        // Style tab.
        // Gallery styling.
        $this->start_controls_section(
            'gallery_styling_section',
            array(
                'label' => esc_html__( 'Gallery Styling', 'modeltheme' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            array(
                'name'     => 'image_border',
                'selector' => '{{WRAPPER}} .mtap-masonry-gallery-image-wrapper',
            )
        );

        $this->add_responsive_control(
            'gallery_image_border_radius',
            array(
                'label'      => esc_html__( 'Image Rounded Corners', 'modeltheme' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em', 'custom' ),
                'selectors'  => array(
                    '{{WRAPPER}}  .mtap-masonry-gallery-image-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'image_box_shadow',
                'selector' => '{{WRAPPER}} .mtap-masonry-gallery-image-wrapper',
            )
        );

        $this->end_controls_section();

        // Title styling.
        $this->start_controls_section(
            'title_styling_section',
            array(
                'label'     => esc_html__( 'Title', 'modeltheme' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array( 'image_title_switcher' => 'yes' ),
            )
        );

        $this->add_control(
            'title_heading_level',
            array(
                'label'       => esc_html__( 'Title Heading Level', 'modeltheme' ),
                'type'        => \Elementor\Controls_Manager::CHOOSE,
                'label_block' => true,
                'options'     =>
                array(
                    'h1' =>
                        array(
                            'title' => esc_html__( 'H1', 'modeltheme' ),
                            'icon'  => 'eicon-editor-h1',
                        ),
                    'h2' =>
                        array(
                            'title' => esc_html__( 'H2', 'modeltheme' ),
                            'icon'  => 'eicon-editor-h2',
                        ),
                    'h3' =>
                        array(
                            'title' => esc_html__( 'H3', 'modeltheme' ),
                            'icon'  => 'eicon-editor-h3',
                        ),
                    'h4' =>
                        array(
                            'title' => esc_html__( 'H4', 'modeltheme' ),
                            'icon'  => 'eicon-editor-h4',
                        ),
                    'h5' =>
                        array(
                            'title' => esc_html__( 'H5', 'modeltheme' ),
                            'icon'  => 'eicon-editor-h5',
                        ),
                    'h6' =>
                        array(
                            'title' => esc_html__( 'H6', 'modeltheme' ),
                            'icon'  => 'eicon-editor-h6',
                        ),
                ),
                'default'     => 'h4',
                'separator'   => 'before',
                'toggle'      => false,
            )
        );

        $this->start_controls_tabs(
            'title_normal_and_hover_state_control_tab'
        );

        $this->start_controls_tab(
            'title_normal_state_tab',
            array(
                'label' => esc_html__( 'Normal', 'modeltheme' ),
            )
        );

        $this->add_control(
            'title_text_color',
            array(
                'label'       => esc_html__( 'Text Color', 'modeltheme' ),
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'default'     => '#222',
                'selectors'   => array( '{{WRAPPER}} .mtap-masonry-gallery-item_title' => 'color: {{VALUE}};' ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'label'       => esc_html__( 'Title Typography', 'modeltheme' ),
                'label_block' => true,
                'name'        => 'title_text_typography',
                'selector'    => '{{WRAPPER}} .mtap-masonry-gallery-item_title',
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            array(
                'name'      => 'title_text_shadow',
                'label'     => esc_html__( 'Text Shadow', 'modeltheme' ),
                'selector'  => '{{WRAPPER}} .mtap-masonry-gallery-item_title',
                'separator' => 'before',
            )
        );

        $this->end_controls_tab();

        // Tab 2.
        $this->start_controls_tab(
            'title_hover_state_tab',
            array(
                'label' => esc_html__( 'Hover', 'modeltheme' ),
            )
        );

        // Settings for second tab.
        $this->add_control(
            'title_text_hover_state_color',
            array(
                'label'       => esc_html__( 'Title Text Color', 'modeltheme' ),
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'default'     => '',
                'selectors'   => array(
                    '{{WRAPPER}} .mtap-masonry-gallery-item_title:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'label'       => esc_html__( 'Title Typography', 'modeltheme' ),
                'label_block' => true,
                'name'        => 'title_text_hover_state_typography',
                'selector'    => '{{WRAPPER}} .mtap-masonry-gallery-item_title:hover',
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            array(
                'name'      => 'title_text_hover_state_shadow',
                'label'     => esc_html__( 'Title Text Shadow', 'modeltheme' ),
                'selector'  => '{{WRAPPER}} .mtap-masonry-gallery-item_title:hover',
                'separator' => 'before',
            )
        );

        $this->add_responsive_control(
            'title_transition_duration',
            array(
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'label'     => esc_html__( 'Transition Duration (ms) ', 'modeltheme' ),
                'range'     => array(
                    'ms' => array(
                        'min'  => 0,
                        'max'  => 10000,
                        'step' => 100,
                    ),
                ),
                'default'   => array(
                    'size' => 300,
                    'unit' => 'ms',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .mtap-masonry-gallery-item_title' => 'transition: all {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'title_text_alignment',
            array(
                'label'       => esc_html__( 'Title Alignment', 'modeltheme' ),
                'type'        => \Elementor\Controls_Manager::CHOOSE,
                'label_block' => true,
                'options'     => array(
                    'left'   => array(
                        'title' => esc_html__( 'Left', 'modeltheme' ),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'modeltheme' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right'  => array(
                        'title' => esc_html__( 'Right', 'modeltheme' ),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'default'     => is_rtl() ? 'right' : 'left',
                'toggle'      => true,
                'separator'   => 'before',
                'selectors'   => array( '{{WRAPPER}} .mtap-masonry-gallery-item_title' => 'text-align: {{VALUE}};' ),
            )
        );

        $this->add_control(
            'title_padding_margin_heading',
            array(
                'label' => esc_html__( 'Title Padding and Margin', 'modeltheme' ),
                'type'  => \Elementor\Controls_Manager::HEADING,

            )
        );

        $this->start_controls_tabs(
            'title_padding_margin_control_tabs',
        );

        // Tab 1.
        $this->start_controls_tab(
            'title_padding_tab',
            array(
                'label' => esc_html__( 'Padding', 'modeltheme' ),
            )
        );

        // Settings for first tab.
        $this->add_responsive_control(
            'title_padding',
            array(
                'label'      => esc_html__( 'Padding', 'modeltheme' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'default'    => array(
                    'top'    => 5,
                    'right'  => 5,
                    'bottom' => 5,
                    'left'   => 5,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .mtap-masonry-gallery-item_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_tab();

        // Tab 2.
        $this->start_controls_tab(
            'title_margin_tab',
            array(
                'label' => esc_html__( 'Margin', 'modeltheme' ),
            )
        );

        // Settings for second tab.
        $this->add_responsive_control(
            'title_margin',
            array(
                'label'      => esc_html__( 'Margin', 'modeltheme' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'default'    => array(
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .mtap-masonry-gallery-item_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // Caption styling.
        $this->start_controls_section(
            'caption_styling_section',
            array(
                'label'     => esc_html__( 'Caption', 'modeltheme' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array( 'caption_switcher' => 'yes' ),
            )
        );

        $this->start_controls_tabs(
            'caption_normal_and_hover_state_control_tab'
        );

        // Tab 1.
        $this->start_controls_tab(
            'caption_normal_state_tab',
            array(
                'label' => esc_html__( 'Normal', 'modeltheme' ),
            )
        );

        // Settings for FIRST tab.
        $this->add_control(
            'caption_text_color',
            array(
                'label'       => esc_html__( 'Caption Text Color', 'modeltheme' ),
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'default'     => '#222',
                'selectors'   => array( '{{WRAPPER}} .mtap-masonry-gallery-item_caption' => 'color:{{VALUE}};' ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'label'       => esc_html__( 'Caption Typography', 'modeltheme' ),
                'label_block' => true,
                'name'        => 'caption_text_typography',
                'selector'    => '{{WRAPPER}} .mtap-masonry-gallery-item_caption',
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            array(
                'name'      => 'caption_text_shadow',
                'label'     => esc_html__( 'Caption Text Shadow', 'modeltheme' ),
                'selector'  => '{{WRAPPER}} .mtap-masonry-gallery-item_caption',
                'separator' => 'before',
            )
        );

        $this->end_controls_tab();

        // Tab 2.
        $this->start_controls_tab(
            'caption_hover_state_tab',
            array(
                'label' => esc_html__( 'Hover', 'modeltheme' ),
            )
        );

        // Settings for second tab.
        $this->add_control(
            'caption_text_hover_state_color',
            array(
                'label'       => esc_html__( 'Caption Text Color', 'modeltheme' ),
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'default'     => '',
                'selectors'   => array(
                    '{{WRAPPER}} .mtap-masonry-gallery-item_caption:hover' => 'color:{{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'label'       => esc_html__( 'Caption Typography', 'modeltheme' ),
                'label_block' => true,
                'name'        => 'caption_text_hover_state_typography',
                'selector'    => '{{WRAPPER}} .mtap-masonry-gallery-item_caption:hover',
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            array(
                'name'      => 'caption_text_hover_state_shadow',
                'label'     => esc_html__( 'Caption Text Shadow', 'modeltheme' ),
                'selector'  => '{{WRAPPER}} .mtap-masonry-gallery-item_caption:hover',
                'separator' => 'before',
            )
        );

        $this->add_responsive_control(
            'caption_transition_duration',
            array(
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'label'     => esc_html__( 'Transition Duration (ms) ', 'modeltheme' ),
                'range'     => array(
                    'ms' => array(
                        'min'  => 0,
                        'max'  => 10000,
                        'step' => 100,
                    ),
                ),
                'default'   => array(
                    'size' => 300,
                    'unit' => 'ms',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .mtap-masonry-gallery-item_caption' => 'transition: all {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'caption_text_alignment',
            array(
                'label'       => esc_html__( 'Caption Alignment', 'modeltheme' ),
                'type'        => \Elementor\Controls_Manager::CHOOSE,
                'label_block' => true,
                'options'     => array(
                    'left'   => array(
                        'caption' => esc_html__( 'Left', 'modeltheme' ),
                        'icon'    => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'caption' => esc_html__( 'Center', 'modeltheme' ),
                        'icon'    => 'eicon-text-align-center',
                    ),
                    'right'  => array(
                        'caption' => esc_html__( 'Right', 'modeltheme' ),
                        'icon'    => 'eicon-text-align-right',
                    ),
                ),
                'default'     => is_rtl() ? 'right' : 'left',
                'toggle'      => true,
                'separator'   => 'before',
                'selectors'   => array( '{{WRAPPER}} .mtap-masonry-gallery-item_caption' => 'text-align: {{VALUE}};' ),
            )
        );

        $this->add_control(
            'caption_padding_margin_heading',
            array(
                'label' => esc_html__( 'Caption Padding and Margin', 'modeltheme' ),
                'type'  => \Elementor\Controls_Manager::HEADING,

            )
        );

        $this->start_controls_tabs(
            'caption_padding_margin_control_tabs',
        );

        // Tab 1.
        $this->start_controls_tab(
            'caption_padding_tab',
            array(
                'label' => esc_html__( 'Padding', 'modeltheme' ),
            )
        );

        $this->add_responsive_control(
            'caption_padding',
            array(
                'label'      => esc_html__( 'Padding', 'modeltheme' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'default'    => array(
                    'top'    => 5,
                    'right'  => 5,
                    'bottom' => 5,
                    'left'   => 5,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .mtap-masonry-gallery-item_caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'caption_margin_tab',
            array(
                'label' => esc_html__( 'Margin', 'modeltheme' ),
            ),
        );

        $this->add_responsive_control(
            'caption_margin',
            array(
                'label'      => esc_html__( 'Margin', 'modeltheme' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'default'    => array(
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .mtap-masonry-gallery-item_caption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'lightbox_styling_section',
            array(
                'label'     => esc_html__( 'Lightbox', 'modeltheme' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array( 'lightbox_switcher!' => '' ),
            )
        );

        $this->add_control(
            'lightbox_background_color',
            array(
                'label'       => esc_html__( 'Lightbox Background Color', 'modeltheme' ),
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'default'     => '#0000006E',
                'selectors'   => array(
                    '{{WRAPPER}}.mfp-wrap' => 'background-color:{{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'exit_icon_color',
            array(
                'label'       => esc_html__( 'Exit Icon Color', 'modeltheme' ),
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'default'     => '#ffffff',
                'selectors'   => array(
                    '{{WRAPPER}} .mfp-close' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'arrows_color',
            array(
                'label'       => esc_html__( 'Arrow Color', 'modeltheme' ),
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'default'     => '#ffffff',
                'selectors'   => array(
                    '{{WRAPPER}} .mfp-arrow.mfp-arrow-right:after' => 'border-left-color: {{VALUE}};',
                    '{{WRAPPER}} .mfp-arrow.mfp-arrow-left:after' => 'border-right-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'arrow_border_color',
            array(
                'label'       => esc_html__( 'Arrow Border Color', 'modeltheme' ),
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'default'     => '#FFFFFF75',
                'selectors'   => array(
                    '{{WRAPPER}}.mtap-masonry-gallery-lightbox .mfp-arrow-left::before' => 'border-right-color: {{VALUE}};',
                    '{{WRAPPER}}.mtap-masonry-gallery-lightbox .mfp-arrow-right::before' => 'border-left-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'title_and_caption_color',
            array(
                'label'       => esc_html__( 'Title & Caption Background Color', 'modeltheme' ),
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'default'     => '#FFFFFF75',
                'selectors'   => array(
                    '{{WRAPPER}} .mfp-title > .mtap-masonry-gallery-item_title , {{WRAPPER}} .mfp-title > .mtap-masonry-gallery-item_caption , {{WRAPPER}} .mfp-title' => 'background-color: {{VALUE}}; padding-right:0;',
                ),
            )
        );

        $this->end_controls_section();

        // Overlay styling.
        $this->start_controls_section(
            'overlay_styling_section',
            array(
                'label'     => esc_html__( 'Overlay', 'modeltheme' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array( 'overlay_on_hover_switcher' => 'yes' ),
            )
        );

        $this->add_responsive_control(
            'overlay_icon_size_slider',
            array(
                'label'      => esc_html__( 'Icon Size', 'modeltheme' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'range'      => array(
                    'px' => array(
                        'min'  => 0,
                        'max'  => 200,
                        'step' => 1,
                    ),
                    '%'  => array(
                        'min' => 0,
                        'max' => 200,
                    ),
                    'vw' => array(
                        'min' => 0,
                        'max' => 200,
                    ),
                    'vh' => array(
                        'min' => 0,
                        'max' => 200,
                    ),
                ),
                'default'    => array(
                    'size' => '20',
                ),
                'size_units' => array( 'px', '%', 'vw', 'vh' ),
                'selectors'  => array(
                    '{{WRAPPER}} .mtap-masonry-gallery-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mtap-masonry-gallery-image-wrapper svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'overlay_icon_color',
            array(
                'label'       => esc_html__( 'Overlay Icon Color', 'modeltheme' ),
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'default'     => '#ffffff',
                'selectors'   => array(
                    '{{WRAPPER}} .mtap-masonry-gallery-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mtap-masonry-gallery-image-wrapper svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'image_overlay_color',
            array(
                'label'       => esc_html__( 'Overlay Background Color', 'modeltheme' ),
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'default'     => '#0000006E',
                'selectors'   => array(
                    '{{WRAPPER}} .mtap-masonry-gallery-image-wrapper::before' => 'background-color: {{VALUE}};',
                ),
            )
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings           = $this->get_settings_for_display();
        $enable_lightbox                  = $settings['lightbox_switcher'];
        $gallery_items                    = is_array( $settings['gallery'] ) ? $settings['gallery'] : array();
        $enable_overlay                   = $settings['overlay_on_hover_switcher'];
        $show_title                       = $settings['image_title_switcher'];
        $title_area                       = $settings['title_show_select'];
        $show_caption                     = $settings['caption_switcher'];
        $caption_area                     = $settings['caption_show_select'];
        $lightbox_title_and_caption_style = $settings['title_caption_style_select'];
        $title_level                      = $settings['title_heading_level'];
        $column_count                     = $settings['select_number_of_column'];
        $column_spacing                   = $settings ['column_spacing_slider']['size'] . $settings ['column_spacing_slider']['unit'];
        $gallery_images                   = '';
        $overlay_output                   = '';
        $image_title                      = '';
        $image_caption                    = '';
        $title_caption_wrapper            = '';


        // Declaring classes and other attributes.
        $this->add_render_attribute( 'image_caption', 'class', array( 'mtap-masonry-gallery-item_caption', $caption_area ) );
        $this->add_render_attribute( 'image_title', 'class', array( 'mtap-masonry-gallery-item_title', $title_area ) );
        $this->add_render_attribute( 'image_wrapper', 'class', 'mtap-masonry-gallery-image-wrapper' );
        $this->add_render_attribute( 'gallery_item_with_lightbox', 'class', array( 'mtap-masonry-gallery-item', 'mtap-masonry-gallery-item-with-lightbox' ) );
        $this->add_render_attribute( 'gallery_item_no_lightbox', 'class', 'mtap-masonry-gallery-item' );
        $this->add_render_attribute( 'gallery_wrapper', 'class', 'mtap-masonry-gallery-wrapper' );
        $this->add_render_attribute( 'gallery_item_gutter', 'class', 'mtap-masonry-gallery-item_gutter' );
        $this->add_render_attribute( 'title_caption_wrapper', 'class', array( 'mtap-masonry-gallery-title-caption-wrapper', $lightbox_title_and_caption_style ) );

        $gutter = absint( $settings ['column_spacing_slider']['size'] );

        $item_width_percentage = 100 / $column_count;
        $item_width_spacing    = $gutter * ( $column_count - 1 ) / $column_count;

        // Massonry gallery item width.
        $item_width = 'calc( ' . $item_width_percentage . '%% - ' . $item_width_spacing . $column_spacing . ' )';

        ?>

        <div <?php $this->print_render_attribute_string( 'gallery_wrapper' ); ?>  data-post_id="<?php echo absint( get_the_id() ); ?> ">
        <div <?php $this->print_render_attribute_string( 'gallery_item_gutter' ); ?> ></div>
            <?php foreach ( $gallery_items as $items ) {
                // Masonry gallery image title.
                if ( '' !== get_the_title( $items['id'] ) && 'yes' === $show_title && 'default-image-id' !== $items['id'] ) {
                    $image_title = '<' . $title_level . ' ' . $this->get_render_attribute_string( 'image_title' ) . '>' . get_the_title( $items['id'] ) . '</' . $title_level . '>';
                } else {
                    $image_title = '';
                }
                if ( '' !== wp_get_attachment_caption( $items['id'] ) && 'yes' === $show_caption && 'default-image-id' !== $items['id'] ) {
                    $image_caption = '<p ' . $this->get_render_attribute_string( 'image_caption' ) . '>' . wp_get_attachment_caption( $items['id'] ) . '</p>';
                } else {
                    $image_caption = '';
                }

                if ( 'yes' === $enable_lightbox ) {
                    ?>
                        <div <?php $this->print_render_attribute_string( 'gallery_item_with_lightbox' ); ?> data-mfp-src="<?php echo esc_url( $items['url'] ); ?> ">
                            <div <?php $this->print_render_attribute_string( 'image_wrapper' ); ?>  >
                            <?php
                            if ( 'default-image-id' === $items['id'] ) {
                                ?>
                                    <img src="<?php echo esc_url( \Elementor\Utils::get_placeholder_image_src() ); ?>" >
                                <?php
                            } else {
                                echo wp_get_attachment_image( $items['id'], $settings['masonry_gallery_image_size_size'], false, array( 'loading' => 'eager' ) );
                            }
                            ?>
                            <?php if ( isset( $settings['overlay_icon_select']['value'] ) && 'yes' === $enable_overlay ) { ?>
                                   <span class="mtap-masonry-gallery-icon">
                                        <?php \Elementor\Icons_Manager::render_icon( $settings['overlay_icon_select'], [ 'aria-hidden' => 'true' ] ); ?>
                                    </span>
                            <?php } ?>
                            </div>
                            <?php
                            if ( '' !== $image_title || '' !== $image_caption ) {
                                ?>
                                    <div <?php $this->print_render_attribute_string( 'title_caption_wrapper' ); ?> >
                                        <?php echo wp_kses_post( $image_title ); ?> 
                                        <?php echo wp_kses_post( $image_caption ); ?> 
                                    </div>
                                <?php
                            } else {
                                $title_caption_wrapper = '';
                            }
                            ?>
                        </div>
                    <?php
                } else {
                    ?>
                        <div <?php $this->print_render_attribute_string( 'gallery_item_no_lightbox' ); ?> >
                            <div <?php $this->print_render_attribute_string( 'image_wrapper' ); ?> >
                        <?php
                        if ( 'default-image-id' === $items['id'] ) {
                            ?>
                            <img src=" <?php echo esc_url( \Elementor\Utils::get_placeholder_image_src() ); ?> " >
                            <?php
                        } else {
                            echo wp_get_attachment_image( $items['id'], $settings['masonry_gallery_image_size_size'], false, array( 'loading' => 'eager' ) );
                        }
                        ?>
                            <?php echo 'yes' === $enable_overlay ? wp_kses_post( $overlay_output ) : ''; ?>
                            </div>
                            <?php
                            if ( '' !== $image_title || '' !== $image_caption ) {
                                ?>
                                    <div <?php $this->print_render_attribute_string( 'title_caption_wrapper' ); ?> >
                                        <?php echo wp_kses_post( $image_title ); ?> 
                                        <?php echo wp_kses_post( $image_caption ); ?> 
                                    </div>
                                <?php
                            } else {
                                $title_caption_wrapper = '';
                            }
                            ?>
                        </div>
                    <?php
                }
            }?>
        </div>
        <?php
        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
            ?>
                <script type="text/javascript">
                    jQuery( '.mtap-masonry-gallery-wrapper' ).isotope({
                        itemSelector: '.mtap-masonry-gallery-item',
                        layoutMode: 'masonry',
                        percentPosition: true,
                        resize: true,
                        masonry: {
                            columnWidth: '.mtap-masonry-gallery-item',
                            gutter: '.mtap-masonry-gallery-item_gutter'
                        }
                    });
                    jQuery( '.mtap-masonry-gallery-wrapper' ).imagesLoaded( { background: '.mtap-masonry-gallery-image-wrapper' } ).progress( function() {
                        jQuery( '.mtap-masonry-gallery-wrapper ' ).isotope( 'layout' );
                        jQuery( '.mtap-masonry-gallery-wrapper ' ).isotope( 'reloadItems' );
                    });

                </script>
            <?php
        }
    }

    protected function content_template() {}
}


