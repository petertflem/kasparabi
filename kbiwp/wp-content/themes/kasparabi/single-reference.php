<?php get_header(); ?>

        <div class="container single-reference">
            <div class="row">

                <!-- ARTICLE -->
                <?php if (have_posts()) : while(have_posts()) : the_post(); ?>

                    <div class="col-md-2"></div>
                    <div class="col-sm-12 col-md-10">
                        <article class="article-with-gallery">
                            <h1><?php the_title(); ?></h1>
                            <?php the_content(); ?>
                        </article>
                    </div>

                <?php endwhile; else : ?>

                    <p><?php _e('No page was found.', 'kasparabi'); ?></p>

                <?php endif; ?>
                <!-- END ARTICLE -->

            </div>
            <div class="row">
              <div class="col-md-2"></div>
              <div class="col-sm-12 col-md-10">
                  <div class="maginfic-popup-gallery reference-images">
                      <?php echo PostHelper::get_post_images_as_html(); ?>
                  </div>
              </div>
            </div>
        </div>

<?php get_footer(); ?>
