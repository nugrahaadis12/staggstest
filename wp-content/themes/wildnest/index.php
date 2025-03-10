<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package wildnest
 */

get_header();

do_action( 'wildnest_before_main_content' );

get_template_part('templates/content/templates/content');

do_action( 'wildnest_after_main_content' );

get_footer();