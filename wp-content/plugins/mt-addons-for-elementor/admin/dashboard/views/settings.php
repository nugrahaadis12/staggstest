<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$all_free_widgets = array(
    'business'    => array(
        'title'              => esc_html__( 'Business Widgets', 'mt-addons' ),
        'blog_posts'         => array(
            'name'             => esc_html__( 'Blog Posts', 'mt-addons' ),
            'status'           => 'on',
            'premium'          => '',
            'presentation_url' => 'blog-posts',
        ),
        'category_card'      => array(
            'name'             => esc_html__( 'Category Cards', 'mt-addons' ),
            'status'           => 'on',
            'premium'          => '',
            'presentation_url' => 'category-card',
        ),
        'clients'            => array(
            'name'             => esc_html__( 'Clients', 'mt-addons' ),
            'status'           => 'on',
            'premium'          => '',
            'presentation_url' => 'clients',
        ),
        'icon_box_grid_item' => array(
            'name'             => esc_html__( 'Icon Box Grid Item', 'mt-addons' ),
            'status'           => 'on',
            'premium'          => '',
            'presentation_url' => 'icon-box-grid-item',
        ),
        'map_pins'           => array(
            'name'             => esc_html__( 'Map Pins', 'mt-addons' ),
            'status'           => 'on',
            'premium'          => '',
            'presentation_url' => 'map-pins',
        ),
        'members'            => array(
            'name'             => esc_html__( 'Members', 'mt-addons' ),
            'status'           => 'on',
            'premium'          => '',
            'presentation_url' => 'members',
        ),
        'portfolio_images'   => array(
            'name'             => esc_html__( 'Portfolio Grid Images', 'mt-addons' ),
            'status'           => 'on',
            'premium'          => '',
            'presentation_url' => 'portfolio-grid-images',
        ),
        'posts_a_z'          => array(
            'name'             => esc_html__( 'Posts A-Z', 'mt-addons' ),
            'status'           => 'on',
            'premium'          => '',
            'presentation_url' => 'posts-a-z',
        ),
        'pricing_services'   => array(
            'name'             => esc_html__( 'Pricing Services', 'mt-addons' ),
            'status'           => 'on',
            'premium'          => '',
            'presentation_url' => 'pricing-services',
        ),
        'pricing_table_v2'   => array(
            'name'             => esc_html__( 'Pricing Tables', 'mt-addons' ),
            'status'           => 'on',
            'premium'          => '',
            'presentation_url' => 'pricing-table-v2',
        ),
        'sale_banner'        => array(
            'name'             => esc_html__( 'Sale Banner', 'mt-addons' ),
            'status'           => 'on',
            'premium'          => '',
            'presentation_url' => 'sale-banner',
        ),
        'video'              => array(
            'name'             => esc_html__( 'Section Video', 'mt-addons' ),
            'status'           => 'on',
            'premium'          => '',
            'presentation_url' => 'video',
        ),
    ),
    'creative'    => array(
        'title'               => esc_html__( 'Creative Widgets', 'mt-addons' ),
        'circle_text'         => array(
            'name'             => esc_html__( 'Circle Text', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'circle-text',
        ),
        'marquee_texts_hero'  => array(
            'name'             => esc_html__( 'Marquee Texts Hero', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'marquee-texts-hero',
        ),
        'niche_categories'    => array(
            'name'             => esc_html__( 'Niche Categories', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'niche-categories',
        ),
        'row_overlay'         => array(
            'name'             => esc_html__( 'Row Overlay', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'row-overlay',
        ),
        'svg_blob'            => array(
            'name'             => esc_html__( 'SVG Blob', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'svg-blob',
        ),
        'social_icons_box'    => array(
            'name'             => esc_html__( 'Social Icon Box', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'social-icons-box',
        ),
        'timeline'            => array(
            'name'             => esc_html__( 'Timeline', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'timeline',
        ),
        'horizontal_timeline' => array(
            'name'             => esc_html__( 'Horizontal Timeline', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'horizontal-timeline',
        ),
        'hero_slider'         => array(
            'name'             => esc_html__( 'Hero Slider', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'hero-slider',
        ),
        'slider'              => array(
            'name'             => esc_html__( 'Slider', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'slider',
        ),
    ),
    'showcase'    => array(
        'title'                   => esc_html__( 'Showcase Widgets', 'mt-addons' ),
        'absolute_element'        => array(
            'name'             => esc_html__( 'Absolute Element', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'absolute-element',
        ),
        'accordion'               => array(
            'name'             => esc_html__( 'Accordion', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'accordion',
        ),
        'before_after_comparison' => array(
            'name'             => esc_html__( 'Before/After Comparison', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'before-after-comparison',
        ),
        'contact_card'            => array(
            'name'             => esc_html__( 'Contact Card', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'contact-card',
        ),
        'contact_form'            => array(
            'name'             => esc_html__( 'Contact Form', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'contact-form',
        ),
        'process'                 => array(
            'name'             => esc_html__( 'Process', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'process',
        ),
        'progress_bar'            => array(
            'name'             => esc_html__( 'Progress Bar', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'progress-bar',
        ),
        'skill_counter'           => array(
            'name'             => esc_html__( 'Skill Counter', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'skill-counter',
        ),
        'tabs'                    => array(
            'name'             => esc_html__( 'Tabs v1', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'tabs',
        ),
        'tabs_style_v2'           => array(
            'name'             => esc_html__( 'Tabs v2', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'tabs-style-v2',
        ),
        'testimonials'            => array(
            'name'             => esc_html__( 'Testimonials', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'testimonials',
        ),
        'week_days'               => array(
            'name'             => esc_html__( 'Week Days', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'week-days',
        ),
    ),
    'typography'  => array(
        'title'            => esc_html__( 'Typography Widgets', 'mt-addons' ),
        'buttons'          => array(
            'name'             => esc_html__( 'Buttons', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'button-widget',
        ),
        'cta_banner'       => array(
            'name'             => esc_html__( 'CTA Banner', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'cta-banner',
        ),
        'highlighted_text' => array(
            'name'             => esc_html__( 'Highlighted Text', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'addons-highlighted-text',
        ),
        'icon_with_text'   => array(
            'name'             => esc_html__( 'Icon with Text', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'icon-with-text',
        ),
        'number'           => array(
            'name'             => esc_html__( 'Number', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'number',
        ),
        'typed_text'       => array(
            'name'             => esc_html__( 'Typeout Text', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'typed-text',
        ),
        'title_subtitle'   => array(
            'name'             => esc_html__( 'Title & Subtitle', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'title-subtitle',
        ),
        'ticker'           => array(
            'name'             => esc_html__( 'Ticker', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'ticker',
        ),
    ),
    'woocommerce' => array(
        'title'                    => esc_html__( 'WooCommerce Widgets', 'mt-addons' ),
        'featured_product'         => array(
            'name'             => esc_html__( 'Featured Product', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'featured-product',
        ),
        'products_category_group'  => array(
            'name'             => esc_html__( 'Products Category Group', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'products-category-group',
        ),
        'category_tabs'            => array(
            'name'             => esc_html__( 'Category Tabs', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'category-tabs',
        ),
        'category_tabs'            => array(
            'name'             => esc_html__( 'Category Tabs', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'category-tabs',
        ),
        'products_filters'         => array(
            'name'             => esc_html__( 'Products Filters', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'products-filters',
        ),
        'products_carousel'        => array(
            'name'             => esc_html__( 'Products Carousel', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'products-carousel',
        ),
        'products_category_list'   => array(
            'name'             => esc_html__( 'Products Category List', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'products-category-list',
        ),
        'products_category_banner' => array(
            'name'             => esc_html__( 'Products With Category Banner', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => '',
            'presentation_url' => 'products-category-banner',
        ),
    ),
);
$all_premium_widgets = array(
    'business'    => array(
        'title'              => esc_html__( 'Business Widgets', 'mt-addons' ),
        'mailchimp'          => array(
            'name'             => esc_html__( 'Mailchimp Forms', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/mailchimp',
        ),
        'onepage_navigation' => array(
            'name'             => esc_html__( 'OnePage Navigation', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/onepage-navigation',
        ),
        'services_carousel'  => array(
            'name'             => esc_html__( 'Services Carousel', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/services-carousel',
        ),
        'blog_card_slider'   => array(
            'name'             => esc_html__( 'Blog Card Slider', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/blog-card-slider',
        ),
        'content_switcher'   => array(
            'name'             => esc_html__( 'Toggle Switcher', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/toggle-switcher',
        ),
    ),
    'creative'    => array(
        'title'         => esc_html__( 'Creative Widgets', 'mt-addons' ),
        'lottie'        => array(
            'name'             => esc_html__( 'Lottie Animation', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => '#',
        ),
        'image_tilt'    => array(
            'name'             => esc_html__( 'Image Tilt', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/image-tilt',
        ),
        'hexagon_photo' => array(
            'name'             => esc_html__( 'Hexagon Photo Gallery', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/hexagon-photo-gallery',
        ),
        'hover_cards'   => array(
            'name'             => esc_html__( 'Hover Cards', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/hover-cards',
        ),
        'shaped_video'  => array(
            'name'             => esc_html__( 'Shaped Video', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/shaped-video',
        ),
    ),
    'showcase'    => array(
        'title'                    => esc_html__( 'Showcase Widgets', 'mt-addons' ),
        'pricing_comparison_table' => array(
            'name'             => esc_html__( 'Pricing Comparison Table', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/pricing-comparison-table',
        ),
        'vertical_tabs'            => array(
            'name'             => esc_html__( 'Vertical Tabs', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => '#',
        ),
        'flipbox'                  => array(
            'name'             => esc_html__( 'Flipbox', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/flipbox',
        ),
        'countdown'                => array(
            'name'             => esc_html__( 'Countdown', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/countdown',
        ),
        'stacked_images'           => array(
            'name'             => esc_html__( 'Stacked Images', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/stacked-images',
        ),
        'textual_project_showcase' => array(
            'name'             => esc_html__( 'Textual Project Showcase', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/textual-project-showcase',
        ),
        'masonry_gallery'          => array(
            'name'             => esc_html__( 'Masonry Gallery', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/masonry-gallery',
        ),
        'scroll_reveal_image'      => array(
            'name'             => esc_html__( 'Scroll Reveal Image', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/scroll-reveal-image',
        ),
        'gallery'                  => array(
            'name'             => esc_html__( 'Gallery Hover', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/gallery',
        ),
    ),
    'typography'  => array(
        'title'         => esc_html__( 'Typography Widgets', 'mt-addons' ),
        'text_gradient' => array(
            'name'             => esc_html__( 'Text Gradient', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/text-gradient',
        ),
        'animated_text' => array(
            'name'             => esc_html__( 'Animated Text', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/animated-texts',
        ),
        'list_item'     => array(
            'name'             => esc_html__( 'List Item', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/list-item',
        ),
    ),
    'woocommerce' => array(
        'title'                 => esc_html__( 'WooCommerce Widgets', 'mt-addons' ),
        'advanced_sale_banners' => array(
            'name'             => esc_html__( 'Advanced Sale Banners', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/advanced-sale-banners',
        ),
        'vertical_tabs'         => array(
            'name'             => esc_html__( 'Vertical Tabs', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/vertical-tabs',
        ),
        'search_forms'          => array(
            'name'             => esc_html__( 'Search Forms', 'mt-addons' ),
            'status'           => 'off',
            'premium'          => 'true',
            'presentation_url' => 'premium/search-forms',
        ),
    ),
);
// Merge the arrays
$all_widgets = array_merge_recursive( $all_free_widgets, $all_premium_widgets );
// If there are any duplicate keys, merge their values
foreach ( $all_widgets as $key => &$value ) {
    if ( is_array( $value ) && isset( $all_free_widgets[$key], $all_premium_widgets[$key] ) ) {
        $value = array_merge( $all_free_widgets[$key], $all_premium_widgets[$key] );
    }
}
// Sort the array keys
ksort( $all_widgets );
$is_pro = 'no-premium';
?>

    <div class="mtfe-settings">
        <div class="mtfe-menu-options settings-options">
            <div class="mtfe-inner">
                <div class="mtfe-tab-content elements">
                    <div class="mtfe-inner mtfe-box-inner">
                        <div class="mtfe-spacer" style="height: 15px"></div>

                        <?php 
foreach ( $all_widgets as $key => $widgets_group ) {
    ?>
                            <h2><?php 
    echo esc_html( $widgets_group['title'] );
    ?></h2>
                            <div class="mtfe-elements-deactivate">
                                <?php 
    unset($widgets_group['title']);
    ?>
                                <?php 
    foreach ( $widgets_group as $key => $widget ) {
        ?>
                                    <div class="mtfe-row mtfe-type-checkbox <?php 
        if ( $widget['premium'] == 'true' ) {
            echo $is_pro;
        }
        ?>">
                                        <div>
                                            <label class="mtfe-label"><?php 
        echo esc_html( $widget['name'] );
        if ( $widget['premium'] == 'true' ) {
            ?><span class="mtfe-premium-tag"><?php 
            esc_html_e( 'PRO', 'mt-addons' );
        }
        ?></label>
                                            <div class="mtfe-spacer" style="height: 5px"></div>
                                            <p><a target="_blank" href="<?php 
        echo esc_html( MT_ADDONS_LIVE_URL . $widget['presentation_url'] );
        ?>"><?php 
        esc_html_e( 'Live Preview', 'mt-addons' );
        ?></a></p>
                                        </div>
                                        <div class="mtfe-toggle">
                                            <input type="checkbox" class="mtfe-checkbox" name="mtfe_el_<?php 
        echo esc_html( $key );
        ?>"
                                                   id="mtfe_el_<?php 
        echo esc_html( $key );
        ?>" data-default=""
                                                   value="<?php 
        echo esc_attr( mtfe_get_option( 'mtfe_el_' . $key, false ) );
        ?>" 
                                                   <?php 
        echo checked( !empty( mtfe_get_option( 'mtfe_el_' . $key, false ) ), 1, false );
        ?>>
                                            <label for="mtfe_el_<?php 
        echo esc_html( $key );
        ?>"></label>
                                        </div>
                                    </div>
                                <?php 
    }
    ?>
                            </div>
                        <?php 
}
?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="mtfe-infobox">
        <div class="mtfe-info-overlay"></div>
        <div class="mtfe-info-inner">
            <div class="mtfe-infobox-msg"></div>
        </div>
    </div>
</div>