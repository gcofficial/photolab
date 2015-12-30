<?php
/**
 * @package photolab
 */
?>
<?php do_action( 'photolab_before_post' ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'col-md-12' ); ?>>

	<div class="entry-wrapper">
		<span class="entry-border"><div class="dashicons dashicons-format-aside"></div></span>
		<div class="entry-content-wrapper">
			<header class="entry-header">
				<?php if ( 'post' == get_post_type() ) : ?>
					<div class="entry-meta">
						<?php photolab_posted_on(); ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
			</header><!-- .entry-header -->

			<?php if ( is_search() ) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<?php photolab_excerpt(); ?>
			</div><!-- .entry-summary -->
			<?php else : ?>
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
			<?php endif; ?>

		</div><!-- .entry-wrapper -->
		<div class="clear"></div>
	</div><!-- .entry-content-wrapper -->
</article><!-- #post-## -->
