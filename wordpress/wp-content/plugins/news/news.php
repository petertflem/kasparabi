<?php
   /*
   Plugin Name: [kasparabi] News (post_type)
   Plugin URI: 
   Description: This is the plugin for the news post type
   Version: 1.0
   Author: Peter Tollnes Flem
   Author URI: 
   */
?>
<?php

function create_news_post_type() {
	$labels = array(
		'name'               => __( 'News', 'kasparabi' ),
		'singular_name'      => __( 'News', 'kasparabi' ),
		'add_new'            => __( 'Add New', 'kasparabi' ),
		'add_new_item'       => __( 'Add News', 'kasparabi' ),
		'edit_item'          => __( 'Edit news', 'kasparabi' ),
		'new_item'           => __( 'Add news', 'kasparabi' ),
		'all_items'          => __( 'All news', 'kasparabi' ),
		'view_item'          => __( 'View news', 'kasparabi' ),
		'search_items'       => __( 'Search news', 'kasparabi' ),
		'not_found'          => __( 'No news found', 'kasparabi' ),
		'not_found_in_trash' => __( 'No news found in the Trash', 'kasparabi' ), 
		'parent_item_colon'  => '',
		'menu_name'          => __('News', 'kasparabi')
	);
	$args = array(
		'labels'        => $labels,
		'description'   => __('All news', 'kasparabi'),
		'public'        => true,
		'menu_position' => 6,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt'),
		'has_archive'   => __('news', 'kasparabi')
	);
	register_post_type( 'news', $args );	
}
add_action('init', 'create_news_post_type');

?>