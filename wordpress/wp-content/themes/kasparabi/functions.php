<?php

// include all PHP files in ./config/ directory:

foreach ( glob( dirname( __FILE__ ) . '/config/*.php' ) as $file )
    include $file;


//  include TEMPLATEPATH  . '/custom-pages/page-templater.php';/
//  add_action('plugins_loaded', array('PageTemplater', 'get_instance'));

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
      ));
    
      if ( empty( $attachments ) )
        return '';

      $output = "\n";

      /**
       * Loop through each attachment
       */
      $iterations = 0;
      $nthElement = 0;
      $rowLength = 3;
    
      foreach ( $attachments as $id  => $attachment ) {
          $nthElement = ++$nthElement == $rowLength ? 0 : $nthElement;
          $open = !( $iterations++ % $rowLength ) ? '<div class="row">' : '';
          $close = !( $iterations % 3 ) && $iterations ? '</div>' : '';

          $title = esc_html( $attachment->post_title, 1 );
          $img = wp_get_attachment_image_src( $id, $size );

          $output .= $open . '<div class="col-xs-4 gallery-image"><a href="' . esc_url( wp_get_attachment_url( $id ) ) . '" title="' . esc_attr( $title ) . '">';
          $output .= '<div class="article-gallery-image" style="background: url(' . esc_url( $img[0] ) . ') no-repeat; background-position: center center; background-size: cover;" title="' . esc_attr( $title ) . '"></div>';
          $output .= '</a></div>' . $close;
      }

      if ($nthElement % $rowLength)
          $output .= '</div>';

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

			// set the image title and alt from the featured image
			$correspondig_page_id = get_post_meta($item->ID, '_menu_item_object_id', true);	// get the id the nav_menu_item points to
			$thumbnail_id = get_post_thumbnail_id($correspondig_page_id);
			$title = get_post($thumbnail_id)->post_title;
			$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

			$args->thumbnail_attr["title"] = $title;
			$args->thumbnail_attr["alt"] = $alt;

			$attr = isset( $args->thumbnail_attr ) ? $args->thumbnail_attr : '';
			$attr = wp_parse_args( $attr , $attr_defaults );
	 
      $item_output = $args->before;
			
			// thumbnail image output
			//$item_output .= ( isset( $args->thumbnail_link ) && $args->thumbnail_link ) ? '<a' . $attributes . '>' : '';
			//$item_output .= apply_filters( 'menu_item_thumbnail' , ( isset( $args->thumbnail ) && $args->thumbnail ) ? get_the_post_thumbnail( $item->object_id , ( isset( $args->thumbnail_size ) ) ? $args->thumbnail_size : 'thumbnail' , $attr ) : '' , $item , $args , $depth );		
			//$item_output .= ( isset( $args->thumbnail_link ) && $args->thumbnail_link ) ? '</a>' : '';
			
			$post = get_post($item->object_id);
			$isInspiration = $post->post_type !== 'inspiration';
			if ($isInspiration) {
				// menu link output
        $item_output .= '<a'. $attributes .'>';

				$item_output .= apply_filters( 'menu_item_thumbnail' , ( isset( $args->thumbnail ) && $args->thumbnail ) ? get_the_post_thumbnail( $item->object_id , ( isset( $args->thumbnail_size ) ) ? $args->thumbnail_size : 'thumbnail' , $attr ) : '' , $item , $args , $depth );		
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

	