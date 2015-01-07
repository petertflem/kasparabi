<?php

	/**
	 * Remove post types from query results
	 */
	function remove_pages_from_search() {
	    global $wp_post_types;
	    $wp_post_types['page']->exclude_from_search = true;
	}
	add_action('init', 'remove_pages_from_search');

?>