<?php
namespace Sepid;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Options_ACF {
    /**
     * Instance Generator
     *
     * @var $instance
     */
    protected static $instance = null;

    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self:: $instance;
    }



    public function __construct() {
	    if(is_admin()){
		    add_filter( 'acf/load_field/name=icon', array( $this, 'acf_svg_icon_picker_field' ));
		    //add_filter( 'acf/load_field/name=spd_product_tax', array( $this, 'acf_spd_product_taxonomy_field_choices' ));
		    //add_filter( 'acf/load_field/name=spd_terms', array( $this, 'acf_spd_terms_field_choices' ));
	    }

//        include_once get_template_directory() . '/inc/libs/acf-configs.php';

	    if( function_exists('acf_add_options_page') ) {

		    acf_add_options_page(array(
			    'page_title' 	=> 'تنظیمات پوسته',
			    'menu_title'	=> 'تنظیمات پوسته',
			    'menu_slug' 	=> 'theme-general-settings',
			    'capability'	=> 'edit_posts',
			    'redirect'		=> false
		    ));

	    }
    }


	/**
	 * @param $name
	 *
	 * @return array|false
	 */
	public function get_option($name){
		return get_field($name, 'option');
	}




	public function show_icon_align_menu_item_fields( $value, $post_id, $field ) {

		$key_show_icon = $key_svg_icon = '';
		foreach ($field['sub_fields'] as $field) {
			if($field['name'] == 'svg_icon') $key_svg_icon = $field['key'];
			if($field['name'] == 'show_icon') $key_show_icon = $field['key'];
		}

		if($value[$key_show_icon] == '1')
			echo '<div class="spd-menu-item-icon">' . $value[$key_svg_icon] . '</div>';

		return $value;
	}


	public function acf_svg_icon_picker_field( $field ) {

		$field['choices'] = Icon::get_all_icons();

		return $field;
	}

	public function acf_spd_product_taxonomy_field_choices( $field ) {

		$field['choices'] = array();

		$taxonomy_objects = get_object_taxonomies( 'product', 'objects' );
		foreach ( $taxonomy_objects as $taxonomy_slug => $taxonomy ){
			$field['choices'][$taxonomy_slug] = $taxonomy->label;
		}

		return $field;
	}

	public function acf_spd_terms_field_choices( $field ) {
        $taxonomies = array();

        // only get terms of these taxonomies
        $include_taxonomies = array();

        $taxonomy_objects = get_object_taxonomies( 'product', 'objects' );
        foreach ( $taxonomy_objects as $taxonomy_slug => $taxonomy ){
            $taxonomies[$taxonomy_slug] = $taxonomy->label;
            $include_taxonomies[] = $taxonomy_slug;
        }


		$field['choices'] = array();
		$terms = get_terms( array(
            'taxonomy' => $include_taxonomies,
			'hide_empty' => false,
		));

		if ( $terms ) {
			foreach ( $terms as $term ) {
				$field['choices'][$term->slug] = $term->name . ' [ '.$taxonomies[$term->taxonomy] . ' ]';
			}
		}

		return $field;
	}


}
