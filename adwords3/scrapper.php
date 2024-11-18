<?php

global $redis, $redis_config, $brands;

require_once __DIR__ . "/db-config.php";
require_once __DIR__ . "/config.php";
require_once dirname(__DIR__) . '/dashboard/config.php';
require_once dirname(__DIR__) . '/dashboard/includes/functions.php';
require_once dirname(__DIR__) . '/dashboard/includes/search-inventory.php';
require_once __DIR__ . '/utils.php';
require_once dirname(__DIR__) . '/cartracker/car_tracker.php';

use Predis\Client as RedisClient;

if (!$redis) {
    $redis = new RedisClient($redis_config);
}

/**
 * { function_description }
 *
 * @param      string  $cron_name         The cron name
 * @param      <type>  $scrapper_config   The scrapper configuration
 * @param      <type>  $CurrentConfig     The current configuration
 * @param      <type>  $carlist           The carlist
 * @param      <type>  $advanced_carlist  The advanced carlist
 */
function Scrap($cron_name, $scrapper_config, $CurrentConfig, $carlist, $advanced_carlist)
{
    global $brands;

    $distances = [
        '25'  => '25 km Radius',
        '50'  => '50 km Radius',
        '100' => '100 km Radius',
        '150' => '150 km Radius',
        '200' => '200 km Radius',
        '300' => '300 km Radius',
        '400' => '400 km Radius',
        '500' => '500 km Radius',
        '-1'  => 'Nation wide'
    ];

    do_action('initialize_' . $cron_name . '_scrap');

    $db_connect = new DbConnect($cron_name);

    // Set dealership default
    $default_dealership = [
        'dealership'        => $cron_name,
        'saler_type'        => 'Dealership',
        'company_name'      => $cron_name,
        'group_name'        => '',
        'phone'             => '',
        'websites'          => '',
        'address'           => '',
        'city'              => '',
        'state'             => '',
        'post_code'         => '',
        'billing_address'   => '',
        'billing_city'      => '',
        'billing_state'     => '',
        'billing_post_code' => '',

        'website_rep'       => [
            'name'  => '',
            'email' => '',
            'phone' => '',
        ],

        'company_rep'       => [
            'name'  => '',
            'email' => '',
            'phone' => '',
        ],

        'inventories'       => [],
        'campaign_types'    => [],
        'start_date'        => 0,
        'end_date'          => 0,
        'last_contacted'    => 0,
        'happiness'         => 76,
        'status'            => 'active'
    ];

    $dealership = $db_connect->get_dealer_details($cron_name);

    if (!$dealership) {
        $db_connect->store_dealer_details($cron_name, $default_dealership);
    }

    // END Set dealership default
    $entry_points = apply_filters('filter_' . $cron_name . '_entry_points', $scrapper_config['entry_points']);

    // Get required params
    $required_params = [];

    if (isset($scrapper_config['required_params'])) {
        $required_params = $scrapper_config['required_params'];
    }

    // Don't need scrap
    if ($dealership['no_scrap']) {
        slecho("Found 'no_scrap' = 'true' in DB for {$cron_name} and stopping scraping.");
        return;
    }

    // some scrapper config is present for non dealers lead tracking
    if (isset($scrapper_config['no_scrap']) && $scrapper_config['no_scrap']) {
        slecho("Found 'no_scrap' = 'true' for $cron_name and stopping scraping.");
        return;
    }

    /*
     * @An additional parameter on scrapper config file scrapper_type
     * @This field is also available in DB as 'scrapper_type' in dealerships table
     * @scrapper_type could be default (RegEx), VS, marketcheck, NLP, CSV
     * @if scrapper_type don't exist or value not equals to default just return
     */
    if (isset($scrapper_config['scrapper_type']) && $scrapper_config['scrapper_type'] != 'default') {
        return;
    }

    $current_svin_table = $db_connect->get_car_table();
    $match              = null;
    $unrefined_cars     = [];
    $unique_car_urls    = [];
    $unique_list_urls   = [];
    $car_picked         = 0;
    $next_page_ok       = false;
    $other_regex_fail   = false;
    $website_fail       = false;
    $refine_fail        = false;
    $ranking_cars       = [];
    $total_images       = 0;
    $total_time_on_page = 0;
    $total_descriptions = 0;
    $total_days         = 0;
    $total_count        = 0;

    // Car Tracker Data
    $ct_sold_cars = [];
    $ct_vinset    = [];
    $ct_stkset    = [];
    $ct_urlset    = [];

    $car_tracker = new CarTracker();
    $car_tracker->getSoldCarDataSet($cron_name, $ct_sold_cars, $ct_vinset, $ct_stkset, $ct_urlset, $db_connect);

    $domain = getDealerDomain($cron_name);
    $db_connect->update_meta('dealer_domain', $domain, $cron_name);
    slecho("Dealer Domain Name: $domain");

    $analytics     = new Analytics(get_current_google_customer());
    $profileId_key = "{$cron_name}_profileId";
    $profileId     = $db_connect->get_meta('dealer_domain', $profileId_key);

    if (!$profileId) {
        slecho("Retriving analytic profileId");
        $profileId = retrive_best_profileId($analytics, $domain);

        if ($profileId) {
            $db_connect->update_meta('dealer_domain', $profileId_key, $profileId);
        }
    }

    slecho("Analytics profileId: {$profileId}");

    $date = new DateTime(date('Y-m-d'));
    $date->sub(new DateInterval('P1M')); // For average time on page, always consider a month

    $startDate = $date->format('Y-m-d');
    $endDate   = date('Y-m-d');

    $metrics    = array('ga:pageviews', 'ga:avgTimeOnPage', 'ga:bounceRate');
    $dimensions = array('ga:pagePath');
    $filters    = '';

    slecho("Retriving analytics report");
    $analyticsReport = get_analytics_report($analytics, $profileId, $startDate, $endDate, $metrics, $dimensions, $filters);
    $brands          = [];

    foreach ($entry_points as $stock_type => $entry_point_array) {
        if (!is_array($entry_point_array)) {
            $entry_point_array = array($entry_point_array);
        }

        $parsing_config = $scrapper_config;

        if (isset($parsing_config[$stock_type])) {
            $parsing_config = $scrapper_config[$stock_type];
        }

        foreach ($entry_point_array as $entry_point) {
            slecho("Processing stock_type: {$stock_type}, entry_point: {$entry_point}");
            $additional_headers     = isset($parsing_config['additional_headers']) ? $parsing_config['additional_headers'] : [];
            $content_type           = isset($parsing_config['content_type']) ? $parsing_config['content_type'] : 'application/x-www-form-urlencoded';
            $next_method            = isset($parsing_config['next_method']) ? $parsing_config['next_method'] : 'GET';
            $init_method            = isset($parsing_config['init_method']) ? $parsing_config['init_method'] : $next_method;
            $next_processor         = function_exists($cron_name . '_next_processor') ? $cron_name . '_next_processor' : false;
            $annoy_func           = isset($parsing_config['annoy_func']) ? $parsing_config['annoy_func'] : null;
            $details_start_tag      = isset($parsing_config['details_start_tag']) ? $parsing_config['details_start_tag'] : false;
            $details_end_tag        = isset($parsing_config['details_end_tag']) ? $parsing_config['details_end_tag'] : false;
            $details_spliter        = isset($parsing_config['details_spliter']) ? $parsing_config['details_spliter'] : false;
            $data_capture_regx      = isset($parsing_config['data_capture_regx']) ? $parsing_config['data_capture_regx'] : [];
            $custom_data_capture    = isset($parsing_config['custom_data_capture']) ? $parsing_config['custom_data_capture'] : false;
            $must_contain_regx      = isset($parsing_config['must_contain_regx']) ? $parsing_config['must_contain_regx'] : false;
            $must_not_contain_regx  = isset($parsing_config['must_not_contain_regx']) ? $parsing_config['must_not_contain_regx'] : false;
            $data_capture_regx_full = isset($parsing_config['data_capture_regx_full']) ? $parsing_config['data_capture_regx_full'] : false;
            $next_page_regx         = isset($parsing_config['next_page_regx']) ? $parsing_config['next_page_regx'] : false;
            $next_query_regx        = isset($parsing_config['next_query_regx']) ? $parsing_config['next_query_regx'] : false;
            $images_regx            = isset($parsing_config['images_regx']) ? $parsing_config['images_regx'] : false;
            $images_fallback_regx   = isset($parsing_config['images_fallback_regx']) ? $parsing_config['images_fallback_regx'] : false;
            $images_proc            = function_exists($cron_name . '_images_proc') ? $cron_name . '_images_proc' : false;
            $auto_texts_regx        = isset($parsing_config['auto_texts_regx']) ? $parsing_config['auto_texts_regx'] : false;
            $proxy                  = isset($scrapper_config['use-proxy']) && $scrapper_config['use-proxy'] ? $scrapper_config['proxy'] : false;
            $refine                 = isset($scrapper_config['refine']) ? $parsing_config['refine'] : true;
            $number_of_retries      = isset($scrapper_config['number_of_retries']) ? $scrapper_config['number_of_retries'] : 0;
            $options_start_tag      = isset($parsing_config['options_start_tag']) ? $parsing_config['options_start_tag'] : null;
            $options_end_tag        = isset($parsing_config['options_end_tag']) ? $parsing_config['options_end_tag'] : null;
            $options_regx           = isset($parsing_config['options_regx']) ? $parsing_config['options_regx'] : null;

            $url         = $entry_point;
            $post_data   = apply_filters('filter_' . $cron_name . '_post_data', '', $stock_type, '');
            $in_cookies  = '';
            $out_cookies = '';

            $method = $init_method;
            $count  = 0;

            while ($url) {
                $in_cookies = apply_filters('filter_' . $cron_name . '_cookies', $in_cookies, $stock_type);
                $count++;

                if ($method != 'POST') {
                    if (in_array($url, $unique_list_urls)) {
                        slecho(date('d-m-Y-H:i:s', time()) . " :: Notice: listing page url already downloaded, skipping: " . $url);
                        $url = false;
                        continue;
                    }

                    slecho(date('d-m-Y-H:i:s', time()) . " :: Requesting {$url} using '{$method}' request");
                    $data       = HttpGet($url, $proxy, !!$proxy, $in_cookies, $out_cookies, $content_type, $additional_headers, $annoy_func);
                    $in_cookies = $out_cookies;

                    if ($data) {
                        $unique_list_urls[] = $url;
                    }

                    slecho('--->' . $count . ': ' . $url);
                } else {
                    if (in_array($url . '-POST-' . $post_data, $unique_list_urls)) {
                        slecho('Notice: list page url already downloaded (POST), skipping: ' . $url . '-POST-' . $post_data);

                        $url = false;
                        continue;
                    }

                    slecho(date('d-m-Y-H:i:s', time()) . " :: Requesting {$url} using HTTP POST request with post data {$post_data}.");
                    $data = HttpPost($url, $post_data, $in_cookies, $out_cookies, $proxy, !!$proxy, $content_type, $additional_headers, $annoy_func);

                    if ($data) {
                        $unique_list_urls[] = $url . '-POST-' . $post_data;
                    }

                    slecho('--->' . $count . ': ' . $url . '-POST-' . $post_data);

                    if ($out_cookies != '') {
                        $in_cookies = $out_cookies;
                    }
                }

                // Switch to next method
                $method = $next_method;

                if ($data) {
                    $data = apply_filters('filter_' . $cron_name . '_data', $data, $stock_type);
                    $temp = $data;
                    // This two line is written this way because that $data is used later
                    // $temp = apply_filters('filter_' . $cron_name . '_data', $data);
                    // is not the right thing, when a scrapper config needed to use
                    // this filter to modify data downloaded from server
                    // As $temp is modified in between, $data is used as a backup for later usese ($used by next_page and next_query)

                    if ($details_start_tag) {
                        $temp = substr($temp, stripos($temp, $details_start_tag));
                    }

                    if ($details_end_tag) {
                        $temp = substr($temp, 0, stripos($temp, $details_end_tag));
                    }

                    $spltd = $temp;

                    if ($details_spliter) {
                        $spltd = explode($details_spliter, $temp);
                    }

                    slecho(date('d-m-Y-H:i:s', time()) . " :: DEBUG: " . count($spltd) . " pieces of information.");

                    if (!$custom_data_capture) {
                        $all_capture_fields = array_fill_keys(array_merge(array_keys($data_capture_regx), array_keys($data_capture_regx_full)), false);

                        foreach ($spltd as $str) {
                            if ($must_contain_regx) {
                                if (!preg_match($must_contain_regx, $str)) {
                                    slecho(date('d-m-Y-H:i:s', time()) . " :: Info: Car does not fulfill required criteria of must_contain_regx");
                                    continue;
                                }
                            }

                            if ($must_not_contain_regx) {
                                if (preg_match($must_not_contain_regx, $str)) {
                                    slecho(date('d-m-Y-H:i:s', time()) . " :: Info: Car does not fulfill required criteria of must_not_contain_regx");
                                    continue;
                                }
                            }

                            $str = apply_filters('filter_' . $cron_name . '_single_data', $str);

                            if (!$str) {
                                continue;
                            }

                            $car_data  = [];
                            $logbuffer = '';

                            foreach ($data_capture_regx as $key => $regx) {
                                if (preg_match($regx, $str, $match)) {
                                    if (array_key_exists($key, $match)) {
                                        $car_data[$key]           = str_replace("\n", '', $match[$key]);
                                        $car_data[$key]           = apply_filters('filter_' . $cron_name . '_field_' . $key, $car_data[$key], $car_data, $str);
                                        $all_capture_fields[$key] = true;
                                    } else {
                                        $nval = apply_filters('filter_' . $cron_name . '_field_' . $key, null, $car_data, $str);

                                        if ($nval) {
                                            $car_data[$key] = $nval;
                                        }

                                        $logbuffer .= 'Error - missing match for: ' . $key . "\n";
                                        $logbuffer .= print_r($match, true) . "\n";
                                    }
                                } else {
                                    $nval = apply_filters('filter_' . $cron_name . '_field_' . $key, null, $car_data, $str);

                                    if ($nval) {
                                        $car_data[$key] = $nval;
                                    }

                                    $logbuffer .= 'Error in regx:' . $key . "\n";
                                }
                            }

                            if (!array_key_exists('make', $car_data)) {
                                $logbuffer .= 'Notice: no make found initially' . "\n";
                            } elseif (isset($parsing_config[$car_data['make']])) {
                                $make_capture_regx = $parsing_config[$car_data['make']];

                                foreach ($make_capture_regx as $key => $regx) {
                                    if (preg_match($regx, $str, $match)) {
                                        $car_data[$key]           = str_replace("\n", '', $match[$key]);
                                        $all_capture_fields[$key] = true;
                                    }
                                }
                            }

                            if ($auto_texts_regx) {
                                if (preg_match_all($auto_texts_regx, $str, $match)) {
                                    if (isset($match['auto_text'])) {
                                        $auto_texts             = +implode('|', $match['auto_text']); // "Expected type 'array'. Found 'string'."
                                        $car_data['auto_texts'] = $auto_texts;
                                    } else {
                                        $logbuffer .= "Error - missing match for auto_texts\n";
                                    }
                                } else {
                                    $logbuffer .= "Error in regx: auto_texts\n";
                                }
                            }

                            if (!isset($car_data['url'])) {
                                slecho(date('d-m-Y-H:i:s', time()) . " :: DEBUG: URL regex probably failed and I can not store");
                                $other_regex_fail |= true; // URL regex probably failed and I can not store
                                continue;
                            }

                            $car_data['url'] = urlCombine($entry_point, $car_data['url']);

                            if (!isset($car_data['stock_type']) || !$car_data['stock_type']) {
                                $car_data['stock_type'] = $stock_type;
                            }

                            if (in_array($car_data['url'], $unique_car_urls[$stock_type])) {
                                slecho(date('d-m-Y-H:i:s', time()) . " :: Notice: car url already downloaded : " . $car_data['url']);
                                continue;
                            }

                            // store svin form url
                            if (!isset($car_data['svin']) && $car_data['url']) {
                                $car_data['svin'] = url_to_svin($car_data['url'], $required_params);
                            }

                            $unique_car_urls[$stock_type][] = $car_data['url'];

                            foreach (explode("\n", $logbuffer) as $logline) {
                                slecho(date('d-m-Y-H:i:s', time()) . " :: " . $logline);
                            }

                            // GET VDP DATA
                            $_temp      = HttpGet($car_data['url'], $proxy, !!$proxy, $in_cookies, $out_cookies, $content_type, $additional_headers, $annoy_func);
                            $in_cookies = $out_cookies;
                            $temp       = apply_filters("filter_{$cron_name}_vdp_data", $_temp);
                            $payload    = [
                                'svin'        => $car_data['svin'],
                                'url'         => $car_data['url'],
                                'page_source' => $_temp,
                            ];

                            // start of scraping options
                            if ($options_start_tag && $options_end_tag && $options_regx) {
                                $options_data = substr($temp, stripos($temp, $options_start_tag));
                                $options_data = substr($options_data, 0, stripos($options_data, $options_end_tag));

                                if ($options_data !== '') {
                                    preg_match_all($options_regx, $options_data, $match);
                                    $options = $match['option'];

                                    if (is_array($options)) {
                                        $car_data['options'] = json_encode($options);
                                    }
                                }
                            } else {
                                $car_data['options'] = '[]';
                            }
                            // end of scraping options

                            // get images
                            if ($images_regx && preg_match_all($images_regx, $temp, $match)) {
                                if (isset($match['img_url'])) {
                                    slecho(date('d-m-Y-H:i:s', time()) . " :: DEBUG notice: entering image proccessing loop");
                                    $im_urls = [];

                                    for ($i = 0, $match_len = count($match['img_url']); $i < $match_len; $i++) {
                                        $im_part = $match['img_url'][$i];

                                        if ($images_proc) {
                                            $im_part = $images_proc($im_part);
                                        }

                                        $im_urls[$i] = urlCombine($car_data['url'], $im_part);
                                    }

                                    $car_data['images']     = apply_filters("filter_{$cron_name}_field_images", $im_urls, $car_data, $temp);
                                    $image_urls             = implode('|', $car_data['images']);
                                    $car_data['all_images'] = $image_urls;
                                }
                            } elseif ($images_fallback_regx && preg_match_all($images_fallback_regx, $temp, $match)) {
                                if (isset($match['img_url'])) {
                                    $im_urls = [];

                                    for ($i = 0, $match_len = count($match['img_url']); $i < $match_len; $i++) {
                                        $im_part = $match['img_url'][$i];

                                        if ($images_proc) {
                                            $im_part = $images_proc($im_part);
                                        }

                                        $im_urls[$i] = urlCombine($car_data['url'], $im_part);
                                    }

                                    $car_data['images']     = apply_filters("filter_{$cron_name}_field_images", $im_urls, $car_data, $temp);
                                    $image_urls             = implode('|', $car_data['images']);
                                    $car_data['all_images'] = $image_urls;
                                }
                            } else {
                                if (!strlen(trim($temp))) {
                                    slecho(date('d-m-Y-H:i:s', time()) . " :: DEBUG : empty page at " . $car_data['url']);
                                    slecho(date('d-m-Y-H:i:s', time()) . " :: DEBUG : possible network error!");
                                } else {
                                    slecho(date('d-m-Y-H:i:s', time()) . " :: DEBUG: no images matched for " . $car_data['url']);
                                    logme_nostrip(date('d-m-Y-H:i:s', time()) . " :: DEBUG: using regx: " . $images_regx);
                                    $debfname = __DIR__ . '/imddebug_cache/' . md5($temp);
                                    file_put_contents($debfname, $temp);
                                    slecho(date('d-m-Y-H:i:s', time()) . " :: DEBUG: page dumped to " . $debfname);
                                }

                                // Fire filter even for no images, scrapper-config may have something
                                $car_data['images']     = apply_filters("filter_{$cron_name}_field_images", [], $car_data, $temp);
                                $image_urls             = implode('|', $car_data['images']);
                                $car_data['all_images'] = $image_urls;
                            }
                            // image section end

                            // get data from vdp
                            if ($data_capture_regx_full) {
                                foreach ($data_capture_regx_full as $key => $regx) {
                                    if (preg_match($regx, $temp, $match)) {
                                        if (array_key_exists($key, $match)) {
                                            $car_data[$key]           = str_replace("\n", '', $match[$key]);
                                            $car_data[$key]           = apply_filters('filter_' . $cron_name . '_field_' . $key, $car_data[$key], $car_data, $temp);
                                            $all_capture_fields[$key] = true;
                                        } else {
                                            $nval = apply_filters('filter_' . $cron_name . '_field_' . $key, null, $car_data, $temp);

                                            if ($nval) {
                                                $car_data[$key] = $nval;
                                            }

                                            slecho(date('d-m-Y-H:i:s', time()) . " :: Error: missing match (full) for " . $key . "\n");
                                        }
                                    } else {
                                        $nval = apply_filters('filter_' . $cron_name . '_field_' . $key, null, $car_data, $temp);

                                        if ($nval) {
                                            $car_data[$key] = $nval;
                                        }

                                        slecho(date('d-m-Y-H:i:s', time()) . " :: Error in regx (full): " . $key . "\n");
                                    }
                                }
                            }
                            // vdp data collection end

                            if (!isset($car_data['make']) || !isset($car_data['model'])) {
                                slecho(date('d-m-Y-H:i:s', time()) . " :: Info: Make or Model data could not be picked for Make '"
                                    . $car_data['make'] . "' and Model '"
                                    . $car_data['model'] . "' cron name " . $cron_name);

                                slecho(date('d-m-Y-H:i:s', time()) . " :: DEBUG: Posibly Make Model Regex Failed");
                                $other_regex_fail |= true; // Posibly Make Model Regex Fail

                                continue;
                            }

                            if (!isset($car_data['price'])) {
                                $car_data['price'] = 'Please Call';
                            }

                            if (!isset($car_data['stock_number']) || !trim($car_data['stock_number'])) {
                                $car_data['stock_number'] = md5($car_data['url']);
                            }

                            if (!isset($car_data['title'])) {
                                $car_data['title'] = $car_data['year'] . ' ' . $car_data['make'] . ' ' . $car_data['model'];
                            }

                            // exception?
                            $car_data['title'] = preg_replace('/\b[Ff] ?- ?(?<m>[0-9]{3})\b/', 'F-$1', $car_data['title']);
                            slecho(date('d-m-Y-H:i:s', time()) . " :: DEBUG true field count");
                            $buffer = '';

                            foreach ($all_capture_fields as $key => $field) {
                                if ($field) {
                                    $buffer .= " %+$key% ";
                                } else {
                                    $buffer .= " %-$key% ";
                                }
                            }

                            slecho(date('d-m-Y-H:i:s', time()) . " :: " . $buffer);

                            if ($refine) {
                                // Apply Smart Scrapper to car data
                                $refined = RefineCarData($car_data, $carlist, $advanced_carlist);
                            } else {
                                $refined = true;
                            }

                            if (!$refined) {
                                $unrefined_cars[] = '<a href="' . $car_data['url'] . '">' . $car_data['title'] . '</a>';

                                if (isset($scrapper_config['avoid_carlist']) && $scrapper_config['avoid_carlist']) {
                                    // Do nothing for now
                                } else {
                                    $db_connect->store_matched_title($car_data['title'], $car_data['url']);
                                    slecho(date('d-m-Y-H:i:s', time()) . " :: Info: Unable to refine car data");
                                    $refine_fail = true;
                                    continue;
                                }
                            }

                            foreach ($car_data as $key => $value) {
                                $car_data[$key] = trim(strip_tags($value));
                            }

                            store_and_process($cron_name, $car_data, $car_picked, $db_connect, $search, $analyticsReport, $total_images, $total_time_on_page, $total_descriptions, $total_days, $total_count, $ranking_cars, $other_regex_fail, $current_svin_table);

                            // Re add tracking
                            $reAddPayload = $car_tracker->isReAdded($car_data, $ct_sold_cars, $ct_vinset, $ct_stkset, $ct_urlset, $required_params);

                            if ($reAddPayload) {
                                $previous_car    = $reAddPayload['old_car'];
                                $reAddDeterminer = $reAddPayload['identifier'];

                                $actual_payload = [
                                    'svin'                  => $previous_car['svin'],
                                    'current_svin'          => $car_data['svin'],
                                    'current_url'           => $car_data['url'],
                                    'previous_url'          => $previous_car['url'],
                                    'current_stock_number'  => $car_data['stock_number'],
                                    'previous_stock_number' => $previous_car['stock_number'],
                                    'current_vin'           => $car_data['vin'],
                                    'previous_vin'          => $previous_car['vin'],
                                    'stock_type'            => $car_data['stock_type'],
                                    'year'                  => $car_data['year'],
                                    'make'                  => $car_data['make'],
                                    'model'                 => $car_data['model'],
                                    'title'                 => $car_data['title'],
                                    'readded_by'            => $reAddDeterminer,
                                    'readded_at'            => time(),
                                    'arrival_date'          => $previous_car['arrival_date'],
                                    'deleted_at'            => $previous_car['deleted_at'],
                                ];

                                $db_connect->store_readd_car($actual_payload);
                            }
                        }
                    } else {
                        $cars = $custom_data_capture($url, $spltd);

                        foreach ($cars as $car_data) {
                            if (!isset($car_data['stock_type']) || !$car_data['stock_type']) {
                                $car_data['stock_type'] = $stock_type;
                            }

                            if (!isset($car_data['svin']) || !$car_data['svin']) {
                                $car_data['svin'] = url_to_svin($car_data['url'], $required_params);
                            }

                            if ($images_regx) {
                                slecho(date('d-m-Y-H:i:s', time()) . " :: DEBUG notice: images_regx found.");
                                $_temp      = HttpGet($car_data['url'], $proxy, !!$proxy, $in_cookies, $out_cookies, $content_type, $additional_headers, $annoy_func);
                                $in_cookies = $out_cookies;
                                $temp       = apply_filters("filter_{$cron_name}_vdp_data", $_temp);
                                $payload    = [
                                    'svin'        => $car_data['svin'],
                                    'url'         => $car_data['url'],
                                    'page_source' => $_temp,
                                ];

                                if ($images_regx && preg_match_all($images_regx, $temp, $match)) {
                                    if (isset($match['img_url'])) {
                                        slecho(date('d-m-Y-H:i:s', time()) . " :: DEBUG notice: entering image proc loop.");
                                        $im_urls = [];

                                        for ($i = 0, $c = count($match['img_url']); $i < $c; $i++) {
                                            $im_part = $match['img_url'][$i];

                                            if ($images_proc) {
                                                $im_part = $images_proc($im_part);
                                            }

                                            $im_urls[$i] = urlCombine($car_data['url'], $im_part);
                                        }

                                        $car_data['images']     = apply_filters("filter_{$cron_name}_field_images", $im_urls, $car_data);
                                        $image_urls             = implode('|', $car_data['images']);
                                        $car_data['all_images'] = $image_urls;
                                    }
                                }

                                slecho(date('d-m-Y-H:i:s', time()) . " :: DEBUG notice: No images found");
                            }

                            store_and_process($cron_name, $car_data, $car_picked, $db_connect, $search, $analyticsReport, $total_images, $total_time_on_page, $total_descriptions, $total_days, $total_count, $ranking_cars, $other_regex_fail, $current_svin_table);

                            // Re add tracking
                            $reAddPayload = $car_tracker->isReAdded($car_data, $ct_sold_cars, $ct_vinset, $ct_stkset, $ct_urlset, $required_params);

                            if ($reAddPayload) {
                                $previous_car    = $reAddPayload['old_car'];
                                $reAddDeterminer = $reAddPayload['identifier'];

                                $actual_payload = [
                                    'svin'                  => $previous_car['svin'],
                                    'current_svin'          => $car_data['svin'],
                                    'current_url'           => $car_data['url'],
                                    'previous_url'          => $previous_car['url'],
                                    'current_stock_number'  => $car_data['stock_number'],
                                    'previous_stock_number' => $previous_car['stock_number'],
                                    'current_vin'           => $car_data['vin'],
                                    'previous_vin'          => $previous_car['vin'],
                                    'stock_type'            => $car_data['stock_type'],
                                    'year'                  => $car_data['year'],
                                    'make'                  => $car_data['make'],
                                    'model'                 => $car_data['model'],
                                    'title'                 => $car_data['title'],
                                    'readded_by'            => $reAddDeterminer,
                                    'readded_at'            => time(),
                                    'arrival_date'          => $previous_car['arrival_date'],
                                    'deleted_at'            => $previous_car['deleted_at'],
                                ];

                                $db_connect->store_readd_car($actual_payload);
                            }
                        }
                    }

                    // get next url
                    if ($next_page_regx) {
                        if (preg_match($next_page_regx, $data, $match)) {
                            $url2 = apply_filters("filter_{$cron_name}_next_page", urlCombine($entry_point, $match['next']), $url, $next_page_regx, $data);

                            if ($url == $url2) {
                                slecho(date('d-m-Y-H:i:s', time()) . " :: Error next page: same url " . $url);
                                $url = false;
                            } else {
                                $url = $url2;
                                slecho(date('d-m-Y-H:i:s', time()) . " :: Notice next page: " . $url);
                            }

                            $next_page_ok |= true;
                        } else {
                            $url = false;
                            slecho(date('d-m-Y-H:i:s', time()) . " :: Error next page - regular expression failed.");
                        }
                    } elseif ($next_query_regx) {
                        if (preg_match($next_query_regx, $data, $match)) {
                            $param = $match['param'];
                            $value = $match['value'];

                            $next_page_ok |= true;

                            if ($next_processor) {
                                $value = $next_processor($param, $value);
                            }

                            if ($value) {
                                if ($method == 'GET') {
                                    $get_data = apply_filters('filter_' . $cron_name . '_post_data', "{$param}={$value}", $stock_type, $data);
                                    $url2     = urlCombine($entry_point, "?{$get_data}");
                                } else {
                                    $url2          = $entry_point;
                                    $cur_post_data = apply_filters('filter_' . $cron_name . '_post_data', "{$param}={$value}", $stock_type, $data);
                                }

                                if ($url == $url2) {
                                    if ($method != 'POST') {
                                        $url = false;
                                    } else {
                                        if ($cur_post_data && $cur_post_data != $post_data) {
                                            $url       = $url2;
                                            $post_data = $cur_post_data;
                                        } else {
                                            $url = false;
                                        }
                                    }
                                } else {
                                    $url = $url2;
                                }
                            } else {
                                $url = false;
                            }
                        } else {
                            slecho(date('d-m-Y-H:i:s', time()) . " :: Error next page - POST regular expression failed.");
                            $url = false;
                        }
                    } else {
                        $url          = false;
                        $next_page_ok = true;
                    }
                } else {
                    if ($number_of_retries == 0) {
                        $url = false;
                        slecho(date('d-m-Y-H:i:s', time()) . " :: ERROR: Unable to connect.");
                        $website_fail = true;

                        send_fatal_scrapper_issue_email($cron_name, $car_picked, $website_fail, !$next_page_ok, $other_regex_fail, $refine_fail, $dealership);

                        return;
                    } else {
                        $number_of_retries--;
                        slecho(date('d-m-Y-H:i:s', time()) . " :: Unable to connect. Trying another proxy.");
                    }
                }
            }

            slecho(date('d-m-Y-H:i:s', time()) . " :: DEBUG notice entry count end: " . $count);
        }
    }

    slecho(date('d-m-Y-H:i:s', time()) . " :: DEBUG notice: total $stock_type cars " . count($unique_car_urls[$stock_type]) . ", total list pages " . count($unique_list_urls));

    if (!$website_fail && $car_picked > 0) {
        // finally delete removed stocks
        // Optimize to delete via a single query instead of a loop.
        $deleteSvinList = [];

        if ($current_svin_table) {
            foreach ($current_svin_table as $svin => $val) {
                if (!$val) {
                    // $db_connect->delete_car_data($svin);
                    $deleteSvinList[] = $svin;
                }
            }

            if (count($deleteSvinList)) {
                $db_connect->delete_car_data_by_svin_list($deleteSvinList);
            }
        }

        $avg_images       = round($total_images / $total_count);
        $avg_time_on_page = round($total_time_on_page / $total_count, 2);
        $avg_desc         = round($total_descriptions / $total_count);
        $avg_days         = round($total_days / $total_count);

        foreach ($ranking_cars as $stock_number => $car) {
            $ranking_cars[$stock_number]['rank_data']['avg_image_count']  = $avg_images;
            $ranking_cars[$stock_number]['rank_data']['avg_desc_count']   = $avg_desc;
            $ranking_cars[$stock_number]['rank_data']['avg_day_count']    = $avg_days;
            $ranking_cars[$stock_number]['rank_data']['avg_time_on_page'] = $avg_time_on_page;
            $points                                                       = calculate_points($ranking_cars[$stock_number]['rank_data']);
            $ranking_cars[$stock_number]['rank_data']['quality_score']    = $points;
            $db_connect->store_rank_data($stock_number, $ranking_cars[$stock_number]['rank_data']);
        }
    } else {
        send_fatal_scrapper_issue_email($cron_name, $car_picked, $website_fail, !$next_page_ok, $other_regex_fail, $refine_fail, $dealership);
    }

    $db_connect->store_dealer_details($cron_name, ['brands' => $brands]);

    do_action('finalize_' . $cron_name . '_scrap');
}

