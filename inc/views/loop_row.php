<?php 
global $post; 
for($i = 0; $i < count($posts); $i++)
{
	$post = $posts[$i];
	setup_postdata( $post );
	get_template_part( $slug, $name ); 
}
