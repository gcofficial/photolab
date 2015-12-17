<?php

class ColorsModel extends OptionsModel{

	/**
	 * Get all options
	 * @return array --- all options
	 */
	public static function getAll()
	{
		return (array) get_option('colors');
	}

	/**
	 * Get text color HEX 
	 * @return string --- text color HEX
	 */
	public static function getTextColor()
	{
		$color = trim(self::getOption('text'));
		if($color == '') $color = '#000';
		return  $color;
	}

	/**
	 * Get color scheme HEX
	 * @return string --- color scheme HEX
	 */
	public static function getColorScheme()
	{
		$color = trim(self::getOption('scheme'));
		if($color == '') $color = '#222';
		return  $color;
	}

	/**
	 * Get text H1 color HEX 
	 * @param $num --- H tag number
	 * @return string --- text H1 color HEX
	 */
	public static function getH($num)
	{
		$color = trim(self::getOption('h' . $num));
		if($color == '') $color = '#333';
		return  $color;
	}
}