/**
 * Stores and process.
 *
 * @param      string     $cron_name            The cron name
 * @param      <type>     $car_data             The car data
 * @param      integer    $car_picked           The car picked
 * @param      DbConnect  $db_connect           The database connect
 * @param      <type>     $search               The search
 * @param      <type>     $analyticsReport      The analytics report
 * @param      <type>     $total_images         The total images
 * @param      integer    $total_time_on_page   The total time on page
 * @param      <type>     $total_descriptions   The total descriptions
 * @param      <type>     $total_days           The total days
 * @param      integer    $total_count          The total count
 * @param      <type>     $ranking_cars         The ranking cars
 * @param      <type>     $other_regex_fail     The other regular expression fail
 * @param      <type>     $current_svin_table  The current svin table
 */
function store_and_process($cron_name, &$car_data, &$car_picked, DbConnect &$db_connect, &$search, &$analyticsReport, &$total_images, &$total_time_on_page, &$total_descriptions, &$total_days, &$total_count, &$ranking_cars, &$other_regex_fail, &$current_svin_table)
{
    global $brands;

    $car_data = apply_filters('filter_' . $cron_name . '_car_data', $car_data);

    if (!$car_data) {
        slecho(date('d-m-Y-H:i:s', time()) . " :: Car is filtered out of the list due to no car data.");
        return;
    }

    if ($car_data['stock_type'] == 'new' && $car_data['make'] && !in_array($car_data['make'], $brands)) {
        $brands[] = $car_data['make'];
    }

    // THINK WHEN IT WILL FAIL?
    if ($car_data['stock_type'] == 'new') {
        $all_brands = $db_connect->get_meta('general_config', 'brands');

        if (!$all_brands) {
            $all_brands = [];
        }

        // IS IT ACTUALLY A PROPER MAKE?
        if ($car_data['make'] && !in_array($car_data['make'], $all_brands)) {
            $valid_make = '/^[a-zA-Z -]*$/';
            $matches = [];
            preg_match($valid_make, $car_data['make'], $matches);
            if (count($matches)) {
                $all_brands[] = $car_data['make'];
                $db_connect->update_meta('general_config', 'brands', $all_brands);
            } else {
                slecho(date('d-m-Y-H:i:s', time()) . " :: ERROR: Invalid make `{$car_data['make']}`");
            }
        }
    }

    $now = time();

    if (isset($car_data['svin'])) {
        $car_picked++;
        $car_data['model'] = str_replace($car_data['make'], '', $car_data['model']);

        $db_connect->store_car_data($car_data);

        $total_images += count($car_data['images']);
        $total_time_on_page += $avgTimeOnPage; // "Undefined variable '$avgTimeOnPage'
        $total_descriptions += strlen((string) $car_data['description']);
        $total_days += round(($now - $car_data['arrival_date']) / (86400));
        $total_count++;

        $ranking_cars[$car_data['stock_number']] = [
            'stock_number' => $car_data['stock_number'],

            'rank_data'    => [
                'price'        => numarifyPrice($car_data['price']),
                'image_count'  => count($car_data['images']),
                'desc_count'   => strlen((string) $car_data['description']),
                'day_count'    => round(($now - $car_data['arrival_date']) / (86400)), // 24 * 60 * 60 = 86400
                'time_on_page' => $avgTimeOnPage, // "Undefined variable '$avgTimeOnPage'
                'status'       => $car_data['status'],
            ],
        ];
    } else {
        slecho(date('d-m-Y-H:i:s', time()) . " :: DEBUG: SVIN is not present and hence data won\'t be stored.");
        $other_regex_fail |= true;
    }

    if (isset($current_svin_table[$car_data['svin']])) {
        $current_svin_table[$car_data['svin']] = true;
    }

    // display data
    foreach ($car_data as $key => $val) {
        slecho(date('d-m-Y-H:i:s', time()) . " :: " . $key . ": " . $val);
    }
}

