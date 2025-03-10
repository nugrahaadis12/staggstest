<?php
/**
 * Settings panel partial
 */
?>
<div id="general" class="panel" style="display:block;">
    <div class="customizer">
        <p><?php echo esc_html__('Providing the quickest way to customize your theme with the inbuilt customizer.', 'modeltheme'); ?></p>
    	<?php
            $url = admin_url('customize.php');

            $links = array(
                array(
                    'icon'  =>  '/assets/images/header.png',
                    'label' => esc_html__('Header Builder', 'modeltheme'),
                    'url'   => add_query_arg(array('autofocus' => array('panel' => 'header_settings')), $url),
                ),
                array(
                    'icon'  =>  '/assets/images/footer.png',
                    'label' => __('Footer Builder', 'modeltheme'),
                    'url'   => add_query_arg(array('autofocus' => array('panel' => 'footer_settings')), $url),
                ),
                array(
                    'icon'  =>  '/assets/images/blog.png',
                    'label' => __('Blog Settings', 'modeltheme'),
                    'url'   => add_query_arg(array('autofocus' => array('panel' => 'blog_panel')), $url),
                ),
                array(
                    'icon'  =>  '/assets/images/social.png',
                    'label' => __('Social Media', 'modeltheme'),
                    'url'   => add_query_arg(array('autofocus' => array('section' => 'social_media_panel')), $url),
                ),
                array(
                    'icon'  =>  '/assets/images/general.png',
                    'label' => __('General Settings', 'modeltheme'),
                    'url'   => add_query_arg(array('autofocus' => array('section' => 'general_settings_panel')), $url),
                ),
                array(
                    'icon'  =>  '/assets/images/styling.png',
                    'label' => __('Styling Settings', 'modeltheme'),
                    'url'   => add_query_arg(array('autofocus' => array('panel' => 'styling_settings_panel')), $url),
                ),
                array(
                    'icon'  =>  '/assets/images/404.png',
                    'label' => __('404 Settings', 'modeltheme'),
                    'url'   => add_query_arg(array('autofocus' => array('panel' => 'not_found_panel')), $url),
                ),
                array(
                    'icon'  =>  '/assets/images/menu.png',
                    'label' => __('Menus', 'modeltheme'),
                    'url'   => add_query_arg(array('autofocus' => array('section' => 'nav_menus')), $url),
                ),
                array(
                    'icon'  =>  '/assets/images/widgets.png',
                    'label' => __('Widgets', 'modeltheme'),
                    'url'   => add_query_arg(array('autofocus' => array('section' => 'widgets')), $url),
                ),
                array(
                    'icon'  =>  '/assets/images/homepage.png',
                    'label' => __('Homepage', 'modeltheme'),
                    'url'   => add_query_arg(array('autofocus' => array('section' => 'static_front_page')), $url),
                ),
                array(
                    'icon'  =>  '/assets/images/woo.png',
                    'label' => __('WooCommerce', 'modeltheme'),
                    'url'   => add_query_arg(array('autofocus' => array('section' => 'woocommerce')), $url),
                ),
                array(
                    'icon'  =>  '/assets/images/css.png',
                    'label' => __('Additional CSS', 'modeltheme'),
                    'url'   => add_query_arg(array('autofocus' => array('section' => 'custom_css')), $url),
                ),
            );

            ?>
           <?php foreach ($links as $link) { ?>
               <li class="customizer-links">
                    <img src="<?php echo PLUGIN_URL.$link['icon'] ; ?>" alt="<?php echo esc_html($link['label']); ?>" >
                    <a href="<?php echo esc_url($link['url']); ?>" target="_blank"><?php echo esc_html($link['label']); ?></a>
                </li>
            <?php } ?>
    </div>

    <div class="quick-links">
        <h2><?php echo esc_html__('Quick Links', 'modeltheme'); ?></h3>
       
        <div class="links-panel-blocks" bis_skin_checked="1">
            <div class="clickable-box" bis_skin_checked="1">
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>../assets/images/docs.svg" alt="docs">  
                <h3>Online Documentation</h3>
                <p>We offer a comprehensive package of documentation to explain our theme features and functionalities.</p>
                <a href="<?php echo MODELTEMA_THEME_DOCS_URL; ?>" target="_blank">View Documentation</a>
            </div>
            <div class="clickable-box" bis_skin_checked="1">
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>../assets/images/video.svg" alt="https://www.youtube.com/playlist?list=PLfHB3UBK6MMnLxbtT7DyidrI9eJXxmSiy">  
                <h3>Video Tutorials</h3>
                <p>We provide interactive installation video and complex WordPress theme tutorials and instructions.</p>
                <a href="https://www.youtube.com/playlist?list=PLfHB3UBK6MMnLxbtT7DyidrI9eJXxmSiy" target="_blank">Check Channel</a>
            </div>
            <div class="clickable-box" bis_skin_checked="1">
                <img src="<?php echo plugin_dir_url( __FILE__ ); ?>../assets/images/support.svg" alt="https://modeltheme.ticksy.com">  
                <h3>Customer Support</h3>
                <p>Our Knowledge Base contains important tutorials, tips and tricks for beginners and professionals.</p>
                <a href="https://modeltheme.ticksy.com" target="_blank">Go to Ticksy</a>
            </div>
            
        </div>
    </div>
    
</div>
