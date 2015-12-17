<?php global $post; ?>
<div id="masonry" class="masonry">
<?php for($i = 0; $i < count($posts); $i++): ?>
	<?php
	$post = $posts[$i];
	setup_postdata( $post );
	?>
	<div class="brick">
		<?php get_template_part( $slug, $name ); ?>
	</div>
<?php endfor; ?>
</div>