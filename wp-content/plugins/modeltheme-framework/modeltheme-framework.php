<?php
/**
* Plugin Name: ModelTheme Framework
* Plugin URI: http://modeltheme.com/
* Description: ModelTheme Framework required by Modeltheme themes.
* Version: 1.2
* Author: ModelTheme
* Author http://modeltheme.com/
* Text Domain: modeltheme
* Last Plugin Update: 24-Feb-2025
*/
$plugin_dir = plugin_dir_path( __FILE__ );


function modeltheme_get_theme($parameter){
    // Get the active theme's information
    $theme = wp_get_theme();

    // Retrieve the theme's name
    if ($theme->parent()) {
        // Get the parent theme's name
        $parent_theme_name = $theme->parent()->get($parameter);
        return $parent_theme_name;
    } else {
        // If no parent theme, display the current theme's name
        return $theme->get($parameter);
    }
}
DEFINE('MODELTHEME_DEMO_DATA_FOLDER', plugin_dir_url( __FILE__ ).'inc/demo-importer/demo-data/');
DEFINE('MODELTEMA_THEME_NAME', 'wildnest');
DEFINE('MODELTEMA_THEME_DOCS_URL', 'https://docs.modeltheme.com/wildnest');

DEFINE( 'MODELTHEME_PLUGIN_BASE', $plugin_dir.'inc/');

function modeltheme_load_textdomain(){
    $domain = 'modeltheme';
    load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'modeltheme_load_textdomain' );

/**
||-> Function: modeltheme_enqueue_admin_scripts()
*/
function modeltheme_enqueue_admin_scripts( $hook ) {
    // CSS
    wp_register_style( 'modelteme-framework-admin-style',  plugin_dir_url( __FILE__ ) . 'assets/css/modelteme-framework-admin-style.css' );
    wp_enqueue_style( 'modelteme-framework-admin-style' );
    // JS
    wp_enqueue_script( 'js-modeltheme-admin-custom', plugin_dir_url( __FILE__ ) . 'assets/js/modeltheme-custom-admin.js', array(), '1.0.0', true );
    
}
add_action('admin_enqueue_scripts', 'modeltheme_enqueue_admin_scripts');

/**
||-> Function: Sites Scripts
*/
function modeltheme_panel_admin_scripts( $id ) {
    if( $id == 'toplevel_page_modeltheme-sites' ){
        wp_enqueue_style('modeltheme-panel', plugin_dir_url( __FILE__ ) .'assets/css/modeltheme-panel.css' );
        wp_enqueue_script('modeltheme-panel', plugin_dir_url( __FILE__ ) .'assets/js/modeltheme-panel.js',  array( 'jquery', 'underscore' ), false, true );
    }
    
}
add_action('admin_enqueue_scripts', 'modeltheme_panel_admin_scripts');

// CMB2 METABOXES
require_once ('inc/cmb2/init.php');
// WIDGETS
require_once('inc/widgets/widgets.php');
// LOAD METABOXES
require_once('inc/metaboxes/metaboxes.php');
// DEMO IMPORTER
require_once('inc/demo-importer/modeltheme-sites.php');
require_once('inc/api-v3/API.php');
// Mega Menu
require_once('inc/mega-menu/modeltheme-mega-menu.php');
// Post Type
require_once('inc/post-type/post-type.php');
// Widgets 
require_once('inc/widgets-addons/countdown/include.php');
require_once('inc/widgets-addons/course-card/include.php');
require_once('inc/widgets-addons/search-forms/include.php');
require_once('inc/widgets-addons/stacked-photos/include.php');
require_once('inc/widgets-addons/shaped-video/include.php');
require_once('inc/widgets-addons/knowledgebase-search/include.php');
require_once('inc/widgets-addons/knowledgebase-list/include.php');
require_once('inc/widgets-addons/knowledgebase-accordion/include.php');
require_once('inc/widgets-addons/masonry-gallery/include.php');
require_once('inc/widgets-addons/pricing-comparison-table/include.php');

function modeltheme_remove_menu_items() {
    if( !current_user_can( 'administrator' ) ):
        remove_menu_page( 'edit.php?post_type=cf_mega_menu' );
        remove_menu_page( 'edit.php?post_type=shop_order' );
        remove_menu_page( 'admin.php?page=vc-welcome' );
    endif;
}
add_action( 'admin_menu', 'modeltheme_remove_menu_items' );

/**
* Function: wildnest_get_header_templates_list()
* Role: Returns an array of header templates made on Customizer Header builder
*/
function wildnest_get_header_templates_list(){
    $headers = get_option('wildnest_header_saved_templates');
    $headers_array = array('' => esc_html__('- Theme Default Header - ','modeltheme'));
    if ($headers) {
        foreach ($headers as $header) {
            $headers_array[$header['name']] = $header['name'];
        }
    }

    return $headers_array;
}

/**
* Function: wildnest_social_share_buttons()
* Role: Returns social links in single products
*/