/**
 * Sends a fatal scrapper issue email.
 *
 * @param      <type>   $cron_name         The cron name
 * @param      <type>   $car_scrapped      The car scrapped
 * @param      boolean  $website_fail      The website fail
 * @param      boolean  $next_regex_fail   The next regular expression fail
 * @param      boolean  $other_regex_fail  The other regular expression fail
 * @param      boolean  $refine_fail       The refine fail
 */
function send_fatal_scrapper_issue_email_old($cron_name, $car_scrapped, $website_fail, $next_regex_fail, $other_regex_fail, $refine_fail, $status)
{
    global $redis;

    if ($status !== 'active') {
        return;
    }

    $wf = $website_fail ? "Yes" : "No";
    $nf = $next_regex_fail ? "Yes" : "No";
    $of = $other_regex_fail ? "Yes" : "No";
    $rf = $refine_fail ? "Yes" : "No";

    $message = "Hello,<br/><br/>There is a fatal issue in '{$cron_name}' scrapper.<br/><br/>";
    $message .= "Car Scrapped:\t{$car_scrapped} <br/>";
    $message .= "Website Fail:\t{$wf} <br/>";
    $message .= "Next Fail:\t{$nf} <br/>";
    $message .= "Other Fail:\t{$of} <br/>";
    $message .= "Refine Fail:\t{$rf} <br/><br/>";
    $message .= "Status:\t<strong>{$status}</strong> <br/><br/>";
    $message .= 'Regards<br/><br/>Car Data Scrapper';

    $maillist = ['toufiq@smedia.ca', 'tanvir@smedia.ca'];

    SendEmail($maillist, 'reports@smedia.ca', "Unable to scrap from {$cron_name}", $message);

    $scrapper_fail_list = [];
    $scrapper_fail_key  = 'SCRAPPER_RAN_FAILED_RECENTLY';
    $scrapper_fail_val  = $redis->get($scrapper_fail_key);

    if ($scrapper_fail_val) {
        $scrapper_fail_list = unserialize($scrapper_fail_val);
    }

    $scrapper_fail_list[$cron_name] = [
        'website_fail'     => $wf,
        'next_regex_fail'  => $nf,
        'other_regex_fail' => $of,
        'refine_fail'      => $rf,
    ];

    $redis->set($scrapper_fail_key, serialize($scrapper_fail_list));
}

