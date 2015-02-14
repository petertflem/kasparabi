<?php
 
/*
Plugin Name: [kasparabi] Text Link Images
Plugin URI: 
Description: Adds a media picker to the text links in the menu
Author: Peter Tollnes Flem
Version: 1.0
Author URI:
*/

class TextLinkImages {
  
  function __construct() {
    add_filter('wp_edit_nav_menu_walker', array($this, 'edit_walker'), 10, 2);
    add_filter('wp_update_nav_menu_item', array($this, 'update_image_field'), 10, 3);
  }
  
  function update_image_field($menu_id, $menu_item_id, $args) {
    if ( isset( $_POST[ "text_link_image_$menu_item_id" ] ) ) {
      update_post_meta( $menu_item_id, 'text_link_image', $_POST[ "text_link_image_$menu_item_id" ] );
    } else {
      delete_post_meta( $menu_item_id, 'text_link_image' );
    }
  }
               
  function edit_walker($walker, $menu_id) {
    require_once WP_PLUGIN_DIR . '/kasparabi-image-on-text-links/kasparabi-image-menu-walker.php';
    
    return 'Text_Link_Image_Menu_Walker'; 
  }
  
  
}

new TextLinkImages();

function enqueue_choose_image_script() {
  wp_enqueue_media();

  wp_register_script( 'choose-image', plugin_dir_url(__FILE__) . '/choose-image.js', array('jquery') );
  wp_localize_script( 'choose-image', 'meta_image', 
      array(
          'title' => __('Choose or upload an image', 'kasparabi'),
          'button' => __('Use this image', 'kasparabi')
      )
  );

  wp_enqueue_script('choose-image');
}
add_action( 'admin_enqueue_scripts', 'enqueue_choose_image_script' );