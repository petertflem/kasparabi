<?php
   /*
   Plugin Name: [kasparabi] Inspiration (post_type)
   Plugin URI: 
   Description: This is the plugin for the inspiration post type
   Version: 1.0
   Author: Peter Tollnes Flem
   Author URI: 
   */
?>
<?php

function create_inspiration_post_type() {
	$labels = array(
		'name'               => __( 'Inspiration', 'kasparabi' ),
		'singular_name'      => __( 'Inspiration', 'kasparabi' ),
		'add_new'            => __( 'Add New', 'kasparabi' ),
		'add_new_item'       => __( 'Add new inspiration', 'kasparabi' ),
		'edit_item'          => __( 'Edit inspiration', 'kasparabi' ),
		'new_item'           => __( 'New inspiration', 'kasparabi' ),
		'all_items'          => __( 'All inspirations', 'kasparabi' ),
		'view_item'          => __( 'View inspiration', 'kasparabi' ),
		'search_items'       => __( 'Search inspirations', 'kasparabi' ),
		'not_found'          => __( 'No inspirations found', 'kasparabi' ),
		'not_found_in_trash' => __( 'No inspirations found in the Trash', 'kasparabi' ), 
		'parent_item_colon'  => '',
		'menu_name'          => __('Inspiration', 'kasparabi')
	);
	$args = array(
		'labels'        => $labels,
		'description'   => __('All the inspirations', 'kasparabi'),
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt'),
		'has_archive'   => __('inspiration', 'kasparabi')
	);
	register_post_type( 'inspiration', $args );	
}
add_action('init', 'create_inspiration_post_type');

?>