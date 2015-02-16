<?php
 
/*
Plugin Name: [kasparabi] Article sub title menu meta box
Plugin URI: 
Description: Provides a metabox to set the sub title menu slug in
Author: Peter Tollnes Flem
Version: 1.0
Author URI:
*/

/*--------------------------------------------------------------------------*
 * Register metabox
/*--------------------------------------------------------------------------*/
function kasparabi_sub_title_menu_information() {

    /* Limit this metabox to contact us pages */
    $post_id = '';

    if (isset($_GET['post'])) {
        $post_id = $_GET['post'];
    } else if (isset($_GET['post_ID'])) {
        $post_id = $_GET['post_ID'];
    } else {
        return;
    }
    
    $template_file = basename(get_post_meta( $post_id, '_wp_page_template', true ));

    if ( $template_file == 'page-article.php' || $template_file == 'page-article-with-gallery.php' ) {
        add_meta_box( 'kasparabi-sub-title-menu-meta', __( 'Sub title menu', 'kasparabi' ), 'kasparabi_render_sub_title_menu_meta_box', 'page' );
    }
}
add_action( 'add_meta_boxes', 'kasparabi_sub_title_menu_information' );

/*--------------------------------------------------------------------------*
 * Callbacks
/*--------------------------------------------------------------------------*/
function kasparabi_render_sub_title_menu_meta_box($post) {
    wp_nonce_field( basename( __FILE__ ), 'gallery-sub-title-menu-meta_nonce' );
    
    render_sub_title_menu_form($post);    
}

function render_sub_title_menu_form($post) {
    $sub_title_menu_slug = get_post_meta($post->ID, 'sub_title_menu_slug', true);
    
    ?>
        <div>
            <h4>Sub Title Menu Slug</h4>
            <p>
                <p class='description'><?php _e('Sub Title Menu Slug', 'kasparabi'); ?></p>
                <input type="text" name="sub-title-menu-slug" class="regular-text" value="<?php echo $sub_title_menu_slug; ?>" />
            </p>
        </div>
    <?php
}

/*--------------------------------------------------------------------------*
 * Save functions
/*--------------------------------------------------------------------------*/
function kasparibi_sub_title_menu_meta_save( $post_id, $post ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'gallery-sub-title-menu-meta_nonce' ] ) && wp_verify_nonce( $_POST[ 'gallery-sub-title-menu-meta_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return $post_id;
    }

    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );

    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    /* Save the slug */
    sub_title_menu_save_value( 'sub-title-menu-slug', 'sub_title_menu_slug', $post );
}
add_action( 'save_post', 'kasparibi_sub_title_menu_meta_save', 1, 2 );

function sub_title_menu_save_value( $name_of_input, $meta_key, $post ) {
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