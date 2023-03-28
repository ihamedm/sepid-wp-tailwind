<?php

namespace Sepid;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Add custom element to DOM
 *
 */
class Customize_DOM {

	protected static $instance = null;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		add_action( 'sepid_after_site_footer', array( $this, 'fixed_buttons' ) );
//		add_action( 'sepid_after_site_footer', array( $this, 'buy_modal' ) );
        add_filter( 'body_class',array( $this, 'sepid_body_classes') );

    }

    public function sepid_body_classes($classes){

        if(is_page()){
            global $post;
            $classes[] = 'page-body-' . $post->post_name;
        }

        return $classes;
    }

	/**
	 * Add this back-to-top button to footer
	 *
	 * @since 1.0.0
	 *
	 * @return  void
	 */
	public function fixed_buttons() {
		printf( '<a href="#page" id="gotop" class="">%s</a>', Icon::get_svg( 'arrow-right' ));
//		printf('<a href="%s" id="whatsapp-btn" target="_blank" class="fix-footer-btn">%s</a>', get_field('whatsapp_link', 'option'),Icon::get_svg( 'whatsapp-fill' , '', 'social'));
//		printf('<a href="%s" id="call-btn" target="_blank" class="fix-footer-btn">%s</a>', get_field('call_link', 'option'),Icon::get_svg( 'call' ));
	}


	public function buy_modal(){
		?>
        <div id="buy-modal" class="spd-modal side-right" tabindex="-1">
            <div class="off-modal-layer"></div>
            <div class="panel-content">
                <div class="modal-header">
                    <a href="#" class="close-account-panel button-close"><?php echo Icon::get_svg( 'close'); ?></a>
                    <div class="modal-title">استعلام فوری قیمت</div>
                </div>
                <div class="modal-content">
                    <?php
                    //dynamic_sidebar('cart-sidebar');
                    echo do_shortcode('[contact-form-7 id="323" title="استعلام قیمت فوری"]');
                    ?>
                </div>
                <div class="modal-footer text-center text-small">

                </div>
            </div>
        </div>
<?php
	}
}