/**
 * Sends a fatal scrapper issue email.
 *
 * @param      <type>  $cron_name         The cron name
 * @param      <type>  $car_scrapped      The car scrapped
 * @param      bool    $website_fail      The website fail
 * @param      bool    $next_regex_fail   The next regular expression fail
 * @param      bool    $other_regex_fail  The other regular expression fail
 * @param      bool    $refine_fail       The refine fail
 * @param      <type>  $dealer_details    The dealer details
 */
function send_fatal_scrapper_issue_email($cron_name, $car_scrapped, $website_fail, $next_regex_fail, $other_regex_fail, $refine_fail, $dealer_details)
{
    global $redis;

    $wf = $website_fail ? "Yes" : "No";
    $nf = $next_regex_fail ? "Yes" : "No";
    $of = $other_regex_fail ? "Yes" : "No";
    $rf = $refine_fail ? "Yes" : "No";

    $status       = strtoupper($dealer_details['status']);
    $company_name = ucwords($dealer_details['company_name']);
    $mail_sub     = "Scraper broken for '{$company_name}'";
    $details_page = "https://tools.smedia.ca/dashboard/details.php?dealership={$cron_name}";
    $ad_feed_xml  = "https://tm.smedia.ca/dynamic-ad-feed.php?format=all&dealership={$cron_name}";
    $ad_feed_img  = "{$ad_feed_xml}&view=live";

    $upper_cron   = strtoupper($cron_name);
    $website      = $dealer_details['websites'];
    $now_time     = date('D, d-M-Y H:i:s', time());
    $web_rep      = $dealer_details['assigned_to'];
    $crep_name    = $dealer_details['company_rep']['name'];
    $crep_email   = $dealer_details['company_rep']['email'];
    $crep_phone   = $dealer_details['company_rep']['phone'];

    $email_body = <<<EMAIL
    Client:<br>
    <strong>{$company_name}</strong>: <i>{$details_page}</i><br>
    Facebook Dynamic Ad Feed:<br>
    Image View (All Format): <i>{$ad_feed_img}</i><br>
    XML View (All Format): <i>{$ad_feed_xml}</i><br>
    Dealership: {$upper_cron}<br>
    Website: <i>{$website}</i><br>
    sMedia Account Representative: {$web_rep}<br>
    Dealer Status: {$status}<br>
    Email Generated At: {$now_time}<br>
    <br>
    Company Representative:<br>
    Name : {$crep_name}<br>
    Email: {$crep_email}<br>
    Phone: {$crep_phone}<br>
    <br>
    Support Request:<br>
    Scraper is not performing as expected when the scraper ran last time. Please check the scraper, and the feeds.<br>
    <br>
    Scrapping Overview:<br>
    1. Website Fail   : {$wf}<br>
    2. Next Regex Fail: {$nf}<br>
    3. OtherRegex Fail: {$of}<br>
    4. Refine Fail    : {$rf}<br>
    5. Car Scrapped   : {$car_scrapped}<br>
EMAIL;

    $from          = "support@smedia.ca";
    $receipients   = ['toufiq@smedia.ca', 'error_reporting@smedia.ca', 'jarrett@smedia.ca', 'missy@smedia.ca', 'tanvir@smedia.ca', 'rezwana@smedia.ca'];

    if ($status == 'ACTIVE') {
        SendEmail($receipients, $from, $mail_sub, $email_body);
    }
}

