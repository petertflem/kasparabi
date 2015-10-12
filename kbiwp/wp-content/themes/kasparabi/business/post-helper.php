<?php

  class PostHelper {

    /**
     * Gets all images attached to a post
     * @return string
     */
    public static function get_post_images_as_html() {
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
      ));

      if ( empty( $attachments ) )
        return '';

      $output = "\n";

      /**
       * Loop through each attachment
       */
      $iterations = 0;
      $nthElement = 0;
      $rowLength = 3;

      foreach ( $attachments as $id  => $attachment ) {
        $nthElement = ++$nthElement == $rowLength ? 0 : $nthElement;
        $open = !( $iterations++ % $rowLength ) ? '<div class="row">' : '';
        $close = !( $iterations % 3 ) && $iterations ? '</div>' : '';

        $title = esc_html( $attachment->post_title, 1 );
        $img = wp_get_attachment_image_src( $id, $size );

        $output .= $open . '<div class="col-sm-4 gallery-image"><a href="' . esc_url( wp_get_attachment_url( $id ) ) . '" title="' . esc_attr( $title ) . '">';
        $output .= '<div class="article-gallery-image" style="background: url(' . esc_url( $img[0] ) . ') no-repeat; background-position: center center; background-size: cover;" title="' . esc_attr( $title ) . '"></div>';
        $output .= '</a></div>' . $close;
      }

      if ($nthElement % $rowLength)
          $output .= '</div>';

      return $output;
    }
  }
