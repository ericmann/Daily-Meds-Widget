<?php
/*
Plugin Name: Daily Meds Widget
Plugin URI: http://jumping-duck.com/wordpress
Description: Add a sidebar widget to display the latest meditation from www.DailyMedToday.com
Version: 1.0
Author: Eric Mann
Author URI: http://eamann.com
License: GPL3+
*/

/* Copyright 2011  Eric Mann, Jumping Duck Media
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 3 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

class Daily_Meds_Widget extends WP_Widget {
	function Daily_Meds_Widget() {
		$widget_ops = array(
			'classname' => 'widget_daily_meds',
			'description' => 'Add the latest meditation from DailyMedToday.com to your sidebar.'
		);

		$this->WP_Widget( false, 'Daily Meds Widget', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		//Check the cache first to see if it's hot
		$meditation = get_transient( 'latest_daily_med' );

		if( ! $meditation ) {
			include_once( ABSPATH . WPINC . '/rss-functions.php' );
			$fetched = fetch_rss( "http://dailymedtoday.com/?s=meditation%20for&feed=rss2" );

			if( $fetched ) {
				$items = array_slice($fetched->items, 0, 1);
				if( count($items) > 0 ) {
					$latest = $items[0];

					$med = array(
						'title' => $latest['title'],
						'excerpt' => $latest['description'],
						'content' => $latest['content'],
						'link' => $latest['link']
					);

					$meditation = serialize( $med );

					set_transient( 'latest_daily_med', $meditation, 21600 );
				}
			}
		} else {
			$med = unserialize( $meditation );
		}

		echo $before_widget;
		echo '<div class="inside">';
		echo '<div class="overflow">';
		echo '<span class="top"></span>';
		echo '<h2><a href="' . $med['link'] . '">' . $med['title'] . '</a></h2>';
		echo '<p>' . $med['content']['encoded'] . '</p>';
		echo '<p class="credit">Powered by <a href="http://dailymedtoday.com">DailyMedToday.com</a></p>';
		echo '<span class="bottom"></span>';
		echo '</div>';
		echo '</div>';
		echo $after_widget;
	}
}

function daily_meds_style() {
	wp_enqueue_style( 'daily-meds-style', WP_PLUGIN_URL . '/daily-meds-widget/daily-meds-style.php?base=' . WP_PLUGIN_URL . '/daily-meds-widget', '', '1.0' );
}

// register widget
add_action( 'widgets_init',    create_function('', 'return register_widget("Daily_Meds_Widget");') );
add_action( 'wp_print_styles', 'daily_meds_style' );
?>