<?php
/**
 * @package Sepid
 */

namespace Sepid;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Sepid after setup theme
 */
class Setup {
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
		add_action( 'after_setup_theme',    array( $this, 'add_theme_supports' ), 2 );
		add_action( 'after_setup_theme',    array( $this, 'set_thumbnail_sizes' ), 2 );
		add_action( 'wp_enqueue_scripts',   array( $this, 'enqueue_scripts' ) );
		add_action( 'widgets_init',         array( $this, 'widgets_init' ) );
		add_action( 'wp_head',              array( $this, 'add_favicon') );


		add_filter( 'intermediate_image_sizes', array($this, 'remove_intermediate_image_sizes') );
		add_filter( 'excerpt_length', array( $this, 'customize_excerpt_length'));
		add_filter( 'use_block_editor_for_post_type', array($this , 'disable_gutenberg_for_post_types'), 10, 2);

	}

	/**
	 * Setup theme
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_theme_supports() {

		// Make theme available for translation. Translations can be filed in the /languages/ directory.
		load_theme_textdomain( 'sepid', get_template_directory() . '/lang' );

		// Theme supports
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		add_theme_support( 'align-wide' );

		add_theme_support( 'align-full' );


		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary'    => esc_html__( 'Primary Menu', 'sepid' ),
			'topbar'     => esc_html__( 'TopBar', 'sepid' ),
			'socials'    => esc_html__( 'Social Menu', 'sepid' ),
			'footer'    => esc_html__( 'Footer Menu', 'sepid' ),
		) );


		remove_theme_support( 'widgets-block-editor' );
	}


	public function remove_intermediate_image_sizes( $sizes ) {
		$new_sizes =  array_diff( $sizes, array(
			'2048x2048',
			'1536x1536',
			'large',
			'medium_large',
			'medium' ,
			'thumbnail',
		) );
		return $new_sizes;
	}

	public function set_thumbnail_sizes() {
		add_image_size( 'sepid-card', 300, 300 , true );
	}


	public function add_favicon(){
		echo "<link rel='shortcut icon' href='" . $this->sepid_asset('assets/images/favicon.png') . "' />" . "\n";
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		$version = Helper::get_theme_version();

		wp_enqueue_style( 'sepid', $this->sepid_asset('build/index.css') ,null, $version);
		wp_enqueue_script( 'sepid', $this->sepid_asset('build/app.js') , null , $version, true );

		if ( (!is_admin()) && is_singular() && comments_open() && get_option('thread_comments') ){
			wp_enqueue_script( 'comment-reply' );
		}

	}

    /**
     * Get asset path.
     *
     * @param string  $path Path to asset.
     *
     * @return string
     */
    public function sepid_asset( $path ) {
        if ( wp_get_environment_type() === 'production' ) {
            return get_stylesheet_directory_uri() . '/' . $path;
        }

        return add_query_arg( 'time', time(),  get_stylesheet_directory_uri() . '/' . $path );
    }

	/**
	 * Register widget area.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function widgets_init() {
		$sidebars = array(
			'blog-sidebar' => esc_html__( 'Blog Sidebar', 'sepid' ),
		);

		// Register sidebars
		foreach ( $sidebars as $id => $name ) {
			register_sidebar(
				array(
					'name'          => $name,
					'id'            => $id,
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<div class="widget-title">',
					'after_title'   => '</div>',
				)
			);
		}

	}


	public function customize_excerpt_length($length){
		return 20;
	}

	public function disable_gutenberg_for_post_types($is_enabled, $post_type){
		$exclude_post_types = array('product', 'post', 'page');
		if (in_array($post_type, $exclude_post_types)) return false;

		return $is_enabled;
	}
}
