<?php

/**
 * Plugin main file
 *
 *
 * @link              https://timersys.com
 * @since             1.0.0
 * @package           Yoast_Qef
 *
 * @wordpress-plugin
 * Plugin Name:       Yoast SEO Quick Edit Fields
 * Plugin URI:        http://wordpress.org/plugins/yoast-qef
 * Description:       Add Yoast SEO basic fields to quick edit mode of WordPress
 * Version:           1.0.0
 * Author:            Damian Logghe
 * Author URI:        https://timersys.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       yoast-qef
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-yoast-qef-activator.php
 */
function activate_yoast_qef() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-yoast-qef-activator.php';
	Yoast_Qef_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-yoast-qef-deactivator.php
 */
function deactivate_yoast_qef() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-yoast-qef-deactivator.php';
	Yoast_Qef_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_yoast_qef' );
register_deactivation_hook( __FILE__, 'deactivate_yoast_qef' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-yoast-qef.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_yoast_qef() {

	$plugin = new Yoast_Qef();
	$plugin->run();

}
run_yoast_qef();
