<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class MT_Addons_Admin_Ajax {

    // Instance of this class.
    protected $plugin_slug = 'mt_addons';
    protected $ajax_data;
    protected $ajax_msg;


    public function __construct() {
        // retrieve all ajax string to localize
        $this->localize_strings();
        $this->init_hooks();
    }

    public function init_hooks() {
        // Register backend ajax action
        add_action('wp_ajax_mt_addons_admin_ajax', array($this, 'mt_addons_admin_ajax'));
        // Load admin ajax js script
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }

    public function ajax_response($success = true, $message = null, $content = null) {
        $response = array(
            'success' => $success,
            'message' => $message,
            'content' => $content
        );
        return $response;
    }

    public function mt_addons_check_nonce() {

        // retrieve nonce
        $nonce = (isset($_POST['nonce'])) ? $_POST['nonce'] : $_GET['nonce'];

        // nonce action for the grid
        $action = 'mt_addons_admin_nonce';

        // check ajax nounce
        if (!wp_verify_nonce($nonce, $action)) {
            // build response
            $response = $this->ajax_response(false, esc_html__('Sorry, an error occurred. Please refresh the page.', 'mt-addons'));
            // die and send json error response
            wp_send_json($response);
        }

    }

    public function mt_addons_admin_ajax() {

        // check the nonce
        $this->mt_addons_check_nonce();

        // retrieve data
        $this->ajax_data = (isset($_POST)) ? $_POST : $_GET;

        // retrieve function
        $func = $this->ajax_data['func'];

        switch ($func) {
            case 'mtfe_save_settings':
                $response = $this->save_settings_callback();
                break;
            case 'mtfe_reset_settings':
                $response = $this->save_settings_callback();
                break;
            default:
                $response = ajax_response(false, esc_html__('Sorry, an unknown error occurred...', 'mt-addons'), null);
                break;
        }

        // send json response and die
        wp_send_json($response);

    }

    public function save_settings_callback() {

        // retrieve data from jquery
        $setting_data = $this->ajax_data['setting_data'];

        mtfe_update_options($setting_data);

        $template = false;
        // get new restore global settings panel
        if ($this->ajax_data['reset']) {
            ob_start();
            require_once('views/settings.php');
            $template = ob_get_clean();
        }

        $response = $this->ajax_response(true, $this->ajax_data['reset'], $template);
        return $response;

    }


    public function localize_strings() {
        
        $this->ajax_msg = array(
            'box_icons' => array(
                'before'    => '<i class="dashicons dashicons-admin-generic"></i>',
                'success'   => '<i class="dashicons dashicons-yes"></i>',
                'error'     => '<i class="dashicons dashicons-no-alt"></i>'
            ),
            'box_messages' => array(

                'mtfe_save_settings' => array(
                    'before'    => esc_html__('Saving plugin settings', 'mt-addons'),
                    'success'   => esc_html__('Plugin settings Saved', 'mt-addons'),
                    'error'     => esc_html__('Sorry, an error occurs while saving settings...', 'mt-addons')
                ),
                'mtfe_reset_settings' => array(
                    'before'    => esc_html__('Resetting plugin settings', 'mt-addons'),
                    'success'   => esc_html__('Plugin settings resetted', 'mt-addons'),
                    'error'     => esc_html__('Sorry, an error occurred while resetting settings', 'mt-addons')
                ),
            )
        );

    }

    public function admin_nonce() {
        return array(
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('mt_addons_admin_nonce')
        );
    }

    public function enqueue_admin_scripts() {

        $screen = get_current_screen();

        // enqueue only in grid panel
        if (strpos($screen->id, $this->plugin_slug) !== false) {
            // merge nonce to translatable strings
            $strings = array_merge($this->admin_nonce(), $this->ajax_msg);

            // Use minified libraries if MTFE_SCRIPT_DEBUG is turned off
            $suffix = (defined('MTFE_SCRIPT_DEBUG') && MTFE_SCRIPT_DEBUG) ? '' : '.min';

            // register and localize script for ajax methods
            wp_register_script('mt-addons-dash-ajax-scripts',  plugins_url( '/', __FILE__ ) . 'assets/js/mt-addons-dash-ajax.js', array(), true);
            wp_enqueue_script('mt-addons-dash-ajax-scripts');

            wp_localize_script('mt-addons-dash-ajax-scripts', 'mt_addons_admin_global_var', $strings);

        }
    }

}

new MT_Addons_Admin_Ajax;