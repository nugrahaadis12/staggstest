<?php 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


function modeltheme_apiv3_enqueue_admin( $hook ) {
    if ( $hook === 'toplevel_page_modeltheme-license' ) {
        wp_register_style( 'modeltheme-activator-v3-dashboard',  plugin_dir_url( __FILE__ ) . 'assets/dashboard.css' );
        wp_enqueue_style( 'modeltheme-activator-v3-dashboard' );
    }
}
add_action('admin_enqueue_scripts', 'modeltheme_apiv3_enqueue_admin');


// Add a submenu for the activation page
function modeltheme_activator_v3_dashboard_page() {
    add_menu_page(
        'Theme License Manager',
        'Theme License Manager',
        'manage_options',
        'modeltheme-license',
        'modeltheme_theme_license_v3_panel',
        plugin_dir_url( __FILE__ ) . 'assets/logo.svg',  // Icon URL or Dashicon class (optional)
        1                           // Position in the menu (optional)
    );
}
add_action('admin_menu', 'modeltheme_activator_v3_dashboard_page');


function modelthemeav3_is_license_activated(){
    if(get_option('modeltheme_keyv3_activator')){
        return true;
    }else{
        return false;
    }
}


function modelthemeav3_get_active_license_type(){
    $license = get_option('modeltheme_keyv3_activator');
    if (isset($license['license_type'])) {
        return $license['license_type'];
    }
}

function modelthemeav3_get_theme(){
    // Get the active theme's information
    $theme = wp_get_theme();

    // Retrieve the theme's name
    if ($theme->parent()) {
        // Get the parent theme's name
        $parent_theme_name = $theme->parent()->get('Name');
        return $parent_theme_name;
    } else {
        // If no parent theme, display the current theme's name
        return $theme->get('Name');
    }
}


