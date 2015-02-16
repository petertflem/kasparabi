<?php

class Text_Link_Image_Menu_Walker extends Walker_Nav_Menu_Edit {
  
  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    
    parent::start_el($output, $item, $depth, $args);
    
    if ( ! class_exists( 'phpQuery') )
      require_once 'phpQuery-onefile.php';

    $_doc = phpQuery::newDocumentHTML( $output );
    $_li = phpQuery::pq('li.menu-item-custom');
    
    //echo htmlspecialchars($_li);
    
    // if the last <li>'s id attribute doesn't match $item->ID something is very wrong, don't do anything
    // just a safety, should never happen...
    $menu_item_id = str_replace( 'menu-item-', '', $_li->attr( 'id' ) );
    if( $menu_item_id != $item->ID ) {
      return;
    }

    $image_url = esc_attr( get_post_meta( $menu_item_id, 'text_link_image', true ) );

    // by means of phpQuery magic, inject a new input field
    $_li->find('.field-url')
        ->append("<p class='description'>Image URL (only for the gallery menu page)<br /><input type='text' value='$image_url' name='text_link_image_$menu_item_id' id='text_link_image' /><button id='select-image'>Select Image</button></p>");
    
    // swap the $output
    $output = $_doc->html();
  }
}