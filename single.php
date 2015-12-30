<?php
/**
 * The Template for displaying all single posts.
 *
 * @package photolab
 */

get_header(); ?>

	<div id="primary" class="container">
		<div class="row">
		<?php echo GeneralSiteSettingsModel::getBreadcrumbs(); ?>
		<?php
		get_template_part( 
			'container', 
			sprintf(
				'%s-%s', 
				'single', 
				getSidebarSideType()
			) 
		);
		?>
		</div>
	</div><!-- #primary -->

<?php get_footer(); ?>