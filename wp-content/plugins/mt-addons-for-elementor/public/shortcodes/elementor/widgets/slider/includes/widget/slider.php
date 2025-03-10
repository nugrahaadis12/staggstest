<?php
/**
 * Slider
 *
 * @package MT_Addons_Slider
 */
namespace Elementor;

use MT_Addons\includes\MT_Addons_ContentControl;
use MT_Addons\includes\MT_Addons_Slider_Helper;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || die();

class mt_addons_slider extends Widget_Base {

	use MT_Addons_ContentControl;

	public function get_name() {
        return 'mtfe-slider';
    }

    public function get_title() {
        return esc_html__( 'MT - Slider', 'mt-addons' );
    }

    public function get_icon() {
        return 'eicon-slides';
    }

    public function get_categories() {
        return ['mt-addons-widgets'];
    }

    public function get_style_depends() {
        return ['splitting', 'mtaddons-slider-style'];
    }

    public function get_script_depends() {
        return [ 'splitting', 'mtaddons-slider-script' ];
    }

	public function get_keywords() {
        return [ 'slider'];
    }

    protected function register_controls() {

        $this->section_slider_settings();
        $this->section_slides();
        $this->section_slider_controls();
        $this->section_image_settings();
        $this->style_sub_heading();
        $this->style_heading();
        $this->style_description();
        $this->style_button();
        $this->style_secondary_button();
        $this->style_play_button();
        $this->style_navigation();
        $this->style_pagination();

    }

