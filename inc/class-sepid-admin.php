<?php
namespace Sepid;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Admin {

	protected static $instance = null;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'add_script_to_admin_pages' ));

		require_once get_template_directory() . '/inc/libs/class-tgm-plugin-activation.php';
		if ( is_admin() ) {
            \Sepid\Admin\Plugin_Install::instance();
//            \Sepid\Admin\Meta_Boxes::instance();
//            \Sepid\Admin\Menu_Item_Meta::instance();
		}
	}

	public function add_script_to_admin_pages()
	{
//		global $pagenow;
//
//		if ($pagenow == 'nav-menus.php') {
//			return;
//		}

		// loading css
		wp_enqueue_style( 'sepid-admin-styles', get_template_directory_uri() . '/assets/css/admin-styles.css', false, '1.0.0' );

	}


}

