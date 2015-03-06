<?php
 
/*
Plugin Name: [kasparabi] Metaboxes for the about us page
Plugin URI: 
Description: Provides metaboxes to set the about us information in
Author: Peter Tollnes Flem
Version: 1.0
Author URI:
*/

/*--------------------------------------------------------------------------*
 * Register metabox
/*--------------------------------------------------------------------------*/
function kasparabi_about_us_information() {

    /* Limit this metabox to about us pages */
    $post_id = '';

    if (isset($_GET['post'])) {
        $post_id = $_GET['post'];
    } else if (isset($_GET['post_ID'])) {
        $post_id = $_GET['post_ID'];
    } else {
        return;
    }
    
    $template_file = get_post_meta( $post_id, '_wp_page_template', true );

    if ( $template_file == 'page-about-us.php' ) {
        add_meta_box( 'kasparabi-about-us-information-meta', __( 'About Us Information', 'kasparabi' ), 'kasparabi_render_about_us_information_meta_box', 'page' );
    }
}
add_action( 'add_meta_boxes', 'kasparabi_about_us_information' );

/*--------------------------------------------------------------------------*
 * Callbacks
/*--------------------------------------------------------------------------*/
function kasparabi_render_about_us_information_meta_box($post) {
    wp_nonce_field( basename( __FILE__ ), 'about-us-information-meta_nonce' );
    
    render_about_us_information_form($post);    
}

function render_about_us_information_form($post) {
    $nathalie_bergsaune_image = get_post_meta($post->ID, 'nathalie_bergsaune_image', true);
    $nathalie_bergsaune_description = get_post_meta($post->ID, 'nathalie_bergsaune_description', true);

    $heidi_madelen_image = get_post_meta($post->ID, $type . 'heidi_madelen_image', true);
    $heidi_madelen_description = get_post_meta($post->ID, $type . 'heidi_madelen_description', true);

    ?>
        <div style="float: left;">
            <h4>Nathalie Bergsaune</h4>
            <p>
                <label for="nathalie-bergsaune-image"><b><?php _e('Bilde:', 'kasparabi'); ?></b></label>
                <br />
                <img src="<?php echo $nathalie_bergsaune_image; ?>" alt="nathalie bergsaune image" class="contact-us-image-thumbnail" />
                <br />
                <input type="button" class="button contact-us-meta-image-button" value="<?php _e( 'Choose or upload an Image', 'kasparabi' )?>" />
                <input type="hidden" name="nathalie-bergsaune-image" class="contact-us-image" value="<?php echo $nathalie_bergsaune_image; ?>" />
            </p>
            <p>
                <b>Litt informasjon:</b> <br />
                <textarea rows="5" cols="50" name="nathalie-bergsaune-description"><?php echo $nathalie_bergsaune_description; ?></textarea>
            </p>
        </div>
        <div style="float: left;">
            <h4>Heidi Madelen</h4>
            <p>
                <label for="heidi-madelen-image"><b><?php _e('Bilde:', 'kasparabi'); ?></b></label>
                <br />
                <img src="<?php echo $heidi_madelen_image; ?>" alt="heidi madelen image" class="contact-us-image-thumbnail" />
                <br />
                <input type="button" class="button contact-us-meta-image-button" value="<?php _e( 'Choose or upload an Image', 'kasparabi' )?>" />
                <input type="hidden" name="heidi-madelen-image" class="contact-us-image" value="<?php echo $heidi_madelen_image; ?>" />
            </p>
            <p>
                <b>Litt informasjon:</b> <br />
                <textarea rows="5" cols="50" name="heidi-madelen-description"><?php echo $heidi_madelen_description; ?></textarea>
            </p>
        </div>
        <span style="clear: left; display: block;"></span>
    <?php
}

/*--------------------------------------------------------------------------*
 * Loads the image managment javascript
/*--------------------------------------------------------------------------*/
function kasparabi_about_us_image_picker_enqueue() {
    global $typenow;
    
    if ( $typenow != 'page' )
        return;

    wp_enqueue_media();

    wp_register_script( 'about-us-meta-box-image', plugin_dir_url(__FILE__) . '/about-us-meta-box-image.js', array('jquery') );
    wp_localize_script( 'about-us-meta-box-image', 'meta_image', 
        array(
            'title' => __('Choose or upload an image', 'kasparabi'),
            'button' => __('Use this image', 'kasparabi')
        )
    );

    wp_enqueue_script('about-us-meta-box-image');
}
add_action( 'admin_enqueue_scripts', 'kasparabi_about_us_image_picker_enqueue' );

/*--------------------------------------------------------------------------*
 * Save functions
/*--------------------------------------------------------------------------*/
function kasparibi_about_us_information_meta_save( $post_id, $post ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'about-us-information-meta_nonce' ] ) && wp_verify_nonce( $_POST[ 'about-us-information-meta_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return $post_id;
    }

    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );

    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    /* Save Nathalie Bergsaune */
    about_us_save_value( 'nathalie-bergsaune-image', 'nathalie_bergsaune_image', $post );
    about_us_save_value( 'nathalie-bergsaune-description', 'nathalie_bergsaune_description', $post );

    /* Save Heidi Madelen */
    about_us_save_value( 'heidi-madelen-image', 'heidi_madelen_image', $post );
    about_us_save_value( 'heidi-madelen-description', 'heidi_madelen_description', $post );
}
add_action( 'save_post', 'kasparibi_about_us_information_meta_save', 1, 2 );

function about_us_save_value( $name_of_input, $meta_key, $post ) {
 	$new_meta_value = ( isset( $_POST[$name_of_input] ) ? sanitize_text_field( $_POST[$name_of_input] ) : '' );
  $meta_value = get_post_meta( $post->ID, $meta_key, true);

  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_meta_value && '' == $meta_value )
      add_post_meta( $post->ID, $meta_key, $new_meta_value, true);

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_meta_value && $new_meta_value != $meta_value )
      update_post_meta( $post->ID, $meta_key, $new_meta_value );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( '' == $new_meta_value && $meta_value )
      delete_post_meta( $post->ID, $meta_key, $meta_value );
}