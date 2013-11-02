<?php
/**
 * Plugin Name: Anime Fansub Manager
 * Description: Anime Fansub Manager for subbing groups
 * Version: 0.1
 * Author: okard
 * License: MIT License
 */
 
//Main File
 
define('AFMNG_PLUGINDIR', plugin_dir_path( __FILE__ ));
define('AFMNG_PLUGINFILE', __FILE__);
define('AFMNG_DEBUG', true);


//Libraries
include_once(AFMNG_PLUGINDIR.'/utils.php');
include_once(AFMNG_PLUGINDIR.'/database.php');
include_once(AFMNG_PLUGINDIR.'/ajax.php');
include_once(AFMNG_PLUGINDIR.'/LTemplate.php');

//Plugin Install/Deinstall Functions
include_once(AFMNG_PLUGINDIR.'/install.php');

//Include Menu Functions
include_once(AFMNG_PLUGINDIR.'/menu.php');

//Include Status Widget
include_once(AFMNG_PLUGINDIR.'/widget.php');

//Include Ajax API

/*
 
//to add capability to specific user
$user = new WP_User( $user_id );
$user->add_cap( 'can_edit_posts');

$current_user = wp_get_current_user();

$wpdb->$users 
http://codex.wordpress.org/Function_Reference/get_users

http://codex.wordpress.org/AJAX_in_Plugins

wp_insert_post

edit_post_link( $link, $before, $after, $id )
http://codex.wordpress.org/Function_Reference

wp_insert_post
   -> hook for additional url parsing?
      * page title and parent
   -> automacilly create project pages

admin_url() for new page

http://blog.wpessence.com/wordpress-admin-page-without-menu-item/

https://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts

post-new.php?post_type=page&post_title=test

*/

?>
