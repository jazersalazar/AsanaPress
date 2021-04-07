<?php
/**
 * Plugin Name: AsanaWP
 * Plugin URI: https://asanawp.com/
 * Description: Integrates asana functionalities inside wordpress dashboard.
 * Author: Jazer Salazar
 * Author URI: https://jazersalazar.com/
 * Version: 0.1
 */

require 'vendor/autoload.php';
require 'includes/settings.php';

define( 'PLUGIN_URL', plugin_dir_url(__FILE__));

function admin_scripts() {
    wp_enqueue_style('asanawp-styles', PLUGIN_URL .'/includes/asanawp.css');
    wp_enqueue_script('asanawp-script', PLUGIN_URL .'/includes/asanawp.js');
}
add_action('admin_enqueue_scripts', 'admin_scripts');