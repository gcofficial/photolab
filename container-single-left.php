<div class="col-sm-9 right-sidebar">
<?php echo SocialPostTypes::getSocialPostCode($post); ?>
<?php while ( have_posts() ) : the_post(); ?>

	<?php get_template_part( 'content', 'single' ); ?>

	<?php photolab_post_nav(); ?>

	<?php
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || '0' != get_comments_number() ) :
			comments_template();
		endif;
	?>

<?php endwhile; // end of the loop. ?>
</div>
<?php echo SidebarSettingsModel::loadSidebar( SidebarSettingsModel::getLeftSidebarID() ); ?>