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
load_plugin_textdomain('reference', false, dirname(plugin_basename( __FILE__ )));

function create_references_post_type() {
	$labels = array(
		'name'               => __( 'References', 'reference' ),
		'singular_name'      => __( 'Reference', 'reference' ),
		'add_new'            => __( 'Add New', 'reference' ),
		'add_new_item'       => __( 'Add new reference', 'reference' ),
		'edit_item'          => __( 'Edit reference', 'reference' ),
		'new_item'           => __( 'New reference', 'reference' ),
		'all_items'          => __( 'All references', 'reference' ),
		'view_item'          => __( 'View reference', 'reference' ),
		'search_items'       => __( 'Search references', 'reference' ),
		'not_found'          => __( 'No references found', 'reference' ),
		'not_found_in_trash' => __( 'No references found in the Trash', 'reference' ),
		'parent_item_colon'  => '',
		'menu_name'          => __('References', 'reference')
	);
	$args = array(
		'labels'        => $labels,
		'description'   => __('All the references', 'reference'),
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt'),
		'has_archive'   => __('references', 'reference')
	);
	register_post_type( 'reference', $args );
}
add_action('init', 'create_references_post_type');

?>
