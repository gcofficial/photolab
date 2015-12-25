<?php
/**
 * Custom template tags for this theme.
 *
 * based on Underscores starter WordPress theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package photolab
 */

if ( ! function_exists( 'photolab_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function photolab_paging_nav() {

	if ( function_exists( 'the_posts_pagination' ) ) {
		the_posts_pagination( array(
			'prev_text'          => __( '&larr; Previous', 'photolab' ),
			'next_text'          => __( 'Next &rarr;', 'photolab' ),
			'screen_reader_text' => '',
		) );
		return;
	}

	global $wp_query, $wp_rewrite;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'      => $pagenum_link,
		'format'    => $format,
		'total'     => $wp_query->max_num_pages,
		'current'   => $paged,
		'mid_size'  => 1,
		'add_args'  => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&larr; Previous', 'photolab' ),
		'next_text' => __( 'Next &rarr;', 'photolab' ),
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'photolab' ); ?></h1>
		<div class="pagination loop-pagination">
			<?php echo $links; ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;

if ( ! function_exists( 'photolab_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function photolab_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation"><?php
		if ( $previous ) :
			$post_format = get_post_format( $previous->ID );
			$post_format = ( !empty($post_format) ) ? 'post-format-' . $post_format : 'post-format-standart';
			?>
			<div class="post-nav-wrap post-prev <?php echo esc_attr( $post_format ); ?>">
				<a href="<?php echo get_permalink( $previous->ID ); ?>" class="post-nav-prev">
				<?php
					if ( has_post_thumbnail( $previous->ID ) ) {
						echo get_the_post_thumbnail( $previous->ID, 'nav-thumbnail' );
					}
				?>
					<div class="post-nav-text">
						<div class="post-nav-label"><?php _e( 'Prev post', 'photolab' ); ?></div>
						<div class="post-nav-title"><?php echo get_the_title( $previous->ID ); ?></div>
					</div>
				</a>
			</div>
			<?php
		endif;
		if ( $next ) :
			$post_format = get_post_format( $next->ID );
			$post_format = ( !empty($post_format) ) ? 'post-format-' . $post_format : 'post-format-standart';
			?>
			<div class="post-nav-wrap post-next <?php echo esc_attr( $post_format ); ?>">
				<a href="<?php echo get_permalink( $next->ID ); ?>" class="post-nav-next">
				<?php
					if ( has_post_thumbnail( $next->ID ) ) {
						echo get_the_post_thumbnail( $next->ID, 'nav-thumbnail' );
					}
				?>
					<div class="post-nav-text">
						<div class="post-nav-label"><?php _e( 'Next post', 'photolab' ); ?></div>
						<div class="post-nav-title"><?php echo get_the_title( $next->ID  ); ?></div>
					</div>
				</a>
			</div>
			<?php
		endif;
	?></nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'photolab_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function photolab_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s"><a href="' . get_permalink() . '">%2$s</a></time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s"><a href="' . get_permalink() . '">%4$s</a></time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	echo $time_string;
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function photolab_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'photolab_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'photolab_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so photolab_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so photolab_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in photolab_categorized_blog.
 */
function photolab_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'photolab_categories' );
}
add_action( 'edit_category', 'photolab_category_transient_flusher' );
add_action( 'save_post',     'photolab_category_transient_flusher' );


/**
 * Custom comments template
 */
function photolab_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'photolab' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'photolab' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-author-thumb">
				<?php echo get_avatar( $comment, 70 ); ?>
			</div><!-- .comment-author -->
			<div class="comment-content">
				<div class="comment-meta">
					<?php printf( '<div class="comment_author">%s</div>', get_comment_author_link() ); ?>
					<time datetime="<?php comment_time( 'c' ); ?>">
						<?php echo human_time_diff( get_comment_time('U'), current_time('timestamp') ) . ' ' . __( 'ago', 'photolab' ); ?>
					</time>
				</div>
				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'photolab' ); ?></p>
				<?php endif; ?>
				<?php comment_text(); ?>
				<?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<div class="reply">',
						'after'     => '</div>',
					) ) );
				?>
			</div><!-- .comment-content -->
		</article><!-- .comment-body -->

	<?php
	endif;
}

/**
 * Modify comment form default fields
 */
