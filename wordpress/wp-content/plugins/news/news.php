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
load_plugin_textdomain('news', false, dirname(plugin_basename( __FILE__ )));

function create_news_post_type() {
	$labels = array(
		'name'               => __( 'News', 'news' ),
		'singular_name'      => __( 'News', 'news' ),
		'add_new'            => __( 'Add New', 'news' ),
		'add_new_item'       => __( 'Add News', 'news' ),
		'edit_item'          => __( 'Edit news', 'news' ),
		'new_item'           => __( 'Add news', 'news' ),
		'all_items'          => __( 'All news', 'news' ),
		'view_item'          => __( 'View news', 'news' ),
		'search_items'       => __( 'Search news', 'news' ),
		'not_found'          => __( 'No news found', 'news' ),
		'not_found_in_trash' => __( 'No news found in the Trash', 'news' ), 
		'parent_item_colon'  => '',
		'menu_name'          => __('News', 'news')
	);
	$args = array(
		'labels'        => $labels,
		'description'   => __('All news', 'news'),
		'public'        => true,
		'menu_position' => 6,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt'),
		'has_archive'   => __('news', 'news')
	);
	register_post_type( 'news', $args );	
}
add_action('init', 'create_news_post_type');

?>