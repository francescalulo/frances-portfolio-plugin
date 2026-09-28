<?php
/**
 * Custom REST API fields
 * Adds a next_project field to Work (portfolio-project) posts
 * for the Work Detail "Next Up" section.
 * Based on the course fwd-rest-api-plugin (register_rest_field()).
 *
 * @link https://developer.wordpress.org/reference/functions/register_rest_field/
 * @package Frances_Portfolio
 */

// Stop direct access to this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register REST API fields.
 */
function fcp_register_rest_fields() {

	// Register a 'next_project' REST API field for the Work CPT.
	register_rest_field(
		'portfolio-project', // REST object name.
		'next_project',      // REST field name.
		array(
			'get_callback'    => 'fcp_get_next_project',
			'update_callback' => null,
			'schema'          => null,
		)
	);
}
add_action( 'rest_api_init', 'fcp_register_rest_fields' );

/**
 * Get all published Work post IDs in display order
 * (the "Order" box first, then title A–Z).
 * Saved in a static variable so the query only runs once per request.
 *
 * @return array Ordered post IDs.
 */
function fcp_get_ordered_project_ids() {
	static $ids = null;

	if ( null === $ids ) {
		$ids = get_posts(
			array(
				'post_type'      => 'portfolio-project',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => array(
					'menu_order' => 'ASC',
					'title'      => 'ASC',
				),
				'fields'         => 'ids',
			)
		);
	}

	return $ids;
}

/**
 * Callback for the next_project field.
 *
 * @param array $post The prepared post data (includes 'id').
 * @return array|null Next project info, or null if there is nothing to link to.
 */
function fcp_get_next_project( $post ) {
	$ids   = fcp_get_ordered_project_ids();
	$total = count( $ids );
	$index = array_search( (int) $post['id'], $ids, true );

	// Not found, or only one project: no Next Up.
	if ( false === $index || $total < 2 ) {
		return null;
	}

	// Loop from the last project back to the first.
	$next_index = ( $index + 1 ) % $total;
	$next_id    = $ids[ $next_index ];

	return array(
		'id'           => $next_id,
		'title'        => get_the_title( $next_id ),
		'slug'         => get_post_field( 'post_name', $next_id ),
		'project_type' => function_exists( 'get_field' ) ? (string) get_field( 'project_type', $next_id ) : '',
		'position'     => $next_index + 1,
		'total'        => $total,
	);
}
