<?php get_header(); ?>
<div class="row">
    <div class="col-md-8 panel panel-default">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<h2>
			    <?php
			    if ( is_archive() ) {
				    echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
			    } else {
				    the_title();
			    }
			    ?>
			</h2>

			<?php the_content(); ?>
			<?php
			if ( is_archive() ) {
				wp_bootstrap_pagination();
			}
			?>

		<?php endwhile; ?>
	<?php else : ?>
		<div>
		    <strong>No content in this loop</strong>
		</div>
	<?php endif; ?>
    </div>
    <div class="col-md-4">
	<?php
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Sidebar' ) ) : //  Sidebar name

	endif;
	?>
    </div>
</div>
<?php get_footer(); ?>