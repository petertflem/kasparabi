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
	 * Make custom settings page
	/*--------------------------------------------------------------------------*/
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

	function register_settings() {
		register_setting( 'kasparabi-settings', 'kasparabi_settings', 'kasparabi_settings_validation');

		//add_settings_section('kasparabi_header', __('Header', 'kasparabi'), 'display_kasparabi_header_settings', 'kasparabi-settings-section');
		//add_settings_field('kasparabi-logo', __('Logo', 'kasparabi'), 'display_logo_field', 'kasparabi-settings-section', 'kasparabi_header');

		//add_settings_section('kasparabi_footer', __('Footer', 'kasparabi'), 'display_kasparabi_footer_settings', 'kasparabi-settings-section');

		add_settings_section('kasparabi_archives', // ID
			__('Archives', 'kasparabi'), // Title
			'display_kasparabi_archives_settings', // Callback used to render
			'kasparabi-settings-page' // The page it is rendered on
		);

		add_settings_field(
			'kasparabi-archive-references-num-per-page', // field ID
			__('References per page', 'kasparabi'), // label
			'display_archive_references_field', // Callback for rendering
			'kasparabi-settings-page', // Page name which option will be displayed on
			'kasparabi_archives' // name of section it belongs to
		);
		add_settings_field('kasparabi-archive-news-num-per-page', __('News per page', 'kasparabi'), 'display_archive_news_field', 'kasparabi-settings-page', 'kasparabi_archives');
	}
	add_action('admin_init', 'register_settings');

	function kasparabi_settings_validation($input) {
		/* TODO: Add type validation */

		$output = array();
		
		foreach ( $input as $key => $value ) {
			
			if ( isset( $input[$key] ) ) {

				$output[$key] = strip_tags( stripcslashes( $input[$key] ) );
			}
		}

		return apply_filters( 'kasparabi_settings_validation', $output, $input);
	}

	/*function display_logo_field() {
		$options = get_option('kasparabi_header');
		echo "<input id='kasparabi_logo' name='kasparabi_header[kasparabi_logo]' size='40' type='text' value='{$options['kasparabi_logo']}'' />" .
		     "<p class='description'>Here you can set the logo for the web page</p>";
	}*/

	function display_archive_references_field() {
		$options = get_option('kasparabi_settings');

		?>
			<input id='kasparabi_archive_references_num_per_page' 
				class='small-text' 
				name='kasparabi_settings[kasparabi_archive_references_num_per_page]' 
				type='text' 
				value='<?php echo $options["kasparabi_archive_references_num_per_page"] ?>'
			/>
			<p class='description'><?php _e('This is used to limit the references per page in the references archive', 'kasparabi'); ?></p>
		<?php
	}

	function display_archive_news_field() {
		$options = get_option('kasparabi_settings');

		?>
			<input id='kasparabi_archive_news_num_per_page' 
				class='small-text' 
				name='kasparabi_settings[kasparabi_archive_news_num_per_page]' 
				type='text' 
				value='<?php echo $options["kasparabi_archive_news_num_per_page"] ?>'
			/>
			<p class='description'><?php _e('This is used to limit the news per page in the references archive', 'kasparabi'); ?></p>
		<?php
	}

	function display_kasparabi_header_settings() {
		echo '';
	}

	/*function display_kasparabi_footer_settings() {
		echo '';
	}*/

	function display_kasparabi_archives_settings() {
		echo '';
	}

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