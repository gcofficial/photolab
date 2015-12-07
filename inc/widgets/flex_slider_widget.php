<?php

add_action('widgets_init', array(FlexSliderWidget, 'register'));

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
	 * Get post type from saved options
	 * @param  string $post_types --- potential post type
	 * @return string --- post type
	 */
	public function getPostType($post_types)
	{
		return $post_types == 'none' ? 'post' : $post_types;
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
	 * @param  string $post_types --- post type
	 * @return array --- posts with thumbnails $post->image
	 */
	public function getPostsWithImages($number_posts, $post_types)
	{
		$posts = get_posts( 
			array(
				'numberposts'     => $number_posts,
				'post_type'       => $post_types,
				'post_status'     => 'publish',
				'meta_key'        => '_thumbnail_id'
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
		$post_types   = $this->getPostType($instance['post_types']);
		$number_posts = $this->getNumberPosts($instance['number_posts']);
		
		$posts = $this->getPostsWithImages(
			$this->getNumberPosts($instance['number_posts']), 
			$this->getPostType($instance['post_types'])
		);

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) 
		{
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		echo Tools::renderView('flex_slider', array('posts' => $posts));
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
		$post_types = get_post_types();
		$post_types = Tools::removeKeys(
			array('attachment', 'revision', 'nav_menu_item'), 
			$post_types
		);

		$post_types = array_merge(
			array('none' => __('Select post type', 'photolab')), 
			$post_types
		);

		$title        = $instance['title'];
		$number_posts = $instance['number_posts'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'photolab' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_types' ); ?>"><?php _e( 'Post type:', 'photolab' ); ?></label> 
			<?php echo Tools::renderSelectControl(
				$post_types,
				array(
					'name'  => $this->get_field_name( 'post_types' ),
					'id'    => $this->get_field_id( 'post_types' ),
					'class' => 'widefat'
				)
			); 
			?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number_posts' ); ?>"><?php _e( 'Number posts:', 'photolab' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'number_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_posts' ); ?>" type="text" value="<?php echo esc_attr( $number_posts ); ?>">
		</p>
		<?php 
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
		$instance['number_posts'] = (int) $new_instance['number_posts'];
		$instance['post_types']   = esc_attr( $new_instance['post_types'] );

		return $instance;
	}

}