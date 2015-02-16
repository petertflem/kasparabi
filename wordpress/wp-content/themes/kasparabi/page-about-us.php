<?php
    /*
        Template Name: About Us
    */
?>
<?php
    /* Get conact information and their pictures */
    $meta = get_post_meta($post->ID);

    $nb_image = isset($meta['nathalie_bergsaune_image']) ? esc_attr( $meta['nathalie_bergsaune_image'][0] ) : '';
    $nb_description = isset($meta['nathalie_bergsaune_description']) ? esc_attr( $meta['nathalie_bergsaune_description'][0] ) : '';
  
    $hm_image = isset($meta['heidi_madelen_image']) ? esc_attr( $meta['heidi_madelen_image'][0] ) : '';
    $hm_description = isset($meta['heidi_madelen_description']) ? esc_attr( $meta['heidi_madelen_description'][0] ) : '';
?>
<?php get_header(); ?>

<?php if (have_posts()) : while(have_posts()) : the_post(); ?>

<div class="container about-us">
  <div class="row">
    <h1><?php the_title(); ?></h1>
  </div>
  <div class="row about-person-row">
    <div class="col-sm-3">
      <img src="<?php echo $nb_image; ?>" alt="Bildet av Nathalie Bergsaune" class="img-responsive" />
    </div>
    <div class="col-sm-9 about-person-text">
      <?php echo $nb_description; ?>
    </div>
  </div>
  <div class="row about-person-row">
    <div class="col-sm-3">
      <img src="<?php echo $hm_image; ?>" alt="Bildet av Heidi Madelen" class="img-responsive" />
    </div>
    <div class="col-sm-9 about-person-text">
      <?php echo $hm_description; ?>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <!--<article class="article">-->
      <article> 
        <?php the_content(); ?>
      </article>
    </div>
  </div>
</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>