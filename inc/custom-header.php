<?php
/**
 * Implement a custom header for photolab
 *
 * based on Twenty Thirteen WordPress theme
 *
 * @link http://codex.wordpress.org/Custom_Headers
 *
 * @package WordPress
 */

/**
 * Set up the WordPress core custom header arguments and settings.
 */
function photolab_custom_header_setup() {
	$args = array(
		'default-image'          => get_template_directory_uri() . '/images/header.jpg',
		'random-default'         => false,
		'width'                  => 1920,
		'height'                 => 585,
		'flex-height'            => true,
		'flex-width'             => true,
		'header-text'            => false,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => 'photolab_admin_header_style',
		'admin-preview-callback' => 'photolab_admin_header_image'
	);

	add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'photolab_custom_header_setup', 11 );


/**
 * Add custom options to admin screen
 */
function photolab_add_header_options() {
?>
<table class="form-table">
	<tbody>
		<tr>
			<th scope="row"><?php _e( 'Header slogan', 'photolab' ); ?></th>
			<td>
				<textarea name="phtotloab_header_slogan" id="phtotloab_header_slogan" rows="5" cols="100"><?php
					$slogan = get_theme_mod( 'header_slogan', __( '<em>Profesional Photographer</em>Hi! I am Linda Grey Johns. I live in NY.', 'photolab' ) );
					echo $slogan;
				?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e( 'Show post title on header image?', 'photolab' ); ?></th>
			<td>
				<label>
					<input type="checkbox" name="show_post_title_on_header">
					<?php _e( 'Show post title on header image?', 'photolab' ); ?>
				</label>
			</td>
		</tr>
	</tbody>
</table>
<?php
}
add_action( 'custom_header_options', 'photolab_add_header_options' );


/**
 * Save sanitized header slogan
 *
 * for old heder image interface
 */
function photolab_save_header_slogan() {

	if ( empty( $_POST ) ) {
		return;
	}
	if ( !isset($_POST['phtotloab_header_slogan']) ) {
		return;
	}

	global $allowedtags;
	$header_slogan = wp_kses( $_POST['phtotloab_header_slogan'], $allowedtags );

	update_option( 'photolab_header_slogan', $header_slogan );

}
add_action( 'admin_head-appearance_page_custom-header', 'photolab_save_header_slogan', 40 );


/**
 * Load our special font CSS files.
 */
function photolab_custom_header_fonts() {
	wp_enqueue_style( 'photolab-fonts', photolab_fonts_url(), array(), null );
}
add_action( 'admin_print_styles-appearance_page_custom-header', 'photolab_custom_header_fonts' );

/**
 * Style the header image displayed on the Appearance > Header admin panel.
 */
function photolab_admin_header_style() {
	$header_image  = get_header_image();
	$header_slogan = get_option( 'photolab_header_slogan' );
?>
	<style type="text/css" id="photolab-admin-header-css">
	.appearance_page_custom-header #headimg {
		border: none;
		-webkit-box-sizing: border-box;
		-moz-box-sizing:    border-box;
		box-sizing:         border-box;
		padding: 0;
		position: relative;
	}
	#headimg .home-link {
		-webkit-box-sizing: border-box;
		-moz-box-sizing:    border-box;
		box-sizing:         border-box;
		margin: 0 auto;
		max-width: 1040px;
		width: 100%;
	}
	.home-link {
		padding: 0 0 10px 0;
	}
	.home-link h1 {
		font-family: 'Libre Baskerville',serif;
	    font-size: 36px;
	    line-height: 36px;
	    margin: 0;
	    padding: 0;
	    font-weight: normal;
	}
	.home-link h1 a {
		text-decoration: none;
		color: #000;
	}
	.home-link h2 {
		color: #969DA3;
	    font-size: 14px;
	    font-weight: normal;
	    margin: 0;
	    padding: 0;
	}
	.header-slogan {
		position: absolute;
		bottom: 20px;
		left: 20px;
		background: #171717;
		color: #fff;
		padding: 15px 30px;
		font-size: 30px;
		line-height: 30px;
		max-width: 650px;
	}
	.header-slogan em {
		display: block;
		font-style: italic;
		font-size: 18px;
		font-family: 'Libre Baskerville',serif;
	}
	.default-header img {
		max-width: 230px;
		width: auto;
	}
	</style>
<?php
}

/**
 * Output markup to be displayed on the Appearance > Header admin panel.
 */
function photolab_admin_header_image() {
	global $allowedtags;
	?>
	<div class="home-link">
		<h1 class="displaying-header-text"><a id="name" onclick="return false;" href="#"><?php bloginfo( 'name' ); ?></a></h1>
		<h2 id="desc" class="displaying-header-text"><?php bloginfo( 'description' ); ?></h2>
	</div>
	<div id="headimg">
		<img src="<?php header_image(); ?>" alt="">
		<?php 
			$header_slogan = get_option( 'photolab_header_slogan' );
			if ( $header_slogan ) {
				echo '<div class="header-slogan">' . wp_kses( $header_slogan, $allowedtags ) . '</div>';
			}
		?>
	</div>
<?php }
