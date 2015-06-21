<?php
 /*
 Plugin Name: [kasparabi] Template Menu
 Plugin URI: 
 Description: Adds a dropdown to the archive page template where you can select which page template you want to list out
 Version: 1.0
 Author: Peter Tollnes Flem
 Author URI: 
 */

/*--------------------------------------------------------------------------*
 * Register metabox
/*--------------------------------------------------------------------------*/
function kasparabi_template_menu() {

  /* Limit this metabox to article pages */
  $post_id = '';

  if (isset($_GET['post'])) {
    $post_id = $_GET['post'];
  } else if (isset($_GET['post_ID'])) {
    $post_id = $_GET['post_ID'];
  } else {
    return;
  }

  $template_file = get_post_meta( $post_id, '_wp_page_template', true );

  if ($template_file == 'page-archive.php') {
    add_meta_box( 'kasparabi-template-menu', __( 'Template Menu', 'kasparabi' ), 'kasparabi_render_template_menu', 'page', 'side' );
  }
}
add_action( 'add_meta_boxes', 'kasparabi_template_menu' );

/*--------------------------------------------------------------------------*
 * Callbacks
/*--------------------------------------------------------------------------*/
function kasparabi_render_template_menu($post) {
  wp_nonce_field( basename( __FILE__ ), 'kasparabi-template-menu_nonce' );

  ?>
    <p>
      <select name="template-selector">
        <?php foreach ( get_page_templates() as $template_name => $template_filename ) {
           $selected = selected(get_post_meta($post->ID, 'template_selector', true), $template_filename, true);
           echo "<option value=\"$template_filename\" $selected>$template_name ($template_filename)</option>";
        } ?>
      </select>
    </p>
  <?php
}

/*--------------------------------------------------------------------------*
 * Save functions
/*--------------------------------------------------------------------------*/
function kasparibi_template_menu_save( $post_id, $post ) {

  // Checks save status
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST[ 'kasparabi-template-menu_nonce' ] ) && wp_verify_nonce( $_POST[ 'kasparabi-template-menu_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

  // Exits script depending on save status
  if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
    return $post_id;
  }

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Save the dropdown */
  template_menu_save_value( 'template-selector', 'template_selector', $post );
}
add_action( 'save_post', 'kasparibi_template_menu_save', 1, 2 );

function template_menu_save_value( $id_of_input, $meta_key, $post ) {
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

?>