<?php
   /*
   Plugin Name: [kasparabi] Settings (custom settings page)
   Plugin URI: 
   Description: This is the custom settings for Kaspara bryllup & interiør
   Version: 1.0
   Author: Peter Tollnes Flem
   Author URI: 
   */
?>
<?php 
	/*--------------------------------------------------------------------------*
	 * Register settings page, sections, and fields
	/*--------------------------------------------------------------------------*/

	/**
	 * Register settings submenu page
	 */
	function register_settings_page () {
		add_submenu_page('options-general.php', // parent slug
			__('Kasparabi', 'kasparabi'), // page title
			__('Kasparabi', 'kasparabi'), // menu title
			'manage_options', // capcbilities
			'kasparabi-settings-page', // menu slug
			'kasparabi_settings_page' // render function
		);
	}
	add_action('admin_menu', 'register_settings_page');

	/**
	 * Register sections
	 */
	function register_settings_sections_and_fields() {
		register_setting( 'kasparabi-settings', 'kasparabi_settings', 'kasparabi_settings_validation');

		add_settings_section('kasparabi_header', 
			__('Header', 'kasparabi'), 
			'display_kasparabi_header_settings', 
			'kasparabi-settings-page'
		);
		register_kaspari_header_fields();
		
		//add_settings_section('kasparabi_footer', __('Footer', 'kasparabi'), 'display_kasparabi_footer_settings', 'kasparabi-settings-section');

		add_settings_section('kasparabi_archives', // ID
			__('Archives', 'kasparabi'), // Title
			'display_kasparabi_archives_settings', // Callback used to render
			'kasparabi-settings-page' // The page it is rendered on
		);
		register_kaspari_archive_fields();

		add_settings_section('kasparabi_frontpage', // ID
			__('Frontpage', 'kasparabi'), // Title
			'display_kasparabi_frontpage_settings', // Callback used to render
			'kasparabi-settings-page' // The page it is rendered on
		);
		register_kaspari_frontpage_fields();
	}
	add_action('admin_init', 'register_settings_sections_and_fields');

	/**
	 * Register fields
	 */
	function register_kaspari_archive_fields() {
		add_settings_field(
			'kasparabi-archive-references-num-per-page', // field ID
			__('References per page', 'kasparabi'), // label
			'display_archive_references_field', // Callback for rendering
			'kasparabi-settings-page', // Page name which option will be displayed on
			'kasparabi_archives' // name of section it belongs to
		);
		add_settings_field('kasparabi-archive-news-num-per-page', __('News per page', 'kasparabi'), 'display_archive_news_field', 'kasparabi-settings-page', 'kasparabi_archives');
		add_settings_field('kasparabi-archive-inspiration-num-per-page', __('Inspirations per page', 'kasparabi'), 'display_archive_inspiration_field', 'kasparabi-settings-page', 'kasparabi_archives');
	}

	function register_kaspari_header_fields() {
		add_settings_field('kasparabi-logo', __('Logo', 'kasparabi'), 'display_logo_field', 'kasparabi-settings-page', 'kasparabi_header');
	}

	function register_kaspari_frontpage_fields() {
		add_settings_field('frontpage-header', __('Frontpage Header', 'kasparabi'), 'display_frontpage_header', 'kasparabi-settings-page', 'kasparabi_frontpage');
		add_settings_field('frontpage-text', __('Frontpage Text', 'kasparabi'), 'display_frontpage_text', 'kasparabi-settings-page', 'kasparabi_frontpage');
	}


	/*--------------------------------------------------------------------------*
	 * Validation
	/*--------------------------------------------------------------------------*/
	function kasparabi_settings_validation($input) {
		/* TODO: Add type validation */

		$output = array();
		
		foreach ( $input as $key => $value ) {
			
			if ( isset( $input[$key] ) ) {

				$output[$key] = sanitize_text_field(strip_tags( stripcslashes( $input[$key] ) ) );
			}
		}

		return apply_filters( 'kasparabi_settings_validation', $output, $input);
	}




	/*--------------------------------------------------------------------------*
	 * Render fields
	/*--------------------------------------------------------------------------*/
	
	/**
	 * Render the referemces per page field
	 */
	function display_archive_references_field() {
		render_num_per_page_archive_text_field('reference', __('This is used to limit the references per page in the reference archive', 'kasparabi'));	
	}

	/**
	 * Render the news per page field
	 */
	function display_archive_news_field() {
		render_num_per_page_archive_text_field('news', __('This is used to limit the news per page in the news archive', 'kasparabi'));	
	}

	/**
	 * Render the inspiration per page field
	 */
	function display_archive_inspiration_field() {
		render_num_per_page_archive_text_field('inspiration', __('This is used to limit the inspiration per page in the inspiration archive', 'kasparabi'));	
	}

	/**
	 * Render the frontpage header
	 */
	function display_frontpage_header() {
		$options = get_option('kasparabi_settings');

		?>
			<input id="<?php echo 'kasparabi_frontpage_header'; ?>"
				class='large-text' 
				name='kasparabi_settings[<?php echo 'kasparabi_frontpage_header'; ?>]' 
				type='text' 
				value='<?php echo $options['kasparabi_frontpage_header'] ?>'
			/>
			<p class='description'><?php _e('The heading next to the image carousel.', 'kasparabi'); ?></p>
		<?php
	}

	/**
	 * Render the frontpage text
	 */
	function display_frontpage_text() {
		$options = get_option('kasparabi_settings');

		?>
			<textarea id="<?php echo 'kasparabi_frontpage_text'; ?>"
				class='large-text' 
				name='kasparabi_settings[<?php echo 'kasparabi_frontpage_text'; ?>]'
				rows="5"
			><?php echo $options['kasparabi_frontpage_text'] ?></textarea>
			<p class='description'><?php _e('The text next to the image carousel.', 'kasparabi'); ?></p>
		<?php
	}

	/**
	 * Render a text field with description
	 */
	function render_num_per_page_archive_text_field($type, $description) {
		$options = get_option('kasparabi_settings');

		?>
			<input id="<?php echo 'kasparabi_archive_' . $type . '_num_per_page'; ?>"
				class='small-text' 
				name='kasparabi_settings[<?php echo 'kasparabi_archive_' . $type . '_num_per_page'; ?>]' 
				type='text' 
				value='<?php echo $options['kasparabi_archive_' . $type . '_num_per_page'] ?>'
			/>
			<p class='description'><?php echo $description; ?></p>
		<?php
	}

	/**
	 * Render the logo selection
	 */
	function display_logo_field() {
	    $options = get_option('kasparabi_settings');

	    ?>
	        <p>
	            <input type="button" class="button" id="logo-upload-button" value="<?php _e( 'Choose or upload an Image', 'kasparabi' )?>" />
	            <br />
	            <br />
	            <img src="<?php echo $options['logo_url']; ?>" alt="logo" id="logo-thumbnail" />
	            <input type="hidden" name="kasparabi_settings[logo_url]" id="logo_url" value="<?php echo $options['logo_url']; ?>" />
	        </p>
	    <?php
	}




	/*--------------------------------------------------------------------------*
	 * Render sections
	/*--------------------------------------------------------------------------*/
	function display_kasparabi_header_settings() { _e('Settings for the header on the page.', 'kasparabi'); }
	//function display_kasparabi_footer_settings() {}
	function display_kasparabi_archives_settings() { _e('Settings for the archives on the page.', 'kasparabi'); }
	function display_kasparabi_frontpage_settings() { _e('Settings for the frontpage.', 'kasparabi'); }



	/*--------------------------------------------------------------------------*
	 * Render the settings page 
	/*--------------------------------------------------------------------------*/
	function kasparabi_settings_page() {

		if (!current_user_can('manage_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.', 'kasparabi'));
		}

		?>
			
			<div class="wrap">
				<?php screen_icon(); ?> <h2><?php _e('Kasparabi', 'kasparabi'); ?></h2>

				<form method="post" action="options.php">
					<?php settings_fields( 'kasparabi-settings' ); ?>
					<?php do_settings_sections( 'kasparabi-settings-page' ); ?>

					<?php submit_button(); ?>
				</form>
			</div>

		<?php
	}





	/*--------------------------------------------------------------------------*
	 * Enqueue the image handeling script
	/*--------------------------------------------------------------------------*/
	function kasparabi_settings_image_upload() {
	    wp_enqueue_media();

	    wp_register_script( 'settings-image-upload', plugin_dir_url(__FILE__) . '/settings-image-upload.js', array('jquery') );
	    wp_localize_script( 'settings-image-upload', 'settings_image', 
	        array(
	            'title' => __('Choose or upload an image', 'kasparabi'),
	            'button' => __('Use this image', 'kasparabi')
	        )
	    );

	    wp_enqueue_script('settings-image-upload');
	}
	add_action( 'admin_enqueue_scripts', 'kasparabi_settings_image_upload' );