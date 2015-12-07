<p>
	<label for="<?php echo $obj->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'photolab' ); ?></label> 
	<input class="widefat" id="<?php echo $obj->get_field_id( 'title' ); ?>" name="<?php echo $obj->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
</p>
<p>
	<label for="<?php echo $obj->get_field_id( 'number_posts' ); ?>"><?php _e( 'Number posts:', 'photolab' ); ?></label> 
	<input class="widefat" id="<?php echo $obj->get_field_id( 'number_posts' ); ?>" name="<?php echo $obj->get_field_name( 'number_posts' ); ?>" type="text" value="<?php echo esc_attr( $number_posts ); ?>">
</p>