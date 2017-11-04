<?php get_header(); ?>

        <!-- START REFERENCES -->
        <div class="container references">
            <div class="row">
                <div class="col-xs-12">
                    <h1><?php _e('References', 'kasparabi'); ?></h1>
                </div>
            </div>
            <div class="row">
                
                <?php
                    global $wp_query;
                    $iterations = 0;
                    $nthElement = 0;
                    $rowLength = 3;

                    if (have_posts()) : while (have_posts()) : the_post();
                        $nthElement = ++$nthElement == $rowLength ? 0 : $nthElement;
                        $open = !( $iterations % $rowLength ) ? '<div class="row">' : '';
                        echo $open;

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

                    <?php 
                        $close = !( $iterations % 3 ) && $iterations ? '</div>' : '';
                        echo $close; 
                    ?>

                <?php endwhile; 
                    if ($nthElement % $rowLength) {
                        echo '</div>';
                    } 
                ?>

                <?php else : ?>
                    <p><?php _e('No references found', 'kasparabi'); ?></p>
                <?php endif; ?>

            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="archive-navigation">
                        <div class="newer-link">
                        <?php 
                            previous_posts_link(__('&larr; newer', 'kasparabi'));
                        ?>
                        </div>
                        <div class="older-link">
                        <?php
                            if ($wp_query->max_num_pages > $paged)
                                next_posts_link(__('older &rarr;', 'kasparabi'));
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END REFERENCES -->     

<?php get_footer(); ?>
