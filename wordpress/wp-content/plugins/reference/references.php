<?php
   /*
   Plugin Name: [kasparabi] Reference (post_type)
   Plugin URI: 
   Description: This is the plugin for the reference post type
   Version: 1.0
   Author: Peter Tollnes Flem
   Author URI: 
   */
?>
<?php

function create_references_post_type() {
	$labels = array(
		'name'               => __( 'References', 'kasparabi' ),
		'singular_name'      => __( 'Reference', 'kasparabi' ),
		'add_new'            => __( 'Add New', 'kasparabi' ),
		'add_new_item'       => __( 'Add new reference', 'kasparabi' ),
		'edit_item'          => __( 'Edit reference', 'kasparabi' ),
		'new_item'           => __( 'New reference', 'kasparabi' ),
		'all_items'          => __( 'All references', 'kasparabi' ),
		'view_item'          => __( 'View reference', 'kasparabi' ),
		'search_items'       => __( 'Search references', 'kasparabi' ),
		'not_found'          => __( 'No references found', 'kasparabi' ),
		'not_found_in_trash' => __( 'No references found in the Trash', 'kasparabi' ), 
		'parent_item_colon'  => '',
		'menu_name'          => __('References', 'kasparabi')
	);
	$args = array(
		'labels'        => $labels,
		'description'   => __('All the references', 'kasparabi'),
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt'),
		'has_archive'   => __('references', 'kasparabi')
	);
	register_post_type( 'reference', $args );	
}
add_action('init', 'create_references_post_type');

function add_references_to_query( $query ) {
	if ( is_home() && $query->is_main_query() )
		$query->set( 'post_type', array( 'reference' ) );
	return $query;
}
add_action( 'pre_get_posts', 'add_references_to_query' );

?>