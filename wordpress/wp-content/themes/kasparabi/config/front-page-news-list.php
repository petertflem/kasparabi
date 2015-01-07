<?php
  
  /*
   * When using the frontpage-news menu, change the walker so we can generate html containg the news items image
   */
  add_filter( 'wp_nav_menu_args' , 'my_add_menu_descriptions' );
  function my_add_menu_descriptions( $args ) {
    if ( $args['theme_location'] == 'frontpage-news' ) {
      $args['walker'] = new Frontpage_News;
      $args['desc_depth'] = 0;
      $args['thumbnail'] = true;
      $args['thumbnail_link'] = false;
      $args['thumbnail_size'] = 'nav_thumb';
      $args['thumbnail_attr'] = array( 'class' => 'img-responsive' );
    }
		
		return $args;
	}

?>