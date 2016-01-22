<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hursty_Theme
 */
if ( !is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<aside id="secondary" class="widget-area col-md-3" role="complementary">
    <div class="well">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>    
    </div>

</aside><!-- #secondary -->

    </div> <!-- /.row -->
</div> <!-- /.container -->