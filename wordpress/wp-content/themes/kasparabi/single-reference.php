<?php get_header(); ?>

        <div class="container single-reference">
            <div class="row">
                
                <?php 
                    /**
                     * Gets all images attached to a post
                     * @return string
                     */
                    function wpse_get_images() {
                        global $post;
                        $id = intval( $post->ID );
                        $size = 'medium';
                        $attachments = get_children( array(
                                'post_parent' => $id,
                                'post_status' => 'inherit',
                                'post_type' => 'attachment',
                                'post_mime_type' => 'image',
                                'order' => 'ASC',
                                'orderby' => 'menu_order'
                            ) );
                        if ( empty( $attachments ) )
                                    return '';

                        $output = "\n";
                        
                        /**
                         * Loop through each attachment
                         */
                        $iterations = 0;
                        $nthElement = 0;
                        $rowLength = 3;
                        foreach ( $attachments as $id  => $attachment ) :
                            $nthElement = $nthElement == $rowLength ? 0 : ++$nthElement;
                            $open = !( $iterations++ % $rowLength ) ? '<div class="row">' : '';
                            $close = !( $iterations % 3 ) && $iterations ? '</div>' : '';

                            $title = esc_html( $attachment->post_title, 1 );
                            $img = wp_get_attachment_image_src( $id, $size );

                            $output .= $open . '<div class="col-xs-4"><a href="' . esc_url( wp_get_attachment_url( $id ) ) . '" title="' . esc_attr( $title ) . '">';
                            $output .= '<img class="img-responsive" src="' . esc_url( $img[0] ) . '" alt="' . esc_attr( $title ) . '" title="' . esc_attr( $title ) . '" />';
                            $output .= '</a></div>' . $close;

                        endforeach;

                        return $output;
                    }
                ?>
            
                <!-- ARTICLE -->
                <?php if (have_posts()) : while(have_posts()) : the_post(); ?>
                    
                    <div class="col-sm-7">
                        <article>
                            <h1><?php the_title(); ?></h1>
                            <?php the_content(); ?>
                        </article>
                    </div>
                    <div class="col-sm-5">
                        <div class="maginfic-popup-gallery reference-images">
                            <?php echo wpse_get_images(); ?>
                        </div>
                    </div>
                
                <?php endwhile; else : ?>

                    <p><?php _e('No page was found.', 'kasparabi'); ?></p>
                
                <?php endif; ?>
                <!-- END ARTICLE -->

            </div>
        </div>        

<?php get_footer(); ?>