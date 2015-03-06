<?php

  /**
	 * Set number of custom post types per page on archive pages
	 */
	function add_custom_posts_per_page( $q ) {	
		global $custom_post_types;
		$custom_post_types = array('reference', 'news', 'inspiration');

		if ( $q->is_main_query() && $q->is_archive && !is_admin() ) {
			if ( in_array ($q->query_vars['post_type'], $custom_post_types) ) {
				$post_type = $q->query_vars['post_type'];
				$options = get_option('kasparabi_settings');

				$q->set( 'posts_per_page', $options['kasparabi_archive_' . $post_type . '_num_per_page'] );
			}
		}

		return $q;
	}
	add_filter('parse_query', 'add_custom_posts_per_page');

	/**
	 * If the archive is the inspiration archive, filter by category if we have one
	 */
	function add_inspiration_category( $q ) {
		if ($q->is_main_query() 
	   		&& $q->is_post_type_archive('inspiration') 
	   		&& !is_admin()) {

			$category_id = $_GET['c'];
			if (!empty($category_id)) {
				$q->set('tax_query', array(
					array(
						'taxonomy' => 'inspiration-taxonomy',
						'field' => 'id',
						'terms' => $category_id
					)
				));
			}
		}

		return $q;
	}
	add_filter('parse_query', 'add_inspiration_category');

  /**
	 * Add custom post types to home page query
	 */
	function add_custom_post_types_to_home_page_query( $query ) {
		if ( is_home() && $query->is_main_query() )
			$query->set( 'post_type', array( 'news', 'reference' ) );
		return $query;
	}
	add_action( 'pre_get_posts', 'add_custom_post_types_to_home_page_query' );

?>