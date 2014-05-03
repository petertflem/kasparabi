<?php get_header(); ?>
    <!-- START INSPIRATION -->
    <div class="container references">
        <div class="row">
            <div class="col-xs-12">
                <h1><?php _e('Inspiration', 'kasparabi'); ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="maginfic-popup-gallery"> 
                
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

                        <?php 
                            $thumb_id = get_post_thumbnail_id();
                            $thumb_url = wp_get_attachment_image_src($thumb_id, 'full');
                        ?>

                        <a href="<?php echo $thumb_url[0]; ?>" title="<?php echo the_title(); ?>">
                            <?php 
                                if (has_post_thumbnail())
                                    the_post_thumbnail('post-thumbnail', array( 'class' => 'img-responsive' ))
                            ?>
                            <h4><?php the_title(); ?></h4>
                        </a>
                        
                    </div>

                    <?php 
                        $close = !( $iterations % $rowLength ) && $iterations ? '</div>' : '';
                        echo $close; 
                    ?>

                <?php endwhile; 
                    if ($nthElement % $rowLength) {
                        echo '</div>';
                    } 
                ?>

                <?php else : ?>
                    <p><?php _e('No inspirations found', 'kasparabi'); ?></p>
                <?php endif; ?>
            </div>
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