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
load_plugin_textdomain('inspiration', false, dirname(plugin_basename( __FILE__ )));

function create_inspiration_post_type() {
	$labels = array(
		'name'               => __( 'Inspiration', 'inspiration' ),
		'singular_name'      => __( 'Inspiration', 'inspiration' ),
		'add_new'            => __( 'Add New', 'inspiration' ),
		'add_new_item'       => __( 'Add new inspiration', 'inspiration' ),
		'edit_item'          => __( 'Edit inspiration', 'inspiration' ),
		'new_item'           => __( 'New inspiration', 'inspiration' ),
		'all_items'          => __( 'All inspirations', 'inspiration' ),
		'view_item'          => __( 'View inspiration', 'inspiration' ),
		'search_items'       => __( 'Search inspirations', 'inspiration' ),
		'not_found'          => __( 'No inspirations found', 'inspiration' ),
		'not_found_in_trash' => __( 'No inspirations found in the Trash', 'inspiration' ), 
		'parent_item_colon'  => '',
		'menu_name'          => __('Inspiration', 'inspiration')
	);
	$args = array(
		'labels'        => $labels,
		'description'   => __('All the inspirations', 'inspiration'),
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt'),
		'has_archive'   => __('inspiration', 'inspiration')
	);
	register_post_type( 'inspiration', $args );	
}
add_action('init', 'create_inspiration_post_type');

?>