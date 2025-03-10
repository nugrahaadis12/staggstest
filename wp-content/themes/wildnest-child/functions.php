<?php
function wildnest_child_scripts() {
    wp_enqueue_style( 'wildnest-parent-style', get_template_directory_uri(). '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'wildnest_child_scripts' );
