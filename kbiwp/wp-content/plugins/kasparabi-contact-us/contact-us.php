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
}

function render_contact_us_information_form($post) {
    $nathalie_bergsaune_name = get_post_meta($post->ID, 'nathalie_bergsaune_name', true);
    $nathalie_bergsaune_phonenumber = get_post_meta($post->ID, 'nathalie_bergsaune_phonenumber', true);
    $nathalie_bergsaune_email = get_post_meta($post->ID, 'nathalie_bergsaune_email', true);    
    
    $heidi_madelen_name = get_post_meta($post->ID, $type . 'heidi_madelen_name', true);
    $heidi_madelen_phonenumber = get_post_meta($post->ID, $type . 'heidi_madelen_phonenumber', true);
    $heidi_madelen_email = get_post_meta($post->ID, $type . 'heidi_madelen_email', true);

    $street_name = get_post_meta($post->ID, 'street_name', true);
    $zip_code = get_post_meta($post->ID, 'zip_code', true);
    $area = get_post_meta($post->ID, 'area', true);
    $kasparabi_email = get_post_meta($post->ID, 'kasparabi_email', true);
    
    ?>
        <div>
            <h4>Nathalie Bergsaune</h4>
            <p>
                <p class='description'><?php _e('Your name', 'kasparabi'); ?></p>
                <input type="text" name="nathalie-bergsaune-name" class="regular-text" value="<?php echo $nathalie_bergsaune_name; ?>" />
            </p>
            <p>
                <p class='description'><?php _e('Phone number', 'kasparabi'); ?></p>
                <input type="text" name="nathalie-bergsaune-phone-number" class="regular-text" value="<?php echo $nathalie_bergsaune_phonenumber; ?>" />
            </p>
            <p>
                <p class='description'><?php _e('Email', 'kasparabi'); ?></p>
                <input type="text" name="nathalie-bergsaune-email" class="regular-text" value="<?php echo $nathalie_bergsaune_email; ?>" />
            </p>
        </div>
        <div>
            <h4>Heidi Madelen</h4>
            <p>
                <p class='description'><?php _e('Your name', 'kasparabi'); ?></p>
                <input type="text" name="heidi-madelen-name" class="regular-text" value="<?php echo $heidi_madelen_name; ?>" />
            </p>
            <p>
                <p class='description'><?php _e('Phone number', 'kasparabi'); ?></p>
                <input type="text" name="heidi-madelen-phone-number" class="regular-text" value="<?php echo $heidi_madelen_phonenumber; ?>" />
            </p>
            <p>
                <p class='description'><?php _e('Email', 'kasparabi'); ?></p>
                <input type="text" name="heidi-madelen-email" class="regular-text" value="<?php echo $heidi_madelen_email; ?>" />
            </p>
        </div>
        <div>
            <h4>Kaspara Bryllup & Interiør</h4>
            <p>
                <p class='description'><?php _e('Street name', 'kasparabi'); ?></p>
                <input type="text" name="street-name" class="regular-text" value="<?php echo $street_name; ?>" />
            </p>
            <p>
                <p class='description'><?php _e('Zip code', 'kasparabi'); ?></p>
                <input type="text" name="zip-code" class="regular-text" value="<?php echo $zip_code; ?>" />
            </p>
            <p>
                <p class='description'><?php _e('Area', 'kasparabi'); ?></p>
                <input type="text" name="area" class="regular-text" value="<?php echo $area; ?>" />
            </p>
            <p>
                <p class='description'><?php _e('Email', 'kasparabi'); ?></p>
                <input type="text" name="kasparabi-email" class="regular-text" value="<?php echo $kasparabi_email; ?>" />
            </p>
        </div>
    <?php
}

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

    /* Save Nathalie Bergsaune */
    contact_us_save_value( 'nathalie-bergsaune-name', 'nathalie_bergsaune_name', $post );
    contact_us_save_value( 'nathalie-bergsaune-phone-number', 'nathalie_bergsaune_phonenumber', $post );
    contact_us_save_value( 'nathalie-bergsaune-email', 'nathalie_bergsaune_email', $post );

    /* Save Heidi Madelen */
    contact_us_save_value( 'heidi-madelen-name', 'heidi_madelen_name', $post );
    contact_us_save_value( 'heidi-madelen-phone-number', 'heidi_madelen_phonenumber', $post );
    contact_us_save_value( 'heidi-madelen-email', 'heidi_madelen_email', $post );

    /* Kasparabi Information */
    contact_us_save_value( 'street-name', 'street_name', $post );
    contact_us_save_value( 'zip-code', 'zip_code', $post );
    contact_us_save_value( 'area', 'area', $post );
    contact_us_save_value( 'kasparabi-email', 'kasparabi_email', $post );
}
add_action( 'save_post', 'kasparibi_contact_us_information_meta_save', 1, 2 );

function contact_us_save_value( $name_of_input, $meta_key, $post ) {
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