<?php

/**
 * Scriptless Social Sharing
 *
 * @package           ScriptlessSocialSharing
 * @author            Robin Cornett
 * @link              https://github.com/robincornett/scriptless-social-sharing
 * @copyright         2015-2016 Robin Cornett
 * @license           GPL-2.0+
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class ScriptlessSocialSharing
 * main plugin class
 */
class ScriptlessSocialSharing {

	/**
	 * @var $help ScriptlessSocialSharingHelp
	 */
	protected $help;

	/**
	 * @var $output ScriptlessSocialSharingOutput
	 */
	protected $output;

	/**
	 * @var $post_meta ScriptlessSocialSharingPostMeta
	 */
	protected $post_meta;

	/**
	 * @var $settings ScriptlessSocialSharingSettings
	 */
	protected $settings;

	/**
	 * ScriptlessSocialSharing constructor.
	 *
	 * @param $settings
	 */
	public function __construct( $help, $output, $post_meta, $settings ) {
		$this->help      = $help;
		$this->output    = $output;
		$this->post_meta = $post_meta;
		$this->settings  = $settings;
	}

	/**
	 * Run all the things.
	 */
	public function run() {
		add_action( 'admin_menu', array( $this->settings, 'do_submenu_page' ) );
		add_action( 'load-settings_page_scriptlesssocialsharing', array( $this->help, 'help' ) );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'add_meta_boxes', array( $this->post_meta, 'add_meta_box' ), 20 );
		add_action( 'save_post' , array( $this->post_meta, 'save_meta' ) );
		add_action( 'wp_enqueue_scripts', array( $this->output, 'load_styles' ) );
		add_filter( 'scriptlesssocialsharing_get_setting', array( $this->settings, 'get_setting' ) );
		add_filter( 'scriptlesssocialsharing_get_buttons', array( $this->output, 'do_buttons' ), 10, 2 );
		add_filter( 'the_content', array( $this->output, 'hide_pinterest_image' ), 99 );
	}

	/**
	 * Set up text domain for translations
	 *
	 * @since 1.0.0
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'scriptless-social-sharing' );
	}
}
