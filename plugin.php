<?php namespace cahnrswp\pagebuilder2;

/**
* Plugin Name: CAHNRS Page Builder 2
* Plugin URI: http://cahnrs.wsu.edu/communications
* Description: Builds Custom Layouts For Pages/Posts
* Version: 0.1
* Author: CAHNRS Communication, Danial Bleile, Phil Cabel
* Author URI: http://URI_Of_The_Plugin_Author
* License: GPL2
*/

class init_plugin{

	private $render_controller;
	private $editor_controller;
	
	public function __construct(){
		/** Defin URL and DIR to use in the plugin **/
		define( __NAMESPACE__.'\URL' , plugins_url( __FILE__ ) ); // Plugin Base Url
		define( __NAMESPACE__.'\DIR' , plugin_dir_path( __FILE__ ) ); // Plugin Directory Path
		
		/** Add autoloading so we don't have to rely on require **/
		require_once 'controls/autoload_control.php';
		$autoload = new autoload_contol();
		
		/** For cleanliness sake, isolate public and admin calls **/
		if ( \is_admin() ) { // Test admin first so it defaults to public if funciton fails
			$this->init_admin(); // Handle admin stuff
		} else {
			$this->init_public(); // Handle public stuff
		}
		$widgets = new widget_control();
	}
	
	private function init_public(){
		
		$this->display_controller = new display_control;
		
		/** render_control ******************************
		* Builds document structure and renders it on public side *
		* It uses the_content filter so that it can easily be added to any theme *
		* Some internal handling is needed so it doesn't create infinite loops *
		* resulting from the use of "apply_filters("the_content..." inside plugins *
		*************************************************/
		\add_filter( 'the_content', array( $this->display_controller , 'get_public_display' ), 99 );
	}
	
	private function init_admin(){
		
		$this->editor_controller = new editor_control();
		
		/** edit_form_after_title ************************
		* Using this hook since wp_editors can't be repositioned in the DOM *
		**************************************************/
		\add_action( 'edit_form_after_title', array( $this->editor_controller , 'add_editor' ) );
		
		\add_action( 'save_post', array( $this->editor_controller , 'save_post' ) );
		
		\add_action( 'init', array( $this->editor_controller , 'remove_default_editor' ) ); 
	}
}
$cahnrs_pabebuilder_2 = new init_plugin(); // Let's start this train a'movin
?>