// Render the activation form
add_action('modeltheme_redux_license_activator', 'modeltheme_theme_license_v3_panel');
function modeltheme_theme_license_v3_panel() {
    DEFINE('ENVITEM', '56767958');
    DEFINE('ENVMKT', 'elements');

    if(modelthemeav3_is_license_activated()){
        $activation_action = 'deregister';
        $title = __('Your License is activated', 'modeltheme');
        $subtitle = __('Great, your license is active! You have successfully registered your copy of the theme!', 'modeltheme');
        $subtitle_elements = '';
        $submit_text = __('Deregister License', 'modeltheme');

        if (modelthemeav3_get_active_license_type() == 'elements') {
            $title = __('Your Envato Elements Token is active', 'modeltheme');
        }
    }else{
        $activation_action = 'register';
        $title = __('Activate your license', 'modeltheme');
        $subtitle = __('Please enter a valid Envato Purchase Code. <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank">Where is my purchase code?</a>. The activation is needed to access the sample data importer.', 'modeltheme');
        $extension_id = md5(get_site_url());

        $token_generate_url = add_query_arg( array(
            'extension_id' => $extension_id,
            'extension_type' => 'envato-wordpress',
            'extension_description' => '(ModelTheme Activator v3) '.get_site_url(),
        ), 'https://api.extensions.envato.com/extensions/begin_activation' );

        $subtitle_elements = __('Please enter a valid Envato Elements Token. <a href="'.esc_url($token_generate_url).'" target="_blank" rel="noopener noreferrer">Follow this link</a> to generate a token.', 'modeltheme');
        $submit_text = __('Register License', 'modeltheme');
    }

 ?>

    <div class="modeltheme-wrap">
        <h1 class="modeltheme-about-wrap">Welcome to <?php echo modelthemeav3_get_theme(); ?> Theme</h1>
        <p class="modeltheme-infop-wrap">Activate your <?php echo modelthemeav3_get_theme(); ?> theme to get in our awesome community.</p>

        <div class="wrap" id="modeltheme-activator-v3-form">
            <form>
                <?php wp_nonce_field('activate_license_nonce', 'license_nonce'); ?>

                <div class="mt-hidden-fields">
                    <input type="hidden" id="admin_email" name="admin_email" value="<?php echo esc_attr(get_option('admin_email')); ?>">
                    <input type="hidden" id="website_url" name="website_url" value="<?php echo esc_url(get_site_url()); ?>">
                    <input type="hidden" id="item_id" name="item_id" value="<?php echo esc_attr(ENVITEM); ?>">
                    <input type="hidden" id="activation_action" name="activation_action" value="<?php echo esc_attr($activation_action); ?>">
                    <?php if(modelthemeav3_is_license_activated()){ ?>
                        <input type="hidden" class="modelthemeav3-activated-license-type" name="license_type" value="<?php echo modelthemeav3_get_active_license_type(); ?>" />
                    <?php } ?>
                </div>

                <h3><?php echo $title; ?></h3>
                <?php if(ENVMKT == 'elements' && !modelthemeav3_is_license_activated()){ ?>
                    <div class="modelthemeav3-license-type">
                        <p style="margin: 0 !important;"><label>
                            <input type="radio" name="license_type" value="market" checked />
                            I have an Envato Market purchase code
                        </label></p>
                        <p style="margin: 0 !important;"><label>
                            <input type="radio" name="license_type" value="elements" />
                            I have an Envato Elements subscription
                        </label></p>
                    </div>
                <?php } ?>

                <p data-li-type="market"><?php echo $subtitle; ?></p>
                <?php if(modelthemeav3_get_active_license_type() == 'elements' || ENVMKT == 'elements'){ ?>
                    <p data-li-type="elements"><?php echo $subtitle_elements; ?></p>
                <?php } ?>

                <?php if(modelthemeav3_is_license_activated()){ ?>
                    <?php 
                        $purchase_key = get_option('modeltheme_keyv3_activator')['purchase_key'];
                        $expiry_date = get_option('modeltheme_keyv3_activator')['expiry_date'];
                        $date = new DateTime($expiry_date);
                        $timezone = get_option('timezone_string');
                        if ($timezone) {
                            $date->setTimezone(new DateTimeZone($timezone));
                        }
                        $date_format = get_option('date_format');
                        $formatted_date = $date->format($date_format);
                        $current_date = new DateTime();
                        $support_date_badge = '<span class="mt-support-active">'.esc_html($formatted_date).' - Still Active</span>';
                        $support_status = '. To get support, please open a <a href="https://modeltheme.ticksy.com/" target="_blank">Help Ticket</a>.';
                        if ($date <= $current_date) {
                            $support_date_badge = '<span class="mt-support-expired">'.esc_html($formatted_date).' - Expired</span>';
                            $support_status = '. To get support on our help desk, please <a href="https://1.envato.market/c/1285662/275988/4415?u=https://themeforest.net/item/x/'.esc_attr(ENVITEM).'" target="_blank">Renew Your Support</a>.';
                        }
                    ?>

                    <?php if(modelthemeav3_get_active_license_type() == 'market'){ ?>
                        <p><strong>Support Valid until:</strong> <?php echo $support_date_badge . $support_status; ?></p>
                        <p><input type="text" class="widefat" readonly id="purchase_key" name="purchase_key" required value="<?php echo esc_attr($purchase_key); ?>"></p>
                    <?php } ?>

                    <!-- market elements -->
                    <?php if(modelthemeav3_get_active_license_type() == 'elements'){ ?>
                        <p>If you deregister the token or reinstall the site, you should re-generate a new valid Envato Elements Token.</p>
                        <p><input type="text" class="widefat" readonly id="token" name="token" required value="<?php echo esc_attr($purchase_key); ?>"></p>
                    <?php } ?>

                <?php }else{ ?>
                    <!-- market fields -->
                    <p data-li-type="market">
                        <input type="text" class="widefat mtav3-license-type" id="purchase_key" name="purchase_key" value="" placeholder="Purchase code (required)" required />
                    </p>
                    <!-- market elements -->
                    <?php if(ENVMKT == 'elements'){ ?>
                        <p data-li-type="elements">
                            <input type="text" class="widefat mtav3-license-type" id="token" name="token" value="" placeholder="Envato Elements Token (required)" required />
                        </p>
                    <?php } ?>
                <?php } ?>

                <?php if(!modelthemeav3_is_license_activated()){ ?>
                    <div class="modeltheme-agreement-group">
                        <p>
                            <input type="checkbox" checked id="modeltheme_envato_terms" name="modeltheme_envato_terms">
                            <label for="modeltheme_envato_terms">Each Envato license is for a single project. Using it for multiple unregistered installations is a copyright violation. <a href="https://themeforest.net/licenses/standard" target="_blank" rel="noopener noreferrer">More info</a>.
                            </label>
                        </p>
                        <p>
                            <label><input type="checkbox" name="gdpr_status" id="gdpr_status" checked> Your data is stored and handled in line with our <a href="//modeltheme.com/privacy-policy/" target="_blank">Privacy Policy</a>.</label>
                        </p>
                    </div>
                <?php } ?>

                <p>
                    <button type="button" class="button button-primary" onclick="submitActivationForm()">
                        <span class="mtav3-button-text"><?php echo $submit_text; ?></span>
                        <div class="mtav3-button-loader" style="display: none;"></div>
                    </button>
                </p>

                <div id="activation-response"></div>

                <small>A purchase code (license) is valid for one domain only. If you're using this theme on a new domain, please <a href="https://1.envato.market/c/1285662/275988/4415?u=https://themeforest.net/item/x/<?php echo esc_attr(ENVITEM); ?>" target="_blank">purchase a new license</a> to receive a new purchase code.</small>

            </form>
        </div>

        <?php do_action('modeltheme_system_requirements_panel'); ?>
    </div>

<!-- 
    <div class="mt-quick-links">
        <div class="mt-import">
            <h3>License Activated</h3>
            <p>You can now import demos</p>
            <a href="#" class="button button-primary">Demo Importer</a>
        </div>
        <div class="mt-import">
            <h3>Theme Support</h3>
            <p>Get support for your purchase</p>
            <a href="#" class="button button-primary">Open Help Ticket</a>
        </div>
        <div class="mt-import">
            <h3>Theme Customization</h3>
            <p>Hire us to build your website</p>
            <a href="#" class="button button-primary">Get Free Quote</a>
        </div>
    </div> -->
    <script type="text/javascript">
        jQuery(document).ready(function() {
            if (jQuery('.modelthemeav3-license-type').length) {
                // Function to show/hide elements based on selected license type
                function toggleLicenseType() {
                    var selectedType = jQuery('input[name="license_type"]:checked').val();
                    
                    // Show only elements with matching data-li-type
                    jQuery('[data-li-type]').hide();
                    jQuery('[data-li-type="' + selectedType + '"]').show();
                    
                    // Toggle required attribute based on selected type
                    jQuery('.widefat').removeAttr('required');
                    jQuery('[data-li-type="' + selectedType + '"] .widefat').attr('required', 'required');
                }

                // Initial toggle on page load
                toggleLicenseType();

                // Toggle on license type change
                jQuery('input[name="license_type"]').change(function() {
                    toggleLicenseType();
                });
            }
        });
    </script>


    <script>
        function submitActivationForm() {
            var purchaseKey = jQuery('#purchase_key').val();
            const nonce = jQuery('input[name="license_nonce"]').val(); // Get the nonce
            const adminEmail = jQuery('#admin_email').val(); // Get admin email
            const websiteUrl = jQuery('#website_url').val(); // Get website URL
            const item_id = jQuery('#item_id').val(); // Get website URL
            const gdpr_status = jQuery('#gdpr_status').is(':checked') ? 1 : 0; // Get gdpr_status
            const activation_action = jQuery('#activation_action').val(); // Get website URL
            var license_type = 'market'; // Default to 'market'
            if (jQuery('.modelthemeav3-license-type').length) {
                license_type = jQuery('input[name="license_type"]:checked').val();
            }else{
                license_type = jQuery('.modelthemeav3-activated-license-type').val();
            }

            var ajax_action = 'activate_license'; // Default to 'market'
            if (license_type == 'elements') {
                purchaseKey = jQuery('#token').val();
                ajax_action = 'activate_license_elements'; // Default to 'market'
            }

            jQuery('.mtav3-button-loader').show();

            // Use jQuery's AJAX method to send the request
            jQuery.ajax({
                url: ajaxurl,
                method: 'POST',
                data: {
                    action: ajax_action, //activate_license or activate_license_elements
                    purchase_key: purchaseKey,
                    admin_email: adminEmail,
                    website_url: websiteUrl,
                    item_id: item_id,
                    license_type: license_type,
                    gdpr_status: gdpr_status,
                    activation_action: activation_action,
                    license_nonce: nonce
                },
                success: function(data) {
                    // Handle the successful response
                    jQuery('#activation-response').html(data.message);

                    jQuery('.mtav3-button-loader').hide();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle any errors
                    jQuery('#activation-response').html('Error: ' + textStatus + ' ' + errorThrown);

                    jQuery('.mtav3-button-loader').hide();
                }
            });
        }
    </script>
    <?php
}



