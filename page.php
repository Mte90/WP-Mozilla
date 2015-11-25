<?php get_header(); ?>
			<div id="content" class="clearfix row">
				<div id="main" class="col-sm-8 panel panel-default clearfix" role="main">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						<header>
							<h2 class="page-title" itemprop="headline"><?php the_title(); ?></h2>
						</header> 
						<section class="post_content clearfix" itemprop="articleBody">
							<?php the_content(); ?>
						</section>
						<footer>
							<?php the_tags('<p class="tags"><span class="tags-title">' . __("Tags","wpbootstrap") . ':</span> ', ', ', '</p>'); ?>
						</footer> 
					</article> 
					<?php comments_template('',true); ?>
					<?php endwhile; ?>
					<?php else : ?>
					<article id="post-not-found">
					    <header>
					    	<h1><?php _e("Not Found", "wpbootstrap"); ?></h1>
					    </header>
					    <section class="post_content">
					    	<p><?php _e("Sorry, but the requested resource was not found on this site.", "wpbootstrap"); ?></p>
					    </section>
					    <footer>
					    </footer>
					</article>
					<?php endif; ?>
				</div>
				<?php get_sidebar(); // sidebar 1 ?>
			</div>
<?php get_footer(); ?> 
