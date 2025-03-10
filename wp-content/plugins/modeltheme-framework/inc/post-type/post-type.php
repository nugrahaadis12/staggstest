<?php

define('CF_POST_TYPE_DIR', trailingslashit(dirname(__FILE__)));

class CF_Post_Type {
	
	static function add_hooks() {
		add_action('init', 'CF_Post_Type::register_knowledgebase_post_type');
		add_action('init', 'CF_Post_Type::register_knowledgebase_post_type_category');

	}
	
	static function register_knowledgebase_post_type() {
		register_post_type('mt-knowledgebase', array(
		    'label' => esc_html__('Knowledge Base','mtkb'),
		    'description' => '',
		    'public' => true,
		    'show_ui' => true,
		    'show_in_menu' => true,
		    'capability_type' => 'post',
		    'map_meta_cap' => true,
		    'hierarchical' => true,
		    'rewrite' => array('slug' => 'knowledgebase', 'with_front' => true),
		    'query_var' => true,
		    'menu_position' => '1',
		    'has_archive' => false,
		    'menu_icon' => 'dashicons-performance',
		    'supports' => array('title','editor','thumbnail','author','excerpt', 'comments'),
		    'labels' => array (
		        'name' => esc_html__('Knowledge Base','mtkb'),
		        'singular_name' => esc_html__('Knowledge','mtkb'),
		        'menu_name' => esc_html__('MT Knowledge Base','mtkb'),
		        'add_new' => esc_html__('Add Knowledge','mtkb'),
		        'add_new_item' => esc_html__('Add New Knowledge','mtkb'),
		        'edit' => esc_html__('Edit','mtkb'),
		        'edit_item' => esc_html__('Edit Knowledge','mtkb'),
		        'new_item' => esc_html__('New Knowledge','mtkb'),
		        'view' => esc_html__('View Knowledge','mtkb'),
		        'view_item' => esc_html__('View Knowledge','mtkb'),
		        'search_items' => esc_html__('Search Knowledge Base','mtkb'),
		        'not_found' => esc_html__('No Knowledge Found','mtkb'),
		        'not_found_in_trash' => esc_html__('No Knowledge Found in Trash','mtkb'),
		        'parent' => esc_html__('Parent Knowledge','mtkb'),
		        )
		    ) 
		); 
	}

	static function register_knowledgebase_post_type_category() {
	    
	    $labels = array(
	        'name'                       => esc_html_x( 'Categories', 'Taxonomy General Name', 'mtkb'  ),
	        'singular_name'              => esc_html_x( 'Categories', 'Taxonomy Singular Name', 'mtkb'  ),
	        'menu_name'                  => esc_html__( 'Categories', 'mtkb'  ),
	        'all_items'                  => esc_html__( 'All Items', 'mtkb'  ),
	        'parent_item'                => esc_html__( 'Parent Item', 'mtkb'  ),
	        'parent_item_colon'          => esc_html__( 'Parent Item:', 'mtkb'  ),
	        'new_item_name'              => esc_html__( 'New Item Name', 'mtkb'  ),
	        'add_new_item'               => esc_html__( 'Add New Item', 'mtkb'  ),
	        'edit_item'                  => esc_html__( 'Edit Item', 'mtkb'  ),
	        'update_item'                => esc_html__( 'Update Item', 'mtkb'  ),
	        'view_item'                  => esc_html__( 'View Item', 'mtkb'  ),
	        'separate_items_with_commas' => esc_html__( 'Separate items with commas', 'mtkb'  ),
	        'add_or_remove_items'        => esc_html__( 'Add or remove items', 'mtkb'  ),
	        'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'mtkb'  ),
	        'popular_items'              => esc_html__( 'Popular Items', 'mtkb'  ),
	        'search_items'               => esc_html__( 'Search Items', 'mtkb'  ),
	        'not_found'                  => esc_html__( 'Not Found', 'mtkb'  ),
	    );

	    $args = array(
	        'hierarchical'      => true,
	        'labels'            => $labels,
	        'show_ui'           => true,
	        'show_admin_column' => true,
	        'show_in_nav_menus'          => true,
	        'query_var'         => true,
	        'rewrite'           => array( 'slug' => 'knowledgebase-category' ),
	        'public'            => true,
	    );

	    register_taxonomy( 'mt-knowledgebase-category', array( 'mt-knowledgebase' ), $args );
	}
	
}
CF_Post_Type::add_hooks();
