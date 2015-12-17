<?php get_sidebar(); ?>
<div class="col-sm-6">
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
<?php get_sidebar('second'); ?>