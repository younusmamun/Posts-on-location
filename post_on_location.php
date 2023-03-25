<?php

/*
Plugin Name: Posts on location
Plugin URI: https://younusm.com/
Description: Word count for every post.
Version: 4.2.1
Author: younusmamun
Author URI: https://younusm.com/
License: GPLv2 or later
Text Domain: post-on-location
Domain Path: /languages/
*/

function test(){

}

function pol_load_textdomain(){
    load_plugin_textdomain('post-on-location',false,dirname(__FILE__)."/languages");
}
add_action("plugins_loaded","pol_load_textdomain");



//$user_ip =  '119.148.12.9' ; // For LocaHost Only
$user_ip =  $_SERVER['HTTP_CLIENT_IP'];
$user_data = wp_remote_get( "http://ip-api.com/json/".$user_ip."");
$user_json_data = $user_data['body'];
$user_data_object= json_decode($user_json_data);
$user_city = $user_data_object->country;



function my_modify_main_query( $query ) {
    if ( $query->is_home() && $query->is_main_query() ) { 
    global $user_city;
    $query->query_vars['category_name'] = $user_city;
    $query->query_vars['posts_per_page'] = 5; 
    }
}
add_action('pre_get_posts','my_modify_main_query');




function my_func_author_location($author){
    global $user_city;
    $author .= 'from'.$user_city;
    return $author;
}
add_filter('the_author','my_func_author_location');











