<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package photolab
 */
?>
	<?php 
	if(FooterSettingsModel::getStyle() != 'minimal')
	{
		get_sidebar('footer');
	}
	?>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<div class="site-info">
				<?php echo FooterSettingsModel::getFooter(); ?>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
	<div id="back-top"><a href="#"><div class="dashicons dashicons-arrow-up-alt2"></div></a></div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
