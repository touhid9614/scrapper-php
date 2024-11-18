<?php

namespace sMedia\AdWords;

use Illuminate\Database\Capsule\Manager as DB;

class Utils
{
	static function processTemplate($template, $values, $max_len = 0, $priorities = [])
	{
		if (!is_array($values) || empty($values)) {
			return $template;
		};

		$max_len = intval($max_len);

		if ($max_len <= 0 && empty($priorities)) {

			$processed_str = str_replace(
				array_map(function ($str) {
					return "[$str]";
				}, array_keys($values)),

				array_values($values),

				$template
			);

			return trim(preg_replace('!\s+!', ' ', $processed_str));
		}

		$processed_str = Utils::processTemplate($template, $values);

		if (strlen($processed_str) > $max_len) {
			$to_remove = max(array_unique(array_values($priorities)));
			$remove_candidate = array_filter($priorities, function ($v) use ($to_remove) {
				return $v == $to_remove;
			});
			if ($remove_candidate) {
				$keys = array_keys($remove_candidate);
				$key_to_remove = end($keys);
				unset($priorities[$key_to_remove]);
				if (isset($values[$key_to_remove])) {
					unset($values[$key_to_remove]);
				}
				$processed_str = Utils::processTemplate(trim(str_replace("[$key_to_remove]", '', $template)), $values, $max_len, $priorities);
			}
		}
		return $processed_str;
	}

	static function templateVarPriorities($template)
	{
		preg_match_all('/\[([^\(\]]*)\(?(\d*)\)?\]/', $template, $vars);
		$priorities = array_map(function ($v) {
			return intval($v);
		}, array_combine($vars[1], $vars[2]));

		$template = preg_replace_callback('/\[([^\(\]]*)\(?(\d*)\)?\]/', function ($v) {
			return "[{$v[1]}]";
		}, $template);

		return ["template" => $template, "priorities" => $priorities];
	}

	static function arrayRandomValue($array)
	{
		return $array[array_rand($array)];
	}

	static function createCombination($a, $b)
	{
		$combination = [];
		foreach ($a as $aval) {
			foreach ($b as $bval) {
				$combination[] = "$aval{||}$bval";
			}
		}
		return $combination;
	}

	static function hostUrl($url)
	{
		$url_parts = parse_url($url);
		return $url_parts['scheme'] . "://" . $url_parts['host'];
	}

	static function replaceMultiSpaceWithOne($str)
	{
		return preg_replace('!\s+!', ' ', $str);
	}

	/**
	 * removeEmptyArrayValues
	 *
	 * @param array $arr input array
	 * @return array
	 */
	static function removeEmptyArrayValues($arr)
	{
		return array_filter($arr, function ($v) {
			return !empty($v);
		});
	}

	static function loadMakeModelYearTrim($dealership)
	{

		$all_make_model_year_trim = DB::table("{$dealership}_scrapped_data")
			->select('make', 'model', 'year', 'trim', 'deleted')
			->where('deleted', '=', 0)
			->where('make', '>', '')
			->where('model', '>', '')
			->where('year', '>', '')
			->groupBy('trim')
			->groupBy('year')
			->groupBy('model')
			->get();

		return $all_make_model_year_trim;
	}

	static function arrayProduct($arrs, $recursive = false)
	{
		$arr1 = $arrs[0];
		$arr2 = $arrs[1];
		$result = [];
		$arr2_length = count($arr2);
		$_arr1 = $recursive ? $arr1 : array_map(function ($v) {
			return [$v];
		}, $arr1);
		for ($i = 0; $i < $arr2_length; $i++) {
			$result = array_merge($result, $_arr1);
		}

		foreach ($arr2 as $key => $val) {
			for ($i = 0; $i < $arr2_length; $i++) {
				$result[$key * $arr2_length + $i][] = $val;
			}
		}

		if (isset($arrs[2])) {
			return self::arrayProduct(array_merge([$result], array_slice($arrs, 2)), true);
		} else {
			return $result;
		}
	}
}
