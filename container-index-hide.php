<?php if ( have_posts() ) : ?>
	<?php echo loop('content', get_post_format()); ?>
	<?php photolab_paging_nav(); ?>

<?php else : ?>

	<?php get_template_part( 'content', 'none' ); ?>

<?php endif; ?>