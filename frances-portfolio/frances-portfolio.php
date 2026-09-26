<?php
/*
* Plugin Name:       Frances Portfolio
* Plugin URI:        https://francescalulo.com/
* Description:       Custom post types, taxonomies, and REST API fields for the headless portfolio.
* Version:           1.1.0
* Requires at least: 6.5
* Requires PHP:      7.0
* Author:            Frances Calulo
* Author URI:        https://francescalulo.com/
* License:           GPL v2 or later
* License URI:       https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain:       frances-portfolio
* Update URI:        false
*/

// Stop direct access to this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Custom Post Types and Taxonomies.
require_once plugin_dir_path( __FILE__ ) . 'includes/post-types-taxonomies.php';