    /**
     * Sub Heading Controls
     *
     * @return void
     */
    private function style_sub_heading() {

        $this->start_controls_section(
            'style_sub_heading',
            [
                'label' => esc_html__( 'Sub Heading', 'mt-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sub_heading_typography',
                'label'    => esc_html__( 'Typography', 'mt-addons' ),
                'selector' => '{{WRAPPER}} .mt-caption.sub-heading',
            ]
        );

        $this->start_controls_tabs( 'sub_heading_style_tabs' );

        $this->start_controls_tab(
            'style_subheading_tab',
            [
                'label' => esc_html__( 'Style', 'mt-addons' ),
            ]
        );

        $this->add_control(
            'sub_heading_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.sub-heading .mt-cap' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'sub_heading_color',
            [
                'label'     => esc_html__( 'Text Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.sub-heading' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'sh_text_stroke',
            [
                'label'        => esc_html__( 'Text Stroke', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'    => esc_html__( 'No', 'mt-addons' ),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'popover_sh_text_stroke',
            [
                'label'        => esc_html__( 'Stroke Options', 'mt-addons' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => esc_html__( 'Default', 'mt-addons' ),
                'label_on'     => esc_html__( 'Custom', 'mt-addons' ),
                'return_value' => 'yes',
                'condition'    => [
                    'sh_text_stroke' => 'yes',
                ],
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'sh_text_stroke_width',
            [
                'label'      => esc_html__( 'Stroke Width', 'mt-addons' ),
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
                    'size' => 1,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.sub-heading' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'sh_text_stroke' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'sh_text_stroke_color',
            [
                'label'     => esc_html__( 'Stroke Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.sub-heading' => '-webkit-text-stroke-color: {{VALUE}}',
                ],
                'condition' => [
                    'sh_text_stroke' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'sh_text_fill_color',
            [
                'label'     => esc_html__( 'Fill Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.sub-heading' => '-webkit-text-fill-color: {{VALUE}}',
                ],
                'condition' => [
                    'sh_text_stroke' => 'yes',
                ],
            ]
        );

        $this->end_popover();

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'sub_heading_text_shadow',
                'selector' => '{{WRAPPER}} .mt-caption.sub-heading',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'sub_heading_box_shadow',
                'selector' => '{{WRAPPER}} .mt-caption.sub-heading .mt-cap',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'sub_heading_border',
                'label'    => esc_html__( 'Border', 'mt-addons' ),
                'selector' => '{{WRAPPER}} .mt-caption.sub-heading .mt-cap',
            ]
        );

        $this->add_responsive_control(
            'sub_heading_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.sub-heading .mt-cap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sub_heading_padding',
            [
                'label'      => esc_html__( 'Padding', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.sub-heading .mt-cap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sub_heading_margin',
            [
                'label'      => esc_html__( 'Margin', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.sub-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'stylesh_hl_text_tab',
            [
                'label' => esc_html__( 'Mark Text', 'mt-addons' ),
            ]
        );

        $this->add_control(
            'sh_hl_style',
            [
                'label'        => esc_html__( 'Custom Style', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'    => esc_html__( 'No', 'mt-addons' ),
                'return_value' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'sh_hl_layout',
            [
                'label'     => esc_html__( 'Layout', 'mt-addons' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'inline-block' => [
                        'title' => esc_html__( 'Inline', 'mt-addons' ),
                        'icon'  => 'eicon-ellipsis-h',
                    ],
                    'block'        => [
                        'title' => esc_html__( 'Block', 'mt-addons' ),
                        'icon'  => 'eicon-menu-bar',
                    ],
                ],
                'default'   => 'inline-block',
                'toggle'    => false,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.sub-heading mark' => 'display: {{VALUE}};',
                ],
                'condition' => [
                    'sh_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'sub_heading_hl_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.sub-heading mark' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'sh_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'sub_heading_hl_color',
            [
                'label'     => esc_html__( 'Text Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.sub-heading mark' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'sh_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'sh_hl_text_stroke',
            [
                'label'        => esc_html__( 'Text Stroke', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'    => esc_html__( 'No', 'mt-addons' ),
                'return_value' => 'yes',
                'condition'    => [
                    'sh_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'popover_sh_hl_text_stroke',
            [
                'label'        => esc_html__( 'Stroke Options', 'mt-addons' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => esc_html__( 'Default', 'mt-addons' ),
                'label_on'     => esc_html__( 'Custom', 'mt-addons' ),
                'return_value' => 'yes',
                'condition'    => [
                    'sh_hl_text_stroke' => 'yes',
                    'sh_hl_style'       => 'yes',
                ],
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'sh_hl_text_stroke_width',
            [
                'label'      => esc_html__( 'Stroke Width', 'mt-addons' ),
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
                    'size' => 1,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.sub-heading mark' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'sh_hl_text_stroke' => 'yes',
                    'sh_hl_style'       => 'yes',
                ],
            ]
        );

        $this->add_control(
            'sh_hl_text_stroke_color',
            [
                'label'     => esc_html__( 'Stroke Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.sub-heading mark' => '-webkit-text-stroke-color: {{VALUE}}',
                ],
                'condition' => [
                    'sh_hl_text_stroke' => 'yes',
                    'sh_hl_style'       => 'yes',
                ],
            ]
        );

        $this->add_control(
            'sh_hl_text_fill_color',
            [
                'label'     => esc_html__( 'Fill Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.sub-heading mark' => '-webkit-text-fill-color: {{VALUE}}',
                ],
                'condition' => [
                    'sh_hl_text_stroke' => 'yes',
                    'sh_hl_style'       => 'yes',
                ],
            ]
        );

        $this->end_popover();

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'      => 'sub_heading_hl_text_shadow',
                'selector'  => '{{WRAPPER}} .mt-caption.sub-heading mark',
                'condition' => [
                    'sh_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'sub_heading_hl_box_shadow',
                'selector'  => '{{WRAPPER}} .mt-caption.sub-heading mark',
                'condition' => [
                    'sh_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'sub_heading_hl_border',
                'label'     => esc_html__( 'Border', 'mt-addons' ),
                'selector'  => '{{WRAPPER}} .mt-caption.sub-heading mark',
                'condition' => [
                    'sh_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'sub_heading_hl_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.sub-heading mark' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'sh_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'sub_heading_hl_padding',
            [
                'label'      => esc_html__( 'Padding', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.sub-heading mark' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'sh_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'sub_heading_hl_margin',
            [
                'label'      => esc_html__( 'Margin', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.sub-heading mark' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'sh_hl_style' => 'yes',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    /**
     * Heading Controls
     *
     * @return void
     */
    private function style_heading() {

        $this->start_controls_section(
            'style_heading',
            [
                'label' => esc_html__( 'Heading', 'mt-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography',
                'label'    => esc_html__( 'Typography', 'mt-addons' ),
                'selector' => '{{WRAPPER}} .mt-caption.heading',
            ]
        );

        $this->start_controls_tabs( 'heading_style_tabs' );

        $this->start_controls_tab(
            'style_heading_tab',
            [
                'label' => esc_html__( 'Style', 'mt-addons' ),
            ]
        );

        $this->add_control(
            'heading_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.heading .mt-cap' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label'     => esc_html__( 'Text Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.heading' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'h_text_stroke',
            [
                'label'        => esc_html__( 'Text Stroke', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'    => esc_html__( 'No', 'mt-addons' ),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'popover_h_text_stroke',
            [
                'label'        => esc_html__( 'Stroke Options', 'mt-addons' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => esc_html__( 'Default', 'mt-addons' ),
                'label_on'     => esc_html__( 'Custom', 'mt-addons' ),
                'return_value' => 'yes',
                'condition'    => [
                    'h_text_stroke' => 'yes',
                ],
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'h_text_stroke_width',
            [
                'label'      => esc_html__( 'Stroke Width', 'mt-addons' ),
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
                    'size' => 1,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.heading' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'h_text_stroke' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'h_text_stroke_color',
            [
                'label'     => esc_html__( 'Stroke Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.heading' => '-webkit-text-stroke-color: {{VALUE}}',
                ],
                'condition' => [
                    'h_text_stroke' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'h_text_fill_color',
            [
                'label'     => esc_html__( 'Fill Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.heading' => '-webkit-text-fill-color: {{VALUE}}',
                ],
                'condition' => [
                    'h_text_stroke' => 'yes',
                ],
            ]
        );

        $this->end_popover();

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'heading_text_shadow',
                'selector' => '{{WRAPPER}} .mt-caption.heading',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'heading_box_shadow',
                'selector' => '{{WRAPPER}} .mt-caption.heading .mt-cap',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'heading_border',
                'label'    => esc_html__( 'Border', 'mt-addons' ),
                'selector' => '{{WRAPPER}} .mt-caption.heading .mt-cap',
            ]
        );

        $this->add_responsive_control(
            'heading_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.heading .mt-cap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_padding',
            [
                'label'      => esc_html__( 'Padding', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.heading .mt-cap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_margin',
            [
                'label'      => esc_html__( 'Margin', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_h_hl_text_tab',
            [
                'label' => esc_html__( 'Mark Text', 'mt-addons' ),
            ]
        );

        $this->add_control(
            'h_hl_style',
            [
                'label'        => esc_html__( 'Custom Style', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'    => esc_html__( 'No', 'mt-addons' ),
                'return_value' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'h_hl_layout',
            [
                'label'     => esc_html__( 'Layout', 'mt-addons' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'inline-block' => [
                        'title' => esc_html__( 'Inline', 'mt-addons' ),
                        'icon'  => 'eicon-ellipsis-h',
                    ],
                    'block'        => [
                        'title' => esc_html__( 'Block', 'mt-addons' ),
                        'icon'  => 'eicon-menu-bar',
                    ],
                ],
                'default'   => 'inline-block',
                'toggle'    => false,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.heading mark' => 'display: {{VALUE}};',
                ],
                'condition' => [
                    'h_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'heading_hl_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.heading mark' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'h_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'heading_hl_color',
            [
                'label'     => esc_html__( 'Text Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.heading mark' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'h_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'h_hl_text_stroke',
            [
                'label'        => esc_html__( 'Text Stroke', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'    => esc_html__( 'No', 'mt-addons' ),
                'return_value' => 'yes',
                'condition'    => [
                    'h_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'popover_h_hl_text_stroke',
            [
                'label'        => esc_html__( 'Stroke Options', 'mt-addons' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => esc_html__( 'Default', 'mt-addons' ),
                'label_on'     => esc_html__( 'Custom', 'mt-addons' ),
                'return_value' => 'yes',
                'condition'    => [
                    'h_hl_text_stroke' => 'yes',
                    'h_hl_style'       => 'yes',
                ],
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'h_hl_text_stroke_width',
            [
                'label'      => esc_html__( 'Stroke Width', 'mt-addons' ),
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
                    'size' => 1,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.heading mark' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'h_hl_text_stroke' => 'yes',
                    'h_hl_style'       => 'yes',
                ],
            ]
        );

        $this->add_control(
            'h_hl_text_stroke_color',
            [
                'label'     => esc_html__( 'Stroke Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.heading mark' => '-webkit-text-stroke-color: {{VALUE}}',
                ],
                'condition' => [
                    'h_hl_text_stroke' => 'yes',
                    'h_hl_style'       => 'yes',
                ],
            ]
        );

        $this->add_control(
            'h_hl_text_fill_color',
            [
                'label'     => esc_html__( 'Fill Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.heading mark' => '-webkit-text-fill-color: {{VALUE}}',
                ],
                'condition' => [
                    'h_hl_text_stroke' => 'yes',
                    'h_hl_style'       => 'yes',
                ],
            ]
        );

        $this->end_popover();

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'      => 'heading_hl_text_shadow',
                'selector'  => '{{WRAPPER}} .mt-caption.heading mark',
                'condition' => [
                    'h_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'heading_hl_box_shadow',
                'selector'  => '{{WRAPPER}} .mt-caption.heading mark',
                'condition' => [
                    'h_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'heading_hl_border',
                'label'     => esc_html__( 'Border', 'mt-addons' ),
                'selector'  => '{{WRAPPER}} .mt-caption.heading mark',
                'condition' => [
                    'h_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_hl_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.heading mark' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'h_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_hl_padding',
            [
                'label'      => esc_html__( 'Padding', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.heading mark' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'h_hl_style' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_hl_margin',
            [
                'label'      => esc_html__( 'Margin', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.heading mark' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'h_hl_style' => 'yes',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    /**
     * Description Controls
     *
     * @return void
     */
    private function style_description() {

        $this->start_controls_section(
            'style_description',
            [
                'label' => esc_html__( 'Description', 'mt-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'desc_typography',
                'label'    => esc_html__( 'Typography', 'mt-addons' ),
                'selector' => '{{WRAPPER}} .mt-caption.desc',
            ]
        );

        $this->add_control(
            'desc_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.desc .mt-cap' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label'     => esc_html__( 'Text Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-caption.desc' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'desc_text_shadow',
                'selector' => '{{WRAPPER}} .mt-caption.desc',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'desc_box_shadow',
                'selector' => '{{WRAPPER}} .mt-caption.desc .mt-cap',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'desc_border',
                'label'    => esc_html__( 'Border', 'mt-addons' ),
                'selector' => '{{WRAPPER}} .mt-caption.desc .mt-cap',
            ]
        );

        $this->add_responsive_control(
            'desc_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.desc .mt-cap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'desc_padding',
            [
                'label'      => esc_html__( 'Padding', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.desc .mt-cap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'desc_margin',
            [
                'label'      => esc_html__( 'Margin', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-caption.desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Button Controls
     *
     * @return void
     */
    private function style_button() {

        $this->start_controls_section(
            'style_button',
            [
                'label' => esc_html__( 'Button', 'mt-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'btn_typography',
                'label'    => esc_html__( 'Typography', 'mt-addons' ),
                'selector' => '{{WRAPPER}} .slider-btn',
            ]
        );

        $this->add_responsive_control(
            'btn_icon_size',
            [
                'label'      => esc_html__( 'Icon Size', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 150,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .slider-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'btn_space_between',
            [
                'label'      => esc_html__( 'Space Between', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .slider-btn' => 'column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'btn_padding',
            [
                'label'      => esc_html__( 'Padding', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .slider-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'btn_margin',
            [
                'label'      => esc_html__( 'Margin', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .slider-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'style_btn_tabs' );

        $this->start_controls_tab(
            'style_btn_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'mt-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'btn_normal_background',
                'label'    => esc_html__( 'Background', 'mt-addons' ),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .slider-btn',
            ]
        );

        $this->add_control(
            'btn_normal_color',
            [
                'label'     => esc_html__( 'Text Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slider-btn' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'btn_normal_border',
                'label'    => esc_html__( 'Border', 'mt-addons' ),
                'selector' => '{{WRAPPER}} .slider-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'btn_normal_box_shadow',
                'selector' => '{{WRAPPER}} .slider-btn',
            ]
        );

        $this->add_responsive_control(
            'btn_normal_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .slider-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_btn_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'mt-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'btn_hover_background',
                'label'    => esc_html__( 'Background', 'mt-addons' ),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .slider-btn:hover',
            ]
        );

        $this->add_control(
            'btn_hover_color',
            [
                'label'     => esc_html__( 'Text Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slider-btn:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'btn_hover_border',
                'label'    => esc_html__( 'Border', 'mt-addons' ),
                'selector' => '{{WRAPPER}} .slider-btn:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'btn_hover_box_shadow',
                'selector' => '{{WRAPPER}} .slider-btn:hover',
            ]
        );

        $this->add_responsive_control(
            'btn_hover_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .slider-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    /**
     * Secondary Button Controls
     *
     * @return void
     */
    private function style_secondary_button() {

        $this->start_controls_section(
            'secondary_style_button',
            [
                'label' => esc_html__( 'Secondary Button', 'mt-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'secondary_btn_typography',
                'label'    => esc_html__( 'Typography', 'mt-addons' ),
                'selector' => '{{WRAPPER}} .slider-secondary-btn',
            ]
        );

        $this->add_responsive_control(
            'secondary_btn_icon_size',
            [
                'label'      => esc_html__( 'Icon Size', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 150,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .slider-secondary-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'secondary_btn_space_between',
            [
                'label'      => esc_html__( 'Space Between', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .slider-secondary-btn' => 'column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'secondary_btn_padding',
            [
                'label'      => esc_html__( 'Padding', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .slider-secondary-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'secondary_btn_margin',
            [
                'label'      => esc_html__( 'Margin', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .slider-secondary-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'style_secondary_btn_tabs' );

        $this->start_controls_tab(
            'style_btn_secondary_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'mt-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'btn_secondary_normal_background',
                'label'    => esc_html__( 'Background', 'mt-addons' ),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .slider-secondary-btn',
            ]
        );

        $this->add_control(
            'secondary_btn_normal_color',
            [
                'label'     => esc_html__( 'Text Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slider-secondary-btn' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'secondary_btn_normal_border',
                'label'    => esc_html__( 'Border', 'mt-addons' ),
                'selector' => '{{WRAPPER}} .slider-secondary-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'secondary_btn_normal_box_shadow',
                'selector' => '{{WRAPPER}} .slider-secondary-btn',
            ]
        );

        $this->add_responsive_control(
            'secondary_btn_normal_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .slider-secondary-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_secondary_btn_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'mt-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'secondary_btn_hover_background',
                'label'    => esc_html__( 'Background', 'mt-addons' ),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .slider-secondary-btn:hover',
            ]
        );

        $this->add_control(
            'secondary_btn_hover_color',
            [
                'label'     => esc_html__( 'Text Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slider-secondary-btn:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'secondary_btn_hover_border',
                'label'    => esc_html__( 'Border', 'mt-addons' ),
                'selector' => '{{WRAPPER}} .slider-secondary-btn:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'secondary_btn_hover_box_shadow',
                'selector' => '{{WRAPPER}} .slider-secondary-btn:hover',
            ]
        );

        $this->add_responsive_control(
            'secondary_btn_hover_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .slider-secondary-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    /**
     * Play Button Controls
     *
     * @return void
     */
    private function style_play_button() {

        $this->start_controls_section(
            'style_play_button',
            [
                'label' => esc_html__( 'Play Button', 'mt-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'play_btn_size',
            [
                'label'      => esc_html__( 'Play Button Size', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 250,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-play-btn .play-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'play_btn_icon_size',
            [
                'label'      => esc_html__( 'Icon Size', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 150,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-play-btn .play-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'play_btn_space_between',
            [
                'label'      => esc_html__( 'Space Between', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 150,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-play-btn' => 'column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'play_btn_margin',
            [
                'label'      => esc_html__( 'Margin', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-play-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'style_play_btn_tabs' );

        $this->start_controls_tab(
            'style_play_btn_icon_tab',
            [
                'label' => esc_html__( 'Play Icon', 'mt-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'play_btn_icon_background',
                'label'    => esc_html__( 'Background', 'mt-addons' ),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mt-play-btn .play-icon',
            ]
        );

        $this->add_control(
            'play_btn_icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-play-btn .play-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'play_btn_icon_border',
                'label'    => esc_html__( 'Border', 'mt-addons' ),
                'selector' => '{{WRAPPER}} .mt-play-btn .play-icon',
            ]
        );

        $this->add_responsive_control(
            'play_btn_icon_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-play-btn .play-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'play_btn_hover_stuff',
            [
                'label'     => esc_html__( 'Hover', 'plugin-name' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'play_btn_icon_hover_background',
                'label'     => esc_html__( 'Background', 'mt-addons' ),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .mt-play-btn:hover .play-icon',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'play_btn_icon_hover_color',
            [
                'label'     => esc_html__( 'Icon Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-play-btn:hover .play-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'play_btn_icon_hover_border',
                'label'    => esc_html__( 'Border', 'mt-addons' ),
                'selector' => '{{WRAPPER}} .mt-play-btn:hover .play-icon',
            ]
        );

        $this->add_responsive_control(
            'play_btn_icon_hover_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-play-btn:hover .play-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_play_btn_text_tab',
            [
                'label' => esc_html__( 'Text/Label', 'mt-addons' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'play_btn_text_typography',
                'label'    => esc_html__( 'Typography', 'mt-addons' ),
                'selector' => '{{WRAPPER}} .mt-play-btn small',
            ]
        );

        $this->add_control(
            'play_btn_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-play-btn small' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'play_btn_text_hover_stuff',
            [
                'label'     => esc_html__( 'Hover', 'plugin-name' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'play_btn_text_hover_color',
            [
                'label'     => esc_html__( 'Text Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-play-btn:hover small' => 'color: {{VALUE}}',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    /**
     * Style Carousel Navigation
     *
     * @return void
     */
    protected function style_navigation() {

        $this->start_controls_section(
            'section_carousel_navigation_style',
            [
                'label'     => esc_html__( 'Navigation', 'mt-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'nav_hide_mobile',
            [
                'label'        => esc_html__( 'Hide on Mobile', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'yes', 'mt-addons' ),
                'label_off'    => esc_html__( 'No', 'mt-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'nav_visibility',
            [
                'label'     => esc_html__( 'Visibility', 'mt-addons' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'hover-on-visible',
                'options'   => [
                    'hover-on-visible' => esc_html__( 'Hover on Visible', 'mt-addons' ),
                    'always-visible'   => esc_html__( 'Always Visible', 'mt-addons' ),
                ],
                'condition' => [
                    'slider_nav' => 'yes',
                    'nav_layout' => '2',
                ],
            ]
        );

        $this->add_control(
            'nav_long_arrow',
            [
                'label'        => esc_html__( 'Long Arrow', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'yes', 'mt-addons' ),
                'label_off'    => esc_html__( 'No', 'mt-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_width',
            [
                'label'      => esc_html__( 'Width', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 300,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-slider-button-prev, {{WRAPPER}} .mt-slider-button-next' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_height',
            [
                'label'      => esc_html__( 'Height', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 300,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-slider-button-prev, {{WRAPPER}} .mt-slider-button-next' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_icon_size',
            [
                'label'      => esc_html__( 'Icon Size', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 200,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-slider-button-prev svg, {{WRAPPER}} .mt-slider-button-next svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_top_bottom_pos',
            [
                'label'      => esc_html__( 'Top Bottom Position', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => -1000,
                        'max'  => 1000,
                        'step' => 5,
                    ],
                    '%'  => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => -50,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .nav-2.mt-slider-button-prev, {{WRAPPER}} .nav-2.mt-slider-button-next' => 'transform: translateY({{SIZE}}{{UNIT}});',
                ],
                'condition'  => [
                    'slider_nav' => 'yes',
                    'nav_layout' => '2',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_left_right_pos',
            [
                'label'      => esc_html__( 'Left Right Position', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => -1000,
                        'max'  => 1000,
                        'step' => 5,
                    ],
                    '%'  => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .nav-2.mt-slider-button-prev'                         => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .nav-2.mt-slider-button-next'                         => 'left: auto; right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .hover-on-visible:hover .nav-2.mt-slider-button-prev' => 'left: calc({{SIZE}}{{UNIT}} + 5px);',
                    '{{WRAPPER}} .hover-on-visible:hover .nav-2.mt-slider-button-next' => 'left: auto; right: calc({{SIZE}}{{UNIT}} + 5px);',
                ],
                'condition'  => [
                    'slider_nav' => 'yes',
                    'nav_layout' => '2',
                ],
            ]
        );

        $this->start_controls_tabs( 'nav_style_tabs' );

        $this->start_controls_tab(
            'nav_style_normal_tab',
            [
                'label'     => esc_html__( 'Normal', 'mt-addons' ),
                'condition' => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'nav_normal_bg',
                'label'     => esc_html__( 'Background', 'mt-addons' ),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .mt-slider-button-prev, {{WRAPPER}} .mt-slider-button-next',
                'condition' => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'nav_normal_color',
            [
                'label'     => esc_html__( 'Icon Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-slider-button-prev, {{WRAPPER}} .mt-slider-button-next' => 'fill: {{VALUE}}',
                ],
                'condition' => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'nav_normal_border',
                'label'     => esc_html__( 'Border', 'mt-addons' ),
                'selector'  => '{{WRAPPER}} .mt-slider-button-prev, {{WRAPPER}} .mt-slider-button-next',
                'condition' => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'nav_normal_box_shadow',
                'selector'  => '{{WRAPPER}} .mt-slider-button-prev, {{WRAPPER}} .mt-slider-button-next',
                'condition' => [
                    'carouse_nav' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_normal_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-slider-button-prev, {{WRAPPER}} .mt-slider-button-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'nav_style_hover_tab',
            [
                'label'     => esc_html__( 'Hover', 'mt-addons' ),
                'condition' => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'nav_hover_bg',
                'label'     => esc_html__( 'Background', 'mt-addons' ),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .mt-slider-button-prev:hover, {{WRAPPER}} .mt-slider-button-next:hover',
                'condition' => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'nav_hover_color',
            [
                'label'     => esc_html__( 'Icon Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-slider-button-prev:hover, {{WRAPPER}} .mt-slider-button-next:hover' => 'fill: {{VALUE}}',
                ],
                'condition' => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'nav_hover_border',
                'label'     => esc_html__( 'Border', 'mt-addons' ),
                'selector'  => '{{WRAPPER}} .mt-slider-button-prev:hover, {{WRAPPER}} .mt-slider-button-next:hover',
                'condition' => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'nav_hover_box_shadow',
                'selector'  => '{{WRAPPER}} .mt-slider-button-prev:hover, {{WRAPPER}} .mt-slider-button-next:hover',
                'condition' => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_hover_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'mt-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .mt-slider-button-prev:hover, {{WRAPPER}} .mt-slider-button-next:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_nav' => 'yes',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    /**
     * Style Carousel Pagination
     *
     * @return void
     */
    protected function style_pagination() {

        $this->start_controls_section(
            'section_carousel_pagination_style',
            [
                'label'     => esc_html__( 'Pagination ( Bullets )', 'mt-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'slider_pagination' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pagi_style',
            [
                'label'     => esc_html__( 'Style', 'mt-addons' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '1',
                'options'   => [
                    '1' => esc_html__( 'Dots Circle', 'mt-addons' ),
                    '2' => esc_html__( 'Dots', 'mt-addons' ),
                    '3' => esc_html__( 'Dots Stroke', 'mt-addons' ),
                    '4' => esc_html__( 'Numbers', 'mt-addons' ),
                    '5' => esc_html__( 'Lines', 'mt-addons' ),
                    '6' => esc_html__( 'Fraction', 'mt-addons' ),
                ],
                'condition' => [
                    'slider_pagination' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'bullet_space_between_item',
            [
                'label'      => esc_html__( 'Space Between Item', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-swiper-pagination'                                               => 'column-gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mt-swiper-pagination.pagi-style-4 .swiper-pagination-bullet-active' => 'column-gap: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_pagination' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_size',
            [
                'label'      => esc_html__( 'Dots Size', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 150,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-swiper-pagination .swiper-pagination-bullet'              => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mt-swiper-pagination.pagi-style-2 .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_pagination' => 'yes',
                    'pagi_style!'       => ['4', '5', '6'],
                ],
            ]
        );

        $this->add_responsive_control(
            'number_line_width',
            [
                'label'      => esc_html__( 'Line Width', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 150,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-swiper-pagination.pagi-style-4 .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mt-swiper-pagination.pagi-style-5 .swiper-pagination-bullet'        => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_pagination' => 'yes',
                    'pagi_style'        => ['4', '5'],
                ],
            ]
        );

        $this->add_responsive_control(
            'number_line_height',
            [
                'label'      => esc_html__( 'Line Height', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 150,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-swiper-pagination.pagi-style-4 .swiper-pagination-bullet-active .line' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mt-swiper-pagination.pagi-style-5 .swiper-pagination-bullet'              => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_pagination' => 'yes',
                    'pagi_style'        => ['4', '5'],
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_active_size',
            [
                'label'      => esc_html__( 'Dot Active Size', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 150,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-swiper-pagination.pagi-style-2 .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_pagination' => 'yes',
                    'pagi_style'        => '2',
                ],
            ]
        );

        $this->start_controls_tabs( 'bullet_style_tabs' );

        $this->start_controls_tab(
            'bullet_style_normal_tab',
            [
                'label'     => esc_html__( 'Normal', 'mt-addons' ),
                'condition' => [
                    'slider_pagination' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'number_pagi_typography',
                'label'     => esc_html__( 'Typography', 'mt-addons' ),
                'selector'  => '{{WRAPPER}} .mt-swiper-pagination.pagi-style-4 .swiper-pagination-bullet .number, {{WRAPPER}} .pagi-style-6.swiper-pagination-fraction',
                'condition' => [
                    'slider_pagination' => 'yes',
                    'pagi_style'        => ['4', '6'],
                ],
            ]
        );

        $this->add_control(
            'bullet_color',
            [
                'label'     => esc_html__( 'Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-swiper-pagination .swiper-pagination-bullet .solid-fill'                                                                                        => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .mt-swiper-pagination.pagi-style-2 .swiper-pagination-bullet'                                                                                       => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .mt-swiper-pagination.pagi-style-3 .swiper-pagination-bullet:before'                                                                                => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .mt-swiper-pagination.pagi-style-4 .swiper-pagination-bullet .number'                                                                               => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mt-swiper-pagination.pagi-style-5 .swiper-pagination-bullet:before'                                                                                => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .pagi-style-6.swiper-pagination-fraction .swiper-pagination-current, {{WRAPPER}} .pagi-style-6.swiper-pagination-fraction .swiper-pagination-total' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'slider_pagination' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'fraction_sep_color',
            [
                'label'     => esc_html__( 'Separator Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pagi-style-6.swiper-pagination-fraction' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'slider_pagination' => 'yes',
                    'pagi_style'        => '6',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'bullet_style_active_tab',
            [
                'label'     => esc_html__( 'Active', 'mt-addons' ),
                'condition' => [
                    'slider_pagination' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'bullet_circle_color',
            [
                'label'     => esc_html__( 'Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-swiper-pagination .swiper-pagination-bullet-active .solid-fill'         => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .mt-swiper-pagination.pagi-style-2 .swiper-pagination-bullet-active'        => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .mt-swiper-pagination.pagi-style-3 .swiper-pagination-bullet-active:before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .mt-swiper-pagination.pagi-style-4 .swiper-pagination-bullet-active .line'  => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .mt-swiper-pagination.pagi-style-5 .swiper-pagination-bullet-active:after'  => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .pagi-style-6.swiper-pagination-fraction .swiper-pagination-current'        => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'slider_pagination' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'fraction_text_stroke',
            [
                'label'        => esc_html__( 'Text Stroke', 'mt-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'mt-addons' ),
                'label_off'    => esc_html__( 'No', 'mt-addons' ),
                'return_value' => 'yes',
                'condition' => [
                    'slider_pagination' => 'yes',
                    'pagi_style' => '6'
                ],
            ]
        );

        $this->add_control(
            'popover_fraction_text_stroke',
            [
                'label'        => esc_html__( 'Stroke Options', 'mt-addons' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => esc_html__( 'Default', 'mt-addons' ),
                'label_on'     => esc_html__( 'Custom', 'mt-addons' ),
                'return_value' => 'yes',
                'condition'    => [
                    'slider_pagination' => 'yes',
                    'pagi_style' => '6',
                    'fraction_text_stroke' => 'yes'
                ],
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'fraction_text_stroke_width',
            [
                'label'      => esc_html__( 'Stroke Width', 'mt-addons' ),
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
                    'size' => 1,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .pagi-style-6.swiper-pagination-fraction .swiper-pagination-current' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'slider_pagination' => 'yes',
                    'pagi_style' => '6',
                    'fraction_text_stroke' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'fraction_text_stroke_color',
            [
                'label'     => esc_html__( 'Stroke Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pagi-style-6.swiper-pagination-fraction .swiper-pagination-current' => '-webkit-text-stroke-color: {{VALUE}}',
                ],
                'condition' => [
                    'slider_pagination' => 'yes',
                    'pagi_style' => '6',
                    'fraction_text_stroke' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'fraction_text_fill_color',
            [
                'label'     => esc_html__( 'Fill Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pagi-style-6.swiper-pagination-fraction .swiper-pagination-current' => '-webkit-text-fill-color: {{VALUE}}',
                ],
                'condition' => [
                    'slider_pagination' => 'yes',
                    'pagi_style' => '6',
                    'fraction_text_stroke' => 'yes'
                ],
            ]
        );

        $this->end_popover();

        $this->add_control(
            'bullet_stroke_color',
            [
                'label'     => esc_html__( 'Stroke Color', 'mt-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mt-swiper-pagination .swiper-pagination-bullet-active .path' => 'stroke: {{VALUE}}',
                ],
                'condition' => [
                    'slider_pagination' => 'yes',
                    'pagi_style'        => ['1', '3'],
                ],
            ]
        );

        $this->add_responsive_control(
            'bullet_stroke_width',
            [
                'label'      => esc_html__( 'Stroke Size', 'mt-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 1,
                        'max'  => 10,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mt-swiper-pagination .swiper-pagination-bullet .path'               => 'stroke-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mt-swiper-pagination.pagi-style-3 .swiper-pagination-bullet-active' => 'box-shadow: 0 0 0 {{SIZE}}{{UNIT}} {{bullet_stroke_color.VALUE}};',
                ],
                'condition'  => [
                    'slider_pagination' => 'yes',
                    'pagi_style'        => ['1', '3'],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

   protected function render() {
        $settings = $this->get_settings_for_display();
        $slider_items = $settings['slide_items'];
        $pagiStyle = $settings['pagi_style'];
        $data = [
            'autoplay' => 'yes' === $settings['autoplay'] ? true : false,
            'autoplaySpeed' => ! empty( $settings['autoplay_speed']['size'] ) ? $settings['autoplay_speed']['size'] : 5000,
            'speed' => ! empty( $settings['anim_speed'] ) ? $settings['anim_speed'] : 1000,
            'direction' => ! empty( $settings['slide_dir'] ) ? $settings['slide_dir'] : 'horizontal',
            'effect' => ! empty( $settings['slide_effect'] ) ? $settings['slide_effect'] : 'fade',
            'initialSlide' => ! empty( $settings['initial_slide'] ) ? ( $settings['initial_slide'] - 1 ) : 0,
            'grabCursor'=> 'yes' === $settings['grabcursor'] ? true : false,
            'loop'=> 'yes' === $settings['infinite_loop'] ? true : false,
            'pauseOnHover'=> 'yes' === $settings['pause_on_hover'] ? true : false,
            'parallax'=> 'yes' === $settings['parallax'] ? true : false,
            'mousewheel'=> 'yes' === $settings['mousewheel'] ? true : false,
            'navigation' => $settings['slider_nav'],
            'pagination' => $settings['slider_pagination'],
            'pagiStyle' => 'style-' . $pagiStyle
        ];

        $nav_visibility = '';
        $nav_mobile_view = '';
        if( 'yes' === $settings['slider_nav'] && '2' === $settings['nav_layout'] ) {
            $nav_visibility = 'hover-on-visible' === $settings['nav_visibility'] ? $settings['nav_visibility'] : '';
        }
        if( 'yes' === $settings['slider_nav'] && 'yes' === $settings['nav_hide_mobile'] ) {
            $nav_mobile_view = 'mobile-none';
        }

        $this->add_render_attribute(
            'slider_wrapper',
            [
                'class' => [ 'mt-slider', 'swiper-container', $settings['fullscreen'], $nav_visibility, $nav_mobile_view ],
                'dir' => is_rtl() ? 'rtl' : $settings['text_direction'],
                'data-settings' => wp_json_encode( $data ),
            ]
        );
        if( $slider_items ) {
        ?>
        <div <?php echo $this->get_render_attribute_string( 'slider_wrapper' ); ?>>
            <div class="swiper-wrapper">
                <?php foreach( $slider_items as $slide ) : ?>
                <div class="swiper-slide elementor-repeater-item-<?php echo esc_attr( $slide['_id'] ) ; ?>">
                    <?php 
                    MT_Addons_Slider_Helper::get_slider_image( $settings, $slide );
                    if( 'yes' === $slide['slider_shape'] && 'angle_shape' === $slide['shape_style'] ) {
                        MT_Addons_Slider_Helper::get_slider_shapes( $slide );
                    }
                    if( 'yes' === $slide['slide_overlay'] ) {
                        echo '<div class="overlay"></div>';
                    }
                    ?>
                    <div class="slider-content-wrap text-<?php echo esc_attr($slide['content_align']); ?>">
                        <div class="content-width">
                            <?php 
                            if( 'yes' === $slide['slider_shape'] && 'border_shape' === $slide['shape_style'] ) {
                                MT_Addons_Slider_Helper::get_slider_shapes( $slide );
                            }
                            ?>
                            <div class="slider-content">
                                <?php
                                MT_Addons_Slider_Helper::get_sub_heading( $slide );
                                MT_Addons_Slider_Helper::get_heading( $slide );
                                MT_Addons_Slider_Helper::get_description( $slide );
                                $text_masking = 'yes' === $slide['text_masking'] ? ' text-masking' : '';
                                ?>
                                <div class="mt-btn-group<?php echo esc_attr( $text_masking ); ?>">
                                    <?php 
                                    MT_Addons_Slider_Helper::get_btn( $slide );
                                    MT_Addons_Slider_Helper::get_secondary_btn( $slide );
                                    MT_Addons_Slider_Helper::get_play_btn( $slide ); 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php
            MT_Addons_Slider_Helper::get_slider_controls( $settings['slider_nav'], $settings['slider_pagination'], $settings['nav_layout'], $settings['nav_long_arrow'], $pagiStyle, $settings['autoplay'] );
            ?>
            <div class="slider-preloader"><div class="dot-flashing"></div></div>
        </div>
        <?php
        }else{
            esc_html_e( 'No slides careated. Please create the slides from the Slides section.', 'mt-addons' );
        }
    }

}