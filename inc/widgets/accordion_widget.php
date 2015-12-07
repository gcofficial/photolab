<?php

add_action('widgets_init', array(AccordionWidget, 'register'));

class AccordionWidget extends WP_Widget{

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'accordion_widget',
			__('Accordion widget', 'photolab'),
			array('description' => __('Accordion Widget', 'photolab')) 
		);

		// ==============================================================
		// Add scripts
		// ==============================================================
		
		wp_enqueue_script( 
			'accordion-widget', 
			get_template_directory_uri().'/js/accordion-widget.js', 
			array('jquery')
		);

		// ==============================================================
		// Add styles
		// ==============================================================
		
		wp_enqueue_style(
			'accordion',
			get_template_directory_uri().'/css/accordion.css'
		);
	}

	/**
	 * Register me
	 */
	public static function register()
	{
		register_widget( 'AccordionWidget' );
	}

	/**
	 * Get number posts from saved options
	 * @param  mixed $number_posts --- potential number posts
	 * @return integer --- number posts
	 */
	public function getNumberPosts($number_posts)
	{
		$number_posts = (int) $number_posts;
		return $number_posts > 0 ? $number_posts : 1;
	}

	/**
	 * Get posts with thumbnails
	 * @param  integer $number_posts --- number posts
	 * @return array --- posts with thumbnails $post->image
	 */
	public function getPosts($number_posts = 1)
	{
		return get_posts( 
			array(
				'numberposts'     => $number_posts,
				'post_type'       => 'accordion_item',
				'post_status'     => 'publish'
			) 
		);
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
		$posts = $this->getPosts($this->getNumberPosts($instance['number_posts']));

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) 
		{
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		echo Tools::renderView('accordion', array('posts' => $posts));
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
			'accordion_widget',
			array(
				'obj'          => $this,
				'title'        => $instance['title'],
				'number_posts' => $instance['number_posts'],
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
		$instance                 = array();
		$instance['title']        = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['number_posts'] = (int) $new_instance['number_posts'];

		return $instance;
	}

}