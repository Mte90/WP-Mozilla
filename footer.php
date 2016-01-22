<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hursty_Theme
 */
?>

<footer id="colophon" class="site-footer" role="contentinfo">

    <div class="container">
	<div class="row">
	    <div class="col-md-8">
		<?php if ( has_nav_menu( 'footer-menu', 'bootstrapwp' ) ) { ?>
			<nav role="navigation">
			    <?php
			    wp_nav_menu( array(
				'container' => '',
				'menu_class' => 'footer-menu',
				'theme_location' => 'footer-menu'
				    )
			    );
			    ?>
			</nav>
		<?php } ?>
	    </div>
	    <div class="col-md-4">
                <p class="copyright">&copy; <?php _e( 'Copyright', 'bootstrapwp' ); ?> <?php echo date( 'Y' ); ?> - <a href="<?php echo home_url(); ?>/" title="<?php bloginfo( 'name' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            </div>
	</div> <!-- .row -->
    </div> <!-- /.container -->

</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