function modeltheme_activate_elements_license() {
    // Verify the nonce
    check_ajax_referer('activate_license_nonce', 'license_nonce');

    $token = isset($_POST['purchase_key']) ? sanitize_text_field($_POST['purchase_key']) : '';

    // Check if the required data is correctly parsed
    if (!isset($token)) {
        wp_send_json(['message' => 'Invalid request. Missing Envato Elements token.']);
        return;
    }
    
    // Include any other parameters you might want to pass
    $admin_email = isset($_POST['admin_email']) ? sanitize_email($_POST['admin_email']) : '';
    $website_url = isset($_POST['website_url']) ? esc_url($_POST['website_url']) : '';
    $item_id = isset($_POST['item_id']) ? sanitize_text_field($_POST['item_id']) : '';
    $gdpr_status = isset($_POST['gdpr_status']) ? esc_attr($_POST['gdpr_status']) : '';
    $activation_action = isset($_POST['activation_action']) ? sanitize_text_field($_POST['activation_action']) : '';
    $license_type = isset($_POST['license_type']) ? sanitize_text_field($_POST['license_type']) : 'elements';

    // Define the URL of the external PHP server script
    // $server_url = 'https://api.modeltheme.com/activator-v3/verify-license.php';
    $server_url = 'https://api.modelthe.me/activator-v3/verify-license.php';
    // $server_url_secondary = 'https://api.modelthe.me/activator-v3/verify-license.php';

    $request_data = [
        'token' => $token,
        'admin_email' => $admin_email,
        'website_url' => $website_url,
        'item_id' => $item_id,
        'license_type' => $license_type,
        'gdpr_status' => $gdpr_status,
        'activation_action' => $activation_action,
    ];

    // Use cURL to send the request with all parameters
    $response = wp_remote_post($server_url, [
        'body' => json_encode($request_data),
        'headers' => ['Content-Type' => 'application/json'],
    ]);
    $api_success = 'modeltheme.com';

    // Handle the response
    // if (is_wp_error($response)) {
    //     $response = wp_remote_post($server_url_secondary, [
    //         'body' => json_encode($request_data),
    //         'headers' => ['Content-Type' => 'application/json'],
    //     ]);
    //     $api_success = 'modelthe.me';
    // }

    // Handle the response or report an error
    if (is_wp_error($response)) {
        wp_send_json(['message' => 'Error connecting to license server.']);
        return;
    }

    // Decode the server's response
    $response_data = json_decode(wp_remote_retrieve_body($response), true);

    // Return the server's response as is
    if ($response_data) {
        $response_data['api_success_source'] = $api_success;
        if (isset($response_data['status']) && $response_data['status'] === 'success') {
            if ($response_data['license_status'] == 'activated') {
                // delete old api meta
                delete_option('modelthemeAPIactivator');
                // update the new api meta
                update_option('modeltheme_keyv3_activator', [
                    'purchase_key' => $token,
                    'license_type' => 'elements',
                    'expiry_date' => ''
                ]);
            }else{
                delete_option('modeltheme_keyv3_activator');
            }
            wp_send_json($response_data);
        } else {
            wp_send_json($response_data);
        }
    } else {
        wp_send_json(['message' => '<div class="mtav3-notice mtav3-notice-error">Unexpected error occurred (No response from server). Contact Support</div>']);
    }

    wp_die();
}

