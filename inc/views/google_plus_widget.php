<p>
	<label for="<?php echo $obj->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'photolab' ); ?></label> 
	<input class="widefat" id="<?php echo $obj->get_field_id( 'title' ); ?>" name="<?php echo $obj->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
</p>
<p>
	<label for="<?php echo $obj->get_field_id( 'page_id' ); ?>"><?php _e( 'Number posts:', 'photolab' ); ?></label> 
	<input class="widefat" id="<?php echo $obj->get_field_id( 'page_id' ); ?>" name="<?php echo $obj->get_field_name( 'page_id' ); ?>" type="text" value="<?php echo esc_attr( $page_id ); ?>">
</p>