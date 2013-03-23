<?php
/*
Plugin Name: Custom Toolbar
Plugin URI: http://www.my-dev.com/
Description: A custom toolbar.
Version: 1.0
Author: Ben Jones
Author URI: http://www.my-dev.com/
License: GPL2
*/

/* 
 * Remove the WordPress Logo from the WordPress Admin Bar 
 */  
function remove_wp_logo() {  
    global $wp_admin_bar;  
    $wp_admin_bar->remove_menu('wp-logo');  
}  
add_action( 'wp_before_admin_bar_render', 'remove_wp_logo' );


/**
 * Removes the "Howdy" item.
 *
 * @since 3.3.0
 */
function remove_howdy( $wp_admin_bar ) {
	$user_id      = get_current_user_id();
	$current_user = wp_get_current_user();
	$profile_url  = get_edit_profile_url( $user_id );

	if ( ! $user_id )
		return;

	$avatar = get_avatar( $user_id, 16 );
	$name  = sprintf( __('%1$s'), $current_user->display_name ) . '\'s Profile';
	$class  = empty( $avatar ) ? '' : 'with-avatar';

	$wp_admin_bar->add_menu( array(
		'id'        => 'my-account',
		'parent'    => 'top-secondary',
		'title'     => $name . $avatar,
		'href'      => $profile_url,
		'meta'      => array(
			'class'     => $class,
			'title'     => __('My Account'),
		),
	) );
}
add_action('admin_bar_menu', 'remove_howdy', 999);


/* Remove Unwanted Toolbar Items */
/* remove site name */
function custom_toolbar($wp_toolbar) {
	global $wp_admin_bar;
	/* ... code to go here ... */
	if ( !current_user_can( 'manage_options' ) ) { 
	$wp_toolbar->remove_node('site-name');
	}
	
	$wp_toolbar->remove_node('comments');
	
	$wp_toolbar->remove_node('new-content');
	
	$wp_toolbar->remove_node('search');	
	
	$wp_toolbar->remove_node('bp-login');
	
	$wp_toolbar->remove_node('bp-register');
	
	$wp_toolbar->remove_node('edit');
	
	$wp_toolbar->remove_node('bp-notifications');
	
	if ( is_user_logged_in() ) {
	
	$wp_toolbar->add_node(array(
	'id' => 'bp-notifications',
	'title' => __('<img src="' . plugins_url( '_inc/images/notifications.png' , __FILE__ ) . '" style="margin-top: 5px;"> '),
	'href'  => bp_loggedin_user_domain() .  bp_get_messages_slug() . '/notices/',
	/*'meta' => array('class' => 'notifications')*/
	));
	
	/*$wp_toolbar->add_node(array(
	'parent' => 'bp-notifications',
	'id' => ' Notices',
	'title' => $notifications,
	'href'  => bp_loggedin_user_domain() .  bp_get_messages_slug() . '/notices/',
	'meta' => 'echo count($notifications);'
	));*/
	
	$wp_toolbar->add_node(array(
	'id' => 'user-friends',
	'title' => __('<img src="' . plugins_url( '_inc/images/friends.png' , __FILE__ ) . '" style="margin-top: 5px;"> '),
	'href'  => bp_loggedin_user_domain() . bp_get_friends_slug() . '/requests/',
	/*'meta' => array('class' => 'menupop')*/
	) );
	
	$wp_toolbar->add_node(array(
	'parent' => 'user-friends',
	'id' => 'friend-requests',
	'title' => ' Friend Requests ',
	'href'  => bp_loggedin_user_domain() . bp_get_friends_slug() . '/requests/',
	'meta' => array('html' => '<span style="margin-left:50px; color: #4e75c1;">' . bp_friend_get_total_requests_count( bp_loggedin_user_id() ) . '</span>' )
	));
	
	$wp_toolbar->add_node(array(
	'id' => 'user-messages',
	'title' => __('<img src="' . plugins_url( '_inc/images/messages.png' , __FILE__ ) . '" style="margin-top: 5px;"> '),
	'href'  => bp_loggedin_user_domain() .  bp_get_messages_slug() . '/view/',
	/*'meta' => array('class' => 'menupop')*/
	) );
	
	$wp_toolbar->add_node(array(
	'parent' => 'user-messages',
	'id' => 'messages',
	'title' => ' Messages ',
	'href'  => bp_loggedin_user_domain() .  bp_get_messages_slug() . '/view/',
	'meta' => array('html' =>'<span style="margin-left:35px; color: #4e75c1;">' . bp_get_total_unread_messages_count( bp_loggedin_user_id() . '</span>' ) )
	));
	
	}
}
add_action('admin_bar_menu', 'custom_toolbar', 999);
?>
