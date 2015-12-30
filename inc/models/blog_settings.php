<?php

class BlogSettingsModel extends OptionsModel{

	//                          __              __      
	//   _________  ____  _____/ /_____ _____  / /______
	//  / ___/ __ \/ __ \/ ___/ __/ __ `/ __ \/ __/ ___/
	// / /__/ /_/ / / / (__  ) /_/ /_/ / / / / /_(__  ) 
	// \___/\____/_/ /_/____/\__/\__,_/_/ /_/\__/____/  
	const LAYOUT_DEFAULT = 'default';
	const LAYOUT_GRID    = 'grid';
	const LAYOUT_MASONRY = 'masonry';

	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	                                             

	/**
	 * Get all options
	 * @return array --- all options
	 */
	public static function getAll()
	{
		return (array) get_option('bs');
	}

	/**
	 * Get blog layout style
	 * @return string --- blog layout style
	 */
	public static function getLayoutStyle()
	{
		$allowed_styles = self::getAllowedStyles();
		$style 			= (string) self::getOption('layout_style');
		if(in_array($style, $allowed_styles))
			return $style;
		return $allowed_styles[0];
	}

	/**
	 * Get all allowed footer styles
	 * @return array --- all allowed footer sytles
	 */
	public static function getAllowedStyles()
	{
		return array(
			'default',
			'grid',
			'masonry'
		);
	}

	/**
	 * Get layout columns
	 * @return integer --- layout columns
	 */
	public static function getColumns()
	{
		$columns = min(3, self::getOption('columns'));
		$columns = max(2, $columns);
		return $columns; 
	}

	/**
	 * Get column CSS class
	 * @return string --- column CSS class
	 */
	public static function getColumnCSSClass()
	{
		$classes = array(
			2 => 'col-md-6 col-lg-6',
			3 => 'col-md-4 col-lg-4'
		);
		return $classes[self::getColumns()];
	}

	/**
	 * Get brick percent width
	 * @return float --- percent width
	 */
	public static function getBrickWidth()
	{
		$widths = array(
			2 => 50,
			3 => 33.333333
		);
		return $widths[self::getColumns()];
	}

	/**
	 * Is default layout ?
	 * @return boolean --- true if succes | false if not
	 */
	public static function isDefaultLayout()
	{
		return self::getLayoutStyle() == self::LAYOUT_DEFAULT;
	}

	/**
	 * Is grid layout ?
	 * @return boolean --- true if succes | false if not
	 */
	public static function isGridLayout()
	{
		return self::getLayoutStyle() == self::LAYOUT_GRID;
	}

	/**
	 * Is masonry layout ?
	 * @return boolean --- true if succes | false if not
	 */
	public static function isMasonryLayout()
	{
		return self::getLayoutStyle() == self::LAYOUT_MASONRY;
	}
}