add_filter( 'comment_form_default_fields', 'photolab_comment_form_fields' );
function photolab_comment_form_fields( $fields ) {

	$req       = get_option( 'require_name_email' );
	$html5     = 'html5';
	$commenter = wp_get_current_commenter();
	$aria_req  = ( $req ? " aria-required='true'" : '' );

	$fields = array(
		'author' => '<p class="comment-form-author"><input class="comment-form-input" id="author" name="author" type="text" placeholder="' . __( 'Name', 'photolab' ) . ( $req ? '*' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><input class="comment-form-input" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' placeholder="' . __( 'Email', 'photolab' ) . ( $req ? '*' : '' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p class="comment-form-url"><input class="comment-form-input" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' placeholder="' . __( 'Website', 'photolab' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'
	);

	return $fields;
}

/**
 * Show welcome message on front page
 */
function photolab_welcome_message() {
	$data = get_option( 'photolab' );
	if ( empty($data) ) {
		return;
	}

	global $wp_query, $allowedtags;
	if ( $wp_query->is_paged && $wp_query->query['paged'] > 1 ) {
		return;
	}

	echo '<div class="container">';
		echo '<div class="welcome_message row">';
			if ( isset($data['welcome_label']) ) {
				echo '<div class="col-md-12"><h3 class="message_label"><span>' . wp_kses( $data['welcome_label'], $allowedtags ) . '</span></h3></div>';
			}
			if ( isset($data['welcome_img']) ) {
				$alt_mess = isset($data['welcome_title']) ? $data['welcome_title'] : get_bloginfo( 'name' );
				echo '<div class="col-md-5"><img src="' . esc_url( $data['welcome_img'] ) . '" alt="' . esc_attr( $alt_mess ) . '"></div>';
			}
			echo '<div class="message_content col-md-7">';
				if ( isset($data['welcome_title']) ) {
					echo '<h2 class="message_title">' . wp_kses( $data['welcome_title'], $allowedtags ) . '</h2>';
				}
				if ( isset($data['welcome_message']) ) {
					echo '<p>' . wp_kses( $data['welcome_message'], $allowedtags ) . '</p>';
				}
			echo '</div>';
		echo '</div>';
	echo '</div>';
}

/**
 * photolab custom excerpt function
 */
function photolab_excerpt() {
	if ( has_excerpt() ) {
		the_excerpt();
	} else {
		$content = get_the_content();
		echo wp_trim_words( $content, 110 );
	}
}

/**
 * photolab readmore btn
 */
function photolab_read_more() {
	$btn_text = photolab_get_option( 'blog_btn', __( "Read More", "photolab" ) );
	if ( !$btn_text ) {
		return;
	}
	echo '<a href="' . esc_url( get_permalink() ) . '" class="btn btn-animated">' . esc_attr( $btn_text ) . '</a>';
}

/**
 * Get image html for featured gallery
 * @param  int $id - image ID
 * @param  string $size - image size
 * @param  string $class - image wrapper class
 * @return string - HTNL markup for gallery tem image
 */
function photolab_get_image_html( $id = null, $size = 'fullwidth-thumbnail', $class = 'fullwidth-item' ) {
	if ( !$id ) {
		return;
	}
	$fullsize_img = wp_get_attachment_url( $id );
	$cropped_image = wp_get_attachment_image( $id, $size );
	if ( $fullsize_img  && $cropped_image  ) {
		$result = '<div class="gall-img-wrap ' . esc_attr( $class ) . '"><a href="' . esc_url( $fullsize_img ) . '" class="lightbox-gallery">' . $cropped_image . '<span class="img-mask"></span></a></div>';
		return $result;
	} else {
		return false;
	}

}

/**
 * Show featured gllery for gallery post format
 * @return void
 */
function photolab_get_featured_gallery_html( $img_ids = null ) {

	if ( !$img_ids || !is_array($img_ids) ) {
		return;
	}

	$post_id = get_the_id();

	$img_ids_chunks = array_chunk($img_ids, 3);
	$num_items = count($img_ids_chunks);
	$i = 0;

	echo '<div class="post-featured-gallery" id="featured-gallery-' . $post_id . '" data-gall-id="featured-gallery-' . $post_id . '">';

	foreach ($img_ids_chunks as $sub_ids) {
		$item_class = 'item-left';
		if ( 0 == ( ( $i + 1 ) % 2 ) ) {
			$item_class = 'item-right';
		}
		if(++$i === $num_items) {

			// Gallery last row start
			echo '<div class="gall-row last ' . esc_attr( $item_class ) . '">';
			
			$sub_ids_length = count($sub_ids);
			switch ($sub_ids_length) {
				case '1':
					echo photolab_get_image_html($sub_ids[0]);
					break;
				
				case '2':
					foreach ($sub_ids as $img_item) {
						echo photolab_get_image_html($img_item, 'gallery-large', 'half-width-item');
					}
					unset($img_item);
					break;

				case '3':
					$sub_iter = 1;
					foreach ($sub_ids as $img_item) {
						if ( 1 == $sub_iter ) {
							echo photolab_get_image_html($img_item, 'gallery-large', 'large-img-item');
							$sub_iter++;
						} else {
							echo photolab_get_image_html($img_item, 'gallery-small', 'small-img-item');
						}
					}
					unset($img_item);
					unset($sub_iter);
					break;
			}

			// Gallery last row finish
			echo '</div>';

		} else {

			// Gallery row start
			echo '<div class="gall-row ' . esc_attr( $item_class ) . '">';

			$sub_iter = 1;
			foreach ($sub_ids as $img_item) {
				if ( 1 == $sub_iter ) {
					echo photolab_get_image_html($img_item, 'gallery-large', 'large-img-item');
					$sub_iter++;
				} else {
					echo photolab_get_image_html($img_item, 'gallery-small', 'small-img-item');
				}
			}
			unset($img_item);
			unset($sub_iter);
			
			// Gallery last row finish
			echo '</div>';
		}
	}

	echo '</div>';

}

/**
 * Featured gallery for gallery post format
 */
function photolab_featured_gallery( $post_format_only = true ) {

	if ( $post_format_only && 'gallery' != get_post_format() ) {
		return;
	}
	
	$post_id = get_the_id();
	$post_gallery = get_post_gallery( $post_id, false );

	if ( $post_gallery && is_array($post_gallery) && isset($post_gallery['ids']) ) {
		$img_ids = explode(',', $post_gallery['ids']);

		photolab_get_featured_gallery_html( $img_ids );
	} else {

		$attachments = get_children( array(
			'post_parent'    => $post_id,
			'posts_per_page' => 3,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
		) );

		if ( $attachments && is_array($attachments) ) {
			$img_ids = array_keys($attachments);
			photolab_get_featured_gallery_html( $img_ids );
		}

	}

}

/**
 * Get image for image post format
 */
function photolab_image_post() {

	if ( has_post_thumbnail() ) {
		$thumb_id = get_post_thumbnail_id();
		$fullsize_img = wp_get_attachment_url( $thumb_id );
		$cropped_image = wp_get_attachment_image( $thumb_id , 'fullwidth-thumbnail' );
		echo '<figure class="lightbox-image"><a href="' . esc_url( $fullsize_img ) . '" class="lightbox-gallery">' . $cropped_image . '<span class="img-mask"></span></a></figure>';
	} else {
		$post_id = get_the_id();
		$attachments = get_children( array(
			'post_parent'    => $post_id,
			'posts_per_page' => 1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
		) );
		if ( $attachments && is_array( $attachments ) ) {
			$img_id = $attachments[0]->ID;
			$fullsize_img = wp_get_attachment_url( $img_id );
			$cropped_image = wp_get_attachment_image( $img_id , 'fullwidth-thumbnail' );
			echo '<figure class="lightbox-image"><a href="' . esc_url( $fullsize_img ) . '" class="lightbox-gallery">' . $cropped_image . '<span class="img-mask"></span></a></figure>';
		}
	}
}

/**
 * Show header image and page title on single pages and archives
 */
add_action( 'photolab_pages_header', 'photolab_show_pages_header' );
function photolab_show_pages_header( $header_image ) {
	?>
	<div class="page-header-wrap">
	<?php
	$header_class = 'page-header';

	$header_class .= ' header-type-' . rand(1,8);

	if ( is_singular() ) 
	{
		if ( has_post_thumbnail() ) 
		{
			$header_class .= ' with-img';
			echo get_the_post_thumbnail( get_the_id(), 'full' );
		} 
		elseif ( $header_image ) 
		{
			$header_class .= ' with-img';
			echo '<img src="' . esc_url( $header_image ) . '" alt="' . get_bloginfo( 'name' ) . '">';
		}
	} 
	else 
	{
		if ( $header_image ) 
		{
			$header_class .= ' with-img';
			echo '<img src="' . esc_url( $header_image ) . '" alt="' . get_bloginfo( 'name' ) . '">';
		}
	}

	if(get_option('show_title_on_header') == '') 
		$header_class .= ' invisibility';
	?>
		<div class="container">
			<div class="<?php echo esc_attr( $header_class ); ?>">
				<?php echo renderTitle(); ?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Render title
 * @return string --- HTML code
 */
function renderTitle()
{
	ob_start();
	?>
	<?php
		if ( is_category() ) :
			echo '<h1>';
				single_cat_title();
			echo '</h1>';

		elseif ( is_tag() ) :
			echo '<h1>';
				single_tag_title();
			echo '</h1>';

		elseif ( is_author() ) :
			echo '<h1>';
				printf( __( 'Author: %s', 'photolab' ), '<span class="vcard">' . get_the_author() . '</span>' );
			echo '</h1>';

		elseif ( is_day() ) :
			echo '<h1>';
				printf( __( 'Day: %s', 'photolab' ), '<span>' . get_the_date() . '</span>' );
			echo '</h1>';

		elseif ( is_month() ) :
			echo '<h1>';
				printf( __( 'Month: %s', 'photolab' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'photolab' ) ) . '</span>' );
			echo '</h1>';

		elseif ( is_year() ) :
			echo '<h1>';
				printf( __( 'Year: %s', 'photolab' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'photolab' ) ) . '</span>' );
			echo '</h1>';

		elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
			echo '<h1>';
				_e( 'Asides', 'photolab' );
			echo '</h1>';

		elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
			echo '<h1>';
				_e( 'Galleries', 'photolab');
			echo '</h1>';

		elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
			echo '<h1>';
				_e( 'Images', 'photolab');
			echo '</h1>';

		elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
			echo '<h1>';
				_e( 'Videos', 'photolab' );
			echo '</h1>';

		elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
			echo '<h1>';
				_e( 'Quotes', 'photolab' );
			echo '</h1>';

		elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
			echo '<h1>';
				_e( 'Links', 'photolab' );
			echo '</h1>';

		elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
			echo '<h1>';
				_e( 'Statuses', 'photolab' );
			echo '</h1>';

		elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
			echo '<h1>';
				_e( 'Audios', 'photolab' );
			echo '</h1>';

		elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
			echo '<h1>';
				_e( 'Chats', 'photolab' );
			echo '</h1>';

		elseif ( is_search() ) :
			?><h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'photolab' ), '<span>' . get_search_query() . '</span>' ); ?></h1><?php

		elseif ( is_single() ) :
		?>
		<div class="entry-meta">
			<?php photolab_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php
		elseif ( is_page() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );

		elseif ( is_404() ) :
			echo '<h1 class="entry-title">' . __( 'Error 404', 'photolab' ) . '</h1>';
		
		else :
			echo '<h1>';
				_e( 'Archives', 'photolab' );
			echo '</h1>';

		endif;
	?>
	<?php
		// Show an optional term description.
		$term_description = term_description();
		if ( ! empty( $term_description ) ) :
			printf( '<div class="taxonomy-description">%s</div>', $term_description );
		endif;
	?>
	<?php
	
	$var = ob_get_contents();
	ob_end_clean();
	return $var;
}

