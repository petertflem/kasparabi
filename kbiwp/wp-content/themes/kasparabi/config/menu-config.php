<?php

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
   * Set active class on currently active menu item
  /*--------------------------------------------------------------------------*/
  add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
    function special_nav_class($classes, $item){
    if( in_array('current-menu-item', $classes) ){
      $classes[] = 'active ';
    }
    return $classes;
  }

	/*--------------------------------------------------------------------------*
	 * Remove the edit.php from the admin menu
	/*--------------------------------------------------------------------------*/
	function remove_default_post_type() {
		remove_menu_page('edit.php');
	}
	add_action('admin_menu','remove_default_post_type');

?>