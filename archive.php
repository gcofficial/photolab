<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package photolab
 */

get_header(); ?>

	<div id="primary" class="container">
		<div class="row">
		<?php echo GeneralSiteSettingsModel::getBreadcrumbs(); ?>
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php echo loop('content', get_post_format()); ?>

			<?php endwhile; ?>

			<?php photolab_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</div>
	</div><!-- #primary -->

<?php get_footer(); ?>
