<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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
					'page', 
					getSidebarSideType()
				) 
			);
			?>

		</div><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
