<?php
// Exit if accessed directly
if (!defined('ABSPATH')) { exit; }
?>
<div class="mtfe-wrap">
    <div id="mtfe-banner-wrap">
        <div id="mtfe-banner" class="mtfe-banner-sticky">
            <h2><span><?php echo esc_html__('MT Addons for Elementor', 'mt-addons'); ?></span><?php echo esc_html__('MT Addons for Elementor', 'mt-addons'); ?></h2>
            <div id="mtfe-buttons-wrap">
                <a class="mtfe-button" data-action="mtfe_save_settings" id="mtfe_settings_save"><i class="dashicons dashicons-yes"></i><?php echo esc_html__('Save Settings', 'mt-addons') ?></a>
                <a class="mtfe-button reset" data-action="mtfe_reset_settings" id="mtfe_settings_reset"><i class="dashicons dashicons-update"></i><?php echo esc_html__('Reset', 'mt-addons') ?></a>
            </div>
        </div>
    </div>