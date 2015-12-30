<?php

class GeneralSiteSettingsModel extends OptionsModel{

	/**
	 * Get all options
	 * @return array --- all options
	 */
	public static function getAll()
	{
		return (array) get_option('gss');
	}

	/**
	 * Get favicon HTML code
	 * @return string --- favicon HTML code
	 */
	public static function getFavicon()
	{
		$result  = '';
		$favicon = trim(self::getOption('favicon'));
		if($favicon != '')
			$result = sprintf('<link rel="icon" type="image/png" href="%s" />', $favicon);
		return $result;
	}

	/**
	 * Get touch icon HTML code
	 * @return string --- touch icon HTML code
	 */
	public static function getTouchIcon()
	{
		$result = '';
		$touch_icon = trim(self::getOption('touch_icon'));
		if($touch_icon != '')
			$result = sprintf('<link rel="apple-touch-icon" href="%s"/>', $touch_icon);
		return $result;
	}

	/**
	 * Get site logo HTML code
	 * @return string --- site logo HTML code
	 */
	public static function getLogo()
	{
		$result  = Tools::renderView(
			'logo_text',
			array(
				'name'        => get_bloginfo( 'name' ),
				'home_url'    => esc_url( home_url( '/' ) ),
				'description' => get_bloginfo( 'description' )
			)
		);

		$logo = trim(self::getOption('logo'));
		if($logo != '')
		{
			$result = Tools::renderView(
				'logo_img',
				array('img' => $logo)
			);
		}
		return $result;
	}

	/**
	 * Get breadcrumbs
	 * @return string --- HTML code
	 */
	public static function getBreadcrumbs()
	{
		if(self::getOption('breadcrumbs') != '1') return '';
		global $post, $wp_query;
		return Tools::renderView(
			'breadcrumbs',
			array(
				'separator'        => '&gt;',
				'breadcrums_id'    => 'breadcrumbs',
				'breadcrums_class' => 'breadcrumbs',
				'home_title'       => 'Homepage',
				'custom_taxonomy'  => 'product_cat',
				'post'             => $post,
				'wp_query'         => $wp_query,
			)
		);
	}

	/**
	 * Get max container size (PX)
	 * @return integer --- max container size 
	 */
	public static function getMaxContainerSize()
	{
		$max_container_size = self::getOption('max_container_size');
		if($max_container_size <= 0) $max_container_size = 1170;
		return $max_container_size;
	}

	/**
	 * Get page preloader
	 * @return string --- preloader HTML code
	 */
	public static function getPreloader()
	{
		if(self::getOption('page_preloader') != '1') return '';
		return Tools::renderView('loader');
	}

	/**
	 * Get color scheme HEX
	 * @return string --- color scheme HEX
	 */
	public static function getColorScheme()
	{
		$color = trim(self::getOption('color_scheme'));
		if($color == '') $color = '#222';
		return  $color;
	}
}