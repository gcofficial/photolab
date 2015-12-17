<?php 
// global $wp_query;
// echo '<pre>';
// print_r($wp_query->get_posts());
// echo '</pre>';
?>
<div class="col-sm-9 right-sidebar">
<?php if ( have_posts() ) : ?>
	<?php echo loop('content', get_post_format()); ?>
	<?php photolab_paging_nav(); ?>

<?php else : ?>

	<?php get_template_part( 'content', 'none' ); ?>

<?php endif; ?>
</div>
<?php get_sidebar(); ?>