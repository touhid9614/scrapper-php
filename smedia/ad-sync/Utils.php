<?php

namespace sMedia\AdSync;

use Exception;
use Illuminate\Database\Capsule\Manager as DB;

class Utils
{
    public static function processTemplate($template, $values, $max_len = 0, $priorities = [])
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
            $to_remove        = max(array_unique(array_values($priorities)));
            $remove_candidate = array_filter($priorities, function ($v) use ($to_remove) {
                return $v == $to_remove;
            });
            if ($remove_candidate) {
                $keys          = array_keys($remove_candidate);
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

    public static function templateVarPriorities($template)
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

    public static function arrayRandomValue($array)
    {
        return $array[array_rand($array)];
    }

    public static function createCombination($a, $b)
    {
        $max         = max(count($a), count($b));
        $loop        = 0;
        $combination = [];
        while ($loop < $max) {
            if (isset($a[$loop])) {
                $aval = $a[$loop];
            }
            if (isset($b[$loop])) {
                $bval = $b[$loop];
            }

            $combination[] = "$aval{||}$bval";
            $loop++;
        }
        return $combination;
    }

    public static function hostUrl($url)
    {
        $url_parts = parse_url($url);
        return $url_parts['scheme'] . "://" . $url_parts['host'];
    }

    public static function replaceMultiSpaceWithOne($str)
    {
        return preg_replace('!\s+!', ' ', $str);
    }

    /**
     * removeEmptyArrayValues
     *
     * @param array $arr input array
     * @return array
     */
    public static function removeEmptyArrayValues($arr)
    {
        return array_filter($arr, function ($v) {
            return !empty($v);
        });
    }

    public static function loadMakeModelYearTrim($dealership)
    {

        try {
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
        } catch (Exception $e) {
            return collect([]);
        }
    }

    public static function getSpecialCampaigns($stock_type = null, $dealership = null)
    {
        $query = DB::table('tbl_ad_special_campaigns')
            ->select('structure', 'stock_type');

        if ($stock_type != null) {
            $query->where('stock_type', $stock_type);
        }
        if ($dealership != null) {
            $query->where('dealership', $dealership);
        }

        return $query->distinct()
            ->get()
            ->map(function ($c) {
                return "smedia_{$c->stock_type}_{$c->structure}";
            })
            ->toArray();
    }

    public static function arrayProduct($arrs, $recursive = false)
    {
        $arr1        = $arrs[0];
        $arr2        = $arrs[1];
        $result      = [];
        $arr2_length = count($arr2);
        $_arr1       = $recursive ? $arr1 : array_map(function ($v) {
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

    /**
     * isV2Campaign
     *
     * @param string $campaign
     * @param string $dealership
     * @param string[] $not_v2
     *
     * @return bool
     */
    public static function isV2Campaign($campaign, $dealership, $not_v2 = [])
    {
        $not_v2 = array_merge([
            "custom",
            "search",
            "search",
            "combined",
            "year_saving",
            "placement",
            "remarketing",
            "custom_roush",
            "dealer",
            "combined",
            "custom",
        ], $not_v2);

        $model_year_trim_pattern = "((_(?P<model>[^_]+))((_(?P<year>(year|[1,2][0,9]\d\d)))(_(?P<trim>[^_]+))?)?)";
        $pattern                 = "/smedia_{$dealership}_(new|used)_(?P<make>[^_]+)$model_year_trim_pattern?$/";

        preg_match($pattern, $campaign, $matches);

        $is_v2 = false;

        if (count($matches) > 0 && !in_array($matches['make'], $not_v2)) {
            $is_v2 = true;
        }

        return $is_v2;
    }
}