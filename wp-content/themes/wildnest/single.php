<?php
/**
 * The template for displaying all single posts.
 *
 * @package wildnest
 */
get_header();

do_action( 'wildnest_before_main_content' );

get_template_part('templates/content/templates/content-single');

do_action( 'wildnest_after_main_content' );

get_footer();