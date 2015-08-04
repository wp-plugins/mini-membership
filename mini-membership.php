<?php
/*
Plugin Name: Mini Membership
Plugin URI: http://increasy.com
Description: Give subscribers private content read access and turn your WordPress site into a mini membership site.Just ask visitors to register as Subscriber to read Private Content, or call it Members Only Content.This plugin also blocks dashboard access for subscribers(even if they try /wp-admin/), hides admin bar from front end and adds an optional widget to let people register, log in and log out of your site.No fancy settings or features, just activate and have a mini membership site to attract more subscribers.
Author: Kumar Abhisek
Author URI: http://increasy.com
Version: 1.0.6
License: GPLv2

 Copyright 2014 Kumar Abhisek (email:meabhi[at]outlook dot com)
 
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License version 2,
 as published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 GNU General Public License for more details.
 
 The license for this software can likely be found here:
 http://www.gnu.org/licenses/gpl-2.0.html

*/


add_filter( 'show_admin_bar', 'mm_hide_admin_bar_from_front_end' );

    function mm_hide_admin_bar_from_front_end(){
               remove_action( 'wp_head', '_admin_bar_bump_cb' );
               return false;
    }

add_action( 'init', 'mm_block_dashboard_access' );

    function mm_block_dashboard_access() {

            if ( is_admin() && ! current_user_can( 'edit_posts' ) ) {
                    wp_redirect( home_url() );
                    exit;
            }
    }
register_activation_hook( __FILE__, 'mini_membership_activate' );
function mini_membership_activate() {     
 $subRole = get_role( 'subscriber' );
 $subRole->add_cap( 'read_private_posts' );
 $subRole->add_cap( 'read_private_pages' );
}
register_deactivation_hook( __FILE__, 'mini_membership_deactivate' );
function mini_membership_deactivate() {
 $subRole = get_role( 'subscriber' );
 $subRole->remove_cap( 'read_private_posts' );
 $subRole->remove_cap( 'read_private_pages' );
} 

//Mini Membership Shortcode Begin
add_shortcode('minimembership', 'mm_shortcode');
add_filter('widget_text', 'do_shortcode');

function mm_shortcode( $atts, $content = null ) {
    return  '<p class="mmsc"> '. $content .' <a href="'.site_url('wp-login.php?action=register').'" class="mmcta"> Register Now</a></p>';
}    