add_action('wp_ajax_activate_license_elements', 'modeltheme_activate_elements_license');



function modeltheme_activate_market_license() {
    // Verify the nonce
    check_ajax_referer('activate_license_nonce', 'license_nonce');

    $purchase_key = isset($_POST['purchase_key']) ? sanitize_text_field($_POST['purchase_key']) : '';

    // Check if the required data is correctly parsed
    if (!isset($purchase_key)) {
        wp_send_json(['message' => 'Invalid request, missing purchase key.']);
        return;
    }
    
    // Include any other parameters you might want to pass
    $admin_email = isset($_POST['admin_email']) ? sanitize_email($_POST['admin_email']) : '';
    $website_url = isset($_POST['website_url']) ? esc_url($_POST['website_url']) : '';
    $item_id = isset($_POST['item_id']) ? sanitize_text_field($_POST['item_id']) : '';
    $gdpr_status = isset($_POST['gdpr_status']) ? esc_attr($_POST['gdpr_status']) : '';
    $activation_action = isset($_POST['activation_action']) ? sanitize_text_field($_POST['activation_action']) : '';
    $license_type = isset($_POST['license_type']) ? sanitize_text_field($_POST['license_type']) : 'market';

    // Define the URL of the external PHP server script
    // $server_url = 'https://api.modeltheme.com/activator-v3/verify-license.php';
    $server_url = 'https://api.modelthe.me/activator-v3/verify-license.php';
    // $server_url_secondary = 'https://api.modelthe.me/activator-v3/verify-license.php';

    $request_data = [
        'purchase_key' => $purchase_key,
        'admin_email' => $admin_email,
        'website_url' => $website_url,
        'item_id' => $item_id,
        'license_type' => $license_type,
        'gdpr_status' => $gdpr_status,
        'activation_action' => $activation_action,
    ];

    // Use cURL to send the request with all parameters
    $response = wp_remote_post($server_url, [
        'body' => json_encode($request_data),
        'headers' => ['Content-Type' => 'application/json'],
    ]);
    $api_success = 'modeltheme.com';

    // // Handle the response
    // if (is_wp_error($response)) {
    //     $response = wp_remote_post($server_url_secondary, [
    //         'body' => json_encode($request_data),
    //         'headers' => ['Content-Type' => 'application/json'],
    //     ]);
    //     $api_success = 'modelthe.me';
    // }

    // Handle the response or report an error
    if (is_wp_error($response)) {
        wp_send_json(['message' => 'Error connecting to license server.']);
        return;
    }

    // Decode the server's response
    $response_data = json_decode(wp_remote_retrieve_body($response), true);

    // Return the server's response as is
    if ($response_data) {
        $response_data['api_success_source'] = $api_success;
        if (isset($response_data['status']) && $response_data['status'] === 'success') {
            if ($response_data['license_status'] == 'activated') {
                // delete old api meta
                delete_option('modelthemeAPIactivator');
                // update the new api meta
                update_option('modeltheme_keyv3_activator', [
                    'purchase_key' => $purchase_key,
                    'license_type' => 'market',
                    'expiry_date' => $response_data['expiry_date']
                ]);
            }else{
                delete_option('modeltheme_keyv3_activator');
            }
            wp_send_json($response_data);
        } else {
            wp_send_json($response_data);
        }
    } else {
        wp_send_json(['message' => '<div class="mtav3-notice mtav3-notice-error">Unexpected error occurred (No response from server). Contact Support</div>']);
    }

    wp_die();
}

