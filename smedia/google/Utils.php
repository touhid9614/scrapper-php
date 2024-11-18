<?php

namespace sMedia\Google;

use sMedia\Google\Type\Config;

class Utils
{
	/**
	 * Loads a configuration.
	 *
	 * @param      string  $path  The path to config file
	 * @return     Config  ( description_of_the_return_value )
	 */
	public static function loadTokenConfig($path, $sys_debug = false)
	{
		if (!file_exists($path)) {
			return new Config();
		}

		$fh         = fopen($path, 'r');
		$stringData = fread($fh, filesize($path));
		fclose($fh);

		if ($sys_debug) {
			slecho("ERROR: Config data file found::  $stringData");
		}

		$configs = Config::fromSerielized($stringData);
		return $configs;
	}

	/**
	 * Saves a configuration.
	 *
	 * @param      Config  $settings  The settings
	 * @param      string  $path  The path to config file
	 */
	public static function saveTokenConfig($settings, $path)
	{
		$stringData = serialize($settings);

		$fh = fopen($path, 'w') or die("can't open file " . $path);
		fwrite($fh, $stringData);
		fclose($fh);
	}

	/**
	 * saveTokenFor a single customer
	 *
	 * @param string $customer
	 * @param AccessToken $token
	 * @param string $path
	 */
	public static function saveTokenFor($customer, $token, $path)
	{
		$configs = self::loadTokenConfig($path);
		if (!$configs) {
			$configs = new Config();
		}

		$configs->AccessTokens[$customer] = $token;

		self::saveTokenConfig($configs, $path);
	}
}


// $log_path = 'data/log.txt';
