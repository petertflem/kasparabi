<?php get_header('header.php'); ?>

        <!-- IMAGE CAROUSEL -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12 image-carousel">
                    <div class="carousel-wrapper">
                        <?php echo do_shortcode('[image-carousel]'); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- END IMAGE CAROUSEL -->
        
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
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
						          <div class="col-sm-12">
                            <?php 
                                wp_nav_menu(array(
                                    'theme_location' => 'frontpage-news',
                                    'menu_class' => 'frontpage-news'
                                ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END LATEST NEWS -->

<?php get_footer(); ?>