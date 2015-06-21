<?php
  
  /**
   * Allow thumbnails in menu
   */
  class Frontpage_News extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
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

      $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );
    }
  }