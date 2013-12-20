<?php get_header(); ?>

        <!-- START NEWS -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1><?php _e('News', 'kasparabi'); ?></h1>
                </div>
            </div>
                
            <?php
                global $wp_query;
                $iterations = 0;

                if (have_posts()) : while (have_posts()) : the_post();

                    $open = !( $iterations % 3 ) ? '<div class="row">' : '';
                    $close = !( $iterations % 3 ) && $iterations ? '</div>' : '';
                    echo $close.$open;

                    $iterations++;
            ?>

                <div class="row">
					<div class="col-xs-12">
						<div class="row">

                        <?php if (has_post_thumbnail()) : ?>
							<div class="col-sm-3">
								<?php the_post_thumbnail('post-thumbnail', array( 'class' => 'img-responsive' )); ?>
							</div>
                        <?php endif; ?>

							<div class="col<?php echo has_post_thumbnail() ? '-sm-9' : '-xs-12'; ?>">
								<h2><?php the_title(); ?></h2>
								<p><?php the_excerpt(); ?></p>
							</div>
						</div>
					</div>
				</div>

            <?php endwhile; else : ?>
                <div class="row">
					<div class="col-xs-12">
						<p><?php _e('No news found', 'kasparabi'); ?></p>
					</div>
				</div><p><?php _e('No references found', 'kasparabi'); ?></p>
            <?php endif; ?>

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
        <!-- END NEWS -->     

<?php get_footer(); ?>