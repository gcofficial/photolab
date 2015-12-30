<?php

class SidebarSettingsModel extends OptionsModel{

	/**
	 * Get all options
	 * @return array --- all options
	 */
	public static function getAll()
	{
		return (array) get_option('sidebar_settings');
	}

	/**
	 * Get mode left
	 * @return string --- mode left
	 */
	public static function getModeLeft()
	{
		return self::getOption('mode_left');
	}

	/**
	 * Get mode right
	 * @return string --- mode right
	 */
	public static function getModeRight()
	{
		return self::getOption('mode_right');
	}

	/**
	 * Get sidebars
	 * @return string --- json string or empty
	 */
	public static function getSidebars()
	{
		return (string) self::getOption('sidebars');
	}

	/**
	 * Get sidebars in array
	 * @return array --- sidebars array
	 */
	public static function getSidebarsArray()
	{
		return (array) json_decode(self::getSidebars());
	}

	/**
	 * Get sidebars with options
	 * @return array --- sidebars with options
	 */
	public static function getSidebarsOptions()
	{
		$res = array();
		$arr = self::getSidebarsArray();
		if(count($arr))
		{
			foreach ($arr as $key => $value) 
			{
				array_push(
					$res, 
					array(
						'name'          => $value,
						'id'            => self::getSidebarID($value),
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget'  => '</aside>',
						'before_title'  => '<h3 class="widget-title">',
						'after_title'   => '</h3>',
					) 
				);
			}
		}
		return $res;
	}

	/**
	 * Get sidebar id from name
	 * @param  string $name --- sidebar name
	 * @return string       --- sidebar id
	 */
	public static function getSidebarID($name)
	{
		return str_replace(' ', '_', strtolower($name));
	}

	/**
	 * Get registered sidebars for select control
	 * @return array --- registered sidebars
	 */
	public static function getSidebarsForSelect()
	{
		$result   = array( '' => 'Inherit' );
		$sidebars = (array) $GLOBALS['wp_registered_sidebars'];
		if(count($sidebars))
		{
			foreach ($sidebars as $sidebar) 
			{
				$result[$sidebar['id']] = $sidebar['name'];
			}
		}
		return $result;
	}

	/**
	 * Get left sidebar id
	 * @return string --- left sidebar id
	 */
	public static function getLeftSidebarID()
	{
		global $post;
		$left = trim((string) get_post_meta( $post->ID, 'sidebar_left', true ));
		if($left == '') $left = 'sidebar-1';
		return $left;
	}

	/**
	 * Get right sidebar id
	 * @return string --- right sidebar id
	 */
	public static function getRightSidebarID()
	{
		global $post;
		$right = trim((string) get_post_meta( $post->ID, 'sidebar_right', true ));
		if($right == '') $right = 'sidebar-2';
		return $right;
	}

	/**
	 * Load sidebar 
	 * @param  string $sidebar_id --- sidebar id
	 * @return string             --- html code sidebar
	 */
	public static function loadSidebar($sidebar_id)
	{
		return Tools::renderView(
			'sidebar',
			array(
				'sidebar_id' => $sidebar_id
			)
		);
	}
}