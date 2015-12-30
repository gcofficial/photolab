<?php

class TypographySettingsModel extends OptionsModel{

	/**
	 * Get all options
	 * @return array --- all options
	 */
	public static function getAll()
	{
		return (array) get_option('typography');
	}

	/**
	 * Get allowed fonts with all options
	 * @return array --- all allowed fonts
	 */
	public static function getAllowedFontsWith()
	{
		return array(
			'open_sans' => array( 
				'name' => 'Open Sans',
				'url'  => 'https://fonts.googleapis.com/css?family=Open+Sans:400,800italic,800,700italic,700,600italic,600,400italic,300italic,300&subset=latin,greek,cyrillic,greek-ext,vietnamese,cyrillic-ext,latin-ext'
			),
			'pt_sans'   => array( 
				'name' => 'PT Sans',
				'url'  => 'https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic&subset=latin,greek,cyrillic,greek-ext,vietnamese,cyrillic-ext,latin-ext'
			),
			'roboto'    => array( 
				'name' => 'Roboto',
				'url'  => 'https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic&subset=latin,greek,greek-ext,cyrillic,vietnamese,cyrillic-ext,latin-ext'
			),
			'lato'      => array( 
				'name' => 'Lato',
				'url'  => 'https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic&subset=latin,latin-ext'
			),
			'oswald'    => array( 
				'name' => 'Oswald',
				'url'  => 'https://fonts.googleapis.com/css?family=Oswald:400,700,300&subset=latin,latin-ext'
			),
			'lora'      => array( 
				'name' => 'Lora',
				'url'  => 'https://fonts.googleapis.com/css?family=Lora:400,400italic,700,700italic&subset=latin,latin-ext,cyrillic'
			),
			'raleway'   => array( 
				'name' => 'Raleway',
				'url'  => 'https://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900'
			)
		);
	}

	/**
	 * Get heading font family
	 * @return string --- font family
	 */
	public static function getHeadingFFamily()
	{
		$ff     = trim(self::getOption('heading_font_family'));
		if($ff != '')
		{
			return Tools::renderView(
				'heading_font_family', 
				array(
					'ff'  => self::getFontOption($ff, 'name'),
					'url' => self::getFontOption($ff, 'url')
				)
			);
		}
		return '';
	}

	/**
	 * Get base font family
	 * @return string --- font family
	 */
	public static function getBaseFFamily()
	{
		$ff     = trim(self::getOption('base_font_family'));
		if($ff != '')
		{
			return Tools::renderView(
				'base_font_family', 
				array(
					'ff'  => self::getFontOption($ff, 'name'),
					'url' => self::getFontOption($ff, 'url')
				)
			);
		}
		return '';
	}

	/**
	 * Get base font size
	 * @return string --- font size
	 */
	public static function getBaseFSize()
	{
		return Tools::renderView(
			'base_font_size', 
			array(
				'fs' => self::getOption('base_font_size')
			)
		);
	}

	/**
	 * Get font option
	 * @param  string $font   --- font key
	 * @param  string $option --- option key
	 * @return string         --- font option
	 */
	public static function getFontOption($font, $option = 'name')
	{
		$options = self::getFontsOption($option);
		if(array_key_exists($font, $options)) return $options[$font];
		return false;
	}

	/**
	 * Get fonts option
	 * @param  string $option --- option key
	 * @return string         --- array with font key => option value
	 */
	public static function getFontsOption($option = 'name')
	{
		$result = array();
		$fonts  = self::getAllowedFontsWith();
		foreach ($fonts as $key => $font) 
		{
			$result[$key] = $font[$option];
		}
		return $result;
	}

	/**
	 * Get text color HEX 
	 * @return string --- text color HEX
	 */
	public static function getTextColor()
	{
		$color = trim(self::getOption('color_text'));
		if($color == '') $color = '#000';
		return  $color;
	}

	/**
	 * Get text H1 color HEX 
	 * @param $num --- H tag number
	 * @return string --- text H1 color HEX
	 */
	public static function getH($num)
	{
		$color = trim(self::getOption('color_h' . $num));
		if($color == '') $color = '#333';
		return  $color;
	}
}