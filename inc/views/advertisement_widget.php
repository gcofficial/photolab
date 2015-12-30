<p>
    <label for="<?php echo $obj->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'photolab' ); ?></label>
    <input class="widefat" id="<?php echo $obj->get_field_id( 'title' ); ?>" name="<?php echo $obj->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
    <label for="<?php echo $obj->get_field_name( 'image' ); ?>"><?php _e( 'Image:', 'photolab' ); ?></label>
    <input name="<?php echo $obj->get_field_name( 'image' ); ?>" id="<?php echo $obj->get_field_id( 'image' ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
    <input id="button_<?php echo $obj->get_field_id( 'image' ); ?>" class="upload_image_button button button-primary" type="button" value="<?php _e('Upload Image', 'photolab'); ?>" />
</p>