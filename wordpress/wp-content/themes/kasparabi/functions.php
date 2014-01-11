<?php
	/*--------------------------------------------------------------------------*
	 * Constants
	/*--------------------------------------------------------------------------*/
	define('THEMEROOT', get_stylesheet_directory_uri());
	define('IMAGES', THEMEROOT . '/images');





	/*--------------------------------------------------------------------------*
	 * Register menus
	/*--------------------------------------------------------------------------*/
	function register_my_menus () {
		register_nav_menus(array(
			'main-navigation' => __('Main Menu', 'kasparabi')
		));
	}
	add_action('init', 'register_my_menus');





	/*--------------------------------------------------------------------------*
	 * Add theme support
	/*--------------------------------------------------------------------------*/
	add_theme_support( 'post-thumbnails' );





	/*--------------------------------------------------------------------------*
	 * Add theme support
	/*--------------------------------------------------------------------------*/
	function remove_default_post_type() {
		remove_menu_page('edit.php');
	}
	add_action('admin_menu','remove_default_post_type');





	/*--------------------------------------------------------------------------*
	 * Customize custom post type archive query
	/*--------------------------------------------------------------------------*/

	/**
	 * Set number of custom post types per page on archive pages
	 */
	function add_custom_posts_per_page( &$q ) {	
		global $custom_post_types;
		$custom_post_types = array('reference', 'news', 'inspiration');

		if ( $q->is_archive && !is_admin() ) {
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
		if (is_post_type_archive('inspiration') && !is_admin()) {

			$category_id = $_GET['category'];
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





	/*--------------------------------------------------------------------------*
	 * Register custom post types with search
	/*--------------------------------------------------------------------------*/

	/**
	 * Add custom post types to home page query
	 */
	function add_custom_post_types_to_home_page_query( $query ) {
		if ( is_home() && $query->is_main_query() )
			$query->set( 'post_type', array( 'news', 'reference' ) );
		return $query;
	}
	add_action( 'pre_get_posts', 'add_custom_post_types_to_home_page_query' );





	/*--------------------------------------------------------------------------*
	 * Remove post types from query results
	/*--------------------------------------------------------------------------*/
	function remove_pages_from_search() {
	    global $wp_post_types;
	    $wp_post_types['page']->exclude_from_search = true;
	}
	add_action('init', 'remove_pages_from_search');





	/*--------------------------------------------------------------------------*
	 * Hide editor for specific page templates
	/*--------------------------------------------------------------------------*/
	function hide_editor() {
		/*$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
		if( !isset( $post_id ) ) return;
	 
		// Get the name of the Page Template file.
		$template_file = get_post_meta($post_id, '_wp_page_template', true);
	 
	    if($template_file == 'page-inspiration-picker.php'){ 
	    	remove_post_type_support('page', 'editor');
	    	remove_post_type_support('page', 'thumbnail');
	    }*/
	}
	add_action( 'admin_init', 'hide_editor' );