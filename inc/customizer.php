<?php
/**
 * photolab Theme Customizer
 * 
 * based on Underscores starter WordPress theme
 *
 * @package photolab
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function photolab_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// ==============================================================
	// Rename default sections
	// ==============================================================
}
add_action( 'customize_preview_init', 'photolab_customize_register' );

/**
 * This function enqueues scripts and styles in the Customizer.
 */
add_action( 'customize_controls_enqueue_scripts', 'my_customize_controls_enqueue_scripts' );
function my_customize_controls_enqueue_scripts() {
	wp_enqueue_script( 
		'my-customizer-script', 
		get_template_directory_uri() . '/js/customizer.js', 
		array( 'customize-controls' ) 
	);
}

/**
* Front End Customizer
*
* WordPress 3.4 Required
*/
add_action( 'customize_register', 'photolab_add_customizer' );

if(!function_exists('photolab_add_customizer')) {

	function photolab_add_customizer( $wp_customize ) {
		

		/* Header slogan */
		$wp_customize->add_setting( 'photolab_header_slogan', array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'photolab_header_slogan', array(
				'label'    => __( 'Header slogan text', 'photolab' ),
				'section'  => 'header_image',
				'settings' => 'photolab_header_slogan',
				'type'     => 'text',
				'priority' => 4
		) );

		/* Show titel on header image */
		$wp_customize->add_setting( 
			'show_title_on_header', 
			array(
				'default'           => 'on',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);
		$wp_customize->add_control( 
			'show_title_on_header', 
			array(
				'label'    => __( 'Show title on header image?', 'photolab' ),
				'section'  => 'header_image',
				'settings' => 'show_title_on_header',
				'type'     => 'checkbox',
				'priority' => 4
			) 
		);

		/* Socials section */
		$wp_customize->add_section( 'photolab_socials', array(
			'title'    => __( 'Socials Settings', 'photolab' ),
			'priority' => 40
		));

		/* Socials position */
		$wp_customize->add_setting( 
			'photolab_socials_position_header', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'photolab_sanitize_select'
			) 
		);
		$wp_customize->add_setting( 
			'photolab_socials_position_footer', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'photolab_sanitize_select'
			) 
		);
		$wp_customize->add_control( 
			'photolab_socials_position_header', 
			array(
				'label'    => __( 'Show social links in header', 'photolab' ),
				'section'  => 'photolab_socials',
				'settings' => 'photolab_socials_position_header',
				'type'     => 'checkbox'
			) 
		);
		$wp_customize->add_control( 
			'photolab_socials_position_footer', 
			array(
				'label'    => __( 'Show social links in footer', 'photolab' ),
				'section'  => 'photolab_socials',
				'settings' => 'photolab_socials_position_footer',
				'type'     => 'checkbox'
			) 
		);

		/* Social links */
		$allowed_socials = photolab_allowed_socials();
		foreach ( $allowed_socials as $social_id => $social_data ) {

			$name  = $social_id . '_url';
			$label = isset( $social_data['label'] ) ? $social_data['label'] : false;

			$wp_customize->add_setting( 'photolab[' . $name . ']', array(
					'default'           => '',
					'type'              => 'option',
					'sanitize_callback' => 'sanitize_text_field'
			) );
			$wp_customize->add_control( 'photolab_' . $name , array(
					'label'    => sprintf( __( '%s url', 'photolab' ), $label ),
					'section'  => 'photolab_socials',
					'settings' => 'photolab[' . $name . ']',
					'type'     => 'text'
			) );
		}


		$wp_customize->add_section( 'photolab_message', array(
			'title'    => __( 'Welcome Message', 'photolab' ),
			'priority' => 50
		));

		/* welcome label */
		$wp_customize->add_setting( 'photolab[welcome_label]', array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'photolab_welcome_label', array(
				'label'    => __( 'Welcome message label', 'photolab' ),
				'section'  => 'photolab_message',
				'settings' => 'photolab[welcome_label]',
				'type'     => 'text',
				'priority' => 4
		) );

		/* welcome image */
		$wp_customize->add_setting( 'photolab[welcome_img]', array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'photolab_sanitize_img'
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'welcome_img', array(
			'label'    => __( 'Welcome message image', 'photolab' ),
			'section'  => 'photolab_message',
			'settings' => 'photolab[welcome_img]',
			'priority' => 5
		) ) );

		/* welcome title */
		$wp_customize->add_setting( 'photolab[welcome_title]', array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'photolab_welcome_title', array(
				'label'    => __( 'Welcome message title', 'photolab' ),
				'section'  => 'photolab_message',
				'settings' => 'photolab[welcome_title]',
				'type'     => 'text',
				'priority' => 6
		) );

		/* welcome title */
		$wp_customize->add_setting( 'photolab[welcome_message]', array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'photolab_welcome_message', array(
				'label'    => __( 'Welcome message text', 'photolab' ),
				'section'  => 'photolab_message',
				'settings' => 'photolab[welcome_message]',
				'type'     => 'text',
				'priority' => 7
		) );

		$wp_customize->add_section( 'photolab_misc', array(
			'title'    => __( 'Misc', 'photolab' ),
			'priority' => 200
		));

		/* featured post label */
		$wp_customize->add_setting( 'photolab[featured_label]', array(
				'default'           => __( 'Featured', 'photolab' ),
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'photolab_featured_label', array(
				'label'    => __( 'Featured Post Label', 'photolab' ),
				'section'  => 'photolab_misc',
				'settings' => 'photolab[featured_label]',
				'type'     => 'text',
				'priority' => 6
		) );

		/* blog posts label */
		$wp_customize->add_setting( 'photolab[blog_label]', array(
				'default'           => __( 'My Blog', 'photolab' ),
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'photolab_blog_label', array(
				'label'    => __( 'Blog Label', 'photolab' ),
				'section'  => 'photolab_misc',
				'settings' => 'photolab[blog_label]',
				'type'     => 'text',
				'priority' => 7
		) );

		/* blog posts label */
		$wp_customize->add_setting( 'photolab[blog_content]', array(
				'default'           => 'excerpt',
				'type'              => 'option',
				'sanitize_callback' => 'photolab_sanitize_select'
		) );
		$wp_customize->add_control( 'photolab_blog_content', array(
				'label'    => __( 'Post content on blog page', 'photolab' ),
				'section'  => 'photolab_misc',
				'settings' => 'photolab[blog_content]',
				'type'     => 'select',
				'choices'  => array(
					'excerpt' => __( 'Only Excerpt', 'photolab' ),
					'full'    => __( 'Full Content', 'photolab' )
				),
				'priority' => 8
		) );

		/* featured image */
		$wp_customize->add_setting( 'photolab[blog_image]', array(
				'default'           => 'post-thumbnail',
				'type'              => 'option',
				'sanitize_callback' => 'photolab_sanitize_select'
		) );
		$wp_customize->add_control( 'photolab_blog_image', array(
				'label'    => __( 'Featured image on blog page', 'photolab' ),
				'section'  => 'photolab_misc',
				'settings' => 'photolab[blog_image]',
				'type'     => 'select',
				'choices'  => array(
					'post-thumbnail'      => __( 'Small', 'photolab' ),
					'fullwidth-thumbnail' => __( 'Fullwidth', 'photolab' )
				),
				'priority' => 9
		) );

		/* blog read more button text */
		$wp_customize->add_setting( 'photolab[blog_btn]', array(
				'default'           => __( 'Read More', 'photolab' ),
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'photolab_blog_btn', array(
				'label'    => __( 'Blog "Read More" button text', 'photolab' ),
				'section'  => 'photolab_misc',
				'settings' => 'photolab[blog_btn]',
				'type'     => 'select',
				'type'     => 'text',
				'priority' => 10
		) );

		/**
		 * Sidebars
		 */
		$wp_customize->add_section( 
			'photolab_sidebars', array(
				'title'    => __( 'Sidebar Settings', 'photolab' ),
				'priority' => 40
			)
		);

		$wp_customize->add_setting( 
			'sidebar_settings[mode_left]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'photolab_sanitize_select'
			) 
		);

		$wp_customize->add_control( 
			'sidebar_settings_mode_left', 
			array(
				'label'    => __( 'Show sidebar on left side', 'photolab' ),
				'section'  => 'photolab_sidebars',
				'settings' => 'sidebar_settings[mode_left]',
				'type'     => 'checkbox'
			) 
		);

		$wp_customize->add_setting( 
			'sidebar_settings[mode_right]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'photolab_sanitize_select'
			) 
		);

		$wp_customize->add_control( 
			'sidebar_settings_mode_right', 
			array(
				'label'    => __( 'Show sidebar on right side', 'photolab' ),
				'section'  => 'photolab_sidebars',
				'settings' => 'sidebar_settings[mode_right]',
				'type'     => 'checkbox'
			) 
		);

		$wp_customize->add_setting( 
			'sidebar_settings[sidebars]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			new SidebarCreator(
				$wp_customize, 
				'sidebar_settings_sidebar', 
				array(
					'label'    => __( 'Custom sidebars', 'photolab' ),
					'section'  => 'photolab_sidebars',
					'settings' => 'sidebar_settings[sidebars]'
				) 
			)
		);

		// ==============================================================
		// Header settings
		// ==============================================================
		$wp_customize->get_section('header_image')->title = __('Header Settings', 'photolab');

		$wp_customize->get_control('background_image')->section = 'header_image';

		$wp_customize->add_setting( 
			'header_settings[stickup_menu]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			'stickup_menu', 
			array(
				'label'    => __( 'Enable/Disable stickup menu', 'photolab' ),
				'section'  => 'header_image',
				'settings' => 'header_settings[stickup_menu]',
				'type'     => 'checkbox',
				'std'    => '1'
			) 
		);

		$wp_customize->add_setting( 
			'header_settings[title_attributes]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			'title_attributes', 
			array(
				'label'    => __( 'Enable/Disable title attributes', 'photolab' ),
				'section'  => 'header_image',
				'settings' => 'header_settings[title_attributes]',
				'type'     => 'checkbox',
				'std'    => '1'
			) 
		);
		
		$wp_customize->add_setting( 
			'header_settings[search_box]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			'search_box', 
			array(
				'label'    => __( 'Enable/Disable search box', 'photolab' ),
				'section'  => 'header_image',
				'settings' => 'header_settings[search_box]',
				'type'     => 'checkbox',
				'std'    => '1'
			) 
		);

		$wp_customize->add_setting( 
			'header_settings[disclimer_text]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_html'
			) 
		);

		$wp_customize->add_control( 
			'disclimer_text', 
			array(
				'label'    => __( 'Disclaimer text', 'photolab' ),
				'section'  => 'header_image',
				'settings' => 'header_settings[disclimer_text]',
				'type'     => 'textarea'
			) 
		);	

		

		$wp_customize->add_setting( 
			'header_settings[header_style]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			'header_style', 
			array(
				'label'    => __( 'Header style', 'photolab' ),
				'section'  => 'header_image',
				'settings' => 'header_settings[header_style]',
				'type'     => 'select',
				'choices'  => array(
					'default'  => __( 'Default', 'photolab' ),
					'minimal'  => __( 'Minimal', 'photolab' ),
					'centered' => __( 'Centered', 'photolab' )
				),
			) 
		);

		// ==============================================================
		// General Site Settings
		// ==============================================================
		$wp_customize->add_section( 
			'general_site_settings', array(
				'title'    => __( 'General Site Settings', 'photolab' ),
				'priority' => 10
			)
		);

		$wp_customize->get_control('background_color')->section = 'general_site_settings';

		$wp_customize->add_setting( 
			'gss[color_scheme]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			new WP_Customize_Color_Control( 
				$wp_customize, 
				'color_scheme', 
				array(
					'label'      => __( 'Color Scheme', 'photolab' ),
					'section'    => 'general_site_settings',
					'settings'   => 'gss[color_scheme]',
				) 
			)
		);

		$wp_customize->add_control( 
			'blogname', 
			array(
				'label'      => __( 'Site Title', 'photolab' ),
				'section'    => 'general_site_settings',
			) 
		);

		$wp_customize->add_control( 
			'blogdescription', 
			array(
				'label'      => __( 'Tagline', 'photolab' ),
				'section'    => 'general_site_settings',
			) 
		);

		$wp_customize->add_setting( 
			'gss[favicon]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'photolab_sanitize_img'
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'favicon',
				array(
					'label'      => __( 'Upload a favicon', 'photolab' ),
					'section'    => 'general_site_settings',
					'settings'   => 'gss[favicon]'
				)
			)
		);

		$wp_customize->add_setting( 
			'gss[touch_icon]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'photolab_sanitize_img'
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'touch_icon',
				array(
					'label'      => __( 'Upload a touch icon (57x57)', 'photolab' ),
					'section'    => 'general_site_settings',
					'settings'   => 'gss[touch_icon]'
				)
			)
		);

		$wp_customize->add_setting( 
			'gss[logo]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'photolab_sanitize_img'
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'logo',
				array(
					'label'      => __( 'Upload a logo', 'photolab' ),
					'section'    => 'general_site_settings',
					'settings'   => 'gss[logo]'
				)
			)
		);

		$wp_customize->add_setting( 
			'gss[max_container_size]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			'max_container_size', 
			array(
				'label'    => __( 'Max container size (px)', 'photolab' ),
				'section'  => 'general_site_settings',
				'settings' => 'gss[max_container_size]',
				'type'     => 'text'
			) 
		);

		$wp_customize->add_setting( 
			'gss[page_preloader]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'photolab_sanitize_select'
			) 
		);

		$wp_customize->add_control( 
			'page_preloader', 
			array(
				'label'    => __( 'Enable/Disable page preloader', 'photolab' ),
				'section'  => 'general_site_settings',
				'settings' => 'gss[page_preloader]',
				'type'     => 'checkbox'
			) 
		);


		$wp_customize->add_setting( 
			'gss[retina_optimisation]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'photolab_sanitize_select'
			) 
		);

		$wp_customize->add_control( 
			'retina_optimisation', 
			array(
				'label'    => __( 'Enable/Disable retina optimisation', 'photolab' ),
				'section'  => 'general_site_settings',
				'settings' => 'gss[retina_optimisation]',
				'type'     => 'checkbox'
			) 
		);

		$wp_customize->add_setting( 
			'gss[breadcrumbs]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'photolab_sanitize_select'
			) 
		);

		$wp_customize->add_control( 
			'breadcrumbs', 
			array(
				'label'    => __( 'Enable/Disable Breadcrumbs', 'photolab' ),
				'section'  => 'general_site_settings',
				'settings' => 'gss[breadcrumbs]',
				'type'     => 'checkbox'
			) 
		);

		// ==============================================================
		// Footer Settings
		// ==============================================================
		$wp_customize->add_section( 
			'footer_settings', array(
				'title'    => __( 'Footer Settings', 'photolab' ),
				'priority' => 100
			)
		);

		$wp_customize->add_setting( 
			'fs[footer_style]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			'footer_style', 
			array(
				'label'    => __( 'Style', 'photolab' ),
				'section'  => 'footer_settings',
				'settings' => 'fs[footer_style]',
				'type'     => 'select',
				'choices'  => array(
					'default'  => __( 'Default', 'photolab' ),
					'minimal'  => __( 'Minimal', 'photolab' ),
					'centered' => __( 'Centered', 'photolab' )
				),
			) 
		);

		$wp_customize->add_setting( 
			'fs[copyright]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			'copyright', 
			array(
				'label'    => __( 'Copyright text', 'photolab' ),
				'section'  => 'footer_settings',
				'settings' => 'fs[copyright]',
				'type'     => 'text'
			) 
		);

		$wp_customize->add_setting( 
			'fs[columns]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);
		
		$wp_customize->add_control( 
			'footer_columns', 
			array(
				'label'       => __( 'Columns number', 'photolab' ),
				'section'     => 'footer_settings',
				'settings'    => 'fs[columns]',
				'type'        => 'select',
				'choices'     => array(
					'2' => 2,
					'3' => 3,
					'4' => 4,
				),
			) 
		);	

		$wp_customize->add_setting( 
			'fs[logo]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'photolab_sanitize_img'
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'footer_logo',
				array(
					'label'      => __( 'Upload a footer logo', 'photolab' ),
					'section'    => 'footer_settings',
					'settings'   => 'fs[logo]'
				)
			)
		);

		// ==============================================================
		// Remove some sections
		// ==============================================================
		$wp_customize->remove_section('title_tagline');
		$wp_customize->remove_section('background_image');
		$wp_customize->remove_section('static_front_page');
		$wp_customize->remove_section('colors');

		// ==============================================================
		// Blog settings
		// ==============================================================
		$wp_customize->add_section( 
			'blog_settings', array(
				'title'    => __( 'Blog Settings', 'photolab' ),
				'priority' => 100
			)
		);

		$wp_customize->get_control('show_on_front')->section = 'blog_settings';

		$wp_customize->add_setting( 
			'bs[layout_style]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			'layout_style', 
			array(
				'label'       => __( 'Layout style', 'photolab' ),
				'section'     => 'blog_settings',
				'settings'    => 'bs[layout_style]',
				'type'        => 'select',
				'description' => __('If you select a non-default double sidebar will be disabled', 'photolab'),
				'choices'     => array(
					'default' => __( 'Default', 'photolab' ),
					'grid'    => __( 'Grid', 'photolab' ),
					'masonry' => __( 'Masonry', 'photolab' ),
				),
			) 
		);
		
		$wp_customize->add_setting( 
			'bs[columns]', 
			array(
				'default'           => '2',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage'
			) 
		);
		
		$wp_customize->add_control( 
			'columns', 
			array(
				'label'       => __( 'Columns', 'photolab' ),
				'section'     => 'blog_settings',
				'settings'    => 'bs[columns]',
				'type'        => 'select',
				'choices'     => array(
					'2' => __( '2', 'photolab' ),
					'3' => __( '3', 'photolab' ),
				),
			) 
		);	

		// ==============================================================
		// Typography settings
		// ==============================================================
		$wp_customize->add_setting( 
			'typography[color_text]',  
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			new WP_Customize_Color_Control( 
				$wp_customize, 
				'text_color', 
				array(
					'label'      => __( 'Text Color', 'photolab' ),
					'section'    => 'typography_settings',
					'settings'   => 'typography[color_text]',
				) 
			)
		);

		$wp_customize->add_setting( 
			'typography[color_h1]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			new WP_Customize_Color_Control( 
				$wp_customize, 
				'color_h1', 
				array(
					'label'      => __( 'Color h1', 'photolab' ),
					'section'    => 'typography_settings',
					'settings'   => 'typography[color_h1]',
				) 
			)
		);

		$wp_customize->add_setting( 
			'typography[color_h2]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			new WP_Customize_Color_Control( 
				$wp_customize, 
				'color_h2', 
				array(
					'label'      => __( 'Color h2', 'photolab' ),
					'section'    => 'typography_settings',
					'settings'   => 'typography[color_h2]',
				) 
			)
		);

		$wp_customize->add_setting( 
			'typography[color_h3]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			new WP_Customize_Color_Control( 
				$wp_customize, 
				'color_h3', 
				array(
					'label'      => __( 'Color h3', 'photolab' ),
					'section'    => 'typography_settings',
					'settings'   => 'typography[color_h3]',
				) 
			)
		);

		$wp_customize->add_setting( 
			'typography[color_h4]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			new WP_Customize_Color_Control( 
				$wp_customize, 
				'color_h4', 
				array(
					'label'      => __( 'Color h4', 'photolab' ),
					'section'    => 'typography_settings',
					'settings'   => 'typography[color_h4]',
				) 
			)
		);

		$wp_customize->add_setting( 
			'typography[color_h5]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			new WP_Customize_Color_Control( 
				$wp_customize, 
				'color_h5', 
				array(
					'label'      => __( 'Color h5', 'photolab' ),
					'section'    => 'typography_settings',
					'settings'   => 'typography[color_h5]',
				) 
			)
		);

		$wp_customize->add_setting( 
			'typography[color_h6]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			new WP_Customize_Color_Control( 
				$wp_customize, 
				'color_h6', 
				array(
					'label'      => __( 'Color h6', 'photolab' ),
					'section'    => 'typography_settings',
					'settings'   => 'typography[color_h6]',
				) 
			)
		);
		$wp_customize->add_section( 
			'typography_settings', array(
				'title'    => __( 'Typography settings', 'photolab' ),
				'priority' => 100
			)
		);

		$wp_customize->add_setting( 
			'typography[heading_font_family]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			'typography_heading_font_family', 
			array(
				'label'       => __( 'Heading font family', 'photolab' ),
				'section'     => 'typography_settings',
				'settings'    => 'typography[heading_font_family]',
				'type'        => 'select',
				'choices'     => TypographySettingsModel::getFontsOption(),
			) 
		);

		$wp_customize->add_setting( 
			'typography[base_font_family]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			'typography_base_font_family', 
			array(
				'label'       => __( 'Base font family', 'photolab' ),
				'section'     => 'typography_settings',
				'settings'    => 'typography[base_font_family]',
				'type'        => 'select',
				'choices'     => TypographySettingsModel::getFontsOption(),
			) 
		);

		$wp_customize->add_setting( 
			'typography[base_font_size]', 
			array(
				'default'           => '',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			) 
		);

		$wp_customize->add_control( 
			'typography_base_font_size', 
			array(
				'label'    => __( 'Base font size', 'photolab' ),
				'section'  => 'typography_settings',
				'settings' => 'typography[base_font_size]',
				'type'     => 'text'
			) 
		);
	}
}


/**
 * ----------------------------------------------
 *     Add sanitize callbacks for customizer
 * ----------------------------------------------
 */


/**
 * Sanitize image input
 */
function photolab_sanitize_img( $input ) {
	return esc_url( $input );
}

/**
 * Sanitize select input
 */
function photolab_sanitize_select( $input ) {
	return esc_attr( $input );
}

/**
 * Sanitize check-box input
 */
function photolab_sanitize_checkbox( $input ) {

	if ( '1' != $input ) {
		return false;
	}

	return $input;

}

/**
 * Sanitize content for allowed HTML tags for post content.
 * @param  string $input --- content
 * @return string --- sanitized content
 */
function sanitize_html( $input ){
	return wp_kses_post( $input );
}