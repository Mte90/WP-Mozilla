<?php
/**
 * Hursty Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Hursty_Theme
 */
if ( !function_exists( 'hursty_wp_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function hursty_wp_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Hursty Theme, use a find and replace
		 * to change 'hursty-wp' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'hursty-wp', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
		    'primary' => esc_html__( 'Primary', 'hursty-wp' ),
		) );

		// Footer Menu
		register_nav_menus( array(
		    'footer-menu' => esc_html__( 'Footer Menu', 'hursty-wp' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
		    'search-form',
		    'comment-form',
		    'comment-list',
		    'gallery',
		    'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
		    'aside',
		    'image',
		    'video',
		    'quote',
		    'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'hursty_wp_custom_background_args', array(
		    'default-color' => 'ffffff',
		    'default-image' => '',
		) ) );
	}

endif;
add_action( 'after_setup_theme', 'hursty_wp_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function hursty_wp_content_width() {
	$GLOBALS[ 'content_width' ] = apply_filters( 'hursty_wp_content_width', 640 );
}

add_action( 'after_setup_theme', 'hursty_wp_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hursty_wp_widgets_init() {
	register_sidebar( array(
	    'name' => esc_html__( 'Sidebar', 'hursty-wp' ),
	    'id' => 'sidebar-1',
	    'description' => '',
	    'before_widget' => '<section id="%1$s" class="widget %2$s">'."\n",
	    'after_widget' => '</section>'."\n",
	    'before_title' => '<h4 class="widget-title">',
	    'after_title' => '</h4>'."\n",
	) );
}

add_action( 'widgets_init', 'hursty_wp_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function hursty_wp_scripts() {

	// Bootstrap Styles
	wp_enqueue_style( 'bootstrap-styles', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.3.6', 'all' );

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.5.0', 'all' );

	wp_enqueue_style( 'hursty-wp-style', get_stylesheet_uri() );

	// Bootstrap JS
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '3.3.6', 'all' );

	wp_enqueue_script( 'hursty-wp-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'hursty-wp-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'hursty_wp_scripts' );


/**
 * Add Respond.js for IE
 */
if ( !function_exists( 'ie_scripts' ) ) {

	function ie_scripts() {
		echo '<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->';
		echo '<!--[if lt IE 9]>';
		echo '<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>';
		echo '<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>';
		echo '<![endif]-->';
	}

	add_action( 'wp_head', 'ie_scripts' );
} // end if

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Bootstrap Nav Walker
 */
require get_template_directory() . '/inc/bootstrap-walker.php';

//WP-Mozilla custom code
if ( !function_exists( '_wp_render_title_tag' ) ) {

	function theme_slug_render_title() {
		?>
		<title><?php wp_title( '-', true, 'right' ); ?></title>
		<?php
	}

	add_action( 'wp_head', 'theme_slug_render_title' );
}
add_filter( 'comment_form_default_fields', 'bootstrap3_comment_form_fields' );

function bootstrap3_comment_form_fields( $fields ) {
	$commenter = wp_get_current_commenter();

	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html5 = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;

	$fields = array(
	    'author' => '<div class="form-group comment-form-author">' . '<label for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
	    '<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter[ 'comment_author' ] ) . '" size="30"' . $aria_req . ' /></div>',
	    'email' => '<div class="form-group comment-form-email"><label for="email">' . __( 'Email' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
	    '<input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter[ 'comment_author_email' ] ) . '" size="30"' . $aria_req . ' /></div>',
	    'url' => '<div class="form-group comment-form-url"><label for="url">' . __( 'Website' ) . '</label> ' .
	    '<input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter[ 'comment_author_url' ] ) . '" size="30" /></div>'
	);

	return $fields;
}

add_filter( 'comment_form_defaults', 'bootstrap3_comment_form' );

function bootstrap3_comment_form( $args ) {
	$args[ 'comment_field' ] = '<div class="form-group comment-form-comment">
                <label for="comment">' . _x( 'Comment', 'noun' ) . '</label> 
                <textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
            </div>';
	$args[ 'class_submit' ] = 'btn btn-default'; // since WP 4.1

	return $args;
}

add_action( 'comment_form', 'bootstrap3_comment_button' );

function bootstrap3_comment_button() {
	echo '<button class="btn btn-default" type="submit">' . __( 'Submit' ) . '</button>';
}
