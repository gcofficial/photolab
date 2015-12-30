<p>
	<label for="<?php echo $obj->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'photolab' ); ?></label> 
	<input class="widefat" id="<?php echo $obj->get_field_id( 'title' ); ?>" name="<?php echo $obj->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
</p>
<p>
	<label for="<?php echo $obj->get_field_id( 'post_ids' ); ?>"><?php _e( 'Post ids:', 'photolab' ); ?></label> 
	<input class="widefat" id="<?php echo $obj->get_field_id( 'post_ids' ); ?>" name="<?php echo $obj->get_field_name( 'post_ids' ); ?>" type="text" value="<?php echo esc_attr( $post_ids ); ?>">
</p>
<p>
	<label for="<?php echo $obj->get_field_id( 'category' ); ?>"><?php _e( 'Category:', 'photolab' ); ?></label>
	<?php wp_dropdown_categories( 
		array(
			'show_option_all'    => '',
			'show_option_none'   => 'All',
			'option_none_value'  => '',
			'orderby'            => 'ID', 
			'order'              => 'ASC',
			'show_count'         => 0,
			'hide_empty'         => 1, 
			'child_of'           => 0,
			'exclude'            => '',
			'echo'               => 1,
			'selected'           => 0,
			'hierarchical'       => 0, 
			'name'               => $obj->get_field_name( 'category' ),
			'id'                 => $obj->get_field_id( 'category' ),
			'class'              => 'postform',
			'depth'              => 0,
			'tab_index'          => 0,
			'taxonomy'           => 'category',
			'hide_if_empty'      => false,
			'value_field'	     => 'term_id',	
		)
	); ?> 
</p>