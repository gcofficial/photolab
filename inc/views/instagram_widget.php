<p>
	<label for="<?php echo $obj->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'photolab' ); ?></label> 
	<input class="widefat" id="<?php echo $obj->get_field_id( 'title' ); ?>" name="<?php echo $obj->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
</p>
<p>
	<label for="<?php echo $obj->get_field_id( 'user' ); ?>"><?php _e( 'User name:', 'photolab' ); ?></label> 
	<input class="widefat" id="<?php echo $obj->get_field_id( 'user' ); ?>" name="<?php echo $obj->get_field_name( 'user' ); ?>" type="text" value="<?php echo esc_attr( $user ); ?>">
</p>
<p>
	<label for="<?php echo $obj->get_field_id( 'number_posts' ); ?>"><?php _e( 'Number posts:', 'photolab' ); ?></label> 
	<input class="widefat" id="<?php echo $obj->get_field_id( 'number_posts' ); ?>" name="<?php echo $obj->get_field_name( 'number_posts' ); ?>" type="text" value="<?php echo esc_attr( $number_posts ); ?>">
</p>
<p>
	<label for="<?php echo $obj->get_field_id( 'client_id' ); ?>"><?php _e( 'Client id:', 'photolab' ); ?></label> 
	<input class="widefat" id="<?php echo $obj->get_field_id( 'client_id' ); ?>" name="<?php echo $obj->get_field_name( 'client_id' ); ?>" type="text" value="<?php echo esc_attr( $client_id ); ?>">
</p>