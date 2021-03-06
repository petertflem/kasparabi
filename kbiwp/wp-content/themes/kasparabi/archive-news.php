<?php get_header(); ?>

        <!-- START NEWS -->
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-xs-12 col-md-10">
                    <h1 class="news-page-heading"><?php _e('News', 'kasparabi'); ?></h1>
                </div>
                <div class="col-md-1"></div>
            </div>
                
            <?php
                global $wp_query;

                if (have_posts()) : while (have_posts()) : the_post();
            ?>

                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-xs-12 col-md-10">
                        <div class="row news-row">
                            <a href="<?php the_permalink(); ?>">

                            <?php if (has_post_thumbnail()) : ?>
                                <div class="col-sm-3">
                                    <div class="news-thumbnail">
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
                        <p><?php _e('No news found', 'kasparabi'); ?></p>
                    </div>
                </div><p><?php _e('No references found', 'kasparabi'); ?></p>
            <?php endif; ?>
        </div>
        <!-- END NEWS -->     

<?php get_footer(); ?>