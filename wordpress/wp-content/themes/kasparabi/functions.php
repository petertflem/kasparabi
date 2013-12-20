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
	 * Make custom post type archive pagination work
	/*--------------------------------------------------------------------------*/
	function add_custom_posts_per_page( &$q ) {	
		global $custom_post_types;

		$custom_post_types = array('reference', 'news');
		if ( $q->is_archive && !is_admin() ) { // any archive that isn't in admin
			if ( in_array ($q->query_vars['post_type'], $custom_post_types) ) {

				$q->set( 'posts_per_page', 9);

                $options = get_option('kasparabi_settings');

				if ($q->query_vars['post_type'] === 'reference')
					$q->set( 'posts_per_page', $options['kasparabi_archive_references_num_per_page'] );

				if ($q->query_vars['post_type'] === 'news')
					$q->set( 'posts_per_page', $options['kasparabi_archive_news_num_per_page'] );
				
			}
		}
		return $q;
	}
	add_filter('parse_query', 'add_custom_posts_per_page');





	/*--------------------------------------------------------------------------*
	 * Remove post types from query results
	/*--------------------------------------------------------------------------*/
	function remove_pages_from_search() {
	    global $wp_post_types;
	    $wp_post_types['page']->exclude_from_search = true;
	}
	add_action('init', 'remove_pages_from_search');