<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use MT_Addons\includes\ContentControlHelp;

class mt_addons_progress_bar extends Widget_Base {

    public function get_style_depends() {
        wp_enqueue_style( 'mt-addons-progress-bar', MT_ADDONS_PUBLIC_ASSETS.'css/progress-bar.css');

        return [
            'mt-addons-progress-bar',
        ];
    }

    public function get_name()
    {
        return 'mtfe-progress-bar';
    }

    use ContentControlHelp;

    public function get_title()
    {
        return esc_html__('MT - Progress Bar', 'mt-addons');
    }

    public function get_icon() {
        return 'eicon-skill-bar';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }
    public function get_script_depends() {
      wp_enqueue_script( 'progressbar', MT_ADDONS_PUBLIC_ASSETS.'js/plugins/progressbar/progressbar.js' );   
      return [ 'jquery', 'elementor-frontend', 'progressbar', 'mt-addons-progressbar' ];
    }

    public function get_keywords() {
        return [ 'progressbar'];
    }

    protected function register_controls() {
        $this->section_progress_bar();
        $this->section_help_settings();
    }

    private function section_progress_bar() {
      $this->start_controls_section(
        'section_title',
        [
          'label'       => esc_html__( 'List Area', 'mt-addons' ),
        ]
      );
      $this->add_control(
        'bar_label',
        [
          'label'       => esc_html__('Title', 'mt-addons'),
          'type'        => \Elementor\Controls_Manager::TEXT,
          'default'     => esc_html__('Design', 'mt-addons'),
        ]
      );
      $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
          'label'       => esc_html__( 'Typography', 'mt-addons' ),
          'name'        => 'title_typography',
          'selector'    => '{{WRAPPER}} .mt-addons-progress-title',
        ]
      );
      $this->add_control(
        'text_color',
        [
          'label'       => esc_html__( 'Text Color', 'mt-addons' ),
          'type'        => Controls_Manager::COLOR,
              'default'   => '#111111',
          'selectors'   => [
            '{{WRAPPER}} .mt-addons-progress-title'         => 'color: {{VALUE}};',
            '{{WRAPPER}}  .mt-addons-progress-fixed-above'  => 'color: {{VALUE}}!important;',
          ],
        ]
      );
      $this->add_control(
        'progress_color',
        [
          'type'        => \Elementor\Controls_Manager::COLOR,
          'label'       => esc_html__( 'Color', 'mt-addons' ),
          'label_block' => true,
          'default'     => '#111111',
          'selectors'   => [
            '{{WRAPPER}}' => 'color: {{VALUE}}',
          ],
        ]
      ); 
      $this->add_control(
        'trail_color',
        [
          'type'        => \Elementor\Controls_Manager::COLOR,
          'label'       => esc_html__( 'Trail color', 'mt-addons' ),
          'label_block' => true,
          'default'     => '#ECECEC',
          'selectors'   => [
            '{{WRAPPER}} ' => 'color: {{VALUE}}',
          ],
        ]
      ); 
      $this->add_control( 
        'duration',
        [
          'label'       => esc_html__( 'Progress Speed (in ms)', 'mt-addons' ),
          'type'        => \Elementor\Controls_Manager::NUMBER,
          'default'     => 5000,
        ]
      );
      $this->add_control(
        'number',
        [
          'label'       => esc_html__( 'Progress Bar Value (0.0 to 1.0)', 'mt-addons' ),
          'type'        => \Elementor\Controls_Manager::NUMBER,
          'min'         => 0.0,
          'max'         => 1.0,
          'default'     => 0.55,
        ]
      );
      $this->add_control(
        'bar_stroke', 
        [
          'label'       => esc_html__( 'Progress Bar Stroke Value', 'mt-addons' ),
          'type'        => \Elementor\Controls_Manager::NUMBER,
          'default'     => 1,
        ]
      );
      $this->add_control(
        'bar_height',
        [
          'label'       => esc_html__( 'Progress Bar Height Value (%)', 'mt-addons' ),
          'type'        => \Elementor\Controls_Manager::NUMBER,
          'default'     => 6,
        ]
      );
      $this->add_control(
        'trail_height',
        [
          'label'       => esc_html__( 'Progress Bar trail Value', 'mt-addons' ),
          'type'        => \Elementor\Controls_Manager::NUMBER,
          'default'     => 6,
        ] 
      ); 
      $this->add_control(
        'percentage_type',
        [
          'label'       => esc_html__( 'Percentage Type', 'mt-addons' ),
          'label_block' => true,
          'type'        => Controls_Manager::SELECT,
          'default'     => 'mt-addons-progress-fixed-above',
          'options'     => [
            ''                                     => esc_html__( 'Select Option', 'mt-addons' ),
            'mt-addons-progress-floating-above'    => esc_html__( 'Floating Above', 'mt-addons' ),
            'mt-addons-progress-fixed-above'       => esc_html__( 'Fixed Above', 'mt-addons' ),
            'mt-addons-progress-floating-on'       => esc_html__( 'Floating On', 'mt-addons' ),
            'mt-addons-progress-fixed-on'          => esc_html__( 'Fixed On', 'mt-addons' ),
          ],
        ]
      );
    
      if (!function_exists('mt_addons_progressbar_attributes')) {
        function mt_addons_progressbar_attributes($id = '', $progress_color = '', $trail_color= '', $duration= '',$number= '' ,$bar_stroke= '', $bar_height= '', $trail_height= '', $percentage_type= ''){ ?>
          data-progressbar-id="<?php echo esc_attr($id); ?>"  
          data-progressbar-color="<?php echo esc_attr($progress_color); ?>"
          data-progressbar-trail-color="<?php echo esc_attr($trail_color); ?>"
          data-progressbar-duration="<?php echo esc_attr($duration); ?>"
          data-progressbar-data-number="<?php echo esc_attr($number); ?>"
          data-progressbar-data-bar-stroke="<?php echo esc_attr($bar_stroke); ?>"
          data-progressbar-data-bar-height="<?php echo esc_attr($bar_height); ?>"
          data-progressbar-data-trail-width="<?php echo esc_attr($trail_height); ?>"
          data-progressbar-percentage-type="<?php echo esc_attr($percentage_type); ?>"
          <?php 
        }
      }
      $this->end_controls_section();
    }

    protected function render() {
        $settings         = $this->get_settings_for_display();
        $bar_label        = $settings['bar_label'];
        $progress_color   = $settings['progress_color'];
        $trail_color      = $settings['trail_color'];
        $duration         = $settings['duration'];
        $number           = $settings['number'];
        $bar_stroke       = $settings['bar_stroke'];
        $bar_height       = $settings['bar_height'];
        $trail_height     = $settings['trail_height'];
        $percentage_type  = $settings['percentage_type'];

        $id = 'mt-addons-progress-bar-'.uniqid(); ?>      
        <div id="<?php echo esc_attr($id); ?>" 
          <?php mt_addons_progressbar_attributes( $id, $progress_color, $trail_color, $duration, $number, $bar_stroke , $bar_height, $trail_height, $percentage_type); ?> class="mt-addons-progress-bar">
            <div class="mt-addons-progress-content">
              <h6 class="mt-addons-progress-title <?php echo esc_attr($percentage_type); ?>"><?php echo esc_html($bar_label); ?> </h6>
            </div>
        </div>
    <?php } 

    protected function content_template() {}
}
