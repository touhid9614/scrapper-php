<?php

namespace sMedia\Config;

class GoogleConf
{
	public static $default = [
		"client_id"     => "876086351109-4qg0gsovfjt1s5pi7ht8hkskc0oolgbj.apps.googleusercontent.com",
		"client_secret" => "ccReKhIfBgATq07IvMP1SKS-",
		"scope"         => "https://www.googleapis.com/auth/adwords https://www.googleapis.com/auth/analytics https://www.googleapis.com/auth/analytics.edit https://www.googleapis.com/auth/analytics.readonly",
		"redirect_uri"  => "https://tm.smedia.ca/adwords3/google_authrize.php",
	];

	public static function accounts()
	{
		return   [
			'marshalsmedia' => self::$default,
			'coaganalytics' => self::$default,
			'smediaanalytic' => self::$default,
			'smediawebmastertool' => self::$default,
			'smediaanalytic2' => self::$default,
		];
	}

	public static function account($customer)
	{
		$google_configs = self::accounts();
		if (!empty($google_configs) && is_array($google_configs) && isset($google_configs[$customer])) {
			return $google_configs[$customer];
		} else {
			return null;
		}
	}
}