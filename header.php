<!DOCTYPE html>
<html>
    <head>
	<title><?php wp_title(); ?> <?php bloginfo( 'name' ); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf8" />
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,400,300,700" rel="stylesheet" media="screen">
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" media="screen">
	<link href="<?php bloginfo( 'template_directory' ); ?>/css/bootstrap.css" rel="stylesheet" media="screen">
	<link href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" rel="stylesheet" media="screen, projection" />
	
	<!-- Tabzilla -->
	<link rel="stylesheet" type="text/css" href="css/tabzilla.css" media="screen" />
	
	<?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>

	<header id="main-header">
		<div class="container">
			<nav class="navbar navbar-default" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo home_url(); ?>"><span class="small"><?php _e( 'Community', 'wp-mozilla' ); ?></span><span class="community"><?php echo get_bloginfo( 'name' ); ?></span></a>
				</div>
				<div id="tabzilla">
					<a href="https://www.mozilla.org/">Mozilla</a>
				</div>
				<div class="top-menu">
					<?php wp_nav_menu( array( 'menu' => 'Top menu', 'menu_class' => 'nav navbar-nav navbar-right', 'depth' => 3, 'container' => false, 'walker' => new Bootstrap_Walker_Nav_Menu ) ); ?>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse main-menu">
					<?php wp_nav_menu( array( 'menu' => 'Main', 'menu_class' => 'nav navbar-nav navbar-right', 'depth' => 3, 'container' => false, 'walker' => new Bootstrap_Walker_Nav_Menu ) ); ?>
				</div> <!--/.navbar-collapse -->
			</nav>
		</div>
	</header>

	<div id="main-container" class="container">

	    <?php bootstrapwp_breadcrumbs(); ?>
