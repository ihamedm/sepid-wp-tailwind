    </div><!--#sepid-main-->

    <?php use Sepid\Helper;

    do_action('sepid_before_site_footer');?>

    <?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {?>
        <footer id="sepid-footer" class="">
            <?php do_action('sepid_site_footer_start'); ?>


            <div class="container">

	            <?php

	            wp_nav_menu(array(
		            'theme_location'       => 'footer',
		            'container'            => 'nav',
		            'container_id'         => 'footer-nav',
		            'container_class'      => '',
		            'menu_class'           => 'spd-nav spd-nav-h',
		            'menu_id'              => '',
		            'before'               => '',
		            'after'                => '',
		            'link_before'          => '',
		            'link_after'           => '',
		            'depth'                => 0,
		            'walker'               => '',
	            ));
	            ?>


                <div class="copyright">
                    <?php
                    $cp = get_field('copyright', 'option');
                    printf('<a href="%s" target="%s">%s</a>', $cp['url'], $cp['target'], $cp['title']);?>
                </div>
            </div>



            <?php do_action('sepid_site_footer_end'); ?>
        </footer>
    <?php } ?>

    <?php do_action('sepid_after_site_footer'); ?>

</div><!--#sepid-wrapper-->

<?php wp_footer();?>
</body>
</html>