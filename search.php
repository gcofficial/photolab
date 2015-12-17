<?php
/**
 * The template for displaying Search Results pages.
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

				<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'content', 'search' );
				?>

			<?php endwhile; ?>

			<?php photolab_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</div>
	</div><!-- #primary -->

<?php get_footer(); ?>
