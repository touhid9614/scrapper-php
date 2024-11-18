<?php

namespace sMedia\Google\ShortCut;

/**
 * This class contain some $_GET shortcuts.
 */
class Get
{
	/**
	 * Shortcut of $_GET['code']
	 * { function_description }
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function Code()
	{
		if (isset($_GET['code'])) {
			return $_GET['code'];
		} else {
			return false;
		}
	}

	public static function Customer($default = 'marshal')
	{
		return isset($_GET['customer']) ? $_GET['customer'] : $default;
	}


	/**
	 * Shortcut of $_GET['error_description']
	 * { function_description }
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function Error()
	{
		if (isset($_GET['error_description'])) {
			return $_GET['error_description'];
		} else {
			return false;
		}
	}


	/**
	 * Shortcut of $_GET['state']
	 * { function_description }
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function State()
	{
		if (isset($_GET['state'])) {
			return $_GET['state'];
		} else {
			return false;
		}
	}
}
