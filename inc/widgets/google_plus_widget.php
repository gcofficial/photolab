<?php

add_action('widgets_init', array('GooglePlusWidget', 'register'));

class GooglePlusWidget extends WP_Widget{

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'google_plus_widget',
			__('Google plus widget', 'photolab'),
			array('description' => __('Google plus Widget', 'photolab')) 
		);
	}

	/**
	 * Register me
	 */
	public static function register()
	{
		register_widget( 'GooglePlusWidget' );
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) 
	{
		$page_id = $instance['page_id'];

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) 
		{
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		echo Tools::renderView('google_plus', array('page_id' => $page_id));
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		echo Tools::renderView(
			'google_plus_widget',
			array(
				'obj'     => $this,
				'title'   => Tools::tryGet('title', $instance),
				'page_id' => Tools::tryGet('page_id', $instance),
			)
		);
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) 
	{
		$instance            = array();
		$instance['title']   = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['page_id'] = $new_instance['page_id'];

		return $instance;
	}

}