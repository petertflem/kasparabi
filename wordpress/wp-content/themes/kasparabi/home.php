<?php get_header(); ?>

        <!-- IMAGE CAROUSEL -->
        <div class="container">
            <div class="row">
                <div class="col-sm-9 image-carousel">
                    <?php echo do_shortcode('[image-carousel]'); ?>
                </div>
                <div class="col-sm-3">
                    <div class="aside-info-text">
                        <?php 
                            $options = get_option('kasparabi_settings');
                            $heading = isset($options['kasparabi_frontpage_header']) ? esc_attr( $options['kasparabi_frontpage_header'] ) : '';
                            $body = isset($options['kasparabi_frontpage_text']) ? esc_attr( $options['kasparabi_frontpage_text'] ) : '';
                        ?>

                        <h1><?php echo $heading; ?></h1>
                        <p><?php echo $body; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- END IMAGE CAROUSEL -->
        
        <!-- LATEST NEWS -->
        <div class="container latest-news">
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12">
                            <h1><?php _e('Last news', 'kasparabi'); ?></h1>
                        </div>
                    </div>
                    <div class="row">
						
						<?php  

                        $args = array(
                            'posts_per_page' => 3,
                            'post_type' => 'any'
                        );
                        $query = new WP_Query($args);
                        if ($query->have_posts()) : while($query->have_posts()) : $query->the_post(); 

                        ?>
						
							<div class="col-sm-4">
	                            <article>
                                    <a href="<?php the_permalink(); ?>">
    	                                <?php 
                                            if (has_post_thumbnail()) {
                                                the_post_thumbnail('post-thumbnail', array(
                                                        'class' => 'img-responsive'
                                                    )); 
                                            }
                                        ?>
    	                                <h1><?php the_title(); ?></h1>
    	                                <!--<p><?php the_time(get_option('time_format')); ?> <?php _e('at', 'kasparabi'); ?> <?php the_date(get_option('date_format')); ?>, <?php _e('by', 'kasparabi'); ?> <?php the_author_posts_link(); ?>
    									<?php the_excerpt(); ?>-->
                                    </a>
	                            </article>
	                        </div>

						<?php endwhile; else : ?>
							<p><?php _e('No news found', 'kasparabi'); ?></p>
						<?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- END LATEST NEWS -->

<?php get_footer(); ?>