<?php
 
/*
Plugin Name: [kasparabi] Inspiration taxonomy (taxonomy)
Plugin URI: 
Description: Adds the inspiration taxonomy
Author: Peter Tollnes Flem
Version: 1.0
Author URI:
*/

function build_inspiration_taxonomies() {
	register_taxonomy(
		'inspiration-taxonomy',
		'inspiration',
		array(
			'label' => __('Inspiration Categories', 'kasparabi'),
			'query_var' => true,
			'hierarchical' => true
		)
	);
}
add_action( 'init', 'build_inspiration_taxonomies' );

function insert_inspiration_terms() {
	$categories = get_terms('inspiration-taxonomy', array('hide_empty' => false));

	if (empty($categories)) {
		if (!term_exists( 'wedding', 'inspiration-taxonomy'))
			wp_insert_term(__('Wedding', 'kasparabi'), 'inspiration-taxonomy', array(
				'description' => 'Used to categorize wedding references',
				'slug' => 'wedding'
			));

		if (!term_exists( 'interior', 'inspiration-taxonomy'))
			wp_insert_term(__('Interior', 'kasparabi'), 'inspiration-taxonomy', array(
				'description' => 'Used to categorize interior references',
				'slug' => 'interior'
			));
	}
}
add_action( 'init', 'insert_inspiration_terms' );