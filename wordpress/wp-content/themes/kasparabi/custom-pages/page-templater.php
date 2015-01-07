<?php
  /* Based on this: http://www.wpexplorer.com/wordpress-page-templates-plugin/ */

  /*
    Plugin Name: [kasparabi] Gallery Page
    Plugin URI: 
    Description: Provides the gallery page
    Author: Peter Tollnes Flem
    Version: 1.0
    Author URI:
  */

  class PageTemplater {

    private static $instance;  // A reference to an instance of this class
    protected $templates;      // The array of templates that this plugin tracks

    public static function get_instance() {
      if (null == self::$instance) {
        self::$instance = new PageTemplater();
      }

      return self::$instance;
    }

    private function __construct() {
      //$this->templates = array();

      //add_filter('page_attributes_dropdown_pages_args', array($this, 'register_project_templates'));
      //add_filter('wp_insert_post_data', array($this, 'register_project_templates'));
      //add_filter('template_include', array($this, 'view_project_template'));

      //$this->templates = array('kasparabi-gallery-page.php' => 'Gallery Page');
    }

    public function register_project_templates($atts) {

      // Create the key used for the themes cache
      $cache_key = 'page_templates-' . md5(get_theme_root() . '/' . get_stylesheet());

      // Retrieve the cache list.
      // If it doesn't exist, or it's empty, prepare an array
      $templates = wp_get_theme()->get_page_templates();
      if (empty($templates)) {
        $templates = array();
      }

      // New cache, therefore remove the old one
      wp_cache_delete($cache_key, 'themes');

      // Now add our template to the list of templates by merging our templates
      // with the existing templates array from the cache.
      $templates = array_merge($templates, $this->templates);

      // Add the modified cache to allow WordPress to pick it up for listing
      // available templates.
      wp_cache_add($cache_key, $templates, 'themes', 1800);

      return $atts;
    }

    public function view_project_template($template) {
      global $post;

      if (!isset($this->templates[get_post_meta($post->ID, '_wp_page_template', true)])) {
        return $template;
      }

      $file = plugin_dir_path(__FILE__).get_post_meta($post->ID, '_wp_page_template', true);

      if (file_exists($file)) {
        return $file;
      } else { echo $file; }

      return $template;
    }
  }
?>