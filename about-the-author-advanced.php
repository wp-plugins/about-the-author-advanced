<?php
/**********************************************************************************************
* Plugin Name: About the Author Advanced
* Plugin URI: http://www.drzdigital.com/
* Description: This plugin creates a sidebar widget which displays the post/page author's information in a highly configurable way.
* Version: 0.2.3
* Author: Dan Zaniewski
* Author URI: http://drzdigital.com/wordpress-plugins/about-the-author-advanced/
* License: GPL2
*
* Copyright (C) 2012 Dan Zaniewski
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program. If not, see <http://www.gnu.org/licenses/>.
*
* @link http://drzdigital.com/wordpress-plugins/about-the-author-advanced/
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
***********************************************************************************************/




$plugin_version = "0.2.3";


// Basic globals	
if (!defined('ATAA_THEME_DIR'))
    define('ATAA_THEME_DIR', ABSPATH . 'wp-content/themes/' . get_template());

if (!defined('ATAA_PLUGIN_NAME'))
    define('ATAA_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('ATAA_PLUGIN_DIR'))
    define('ATAA_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . ATAA_PLUGIN_NAME);

if (!defined('ATAA_PLUGIN_URL'))
    define('ATAA_PLUGIN_URL', WP_PLUGIN_URL . '/' . ATAA_PLUGIN_NAME);
	
	
	
// Define the plugin version for future update use.	
if (!defined('ATAA_VERSION_NUM'))
    define('ATAA_VERSION_NUM', $plugin_version);
add_option(ataa_version_key, ATAA_VERSION_NUM);


if (get_option('ataa_version_key') != $plugin_version) {
	    // Execute your upgrade logic here

	    // Then update the version value
    update_option('ataa_version_key', $plugin_version);
}
	


	
function requires_wordpress_version() {
	global $wp_version;
	$plugin = plugin_basename( __FILE__ );
	$plugin_data = get_plugin_data( __FILE__, false );

	if ( version_compare($wp_version, "3", "<" ) ) {
		if( is_plugin_active(ATAA_PLUGIN_NAME) ) {
			deactivate_plugins( ATAA_PLUGIN_NAME );
			wp_die( "'".ATAA_PLUGIN_NAME."' requires WordPress 3.0 or higher, and has been deactivated! Please upgrade WordPress and try again.<br /><br />Back to <a href='".admin_url()."'>WordPress admin</a>." );
		}
	}
}
add_action( 'admin_init', 'requires_wordpress_version' );
	
	

global $wpdb;	


// Set-up Action and Filter Hooks
register_activation_hook(__FILE__, 'ataa_add_defaults');
register_uninstall_hook(__FILE__, 'ataa_delete_plugin_options');
add_action('admin_init', 'ataa_init' );


	
function ataa_init(){
	register_setting( 'ataa_plugin_options', 'ataa_options' );
	register_setting( 'ataa_plugin_options', 'ataa_version_key' );
}	

function ataa_add_defaults(){
	$tmp = get_option('ataa_options');
    if(($tmp['chk_default_options_db']=='1')||(!is_array($tmp))) {
		delete_option('ataa_options'); // so we don't have to reset all the 'off' checkboxes too! (don't think this is needed but leave for now)
		$arr = array(	"ataa_phone" => "1",
				"twitter" => "1",
				"facebook" => "1",
				"show_gravatar" => "1",
				"show_email" => "1",
				"show_twitter" => "1",
				"show_facebook" => "1",
				"show_gplus"=> "0",
				"display_name" => "1",
				"css" => "1",
				"gravatar_align" => "left",
				"gravatar_size" => "48",
				"social_text" => "Follow me",
				"display_admin" => "1",
				"phone_label" => "Phone: ",
				"email_label" => "Email: ",
				"web_label" => "Web: "
		);
		update_option('ataa_options', $arr);
	}	
	add_filter( 'user_contactmethods', 'ataa_default_contactmethods' );  
}

function ataa_default_contactmethods( $contactmethods ) {		
			$options = get_option('ataa_options');
			if($options['phone']){ $contactmethods['phone'] = 'Phone' ; }else{ unset($contactmethods['phone']);}
			if($options['twitter']){ $contactmethods['twitter'] = 'Twitter' ; }else{ unset($contactmethods['twitter']);}
			if($options['facebook']){ $contactmethods['facebook'] = 'Facebook' ; }else{ unset($contactmethods['facebook']);}
			if($options['gplus']){ $contactmethods['gplus'] = 'Google+' ; }else{ unset($contactmethods['gplus']);}
			unset($contactmethods['jabber']);	
	return $contactmethods;
}

function ataa_delete_plugin_options(){
	delete_option('ataa_options');
}



function our_plugin_action_links($links, $file) {
    static $this_plugin;
 
    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    } 
    // check to make sure we are on the correct plugin
    if ($file == $this_plugin) {

			$settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=ataa-settings">Settings</a>';
			$donate_link = '<a href="http://tinyurl.com/about-author-advanced" target="_blank">Donate</a>';
			
			array_push($links, $settings_link);
			array_push($links, $donate_link);			
	}
	return $links;
}
add_filter('plugin_row_meta', 'our_plugin_action_links', 10, 2);







//if ( is_admin() && current_user_can( 'edit_users' ) ){
if ( is_admin() ){
	require_once dirname( __FILE__ ) . '/classes/edit-options.php';	
}

require_once dirname(__FILE__) . '/classes/ataa-widget.php';



if (class_exists("Ataa_Widget")) {
        $ataa_plugin_widget = new Ataa_Widget();
		if (isset($ataa_plugin_widget)) {
			add_action( 'widgets_init', 'ataa_widget_init' );
		}
}

function ataa_widget_init(){
	register_widget( 'Ataa_Widget' );
	$options = get_option('ataa_options');	
	
	if($options['css']){
		wp_register_style('ataa.css', ATAA_PLUGIN_URL . '/css/ataa.css?t=' . time());
		wp_enqueue_style('ataa.css');
	}	
}

	



?>
