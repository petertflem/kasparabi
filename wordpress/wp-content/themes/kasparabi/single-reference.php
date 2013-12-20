<?php get_header(); ?>

        <div class="container">
            <div class="row">

                <!-- ARTICLE -->
                <?php if (have_posts()) : while(have_posts()) : the_post(); ?>
                    
                    <div class="col-xs-12">
                        <article>
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