<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Hursty_Theme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function hursty_wp_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'hursty_wp_body_classes' );

/**
 * Custom Read More Button
 */

function modify_read_more_link() {
    return '<p><a class="more-link btn btn-default" href="' . get_permalink() . '">Read More</a></p>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );

/**
 * Custom Edit Button
 */
function custom_edit_post_link($output) {

	$output = str_replace('class="post-edit-link"', 'class="post-edit-link btn btn-danger btn-xs"', $output);
	return $output;
}
add_filter('edit_post_link', 'custom_edit_post_link');