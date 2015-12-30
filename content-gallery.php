<?php
/**
 * @package photolab
 */
?>
<?php do_action( 'photolab_before_post' ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'col-md-12' ); ?>>

	<div class="entry-wrapper">
		<span class="entry-border"><div class="dashicons dashicons-format-gallery"></div></span>
		<div class="entry-content-wrapper">
			<header class="entry-header">
				<?php if ( 'post' == get_post_type() ) : ?>
					<div class="entry-meta">
						<?php photolab_posted_on(); ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			</header><!-- .entry-header -->

			
			<div class="entry-content">
			<?php photolab_featured_gallery(); ?>
			</div><!-- .entry-content -->

		</div><!-- .entry-wrapper -->
		<div class="clear"></div>
	</div><!-- .entry-content-wrapper -->
	
</article><!-- #post-## -->
