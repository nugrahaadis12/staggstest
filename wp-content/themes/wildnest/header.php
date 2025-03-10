<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Wildnest
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=10.0, user-scalable=yes">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
}
?>
<div id="page">
	<a class="skip-link screen-reader-text" href="#wildnest-site-content"><?php esc_html_e( 'Skip to content', 'wildnest' ); ?></a>
	<?php
	do_action( 'wildnest/site-start/before' );
	
		/**
		 * Site start
		 *
		 * Hooked
		 *
		 * @see wildnest_customize_render_header - 10
		 * @see wildnest_Page_Header::render - 35
		 */
		do_action( 'wildnest/site-start' );
	
	/**
	 * Hook before main content
	 */
	do_action( 'wildnest/before-site-content' );
	?>
	<div id="wildnest-site-content" >
		<div>
			<div>
				<?php do_action( 'wildnest/main/before' );
