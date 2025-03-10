<?php
/**
 * wildnest functions and definitions
 *
 * @package wildnest
 */


// Include the main Wildnest class.
require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/builder/class-theme.php';

function Wildnest() {
    return Wildnest::get_instance();
}
Wildnest();

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
    $content_width = 640; /* pixels */
}

if ( ! function_exists( 'wildnest_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function wildnest_setup() {

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on wildnest, use a find and replace
         * to change 'wildnest' to the name of your theme in all the template files
         */
        load_theme_textdomain( 'wildnest', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'woocommerce', array(
            'gallery_thumbnail_image_width' => 200,
            'woocommerce_thumbnail' => 768,
        ));
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        remove_theme_support( 'widgets-block-editor' );
        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );
        /**
         * Support Gutenberg.
         *
         * @since 0.2.6
         */
        add_theme_support( 'align-wide' );
        /**
         * Add editor style support.
         */
        add_theme_support( 'editor-styles' );
        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'hb-primary-navigation' => esc_html__( 'Primary Navigation', 'wildnest' ),
            'hb-menu-mobile'        => esc_html__( 'Mobile Navigation', 'wildnest' ),
            'hb-menu-navigation1'   => esc_html__( 'Navigation 1', 'wildnest' ),
            'hb-menu-navigation2'   => esc_html__( 'Navigation 2', 'wildnest' ),
            'hb-category-button'    => esc_html__( 'Category Button', 'wildnest' ),
        ) );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
        ) );

    }
endif; // wildnest_setup
add_action( 'after_setup_theme', 'wildnest_setup' );

/**
 * Enqueue scripts and styles.
 */
if (!function_exists("wildnest_scripts")) {
    function wildnest_scripts() {

        //STYLESHEETS
        wp_enqueue_style( "font-awesome5", get_template_directory_uri()."/assets/vendor/font-awesome/all.min.css", array(), "5.15.4" );
        wp_enqueue_style( "bootstrap", get_template_directory_uri()."/assets/vendor/bootstrap/bootstrap.min.css", array(), "5.0.2" );
        wp_enqueue_style( "wildnest-styles", get_template_directory_uri()."/assets/css/styles.css" );
        wp_enqueue_style( "wildnest-style", get_template_directory_uri()."/assets/css/wildnest-style.css" );
        wp_enqueue_style( "wildnest-style", get_stylesheet_uri() );
        wp_enqueue_style( "wildnest-gutenberg-frontend", get_template_directory_uri()."/inc/gutenberg/assets/gutenberg-frontend.css" );
        // WooCommerce
        if ( class_exists( "WooCommerce" ) ) {
            wp_enqueue_style( "wildnest-woocommerce", get_template_directory_uri()."/assets/css/compatibility/woocommerce.css" );
        }
        wp_enqueue_style( "select2", get_template_directory_uri()."/assets/vendor/select2/select2.min.css" );
        // BuddyPress/Youzify
        if ( class_exists( "BuddyPress" ) || class_exists('Youzify') ) {
            wp_enqueue_style( "buddypress-youzify", get_template_directory_uri()."/assets/css/compatibility/buddypress-youzify.css" );
        }
        // The Events Calendar
        if ( class_exists( "Tribe__Template" )) {
            wp_enqueue_style( "tribe-events", get_template_directory_uri()."/assets/css/compatibility/tribe-events.css" );
        }
        
        //SCRIPTS
        wp_enqueue_script( "classie", get_template_directory_uri() . "/assets/vendor/classie/classie.js", array("jquery"), "1.0", true );
        wp_enqueue_script( "jquery-sticky", get_template_directory_uri() . "/assets/vendor/jquery-sticky/jquery.sticky.js", array("jquery"), "1.0.0", true );
        wp_enqueue_script( "bootstrap", get_template_directory_uri() . "/assets/vendor/bootstrap/bootstrap.min.js", array("jquery"), "3.3.1", true );
        wp_enqueue_script( "theme-select2", get_template_directory_uri() . "/assets/vendor/select2/select2.min.js", array("jquery"), "4.1.0-rc.0", true );
        // WooCommerce
        if ( class_exists( "WooCommerce" ) ) {
            wp_enqueue_script( "custom-woocommerce", get_template_directory_uri() . "/assets/js/compatibility/custom-woocommerce.js", array("jquery"), "1.0.0", true );
            wp_enqueue_script( "jquery-cookie", get_template_directory_uri() . "/assets/vendor/jquery-cookie/jquery.cookie.min.js", array("jquery"), "1.2", true );
            wp_enqueue_script( "jquery-matchheight", get_template_directory_uri() . "/assets/vendor/jquery-match-height/jquery.matchHeight-min.js", array("jquery"), "0.7.2", true );
        }
        // Custom JS
        wp_enqueue_script( "wildnest-custom", get_template_directory_uri() . "/assets/js/custom.js", array("jquery"), "1.0.0", true );
        if ( is_singular() && comments_open() && get_option( "thread_comments" ) ) {
            wp_enqueue_script( "comment-reply" );
        }
    }
    add_action( "wp_enqueue_scripts", "wildnest_scripts" );
}

