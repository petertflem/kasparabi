<?php

  /*--------------------------------------------------------------------------*
   * Hide editor for specific page templates
  /*--------------------------------------------------------------------------*/
  function hide_editor() {
    $post_id = '';

    if (isset($_GET['post'])) {
        $post_id = $_GET['post'];
    } else if (isset($_GET['post_ID'])) {
        $post_id = $_GET['post_ID'];
    } else {
        return;
    }

    // Get the name of the Page Template file.
    $template_file = get_post_meta($post_id, '_wp_page_template', true);

    if($template_file == 'page-contact-us.php'){ 
      remove_post_type_support('page', 'editor');
      remove_post_type_support('page', 'thumbnail');
    }
    
    if ($template_file == 'page-inspiration-picker.php') {
      remove_post_type_support('page', 'editor');
    }
  }
  add_action( 'admin_init', 'hide_editor' );

?>