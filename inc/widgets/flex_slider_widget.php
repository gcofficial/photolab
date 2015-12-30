<?php

add_action('widgets_init', array('FlexSliderWidget', 'register'));

class FlexSliderWidget extends WP_Widget{

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'flex_slider_widget',
			__('Flex slider widget', 'photolab'),
			array('description' => __('Flex Slider Widget', 'photolab')) 
		);

		// ==============================================================
		// Add scripts
		// ==============================================================

		wp_enqueue_script( 
			'flex-slider', 
			get_template_directory_uri().'/js/jquery.flexslider-min.js', 
			array('jquery')
		);

		wp_enqueue_script( 
			'flex-slider-widget', 
			get_template_directory_uri().'/js/flex-slider-widget.js', 
			array('jquery')
		);

		// ==============================================================
		// Add styles
		// ==============================================================
		
		wp_enqueue_style(
			'flex-slider',
			get_template_directory_uri().'/css/flexslider.css'
		);
	}

	/**
	 * Register me
	 */
	public static function register()
	{
		register_widget( 'FlexSliderWidget' );
	}

	/**
	 * Get posts with thumbnails
	 * @param  $post_ids - include post ids
	 * @param  $category - category id
	 * @return array --- posts with thumbnails $post->image
	 */
	public function getPosts($post_ids, $category)
	{
		$posts = get_posts( 
			array(
				'numberposts'     => -1,
				'include'         => $post_ids,
				'category'        => $category,
				'post_type'       => 'post',
				'post_status'     => 'publish'
			) 
		);

		if(count($posts))
		{
			foreach ($posts as &$p) 
			{
				if(has_post_thumbnail( $p->ID ))
				{
					$thumb = wp_get_attachment_image_src( 
						get_post_thumbnail_id($p->ID), 
						'medium' 
					);
					$p->image = $thumb[0];
				}

				if(trim($p->image) == '')
				{
					$p->image = 'http://placehold.it/300x300';
				}
			}
		}
		return $posts;
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
		$posts = $this->getPosts(
			Tools::tryGet('post_ids', $instance),
			Tools::tryGet('category', $instance)
		);

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) 
		{
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		echo Tools::renderView(
			'flex_slider', 
			array('posts' => $posts)
		);
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
			'flex_slider_widget',
			array(
				'obj'          => $this,
				'title'        => Tools::tryGet('title', $instance),
				'post_ids'     => Tools::tryGet('post_ids', $instance),
				'category'     => Tools::tryGet('category', $instance),
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
	public function update( $new_instance, $old_instance ) {
		$instance                 = array();
		$instance['title']        = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['post_ids'] 	  = esc_attr( $new_instance['post_ids'] );
		$instance['category'] 	  = esc_attr( $new_instance['category'] );

		return $instance;
	}

}