<?php get_header(); ?>

        <div class="container single-reference">
            <div class="row">
                
                <!-- ARTICLE -->
                <?php if (have_posts()) : while(have_posts()) : the_post(); ?>
                    
                    <div class="col-sm-8">
                        <article>
                            <h1><?php the_title(); ?></h1>
                            <?php the_content(); ?>
                        </article>
                    </div>
                    <div class="col-sm-4">
                        <div class="maginfic-popup-gallery reference-images">
                            <?php echo kasparabi_get_images(); ?>
                        </div>
                    </div>
                
                <?php endwhile; else : ?>

                    <p><?php _e('No page was found.', 'kasparabi'); ?></p>
                
                <?php endif; ?>
                <!-- END ARTICLE -->

            </div>
        </div>        

<?php get_footer(); ?>