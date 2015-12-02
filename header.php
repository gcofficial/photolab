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
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	
	<header id="masthead" class="site-header" role="banner">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="site-branding">
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php if ( get_bloginfo( 'description' ) ) : ?>
						<div class="site-description"><?php bloginfo( 'description' ); ?></div>
						<?php endif; ?>
					</div>
				</div>
				<div class="col-md-8">
					<div class="clear">
						<?php photolab_social_list( 'header' ); ?>
						<div class="main-nav-wrap"><?php 
							wp_nav_menu( 
								array( 
									'theme_location'  => 'primary',
									'container'       => 'nav', 
									'container_class' => 'main-navigation', 
									'container_id'    => 'site-navigation',
									'menu_class'      => 'sf-menu', 
									'fallback_cb'     => 'photolab_page_menu'
								) 
							); 
						?></div><!-- #site-navigation -->
					</div>
				</div>
			</div>
		</div>
	</header><!-- #masthead -->
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
