<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_image_badge_element extends Widget_Base {
    public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-image-badge-element', MT_ADDONS_PUBLIC_ASSETS.'css/image-badge-element.css');
        return [
            'mt-addons-absolute-element',
        ];
    }  
    use ContentControlHelp;
    public function get_name() {
        return 'mtfe-image-badge-element'; 
    }
    public function get_title() {
        return esc_html__('MT - Image Badge Element','mt-addons');
    }
    public function get_icon() {
        return 'eicon-elementor-circle';
    }
    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }
    protected function register_controls() {
        $this->section_absolute_element();
        $this->section_help_settings();
    }
    private function section_absolute_element() {
        $this->start_controls_section(
            'section_title',
            [
                'label'             => esc_html__( 'Content', 'mt-addons' ),
            ]
        );
        $this->add_control(
            'image_border_radius',
            [
                'label'             => esc_html__( 'Image Radius', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', '%', 'em' ],
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-absolute-element-absolute' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'           => [
                    'unit'              => 'px',
                    'top'               => 0,
                    'right'             => 0,
                    'bottom'            => 0,
                    'left'              => 0,
                ],
            ]
        );
        $this->add_control(
            'image', 
            [
                'label'             => esc_html__( 'Element Image', 'plugin-name' ),
                'type'              => \Elementor\Controls_Manager::MEDIA,
                'default'           => [
                    'url'               => MT_ADDONS_ASSETS.'/placeholder.png',
                ],
            ]
        );
        $this->add_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'textdomain' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'textdomain' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'textdomain' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .mtfeib-position' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title',
            [
                'type' => \Elementor\Controls_Manager::TEXT,
                'label' => esc_html__( 'Title', 'mt-addons' ),
                'placeholder' => esc_html__( 'Enter your title', 'mt-addons' ),
            ]
        );
        $this->add_control(
            'title_tag',
            [
                'label'             => esc_html__( 'Element tag', 'mt-addons' ),
                'label_block'       => true,
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    ''                  => esc_html__( 'Select', 'mt-addons' ),
                    'h1'                => 'h1',
                    'h2'                => 'h2',
                    'h3'                => 'h3',
                    'h4'                => 'h4',
                    'h5'                => 'h5',
                    'h6'                => 'h6',
                    'p'                 => 'p',

                ],
                'default'           => 'h2',
            ]
        );
        $this->add_control(
            'subtitle',
            [
                'type' => \Elementor\Controls_Manager::TEXT,
                'label' => esc_html__( 'Subtitle', 'mt-addons' ),
                'placeholder' => esc_html__( 'Enter your subtitle', 'mt-addons' ),
            ]
        );
        $this->add_control(
            'subtitle_tag',
            [
                'label'             => esc_html__( 'Element tag', 'mt-addons' ),
                'label_block'       => true,
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    ''                  => esc_html__( 'Select', 'mt-addons' ),
                    'h1'                => 'h1',
                    'h2'                => 'h2',
                    'h3'                => 'h3',
                    'h4'                => 'h4',
                    'h5'                => 'h5',
                    'h6'                => 'h6',
                    'p'                 => 'p',

                ],
                'default'           => 'p',
            ]
        );
        $this->add_control(
            'top_badge',
            [
                'type' => \Elementor\Controls_Manager::TEXT,
                'label' => esc_html__( 'Badge Top', 'mt-addons' ),
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control(
            'bottom_badge',
            [
                'label'     => esc_html__('Title', 'mt-addons'),
                'type'      => Controls_Manager::TEXT
            ]
        );
        $repeater->add_control(
            'badge_bottom_bg_color',
            [
                'label'             => esc_html__( 'Background Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'default'           => '#BF275E',
                'selectors'         => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} ' => 'background-color: {{VALUE}}',

                ],
            ]
        );
        $this->add_control(
            'badge_groups',
            [
                'label'     => esc_html__('Items', 'mt-addons'),
                'type'      => Controls_Manager::REPEATER,
                'fields'    => $repeater->get_controls(),
                'default'   => [
                    [
                        'bottom_badge'              => esc_html__( 'WPBakery ', 'mt-addons' ),
                        'badge_bottom_bg_color'     => esc_attr( '#ee2752 ', 'mt-addons' ),
                    ],
                    [
                        'bottom_badge'              => esc_html__( 'Elementor', 'mt-addons' ),
                        'badge_bottom_bg_color'     => esc_attr( '#0F73A6 ', 'mt-addons' ),
                    ],
                ],
            ]
        );
        $this->add_control(
            'badge_url',
            [
                'label'             => esc_html__( 'Link', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::URL,
                'placeholder'       => esc_html__( 'https://your-link.com', 'mt-addons' ),
                'default'           => [
                    'url'               => '#',
                    'is_external'       => true,
                    'nofollow'          => true,
                    'custom_attributes' => '',
                ],
                'label_block'       => true,
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'list_style',
            [
                'label'         => esc_html__( 'Style Title', 'mt-addons' ),
                'tab'           => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'fileds_typography_title',
                'label'             => esc_html__( 'Typography Title', 'mt-addons' ),
                'selector'          => '{{WRAPPER}} .mtfe-image-badge-title',
            ]
        );
        $this->add_control(
            'title_text_color',
            [
                'label'             => esc_html__( 'Title Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'default'           => '#111',
                'selectors'         => [
                    '{{WRAPPER}} .mtfe-image-badge-title' => 'color: {{VALUE}}',

                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'list_style_sub',
            [
                'label'         => esc_html__( 'Style subtitle', 'mt-addons' ),
                'tab'           => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'subtitle_text_color',
            [
                'label'             => esc_html__( 'Subtitle Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'default'           => '#111',
                'selectors'         => [
                    '{{WRAPPER}} .mtfe-image-badge-subtitle' => 'color: {{VALUE}}',

                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'fileds_typography_subtitle',
                'label'             => esc_html__( 'Typography Subtitle', 'mt-addons' ),
                'selector'          => '{{WRAPPER}} .mtfe-image-badge-subtitle',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'list_style_badge',
            [
                'label'         => esc_html__( 'Style Badge', 'mt-addons' ),
                'tab'           => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'fileds_typography_badge_bottom',
                'label'             => esc_html__( 'Typography Badge Bottom', 'mt-addons' ),
                'selector'          => '{{WRAPPER}} .mtfe-image-badge-builders',
            ]
        );
        $this->add_control(
            'badge_bottom_text_color',
            [
                'label'             => esc_html__( 'Text Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'default'           => '#fff',
                'selectors'         => [
                    '{{WRAPPER}} .mtfe-image-badge-builders' => 'color: {{VALUE}}',

                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'list_style_badge_top',
            [
                'label'         => esc_html__( 'Style Badge Top', 'mt-addons' ),
                'tab'           => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'fileds_typography_badge_top',
                'label'             => esc_html__( 'Typography Badge Top', 'mt-addons' ),
                'selector'          => '{{WRAPPER}} .mtfe-image-badge-text-top',
            ]
        );
        $this->add_control(
            'badge_top_text_color',
            [
                'label'             => esc_html__( 'Text Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'default'           => '#fff',
                'selectors'         => [
                    '{{WRAPPER}} .mtfe-image-badge-text-top' => 'color: {{VALUE}}',

                ],
            ]
        );
        $this->add_control(
            'badge_top_bg_color',
            [
                'label'             => esc_html__( 'Background Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'default'           => '#39B86B',
                'selectors'         => [
                    '{{WRAPPER}} .mtfe-image-badge-custom' => '--color-ribbon: {{VALUE}}; background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    
    }

    protected function render() {
        $settings       = $this->get_settings_for_display();
        $image_url      = $settings['image']['url'];
        $title          = $settings['title'];
        $subtitle       = $settings['subtitle'];
        $title_tag      = $settings['title_tag'];
        $subtitle_tag   = $settings['subtitle_tag'];
        $top_badge      = $settings['top_badge'];
        $badge_groups   = $settings['badge_groups'];
        $badge_url      = $settings['badge_url']['url'];

        ?>
        <a class="mtfe-image-badge-url" href="<?php echo esc_url($badge_url); ?>">
            <!-- Image -->
            <img class="mtfe-image-badge" src="<?php echo esc_url($image_url); ?>" alt="mtfe-image-badge"/>

            <!-- Top Badge (Optional) -->
            <?php if (!empty($top_badge)) { ?>
                <div class="mtfe-image-badge-wrapper">
                    <div class="mtfe-image-badge-custom">
                        <div class="mtfe-image-badge-text-top">
                            <span class="mtfe-image-badge-custom-top"><?php echo esc_html($top_badge); ?></span>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- Badge Group and Other Content -->
            <div class="mtfeib-position">
                <span class="mtfeib-block">
                    <?php if ($badge_groups) { ?>
                        <?php foreach ($badge_groups as $badge) {
                            $bottom_badge = array_key_exists('bottom_badge', $badge) ? $badge['bottom_badge'] : '';
                            ?>
                            <div class="mtfe-image-badge-builders elementor-repeater-item-<?php echo esc_attr($badge['_id']); ?>">
                                <?php echo esc_html($bottom_badge); ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </span>
                <<?php echo Utils::validate_html_tag($title_tag); ?> class="mtfe-image-badge-title">
                    <?php echo esc_html($title); ?>
                </<?php echo Utils::validate_html_tag($title_tag); ?>>
                <<?php echo Utils::validate_html_tag($subtitle_tag); ?> class="mtfe-image-badge-subtitle">
                    <?php echo esc_html($subtitle); ?>
                </<?php echo Utils::validate_html_tag($subtitle_tag); ?>>
            </div>
        </a>

    <?php
    }

    protected function content_template() {
    }
}