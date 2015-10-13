<?php

/*
Plugin Name: [kasparabi] Reference taxonomy (taxonomy)
Plugin URI:
Description: Adds the reference taxonomy
Author: Peter Tollnes Flem
Version: 1.0
Author URI:
*/

function build_reference_taxonomies() {
	register_taxonomy(
		'reference-taxonomy',
		'reference',
		array(
			'label' => __('Reference Categories', 'kasparabi'),
			'query_var' => true,
			'hierarchical' => true
		)
	);
}
add_action( 'init', 'build_reference_taxonomies' );

function insert_reference_terms() {
	$categories = get_terms('reference-taxonomy', array('hide_empty' => false));

	if (empty($categories)) {
		if (!term_exists( 'wedding', 'reference-taxonomy'))
			wp_insert_term(__('Wedding', 'kasparabi'), 'reference-taxonomy', array(
				'description' => 'Used to categorize wedding references',
				'slug' => 'wedding'
			));

		if (!term_exists( 'residentialstyling', 'reference-taxonomy'))
			wp_insert_term(__('Residential Styling', 'kasparabi'), 'reference-taxonomy', array(
				'description' => 'Used to categorize residential styling references',
				'slug' => 'residentialstyling'
			));
	}
}
add_action( 'init', 'insert_reference_terms' );
