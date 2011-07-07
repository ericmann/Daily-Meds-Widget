<?php
if ( ! class_exists('Daily_Meds') ) :
/**
 * Contains primary functionality for the plugin.
 *
 * @package WordPress
 * @subpackage DailyMedsWidget
 * @since 1.0.2
 */
class Daily_Meds {
	public static function init() {
		// register widget
		add_action( 'widgets_init',                     array( 'Daily_Meds', 'register_widget' ) );
		add_action( 'wp_print_styles',                  array( 'Daily_Meds', 'enqueue_style' ) );

		add_filter( 'wp_feed_cache_transient_lifetime', array( 'Daily_Meds', 'duration_filter' ), 10, 2 );
	}

	public static function enqueue_style() {
		wp_enqueue_style( 'daily-meds-style', WP_PLUGIN_URL . '/daily-meds-widget/daily-meds-style.css', '', '1.0.1' );
	}

	public static function register_widget() {
		register_widget("Daily_Meds_Widget");
	}

	public static function duration_filter( $duration, $url ) {
		if( "http://dailymedtoday.com/?s=meditation%20for&feed=rss2" == $url ) {
			return 3600;
		}

		return $duration;
	}
}
endif;
?>