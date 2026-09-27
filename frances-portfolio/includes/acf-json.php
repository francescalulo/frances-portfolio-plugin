<?php
/**
 * ACF Local JSON
 * Saves and loads ACF field groups from the plugin's acf-json folder
 * so they are version-controlled with Git.
 *
 * @link https://www.advancedcustomfields.com/resources/local-json/
 * @package Frances_Portfolio
 */

// Stop direct access to this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Save field groups as JSON in this plugin's acf-json folder.
 *
 * @param string $path Default save path.
 * @return string New save path.
 */
function fcp_acf_json_save_point( $path ) {
	return plugin_dir_path( __DIR__ ) . 'acf-json';
}
add_filter( 'acf/settings/save_json', 'fcp_acf_json_save_point' );

/**
 * Load field groups from this plugin's acf-json folder.
 *
 * @param array $paths Default load paths.
 * @return array New load paths.
 */
function fcp_acf_json_load_point( $paths ) {
	unset( $paths[0] ); // Remove the default (theme) folder.
	$paths[] = plugin_dir_path( __DIR__ ) . 'acf-json';
	return $paths;
}
add_filter( 'acf/settings/load_json', 'fcp_acf_json_load_point' );
