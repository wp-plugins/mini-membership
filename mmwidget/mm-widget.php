<?php
/*
Author: Kumar Abhisek
Author URI: http://increasy.com
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

class wp_mm_widget extends WP_Widget {

	// constructor
	function wp_mm_widget() {
      	$widget_ops = array('classname' => 'widget_mm', 'description' => __( 'Member Access Sidebar Widget', 'mm-widget' ) );
		$this->WP_Widget('mm_widget', __('Mini Membership Widget', 'mm-widget'), $widget_ops);
	}

	// widget form creation
	function form($instance) {	
	$instance = wp_parse_args(
			(array) $instance,
			array(
				'title' => '',
				'title_member' => '',
				'register_link' => 0,
				'inline' => 0
			)
		);
		$title = strip_tags($instance['title']);
		$title_member = strip_tags($instance['title_member']);
		$login_text = trim($instance['login_text']);
		$logout_text = trim($instance['logout_text']);
		$show_welcome_text = $instance['show_welcome_text'] ? 'checked="checked"' : '';
		$welcome_text = trim($instance['welcome_text']);
		$register_link = $instance['register_link'] ? 'checked="checked"' : '';
		$register_text = trim($instance['register_text']);
		$inline = $instance['inline'] ? 'checked="checked"' : '';
		
?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'mm-widget'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('title_member'); ?>"><?php _e('Title For Members', 'mm-widget'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title_member'); ?>" name="<?php echo $this->get_field_name('title_member'); ?>" type="text" value="<?php echo esc_attr($title_member); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('login_text'); ?>"><?php _e('Log in text', 'mm-widget'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('login_text'); ?>" name="<?php echo $this->get_field_name('login_text'); ?>" type="text" value="<?php echo esc_attr($login_text); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('logout_text'); ?>"><?php _e('Log out text', 'mm-widget'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('logout_text'); ?>" name="<?php echo $this->get_field_name('logout_text'); ?>" type="text" value="<?php echo esc_attr($logout_text); ?>" />
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php echo $show_welcome_text; ?> id="<?php echo $this->get_field_id('show_welcome_text'); ?>" name="<?php echo $this->get_field_name('show_welcome_text'); ?>" /> <label for="<?php echo $this->get_field_id('show_welcome_text'); ?>"><?php _e('Show Welcome text when member logs in', 'mm-widget'); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('welcome_text'); ?>"><?php _e('Welcome text (use [membername] to show the name of the member)', 'mm-widget'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('welcome_text'); ?>" name="<?php echo $this->get_field_name('welcome_text'); ?>" type="text" value="<?php echo esc_attr($welcome_text); ?>" />
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php echo $register_link; ?> id="<?php echo $this->get_field_id('register_link'); ?>" name="<?php echo $this->get_field_name('register_link'); ?>" /> <label for="<?php echo $this->get_field_id('register_link'); ?>"><?php _e('Show Register link (if registration allowed)', 'mm-widget'); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('register_text'); ?>"><?php _e('Register text', 'mm-widget'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('register_text'); ?>" name="<?php echo $this->get_field_name('register_text'); ?>" type="text" value="<?php echo esc_attr($register_text); ?>" />
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php echo $inline; ?> id="<?php echo $this->get_field_id('inline'); ?>" name="<?php echo $this->get_field_name('inline'); ?>" /> <label for="<?php echo $this->get_field_id('inline'); ?>"><?php _e('Inline (unchecked=list of links and checked= in one line)', 'mm-widget'); ?></label>
			</p>
<?php
	}

	// widget update
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$new_instance = wp_parse_args(
			(array) $new_instance,
			array(
				'title' => '',
				'title_member' => '',
				'register_link' => 0,
				'inline' => 0
			)
		);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['title_member'] = strip_tags($new_instance['title_member']);
		$instance['login_text'] = trim($new_instance['login_text']);
		$instance['logout_text'] = trim($new_instance['logout_text']);
		$instance['show_welcome_text'] = $new_instance['show_welcome_text'] ? 1 : 0;
		$instance['welcome_text'] = trim($new_instance['welcome_text']);
		$instance['register_link'] = $new_instance['register_link'] ? 1 : 0;
		$instance['register_text'] = trim($new_instance['register_text']);
		$instance['inline'] = $new_instance['inline'] ? 1 : 0;
		return $instance;
	}

	// widget display
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$title_member = apply_filters('widget_title', $instance['title_member']);
		$login_text = empty($instance['login_text']) ? __('Log in', 'mm-widget') : $instance['login_text'];
		$logout_text = empty($instance['logout_text']) ? __('Log out', 'mm-widget') : $instance['logout_text'];
		$show_welcome_text = $instance['show_welcome_text'] ? '1' : '0';
		$welcome_text = empty($instance['welcome_text']) ? __('Welcome [membername]', 'mm-widget') : $instance['welcome_text'];
		$register_link = $instance['register_link'] ? '1' : '0';
		$register_text = empty($instance['register_text']) ? __('Register', 'mm-widget') : $instance['register_text'];
		$inline = $instance['inline'] ? '1' : '0';
		
		echo $before_widget;
		if ( is_user_logged_in() ){
			echo $before_title . $title_member . $after_title;
		}else{
			echo $before_title . $title . $after_title;
		}
		if( $inline ){
			$wrap_before = '<p class="wrap_mm_widget">';
			$wrap_after = '</p>';
			$item_before = '<span class=';
			$item_after = '</span>';
			$split_char = ' | ';
		}else{
			$wrap_before = '<ul class="wrap_mm_widget">';
			$wrap_after = '</ul>';
			$item_before = '<li class=';
			$item_after = '</li>';
			$split_char = '';
		}
		echo $wrap_before."\n";
		if ( $show_welcome_text ){
			if ( is_user_logged_in() ){
				$current_user = wp_get_current_user();
				$membername = $current_user->display_name;
				$welcome_text_new = str_replace('[membername]', $membername, $welcome_text);
				echo $item_before.'"item_welcome">'.$welcome_text_new.$item_after.$split_char;
			}
		}
		echo $item_before;
		if ( ! is_user_logged_in() ){
			echo '"item_login">';
			echo '<a href="'.esc_url( wp_login_url($_SERVER['REQUEST_URI']) ).'">'.$login_text.'</a>';
		}else{
			echo '"item_logout">';
			echo '<a href="'.esc_url( wp_logout_url($_SERVER['REQUEST_URI']) ).'">'.$logout_text.'</a>';
		}
		echo $item_after;
		//wp_register();
		if( $register_link ){
			if ( ! is_user_logged_in() ) {
				if ( get_option('users_can_register') ){
					echo $split_char.$item_before.'"item_register">'.'<a href="'.site_url('wp-login.php?action=register', 'login').'">'.$register_text.'</a>'.$item_after;
				}
			}
		}
		
		echo "\n".$wrap_after."\n";
		
		echo $after_widget;
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("wp_mm_widget");'));

if ( ! function_exists( 'mm_widget_lang_init' ) ) :
	function mm_widget_lang_init() {
		load_plugin_textdomain('mini-membership', false, dirname( plugin_basename(__FILE__) ) . '/languages/');
	}
	add_action('init', 'mm_widget_lang_init');
endif;