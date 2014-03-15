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
			'main-navigation' => __('Main Menu', 'kasparabi'),
			'frontpage-news' => __('Frontpage News', 'kasparabi')
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
	    $post_id = '';

	    if (isset($_GET['post'])) {
	        $post_id = $_GET['post'];
	    } else if (isset($_GET['post_ID'])) {
	        $post_id = $_GET['post_ID'];
	    } else {
	        return;
	    }
	 
		// Get the name of the Page Template file.
		$template_file = get_post_meta($post_id, '_wp_page_template', true);
	 
	    if($template_file == 'page-inspiration-picker.php'
	    	|| $template_file == 'page-contact-us.php'){ 
	    	remove_post_type_support('page', 'editor');
	    	remove_post_type_support('page', 'thumbnail');
	    }
	}
	add_action( 'admin_init', 'hide_editor' );





	/*--------------------------------------------------------------------------*
	 * Enqueue JavaScript
	/*--------------------------------------------------------------------------*/
	function kasparabi_enqueue_javascript() {
		wp_register_script('bootstrapjs', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'));
		wp_register_script('magnific-popupjs', get_template_directory_uri() . '/js/magnific-popup.min.js', array('jquery'));
		wp_register_script('inspiration-gallery', get_template_directory_uri() . '/js/initialize-mgnific-popup.js', array('jquery', 'magnific-popupjs'));
		wp_register_script('mainjs', get_template_directory_uri() . '/js/main.js', array('jquery', 'bootstrapjs'));

		wp_enqueue_script('bootstrapjs');
		wp_enqueue_script('magnific-popupjs');
		wp_enqueue_script('inspiration-gallery');
		wp_enqueue_script('mainjs');	
	}
	add_action('wp_enqueue_scripts', 'kasparabi_enqueue_javascript');





	/*--------------------------------------------------------------------------*
	 * Get all the images uploaded to a post
	/*--------------------------------------------------------------------------*/
	/**
     * Gets all images attached to a post
     * @return string
     */
    function kasparabi_get_images() {
        global $post;
        $id = intval( $post->ID );
        $size = 'medium';
        $attachments = get_children( array(
                'post_parent' => $id,
                'post_status' => 'inherit',
                'post_type' => 'attachment',
                'post_mime_type' => 'image',
                'order' => 'ASC',
                'orderby' => 'menu_order'
            ) );
        if ( empty( $attachments ) )
                    return '';

        $output = "\n";
        
        /**
         * Loop through each attachment
         */
        $iterations = 0;
        $nthElement = 0;
        $rowLength = 3;
        foreach ( $attachments as $id  => $attachment ) :
            $nthElement = $nthElement == $rowLength ? 0 : ++$nthElement;
            $open = !( $iterations++ % $rowLength ) ? '<div class="row">' : '';
            $close = !( $iterations % 3 ) && $iterations ? '</div>' : '';

            $title = esc_html( $attachment->post_title, 1 );
            $img = wp_get_attachment_image_src( $id, $size );

            $output .= $open . '<div class="col-xs-4"><a href="' . esc_url( wp_get_attachment_url( $id ) ) . '" title="' . esc_attr( $title ) . '">';
            $output .= '<img class="img-responsive" src="' . esc_url( $img[0] ) . '" alt="' . esc_attr( $title ) . '" title="' . esc_attr( $title ) . '" />';
            $output .= '</a></div>' . $close;

        endforeach;

        return $output;
    }






	/**
	 * Allow thumbnails in menu
	 */
	class Frontpage_News extends Walker_Nav_Menu {
	    function start_el(&$output, $item, $depth, $args) {
	        global $wp_query;
			
	        $indent = ( $depth ) ? str_repeat( "t", $depth ) : '';
	 
	        $class_names = $value = '';
	 
	        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
	 
	        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
	        $class_names = ' class="' . esc_attr( $class_names ) . ' col-sm-4"';
	 		
	        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
	 
	        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
	        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
	        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
	        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			
			// get user defined attributes for thumbnail images
			$attr_defaults = array( 'class' => 'nav_thumb' , 'alt' => esc_attr( $item->attr_title ) , 'title' => esc_attr( $item->attr_title ) );
			$attr = isset( $args->thumbnail_attr ) ? $args->thumbnail_attr : '';
			$attr = wp_parse_args( $attr , $attr_defaults );
	 
	        $item_output = $args->before;
			
			// thumbnail image output
			$item_output .= ( isset( $args->thumbnail_link ) && $args->thumbnail_link ) ? '<a' . $attributes . '>' : '';
			$item_output .= apply_filters( 'menu_item_thumbnail' , ( isset( $args->thumbnail ) && $args->thumbnail ) ? get_the_post_thumbnail( $item->object_id , ( isset( $args->thumbnail_size ) ) ? $args->thumbnail_size : 'thumbnail' , $attr ) : '' , $item , $args , $depth );		
			$item_output .= ( isset( $args->thumbnail_link ) && $args->thumbnail_link ) ? '</a>' : '';
			
			$post = get_post($item->object_id);
			$isInspiration = $post->post_type !== 'inspiration';
			if ($isInspiration) {
				// menu link output
		        $item_output .= '<a'. $attributes .'>';
		        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
				
				// menu description output based on depth
		        $item_output .= ( $args->desc_depth >= $depth ) ? '<br /><span class="sub">' . $item->description . '</span>' : '';
				
				// close menu link anchor
		        $item_output .= '</a>';
		    } else {
	    		$item_output .= '<h1>' . apply_filters( 'the_title', $item->title, $item->ID ) . '</h1>';
		    }

	        $item_output .= $args->after;
	 
	        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	    }
	}

	add_filter( 'wp_nav_menu_args' , 'my_add_menu_descriptions' );
	function my_add_menu_descriptions( $args ) {
		if ( $args['theme_location'] == 'frontpage-news' ) {

			$args['walker'] = new Frontpage_News;
			$args['desc_depth'] = 0;
			$args['thumbnail'] = true;
			$args['thumbnail_link'] = false;
			$args['thumbnail_size'] = 'nav_thumb';
			$args['thumbnail_attr'] = array( 'class' => 'img-responsive' , 'alt' => 'test' , 'title' => 'test' );
		}
		
		return $args;
	}