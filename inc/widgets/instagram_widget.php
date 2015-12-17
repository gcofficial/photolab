<?php

add_action('widgets_init', array(InstagramWidget, 'register'));

class InstagramWidget extends WP_Widget{

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'instagarm_widget',
			__('Instagram widget', 'photolab'),
			array('description' => __('Instagram recent photos Widget', 'photolab')) 
		);
	}

	/**
	 * Register me
	 */
	public static function register()
	{
		register_widget( 'InstagramWidget' );
	}

	/**
	 * Get user id by user name
	 * @param  string $user_name --- user name
	 * @param  string $client_id --- client id
	 * @return integer --- user id
	 */
	public function getUserID($user_name, $client_id = '1515b124cf42481db64cacfb96132345')
	{
		$user_name = trim($user_name);
		$client_id = trim($client_id);

		if($user_name == '' || $client_id == '') return 0;
		$result = 0;
		$query  = sprintf(
			'https://api.instagram.com/v1/users/search?q=%s&client_id=%s',
			$user_name, 
			$client_id
		);
		$request = (array) json_decode(@file_get_contents($query), true);
		
		if(array_key_exists('data', $request))
		{
			if(is_array($request['data']))
				$result = (int) $request['data'][0]['id'];
		}

		return $result;
	}

	/**
	 * Get posts with thumbnails
	 * @param  integer $number_posts --- number posts
	 * @param  string $post_types --- post type
	 * @return array --- posts with thumbnails $post->image
	 */
	public function getPostsWithImages($id = '189003872', $client_id = '1515b124cf42481db64cacfb96132345', $number_posts = 1)
	{
		if($id == 0) return array();
		$query   = sprintf(
			'https://api.instagram.com/v1/users/%s/media/recent/?client_id=%s&count=%d',
			$id,
			$client_id,
			$number_posts
		);

		$request = @file_get_contents($query);

		return json_decode($request, true);
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
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) 
	{
		$number_posts = $this->getNumberPosts($instance['number_posts']);
		$user_id      = $this->getUserID($instance['user'], $instance['client_id']);
		$images       = $this->getPostsWithImages($user_id, $instance['client_id'], $number_posts);

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) 
		{
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		echo Tools::renderView('instagram_list', array('images' => $images));
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
		$title        = $instance['title'];
		$user         = $instance['user'];
		$number_posts = $instance['number_posts'];
		$client_id    = $instance['client_id'];

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'photolab' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'user' ); ?>"><?php _e( 'User name:', 'photolab' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'user' ); ?>" name="<?php echo $this->get_field_name( 'user' ); ?>" type="text" value="<?php echo esc_attr( $user ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number_posts' ); ?>"><?php _e( 'Number posts:', 'photolab' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'number_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_posts' ); ?>" type="text" value="<?php echo esc_attr( $number_posts ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'client_id' ); ?>"><?php _e( 'Client id:', 'photolab' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'client_id' ); ?>" name="<?php echo $this->get_field_name( 'client_id' ); ?>" type="text" value="<?php echo esc_attr( $client_id ); ?>">
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
	public function update( $new_instance, $old_instance ) 
	{
		$instance                 = array();
		$instance['title']        = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['user']         = esc_attr( $new_instance['user'] );
		$instance['number_posts'] = (int) $new_instance['number_posts'];
		$instance['client_id']    = esc_attr( $new_instance['client_id'] );

		return $instance;
	}

}