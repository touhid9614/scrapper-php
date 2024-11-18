<?php

namespace sMedia\Google\Type;

/**
 * This class describes a configuration.
 */
class Config
{
	public $AccessTokens;

	/**
	 * Constructs a new instance.
	 */
	public function __construct()
	{
		$this->AccessTokens = array();
	}

	public static function fromSerielized($stringData)
	{
		$data = unserialize($stringData);
		if (get_class($data) == "__PHP_Incomplete_Class") {
			$replace_class = ['Config', 'AccessToken'];
			$stringData = str_replace(
				array_map(self::objStr('[class_name]'), $replace_class),
				array_map(self::objStr('sMedia\Google\Type\[class_name]'), $replace_class),
				$stringData
			);

			$data = unserialize($stringData);
		}
		return $data;
	}

	private static function objStr($template)
	{
		return function ($v) use ($template) {
			$value = str_replace('[class_name]', $v, $template);
			return 'O:' . strlen($value) . ':"' . $value . '"';
		};
	}
}
