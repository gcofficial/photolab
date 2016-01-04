<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package photolab
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php echo GeneralSiteSettingsModel::getFavicon(); ?>
<?php echo GeneralSiteSettingsModel::getTouchIcon(); ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>
<style>
	body{
		color: <?php echo TypographySettingsModel::getTextColor() ?>;
	}

	body #back-top a:hover {
		border-color: <?php echo GeneralSiteSettingsModel::getColorScheme() ?>;
	}

	body input[type="text"]:focus,
	body input[type="email"]:focus,
	body input[type="url"]:focus,
	body input[type="password"]:focus,
	body input[type="search"]:focus {
		border-color: <?php echo GeneralSiteSettingsModel::getColorScheme() ?>;
		outline: none;
	}

	body .entry-wrapper .entry-border > div {
		background: <?php echo GeneralSiteSettingsModel::getColorScheme() ?>;
	}

	body .entry-wrapper .entry-border:after{
		background: <?php echo adjustBrightness(GeneralSiteSettingsModel::getColorScheme(), -50) ?>;
	}

	body .entry-wrapper .entry-border:before{
		background: <?php echo adjustBrightness(GeneralSiteSettingsModel::getColorScheme(), -25) ?>;
	}

	body .entry-footer-item.meta-category .dashicons{
		color: <?php echo adjustBrightness(GeneralSiteSettingsModel::getColorScheme(), -25) ?>;
	}

	body h1,
	body h2,
	body h3,
	body h4,
	body h5,
	body h6 {
	  color: <?php echo adjustBrightness(GeneralSiteSettingsModel::getColorScheme(), -55) ?>;;
	}

	body .post-nav-wrap.post-format-standart a .post-nav-text {
		background: <?php echo GeneralSiteSettingsModel::getColorScheme() ?>;
	}
	body .post-nav-wrap.post-format-standart a:after {
		background: <?php echo GeneralSiteSettingsModel::getColorScheme() ?>;
	}
	body .sf-menu > li.item-type-1 > a:before {
  		background: <?php echo GeneralSiteSettingsModel::getColorScheme() ?>;
	}
	body .header-image-box .page-header-wrap .page-header.with-img.header-type-1 {
		background: <?php echo GeneralSiteSettingsModel::getColorScheme() ?>;
	}
	body .entry-footer-item.meta-user .dashicons {
		color: <?php echo GeneralSiteSettingsModel::getColorScheme() ?>;
	}
	body .post-thumbnail a:after {
		background: <?php echo GeneralSiteSettingsModel::getColorScheme() ?>;
	}
	body #wp-calendar thead tr th:first-child {
		border-top: 2px solid <?php echo GeneralSiteSettingsModel::getColorScheme() ?>;
		border-bottom: 2px solid <?php echo GeneralSiteSettingsModel::getColorScheme() ?>;
	}
	body .tagcloud a.term-type-1:hover {
		border-color: <?php echo GeneralSiteSettingsModel::getColorScheme() ?>;
		background-color: <?php echo GeneralSiteSettingsModel::getColorScheme() ?>;
	}
	body .widget .cat-item:nth-child(8n+1) a:hover,
	body .widget .menu li:nth-child(8n+1) a:hover,
	body .widget.widget_archive li:nth-child(8n+1) a:hover {
		color: <?php echo GeneralSiteSettingsModel::getColorScheme() ?>;
	}
	body .btn.btn-animated:hover {
		border-bottom: 2px solid <?php echo GeneralSiteSettingsModel::getColorScheme() ?>;
	}
	body .btn.btn-animated:hover:before {
		background: <?php echo GeneralSiteSettingsModel::getColorScheme() ?>;
	}

	@media (min-width: 1199px) {
		body .container{
			width: <?php echo GeneralSiteSettingsModel::getMaxContainerSize(); ?>px;
		}
	}

	body h1{
		color: <?php echo TypographySettingsModel::getH(1) ?>;
	}

	body h2{
		color: <?php echo TypographySettingsModel::getH(2); ?>;
	}

	body h3{
		color: <?php echo TypographySettingsModel::getH(3); ?>;
	}

	body h4{
		color: <?php echo TypographySettingsModel::getH(4); ?>;
	}

	body h5{
		color: <?php echo TypographySettingsModel::getH(5); ?>;
	}

	body h6{
		color: <?php echo TypographySettingsModel::getH(6); ?>;
	}

	.brick {
		width: <?php echo BlogSettingsModel::getBrickWidth(); ?>%;
	}
	<?php
	echo TypographySettingsModel::getBaseFSize();
	echo TypographySettingsModel::getBaseFFamily();
	echo TypographySettingsModel::getHeadingFFamily();
	?>
</style>

<body <?php body_class(); ?>>
<?php echo GeneralSiteSettingsModel::getPreloader(); ?>
<div id="page" class="hfeed site">
	<?php if(has_nav_menu('top')): ?>
	<div class="top-menu">
		<?php 
		echo HeaderSettingsModel::getDisclimer();
		if(HeaderSettingsModel::getSearchBox())
		{
			get_search_form(); 	
		}
		?>		
		<?php 
			wp_nav_menu( 
				array( 
					'theme_location'  => 'top',
					'container'       => 'nav', 
					'container_class' => 'top-navigation', 
					'container_id'    => 'site-navigation',
					'menu_class'      => 'sf-top-menu', 
					'fallback_cb'     => 'photolab_page_menu',
					'walker'          => new PhotolabWalker()
				) 
			); 	
		?>
	</div>
	<?php endif; ?>
	<?php echo HeaderSettingsModel::getHeader(); ?>
	<div class="header-image-box">
	<?php
		$header_image  = get_header_image();
		if ( is_front_page() ) {
			$header_image  = get_header_image();
			$header_slogan = get_option( 'photolab_header_slogan' );
			if ( $header_image ) {
				echo '<img src="' . $header_image . '" alt="' . get_bloginfo( 'name' ) . '">';
			}
			if ( $header_slogan && $header_image ) {
				$static_class = empty( $header_image ) ? 'static' : 'absolute';
				echo '<div class="header-slogan ' . esc_attr( $static_class ) . '">' . $header_slogan . '</div>';
			}
		} else {
			do_action( 'photolab_pages_header', $header_image );
		}
	?>
	</div>
	<?php 
		if ( is_front_page() ) {
			photolab_welcome_message();
		}
	?>
	<div id="content" class="site-content">
