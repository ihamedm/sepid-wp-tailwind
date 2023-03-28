<?php
function sepidtw_enqueue_scripts() {
	$theme = wp_get_theme();

	wp_enqueue_style( 'tailpress', sepidtw_asset( 'dist/styles.css' ), array(), $theme->get( 'Version' ) );
    wp_enqueue_script( 'tailpress', sepidtw_asset( 'dist/scripts.js' ), array(), $theme->get( 'Version' ) );
}

add_action( 'wp_enqueue_scripts', 'sepidtw_enqueue_scripts' );

function sepidtw_asset( $path ) {
	if ( wp_get_environment_type() === 'production' ) {
		return get_stylesheet_directory_uri() . '/' . $path;
	}

	return add_query_arg( 'time', time(), get_stylesheet_directory_uri() . '/' . $path );
}
