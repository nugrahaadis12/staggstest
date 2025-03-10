<?php
/**
 * Content Control Trait
 *
 * @package MT_Addons_Slider
 */
namespace MT_Addons\includes;

use MT_Addons\includes\MT_Addons_Slider_Helper;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

trait MT_Addons_ContentControl {
    /**
     * Slider Settings
     *
     * @return void
     */
    private function section_slider_settings() {

        $this->start_controls_section(
            'section_slider_settings',
            [
                'label' => esc_html__( 'Slider Settings', 'mt-addons' ),
            ]
        );

        $this->add_control(
            'fullscreen',
            [
                'label'   => esc_html__( 'Fullscreen', 'mt-addons' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'fullscreen' => esc_html__( 'Enable', 'mt-addons' ),
                    'custom'     => esc_html__( 'Disable', 'mt-addons' ),
                ],
                'default' => 'custom',
            ]
        );

        $this->add_responsive_control(
            'slider_height',
            [
                'label'           => esc_html__( 'Slider Height', 'mt-addons' ),
                'type'            => Controls_Manager::SLIDER,
                'range'           => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                ],
                'desktop_default' => [
                    'size' => 650,
                    'unit' => 'px',
                ],
                'tablet_default'  => [
                    'size' => 580,
                    'unit' => 'px',
                ],
                'mobile_default'  => [
                    'size' => 480,
                    'unit' => 'px',
                ],
                'selectors'       => [
                    '{{WRAPPER}} .mt-slider.custom .swiper-slide'        => 'min-height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mt-slider.custom .slider-content-wrap' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mt-slider.custom.swiper-container'     => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition'       => [
                    'fullscreen' => 'custom',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_container_width',
            [
                'label'           => esc_html__( 'Content Container Width', 'mt-addons' ),
                'type'            => Controls_Manager::SLIDER,
                'size_units'      => ['px', '%'],
                'range'           => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 3000,
                        'step' => 5,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'desktop_default' => [
                    'size' => 1140,
                    'unit' => 'px',
                ],
                'tablet_default'  => [
                    'size' => 95,
                    'unit' => '%',
                ],
                'mobile_default'  => [
                    'size' => 95,
                    'unit' => '%',
                ],
                'selectors'       => [
                    '{{WRAPPER}} .content-width'      => 'max-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mt-slider-controls' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'              => esc_html__( 'Content Padding', 'mt-addons' ),
                'type'               => Controls_Manager::DIMENSIONS,
                'size_units'         => ['px', '%', 'em'],
                'allowed_dimensions' => 'horizontal',
                'default'            => [
                    'left'  => [
                        'size' => 30,
                        'unit' => 'px',
                    ],
                    'right' => [
                        'size' => 30,
                        'unit' => 'px',
                    ],
                ],
                'selectors'          => [
                    '{{WRAPPER}} .content-width' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Slides Controls
     *
     * @return void
     */
    private function section_slides() {
        $this->start_controls_section(
            'section_slider_slides',
            [
                'label' => esc_html__( 'Slides', 'mt-addons' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'text_masking',
            [
                'label'        => esc_html__( 'Text Masking', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'    => esc_html__( 'No', 'mt-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $repeater->add_responsive_control(
            'content_align',
            [
                'label'   => esc_html__( 'Alignment', 'mt-addons' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'mt-addons' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'mt-addons' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'mt-addons' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle'  => false,
            ]
        );

        $repeater->add_responsive_control(
            'content_right_width',
            [
                'label'      => esc_html__( 'Content Width', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 5,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .text-right .slider-content' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'content_align' => 'right',
                ],
            ]
        );

        $repeater->add_control(
            'slider_shape',
            [
                'label'        => esc_html__( 'Shape', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'mt-addons' ),
                'label_off'    => esc_html__( 'Hide', 'mt-addons' ),
                'return_value' => 'yes',
            ]
        );

        $repeater->add_control(
            'shape_style',
            [
                'label'     => esc_html__( 'Shape Style', 'mt-addons' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'angle_shape',
                'options'   => [
                    'angle_shape'  => esc_html__( 'Angle Shape', 'mt-addons' ),
                    'border_shape' => esc_html__( 'Border Shape', 'mt-addons' ),
                ],
                'condition' => [
                    'slider_shape'  => 'yes',
                    'content_align' => 'left',
                ],
            ]
        );

        $repeater->add_control(
            'popover_angle_shape',
            [
                'label'        => esc_html__( 'Angle Shape Settings', 'mt-addons' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => esc_html__( 'Default', 'mt-addons' ),
                'label_on'     => esc_html__( 'Custom', 'mt-addons' ),
                'return_value' => 'yes',
                'condition'    => [
                    'slider_shape'  => 'yes',
                    'shape_style'   => 'angle_shape',
                    'content_align' => 'left',
                ],
            ]
        );

        $repeater->start_popover();

        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'shape_color',
                'label'     => esc_html__( 'Background', 'mt-addons' ),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}} .slider-layer',
                'condition' => [
                    'slider_shape'  => 'yes',
                    'shape_style'   => 'angle_shape',
                    'content_align' => 'left',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'slider_shape_width',
            [
                'label'      => esc_html__( 'Width', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 5,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slider-layer' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_shape'  => 'yes',
                    'shape_style'   => 'angle_shape',
                    'content_align' => 'left',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'slider_shape_angle',
            [
                'label'      => esc_html__( 'Shape Angle', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range'      => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 80,
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slider-layer'                       => 'clip-path: polygon(0 0,{{SIZE}}{{UNIT}} 0%, 100% 100%, 0 100%);',
                    '{{WRAPPER}} .swiper-container-rtl {{CURRENT_ITEM}} .slider-layer' => 'clip-path: polygon(calc(100% - {{SIZE}}{{UNIT}}) 0,100% 0%, 100% 100%, 0 100%);',
                ],
                'condition'  => [
                    'slider_shape'  => 'yes',
                    'shape_style'   => 'angle_shape',
                    'content_align' => 'left',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'slider_shape_opacity',
            [
                'label'      => esc_html__( 'Shape Opacity', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slider-layer' => 'opacity: {{SIZE}};',
                ],
                'condition'  => [
                    'slider_shape'  => 'yes',
                    'shape_style'   => 'angle_shape',
                    'content_align' => 'left',
                ],
            ]
        );

        $repeater->add_control(
            'shape_animation',
            [
                'label'     => esc_html__( 'Animation', 'mt-addons' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'mt-fadeInLeft',
                'options'   => MT_Addons_Slider_Helper::get_animation_effects( ['clip-text', 'reveal-text', 'char-top', 'char-right', 'char-bottom', 'char-expand'] ),
                'condition' => [
                    'slider_shape'  => 'yes',
                    'shape_style'   => 'angle_shape',
                    'content_align' => 'left',
                ],
            ]
        );

        $repeater->add_control(
            'shape_anim_delay',
            [
                'label'      => esc_html__( 'Delay', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 5000,
                        'step' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
                'condition'  => [
                    'slider_shape'     => 'yes',
                    'shape_style'      => 'angle_shape',
                    'content_align'    => 'left',
                    'shape_animation!' => 'none',
                ],
            ]
        );

        $repeater->add_control(
            'shape_anim_duration',
            [
                'label'      => esc_html__( 'Duration', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 5000,
                        'step' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
                'condition'  => [
                    'slider_shape'     => 'yes',
                    'shape_style'      => 'angle_shape',
                    'content_align'    => 'left',
                    'shape_animation!' => 'none',
                ],
            ]
        );

        $repeater->end_popover();

        $repeater->add_control(
            'popover_border_shape',
            [
                'label'        => esc_html__( 'Border Shape Settings', 'mt-addons' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => esc_html__( 'Default', 'mt-addons' ),
                'label_on'     => esc_html__( 'Custom', 'mt-addons' ),
                'return_value' => 'yes',
                'condition'    => [
                    'slider_shape'  => 'yes',
                    'shape_style'   => 'border_shape',
                    'content_align' => 'left',
                ],
            ]
        );

        $repeater->start_popover();

        $repeater->add_control(
            'border_shape_color',
            [
                'label'     => esc_html__( 'Border Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .border-layers span' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'slider_shape'  => 'yes',
                    'shape_style'   => 'border_shape',
                    'content_align' => 'left',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'border_shape_bd_size',
            [
                'label'      => esc_html__( 'Border Size', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 50,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .border-layers span:nth-child(2), {{WRAPPER}} {{CURRENT_ITEM}} .border-layers span:nth-child(4)' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .border-layers span:nth-child(1), {{WRAPPER}} {{CURRENT_ITEM}} .border-layers span:nth-child(3)' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_shape'  => 'yes',
                    'shape_style'   => 'border_shape',
                    'content_align' => 'left',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'border_shape_width',
            [
                'label'      => esc_html__( 'Width', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 5,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .border-layers' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_shape'  => 'yes',
                    'shape_style'   => 'border_shape',
                    'content_align' => 'left',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'border_shape_height',
            [
                'label'      => esc_html__( 'Height', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 5,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}}  {{CURRENT_ITEM}} .border-layers' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_shape'  => 'yes',
                    'shape_style'   => 'border_shape',
                    'content_align' => 'left',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'border_shape_x_pos',
            [
                'label'      => esc_html__( 'X Position', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => -2000,
                        'max'  => 2000,
                        'step' => 5,
                    ],
                    '%'  => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}}  {{CURRENT_ITEM}} .border-layers' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_shape'  => 'yes',
                    'shape_style'   => 'border_shape',
                    'content_align' => 'left',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'border_shape_y_pos',
            [
                'label'      => esc_html__( 'Y Position', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => -2000,
                        'max'  => 2000,
                        'step' => 5,
                    ],
                    '%'  => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .border-layers' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_shape'  => 'yes',
                    'shape_style'   => 'border_shape',
                    'content_align' => 'left',
                ],
            ]
        );

        $repeater->end_popover();

        $repeater->add_control(
            'slider_shape_blend_mode',
            [
                'label'     => esc_html__( 'Shape Blend Mode', 'mt-addons' ),
                'type'      => Controls_Manager::SELECT,
                'separator' => 'none',
                'options'   => [
                    'inherit'     => 'Normal',
                    'multiply'    => 'Multiply',
                    'screen'      => 'Screen',
                    'overlay'     => 'Overlay',
                    'darken'      => 'Darken',
                    'lighten'     => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation'  => 'Saturation',
                    'color'       => 'Color',
                    'difference'  => 'Difference',
                    'exclusion'   => 'Exclusion',
                    'hue'         => 'Hue',
                    'luminosity'  => 'Luminosity',
                ],
                'default'   => 'inherit',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .border-layers' => 'mix-blend-mode: {{VALUE}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slider-layer'  => 'mix-blend-mode: {{VALUE}}',
                ],
                'condition' => [
                    'slider_shape' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'bg_img_heading',
            [
                'label'     => esc_html__( 'Slider Background', 'mt-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'bg_type',
            [
                'label'   => esc_html__( 'Type', 'mt-addons' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'color'    => [
                        'title' => esc_html__( 'Color', 'mt-addons' ),
                        'icon'  => 'eicon-global-colors',
                    ],
                    'image'    => [
                        'title' => esc_html__( 'Image', 'mt-addons' ),
                        'icon'  => 'eicon-image',
                    ],
                    'gradient' => [
                        'title' => esc_html__( 'Gradient', 'mt-addons' ),
                        'icon'  => 'eicon-barcode',
                    ],
                ],
                'default' => 'image',
                'toggle'  => false,
            ]
        );

        $repeater->add_control(
            'slide_color_bg',
            [
                'label'     => esc_html__( 'Background Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slide-img-wrap' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'bg_type' => 'color',
                ],
            ]
        );

        $repeater->add_control(
            'slide_image',
            [
                'label'     => esc_html__( 'Choose Slide Image', 'mt-addons' ),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'bg_type' => 'image',
                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'        => 'slide_gradient_bg',
                'label'       => esc_html__( 'Gradient', 'mt-addons' ),
                'description' => esc_html__( 'Create gradient background using this control.', 'mt-addons' ),
                'types'       => ['gradient'],
                'selector'    => '{{WRAPPER}} {{CURRENT_ITEM}} .slide-img-wrap',
                'condition'   => [
                    'bg_type' => 'gradient',
                ],
            ]
        );

        $repeater->add_control(
            'kenburns_effect',
            [
                'label'     => esc_html__( 'Kenburns Effect', 'mt-addons' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'none',
                'options'   => MT_Addons_Slider_Helper::get_kenburns_effects(),
                'separator' => 'before',
                'condition' => [
                    'bg_type' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'kenburns_duration',
            [
                'label'       => esc_html__( 'Kenburns Duration', 'mt-addons' ),
                'description' => esc_html__( 'Duration calculate in milliseconds(ms).', 'mt-addons' ),
                'type'        => Controls_Manager::NUMBER,
                'min'         => 100,
                'max'         => 30000,
                'step'        => 100,
                'default'     => 12000,
                'condition'   => [
                    'bg_type'          => 'image',
                    'kenburns_effect!' => 'none',
                ],
            ]
        );

        $repeater->add_control(
            'slide_overlay',
            [
                'label'     => esc_html__( 'Overlay', 'mt-addons' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'separator' => 'before',
            ]
        );

        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'slide_ov_background',
                'label'     => esc_html__( 'Background', 'mt-addons' ),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}} .overlay',
                'condition' => [
                    'slide_overlay' => 'yes',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'slide_ov_opacity',
            [
                'label'      => esc_html__( 'Opacity', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1,
                        'step' => 0.1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .overlay' => 'opacity: {{SIZE}};',
                ],
                'condition'  => [
                    'slide_overlay' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'slider_bg_ov_blend_mode',
            [
                'label'     => esc_html__( 'Overlay Blend Mode', 'mt-addons' ),
                'type'      => Controls_Manager::SELECT,
                'separator' => 'none',
                'options'   => [
                    'inherit'     => 'Normal',
                    'multiply'    => 'Multiply',
                    'screen'      => 'Screen',
                    'overlay'     => 'Overlay',
                    'darken'      => 'Darken',
                    'lighten'     => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation'  => 'Saturation',
                    'color'       => 'Color',
                    'difference'  => 'Difference',
                    'exclusion'   => 'Exclusion',
                    'hue'         => 'Hue',
                    'luminosity'  => 'Luminosity',
                ],
                'default'   => 'inherit',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .overlay' => 'mix-blend-mode: {{VALUE}}',
                ],
                'condition' => [
                    'slide_overlay' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'subheading_heading',
            [
                'label'     => esc_html__( 'Sub Heading', 'mt-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->start_controls_tabs( 'subheading_tabs' );

        $repeater->start_controls_tab(
            'subheading_tab',
            [
                'label' => esc_html__( 'Text', 'mt-addons' ),
            ]
        );

        $repeater->add_control(
            'sub_heading', [
                'label'       => '',
                'placeholder' => esc_html__( 'Sub heading goes here...', 'mt-addons' ),
                'description' => esc_html__( 'Use mark tag for highlighted/dual color text. Example: <mark>Your Text</mark>.', 'mt-addons' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'rows'        => 4,
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'subheading_tab_anim',
            [
                'label' => esc_html__( 'Animation', 'mt-addons' ),
            ]
        );

        $repeater->add_control(
            'sh_animation',
            [
                'label'   => esc_html__( 'Effect', 'mt-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'mt-fadeIn',
                'options' => MT_Addons_Slider_Helper::get_animation_effects(),
            ]
        );

        $repeater->add_control(
            'sh_anim_delay',
            [
                'label'      => esc_html__( 'Delay', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 5000,
                        'step' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'sh_animation',
                            'operator' => '!in',
                            'value'    => ['none', 'char-top', 'char-right', 'char-bottom', 'char-expand'],
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'sh_anim_duration',
            [
                'label'      => esc_html__( 'Duration', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 5000,
                        'step' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'sh_animation',
                            'operator' => '!in',
                            'value'    => ['none', 'char-top', 'char-right', 'char-bottom', 'char-expand'],
                        ],
                    ],
                ],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $repeater->add_control(
            'heading_sec',
            [
                'label'     => esc_html__( 'Heading', 'mt-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->start_controls_tabs( 'heading_tabs' );

        $repeater->start_controls_tab(
            'heading_tab',
            [
                'label' => esc_html__( 'Text', 'mt-addons' ),
            ]
        );

        $repeater->add_control(
            'heading', [
                'label'       => '',
                'placeholder' => esc_html__( 'Heading goes here...', 'mt-addons' ),
                'description' => esc_html__( 'Seperate the line using comma. Use mark tag for highlighted/dual color text. Example: <mark>Your Text</mark>.', 'mt-addons' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'rows'        => 4,
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'heading_tab_anim',
            [
                'label' => esc_html__( 'Animation', 'mt-addons' ),
            ]
        );

        $repeater->add_control(
            'h_animation',
            [
                'label'   => esc_html__( 'Effect', 'mt-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'mt-fadeIn',
                'options' => MT_Addons_Slider_Helper::get_animation_effects(),
            ]
        );

        $repeater->add_control(
            'h_anim_delay',
            [
                'label'      => esc_html__( 'Delay', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 5000,
                        'step' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'h_animation',
                            'operator' => '!in',
                            'value'    => ['none', 'char-top', 'char-right', 'char-bottom', 'char-expand'],
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'h_anim_duration',
            [
                'label'      => esc_html__( 'Duration', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 5000,
                        'step' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'h_animation',
                            'operator' => '!in',
                            'value'    => ['none', 'char-top', 'char-right', 'char-bottom', 'char-expand'],
                        ],
                    ],
                ],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $repeater->add_control(
            'desc_heading',
            [
                'label'     => esc_html__( 'Description', 'mt-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->start_controls_tabs( 'desc_tabs' );

        $repeater->start_controls_tab(
            'desc_tab',
            [
                'label' => esc_html__( 'Text', 'mt-addons' ),
            ]
        );

        $repeater->add_control(
            'desc', [
                'label'       => '',
                'placeholder' => esc_html__( 'Desctiption goes here...', 'mt-addons' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'rows'        => 4,
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'desc_tab_anim',
            [
                'label' => esc_html__( 'Animation', 'mt-addons' ),
            ]
        );

        $repeater->add_control(
            'd_animation',
            [
                'label'   => esc_html__( 'Effect', 'mt-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'mt-fadeIn',
                'options' => MT_Addons_Slider_Helper::get_animation_effects(),
            ]
        );

        $repeater->add_control(
            'd_anim_delay',
            [
                'label'      => esc_html__( 'Delay', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 5000,
                        'step' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'd_animation',
                            'operator' => '!in',
                            'value'    => ['none', 'char-top', 'char-right', 'char-bottom', 'char-expand'],
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'd_anim_duration',
            [
                'label'      => esc_html__( 'Duration', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 5000,
                        'step' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'd_animation',
                            'operator' => '!in',
                            'value'    => ['none', 'char-top', 'char-right', 'char-bottom', 'char-expand'],
                        ],
                    ],
                ],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $repeater->add_control(
            'btn_caption_heading',
            [
                'label'     => esc_html__( 'Button', 'mt-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->start_controls_tabs( 'btn_caption_tabs' );

        $repeater->start_controls_tab(
            'btn_caption_tab',
            [
                'label' => esc_html__( 'Button', 'mt-addons' ),
            ]
        );

        $repeater->add_control(
            'btn_label', [
                'label'       => esc_html__( 'Label', 'mt-addons' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Learn More', 'mt-addons' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'btn_url',
            [
                'label'         => esc_html__( 'Link', 'mt-addons' ),
                'type'          => Controls_Manager::URL,
                'placeholder'   => esc_html__( 'https://your-link.com', 'mt-addons' ),
                'show_external' => false,
            ]
        );

        $repeater->add_control(
            'btn_icon',
            [
                'label'                  => esc_html__( 'Button Icon', 'text-domain' ),
                'description'            => esc_html__( 'Choose a icon using this icon control.', 'text-domain' ),
                'type'                   => Controls_Manager::ICONS,
                'skin'                   => 'inline',
                'exclude_inline_options' => 'svg',
                'default'                => [
                    'value'   => 'fas fa-chevron-right',
                    'library' => 'solid',
                ],
            ]
        );

        $repeater->add_control(
            'btn_icon_position',
            [
                'label'                => esc_html__( 'Icon Position', 'mt-addons' ),
                'type'                 => Controls_Manager::CHOOSE,
                'options'              => [
                    'left'  => [
                        'title' => esc_html__( 'Left', 'mt-addons' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'mt-addons' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'              => 'right',
                'selectors_dictionary' => [
                    'left'  => 'flex-flow: row-reverse',
                    'right' => 'flex-flow: inherit',
                ],
                'toggle'               => false,
                'selectors'            => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slider-btn' => '{{VALUE}}',
                ],
                'condition'            => [
                    'btn_icon!' => '',
                ],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'btn_caption_tab_anim',
            [
                'label' => esc_html__( 'Animation', 'mt-addons' ),
            ]
        );

        $repeater->add_control(
            'btn_animation',
            [
                'label'   => esc_html__( 'Effect', 'mt-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'mt-fadeIn',
                'options' => MT_Addons_Slider_Helper::get_animation_effects(),
            ]
        );

        $repeater->add_control(
            'btn_anim_delay',
            [
                'label'      => esc_html__( 'Delay', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 5000,
                        'step' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'btn_animation',
                            'operator' => '!in',
                            'value'    => ['none', 'char-top', 'char-right', 'char-bottom', 'char-expand'],
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'btn_anim_duration',
            [
                'label'      => esc_html__( 'Duration', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 5000,
                        'step' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'btn_animation',
                            'operator' => '!in',
                            'value'    => ['none', 'char-top', 'char-right', 'char-bottom', 'char-expand'],
                        ],
                    ],
                ],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $repeater->add_control(
            'secondary_btn_caption_heading',
            [
                'label'     => esc_html__( 'Secondary Button', 'mt-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $repeater->start_controls_tabs( 'secondary_btn_caption_tabs' );
        
        $repeater->start_controls_tab(
            'secondary_btn_caption_tab',
            [
                'label' => esc_html__( 'Button', 'mt-addons' ),
            ]
        );
        
        $repeater->add_control(
            'secondary_btn_label', [
                'label'       => esc_html__( 'Label', 'mt-addons' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Get Started', 'mt-addons' ),
                'label_block' => true,
            ]
        );
        
        $repeater->add_control(
            'secondary_btn_url',
            [
                'label'         => esc_html__( 'Link', 'mt-addons' ),
                'type'          => Controls_Manager::URL,
                'placeholder'   => esc_html__( 'https://your-link.com', 'mt-addons' ),
                'show_external' => false,
            ]
        );
        
        $repeater->add_control(
            'secondary_btn_icon',
            [
                'label'                  => esc_html__( 'Button Icon', 'text-domain' ),
                'description'            => esc_html__( 'Choose a icon using this icon control.', 'text-domain' ),
                'type'                   => Controls_Manager::ICONS,
                'skin'                   => 'inline',
                'exclude_inline_options' => 'svg',
                'default'                => [
                    'value'   => 'fas fa-chevron-right',
                    'library' => 'solid',
                ],
            ]
        );
        
        $repeater->add_control(
            'secondary_btn_icon_position',
            [
                'label'                => esc_html__( 'Icon Position', 'mt-addons' ),
                'type'                 => Controls_Manager::CHOOSE,
                'options'              => [
                    'left'  => [
                        'title' => esc_html__( 'Left', 'mt-addons' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'mt-addons' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'              => 'right',
                'selectors_dictionary' => [
                    'left'  => 'flex-flow: row-reverse',
                    'right' => 'flex-flow: inherit',
                ],
                'toggle'               => false,
                'selectors'            => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slider-secondary-btn' => '{{VALUE}}',
                ],
                'condition'            => [
                    'secondary_btn_icon!' => '',
                ],
            ]
        );
        
        $repeater->end_controls_tab();
        
        $repeater->start_controls_tab(
            'secondary_btn_caption_tab_anim',
            [
                'label' => esc_html__( 'Animation', 'mt-addons' ),
            ]
        );
        
        $repeater->add_control(
            'secondary_btn_animation',
            [
                'label'   => esc_html__( 'Effect', 'mt-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'mt-fadeIn',
                'options' => MT_Addons_Slider_Helper::get_animation_effects(),
            ]
        );
        
        $repeater->add_control(
            'secondary_btn_anim_delay',
            [
                'label'      => esc_html__( 'Delay', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 5000,
                        'step' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'secondary_btn_animation',
                            'operator' => '!in',
                            'value'    => ['none', 'char-top', 'char-right', 'char-bottom', 'char-expand'],
                        ],
                    ],
                ],
            ]
        );
        
        $repeater->add_control(
            'secondary_btn_anim_duration',
            [
                'label'      => esc_html__( 'Duration', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 5000,
                        'step' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'secondary_btn_animation',
                            'operator' => '!in',
                            'value'    => ['none', 'char-top', 'char-right', 'char-bottom', 'char-expand'],
                        ],
                    ],
                ],
            ]
        );
        
        $repeater->end_controls_tab();
        
        $repeater->end_controls_tabs();

        $repeater->add_control(
            'play_btn_caption_heading',
            [
                'label'     => esc_html__( 'Play Button', 'mt-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->start_controls_tabs( 'play_btn_caption_tabs' );

        $repeater->start_controls_tab(
            'play_btn_caption_tab',
            [
                'label' => esc_html__( 'Button', 'mt-addons' ),
            ]
        );

        $repeater->add_control(
            'play_btn_label', [
                'label'       => esc_html__( 'Label', 'mt-addons' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Watch Video', 'mt-addons' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'play_btn_url',
            [
                'label'         => esc_html__( 'Link', 'mt-addons' ),
                'type'          => Controls_Manager::URL,
                'placeholder'   => esc_html__( 'https://your-link.com', 'mt-addons' ),
                'show_external' => false,
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'play_btn_caption_tab_anim',
            [
                'label' => esc_html__( 'Animation', 'mt-addons' ),
            ]
        );

        $repeater->add_control(
            'play_btn_animation',
            [
                'label'   => esc_html__( 'Effect', 'mt-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'mt-fadeIn',
                'options' => MT_Addons_Slider_Helper::get_animation_effects( ['clip-text', 'reveal-text', 'char-top', 'char-right', 'char-bottom', 'char-expand'] ),
            ]
        );

        $repeater->add_control(
            'play_btn_anim_delay',
            [
                'label'      => esc_html__( 'Delay', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 5000,
                        'step' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'play_btn_animation',
                            'operator' => '!in',
                            'value'    => ['none'],
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'play_btn_anim_duration',
            [
                'label'      => esc_html__( 'Duration', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 5000,
                        'step' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'play_btn_animation',
                            'operator' => '!in',
                            'value'    => ['none'],
                        ],
                    ],
                ],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
            'slide_items',
            [
                'label'   => esc_html__( 'Create Slides', 'mt-addons' ),
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => [
                    [
                        'bg_type'     => 'image',
                        'slide_image' => [
                            'url' => MT_Addons_Slider_Helper::get_el_placeholder_img(),
                        ],
                        'sub_heading' => esc_html__( 'Medium Caption', 'mt-addons' ),
                        'heading'     => esc_html__( 'Big Caption #1', 'mt-addons' ),
                        'desc'        => esc_html__( 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'mt-addons' ),
                        'btn_label'   => esc_html__( 'Learn More', 'mt-addons' ),
                        'btn_url'     => [
                            'url' => '#',
                        ],
                    ],
                    [
                        'bg_type'     => 'image',
                        'slide_image' => [
                            'url' => MT_Addons_Slider_Helper::get_el_placeholder_img(),
                        ],
                        'sub_heading' => esc_html__( 'Medium Caption', 'mt-addons' ),
                        'heading'     => esc_html__( 'Big Caption #2', 'mt-addons' ),
                        'desc'        => esc_html__( 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'mt-addons' ),
                        'btn_label'   => esc_html__( 'Learn More', 'mt-addons' ),
                        'btn_url'     => [
                            'url' => '#',
                        ],
                    ],
                    [
                        'bg_type'     => 'image',
                        'slide_image' => [
                            'url' => MT_Addons_Slider_Helper::get_el_placeholder_img(),
                        ],
                        'sub_heading' => esc_html__( 'Medium Caption', 'mt-addons' ),
                        'heading'     => esc_html__( 'Big Caption #3', 'mt-addons' ),
                        'desc'        => esc_html__( 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'mt-addons' ),
                        'btn_label'   => esc_html__( 'Learn More', 'mt-addons' ),
                        'btn_url'     => [
                            'url' => '#',
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Image Settings Controls
     *
     * @return void
     */
    private function section_slider_controls() {
        $this->start_controls_section(
            'section_slider_controls',
            [
                'label' => esc_html__( 'Slider Controls', 'mt-addons' ),
            ]
        );

        $this->add_control(
            'parallax',
            [
                'label'        => esc_html__( 'Parallax', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'    => esc_html__( 'No', 'mt-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'slide_dir',
            [
                'label'     => esc_html__( 'Slide Direction', 'mt-addons' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'horizontal',
                'options'   => [
                    'horizontal' => esc_html__( 'Horizontal', 'mt-addons' ),
                    'vertical'   => esc_html__( 'Vertical', 'mt-addons' ),
                ],
                'condition' => [
                    'parallax!' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'slide_effect',
            [
                'label'     => esc_html__( 'Effect', 'mt-addons' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'fade',
                'options'   => [
                    'fade'      => esc_html__( 'Fade', 'mt-addons' ),
                    'slide'     => esc_html__( 'Slide', 'mt-addons' ),
                    'coverflow' => esc_html__( 'Coverflow', 'mt-addons' ),
                    'flip'      => esc_html__( 'Flip', 'mt-addons' ),
                    'cube'      => esc_html__( 'Cube', 'mt-addons' ),
                ],
                'condition' => [
                    'parallax!' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'initial_slide',
            [
                'label'   => esc_html__( 'Initia lSlide', 'mt-addons' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => 1,
                'max'     => 10,
                'step'    => 1,
                'default' => 1,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'        => esc_html__( 'Autoplay', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'    => esc_html__( 'No', 'mt-addons' ),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'      => esc_html__( 'Autoplay Speed', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 500,
                        'max'  => 20000,
                        'step' => 5,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 5000,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .autoplay-active .mt-swiper-pagination.pagi-style-5 .swiper-pagination-bullet-active:after' => 'animation-duration: {{SIZE}}ms;',
                ],
                'condition'  => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label'        => esc_html__( 'Pause on Hover', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'    => esc_html__( 'No', 'mt-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label'        => esc_html__( 'Infinite Loop', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'    => esc_html__( 'No', 'mt-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'grabcursor',
            [
                'label'        => esc_html__( 'Grab Cursor', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'    => esc_html__( 'No', 'mt-addons' ),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'mousewheel',
            [
                'label'       => esc_html__( 'Mouse Wheel', 'mt-addons' ),
                'type'        => Controls_Manager::SWITCHER,
                'description' => esc_html__( 'Enables navigation through slides using mouse wheel.', 'elementor' ),
                'label_on'    => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'   => esc_html__( 'No', 'mt-addons' ),
            ]
        );

        $this->add_control(
            'anim_speed',
            [
                'label'   => esc_html__( 'Animation Speed', 'mt-addons' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => 100,
                'max'     => 3000,
                'step'    => 5,
                'default' => 1000,
            ]
        );

        $this->add_control(
            'text_direction',
            [
                'label'   => esc_html__( 'Text Direction', 'mt-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'ltr',
                'options' => [
                    'ltr' => esc_html__( 'Left - LTR', 'mt-addons' ),
                    'rtl' => esc_html__( 'Right - RTL', 'mt-addons' ),
                ],
            ]
        );

        $this->add_control(
            'slider_nav',
            [
                'label'        => esc_html__( 'Navigation', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'    => esc_html__( 'No', 'mt-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'slider_pagination',
            [
                'label'        => esc_html__( 'Pagination ( Bullets )', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'    => esc_html__( 'No', 'mt-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'nav_controls_head',
            [
                'label'     => esc_html__( 'Navigation Controls', 'mt-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'nav_layout',
            [
                'label'     => esc_html__( 'Layout', 'mt-addons' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    '1' => [
                        'title' => esc_html__( 'Bottom', 'mt-addons' ),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                    '2' => [
                        'title' => esc_html__( 'Center', 'mt-addons' ),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                ],
                'default'   => '1',
                'toggle'    => false,
                'condition' => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_alignment',
            [
                'label'                => esc_html__( 'Alignment', 'mt-addons' ),
                'type'                 => Controls_Manager::CHOOSE,
                'options'              => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'mt-addons' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'mt-addons' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'mt-addons' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'toggle'               => false,
                'selectors_dictionary' => [
                    'left'   => 'justify-content: flex-start',
                    'center' => 'justify-content: center',
                    'right'  => 'justify-content: flex-end',
                ],
                'default'              => 'center',
                'selectors'            => [
                    '{{WRAPPER}} .mt-slider-controls' => '{{VALUE}}',
                ],
                'condition'            => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_space_between_item',
            [
                'label'      => esc_html__( 'Space Between', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-slider-controls.style-1' => 'column-gap: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_nav'    => 'yes',
                    'nav_layout'    => '1',
                    'nav_alignment' => 'center',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_bottom_spacing',
            [
                'label'              => esc_html__( 'Bottom Spacing', 'mt-addons' ),
                'type'               => Controls_Manager::DIMENSIONS,
                'size_units'         => ['px', '%', 'em'],
                'allowed_dimensions' => ['bottom'],
                'selectors'          => [
                    '{{WRAPPER}} .mt-slider-controls' => 'bottom: {{BOTTOM}}{{UNIT}};',
                ],
                'condition'          => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Image Settings Controls
     *
     * @return void
     */
    private function section_image_settings() {
        $this->start_controls_section(
            'section_slider_image_settings',
            [
                'label' => esc_html__( 'Image Settings', 'mt-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'imagesize',
                'exclude' => ['custom'],
                'include' => [],
                'default' => 'full',
            ]
        );

        $this->add_responsive_control(
            'image_position',
            [
                'label'     => esc_html__( 'Image Position', 'mt-addons' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'center',
                'options'   => [
                    'top'    => esc_html__( 'Top', 'mt-addons' ),
                    'bottom' => esc_html__( 'Bottom', 'mt-addons' ),
                    'left'   => esc_html__( 'Left', 'mt-addons' ),
                    'Right'  => esc_html__( 'Right', 'mt-addons' ),
                    'center' => esc_html__( 'Center', 'mt-addons' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .mt-slider .slide-img' => 'object-position: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

}