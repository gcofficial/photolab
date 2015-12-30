<?php

add_action('widgets_init', array('AdvertisementWidget', 'register'));

class AdvertisementWidget extends WP_Widget{

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'advertisement_widget',
			__('Advertisement widget', 'photolab'),
			array('description' => __('Advertisement Widget', 'photolab')) 
		);

		// ==============================================================
		// Image sizes
		// ==============================================================
		add_image_size( 'advertisement', 300, 250, true );

		// ==============================================================
		// Actions
		// ==============================================================
		add_action('admin_enqueue_scripts', array($this, 'uploadScripts'));
		add_action('customize_controls_enqueue_scripts', array($this, 'uploadScripts'));

		// ==============================================================
		// Filters
		// ==============================================================
		add_filter('image_size_names_choose', array($this, 'addImageSize'));
		
	}

	/**
	 * Filter add advertisement image size
	 * @param array $sizes --- image sizes
	 */
	public function addImageSize($sizes)
	{
		return array_merge(
			$sizes, 
			array('advertisement' => __('Advertisement', 'photolab'))
		);
	}

	/**
	 * Upload some scripts to admin and customize
	 */
	public function uploadScripts()
	{
		wp_enqueue_media();
        wp_enqueue_script(
        	'upload_media_widget', 
        	get_template_directory_uri().'/js/advertisement.js', 
        	array('jquery')
        );
	}

	/**
	 * Register me
	 */
	public static function register()
	{
		register_widget( 'AdvertisementWidget' );
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
		$image = $instance['image'];

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) 
		{
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		echo Tools::renderView('advertisement', array('image' => $image));
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
			'advertisement_widget', 
			array(
				'obj'   => $this,
				'title' => Tools::tryGet('title', $instance, __('Widget Image', 'photolab')),
				'image' => Tools::tryGet('image', $instance, '')
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
		$instance['image'] = $new_instance['image'];

		return $instance;
	}

}