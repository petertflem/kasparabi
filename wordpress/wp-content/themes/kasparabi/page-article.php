<?php
    /*
        Template Name: Article
    */
?>
<?php get_header(); ?>
        
        <?php 
            $meta_show_menu = get_post_meta( $post->ID, 'left_menu_checkbox', true ); 
            $show_menu = !empty($meta_show_menu);
            $menu_slug = get_post_meta( $post->ID, 'menu_select', true );

            if (!empty($menu_slug)) :
                $menu_title = wp_get_nav_menu_object($menu_slug);
            endif;
        ?>

        <div class="container">
            <div class="row">
                
                <!-- LEFT MENU -->
                <?php if ($show_menu) : ?>
                    
                    <div class="col-sm-2 left-menu">
                        <nav>
                            <h4><?php echo $menu_title->name ?></h4>
                            <?php wp_nav_menu( array( 'menu' => $menu_slug ) ); ?>
                        </nav>
                    </div>

                <?php endif; ?>
                <!-- END LEFT MENU -->
                
                <!-- ARTICLE -->
                <?php if (have_posts()) : while(have_posts()) : the_post(); ?>
                    
                    <div class="col-<?php echo !$show_menu ? 'xs-12' : 'sm-10'; ?>">
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