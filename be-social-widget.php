<?php
/**
 * Plugin Name: BE Social Widget
 * Description: This allows you to link to your social profiles like Twitter and Facebook
 * Plugin URI:  https://github.com/billerickson/BE-Social-Widget/
 * Version:     1.0.0
 * Author:      Bill Erickson
 * Author UR:   http://www.billerickson.net
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2, as published by the
 * Free Software Foundation.  You may NOT assume that you can use any other
 * version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.
 *
 * @package    BESocialWidget
 * @since      1.0.0
 * @copyright  Copyright (c) 2014, Bill Erickson
 * @license    GPL-2.0+
 */

/**
 * Enqueue Icon Font
 *
 */
function be_social_widget_icons() {
	wp_enqueue_style( 'be-social-widget', plugins_url( '/icons/style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'be_social_widget_icons' );

/**
 * Social Widget
 *
 * @since 1.0.0
 */
class BE_Social_Widget extends WP_Widget {

	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $defaults;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		// widget defaults
		$this->defaults = array(
			'title'    => '',
			'twitter'  => '',
			'facebook' => '',
			'gplus'    => '',
			'linkedin' => '',
			'youtube'  => '',
			'rss'      => '',
		);
		
		// Socials
		$this->socials = apply_filters( 'be_social_widget_order', array(
			'twitter'  => 'Twitter URL',
			'facebook' => 'Facebook URL',
			'gplus'    => 'Google Plus URL',
			'linkedin' => 'LinkedIn URL',
			'youtube'  => 'Youtube URL',
			'rss'      => 'RSS URL',
		) );

		// widget basics
		$widget_ops = array(
			'classname'   => 'be-social-widget',
			'description' => 'Links to social sites.'
		);

		// widget controls
		$control_ops = array(
			'id_base' => 'be-social-widget',
			//'width'   => '400',
		);

		// load widget
		$this->WP_Widget( 'be-social-widget', 'Social Widget', $widget_ops, $control_ops );

	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @since 1.0.0
	 * @param array $args An array of standard parameters for widgets in this theme 
	 * @param array $instance An array of settings for this widget instance 
	 */
	function widget( $args, $instance ) {

		extract( $args );

		// Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $before_widget;

		if ( !empty( $instance['title'] ) ) { 
			echo $before_title . $instance['title'] . $after_title;
		}

		echo '<p class="socials">';
		foreach( $this->socials as $social => $title ) {
			$url = esc_url( $instance[$social] );
			if( $url )
				echo '<a href="' . $url . '"><i class="be-social-' . $social . '"></i></a> ';
		}
		echo '</p>';

		echo $after_widget;
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 *
	 * @since 1.0.0
	 * @param array $new_instance An array of new settings as submitted by the admin
	 * @param array $old_instance An array of the previous settings 
	 * @return array The validated and (if necessary) amended settings
	 */
	function update( $new_instance, $old_instance ) {

		$new_instance['title'] = strip_tags( $new_instance['title'] );
		foreach( $this->socials as $social => $title ) {
			$new_instance[$social] = esc_url( $new_instance[$social] );
		}

		return $new_instance;
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 *
	 * @since 1.0.0
	 * @param array $instance An array of the current settings for this widget
	 */
	function form( $instance ) {

		// Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		
		echo '<p>
			<label for="' . $this->get_field_id( 'title' ) . '">Title:</label>
			<input type="text" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . esc_attr( $instance['title'] ) . '" class="widefat" />
			</p>';
			
		foreach( $this->socials as $social => $title ) {
			echo '<p>
				<label for="' . $this->get_field_id( $social ) . '">' . $title . ':</label>
				<input type="text" id="' . $this->get_field_id( $social ) . '" name="' . $this->get_field_name( $social ) . '" value="' . esc_attr( $instance[$social] ) . '" class="widefat" />
				</p>';
		}

	}
}
add_action( 'widgets_init', create_function( '', "register_widget('BE_Social_Widget');" ) );
