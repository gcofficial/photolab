<?php

abstract class OptionsModel{

	/**
	 * Get single option by key
	 * @param  string $key --- option key
	 * @return mixed --- option type
	 */
	public static function getOption($key)
	{
		return Tools::tryGet($key, static::getAll(), '');
	}

	/**
	 * Get all options
	 * @return array --- all options
	 */
	public static function getAll()
	{
		die('It must be ovverided!');
	}
}