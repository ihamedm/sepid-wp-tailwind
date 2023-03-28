<?php

namespace Sepid;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Inline_Style {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'sepid_after_enqueue_all_styles', array( $this, 'generate_inline_styles' ) );
	}

	/**
	 * Get get style data
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	public function generate_inline_styles() {
		$inline_styles = $this->mobile_header_static_css();
		wp_add_inline_style( 'sepid', apply_filters( 'sepid_inline_styles', $inline_styles ) );
	}


	/**
	 * Get CSS code of settings for mobile header
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	public function mobile_header_static_css() {
		$static_css = '';

		// Mobile Header Height
		if ( get_field( 'mobile_header_height' ) != 60 ) {
			$static_css .= '.spd-header-mobile { height: ' . intval( get_field( 'mobile_header_height' ) ) . 'px; }';
		}

		return $static_css;
	}
}