add_action('wp_ajax_activate_license', 'modeltheme_activate_market_license');


add_action('modeltheme_system_requirements_panel', 'modeltheme_system_requirements_panel_box');
function modeltheme_system_requirements_panel_box(){ ?>
    <div class="modeltheme-sys-info-panel">
        <h3>System Status</h3>
        <p>If you have speed issues or slow demo importer check and improve the system requirements.</p>
        <table class="modeltheme-sys-info-table widefat striped health-check-table" role="presentation">
            <thead>
                <tr>
                    <th><strong>Option</strong></th>
                    <th><strong>Current</strong></th>
                    <th><strong>Min. Recommended</strong></th>
                    <th><strong>Status</strong></th>
                </tr>
            </thead>
            <tbody><?php
                $settings = modeltheme_get_system_configs();
                foreach ($settings as $option) { ?>
                    <tr>
                        <td><?php echo $option['title']; ?></td>
                        <td>
                            <?php if ($option['pass'] == false) {echo '<div style="color: red; font-weight: bold;">';} 
                                echo $option['value']; 
                            if ($option['pass'] == false) {echo '</div>';} 
                            ?>
                        </td>
                        <td><?php echo $option['required']; ?></td>
                        <td class="modeltheme-sys-info-status">
                            <?php 
                            if ($option['pass'] == true) { ?>
                                <div style="color: green; font-weight: bold;"><span class="dashicons dashicons-yes-alt"></span> Passed</div><?php
                            }else{ ?>
                                <div style="color: red; font-weight: bold;"><span class="dashicons dashicons-info"></span></div> <?php echo $option['notice'];
                            } ?>
                        </td>
                    </tr><?php 
                } ?>
            </tbody>
        </table>
    </div><?php
}

