<?php
    /*
        Template Name: Article with gallery
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
                <div class="col-xs-12">
                    <div class="visible-xs text-center sub-menu-toggle">
                        <a data-toggle="collapse" data-target="#sub-menu">Undermeny</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- LEFT MENU -->
                <?php if ($show_menu) : ?>

                    <div class="col-sm-12 sub-menu">
                        <nav class="sub-menu-wrapper">
                            <?php wp_nav_menu(array(
                                'menu' => $menu_slug, 
                                'menu_class' => 'nav nav-pills nav-justified collapse sub-menu',
                                'menu_id' => 'sub-menu')); ?>
                        </nav>
                    </div>

                <?php endif; ?>
                <!-- END LEFT MENU -->
            </div>
           
            <div class="row">
                <!-- ARTICLE -->
                <?php if (have_posts()) : while(have_posts()) : the_post(); ?>
                    
                    <div class="col-xs-8">
                        <article class="article-with-gallery">
                            <h1><?php the_title(); ?></h1>
                            <?php the_content(); ?>
                        </article>
                    </div>
                
                <?php endwhile; else : ?>

                    <p><?php _e('No page was found.', 'kasparabi'); ?></p>
                
                <?php endif; ?>

                <div class="col-sm-4">
                    <div class="maginfic-popup-gallery reference-images">
                        <?php echo kasparabi_get_images(); ?>
                    </div>
                </div>
                <!-- END ARTICLE -->

            </div>
        </div>        

<?php get_footer(); ?>