/**
 * { function_description }
 *
 * @param      <type>   $car_data          The car data
 * @param      <type>   $carlist           The carlist
 * @param      <type>   $advanced_carlist  The advanced carlist
 *
 * @return     boolean  ( description_of_the_return_value )
 */
function RefineCarData(&$car_data, $carlist, $advanced_carlist)
{
    $year = $car_data['year'];
    $make = strtolower($car_data['make']);

    if (!isset($car_data['fuel_type']) || !$car_data['fuel_type']) {
        CheckFuelType($car_data);
    }

    if (!isset($carlist[$year])) {
        slecho(date('d-m-Y-H:i:s', time()) . " :: Info refine: Year ' . $year . ' is not present in car list.");
        return RefineAdvancedCarData($car_data, $advanced_carlist);
    }

    if (!isset($carlist[$year][$make])) {
        slecho(date('d-m-Y-H:i:s', time()) . " :: Info refine: Specs is not present for make " . $make);
        slecho(date('d-m-Y-H:i:s', time()) . " :: Warning: Unable to refine without make data.");

        if (isset($carlist['all_years'][$make])) {
            slecho(date('d-m-Y-H:i:s', time()) . " :: Info: $make is present all years data. It might be missing for $year");
            return RefineAdvancedCarData($car_data, $advanced_carlist);
        }

        return false;
    }

    $car_data['make'] = $carlist[$year][$make]['_name'];

    if (!isset($car_data['title'])) {
        slecho(date('d-m-Y-H:i:s', time()) . " :: Info refine: title not found :" . $car_data['title']);
        return RefineAdvancedCarData($car_data, $advanced_carlist);
    }

    $match = [];
    preg_match_all('/(?<w>\d+|\w+)/', $car_data['title'], $match);
    $words = $match['w'];

    $models = [];

    // Iterate through each word in title and try to match it with model and trim
    foreach ($words as $word) {
        if (strlen($word) < 3) {
            continue;
        }

        $word_regex = '/' . $word . '/i';

        if (strtolower($year) == strtolower($word)) {
            continue;
        }

        if (preg_match($word_regex, $make)) {
            continue; //skip it $word is the first word of $make
        }

        foreach ($carlist[$year][$make] as $c_model => $c_trims) {
            if ($c_model == '_name') {
                continue;
            }

            if (preg_match($word_regex, $c_model)) {
                if (isset($models[$c_model])) {
                    $models[$c_model]['w'] += 100;
                } else {
                    $models[$c_model] = array('w' => 100, 'trims' => []);
                }
            }

            foreach ($c_trims as $c_trim => $c_styles) {
                if (preg_match($word_regex, $c_trim)) {
                    if (!isset($models[$c_model])) {
                        $models[$c_model] = array('w' => 0, 'trims' => []);
                    }

                    if (isset($models[$c_model]['trims'][$c_trim])) {
                        $models[$c_model]['trims'][$c_trim] += 10;
                    } else {
                        $models[$c_model]['trims'][$c_trim] = 10;
                    }
                }
            }
        }
    }
    // end of title iteration

    if (defined('debug')) {
        echo '<pre>';
        print_r($carlist[$year][$make]);
        echo '</pre>';
    }

    if (count($models) > 0) {
        $value       = 0; #Model match need to occur
        $model_value = 0;
        $model       = null;
        $trim        = null;

        foreach ($models as $m => $v) {
            $model_matched = false; #Please don't switch it to true
            #We don't want bad data to be passed just because we don't have it in our databse

            preg_match_all('/(?<w>\d+|\w+)/', $m, $match);
            $actual_value    = $v['w'] - ((count($match['w']) - ($v['w'] / 100)) * 25);
            $models[$m]['w'] = $actual_value;

            if (count($v['trims']) > 0) {
                $total_value = $actual_value + max($v['trims']);
            } else {
                $total_value = $actual_value;
            }

            if ($total_value > $value && $actual_value >= $model_value) {
                $model         = $m;
                $trim          = '';
                $value         = $total_value;
                $model_value   = $actual_value;
                $model_matched = true;
            } else {
                continue;
            }

            if ($model_matched && count($v['trims']) > 0) {
                $max_trims = array_keys($v['trims'], max($v['trims']));
                $trim      = $max_trims[0];
            }
        }

        if (defined('debug')) {
            echo '<pre>';
            print_r($models);
            echo '</pre>';
        }

        if ($model != null) {
            // model name must be present in the title
            if (stripos($car_data['title'], $model) !== false) {
                $car_data['model'] = $model;
            } else {
                slecho(date('d-m-Y-H:i:s', time()) . " :: Info: Possible wrong model picked for {$car_data['title']}");
                return RefineAdvancedCarData($car_data, $advanced_carlist);
            }
        } else {
            slecho(date('d-m-Y-H:i:s', time()) . " :: Info refine: no model after iteration : " . $car_data['title']);
            return RefineAdvancedCarData($car_data, $advanced_carlist);
        }

        if ($trim) {
            $car_data['trim'] = $trim;
        } else {
            unset($car_data['trim']);
        }
    } else {
        slecho(date('d-m-Y-H:i:s', time()) . " :: Info: smart scrap fails to match any model or trim");
        return RefineAdvancedCarData($car_data, $advanced_carlist);
    }

    return RefineAdvancedCarData($car_data, $advanced_carlist);
}

