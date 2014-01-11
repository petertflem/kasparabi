<?php
 
/*
Plugin Name: [kasparabi] Set inspiration picker images
Plugin URI: 
Description: Provides a metabox to set the images in the inspiration picker
Author: Peter Tollnes Flem
Version: 1.0
Author URI:
*/

/*--------------------------------------------------------------------------*
 * Register metabox
/*--------------------------------------------------------------------------*/
function kasparabi_inspiration_picker_images() {

    /* Limit this metabox to article pages */
    $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
    $template_file = get_post_meta( $post_id, '_wp_page_template', true );

    if ( $template_file == 'page-inspiration-picker.php' ) {
        add_meta_box( 'kasparabi-inspiration-picker-images-meta', __( 'Inspiration Picker Images', 'kasparabi' ), 'kasparabi_render_inspiration_picker_images_meta_box', 'page' );
    }
}
add_action( 'add_meta_boxes', 'kasparabi_inspiration_picker_images' );

/*--------------------------------------------------------------------------*
 * Callbacks
/*--------------------------------------------------------------------------*/
function kasparabi_render_inspiration_picker_images_meta_box($post) {
    wp_nonce_field( basename( __FILE__ ), 'inspiration-picker-images-meta_nonce' );
    
    render_inspiration_images_selection_section(__('Wedding Image', 'kasparabi'), 'wedding', $post);
    render_inspiration_images_selection_section(__('Interior Image', 'kasparabi'), 'interior', $post);
}

function render_inspiration_images_selection_section($title, $type, $post) {
    $meta_image_url = get_post_meta($post->ID, $type . '_inspiration_image', true);

    ?>
        <p>
            <label for="<?php echo $type; ?>-inspiration-image" class="prfx-row-title"><b><?php echo $title; ?></b></label>
            <br />
            <img src="<?php echo $meta_image_url; ?>" alt="<?php echo $type; ?>-inspiration-image" class="inspiration-image-thumbnail" />
            <br />
            <input type="button" class="button meta-image-button" value="<?php _e( 'Choose or upload an Image', 'kasparabi' )?>" />
            <input type="hidden" name="<?php echo $type; ?>-inspiration-image" class="meta-image" value="<?php echo $meta_image_url; ?>" />
        </p>
    <?php
}

/*--------------------------------------------------------------------------*
 * Loads the image managment javascript
/*--------------------------------------------------------------------------*/
function kasparabi_inspiration_image_picker_enqueue() {
    global $typenow;
    
    if ( $typenow != 'page' )
        return;

    wp_enqueue_media();

    wp_register_script( 'meta-box-image', plugin_dir_url(__FILE__) . '/meta-box-image.js', array('jquery') );
    wp_localize_script( 'meta-box-image', 'meta_image', 
        array(
            'title' => __('Choose or upload an image', 'kasparabi'),
            'button' => __('Use this image', 'kasparabi')
        )
    );

    wp_enqueue_script('meta-box-image');
}
add_action( 'admin_enqueue_scripts', 'kasparabi_inspiration_image_picker_enqueue' );

/*--------------------------------------------------------------------------*
 * Save functions
/*--------------------------------------------------------------------------*/
function kasparibi_inspiration_picker_images_meta_save( $post_id, $post ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'inspiration-picker-images-meta_nonce' ] ) && wp_verify_nonce( $_POST[ 'inspiration-picker-images-meta_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return $post_id;
    }

    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );

    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    /* Save wedding image */
    inspiration_picker_images_save_value( 'wedding-inspiration-image', 'wedding_inspiration_image', $post );

    /* Save interior image */
    inspiration_picker_images_save_value( 'interior-inspiration-image', 'interior_inspiration_image', $post );
}
add_action( 'save_post', 'kasparibi_inspiration_picker_images_meta_save', 1, 2 );

function inspiration_picker_images_save_value( $name_of_input, $meta_key, $post ) {
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