/**
 * Enqueue Editor styles.
 */
function wildnest_add_editor_styles() {
    add_editor_style( 'assets/css/custom-editor-style.css' );
}
add_action( 'admin_init', 'wildnest_add_editor_styles' );


/**
 * Enqueue scripts and styles for admin dashboard.
 */
if (!function_exists('wildnest_enqueue_admin_scripts')) {
    function wildnest_enqueue_admin_scripts( $hook ) {
        wp_enqueue_style( 'wildnest-admin-style', get_template_directory_uri().'/assets/css/admin-style.css' );
    }
    add_action('admin_enqueue_scripts', 'wildnest_enqueue_admin_scripts');
}


// Define custom excerpt length
function wildnest_custom_excerpt_length( $length ) {
    return 18;
}
add_filter( 'excerpt_length', 'wildnest_custom_excerpt_length', 999 );

function wildnest_get_all_header_parts() {
    $header_parts = array(
        'navigation'   => esc_html__( 'Navigation', 'wildnest' ),
        'cart'         => esc_html__( 'Cart', 'wildnest' ),
        'logo'         => esc_html__( 'Logo', 'wildnest' ),
        'search-form'  => esc_html__( 'Search Form', 'wildnest' ),
        'lang-curr-dropdown' => esc_html__( 'Language & Currency Dropdown', 'wildnest' ),
        'category-menu' => esc_html__( 'Category Menu', 'wildnest' )
    );
    return $header_parts;
}

/* ========= LOAD  ===================================== */
// Include the TGM_Plugin_Activation class.
require get_template_directory().'/inc/tgm/include_plugins.php';
// Theme functions
require get_template_directory() . '/inc/functions-theme.php';
// WooCommerce functions
if (class_exists( 'WooCommerce' )) {
    require get_template_directory() . '/inc/functions-woocommerce.php';
}
// Gutenberg functions
require_once get_template_directory() . '/inc/gutenberg/functions.php';

/* ========= RESIZE IMAGES ===================================== */
add_image_size( 'wildnest_blog_single', 1400, 650, true );


/* ========= SEARCH FOR POSTS ONLY ===================================== */
function wildnest_search_filter($query) {
    if ($query->is_search && !isset($_GET['post_type'])) {
        $query->set('post_type', 'post');
    }
    return $query;
}
if( !is_admin() ){
    add_filter('pre_get_posts','wildnest_search_filter');
}