function wildnest_social_share_buttons() {
        
        // Get current page URL 
        $mt_url = esc_url(get_permalink());

        // Get current page title
        $mt_title = str_replace( ' ', '%20', get_the_title());
        
        // Get Post Thumbnail for pinterest
        $mt_thumb = wildnest_get_the_post_thumbnail_src(get_the_post_thumbnail());

        $mt_thumb_url = '';
        if(!empty($mt_thumb)) {
            $mt_thumb_url = $mt_thumb[0];
        }

        // Construct sharing URL without using any script
        $twitter_url = 'https://twitter.com/intent/tweet?text='.esc_html($mt_title).'&amp;url='.esc_url($mt_url).'&amp;via='.esc_attr(get_bloginfo( 'name' ));
        $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u='.esc_url($mt_url);
        $whatsapp_url = 'https://api.whatsapp.com/send?text='.esc_html($mt_title) . ' ' . esc_url($mt_url);
        $linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url='.esc_url($mt_url).'&amp;title='.esc_html($mt_title);
        if(!empty($mt_thumb)) {
            $pinterest_url = 'https://pinterest.com/pin/create/button/?url='.esc_url($mt_url).'&amp;media='.esc_url($mt_thumb_url).'&amp;description='.esc_html($mt_title);
        }else {
            $pinterest_url = 'https://pinterest.com/pin/create/button/?url='.esc_url($mt_url).'&amp;description='.esc_html($mt_title);
        }
        // Based on popular demand added Pinterest too
        $pinterest_url = 'https://pinterest.com/pin/create/button/?url='.esc_url($mt_url).'&amp;media='.esc_url($mt_thumb_url).'&amp;description='.esc_html($mt_title);
        $email_url = 'mailto:?subject='.esc_html($mt_title).'&amp;body='.esc_url($mt_url);

        $telegram_url = 'https://telegram.me/share/url?url=<'.esc_url($mt_url).'>&text=<'.esc_html($mt_title).'>';

        // The Visual Buttons
        echo '<div class="social-box"><div class="social-btn">';
            if (wildnest()->get_setting('wildnest_social_media_shares_twitter')) {
                echo '<a class="col-2 sbtn s-twitter" href="'. esc_url($twitter_url) .'" target="_blank" rel="nofollow"><i class="fab fa-twitter"></i></a>';
            }
            if (wildnest()->get_setting('wildnest_social_media_shares_facebook')) {
                echo '<a class="col-2 sbtn s-facebook" href="'.esc_url($facebook_url).'" target="_blank" rel="nofollow"><i class="fab fa-facebook-f"></i></a>';
            }
            if (wildnest()->get_setting('wildnest_social_media_shares_whatsapp')) {
                echo '<a class="col-2 sbtn s-whatsapp" href="'.esc_url($whatsapp_url).'" target="_blank" rel="nofollow"><i class="fab fa-whatsapp"></i></a>';
            }
            if (wildnest()->get_setting('wildnest_social_media_shares_pinterest')) {
                echo '<a class="col-2 sbtn s-pinterest" href="'.esc_url($pinterest_url).'" data-pin-custom="true" target="_blank" rel="nofollow"><i class="fab fa-pinterest-p"></i></a>';
            }
            if (wildnest()->get_setting('wildnest_social_media_shares_linkedin')) {
                echo '<a class="col-2 sbtn s-linkedin" href="'.esc_url($linkedin_url).'" target="_blank" rel="nofollow"><i class="fab fa-linkedin-in"></i></a>';
            }
            if (wildnest()->get_setting('wildnest_social_media_shares_telegram')) {
                echo '<a class="col-2 sbtn s-telegram" href="'.esc_url($telegram_url).'" target="_blank" rel="nofollow"><i class="fab fa-telegram-plane"></i></a>';
            }
            if (wildnest()->get_setting('wildnest_social_media_shares_email')) {
                echo '<a class="col-2 sbtn s-email" href="'.esc_url($email_url).'" target="_blank" rel="nofollow"><i class="far fa-envelope"></i></a>';
            }
        echo '</div></div>';
}
add_action( 'woocommerce_product_meta_end', 'wildnest_social_share_buttons');


/* Function: redirect to Theme panel after activation */
register_activation_hook(__FILE__, 'modeltheme_plugin_activate');
add_action('admin_init', 'modeltheme_plugin_redirect');

function modeltheme_plugin_activate() {
    add_option('modeltheme_plugin_do_activation_redirect', true);
}

function modeltheme_plugin_redirect() {
    if (get_option('modeltheme_plugin_do_activation_redirect', false)) {
        delete_option('modeltheme_plugin_do_activation_redirect');
        if(!isset($_GET['activate-multi']))
        {
            wp_redirect("options-general.php?page=modeltheme-sites");
        }
    }
}

/* Filter the single_template with our custom function knowledge base*/
function modeltheme_single_template($single) {
    global $wp_query, $post;
    /* Checks for single template by post type */
    if ( $post->post_type == 'mt-knowledgebase' ) {
        if ( file_exists( plugin_dir_path( __FILE__ ) . 'inc/templates/single-knowledge.php' ) ) {
            return plugin_dir_path( __FILE__ ) . 'inc/templates/single-knowledge.php';
        }
    }
    return $single;
}
add_filter('single_template', 'modeltheme_single_template');