<?php
namespace Sepid\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register required plugins
 *
 * @since  1.0
 */
class Plugin_Install {
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
		add_action( 'tgmpa_register', array( $this, 'register_required_plugins' ) );
	}


	/**
	 * Register required plugins
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_required_plugins() {
		$plugins = array(
			// This is an example of how to include a plugin bundled with a theme.
			/**
			array(
				'name'               => 'TGM Activation Plugin', // The plugin name.
				'slug'               => 'tgm-activation-plugin', // The plugin slug (typically the folder name).
				'source'             => get_stylesheet_directory() . '/lib/plugins/tgm-activation-plugin.zip', // The plugin source. It can be an external link, wordpress plugin repository or a GITHUB repository.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
				'is_callable'        => '', // If set, this callable will be checked for availability to determine if a plugin is active.
			),
			*/
			array(
				'name'               => esc_html__( 'Advanced Custom Field', 'sepid' ),
				'slug'               => 'advanced-custom-fields-pro',
				'source'             => get_stylesheet_directory() . '/plugins/advanced-custom-fields-pro.zip',
				'required'           => true,
				'force_activation'   => true,
			),
//			array(
//				'name'               => esc_html__( 'Disable Gutenberg', 'sepid' ),
//				'slug'               => 'disable-gutenberg',
//				'required'           => true,
//				'force_activation'   => false,
//			),
			array(
				'name'               => esc_html__( 'Parsi Date', 'sepid' ),
				'slug'               => 'wp-parsidate',
				'required'           => true,
				'force_activation'   => true,
			)
		);
		$config  = array(
			'domain'       => 'sepid',
			'default_path' => '',
			'menu'         => 'install-required-plugins',
			'has_notices'  => true,
			'is_automatic' => false,
			'message'      => '',
			'strings'      => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'sepid' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'sepid' ),
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'sepid' ),
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'sepid' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'sepid' ),
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'sepid' ),
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'sepid' ),
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'sepid' ),
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'sepid' ),
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'sepid' ),
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'sepid' ),
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'sepid' ),
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'sepid' ),
				'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'sepid' ),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'sepid' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'sepid' ),
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'sepid' ),
				'nag_type'                        => 'updated',
			),
		);
		tgmpa( $plugins, $config );
	}
}
