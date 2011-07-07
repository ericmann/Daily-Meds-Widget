<?php
if ( ! class_exists('Daily_Meds_Widget') ) :
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

		// Get the feed
		$meditation = fetch_feed( "http://dailymedtoday.com/?s=meditation%20for&feed=rss2" );
		$med = array();

		if( is_wp_error( $meditation ) )
			return;

		$latest = $meditation->get_item();

		$med = array(
			'title' => esc_attr(strip_tags($latest->get_title())),
			'excerpt' => str_replace( array("\n", "\r"), ' ', esc_attr( strip_tags( @html_entity_decode( $latest->get_description(), ENT_QUOTES, get_option('blog_charset') ) ) ) ),
			'content' => str_replace( array("\n", "\r"), ' ', $latest->get_content() ),
			'link' => esc_url(strip_tags($latest->get_link()))
		);

		echo $before_widget;
		echo '<div class="inside">';
		echo '<div class="overflow">';
		echo '<span class="top"></span>';
		echo '<h2><a href="' . $med['link'] . '">' . $med['title'] . '</a></h2>';
		echo '<p>' . $med['content'] . '</p>';
		echo '<p class="credit">Powered by <a href="http://dailymedtoday.com">DailyMedToday.com</a></p>';
		echo '<span class="bottom"></span>';
		echo '</div>';
		echo '</div>';
		echo $after_widget;
	}
}
endif;
?>