<?php
/**
 * @package Sepid
 */

namespace Sepid;

use Sepid\Theme;
use WP_Term;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sepid Helper initial
 *
 */
class Helper {
	/**
	 * Post ID
	 *
	 * @var $post_id
	 */
	protected static $post_id = null;

	/**
	 * Header Layout
	 *
	 * @var $header_layout
	 */
	protected static $header_layout = null;


    public static function print_pre($var){
        echo '<pre style="direction: ltr;text-align: left;font-size: 0.7rem;font-weight: 600;">';
        print_r($var);
        echo '</pre>';
    }
    /**
     * @return array|false|string
     */
    public static function get_theme_version(){
        return wp_get_theme()->get('Version');
    }

	/**
	 * Get theme option
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_option( $name ) {
		return Theme::instance()->get( 'options_ACF' )->get_option( $name );
	}


	/**
	 * get user display name
	 */
    public static function get_user_display_name(){
	    $user = wp_get_current_user();
        if( !$user->exists()) return false;

	    return $user->display_name ?: $user->first_name . ' ' . $user->last_name;

    }


	/**
	 * Post pagination
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function sepid_posts_navigation( \WP_Query $wp_query = null, $echo = true, $params = [] ) {
		if ( null === $wp_query ) {
			global $wp_query;
		}

		$add_args = [];

		$pages = paginate_links( array_merge( [
				'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
				'format'       => '?paged=%#%',
				'current'      => max( 1, get_query_var( 'paged' ) ),
				'total'        => $wp_query->max_num_pages,
				'type'         => 'array',
				'show_all'     => false,
				'end_size'     => 3,
				'mid_size'     => 1,
				'prev_next'    => true,
				'prev_text'    => '« قبلی',
				'next_text'    => 'بعدی »',
				'add_args'     => $add_args,
				'add_fragment' => ''
			], $params )
		);

		if ( is_array( $pages ) ) {
			//$current_page = ( get_query_var( 'paged' ) == 0 ) ? 1 : get_query_var( 'paged' );
			$pagination = '<nav class=""><ul class="pagination">';

			foreach ( $pages as $page ) {
				$pagination .= '<li class="page-item' . ( strpos( $page, 'current' ) !== false ? ' active' : '' ) . '"> ' . str_replace( 'page-numbers', 'page-link', $page ) . '</li>';
			}

			$pagination .= '</ul></nav>';

			if ( $echo ) {
				echo $pagination;
			} else {
				return $pagination;
			}
		}
	}

    public static function the_breadcrumb() {

	    $breadcrumbs = new Breadcrumbs(array(
		    'home'      => 'خانه',
		    'blog'      => 'بلاگ',
		    'seperator' => '»',
		    'class'     => 'spd-breadcrumbs',
		    'element'   => 'nav'
	    ));
		$breadcrumbs->theBreadcrumbs();
    }




    public static function get_product_term_link(\WP_Post $product){
        //Get all terms associated with post in taxonomy 'category'
	    $terms = get_the_terms($product->ID,'product_group');
        //Get an array of their IDs
	    $term_ids = wp_list_pluck($terms,'term_id');

        //Get array of parents - 0 is not a parent
	    $parents = array_filter(wp_list_pluck($terms,'parent'));

        //Get array of IDs of terms which are not parents.
	    $term_ids_not_parents = array_diff($term_ids,  $parents);

        //Get corresponding term objects
	    $terms_not_parents = array_intersect_key($terms,  $term_ids_not_parents);

	    if($terms_not_parents > 0){
		    $term_to_redirect = end($terms_not_parents);
	    }else{
		    $term_to_redirect = end($terms);
	    }

	    return get_term_link($term_to_redirect);
    }


	/**
     *
     * return filters and price table columns specific for each term
     * return defaults from theme options if not set for current term
     *
	 * @param $current_term
	 *
	 * @return array
	 */
    public static function get_term_table_columns($current_term = null , $default_field_key = 'table_columns_defaults'){
        $filters = array();
        $table_columns = array();

	    if(isset($current_term) && have_rows('table_columns', $current_term)):
		    while(have_rows('table_columns', $current_term)): the_row();
			    $row_layout = get_row_layout();
			    if( $row_layout == 'taxonomy'){
				    $tax = get_sub_field('spd_product_tax', $current_term);

                    $table_columns[] = array(
					    'layout' => $row_layout,
					    'slug' => $tax['value'] ?? '',
					    'label' => $tax['label'] ?? '',
					    'mobile-hidden' => get_sub_field('mobile-hidden') ?? '',
				    );

                    if(get_sub_field('use_as_filter', $current_term)){
                        $filters[] = array(
                            'taxonomy' => $tax,
                            'terms' =>   get_sub_field('spd_terms', $current_term),
                        );
                    }
			    }else{
				    $post_meta = get_sub_field('post_meta_key', $current_term);
				    $table_columns[] = array(
					    'layout' => $row_layout,
					    'slug' => $post_meta['value'] ?? '',
					    'label' => $post_meta['label'] ?? '',
					    'mobile-hidden' => get_sub_field('mobile-hidden') ?? ''
				    );
			    }
		    endwhile;

        // custom columns not defined for these products group so get default values from theme options
        elseif(have_rows($default_field_key, 'options')):
		    while(have_rows($default_field_key, 'options')): the_row();
			    $row_layout = get_row_layout();
			    if( $row_layout == 'taxonomy' ){
				    $tax = get_sub_field('spd_product_tax', 'options');
				    $table_columns[] = array(
					    'layout' => $row_layout,
					    'slug' => $tax['value'] ?? '',
					    'label' => $tax['label'] ?? '',
					    'mobile-hidden' => get_sub_field('mobile-hidden') ?? ''
				    );

                    if(get_sub_field('use_as_filter', 'options')){
                        $filters[] = array(
                            'taxonomy' => $tax,
                            'terms' =>   get_sub_field('spd_terms', 'options'),
                        );
                    }
			    }else{
				    $post_meta = get_sub_field('post_meta_key', 'options');
				    $table_columns[] = array(
					    'layout' => $row_layout,
					    'slug' => $post_meta['value'] ?? '',
					    'label' => $post_meta['label'] ?? '',
					    'mobile-hidden' => get_sub_field('mobile-hidden') ?? ''
				    );
			    }
		    endwhile;
	    endif;


        return array(
            'filters' => $filters,
            'table_columns' => $table_columns,
        );
    }

}
