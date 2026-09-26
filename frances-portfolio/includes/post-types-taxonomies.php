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
 * Register Custom Taxonomies (all assigned to the Work CPT).
 */
function fcp_register_taxonomies() {

	// key => array( plural label, singular label, URL slug ).
	$taxonomies = array(
		'build'         => array( 'Build', 'Build', 'build' ),
		'tech-stack'    => array( 'Tech Stack', 'Tech Stack', 'tech-stack' ),
		'collaboration' => array( 'Work With', 'Work With', 'collaboration' ),
		'work-category' => array( 'Categories', 'Category', 'work-category' ),
	);

	foreach ( $taxonomies as $key => $tax ) {

		$labels = array(
			'name'          => $tax[0],
			'singular_name' => $tax[1],
			'menu_name'     => $tax[0],
			'all_items'     => 'All ' . $tax[0],
			'edit_item'     => 'Edit ' . $tax[1],
			'add_new_item'  => 'Add New ' . $tax[1],
			'new_item_name' => 'New ' . $tax[1] . ' Name',
			'search_items'  => 'Search ' . $tax[0],
			'not_found'     => 'No ' . strtolower( $tax[0] ) . ' found.',
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