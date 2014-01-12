<?php
 
/*
Plugin Name: [kasparabi] Toggle left menu on pages
Plugin URI: 
Description: Provides a metabox to toggle and select the left menu on pages
Author: Peter Tollnes Flem
Version: 1.0
Author URI:
*/

/*--------------------------------------------------------------------------*
 * Register metabox
/*--------------------------------------------------------------------------*/
function kasparabi_page_left_menu() {

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

    if ( $template_file == 'page-article.php' ) {
        add_meta_box( 'kasparabi-left-menu-meta', __( 'Left Menu', 'kasparabi' ), 'kasparabi_render_left_menu_meta_box', 'page', 'side' );
    }
}
add_action( 'add_meta_boxes', 'kasparabi_page_left_menu' );

/*--------------------------------------------------------------------------*
 * Callbacks
/*--------------------------------------------------------------------------*/
function kasparabi_render_left_menu_meta_box($post) {
    wp_nonce_field( basename( __FILE__ ), 'kasparabi-left-menu-meta_nonce' );
    $menus = wp_get_nav_menus(array( 'hide_empty' => true ) );

    ?>
        <p>
            <div>
                <label for="left-menu-checkbox">
                    <input type="checkbox" name="left-menu-checkbox" <?php checked( get_post_meta( $post->ID, 'left_menu_checkbox', true ), 'on', true ) ?> />
                    <?php _e( 'Display left menu', 'kasparabi' )?>
                </label>
            </div>
        </p>
        <p>
		    <label for="menu-select"><?php _e( 'Select menu', 'kasparabi' )?></label>
		    <br />
		    <select name="menu-select">
				<?php foreach ( $menus as $menu ): ?>
				<option value="<?php echo $menu->slug; ?>" <?php selected( get_post_meta( $post->ID, 'menu_select', true ), $menu->slug, true ) ?> ><?php echo $menu->name; ?></option>
				<?php endforeach; ?>
		    </select>
		</p>
    <?php
}

/*--------------------------------------------------------------------------*
 * Save functions
/*--------------------------------------------------------------------------*/
function kasparibi_left_menu_meta_save( $post_id, $post ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'kasparabi-left-menu-meta_nonce' ] ) && wp_verify_nonce( $_POST[ 'kasparabi-left-menu-meta_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return $post_id;
    }

    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );

    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    /* Save the checkbox */
    left_menu_save_value( 'left-menu-checkbox', 'left_menu_checkbox', $post );

    /* Save the dropdown */
    left_menu_save_value( 'menu-select', 'menu_select', $post );
}
add_action( 'save_post', 'kasparibi_left_menu_meta_save', 1, 2 );

function left_menu_save_value( $id_of_input, $meta_key, $post ) {
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