<?php
 
/*
Plugin Name: [kasparabi] Set inspiration picker links
Plugin URI: 
Description: Provides a metabox to set the links on the inspiration picker pages
Author: Peter Tollnes Flem
Version: 1.0
Author URI:
*/

/*--------------------------------------------------------------------------*
 * Register metabox
/*--------------------------------------------------------------------------*/
function kasparabi_inspiration_picker_links() {

    /* Limit this metabox to article pages */
    $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
    $template_file = get_post_meta( $post_id, '_wp_page_template', true );

    if ( $template_file == 'page-inspiration-picker.php' ) {
        add_meta_box( 'kasparabi-inspiration-picker-links-meta', __( 'Inspiration Menu Links', 'kasparabi' ), 'kasparabi_render_inspiration_picker_links_meta_box', 'page' );
    }
}
add_action( 'add_meta_boxes', 'kasparabi_inspiration_picker_links' );

/*--------------------------------------------------------------------------*
 * Callbacks
/*--------------------------------------------------------------------------*/
function kasparabi_render_inspiration_picker_links_meta_box($post) {
    wp_nonce_field( basename( __FILE__ ), 'inspiration-picker-links-meta_nonce' );
    
    render_inspiration_picker_section(__('Wedding Link', 'kasparabi'), 'wedding', $post);
    render_inspiration_picker_section(__('Interior Link', 'kasparabi'), 'interior', $post);
}

function render_inspiration_picker_section($title, $type, $post) {
    ?>
        <p>
            <label for="menu-select">
                <strong><?php echo $title; ?></strong>
            </label>

            <br />
            
            <?php _e('Link to archive', 'kasparabi'); ?> 
            <input type="text" name="<?php echo $type; ?>-archive-link" class="regular-text code" value="<?php echo esc_attr( get_post_meta( $post->ID, $type . '_archive_link', true ) ); ?>" />
            
            <br />
            
            <?php _e('Archive type', 'kasparabi'); ?> 
            <?php wp_dropdown_categories(array(
                'taxonomy' => 'inspiration-taxonomy', 
                'name' => 'cat-' . $type,
                'selected' => get_post_meta( $post->ID, 'cat_' . $type, true )
            )); 
            
            ?>
        </p>
    <?php
}

/*--------------------------------------------------------------------------*
 * Save functions
/*--------------------------------------------------------------------------*/
function kasparibi_inspiration_picker_links_meta_save( $post_id, $post ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'inspiration-picker-links-meta_nonce' ] ) && wp_verify_nonce( $_POST[ 'inspiration-picker-links-meta_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return $post_id;
    }

    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );

    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    /* Save wedding link */
    inspiration_picker_links_save_value( 'wedding-archive-link', 'wedding_archive_link', $post );
    inspiration_picker_links_save_value( 'cat-wedding', 'cat_wedding', $post );

    /* Save interior link */
    inspiration_picker_links_save_value( 'interior-archive-link', 'interior_archive_link', $post );
    inspiration_picker_links_save_value( 'cat-interior', 'cat_interior', $post );
}
add_action( 'save_post', 'kasparibi_inspiration_picker_links_meta_save', 1, 2 );

function inspiration_picker_links_save_value( $id_of_input, $meta_key, $post ) {
 	$new_meta_value = ( isset( $_POST[$id_of_input] ) ? sanitize_text_field( $_POST[$id_of_input] ) : '' );
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