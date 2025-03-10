<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_horizontal_timeline extends Widget_Base {
    public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-horizontal-timeline', MT_ADDONS_PUBLIC_ASSETS.'css/horizontal-timeline.css');

        return [
            'mt-addons-horizontal-timeline',
        ];
    }

    public function get_script_depends() {
        wp_enqueue_script( 'util', MT_ADDONS_PUBLIC_ASSETS.'js/plugins/horizontal-timeline/util.min.js');
        wp_enqueue_script( 'swipe-content', MT_ADDONS_PUBLIC_ASSETS.'js/plugins/horizontal-timeline/swipe-content.min.js');
        wp_enqueue_script( 'mt-addons-horizontal-timeline', MT_ADDONS_PUBLIC_ASSETS.'js/plugins/horizontal-timeline/horizontal-timeline.min.js');
        return [
            'util',
            'swipe-content',
            'mt-addons-horizontal-timeline',
        ];
    }


    public function get_name()
    {
        return 'mtfe-horizontal-timeline';
    }

    use ContentControlHelp;

    public function get_title()
    {
        return esc_html__('MT - Horizontal Timeline', 'mt-addons');
    }

    public function get_icon() {
        return 'eicon-time-line';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    public function get_keywords() {
        return [ 'timeline', 'horizontal', 'custom' ];
    }

    protected function register_controls() {
        $this->section_horizontal_timeline();
        $this->section_help_settings();
    }

    private function section_horizontal_timeline() {
        $this->start_controls_section(
            'content_section',
            [
                'label'             => esc_html__( 'Text Section', 'mt-addons' ),
                'tab'               => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater1 = new \Elementor\Repeater();
        $repeater2 = new \Elementor\Repeater();
        $repeater1->add_control(
            'date', [
                'label'             => esc_html__( 'Date', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::TEXT,
                'default'           => esc_html__( '14/08/2022' , 'mt-addons' ),
                'placeholder'       => esc_html__( 'dd/mm/yyyy', 'mt-addons' ),
                'label_block'       => true,
            ]
        );
        $repeater1->add_control(
            'date_title', [
                'label'             => esc_html__( 'Date Title', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::TEXT,
                'default'           => esc_html__( '2018' , 'mt-addons' ),
                'label_block'       => true,
            ]
        );
        $this->add_control(
            'list1',
            [
                'label'             => esc_html__( 'Date Items', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::REPEATER,
                'fields'            => $repeater1->get_controls(),
                'default'           => [
                    [
                        'date'          => esc_html__( '14/08/2022', 'mt-addons' ),
                        'date_title'    => esc_html__( '2020', 'mt-addons' ),
                    ],
                ]
            ]
        );
        $repeater2->add_control(
            'image',
            [
                'label'             => esc_html__( 'Choose Image', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::MEDIA,
                'default'           => [
                    'url'               => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater2->add_control(
            'timeline_title',
            [
                'label'             => esc_html__( 'Title', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::TEXT,
                'default'           => esc_html__( '2024', 'mt-addons' ),
                'placeholder'       => esc_html__( 'Type your title here', 'mt-addons' ),
            ]
        );

        $repeater2->add_control(
            'timeline_description',
            [
                'label'             => esc_html__( 'Description', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::TEXTAREA,
                'rows'              => 5,
                'default'           => esc_html__('Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa.', 'mt-addons' ),
                'placeholder'       => esc_html__( 'Type your description here', 'mt-addons' ),
            ]
        );
        $this->add_control(
            'list2',
            [
                'label'             => esc_html__( 'Description Items', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::REPEATER,
                'fields'            => $repeater2->get_controls(),
                'default'           => [
                    [
                    'timeline_title'        => esc_html__( '2020', 'mt-addons' ),
                    'timeline_description'  => esc_html__( 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa.', 'mt-addons' ),
                    ],
                ]
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style_section',
            [
                'label'             => esc_html__( 'Timeline Style', 'mt-addons' ),
                'tab'               => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'show_image',
            [
                'label'             => esc_html__( 'Show Image', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::SWITCHER,
                'label_on'          => esc_html__( 'Show', 'mt-addons' ),
                'label_off'         => esc_html__( 'Hide', 'mt-addons' ),
                'return_value'      => 'yes',
                'default'           => 'yes',
            ]
        );
        $this->add_control(
            'text_align',
            [
                'label'             => esc_html__( 'Text Aligment', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::CHOOSE,
                'options'           => [
                    'left'              => [
                        'title'         => esc_html__( 'Left', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-left',
                    ],
                    'center'            => [
                        'title'         => esc_html__( 'Center', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-center',
                    ],
                    'right'             => [
                        'title'         => esc_html__( 'Right', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-right',
                    ],
                ],
                'default'           => 'center',
                'toggle'            => true,
                'selectors'         => [
                    '{{WRAPPER}} .mt-timeline__event-title'         => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .mt-timeline__event-description'   => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'image_align',
            [
                'label'             => esc_html__( 'Image Alignment', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::CHOOSE,
                'options'           => [
                    'flex-start'        => [
                        'title'         => esc_html__( 'Left', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-left',
                    ],
                    'center'        => [
                        'title'         => esc_html__( 'Center', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-center',
                    ],
                    'flex-end'      => [
                        'title'         => esc_html__( 'Right', 'mt-addons' ),
                        'icon'          => 'eicon-text-align-right',
                    ],
                ],
                'selectors'         => [
                    '{{WRAPPER}} .mt-timeline-img-wrapper' => 'justify-content: {{VALUE}}',
                ],
                'default'           => 'center',
                'toggle'            => true,
                'condition'         => [
                    'show_image'        => 'yes',
                ],
            ]
        );
        $this->add_control(
            'image_width',
            [
                'label'             => esc_html__( 'Image Width', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::NUMBER,
                'min'               => 1,
                'max'               => 9999,
                'step'              => 1,
                'selectors'         => [
                    '{{WRAPPER}} .mt-timeline-img-wrapper img' => 'width: {{VALUE}}px',
                ],
                'default'           => 350,
                'condition'         => [
                    'show_image'        => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'              => 'title_typography',
                'label'             => esc_html__( 'Title Typography', 'mt-addons' ),
                'selector'          => '{{WRAPPER}} .mt-timeline__mt-timeline__event-title',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'              => 'description_typography',
                'label'             => esc_html__( 'Description Typography', 'mt-addons' ),
                'selector'          => '{{WRAPPER}} .mt-timeline__event-description',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label'             => esc_html__( 'Date Title Typography', 'mt-addons' ),
                'name'              => 'date_title_typography',
                'selector'          => '{{WRAPPER}} .mt-timeline__date',
            ]
        );
        $this->add_control(
            'timeline_color',
            [
                'label'             => esc_html__( 'Timeline Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}}  .mt-timeline__date::after'            => 'border-color: {{VALUE}}',
                    '{{WRAPPER}}  .mt-timeline__date--selected::after'  => 'background-color: {{VALUE}}',
                    '{{WRAPPER}}  .mt-timeline__filling-line'           => 'background-color: {{VALUE}}',
                    '{{WRAPPER}}  .mt-timeline__date:hover::after'      => 'background-color: {{VALUE}}',
                    '{{WRAPPER}}  .mt-timeline__date--selected'         => 'color: {{VALUE}}',
                    '{{WRAPPER}}  .mt-timeline__navigation:hover'       => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label'             => esc_html__( 'Icon Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}}  .text-replace' => 'color: {{VALUE}}',
                ],
                'default'           => '#ED137D',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'             => esc_html__( 'Title Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}}  .mt-timeline__event-title' => 'color: {{VALUE}}',
                ],
                'default'           => '#ED137D',
            ]
        );
        $this->add_control(
            'description_color',
            [
                'label'             => esc_html__( 'Description Color', 'mt-addons' ),
                'type'              => \Elementor\Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}}  .mt-timeline__event-description' => 'color: {{VALUE}}',
                ],
                'default'           => '#000000',
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings   = $this->get_settings_for_display();
        $list1      = $settings['list1'];
        $list2      = $settings['list2'];
        $show_image = $settings['show_image'];
        ?>

        <section class="mt-timeline js-mt-timeline margin-bottom-md">
            <div class="mt-timeline__container mtfe-container">
                <ul>
                    <li><a href="#0" class="text-replace mt-timeline__navigation mt-timeline__navigation--prev mt-timeline__navigation--inactive"><i class="fas fa-arrow-right"></i></a></li>
                    <li><a href="#0" class="text-replace mt-timeline__navigation mt-timeline__navigation--next"><i class="fas fa-arrow-right"></i></a></li>
                </ul>
                <div class="mt-timeline__dates">
                    <div class="mt-timeline__line">
                        <ol>
                            <?php
                            if ($list1) {
                                foreach ($list1 as $index => $newdate) {
                                    $date = $newdate['date'];
                                    $date_title = $newdate['date_title'];
                                    $date_selected = ($index === 0) ? 'mt-timeline__date--selected' : '';
                                    ?>
                                    <li><a href="#0" data-date="<?php echo esc_attr($date); ?>"
                                   class="mt-timeline__date <?php echo esc_attr($date_selected); ?>"><?php echo esc_html($date_title); ?></a></li>
                                <?php }
                            } ?>
                        </ol>
                        <span class="mt-timeline__filling-line" aria-hidden="true"></span>
                    </div>
                </div>
            </div>

            <div class="mt-timeline__events">
                <ol>
                    <?php foreach ($list2 as $newdescription) {
                        $image          = $newdescription['image']['url'];
                        $title          = $newdescription['timeline_title'];
                        $description    = $newdescription['timeline_description'];
                        ?>
                        <li class="mt-timeline__event text-component">
                            <div class="mt-timeline__event-content mtfe-container">
                                <?php if ($show_image == 'yes') { ?>
                                    <div class="mt-timeline-img-wrapper">
                                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>"/>
                                    </div>
                                <?php } ?>
                                <h2 class="mt-timeline__event-title"><?php echo esc_html__($title); ?></h2>
                                <p class="mt-timeline__event-description color-contrast-medium">
                                    <?php echo esc_html($description); ?>
                                </p>
                            </div>
                        </li>
                    <?php } ?>
                </ol>
            </div>
        </section>

    <?php
    }

    protected function content_template() {}
}