/**
 * Add title to content
 * @param string $content --- html code
 */
function addTitleToContent( $content ) 
{
	$custom_content = '';
	if(get_option('show_title_on_header') == '')	
    	$custom_content = renderTitle();
    $custom_content .= $content;
    return $custom_content;
}
add_filter( 'the_content', 'addTitleToContent' );

/**
 * Show social links list
 */
function photolab_social_list( $where = 'header', $echo = true ) {

	ob_start();

	$data     = get_option( 'photolab' );
	$position = isset( $data['socials_position'] ) ? esc_attr( $data['socials_position'] ) : 'header';
	
	$photolab_socials_position_header = get_option('photolab_socials_position_header');
	$photolab_socials_position_footer = get_option('photolab_socials_position_footer');

	if($where == 'header' && $photolab_socials_position_header == '') return;
	if($where == 'footer' && $photolab_socials_position_footer == '') return;

	$socials = photolab_allowed_socials();

	$item_format = apply_filters( 
		'photolab_social_list_itemformat', 
		'<li class="social-list_item item-%1$s"><a class="social-list_item_link" href="%2$s"><i class="fa %3$s"></i></a></li>' 
	);

	$list = '';
	foreach ( $socials as $social_id => $social_data ) {
		if ( empty( $data[ $social_id . '_url' ] ) ) {
			continue;
		}
		$url  = esc_url( $data[ $social_id . '_url' ] );
		$icon = isset( $social_data['icon'] ) ? $social_data['icon'] : false;
		
		$list .= sprintf( $item_format, $social_id, $url, $icon );
	}

	if ( ! $list ) {
		return;
	}

	printf( '<ul class="social-list list-%1$s">%2$s</ul>', $where, $list );

	$var = ob_get_contents();
	ob_end_clean();
	if($echo == true)
		echo $var;
	else
		return $var;
}

/**
 * Get sidebars type
 * @return string --- sidebars type
 */
function getSidebarSideType()
{
	$key   = sprintf(
		'l%sr%s', 
		SidebarSettingsModel::getModeLeft(),
		SidebarSettingsModel::getModeRight()
	);
	$values = array(
		'lr'   => 'hide',
		'l1r'  => 'left',
		'lr1'  => 'right',
		'l1r1' => 'leftright',
	);	
	if(!BlogSettingsModel::isDefaultLayout())
	{
		$values['l1r1'] = 'left';
	}
	return $values[$key];
}

/**
 * Adjust brightness
 * @param  string $hex --- color hex
 * @param  int $steps --- steps
 * @return string --- color hex
 */
function adjustBrightness($hex, $steps) 
{
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Normalize into a six character long hex string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Split into three parts: R, G and B
    $color_parts = str_split($hex, 2);
    $return = '#';

    foreach ($color_parts as $color) {
        $color   = hexdec($color); // Convert to decimal
        $color   = max(0,min(255,$color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
    }

    return $return;
}