<?php
/**
 *
 * Template Name: Page with left sidebar
 *
 * @package photolab
 */

get_header(); ?>

	<div id="primary" class="container">
		<div class="row">
			<div class="col-sm-9 right-sidebar">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					?>

				<?php endwhile; // end of the loop. ?>
			</div>
			<?php get_sidebar(); ?>

		</div><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
