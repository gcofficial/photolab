<?php
/**
 * The Template for displaying all single posts.
 *
 * @package photolab
 */

get_header(); ?>

	<div id="primary" class="container">
		<div class="row">
		<?php
		get_template_part( 
			'container', 
			sprintf(
				'%s-%s', 
				'single', 
				get_option('sidebar_mode')
			) 
		);
		?>
		</div>
	</div><!-- #primary -->

<?php get_sidebar('footer'); ?>
<?php get_footer(); ?>