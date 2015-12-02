<?php
/**
 * @package photolab
 */
?>
<?php do_action( 'photolab_before_post' ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'col-md-12' ); ?>>

	<div class="entry-wrapper">
		<span class="entry-border"><div class="dashicons dashicons-format-image"></div></span>
		<div class="entry-content-wrapper">
			<header class="entry-header">
				<?php if ( 'post' == get_post_type() ) : ?>
					<div class="entry-meta">
						<?php photolab_posted_on(); ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			</header><!-- .entry-header -->

			<?php photolab_image_post(); ?>

			<div class="entry-content">
				<?php
					$photolab_blog_content = photolab_get_option( 'blog_content', 'excerpt' );
					if ( 'excerpt' == $photolab_blog_content ) {
						photolab_excerpt();
					} else {
						the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'photolab' ) );
						wp_link_pages( array(
							'before' => '<div class="page-links">' . __( 'Pages:', 'photolab' ),
							'after'  => '</div>',
						) );
					}
				?>
			</div><!-- .entry-content -->
			<?php photolab_read_more(); ?>

		</div><!-- .entry-wrapper -->
		<div class="clear"></div>
	</div><!-- .entry-content-wrapper -->
</article><!-- #post-## -->
