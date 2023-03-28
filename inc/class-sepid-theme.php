<?php
/**
 * Sepid start init here
 */

namespace Sepid;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


/**
 * Sepid theme init
 */
final class Theme {
    /**
     * Instance
     *
     * @var $instance
     */
    private static $instance = null;

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
        require_once get_template_directory() . '/inc/class-sepid-autoload.php';
    }

    /**
     * Hooks to init
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function start() {
        // Before init action.
        do_action( 'before_sepid_theme_init' );

        $this->get( 'autoload' );

        // Setup Theme []
        $this->get( 'setup' );

        // walkers
        $this->get( 'Menus_Walker' );


	    $this->get( 'Options_ACF' );

        // Layout & Style
		$this->get('Customize_DOM');

        // Admin
        $this->get( 'admin' );

        // After init action.
        do_action( 'after_sepid_theme_init' );

    }

    /**
     * get object of classes
     *
     * @param $class
     * @return mixed|object|Options|WooCommerce|void|null
     */
    public function get( $class ) {
        switch ( $class ) {

            // specific classes locate in /inc/..
            case 'woocommerce':
                if ( class_exists( 'WooCommerce' ) ) {
                    return WooCommerce::instance();
                }
                break;

            // general classes locate on /inc directory
            default :
                $class = ucwords( $class );
                $class = "\Sepid\\" . $class;
                if ( class_exists( $class ) ) {
                    return $class::instance();
                }
                break;
        }

    }

}
