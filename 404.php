<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package photolab
 */

get_header(); ?>

	<div id="primary" class="container">
		<div class="row">
			<?php echo GeneralSiteSettingsModel::getBreadcrumbs(); ?>
			<section class="error-404 not-found col-md-12">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'photolab' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'photolab' ); ?></p>

					<?php get_search_form(); ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</div>
	</div><!-- #primary -->

<?php get_footer(); ?>
