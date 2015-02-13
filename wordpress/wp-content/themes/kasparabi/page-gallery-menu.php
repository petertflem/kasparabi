<?php

/*
 * Template Name: Gallery Menu
 */
?>

<?php
  $gallery_menu_slug = get_post_meta( $post->ID, 'gallery_menu_slug', true ); 
?>

<?php get_header(); ?>

<div class="container gallery-menu">
  <div class="row">
    <div class="col-xs-12">
      <h1><?php _e('Gallery', 'kasparabi'); ?></h1>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <?php
          if (!empty($gallery_menu_slug)) {
            wp_nav_menu(array(
              'menu' => $gallery_menu_slug,
              'walker' => new GalleryMenu,
              'container' => false,
              'items_wrap' => '%3$s'
            ));
          }
      ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>