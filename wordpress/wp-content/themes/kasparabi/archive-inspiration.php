<?php get_header(); ?>

        <!-- START INSPIRATION -->
        <div class="container references">
            <div class="row">
                <div class="col-xs-12">
                    <h1><?php _e('Inspiration', 'kasparabi'); ?></h1>
                </div>
            </div>
            <div class="row">
                
                <?php
                    global $wp_query;
                    $iterations = 0;

                    if (have_posts()) : while (have_posts()) : the_post();

                        $open = !( $iterations % 3 ) ? '<div class="row">' : '';
                        $close = !( $iterations % 3 ) && $iterations ? '</div>' : '';
                        echo $close.$open;

                        $iterations++;
                ?>

                    <div class="col-sm-4">
                        <a href="<?php the_permalink(); ?>">
                            <?php 
                                if (has_post_thumbnail())
                                    the_post_thumbnail('post-thumbnail', array( 'class' => 'img-responsive' )) 
                            ?>
                            <h4><?php the_title(); ?></h4>
                        </a>
                    </div>

                <?php endwhile; else : ?>
                    <p><?php _e('No inspirations found', 'kasparabi'); ?></p>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <?php 
                        previous_posts_link(__('&larr; newer', 'kasparabi'));

                        if ($wp_query->max_num_pages > $paged)
                            next_posts_link(__('older &rarr;', 'kasparabi'));
                    ?>
                </div>
            </div>
        </div>
        <!-- END INSPIRATION -->     

<?php get_footer(); ?>