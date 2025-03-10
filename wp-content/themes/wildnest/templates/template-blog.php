<?php
/*
* Template Name: Blog
*/
get_header();

do_action( 'wildnest_before_main_content' );

get_template_part('templates/content/templates/content-blog');

do_action( 'wildnest_after_main_content' );

get_footer();