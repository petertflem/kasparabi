<?php
  
/**
 * Allow thumbnails in menu
 */
class GalleryMenu extends Walker_Nav_Menu {
  
  public $rowLength = 3;
  
  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    $iterations = (int) $args->iterations;
    
    $output .= !( $iterations++ % $this->rowLength ) ? '<div class="row">' : '';
    $output .= '<div class="col-sm-4 gallery-image">';
    $output .= $this->build_element($item);
    $output .= '</div>';
    
    $args->iterations = $iterations;
  }
  
  public function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $iterations = (int) $args->iterations;
    
    $output .= !( $iterations % $this->rowLength ) && $iterations ? '</div>' : '';
    
    // Get menu object
    $my_menu = wp_get_nav_menu_object( $args->menu );
    $numberOfElements = $my_menu->count;

    if ($iterations == $numberOfElements && ($numberOfElements % $this->rowLength != 0))
      $output .= '</div>';
  }
  
  private function build_element($item) {
    $attachment_id = get_post_thumbnail_id($item->object_id);
    $img = wp_get_attachment_image_src($attachment_id, 'large');
    $title = apply_filters( 'the_title', $item->title, $item->ID );
    
    $item_output = '<a href="' . $item->url . '">';
    $item_output .= '<div class="gallery-menu-image" style="background: url(' . esc_url($img[0]) . ') no-repeat; background-position: center center; background-size: cover;"></div>';
    $item_output .= '<h4>' . $title . '</h4>';
    $item_output .= '</a>';
    
    return $item_output;
  }
}