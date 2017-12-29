<?php
/**
 * @package remove-wordpress-comments
 * @version 0.1.0
 */

/*
  Plugin Name: Remove WordPress Comments
  Author: Ben Furfie
  Author URI: http://www.benfurfie.co.uk
  Version: 0.1.0
*/

defined('ABSPATH') or die('You cannot access this page directly.');

/**
 * Delete support for comments and trackbacks in post types
 * 
 * @since 0.1.0
 */

function bmf_disable_comments_post_types_support()
{
	$post_types = get_post_types();
    foreach ($post_types as $post_type)
    {
		if(post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
}
add_action('admin_init', 'bmf_disable_comments_post_types_support');

/**
 * Remove comments from menu
 * 
 * @since 0.1.0
 */

function bmf_disable_comments_admin_menu()
{
	remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'bmf_disable_comments_admin_menu');

/**
 * Redirect any user trying to access the comments page.
 * 
 * @since 0.1.0
 */

function bmf_disable_comments_admin_menu_redirect()
{
	global $pagenow;
    if ($pagenow === 'edit-comments.php')
    {
		wp_redirect(admin_url()); exit;
	}
}
add_action('admin_init', 'bmf_disable_comments_admin_menu_redirect');

/**
 * Remove the comments metabox from the dashboard
 * 
 * @since 0.1.0
 */

function bmf_disable_comments_dashboard()
{
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'bmf_disable_comments_dashboard');

/**
 * Remove comments link from admin bar
 * 
 * @since 0.1.0
 * @todo Link not being removed despite hook being correct. Need to investigate.
 */

function bmf_disable_comments_admin_bar()
{
    if (is_admin_bar_showing())
    {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
}
add_action('init', 'bmf_disable_comments_admin_bar');