/**
 * { function_description }
 *
 * @param      <type>  $car_data  The car data
 */
function CheckFuelType(&$car_data)
{
    global $fuel_type_carlist;

    $year  = $car_data['year'];
    $make  = $car_data['make'];
    $smake = strtolower($make);
    $model = $car_data['model'];

    if (isset($fuel_type_carlist[$year][$smake][$model])) {
        $car_data['fuel_type'] = $fuel_type_carlist[$year][$smake][$model];
    }
}

/**
 * { function_description }
 *
 * @param      <type>   $car_data  The car data
 * @param      <type>   $carlist   The carlist
 *
 * @return     boolean  ( description_of_the_return_value )
 */
function TryResolveMake(&$car_data, $carlist)
{
    $year  = $car_data['year'];
    $title = str_replace(')', ' ', str_replace('(', ' ', $car_data['title']));
    $words = explode(' ', $title);
    $makes = [];

    foreach ($words as $word) {
        $word       = str_replace('/', '\/', trim($word, ", \t\n\r\0\x0B-_"));
        $word_regex = '/\b' . $word . '\b/i';

        foreach ($carlist[$year] as $c_make => $m_details) {
            $m_name = $m_details['_name'];

            if (preg_match($word_regex, $m_name)) {
                if (isset($makes[$m_name])) {
                    $makes[$m_name] += 1;
                } else {
                    $makes[$m_name] = 1;
                }
            }
        }
    }

    if (count($makes) == 0) {
        return false;
    }

    $make = '';
    $max  = 0;

    foreach ($makes as $m => $v) {
        if ($v > $max) {
            $max  = $v;
            $make = $m;
        }
    }

    $car_data['make'] = $make;

    return true;
}

