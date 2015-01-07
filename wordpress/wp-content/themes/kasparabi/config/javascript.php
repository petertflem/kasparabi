<?php

	/*--------------------------------------------------------------------------*
	 * Enqueue JavaScript
	/*--------------------------------------------------------------------------*/
	function kasparabi_enqueue_javascript() {
		wp_register_script('bootstrapjs', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'));
		wp_register_script('magnific-popupjs', get_template_directory_uri() . '/assets/js/magnific-popup.min.js', array('jquery'));
		wp_register_script('inspiration-gallery', get_template_directory_uri() . '/assets/js/initialize-mgnific-popup.js', array('jquery', 'magnific-popupjs'));
		wp_register_script('mainjs', get_template_directory_uri() . '/assets/js/main.js', array('jquery', 'bootstrapjs'));

		wp_enqueue_script('bootstrapjs');
		wp_enqueue_script('magnific-popupjs');
		wp_enqueue_script('inspiration-gallery');
		wp_enqueue_script('mainjs');	
	}
	add_action('wp_enqueue_scripts', 'kasparabi_enqueue_javascript');

?>