<?php
//Add thumbnail support
add_theme_support( 'post-thumbnails' );

//Add menu support and register main menu
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		    'main_menu' => 'Main Menu'
		)
	);
}

// filter the Gravity Forms button type
add_filter( "gform_submit_button", "form_submit_button", 10, 2 );

function form_submit_button( $button, $form ) {
	return "<button class='button btn' id='gform_submit_button_{$form[ "id" ]}'><span>{$form[ 'button' ][ 'text' ]}</span></button>";
}

// Register sidebar
if ( function_exists( 'register_sidebar' ) ) {
	register_sidebar( array(
	    'id' => 'sidebar-1',
	    'name' => 'Sidebar',
	    'class' => '',
	    'before_widget' => '<article id="%1$s" class="panel panel-info widget %2$s">' . "\n",
	    'after_widget' => '</section></article>' . "\n",
	    'before_title' => '<h4 class="panel-heading">' . "\n",
	    'after_title' => '</h4><section class="panel-content">' . "\n",
	) );
}

// Bootstrap_Walker_Nav_Menu setup

add_action( 'after_setup_theme', 'bootstrap_setup' );

if ( !function_exists( 'bootstrap_setup' ) ):

	function bootstrap_setup() {

		add_action( 'init', 'register_menu' );

		function register_menu() {
			register_nav_menu( 'top-bar', 'Bootstrap Top Menu' );
		}

		class Bootstrap_Walker_Nav_Menu extends Walker_Nav_Menu {

			function start_lvl( &$output, $depth = 0, $args = array() ) {

				$indent = str_repeat( "\t", $depth );
				$output .= "\n$indent<ul class=\"dropdown-menu\">\n";
			}

			function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

				$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

				$li_attributes = $class_names = $value = $item_output = '';

				$classes = empty( $item->classes ) ? array() : ( array ) $item->classes;
				$classes[] = !empty( $args->has_children ) ? 'dropdown' : '';
				$classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
				$classes[] = 'menu-item-' . $item->ID;
				if ( isset( $item->url ) ) {
					$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
					$class_names = ' class="' . esc_attr( $class_names ) . '"';

					$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
					$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

					$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

					$attributes = !empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
					$attributes .=!empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
					$attributes .=!empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
					$attributes .=!empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';
					$attributes .=!empty( $args->has_children ) ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

					$item_output = !empty( $args->before ) ? $args->before : '';
					$item_output .= '<a' . $attributes . '>';
					$item_output .=!empty( $args->link_before ) ? $args->link_before : '';
					$item_output .= apply_filters( 'the_title', $item->title, $item->ID );
					$item_output .=!empty( $args->link_after ) ? $args->link_adter : '';
					$item_output .=!empty( $args->has_children ) ? ' <b class="caret"></b></a>' : '</a>';
					$item_output .=!empty( $args->after );
				}
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}

			function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {

				if ( !$element ) {
					return;
				}

				$id_field = $this->db_fields[ 'id' ];

				//display this element
				if ( is_array( $args[ 0 ] ) ) {
					$args[ 0 ][ 'has_children' ] = !empty( $children_elements[ $element->$id_field ] );
				} else if ( is_object( $args[ 0 ] ) ) {
					$args[ 0 ]->has_children = !empty( $children_elements[ $element->$id_field ] );
				}
				$cb_args = array_merge( array( &$output, $element, $depth ), $args );
				call_user_func_array( array( &$this, 'start_el' ), $cb_args );

				$id = $element->$id_field;

				// descend only when the depth is right and there are childrens for this element
				if ( ($max_depth == 0 || $max_depth > $depth + 1 ) && isset( $children_elements[ $id ] ) ) {

					foreach ( $children_elements[ $id ] as $child ) {

						if ( !isset( $newlevel ) ) {
							$newlevel = true;
							//start the child delimiter
							$cb_args = array_merge( array( &$output, $depth ), $args );
							call_user_func_array( array( &$this, 'start_lvl' ), $cb_args );
						}
						$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
					}
					unset( $children_elements[ $id ] );
				}

				if ( isset( $newlevel ) && $newlevel ) {
					//end the child delimiter
					$cb_args = array_merge( array( &$output, $depth ), $args );
					call_user_func_array( array( &$this, 'end_lvl' ), $cb_args );
				}

				//end this element
				$cb_args = array_merge( array( &$output, $element, $depth ), $args );
				call_user_func_array( array( &$this, 'end_el' ), $cb_args );
			}

			function end_el( &$output, $item, $depth = 0, $args = array() ) {

				if ( isset( $item->url ) ) {
					$output .= "</li>\n";
				}
			}

		}

	}

endif;

