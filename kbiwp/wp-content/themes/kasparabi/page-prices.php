<?php
  /*
  Template Name: Prices
  */
?>
<?php get_header(); ?>

<?php 
  $meta_show_menu = get_post_meta( $post->ID, 'left_menu_checkbox', true ); 
  $show_menu = !empty($meta_show_menu);
  $menu_slug = get_post_meta( $post->ID, 'menu_select', true );
?>

<div class="container prices">

  <div class="row">
    <div class="col-xs-12">
      <div class="visible-xs text-center sub-menu-toggle">
        <a data-toggle="collapse" data-target="#sub-menu">Undermeny</a>
      </div>
    </div>
  </div>

  <!-- ARTICLE -->
  <?php if (have_posts()) : while(have_posts()) : the_post(); ?>

  <div class="col-xs-12">
    <article class="article">
      <h1><?php the_title(); ?></h1>
      <?php the_content(); ?>
    </article>
  </div>

  <?php endwhile; else : ?>

  <p><?php _e('No page was found.', 'kasparabi'); ?></p>

  <?php endif; ?>
  <!-- END ARTICLE -->

  </div>
</div>        

<?php get_footer(); ?>