function modeltheme_get_system_configs()
{
    $settings = [
        array(
            'title' => esc_html__('PHP Memory Limit', 'modeltheme'),
            'value' => size_format(wp_convert_hr_to_bytes(@ini_get('memory_limit'))),
            'required' => '128M',
            'pass' => (wp_convert_hr_to_bytes(@ini_get('memory_limit')) >= 134217728) ? true : false,
            'notice' => esc_html__('The current value is insufficient to properly support the theme. Please adjust this value to 128M in order to meet the theme requirements. ', 'modeltheme')
        ),
        array(
            'title' => esc_html__('PHP Version', 'modeltheme'),
            'value' => phpversion(),
            'required' => '7.4.x - 8.3.x',
            'pass' => version_compare(PHP_VERSION, '7.4.0') >= 0 ? true : false,
            'notice' => ''
        ),
        array(
            'title' => esc_html__('PHP Post Max Size', 'modeltheme'),
            'value' => ini_get('post_max_size'),
            'required' => '256M',
            'pass' => (str_replace('M', '', ini_get('post_max_size')) >= 256) ? true : false,
            'notice' => esc_html__('The current value is insufficient to properly support the theme. Please adjust this value to 256M in order to meet the theme requirements. ', 'modeltheme')
        ),
        array(
            'title' => esc_html__('PHP Time Limit', 'modeltheme'),
            'value' => ini_get('max_execution_time'),
            'required' => '300',
            'pass' => ((ini_get('max_execution_time') >= 300) || ini_get('max_execution_time') == -1) ? true : false,
            'notice' => esc_html__('The current value is insufficient to properly support the theme. Please adjust this value to 300 in order to meet the theme requirements. ', 'modeltheme')
        ),
        array(
            'title' => esc_html__('PHP Max Input Vars', 'modeltheme'),
            'value' => ini_get('max_input_vars'),
            'required' => '5000',
            'pass' => (ini_get('max_input_vars') >= 5000) ? true : false,
            'notice' => esc_html__('The current value is insufficient to properly support the theme. Please adjust this value to 5000 in order to meet the theme requirements. ', 'modeltheme')
        ),
        array(
            'title' => esc_html__('Max Upload Size', 'modeltheme'),
            'value' => size_format(wp_max_upload_size()),
            'required' => '64 MB',
            'pass' => (wp_max_upload_size() >= 67108864) ? true : false,
            'notice' => esc_html__('The current value is insufficient to properly support the theme. Please adjust this value to 64 MB in order to meet the theme requirements. ', 'modeltheme')
        ),
        array(
            'title' => esc_html__('Max Execution Time', 'modeltheme'),
            'value' => ini_get('max_execution_time'),
            'required' => '300',
            'pass' => (ini_get('max_execution_time') >= 300) ? true : false,
            'notice' => esc_html__('The current value is insufficient to properly support the theme. Please adjust this value to min 300 in order to meet the theme requirements. ', 'modeltheme')
        ),
    ];

    return $settings;
}