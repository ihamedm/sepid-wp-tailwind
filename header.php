<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php wp_head(); ?>
    </head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="sepid-wrapper">
<?php do_action('sepid_before_site_header');?>

<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {?>
    <header id="sepid-header" class="">

        <?php do_action('sepid_site_header_start'); ?>

        <?php get_template_part( 'template-parts/header/header', 'main' );?>
        <?php
        if(is_home()){
	        $hero_data = get_field('hero', 'option');
	        get_template_part('template-parts/home/section', 'hero', array('section_data' => $hero_data));
        }?>

        <?php do_action('sepid_site_header_end'); ?>

    </header>
<?php } ?>
<?php do_action('
sepid_after_site_header'
); ?>

    <div class="sepid-main">