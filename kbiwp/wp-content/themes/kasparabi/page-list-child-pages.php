<?php
/*
Template Name: List Out Child Pages
*/
?>

<?php get_header(); ?>

<!-- START NEWS -->
<div class="container">
  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-xs-12 col-md-10">
      <h1 class="list-child-pages-page-heading"><?php _e('Inspiring Homes', 'kasparabi'); ?></h1>
    </div>
    <div class="col-md-1"></div>
  </div>

  <?php

    $subpages = new WP_Query( array(
  		'post_type' => 'page',
  		'post_parent' => $post->ID,
  		'posts_per_page' => -1,
  		'orderby' => 'menu_order'
  	));

    if ($subpages->have_posts()) : while ($subpages->have_posts()) : $subpages->the_post();

  ?>


  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-xs-12 col-md-10">
      <div class="row list-child-pages-row">
        <a href="<?php the_permalink(); ?>">

          <?php if (has_post_thumbnail()) : ?>
            <div class="col-sm-3">
              <div class="child-pages-thumbnail">
                <?php the_post_thumbnail('post-thumbnail', array( 'class' => 'img-responsive' )); ?>
              </div>
            </div>
          <?php endif; ?>

          <div class="col<?php echo has_post_thumbnail() ? '-sm-9' : '-xs-12'; ?>">
            <h1><?php the_title(); ?></h1>
            <p><?php the_excerpt(); ?></p>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-1"></div>
  </div>

<?php endwhile; else : ?>
  <div class="row">
    <div class="col-xs-12">
      <p><?php _e('No inspiring homes pages found', 'kasparabi'); ?></p>
    </div>
  </div>
<?php endif; ?>
</div>
<!-- END NEWS -->

<?php get_footer(); ?>
