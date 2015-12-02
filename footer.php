<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package photolab
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<div class="site-info">
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'photolab' ) ); ?>" rel="nofollow"><?php printf( __( 'Proudly powered by %s', 'photolab' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<a href="<?php echo esc_url( __( 'http://www.templatemonster.com/', 'photolab' ) ); ?>" rel="nofollow" target="_blank"><?php printf( __( 'Theme %1$s designed by %2$s', 'photolab' ), 'Photolab', 'TemplateMonster' ); ?></a>
				<?php photolab_social_list( 'footer' ); ?>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
	<div id="back-top"><a href="#"><div class="dashicons dashicons-arrow-up-alt2"></div></a></div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
