<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * based on Underscores starter WordPress theme
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package photolab
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function photolab_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'photolab_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function photolab_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'photolab_body_classes' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function photolab_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'photolab' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'photolab_wp_title', 10, 2 );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function photolab_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'photolab_setup_author' );

/**
 * Empty primary menu callback function
 */
function photolab_page_menu( $args = array() ) {
	$defaults = array(
		'container'       => 'nav', 
		'container_class' => 'main-navigation', 
		'container_id'    => 'site-navigation',
		'menu_class'      => 'sf-menu',
		'echo'            => true,
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul id=\"%1$s\" class=\"%2$s\">%3$s</ul>',
		'depth'           => 0,
		'show_home'	      => __( 'Home', 'photolab' )
	);
	$args = wp_parse_args( $args, $defaults );

	$menu = '';

	$list_args = $args;

	// Show Home in the menu
	if ( ! empty($args['show_home']) ) {
		if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] )
			$text = __( 'Home', 'photolab' );
		else
			$text = $args['show_home'];
		$class = '';
		if ( is_front_page() && !is_paged() )
			$class = 'class="current_page_item"';
		$menu .= '<li ' . $class . '><a href="' . home_url( '/' ) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';
		// If the front page is a page, add it to the exclude list
		if (get_option('show_on_front') == 'page') {
			if ( !empty( $list_args['exclude'] ) ) {
				$list_args['exclude'] .= ',';
			} else {
				$list_args['exclude'] = '';
			}
			$list_args['exclude'] .= get_option('page_on_front');
		}
	}

	$list_args['echo'] = false;
	$list_args['title_li'] = '';
	$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages($list_args) );

	if ( $menu )
		$menu = '<ul class="' . esc_attr( $args['menu_class'] ) . '">' . $menu . '</ul>';

	$menu = '<' . $args['container'] . ' id="' . esc_attr( $args['container_id'] ) . '" class="' . esc_attr($args['container_class']) . '">' . $menu . "</" . $args['container'] . ">\n";
	
	if ( $args['echo'] )
		echo $menu;
	else
		return $menu;
}

/**
 * Get theme option by name
 */
function photolab_get_option( $option = null, $default = '' ) {
	
	if ( !$option ) {
		return;
	}
	
	global $photolab_options;
	
	if ( !$photolab_options ) {
		$photolab_options = get_option( 'photolab' );
		$GLOBALS['photolab_options'] = $photolab_options;
	}

	if ( isset($photolab_options[$option]) ) {
		return $photolab_options[$option];
	} else {
		return $default;
	}

}

/**
 * Increase default excerpt length
 */
function photolab_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'photolab_excerpt_length', 99 );


/**
 * Add featured label and label before blog
 */
function photolab_blog_labels() {
	global $photolab_first_sticky, $photolab_first_post, $wp_query;
	if ( is_sticky() && $photolab_first_sticky ) {
		return;
	} elseif ( !is_sticky() && $photolab_first_post ) {
		return;
	} elseif ( is_sticky() ) {
		$photolab_first_sticky = get_the_id();
		$label = photolab_get_option( 'featured_label' );
		if ( $wp_query->is_home() && $wp_query->is_main_query() ) {
			if ( $wp_query->is_paged && $wp_query->query['paged'] > 1 ) {
				return;
			}
			if ( $label ) {
				echo '<div class="col-md-12"><h3 class="blog_label"><span>' . $label . '</span></h3></div>';
			}
		}
	} else {
		$photolab_first_post = get_the_id();
		$label = photolab_get_option( 'blog_label' );
		if ( $wp_query->is_home() && $wp_query->is_main_query() ) {
			if ( $wp_query->is_paged && $wp_query->query['paged'] > 1 ) {
				return;
			}
			if ( $label ) {
				echo '<div class="col-md-12"><h3 class="blog_label"><span>' . $label . '</span></h3></div>';
			}
		}
	}
}
add_action( 'photolab_before_post', 'photolab_blog_labels' );

/**
 * Add random class to tag cloud links (for hover effect)
 */
add_filter( 'wp_generate_tag_cloud', 'photolab_tag_class', 10 );
function photolab_tag_class( $return ) {
	$return = preg_replace_callback("|(tag-link-)|", 'photolab_gener_random_class', $return);
	return $return;
}

function photolab_gener_random_class($matches) {
	return 'term-type-' . rand(1, 8) . ' ' . $matches[0];
}

/**
 * Add random class to nav items in primary menu (for hover effect)
 */
add_filter( 'nav_menu_css_class', 'photolab_nav_class' );
function photolab_nav_class( $classes ) {
	$classes[] = 'item-type-' . rand(1, 8);
	return $classes;
}

/**
 * Add layout classes for page content
 */
function photoloab_layout_class() {
	if ( is_page_template( 'page-left-sidebar.php' ) || is_page_template( 'page-right-sidebar.php' ) ) {
		return '';
	}
	return 'col-sm-12';
}

/**
 * Add some mime types
 * @param array $mime_types --- mime types
 */
add_filter('upload_mimes', 'addSomeMimeTypes', 1, 1);
function addSomeMimeTypes($mime_types){
    $mime_types['svg'] = 'image/svg+xml';
    return $mime_types;
}
