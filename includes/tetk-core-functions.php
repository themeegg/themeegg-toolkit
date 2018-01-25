<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
function tetk_maybe_define_constant( $name, $value ) {
	if ( ! defined( $name ) ) {
		define( $name, $value );
	}
}

function tetk_get_post_id( $slug, $post_type ) {
	$query = new WP_Query(
		array(
			'name'      => $slug,
			'post_type' => $post_type
		)
	);

	$query->the_post();

	return get_the_ID();
}