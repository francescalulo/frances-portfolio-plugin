<?php
/**
 * Custom Post Types and Taxonomies
 *
 * @package Frances_Portfolio
 */

// Stop direct access to this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Custom Post Types.
 */
function fcp_register_post_types() {

	// Work CPT (key: portfolio-project, URL slug: work).
	$labels = array(
		'name'               => _x( 'Work', 'post type general name', 'frances-portfolio' ),
		'singular_name'      => _x( 'Work', 'post type singular name', 'frances-portfolio' ),
		'menu_name'          => _x( 'Work', 'admin menu', 'frances-portfolio' ),
		'add_new_item'       => __( 'Add New Work', 'frances-portfolio' ),
		'new_item'           => __( 'New Work', 'frances-portfolio' ),
		'edit_item'          => __( 'Edit Work', 'frances-portfolio' ),
		'view_item'          => __( 'View Work', 'frances-portfolio' ),
		'all_items'          => __( 'All Work', 'frances-portfolio' ),
		'search_items'       => __( 'Search Work', 'frances-portfolio' ),
		'not_found'          => __( 'No work found.', 'frances-portfolio' ),
		'not_found_in_trash' => __( 'No work found in Trash.', 'frances-portfolio' ),
		'featured_image'     => __( 'Featured Image', 'frances-portfolio' ),
		'set_featured_image' => __( 'Set featured image', 'frances-portfolio' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'work' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-portfolio',
		'supports'           => array( 'title', 'excerpt', 'thumbnail', 'page-attributes', 'revisions' ),
	);

	register_post_type( 'portfolio-project', $args );

	// Experience CPT (key: experience, no public route).
	$labels = array(
		'name'               => _x( 'Experience', 'post type general name', 'frances-portfolio' ),
		'singular_name'      => _x( 'Experience', 'post type singular name', 'frances-portfolio' ),
		'menu_name'          => _x( 'Experience', 'admin menu', 'frances-portfolio' ),
		'add_new_item'       => __( 'Add New Experience', 'frances-portfolio' ),
		'new_item'           => __( 'New Experience', 'frances-portfolio' ),
		'edit_item'          => __( 'Edit Experience', 'frances-portfolio' ),
		'all_items'          => __( 'All Experience', 'frances-portfolio' ),
		'search_items'       => __( 'Search Experience', 'frances-portfolio' ),
		'not_found'          => __( 'No experience found.', 'frances-portfolio' ),
		'not_found_in_trash' => __( 'No experience found in Trash.', 'frances-portfolio' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'query_var'          => false,
		'rewrite'            => false,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 6,
		'menu_icon'          => 'dashicons-id-alt',
		'supports'           => array( 'title', 'page-attributes', 'revisions' ),
	);

	register_post_type( 'experience', $args );
}
add_action( 'init', 'fcp_register_post_types' );

/**
 * The custom taxonomies (all assigned to the Work CPT).
 *
 * @return array key => array( plural label, singular label, URL slug ).
 */
function fcp_get_taxonomies() {
	return array(
		'build'         => array( __( 'Build', 'frances-portfolio' ), __( 'Build', 'frances-portfolio' ), 'build' ),
		'tech-stack'    => array( __( 'Tech Stack', 'frances-portfolio' ), __( 'Tech Stack', 'frances-portfolio' ), 'tech-stack' ),
		'collaboration' => array( __( 'Work With', 'frances-portfolio' ), __( 'Work With', 'frances-portfolio' ), 'collaboration' ),
		'work-category' => array( __( 'Categories', 'frances-portfolio' ), __( 'Category', 'frances-portfolio' ), 'work-category' ),
	);
}

/**
 * Register Custom Taxonomies.
 */
function fcp_register_taxonomies() {

	foreach ( fcp_get_taxonomies() as $key => $tax ) {

		$labels = array(
			'name'          => $tax[0],
			'singular_name' => $tax[1],
			'menu_name'     => $tax[0],
			/* translators: %s: taxonomy name (plural). */
			'all_items'     => sprintf( __( 'All %s', 'frances-portfolio' ), $tax[0] ),
			/* translators: %s: taxonomy name (singular). */
			'edit_item'     => sprintf( __( 'Edit %s', 'frances-portfolio' ), $tax[1] ),
			/* translators: %s: taxonomy name (singular). */
			'add_new_item'  => sprintf( __( 'Add New %s', 'frances-portfolio' ), $tax[1] ),
			/* translators: %s: taxonomy name (singular). */
			'new_item_name' => sprintf( __( 'New %s Name', 'frances-portfolio' ), $tax[1] ),
			/* translators: %s: taxonomy name (plural). */
			'search_items'  => sprintf( __( 'Search %s', 'frances-portfolio' ), $tax[0] ),
			/* translators: %s: taxonomy name (plural, lowercase). */
			'not_found'     => sprintf( __( 'No %s found.', 'frances-portfolio' ), strtolower( $tax[0] ) ),
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => $tax[2] ),
		);

		register_taxonomy( $key, array( 'portfolio-project' ), $args );
	}
}
add_action( 'init', 'fcp_register_taxonomies' );

/**
 * On activation: register the post types and taxonomies, then flush the rewrite rules
 * so their URLs work straight away (activation runs before init).
 *
 * @link https://developer.wordpress.org/plugins/plugin-basics/activation-deactivation-hooks/
 */
function fcp_activate() {
	fcp_register_post_types();
	fcp_register_taxonomies();
	flush_rewrite_rules();
}

/**
 * On deactivation: remove the post types and taxonomies, then flush the rewrite rules
 * so their URLs are cleared. The posts themselves stay in the database.
 */
function fcp_deactivate() {
	unregister_post_type( 'portfolio-project' );
	unregister_post_type( 'experience' );

	foreach ( array_keys( fcp_get_taxonomies() ) as $key ) {
		unregister_taxonomy( $key );
	}

	flush_rewrite_rules();
}
