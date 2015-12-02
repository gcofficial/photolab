<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package photolab
 */
$photolab_page_layout = photoloab_layout_class();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($photolab_page_layout); ?>>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'photolab' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
