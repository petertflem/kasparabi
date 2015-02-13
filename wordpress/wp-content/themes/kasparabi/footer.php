        </div> <!-- end .sticky-footer -->

        <!-- FOOTER -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="copyright">
                            <a href="<?php echo home_url(); ?>">copyright kaspara</a>
                        </div>
                        <div class="social-media">
                            <?php 
                                $options = get_option('kasparabi_settings');
                                $facebook_url = isset($options['facebook_url']) ? esc_attr( $options['facebook_url'] ) : '';
                                $instagram_url = isset($options['instagram_url']) ? esc_attr( $options['instagram_url'] ) : '';
                            ?>
                            <a href="<?php echo $facebook_url; ?>" target="_blank">
                                <div class="facebook social-media-logo">
                                    <img src="<?php bloginfo('template_directory');?>/assets/images/facebook.png" alt="kaspara bryllup & interiør facebook" /> 
                                </div>
                            </a>
                            <a href="<?php echo $instagram_url; ?>" target="_blank">
                                <div class="instagram social-media-logo">
                                    <img src="<?php bloginfo('template_directory');?>/assets/images/instagram.png" alt="kaspara bryllup & interiør instagram" />
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- END FOOTER -->
        
        <?php wp_footer(); ?>
    </body>
</html>