// KSES ALLOWED HTML
if (!function_exists('wildnest_kses_allowed_html')) {
    function wildnest_kses_allowed_html($tags, $context) {
      switch($context) {
        case 'link': 
            $tags = array( 
                'a' => array(
                    'href' => array(),
                    'class' => array(),
                    'title' => array(),
                    'target' => array(),
                    'rel' => array(),
                    'data-commentid' => array(),
                    'data-postid' => array(),
                    'data-belowelement' => array(),
                    'data-respondelement' => array(),
                    'data-replyto' => array(),
                    'aria-label' => array(),
                ),
                'img' => array(
                    'src' => array(),
                    'alt' => array(),
                    'style' => array(),
                    'height' => array(),
                    'width' => array(),

                ),
            );
            return $tags;
        break;

        case 'icon':
            $tags = array(
                'i' => array(
                    'class' => array(),
                ),
            );
            return $tags;
        break;
        
        default: 
            return $tags;
      }
    }
    add_filter( 'wp_kses_allowed_html', 'wildnest_kses_allowed_html', 10, 2);
}


/* search */
if (!function_exists('wildnest_search_form_ajax_fetch')) {
    add_action( 'wp_footer', 'wildnest_search_form_ajax_fetch' );
    function wildnest_search_form_ajax_fetch() { ?>
        <script type="text/javascript">
            function wildnest_fetch_products(){
                jQuery.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'post',
                    data: { 
                        action: 'wildnest_search_form_data_fetch', 
                        keyword: jQuery('.search-keyword').val(),
                        category_slug: jQuery('.search-form-product select option:selected').val()
                    },
                    success: function(data) {
                        jQuery('.data_fetch').html( data );
                    }
                });
            }
        </script>
    <?php
    }
}


// the ajax function
if (!function_exists('wildnest_search_form_data_fetch')) {
    add_action('wp_ajax_wildnest_search_form_data_fetch', 'wildnest_search_form_data_fetch');
    add_action('wp_ajax_nopriv_wildnest_search_form_data_fetch', 'wildnest_search_form_data_fetch');
    function wildnest_search_form_data_fetch(){
        if (  esc_attr( $_POST['keyword'] ) == null ) { 
            die(); 
        }
        if ($_POST['category_slug'] != '') {
            $the_query = new WP_Query( 
                array( 
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'post_per_page' => get_option('posts_per_page'),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'slug',
                            'terms'    => esc_attr($_POST['category_slug']), 
                        ),
                    ),
                    's' => esc_attr( $_POST['keyword']) 
                ) 
            );
        }else{
            $the_query = new WP_Query( 
                array( 
                    'post_type'=> 'product',
                    'post_per_page' => get_option('posts_per_page'),
                    's' => esc_attr( $_POST['keyword']) 
                ) 
            );
        }

        if( $the_query->have_posts() ) : ?>
            <ul class="search-result">           
                <?php while( $the_query->have_posts() ): $the_query->the_post(); ?>   
                    <?php $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'wildnest_post_widget_pic70x70' ); ?>             
                    <li>
                        <a href="<?php echo esc_url( get_permalink() ); ?>">
                            <?php if($thumbnail_src) { ?>
                                <?php the_post_thumbnail( 'wildnest_post_widget_pic70x70' ); ?>
                            <?php } ?>
                            <?php the_title(); ?>
                        </a>
                    </li>             
                <?php endwhile; ?>
            </ul>       
            <?php wp_reset_postdata();  
        else :
            ?>
            <ul class="search-result">           
                <li><?php echo esc_html__('No products were found.', 'wildnest'); ?></li>
            </ul>
        <?php 
        endif;

        die();
    }
}


$header_status = Wildnest()->get_setting('wildnest_header_status');
if ($header_status == 0) {
    /**
     * Remove Header Content To Frontend
     */
    remove_action( 'wildnest/site-start', 'wildnest_customize_render_header' );
}

$footer_status = Wildnest()->get_setting('wildnest_footer_status');
if ($footer_status == 0) {
    /**
     * Remove Footer Content To Frontend
     */
    remove_action( 'wildnest/site-end', 'wildnest_customize_render_footer' );
}