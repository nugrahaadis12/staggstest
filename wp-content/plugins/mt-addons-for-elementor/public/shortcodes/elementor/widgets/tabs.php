<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Utils;
use MT_Addons\includes\ContentControlHelp;

class mt_addons_tabs extends Widget_Base {
    
    public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-tabs', MT_ADDONS_PUBLIC_ASSETS.'css/tabs.css');
        return [
            'mt-addons-tabs',
        ];
    }

    public function get_name() {
        return 'mtfe-tabs';
    }
    use ContentControlHelp;

    public function get_title() {
        return esc_html__('MT - Tabs','mt-addons');
    }
    public function get_icon() {
        return 'eicon-tabs';
    }
    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    } 

    protected function register_controls() {
        $this->section_tabs();
        $this->section_help_settings();
    }

    private function section_tabs() {
        $this->start_controls_section(
            'section_title',
            [
                'label'             => esc_html__( 'Content', 'mt-addons' ),
            ]
        );
        $this->add_control(
            'background_color',
            [
                'type'              => \Elementor\Controls_Manager::COLOR,
                'label'             => esc_html__( 'Tab Backgroung (active)', 'mt-addons' ),
                'label_block'       => true,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-tabs-nav' => 'background: {{VALUE}}',
                ],
                'default'           => '#3147FF',
            ]
        ); 
        $this->add_control(
            'tab_text',
            [
                'type'              => \Elementor\Controls_Manager::COLOR,
                'label'             => esc_html__( 'Tab Text Color', 'mt-addons' ),
                'label_block'       => true,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-tabs-nav-title' => 'color: {{VALUE}}',
                ],
                'default'           => '#000000',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'          => 'title_typography',
                'label'         => esc_html__( 'Title Typography', 'mt-addons' ),
                'selector'      => '{{WRAPPER}} .mt-addons-tab-content-title',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'          => 'button_typography',
                'label'         => esc_html__( 'Button Typography', 'mt-addons' ),
                'selector'      => '{{WRAPPER}} .mt-addons-tab-content-button',
            ]
        );
        // start repeater
        $repeater = new Repeater();
        $repeater->add_control(
            'image', 
            [
                'label'             => esc_html__( 'Tab Icon', 'plugin-name' ),
                'type'              => Controls_Manager::MEDIA,
                'default'           => [
                    'url'           => Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater->add_control(
            'title',
            [
                'label'             => esc_html__( 'Tab Title', 'mt-addons' ),
                'label_block'       => true,
                'type'              => Controls_Manager::TEXT,
                'default'           => esc_html__('Live Draws','mt-addons'),
            ]
        );
        $repeater->add_control(
            'desc_image', 
            [
                'label'             => esc_html__( 'Description Image', 'plugin-name' ),
                'type'              => Controls_Manager::MEDIA,
                'default'           => [
                    'url'           => Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater->add_control(
            'desc_title',
            [
                'label'             => esc_html__( 'Description Title', 'mt-addons' ),
                'label_block'       => true,
                'type'              => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'desc_content',
            [
                'label'             => esc_html__( 'Description Content', 'mt-addons' ),
                'label_block'       => true,
                'type'              => Controls_Manager::TEXTAREA,
            ]
        );
         $repeater->add_control(
            'button_text',
            [
                'label'             => esc_html__( 'Button text', 'mt-addons' ),
                'type'              => Controls_Manager::TEXT,
                'default'           => esc_html__('View Collection','mt-addons'),
            ]
        );
        $repeater->add_control(
            'button_url',
            [
                'label'             => esc_html__( 'Button URL', 'mt-addons' ),
                'type'              => Controls_Manager::TEXT,
                'default'           => '#',
            ]
        );
        $repeater->add_control(
            'button_color',
            [
                'type'              => \Elementor\Controls_Manager::COLOR,
                'label'             => esc_html__( 'Button Color', 'mt-addons' ),
                'label_block'       => true,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-tab-content-button' => 'color: {{VALUE}}',
                ],
                'default'           => '#ffffff',
            ]
        ); 
        $repeater->add_control(
            'button_bg_color',
            [
                'type'              => \Elementor\Controls_Manager::COLOR,
                'label'             => esc_html__( 'Background Color', 'mt-addons' ),
                'label_block'       => true,
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-tab-content-button' => 'background-color: {{VALUE}}',
                ],
                'default'           => '#3147FF',
            ]
        );
        $this->add_control(
            'category_tabs',
            [
                'label'             => esc_html__( 'Tabs Items', 'mt-addons' ),
                'type'              => Controls_Manager::REPEATER,
                'fields'            => $repeater->get_controls(),
                'default'           => [
                    [
                        'title'             => esc_html__( 'Live Draws', 'mt-addons' ),
                        'desc_title'        => esc_html__( 'Live Draws', 'mt-addons' ),
                        'desc_content'      => esc_html__( 'Duis porttitor, turpis sollicitudin maximus bibendum, eros sapien feugiat magna, id interdum ex justo ut dolor. Nulla facilisis urna sed ipsum euismod porta. Cras maximus commodo purus, eget accumsan purus. Integer semper massa nec lectus blandit malesuada.', 'mt-addons' ),
                        'button_text'       => esc_html__( 'View Collection', 'mt-addons' ),
                        'button_url'        => esc_url( '#', 'mt-addons' ),
                        'button_color'      => esc_attr( '#fff', 'mt-addons' ),
                        'button_bg_color'   => esc_attr( '#3147FF', 'mt-addons' ),
                        
                    ],
                    [
                        'title'             => esc_html__( 'Entry Lists', 'mt-addons' ),
                        'desc_title'        => esc_html__( 'Entry Lists', 'mt-addons' ),
                        'desc_content'      => esc_html__( 'Duis porttitor, turpis sollicitudin maximus bibendum, eros sapien feugiat magna, id interdum ex justo ut dolor. Nulla facilisis urna sed ipsum euismod porta. Cras maximus commodo purus, eget accumsan purus. Integer semper massa nec lectus blandit malesuada.', 'mt-addons' ),
                        'button_text'       => esc_html__( 'View Collection', 'mt-addons' ),
                        'button_url'        => esc_url( '#', 'mt-addons' ),
                        'button_color'      => esc_attr( '#fff', 'mt-addons' ),
                        'button_bg_color'   => esc_attr( '#3147FF', 'mt-addons' ),
                    ],
                    [
                        'title'             => esc_html__( 'Charities', 'mt-addons' ),
                        'desc_title'        => esc_html__( 'Charities', 'mt-addons' ),
                        'desc_content'      => esc_html__( 'Duis porttitor, turpis sollicitudin maximus bibendum, eros sapien feugiat magna, id interdum ex justo ut dolor. Nulla facilisis urna sed ipsum euismod porta. Cras maximus commodo purus, eget accumsan purus. Integer semper massa nec lectus blandit malesuada.', 'mt-addons' ),
                        'button_text'       => esc_html__( 'View Collection', 'mt-addons' ),
                        'button_url'        => esc_url( '#', 'mt-addons' ),
                        'button_color'      => esc_attr( '#fff', 'mt-addons' ),
                        'button_bg_color'   => esc_attr( '#3147FF', 'mt-addons' ),
                    ],
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_content_border',
            [
                'label'             => esc_html__( 'Buttons Border Radius', 'mt-addons' ),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => ['px', '%', 'em'],
                'selectors'         => [
                    '{{WRAPPER}} .mt-addons-tab-content-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }
    protected function render() {
        $settings               = $this->get_settings_for_display();
        $category_tabs          = $settings['category_tabs'];
        $background_color       = $settings['background_color'];
        $tab_text               = $settings['tab_text'];
       
        ?>
        <div class="mt-addons-tabs">
            <nav>
                <ul class="mt-addons-tabs-nav"> 
                    <?php $tab_id = 1; ?>
                    <?php if ($category_tabs) { ?>
                        <?php foreach ($category_tabs as $tab) {
                            if (!array_key_exists('title', $tab)) {
                                $title = '';
                            }else{
                                $title = $tab['title'];
                            }
                            $image = $tab['image']['url'];
                            $url_link = $tab['title'];
                            ?>  
                            <li><a href="#section-iconbox-<?php echo esc_attr($tab_id);?>"> 
                                <img class="mt-addons-tabs-nav-icon" src="<?php echo esc_url($image); ?>" alt="mt-addons-icon">
                                <h5 class="mt-addons-tabs-nav-title"><?php echo esc_html($title);?></h5></a>
                            </li> 
                        <?php $tab_id++; ?>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </nav>
            <div class="mt-addons-tab-content">
                <?php $content_id = 1; ?>
                <?php if ($category_tabs) { ?>
                  <?php foreach ($category_tabs as $tab) { 
                    if (!array_key_exists('desc_title', $tab)) {
                        $desc_title = '';
                    }else{
                        $desc_title = $tab['desc_title'];
                    }
                    if (!array_key_exists('desc_content', $tab)) {
                        $desc_content = '';
                    }else{
                        $desc_content = $tab['desc_content'];
                    }
                    $desc_image = $tab['desc_image']['url'];
                    $url_link = $tab['button_url'];
                    ?>
                    <section id="section-iconbox-<?php echo esc_attr($content_id);?>">
                        <div class="mtfe-row">
                            <div class="col-md-6 mtfe-first-section">
                                <img class="mt-addons-tab-content-image" src="<?php echo esc_url($desc_image); ?>" alt="tabs-image">
                            </div>
                            <div class="col-md-6 mtfe-second-section">
                                <h3 class="mt-addons-tab-content-title"><?php echo esc_html($desc_title); ?></h3>
                                <p class="mt-addons-tab-content"><?php echo esc_html($desc_content); ?></p>
                                 <?php if($url_link != ''){ ?>
                                  <a class="mt-addons-tab-content-button"
                                  href="<?php echo esc_url($url_link); ?>" >
                                     <?php echo esc_html($tab['button_text']); ?>
                                  </a>
                                 <?php } ?>
                            </div>
                        </div>                     
                    </section>
                    <?php $content_id++; ?>
                  <?php } ?>
                <?php } ?>
            </div>
        </div>
        <?php 
    } 
    protected function content_template() {

    }
}