<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://knowhalim.com/plugins
 * @since      1.0.0
 *
 * @package    Kh_Remove_Duplicates
 * @subpackage Kh_Remove_Duplicates/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Kh_Remove_Duplicates
 * @subpackage Kh_Remove_Duplicates/includes
 * @author     Halim <contact@knowhalim.com>
 */
class Kh_Remove_Duplicates_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'kh-remove-duplicates',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
