<?php
 
/*
Plugin Name: [kasparabi] Metaboxes for the contact us page
Plugin URI: 
Description: Provides metaboxes to set the contact information in
Author: Peter Tollnes Flem
Version: 1.0
Author URI:
*/

/*--------------------------------------------------------------------------*
 * Register metabox
/*--------------------------------------------------------------------------*/
function kasparabi_contact_us_information() {

    /* Limit this metabox to contact us pages */
    $post_id = '';

    if (isset($_GET['post'])) {
        $post_id = $_GET['post'];
    } else if (isset($_GET['post_ID'])) {
        $post_id = $_GET['post_ID'];
    } else {
        return;
    }
    
    $template_file = get_post_meta( $post_id, '_wp_page_template', true );

    if ( $template_file == 'page-contact-us.php' ) {
        add_meta_box( 'kasparabi-contact-us-information-meta', __( 'Contact Us Information', 'kasparabi' ), 'kasparabi_render_contact_us_information_meta_box', 'page' );
    }
}
add_action( 'add_meta_boxes', 'kasparabi_contact_us_information' );

/*--------------------------------------------------------------------------*
 * Callbacks
/*--------------------------------------------------------------------------*/
function kasparabi_render_contact_us_information_meta_box($post) {
    wp_nonce_field( basename( __FILE__ ), 'contact-us-information-meta_nonce' );
    
    render_contact_us_information_form($post);    
    //render_inspiration_images_selection_section(__('Wedding Image', 'kasparabi'), 'wedding', $post);
    //render_inspiration_images_selection_section(__('Interior Image', 'kasparabi'), 'interior', $post);
}

function render_contact_us_information_form($post) {
    $nathalie_bergsaune_image = get_post_meta($post->ID, 'nathalie_bergsaune_image', true);
    $heidi_madelen_image = get_post_meta($post->ID, $type . 'heidi_madelen_image', true);

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
                <textarea rows="5" cols="50"></textarea>
            </p>
        </div>
        <div style="float: left; margin-left: 50px;">
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
                <textarea rows="5" cols="50"></textarea>
            </p>
        </div>
        <span style="clear: left; display: block;"></span>
    <?php
}

/*function render_inspiration_images_selection_section($title, $type, $post) {
    $meta_image_url = get_post_meta($post->ID, $type . '_inspiration_image', true);

    ?>
        <p>
            <label for="<?php echo $type; ?>-inspiration-image"><b><?php echo $title; ?></b></label>
            <br />
            <img src="<?php echo $meta_image_url; ?>" alt="<?php echo $type; ?>-inspiration-image" class="inspiration-image-thumbnail" />
            <br />
            <input type="button" class="button meta-image-button" value="<?php _e( 'Choose or upload an Image', 'kasparabi' )?>" />
            <input type="hidden" name="<?php echo $type; ?>-inspiration-image" class="meta-image" value="<?php echo $meta_image_url; ?>" />
        </p>
    <?php
}*/

/*--------------------------------------------------------------------------*
 * Loads the image managment javascript
/*--------------------------------------------------------------------------*/
function kasparabi_contact_us_image_picker_enqueue() {
    global $typenow;
    
    if ( $typenow != 'page' )
        return;

    wp_enqueue_media();

    wp_register_script( 'contact-us-meta-box-image', plugin_dir_url(__FILE__) . '/contact-us-meta-box-image.js', array('jquery') );
    wp_localize_script( 'contact-us-meta-box-image', 'meta_image', 
        array(
            'title' => __('Choose or upload an image', 'kasparabi'),
            'button' => __('Use this image', 'kasparabi')
        )
    );

    wp_enqueue_script('contact-us-meta-box-image');
}
add_action( 'admin_enqueue_scripts', 'kasparabi_contact_us_image_picker_enqueue' );

/*--------------------------------------------------------------------------*
 * Save functions
/*--------------------------------------------------------------------------*/
function kasparibi_contact_us_information_meta_save( $post_id, $post ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'contact-us-information-meta_nonce' ] ) && wp_verify_nonce( $_POST[ 'contact-us-information-meta_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return $post_id;
    }

    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );

    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    /* Save the Nathalie Bergsaune image */
    contact_us_image_save( 'nathalie-bergsaune-image', 'nathalie_bergsaune_image', $post );

    /* Save the Heidi Madelen image */
    inspiration_picker_images_save_value( 'heidi-madelen-image', 'heidi_madelen_image', $post );
}
add_action( 'save_post', 'kasparibi_contact_us_information_meta_save', 1, 2 );

function contact_us_image_save( $name_of_input, $meta_key, $post ) {
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