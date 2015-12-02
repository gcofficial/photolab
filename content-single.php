<?php
/**
 * @package photolab
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-12'); ?>>

	<?php photolab_featured_gallery(); ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'photolab' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<div class="entry-footer-item meta-user"><div class="dashicons dashicons-businessman"></div> <?php the_author_posts_link(); ?></div>
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'photolab' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'photolab' ) );

			if ($category_list) {
				echo '<div class="entry-footer-item meta-category"><div class="dashicons dashicons-category"></div> ' . $category_list . '</div>';
			}
			if ($tag_list) {
				echo '<div class="entry-footer-item meta-tags"><div class="dashicons dashicons-tag"></div> ' . $tag_list . '</div>';
			}
		?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
