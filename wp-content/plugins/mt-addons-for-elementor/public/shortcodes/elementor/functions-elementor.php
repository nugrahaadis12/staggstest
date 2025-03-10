<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}
require_once('widgets/slider/slider.php');

class MT_Addons_For_Elementor_Widgets {

	protected static $instance = null;

	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	protected function __construct() {
		require_once('widgets/slider/includes/widget/slider.php');
		require_once('widgets/title-subtitle.php');
		require_once('widgets/button-widget.php');
		require_once('widgets/icon-with-text.php');
		require_once('widgets/blog-posts.php');
		require_once('widgets/members.php');
		require_once('widgets/clients.php');
		require_once('widgets/testimonials.php');
		require_once('widgets/video.php');
		require_once('widgets/social-icon-box.php');
		require_once('widgets/circle-text.php');
		require_once('widgets/absolute-element.php');
		require_once('widgets/spacer.php');
		require_once('widgets/hero-slider.php');
		require_once('widgets/process.php');
		require_once('widgets/skill-counter.php');
		require_once('widgets/tabs.php');
		require_once('widgets/accordion.php');
		require_once('widgets/highlighted-text.php');
		require_once('widgets/row-overlay.php');
		require_once('widgets/map-pins.php');
		require_once('widgets/before-after-comparison.php');
		require_once('widgets/marquee-texts-hero.php');
		require_once('widgets/posts-a-z.php');
		require_once('widgets/timeline.php');
		require_once('widgets/svg-blob.php');
		require_once('widgets/stylized-numbers.php');
		require_once('widgets/typed-text.php');
		require_once('widgets/contact-card.php');
    require_once('widgets/pricing-services.php');
    require_once('widgets/pricing-table-v2.php');
    require_once('widgets/category-card.php');
    require_once('widgets/sale-banner.php');
    require_once('widgets/horizontal-timeline.php');
		require_once('widgets/niche-categories.php');
		require_once('widgets/week-days.php');
		require_once('widgets/cta-banner.php');
		require_once('widgets/icon-box-grid-item.php');
		require_once('widgets/tabs-style-v2.php');
		require_once('widgets/ticker.php');
		require_once('widgets/portfolio-grid-images.php');
		require_once('widgets/progress-bar.php');
		if ( function_exists( 'is_woocommerce' ) ) {
			require_once('widgets/featured-product.php');
			require_once('widgets/products-filters.php');
			require_once('widgets/products-category-list.php');
			require_once('widgets/category-tabs.php');
			require_once('widgets/products-category-banner.php');
			require_once('widgets/products-carousel.php');
			require_once('widgets/products-category-group.php');
		}
		require_once('widgets/image-with-badge.php');

		if (is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
			require_once('widgets/contact-form.php');
		}
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
	}

	public function register_widgets() {
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_slider() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_title_subtitle() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_button_widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_icon_with_text() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_blog_posts() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_members() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_clients() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_testimonials() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_video() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_mt_social_icon_box() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_circle_text() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_absolute_element() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_spacer() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_hero_slider() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_process() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_skill_counter() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_tabs() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_accordion() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_highlighted_text() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_row_overlay() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_map_pins() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_before_after_comparison() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_marquee_texts_hero() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_posts_a_z() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_timeline() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_svg_blob() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_stylized_numbers() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_typed_text() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_contact_card() );
    \Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_pricing_services() );
    \Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_pricing_table_v2() );
    \Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_category_card() );
    \Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_sale_banner() );
    \Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_horizontal_timeline() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_niche_categories() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_week_days() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_cta_banner() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_icon_box_grid_item() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_tabs_style_v2() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_ticker() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_portfolio_images() );
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_progress_bar() );
		if ( function_exists( 'is_woocommerce' ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_featured_product() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_products_filters() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_products_category_list() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_category_tabs() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_products_category_banner() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_products_carousel() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_products_category_group() );
		}
		if (is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
			\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_contact_form() );
		}
		\Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\mt_addons_image_badge_element() );
	}
}

add_action( 'init', 'mt_addons_elementor_widgets_init' );
function mt_addons_elementor_widgets_init() {
	MT_Addons_For_Elementor_Widgets::get_instance();
}

function mt_addons_add_elementor_widget_categories( $elements_manager ) {

	$elements_manager->add_category(
		'mt-addons-widgets',
		[
			'title' 	=> esc_html__( 'MT Addons', 'mt-addons' ),
			'icon' 		=> 'fa fa-plug',
		]
	);

}
add_action( 'elementor/elements/categories_registered', 'mt_addons_add_elementor_widget_categories' );