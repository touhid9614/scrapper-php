<?php

/**
 * { function_description }
 *
 * @param      <type>  $scrapper_config  The scrapper configuration
 * @param      <type>  $url              The url
 *
 * @return     string  ( description_of_the_return_value )
 */
function resolve_dealer_page_type($scrapper_config, $url)
{
    $vdp_page_regex = isset($scrapper_config['vdp_url_regex']) ? $scrapper_config['vdp_url_regex'] : null;
    $ty_page_regex  = isset($scrapper_config['ty_url_regex']) ? $scrapper_config['ty_url_regex'] : null;
    $srp_page_regex = isset($scrapper_config['srp_page_regex']) ? $scrapper_config['srp_page_regex'] : null;

    if ($ty_page_regex && preg_match($ty_page_regex, $url)) {
        return 'ty';
    } elseif ($vdp_page_regex && preg_match($vdp_page_regex, $url)) {
        return 'vdp';
    } elseif ($srp_page_regex && preg_match($srp_page_regex, $url)) {
        return 'srp';
    } else {
        if (isset($scrapper_config['page_types'])) {
            foreach ($scrapper_config['page_types'] as $page_type => $page_type_def) {
                if (preg_match($page_type_def['url_regex'], $url)) {
                    return $page_type;
                }
            }
        }

        return 'other';
    }
}

/**
 * { function_description }
 *
 * @param      <type>  $cron_name        The cron name
 * @param      <type>  $scrapper_config  The scrapper configuration
 * @param      <type>  $url              The url
 * @param      <type>  $ref_url          The reference url
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function resolve_car_from_url($cron_name, $scrapper_config, $url, $ref_url)
{
    global $debug, $redis, $redis_cache_duration;

    // $debug = true;

    $vdp_page_regex  = isset($scrapper_config['vdp_url_regex']) ? $scrapper_config['vdp_url_regex'] : null;
    $required_params = isset($scrapper_config['required_params']) ? $scrapper_config['required_params'] : null;

    $car_data = null;

    $car_data_key = 'car_data_' . url_to_svin($ref_url, $required_params);

    if (isset($redis) && ($car_data_str = $redis->get($car_data_key))) {
        $car_data = unserialize($car_data_str);

        if ($debug) {
            echo "\n// Car Data is found in redis cache.\n";
            echo "\n// car_data_str = {$car_data_str} \n";

            foreach ($car_data as $key => $value) {
                echo "\n// {$key}  ==>  {$value}\n";
            }
        }
    }

    if ($car_data) {
        if ($debug) {
            echo "\n// Valid Car Data is found in redis cache.\n";
        }

        return $car_data;
    } else {
        if ($debug) {
            echo "\n// Valid Car Data is not available in redis cache. Searching DBMS.\n";
        }

        if (!$required_params) {
            $urls = get_url_veriations($url);

            $where = '';

            foreach ($urls as $_url) {
                if ($where) {
                    $where .= ' OR ';
                }

                $where .= "url like '%" . tagdb_real_escape_string($_url) . "'";
            }

            if ($debug) {
                echo "\n// Where: {$where}\n";
            }

            $car_data = get_car_data($cron_name, $where);
        } else {
            if (!$car_data && (!$vdp_page_regex || preg_match($vdp_page_regex, $ref_url)) && is_array($required_params)) {
                $where = create_url_where($ref_url, $required_params);

                if ($debug) {
                    echo "\n//Where: $where\n";
                }

                if ($where) {
                    $car_data = get_car_data($cron_name, $where);
                }
            }
        }

        if ($debug) {
            foreach ($car_data as $key => $value) {
                echo "\n// {$key}  ==>  {$value}\n";
            }
        }

        if (isset($redis)) {
            $redis->set($car_data_key, serialize($car_data));
            $redis->expire($car_data_key, $redis_cache_duration);

            if ($debug) {
                echo "\n// car data has been stored in redis.\n";
            }
        }

        return $car_data;
    }
}

/**
 * Gets the client ip.
 *
 * @return     string  The client ip.
 */
function get_client_ip()
{
    $ipaddress = '';

    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
}

/**
 * Gets all client ip.
 *
 * @return     string  All client ip.
 */
function get_all_client_ip()
{
    $ipaddress = '';

    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
}
