<?php get_header(); ?>

        <div class="container">
            <div class="row">

                <?php if (have_posts()) : while(have_posts()) : the_post(); ?>

                    <div class="col-md-2"></div>
                    <div class="col-sm-12 col-md-8">
                        <article class="article">
                            <h1><?php the_title(); ?></h1>
                            <?php the_content(); ?>
                        </article>
                    </div>
                    <div class="col-md-2"></div>

                <?php endwhile; else : ?>

                    <p><?php _e('No page was found.', 'kasparabi'); ?></p>

                <?php endif; ?>

            </div>
        </div>

<?php get_footer(); ?>
