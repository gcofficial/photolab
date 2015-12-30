<?php

class HeaderSettingsModel extends OptionsModel{

	/**
	 * Get all options
	 * @return array --- all options
	 */
	public static function getAll()
	{
		return (array) get_option('header_settings');
	}

	/**
	 * Get stickup menu checkbox value
	 * @return boolean --- true or false
	 */
	public static function getStickupMenu()
	{
		return (bool) self::getOption('stickup_menu');
	}

	/**
	 * Get enable/disable flag title attributes
	 * @return boolean --- enabled or disabled
	 */
	public static function getTitleAttributes()
	{
		return (bool) self::getOption('title_attributes');
	}

	/**
	 * Get enable/disable flag search box
	 * @return boolean --- enabled or disabled
	 */
	public static function getSearchBox()
	{
		return (bool) self::getOption('search_box');
	}

	/**
	 * Get disclimer text HTML code
	 * @return string --- disclimer text HTML code
	 */
	public static function getDisclimer()
	{
		$result    = '';
		$disclimer = (string) self::getOption('disclimer_text');
		if($disclimer != '')
			$result = sprintf('<span class="disclimer">%s</span>', $disclimer);
		return $result;
	}

	/**
	 * Get header style HTML code
	 * @return string --- get header style code
	 */
	public static function getHeader()
	{
		$header_style = self::getHeaderStyle();
		$header_view  = sprintf('header_%s', $header_style);
		$main_menu    = '';

		if(has_nav_menu('main'))
		{
			$main_menu = wp_nav_menu( 
				array( 
					'theme_location'  => 'main',
					'container'       => 'nav', 
					'container_class' => 'main-navigation', 
					'container_id'    => 'site-navigation',
					'menu_class'      => 'sf-menu', 
					'fallback_cb'     => 'photolab_page_menu',
					'walker'          => new PhotolabWalker(),
					'echo'            => false
				) 
			); 	
		}

		return Tools::renderView(
			$header_view,
			array(
				'logo'      => GeneralSiteSettingsModel::getLogo(),
				'socials'   => photolab_social_list( 'header', false ),
				'main_menu' => $main_menu
			)
		);
	}

	/**
	 * Get current header style
	 * @return string --- header style
	 */
	public static function getHeaderStyle()
	{
		$allowed_header_styles = self::getAllowedHeaderStyles();
		$header_style = (string) self::getOption('header_style');
		if(in_array($header_style, $allowed_header_styles))
			return $header_style;
		return $allowed_header_styles[0];
	}

	/**
	 * Get all allowed header styles
	 * @return array --- all allowed header sytles
	 */
	public static function getAllowedHeaderStyles()
	{
		return array(
			'default',
			'minimal',
			'centered'
		);
	}
}