/**
 * { function_description }
 *
 * @param      <type>   $car_data          The car data
 * @param      <type>   $advanced_carlist  The advanced carlist
 *
 * @return     boolean  ( description_of_the_return_value )
 */
function RefineAdvancedCarData(&$car_data, $advanced_carlist)
{
    if ($car_data['trim']) {
        return true;
    }

    $year           = $car_data['year'];
    $make           = $car_data['make'];
    $smake          = strtolower($make);
    $model          = $car_data['model'];
    $body_style     = $car_data['body_style'];
    $sbody_style    = strtolower($body_style);
    $engine         = strtolower($car_data['engine']);
    $size_regex     = '/\b(?<size>[0-9]*\.[0-9]*)\s*[lL]\b/';
    $cyl_regex      = '/\b(?<count>[0-9]*)\s*cyl\b/';
    $engine_size    = null;
    $cylinder_count = null;
    $matches        = [];

    if (preg_match($size_regex, $engine, $matches)) {
        $engine_size = $matches['size'] * 1000;
    }

    if (preg_match($cyl_regex, $engine, $matches)) {
        $cylinder_count = $matches['count'];
    }

    $trims = isset($advanced_carlist[$year][$smake][$model]) ? $advanced_carlist[$year][$smake][$model] : null;

    if (!$trims) {
        slecho(date('d-m-Y-H:i:s', time()) . " :: Advanced matching failed. Trims are not found for {$year} {$make} {$model}.");
        return true;
    }

    $max_value      = 0;
    $best_trim_name = null;

    foreach ($trims as $trim_name => $trim) {
        $trim_value = 0;

        if ($sbody_style && stripos($trim['body_style'], $sbody_style) !== false) {
            $trim_value++;
        }

        if ($engine_size && $trim['engine_size'] == $engine_size) {
            $trim_value++;
        }

        if ($cylinder_count && $trim['cylinder_count'] == $cylinder_count) {
            $trim_value++;
        }

        if ($trim_value > $max_value) {
            $best_trim_name = $trim_name;
            $max_value      = $trim_value;
        }
    }

    if ($best_trim_name) {
        $car_data['trim'] = $best_trim_name;
        slecho(date('d-m-Y-H:i:s', time()) . " :: Advanced matching: best trim name for {$year} {$make} {$model} ({$engine}, {$body_style}) is {$best_trim_name}");
        return true;
    }

    return true;
}

/**
 * { function_description }
 *
 * @param      <type>  $con        The con
 * @param      <type>  $cron_name  The cron name
 * @param      <type>  $mutex      The mutex
 */
function ClearScrap($con, $cron_name, $mutex)
{
    $db_connect = new DbConnect($cron_name);
    $db_connect->clear_cron_data();
}
