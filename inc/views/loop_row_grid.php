<?php global $post; ?>
<?php for($i = 0; $i < count($posts); $i+=$columns_count): ?>
	
	<div class="row">
	<?php for($x = 0; $x < $columns_count; $x++): ?>
	
		<?php if(isset($posts[$i+$x])): ?>
			<?php

			$post = $posts[$i+$x];
			setup_postdata( $post );
			?>
			<div class="<?php echo $column_css_class; ?>">
				<?php get_template_part( $slug, $name ); ?>
			</div>
				
		<?php endif; ?>

	<?php endfor; ?>
	</div>

<?php endfor; ?>
