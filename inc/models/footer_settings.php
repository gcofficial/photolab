<?php

class FooterSettingsModel extends OptionsModel{

	/**
	 * Get all options
	 * @return array --- all options
	 */
	public static function getAll()
	{
		return (array) get_option('fs');
	}

	/**
	 * Get copyright text
	 * @return string --- copyright HTML code
	 */
	public static function getCopyright()
	{
		return Tools::renderView(
			'copyright',
			array( 'copyright' => self::getOption('copyright') ) 
		);
	}

	/**
	 * Get site logo HTML code
	 * @return string --- site logo HTML code
	 */
	public static function getLogo()
	{
		$result  = '';

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
	 * Get footer HTML code
	 * @return string --- footer HTML code
	 */
	public static function getFooter()
	{
		$footer_view = sprintf('footer_%s', self::getStyle());
		return Tools::renderView(
			$footer_view,
			array(
				'logo'      => self::getLogo(),
				'copyright' => FooterSettingsModel::getCopyright(),
				'menu'      => wp_nav_menu( 
					array( 
						'theme_location'  => 'footer',
						'container'       => '', 
						'container_class' => 'footer-navigation', 
						'container_id'    => 'site-navigation',
						'menu_class'      => 'sf-footer-menu',
						'echo'            => false
					) 
				),
				'socials'   => photolab_social_list( 'footer', false )
			)
		);
	}

	/**
	 * Get current footer style
	 * @return string --- footer style
	 */
	public static function getStyle()
	{
		$allowed_styles = self::getAllowedStyles();
		$style 			= (string) self::getOption('footer_style');
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
			'minimal',
			'centered'
		);
	}

	/**
	 * Get columns number
	 * @return integer --- columns number
	 */
	public static function getColumns()
	{
		$columns = (int) self::getOption('columns');
		$columns = max(2, $columns);
		$columns = min(4, $columns);
		return $columns;
	}

	/**
	 * Get columns css class
	 * @return string --- css class
	 */
	public static function getColumnsCSSClass()
	{
		$columns_number = self::getColumns();
		$classes = array(
			2 => 'col-md-6',
			3 => 'col-md-4',
			4 => 'col-md-3',
		);
		return $classes[$columns_number];
	}

	/**
	 * Get all footer widgets id
	 * @return array --- all footer widgets id
	 */
	public static function getAllFooterWidgetsID()
	{
		global $_wp_sidebars_widgets;
		$result = array();
		if(array_key_exists('footer', $_wp_sidebars_widgets))
			$result = $_wp_sidebars_widgets['footer'];
		return $result;
	}

	/**
	 * Get all footer widgets
	 * @return array --- widgets
	 */
	public static function getAllFooterWidgets()
	{
		global $wp_registered_widgets;
		$widget_keys = array_keys($wp_registered_widgets);
		$ids         = self::getAllFooterWidgetsID();
		$result 	 = array();
		if(count($ids))
		{
			foreach ($ids as $id) 
			{
				if(in_array($id, $widget_keys))
				{
					array_push($result, $wp_registered_widgets[$id]);
				}
			}
		}
		return $result;
	}

	/**
	 * Get all footer widgets HTML in on array
	 * @return array --- all footer widgets HTML in on array
	 */
	public static function getAllFooterWidgetsHTML()
	{
		$widgets 		= array();
		$footer_widgets = self::getAllFooterWidgets();
		if(count($footer_widgets))
		{
			foreach ($footer_widgets as $widget) 
			{
				$option   = get_option( $widget['callback'][0]->option_name );
				$instance = array();
				if(array_key_exists($widget['callback'][0]->number, $option))
					$instance = $option[$widget['callback'][0]->number];

				ob_start();	
				the_widget( 
					get_class($widget['callback'][0]), 
					$instance, 
					array(
						'before_widget' => '<aside class="widget footer-widget">',
						'after_widget'  => '</aside>',
						'before_title'  => '<h3 class="widget-title">',
						'after_title'   => '</h3>',
					)
				);
				$widget = ob_get_clean();
				array_push($widgets, $widget);
				$widget = ''; // Yeah i'm a paranoic :D
			}
		}
		return $widgets;
	}
}