//From https://github.com/rachelbaker/bootstrapwp-Twitter-Bootstrap-for-WordPress
function bootstrapwp_breadcrumbs() {
	$home = __( 'Home' ); // text for the 'Home' link
	$before = '<li class="active">'; // tag before the current crumb
	$sep = '';
	$after = '</li>'; // tag after the current crumb
	if ( !is_home() && !is_front_page() || is_paged() ) {
		echo '<div class="well well-light"><ul class="breadcrumb">';
		global $post;
		$homeLink = home_url();
		echo '<li><i class="fa fa-caret-square-o-right"></i>&nbsp;<a href="' . $homeLink . '">' . $home . '</a></li> ';
		if ( is_category() ) {
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$thisCat = $cat_obj->term_id;
			$thisCat = get_category( $thisCat );
			$parentCat = get_category( $thisCat->parent );
			if ( $thisCat->parent != 0 ) {
				echo get_category_parents( $parentCat, true, $sep );
			}
			echo $before . __( 'Archive by category' ) . ' "' . single_cat_title( '', false ) . '"' . $after;
		} elseif ( is_day() ) {
			echo '<li><a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time(
				'Y'
			) . '</a></li> ';
			echo '<li><a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time(
				'F'
			) . '</a></li> ';
			echo $before . get_the_time( 'd' ) . $after;
		} elseif ( is_month() ) {
			echo '<li><a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time(
				'Y'
			) . '</a></li> ';
			echo $before . get_the_time( 'F' ) . $after;
		} elseif ( is_year() ) {
			echo $before . get_the_time( 'Y' ) . $after;
		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object( get_post_type() );
				$slug = $post_type->rewrite;
				echo '<li><a href="' . $homeLink . '/' . $slug[ 'slug' ] . '/">' . $post_type->labels->singular_name . '</a></li> ';
				echo $before . get_the_title() . $after;
			} else {
				$cat = get_the_category();
				$cat = $cat[ 0 ];
				echo '<li>' . get_category_parents( $cat, true, $sep ) . '</li>';
				echo $before . get_the_title() . $after;
			}
		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object( get_post_type() );
			echo $before . $post_type->labels->singular_name . $after;
		} elseif ( is_attachment() ) {
			$parent = get_post( $post->post_parent );
			$cat = get_the_category( $parent->ID );
			$cat = $cat[ 0 ];
			echo get_category_parents( $cat, true, $sep );
			echo '<li><a href="' . get_permalink(
				$parent
			) . '">' . $parent->post_title . '</a></li> ';
			echo $before . get_the_title() . $after;
		} elseif ( is_page() && !$post->post_parent ) {
			echo $before . get_the_title() . $after;
		} elseif ( is_page() && $post->post_parent ) {
			$parent_id = $post->post_parent;
			$breadcrumbs = array();
			while ( $parent_id ) {
				$page = get_page( $parent_id );
				$breadcrumbs[] = '<li><a href="' . get_permalink( $page->ID ) . '">' . get_the_title(
						$page->ID
					) . '</a>' . $sep . '</li>';
				$parent_id = $page->post_parent;
			}
			$breadcrumbs = array_reverse( $breadcrumbs );
			foreach ( $breadcrumbs as $crumb ) {
				echo $crumb;
			}
			echo $before . get_the_title() . $after;
		} elseif ( is_search() ) {
			echo $before . __( 'Search results for' ) . ' "' . get_search_query() . '"' . $after;
		} elseif ( is_tag() ) {
			echo $before . __( 'Posts tagged' ) . ' "' . single_tag_title( '', false ) . '"' . $after;
		} elseif ( is_author() ) {
			global $author;
			$userdata = get_userdata( $author );
			echo $before . __( 'Articles posted by' ) . ' ' . $userdata->display_name . $after;
		} elseif ( is_404() ) {
			echo $before . __( 'Error 404' ) . $after;
		}
		echo '</ul></div>';
	}
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
	$args[ 'class_submit' ] = 'btn btn-primary'; // since WP 4.1

	return $args;
}

function bootstrapwp_comment( $comment, $args, $depth ) {
	$GLOBALS[ 'comment' ] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
			?>
			<li class="comment media" id="comment-<?php comment_ID(); ?>">
			    <div class="media-body">
				<p>
				    <?php _e( 'Pingback:' ); ?> <?php comment_author_link(); ?>
				</p>
			    </div>
			    <?php
			    break;
		    default :
			    // Proceed with normal comments.
			    global $post;
			    ?>

			<li class="comment media" id="li-comment-<?php comment_ID(); ?>">
			    <a href="<?php echo $comment->comment_author_url; ?>" class="pull-left">
				<?php echo get_avatar( $comment, 64 ); ?>
			    </a>
			    <div class="media-body">
				<h4 class="media-heading comment-author vcard">
				    <?php
				    printf( '<cite class="fn">%1$s %2$s</cite>', get_comment_author_link(),
					    // If current post author is also comment author, make it known visually.
					    ($comment->user_id === $post->post_author) ? '<span class="label"> ' . __(
							    'Post author'
						    ) . '</span> ' : ''  );
				    ?>
				</h4>

				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php
					    _e(
						    'Your comment is awaiting moderation.'
					    );
					    ?></p>
				<?php endif; ?>

				<?php comment_text(); ?>
				<p class="meta">
				    <?php
				    printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>', esc_url( get_comment_link( $comment->comment_ID ) ), get_comment_time( 'c' ), sprintf(
						    __( '%1$s at %2$s' ), get_comment_date(), get_comment_time()
					    )
				    );
				    ?>
				</p>
				<p class="reply">
				    <?php
				    comment_reply_link( array_merge( $args, array(
					'reply_text' => __( 'Reply <span>&darr;</span>' ),
					'depth' => $depth,
					'max_depth' => $args[ 'max_depth' ]
						    )
				    ) );
				    ?>
				</p>
			    </div>
			    <?php
			    break;
	    endswitch;
    }
    