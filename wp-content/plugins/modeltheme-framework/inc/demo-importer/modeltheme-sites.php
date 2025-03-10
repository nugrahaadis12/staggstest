<?php
define( 'PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );
define( 'PLUGIN_PATH', dirname( __FILE__ ) );

require dirname( __FILE__ ) . '/classes/class-dashboard.php';

Modeltheme_Sites::get_instance();

Class Modeltheme_Sites {
    static $_instance = null;

    // Server API address.
    public static $api = 'https://modeltheme.com/TFPLUGINS/';

    // Directory.
    public static $dir;

    // Core functionality.
    public function __construct() {
        self::$api = apply_filters( 'mt_config_api', false );
        require_once( self::$dir . 'classes/class-demo-importer.php' );
    }

    /**
    * Instance
    */
    public static function instance() {
        if ( self::$instance === null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    static function get_instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
            add_action( 'admin_menu', array( self::$_instance, 'add_menu' ), 50 );
        }
        return self::$_instance;
    }

    function add_menu() {
        add_menu_page(
            esc_html__( 'Theme Panel', 'modeltheme' ), 
            esc_html__( 'Theme Panel', 'modeltheme' ), 
            'manage_options', 
            'modeltheme-sites', 
            array( $this, 'page' ),
            plugins_url( 'modeltheme-framework/inc/demo-importer/assets/images/theme-panel-menu-icon.svg' ),
            2
        );
    }

    function page(){

        // Get the current theme object
        $current_theme = wp_get_theme();
        // Construct the screenshot URL
        $screenshot_url = $current_theme->get_screenshot();
        
        echo '<div class="wrap about-wrap">';
            echo '<div class="theme-header">';
                echo '<div class="intro">';
                    echo '<h2>'.__('Welcome to '.modeltheme_get_theme('Name').' Theme', 'modeltheme').'</h3>';
                    echo '<p>'.esc_html(modeltheme_get_theme('Description')).'</p>';
                    echo '<div class="theme-infos">';
                        echo '<span>'.esc_html__('Version:', 'modeltheme').' '.esc_html(modeltheme_get_theme('Version')).'</span>';
                    echo '</div>';
                echo '</div>';
                echo '<div class="theme-image">';
                    echo '<img src="'.$screenshot_url.'" alt="'.esc_html(modeltheme_get_theme('Name')).'" width="50" height="100">';
                echo '</div>';
            echo '</div>';
        echo '</div>';
        echo '<div class="modeltheme-panel-wrapper">';
            require_once PLUGIN_PATH.'/templates/tabs.php';
            echo '<div class="wrap about-wrap">';
                require_once PLUGIN_PATH.'/templates/general.php';
                require_once PLUGIN_PATH.'/templates/dashboard.php';
            echo '</div>
        </div>';
    }


    /**
    * Get theme options
    * 
    * @return array|string|null
    */
    public static function option( $key = '', $default = '' ) {
        $options = apply_filters( 'modeltheme/options', get_option( 'modeltheme_theme_options' ) );
        return empty( $key ) ? $options : apply_filters( 'modeltheme/option/' . $key, ( empty( $options[ $key ] ) ? $default : $options[ $key ] ) );
    }


    /**
    * Check if string contains specific value(s)
    * 
    * @return string
    */
    public static function contains( $v = '', $a = [] ) {
        if ( $v ) {
            foreach ( (array) $a as $k ) {
                if ( $k && strpos( (string) $v, (string) $k ) !== false ) {
                    return 1;
                    break;
                }
            }
        }
        return null;
    }


    /**
    * Get current post type name
    * 
    * @return string
    */
    public static function get_post_type( $id = '', $page = false ) {

        if ( is_search() || is_tag() || is_404() ) {
            $cpt = '';
        } else if ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
            $cpt = 'bbpress';
        } else if ( function_exists( 'is_woocommerce' ) && ( is_shop() || is_woocommerce() ) ) {
            $cpt = 'product';
        } else if ( function_exists( 'is_buddypress' ) && is_buddypress() ) {
            $cpt = 'buddypress';
        } else if ( ( ! $page && get_post_type( $id ) ) || is_singular() ) {
            $cpt = get_post_type( $id );
        } else if ( is_tax() ) {
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            if ( get_taxonomy( $term->taxonomy ) ) {
                $cpt = get_taxonomy( $term->taxonomy )->object_type[0];
            }
        } else if ( is_post_type_archive() ) {
            $cpt = get_post_type_object( get_query_var( 'post_type' ) )->name;
        } else {
            $cpt = 'post';
        }

        return $cpt;
    }
}