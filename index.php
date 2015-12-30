<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
				'index', 
				getSidebarSideType()
			) 
		);
		?>
		</div>
	</div><!-- #primary -->

<?php get_footer(); ?>
