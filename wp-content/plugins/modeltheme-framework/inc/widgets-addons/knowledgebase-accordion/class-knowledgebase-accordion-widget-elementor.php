<?php
class Modeltheme_Knowledgebase_Accordion extends \Elementor\Widget_Base {
   public function get_style_depends() {
        wp_enqueue_style( 'modeltheme-knowledgebase-accordion', plugin_dir_url( __FILE__ ).'css/knowledgebase-accordion.css');
        return [
            'modeltheme-knowledgebase-accordion',
        ];
    }
     public function get_script_depends() {
        wp_enqueue_script( 'modeltheme-knowledgebase-accordion', plugin_dir_url( __FILE__ ).'js/knowledgebase-accordion.js');
        return [
            'modeltheme-knowledgebase-accordion',
        ];
    }

    public function get_name() {
        return 'mtfe-knowledgebase-accordion';
    }

    public function get_title() {
        return esc_html__('MT - Knowledgebase Accordion', 'modeltheme');
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_categories() {
        return [ 'mt-addons-widgets' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'modeltheme' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'heading_title',
            [
                'label' => __( 'Heading Title', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Heading Title', 'modeltheme' ),
            ]
        );

        $repeater = new \Elementor\Repeater(); 

        $terms = get_terms('mt-knowledgebase-category', ['hide_empty' => 0]);
        $categories = [];
        foreach ($terms as $term) {
            $categories[$term->slug] = $term->name;
        }

        $repeater->add_control(
            'category',
            [
                'label' => __( 'Category', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $categories,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'number',
            [
                'label' => __( 'Number of posts', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '5',
            ]
        );

        $repeater->add_control(
            'is_active',
            [
                'label' => __( 'Is Active', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'modeltheme' ),
                'label_off' => __( 'No', 'modeltheme' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => __( 'Accordion Items', 'modeltheme' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ category }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $heading_title = $settings['heading_title'];
        $items = $settings['items'];
        ?>

        <div class="knowledge-list-accordion knowledge-list-accordion-shortcode wow">
            <div class="knowledge-accordion">
                <ul id="accordion" class="accordion">
                    <?php foreach ($items as $item):
                        $category = $item['category'];
                        $number = $item['number'];
                        $is_active = $item['is_active'];

                        $args_knowledges = array(
                            'posts_per_page' => $number,
                            'orderby' => 'post_date',
                            'order' => 'DESC',
                            'post_type' => 'mt-knowledgebase',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'mt-knowledgebase-category',
                                    'field' => 'slug',
                                    'terms' => $category
                                )
                            ),
                            'post_status' => 'publish'
                        );

                        $knowledges = get_posts($args_knowledges);
                        $open_accordion = ($is_active === 'yes') ? 'default open' : '';
                        ?>
                        <li class="<?= esc_attr($open_accordion) ?>">
                            <div class="link"><?= esc_html($category) ?><i class="fa fa-chevron-right"></i></div>
                            <ul class="submenu">
                                <?php foreach ($knowledges as $knowledge):
                                    $currentClass = (get_the_ID() == $knowledge->ID) ? " current_post" : "";
                                    ?>
                                    <li class="post_title<?= esc_attr($currentClass) ?>">
                                        <a href="<?= get_permalink($knowledge->ID) ?>" title="<?= esc_attr($knowledge->post_title) ?>"><?= esc_html($knowledge->post_title) ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php
    }

    protected function _content_template() {}
}


