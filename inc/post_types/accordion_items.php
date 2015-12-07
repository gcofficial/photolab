<?php
add_action( 'init', 'create_post_type' );
function create_post_type() {
    register_post_type( 'accordion_item',
        array(
            'labels' => array(
                'name' => __( 'Accordion items' ),
                'singular_name' => __( 'Accordion item' )
            ),
            'public' => true,
            'has_archive' => true,
        )
    );
}