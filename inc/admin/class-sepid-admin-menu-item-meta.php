<?php

namespace Sepid\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Meta boxes initial
 *
 */
class Menu_Item_Meta {
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
		//add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'add_custom_fields'), 10, 2 );
		//add_action( 'wp_update_nav_menu_item', array( $this, 'update_custom_fields') , 10, 2 );
	}

	/**
	 * Add custom fields to menu item
	 *
	 * This will allow us to play nicely with any other plugin that is adding the same hook
	 *
	 * @param  int $item_id
	 * @params obj $item - the menu item
	 * @params array $args
	 */
	public function add_custom_fields( $item_id, $item ) {

		wp_nonce_field( 'custom_menu_meta_nonce', '_custom_menu_meta_nonce_name' );
		$svg_icon = get_post_meta( $item_id, '_menu-item-svg-icon', true );
        echo '<div class="spd-menu-item-icon">' . $svg_icon . '</div>';
		?>

		<input type="hidden" name="custom-menu-meta-nonce" value="<?php echo wp_create_nonce( 'custom-menu-meta-name' ); ?>" />

		<p class="field-description description description-wide" >
			<input type="hidden" class="nav-menu-id" value="<?php echo $item_id ;?>" />

            <label for="edit-menu-item-svg-icon-<?php echo $item_id ;?>">
                <?php echo esc_html__( 'show SVG icon if setup on theme', 'sepid'); ?><br>
                <textarea name="menu-item-svg-icon[<?php echo $item_id ;?>]" id="menu-item-svg-icon-for-<?php echo $item_id ;?>" class="widefat" rows="3" cols="20" style="direction: ltr;text-align: left"><?php echo esc_attr( $svg_icon ); ?></textarea>
            </label>

		</p>

		<?php
	}




	/**
	 * Save the menu item meta
	 *
	 * @param int $menu_id
	 * @param int $menu_item_db_id
	 */
	public function update_custom_fields( $menu_id, $menu_item_db_id ) {

		// Verify this came from our screen and with proper authorization.
		if ( ! isset( $_POST['_custom_menu_meta_nonce_name'] ) || ! wp_verify_nonce( $_POST['_custom_menu_meta_nonce_name'], 'custom_menu_meta_nonce' ) ) {
			return $menu_id;
		}

		if ( isset( $_POST['menu-item-svg-icon'][$menu_item_db_id]  ) ) {
			$sanitized_data = esc_html( $_POST['menu-item-svg-icon'][$menu_item_db_id] );
			update_post_meta( $menu_item_db_id, '_menu-item-svg-icon', $_POST['menu-item-svg-icon'][$menu_item_db_id]);
		} else {
			delete_post_meta( $menu_item_db_id, '_menu-item-svg-icon' );
		}
	}

}
