<?php
/**
 * The Sidebar containing footer widget areas.
 *
 * @package photolab
 */
?>
<div class="footer-widgets">
	<div class="container">
		<div class="row">
		<?php
		if(is_active_sidebar('footer' )):
			echo Tools::renderView(
				'widgets_footer',
				array(
					'widgets' => FooterSettingsModel::getAllFooterWidgetsHTML(),
					'columns' => FooterSettingsModel::getColumns(),
					'css'     => FooterSettingsModel::getColumnsCSSClass()
				)
			);
		else:
		?>
			<aside id="search" class="widget widget_search col-md-4">
				<?php get_search_form(); ?>
			</aside>

			<aside id="archives" class="widget col-md-4">
				<h3 class="widget-title"><?php _e( 'Archives', 'photolab' ); ?></h3>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

			<aside id="meta" class="widget col-md-4">
				<h3 class="widget-title"><?php _e( 'Meta', 'photolab' ); ?></h3>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

		<?php endif; // end sidebar widget area ?>
		</div>
	</div>
</div>