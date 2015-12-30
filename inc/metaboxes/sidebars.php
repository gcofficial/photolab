<?php

SidebarsMetaBox::init();

class SidebarsMetaBox{

	/**
	 * Initialize and add meta box
	 */
	public static function init()
	{
		if ( is_admin() ) 
		{
			add_action( 'load-post.php', array('SidebarsMetaBox', 'getNewClass') );
			add_action( 'load-post-new.php', array('SidebarsMetaBox', 'getNewClass') );
		}
	}

	/**
	 * Get new class object
	 * @return SidebarsMetaBox --- object
	 */
	public static function getNewClass()
	{
		return new SidebarsMetaBox();
	}

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'addMetaBox' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * Adds the meta box container.
	 */
	public function addMetaBox( $post_type ) {
		$post_types = array('post', 'page');
		if ( in_array( $post_type, $post_types )) 
		{
			add_meta_box(
				'sidebars_metabox',
				__( 'Sidebars ( you can choose your own sidebar for this page )', 'photolab' ),
				array( $this, 'renderMetaBoxContent' ),
				$post_type,
				'advanced',
				'high'
			);
		}
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {
	
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['sidebars_nonce'] ) ) return $post_id;

		$nonce = $_POST['sidebars_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'sidebars' ) ) return $post_id;

		// If this is an autosave, our form has not been submitted,
		// so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) 
		{
			if ( ! current_user_can( 'edit_page', $post_id ) ) return $post_id;
		} 
		else 
		{
			if ( ! current_user_can( 'edit_post', $post_id ) ) return $post_id;
		}

		/* OK, its safe for us to save the data now. */

		// Sanitize the user input.
		
		$sidebar_left  = $_POST['sidebar_left'];
		$sidebar_right = $_POST['sidebar_right'];
		// Update the meta field.
		update_post_meta( $post_id, 'sidebar_left', $sidebar_left );
		update_post_meta( $post_id, 'sidebar_right', $sidebar_right );
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function renderMetaBoxContent( $post ) 
	{
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'sidebars', 'sidebars_nonce' );
		
		echo Tools::renderView(
			'sidebars_metabox', 
			array(
				'left_select'  => Tools::renderSelectControl(
					SidebarSettingsModel::getSidebarsForSelect(),
					array(
						'name'  => 'sidebar_left',
						'id'    => 'sidebar_left',
						'value' => self::getSidebarLeft($post->ID)
					)
				),
				'right_select' => Tools::renderSelectControl(
					SidebarSettingsModel::getSidebarsForSelect(),
					array(
						'name'  => 'sidebar_right',
						'id'    => 'sidebar_right',
						'value' => self::getSidebarRight($post->ID)
					)
				)
			)
		);
	}

	/**
	 * Get sidebar left
	 * @param  object $post --- post
	 * @return string       --- sidebar left
	 */
	public static function getSidebarLeft($post_id)
	{
		return (string) get_post_meta( 
			$post_id, 
			'sidebar_left', 
			true 
		);
	}

	/**
	 * Get sidebar right
	 * @param  object $post --- post
	 * @return string       --- sidebar right
	 */
	public static function getSidebarRight($post_id)
	{
		return (string) get_post_meta( 
			$post_id, 
			'sidebar_right', 
			true 
		);
	}
}