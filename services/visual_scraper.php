<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

$base_dir     = dirname(__DIR__) . "/";
$adwords_dir  = $base_dir . "adwords3/";
$vs_cache_dir = $adwords_dir . 'caches/VS/';

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';
require_once $base_dir . '/visual-scraper/regex_generator.php';

global $scrapper_configs;

/* GET MANDATORY PARAMETERS */
$action = isset($_POST['act']) ? filter_input(INPUT_POST, 'act') : null;
$URL    = isset($_POST['url']) ? urldecode(filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL)) : null;

if (!$action || !$URL) {
    echo json_encode(['message' => 'No Such Action', 'success' => false, 'action' => 'error']);

    return;
}

/* GET THE DEALERSHIP NAME */
$db_connect = new DbConnect('');
$DEALERSHIP = getDomainDealer(GetDomain($URL), $URL);
$URL        = filter_url(htmlspecialchars($URL), $DEALERSHIP);

/**
 * { If dealership is unavailable return error. }
 */
if (!$DEALERSHIP) {
    echo json_encode(['message' => 'Dealership Not Found In sMedia Meta Table', 'success' => false, 'dealership' => null, 'action' => 'unavailable_dealer_get']);

    return;
}

$scraper_config  = $scrapper_configs[$DEALERSHIP];
$required_params = isset($scraper_config['required_params']) ? $scraper_config['required_params'] : [];
$paramlessURL    = removeParams($URL, $required_params);

// $price_log_dir  = $vs_cache_dir . 'improper_price_log/' . $DEALERSHIP . '/';
// $dealer_log_dir = $vs_cache_dir . 'JS_log/' . $DEALERSHIP . '/';

/**
 * { Determine request type and serve and response accordingly. }
 */
switch ($action) {
    case 'get_page_type':
        $query       = DbConnect::get_instance()->query("SELECT page_type, page_type_heading, required_param FROM vs_page_type WHERE dealership = '$DEALERSHIP';");
        $result_data = [];
        $i           = 0;

        while ($record = mysqli_fetch_assoc($query)) {
            $result_data[$i]['page_type']         = $record['page_type'];
            $result_data[$i]['page_type_heading'] = $record['page_type_heading'];
            $result_data[$i]['required_param']    = $record['required_param'];
            $i++;
        }

        echo json_encode(['message' => 'Visual Scraper Page Type Received', 'success' => true, 'new_pages' => $result_data, 'action' => $action], JSON_PRETTY_PRINT);
        break;

    case 'save_vs_data':
        $status = [];

        /* SAVE PAGE TYPE */
        if (isset($_POST['page_type'])) {
            $page_type_input = filter_input(INPUT_POST, 'page_type');
            $page_type_input = json_decode($page_type_input);

            if ($page_type_input) {
                $pages_data =
                    [
                    'dealership' => $DEALERSHIP,
                    'url'        => $URL,
                    'page_type'  => $page_type_input,
                ];

                $ifexist_query = $db_connect->query("SELECT url FROM vs_config_pages WHERE url = \"" . $URL . "\";");

                if (!mysqli_num_rows($ifexist_query)) {
                    $query_prep = $db_connect->prepare_query_params($pages_data, DbConnect::PREPARE_PARENTHESES);
                    $query_str  = "INSERT INTO vs_config_pages $query_prep;";
                    $db_connect->query($query_str);
                    $status[] = ['message' => 'Visual Scraper Pages Data Inserted', 'success' => true, 'action' => 'save_page'];
                } else {
                    $query_prep = $db_connect->prepare_query_params($pages_data, DbConnect::PREPARE_PARENTHESES);
                    $query_str  = "UPDATE vs_config_pages SET dealership = '$DEALERSHIP', page_type = '$page_type_input' WHERE url = \"" . $URL . "\";";
                    $db_connect->query($query_str);
                    $status[] = ['message' => 'Visual Scraper Pages Data Updated', 'success' => true, 'action' => 'save_page'];
                }
            }

            $status[] = ['message' => 'Page type stored'];
        }

        /* SAVE ALL URLs */
        if (isset($_POST['scraped_pages'])) {
            $scraped_pages = $_POST['scraped_pages'];
            $scraped_pages = json_decode($scraped_pages, true);

            if ($scraped_pages) {
                $knownVDP   = [];
                $knownSRP   = [];
                $regexQuery = $db_connect->query("SELECT url, page_type FROM vs_config_pages WHERE dealership = '$DEALERSHIP' AND (page_type = 'vdp' OR page_type = 'listing');");

                while ($vdp = mysqli_fetch_assoc($regexQuery)) {
                    if ($vdp['page_type'] == 'vdp') {
                        $knownVDP[] = $vdp['url'];
                    } else {
                        $knownSRP[] = $vdp['url'];
                    }
                }

                $vdp_regex = generate_regex($knownVDP);
                $srp_regex = generate_regex($knownSRP);

                $result2       = $db_connect->query("SELECT vdp_regex, srp_regex FROM vs_config WHERE dealership = '$DEALERSHIP';");
                $fetch_result2 = mysqli_fetch_assoc($result2);

                if ($fetch_result2['vdp_regex'] && $fetch_result2['vdp_regex'] != '') {
                    $vdp_regex = $fetch_result2['vdp_regex'];
                }

                if ($fetch_result2['srp_regex'] && $fetch_result2['srp_regex'] != '') {
                    $srp_regex = $fetch_result2['srp_regex'];
                }

                $time          = time();
                $scraped_pages = removeAfterHashArray($scraped_pages);
                $url_count     = 0;
                $len           = count($scraped_pages);

                for ($i = 0; $i < $len; $i++) {
                    if (!empty($scraped_pages[$i])) {
                        $page_url = filter_url($scraped_pages[$i], $DEALERSHIP);
                        $page_url = removeParams($page_url, $required_params);

                        if ($page_url && (validate_by_generated_regex($page_url, $vdp_regex) || validate_by_generated_regex($page_url, $srp_regex))) {
                            $page_url = removeParams($page_url, $required_params);

                            $ifexist_query       = $db_connect->query("SELECT url, deleted FROM vs_scraped_pages WHERE url = \"" . $page_url . "\";");
                            $fetch_ifexist_query = mysqli_fetch_assoc($ifexist_query);

                            if (!mysqli_num_rows($ifexist_query)) {
                                $db_connect->query("INSERT INTO vs_scraped_pages(dealership, url, last_updated) VALUES ('{$DEALERSHIP}', '{$page_url}', {$time});");
                                $url_count++;
                            } else {
                                if ($fetch_ifexist_query['deleted'] == true) {
                                    $db_connect->query("UPDATE vs_scraped_pages SET deleted = false, last_updated = '$time' WHERE url = \"" . $page_url . "\";");
                                }
                            }
                        }
                    }
                }

                $saved_urls  = [];
                $failed_urls = [];
                $exist_urls  = [];

                if (validate_by_generated_regex($URL, $srp_regex)) {
                    $srpExists = $db_connect->query("SELECT url FROM vs_scraped_pages WHERE url = \"" . $URL . "\";");

                    if (!mysqli_num_rows($srpExists)) {
                        $db_connect->query("INSERT INTO vs_scraped_pages(dealership, url, last_updated) VALUES ('{$DEALERSHIP}', '{$URL}', {$time});");
                        $saved_urls[] = $URL;
                        $url_count++;
                    } else {
                        $db_connect->query("UPDATE vs_scraped_pages SET deleted = false, last_updated = '$time' WHERE url = \"" . $URL . "\";");
                        $exist_urls[] = $URL;
                    }
                } else {
                    $failed_urls[] = $URL;
                }

                $status[] = ['message' => $url_count . ' valid URLs among ' . $len . ' URLs have been saved successfully!'];
            }
        }

        /* SAVE VS CONFIG */
        if (isset($_POST['visual_data'])) {
            $visual_data = filter_input(INPUT_POST, 'visual_data');
            $visual_data = json_decode($visual_data, true);

            $result2       = $db_connect->query("SELECT vdp_regex, srp_regex FROM vs_config WHERE dealership = '$DEALERSHIP';");
            $fetch_result2 = mysqli_fetch_assoc($result2);

            if ($visual_data) {
                $scraper_data =
                    [
                    'dealership'  => $DEALERSHIP,
                    'visual_data' => $visual_data,
                    'vdp_regex'   => (isset($fetch_result2['vdp_regex']) & !empty($fetch_result2['vdp_regex'])) ? $fetch_result2['vdp_regex'] : null,
                    'srp_regex'   => (isset($fetch_result2['srp_regex']) & !empty($fetch_result2['srp_regex'])) ? $fetch_result2['srp_regex'] : null,
                ];

                $delete_query = $db_connect->query("DELETE FROM vs_config WHERE dealership = '$DEALERSHIP';");
                $query_prep   = $db_connect->prepare_query_params($scraper_data, DbConnect::PREPARE_PARENTHESES);
                $query_str    = "INSERT INTO vs_config $query_prep;";
                $db_connect->query($query_str);

                $status[] = ['message' => 'Visual Scraper Config Submitted'];
            }
        }

        /* SAVE SCRAPED DATA FROM A PAGE */
        if (isset($_POST['scraped_data'])) {
            $scraped_data = filter_input(INPUT_POST, 'scraped_data');
            $scraped_data = json_decode($scraped_data, true);

            if ($scraped_data) {
                foreach ($scraped_data as $key => $value) {
                    $scraped_data[$key] = urldecode($value);

                    if (in_array($scraped_data[$key], ['N/A', 'n/a', 'n%2Fa', 'N%2FA'])) {
                        $scraped_data[$key] = '';
                    }
                }

                $scraped_data['url'] = $paramlessURL;

                /* FILTER YEAR, MAKE AND MODEL */
                $response              = filter_model_trim($scraped_data);
                $scraped_data['year']  = $response['year'];
                $scraped_data['make']  = $response['make'];
                $scraped_data['model'] = $response['model'];

                /* TAKE SPECIAL CARE OF TRIM */
                $scraped_data['trim'] = $scraped_data['trim'] == '' ? $response['trim'] : $scraped_data['trim'];
                $scraped_data['trim'] = !empty($scraped_data['trim']) ? filter_trim($scraped_data) : $scraped_data['trim'];

                /* TAKE CARE OF STOCK TYPE, STOCK NUMBER AND TITLE */
                $scraped_data['stock_type']   = $scraped_data['stock_type'] == '' ? strtolower(predict_stock_type($scraped_data)) : strtolower($scraped_data['stock_type']);
                $scraped_data['stock_number'] = (!isset($scraped_data['stock_number']) || $scraped_data['stock_number'] == '' || $scraped_data['stock_number'] == '') ? md5($scraped_data['url']) : $scraped_data['stock_number'];
                $scraped_data['title']        = trim((!isset($scraped_data['title']) || $scraped_data['title'] == '') ? (generateTitle($scraped_data)) : $scraped_data['title']);

                /* PREPARE THE REST OF THE FIELDS */
                $scraped_data['year']           = $scraped_data['year'] == '' ? null : $scraped_data['year'];
                $scraped_data['make']           = $scraped_data['make'] == '' ? $DEALERSHIP : $scraped_data['make'];
                $scraped_data['model']          = $scraped_data['model'] == '' ? null : $scraped_data['model'];
                $scraped_data['trim']           = $scraped_data['trim'] == '' ? null : $scraped_data['trim'];
                $scraped_data['price']          = $scraped_data['price'] == '' ? null : $scraped_data['price'];
                $scraped_data['msrp']           = $scraped_data['msrp'] == '' ? null : $scraped_data['msrp'];
                $scraped_data['engine']         = $scraped_data['engine'] == '' ? null : $scraped_data['engine'];
                $scraped_data['exterior_color'] = $scraped_data['exterior_color'] == '' ? null : $scraped_data['exterior_color'];
                $scraped_data['interior_color'] = $scraped_data['interior_color'] == '' ? null : $scraped_data['interior_color'];
                $scraped_data['vin']            = $scraped_data['vin'] == '' ? $scraped_data['stock_number'] : $scraped_data['vin'];
                $scraped_data['body_style']     = $scraped_data['body_style'] == '' ? null : $scraped_data['body_style'];
                $scraped_data['transmission']   = $scraped_data['transmission'] == '' ? null : $scraped_data['transmission'];
                $scraped_data['kilometres']     = $scraped_data['kilometres'] == '' ? null : $scraped_data['kilometres'];
                $scraped_data['all_images']     = isset($scraped_data['images']) ? $scraped_data['images'] : null;
                $scraped_data['svin']           = url_to_svin($paramlessURL, $required_params);

                if (looksSold($scraped_data)) {
                    $scraped_data['deleted'] = true;
                }

                if (isset($scraped_data['images'])) {
                    unset($scraped_data['images']);
                }

                $svin          = $scraped_data['svin'];
                $scraped_table = $DEALERSHIP . "_scrapped_data";
                $ifexist_query = $db_connect->query("SELECT stock_number, url, svin FROM {$scraped_table} WHERE svin = '$svin';");

                if (mysqli_num_rows($ifexist_query)) {
                    $row     = mysqli_fetch_assoc($ifexist_query);
                    $row_url = $row['url'];

                    if (mandatoryFieldsExists($scraped_data)) {
                        $scraped_data['updated_at'] = time();
                        $query_prep                 = $db_connect->prepare_query_params($scraped_data, DbConnect::PREPARE_EQUAL);
                        $query_str                  = "UPDATE {$scraped_table} SET {$query_prep}, deleted = 0 WHERE svin = '$svin';";
                        $db_connect->query($query_str);
                        $status[] = ['message' => 'Existing Data Updated By Crawler', 'query' => $query_str];
                    } else {
                        $scraped_data['updated_at'] = time();
                        $db_connect->query("UPDATE {$scraped_table} SET deleted = true WHERE svin = '$svin';");
                        $paramless_row_url = removeParams($row_url, $required_params);
                        $db_connect->query("UPDATE vs_scraped_pages SET deleted = true WHERE url LIKE '%$paramless_row_url%';");
                        $status[] = ['message' => 'Existing Data Is Set As Deleted'];
                    }
                } else {
                    if (mandatoryFieldsExists($scraped_data)) {
                        $scraped_data['arrival_date'] = time();
                        $query_prep                   = $db_connect->prepare_query_params($scraped_data, DbConnect::PREPARE_PARENTHESES);
                        $query_str                    = "INSERT INTO {$scraped_table} $query_prep;";
                        $db_connect->query($query_str);
                        $status[] = ['message' => 'Scraped Data Submitted And Inserted By Crawler'];
                    }
                }
            }
        }

        /* IMPROPER PRICE */
        /*if (isset($_POST['improper_price']))
        {
        // Create directory recursievly if doesn't exist.
        if (!is_dir($price_log_dir))
        {
        mkdir($price_log_dir, 0755, true);
        }

        $log_data   = $URL . '    ' . $price;
        $log_URL    = $price_log_dir . date('Y-m-d') . '.txt';
        writeLog($log_URL, $log_data);
        $status[]   = ['message' => 'Improper price found!'];
        }
         */

        /* SAVE SESSION */
        /*if (isset($_POST['session_data']))
        {
        // Create directory recursievly if doesn't exist.
        if (!is_dir($dealer_log_dir))
        {
        mkdir($dealer_log_dir, 0755, true);
        }

        $session_data = json_decode(filter_input(INPUT_POST, 'session_data'));
        $session_data['url'] = $URL;
        $session_data['timestamp'] = date('Y-m-d H:i:s T P');
        $dealer_log_file = $dealer_log_dir . date('Y-m-d') . '.txt';
        writeLog($dealer_log_file, json_encode($session_data));
        $status[] = ['message' => 'User session saved'];
        }
         */

        echo json_encode(['status' => $status, 'page_type' => $page_type_input, 'visual_data' => $visual_data, 'scraped_pages' => $scraped_pages, 'saved_urls' => $saved_urls, 'failed_urls' => $failed_urls, 'exist_urls' => $exist_urls, 'scraped_data' => $scraped_data, 'vdp_regex' => $vdp_regex, 'srp_regex' => $srp_regex, 'dealer' => $DEALERSHIP, 'action' => $action], JSON_PRETTY_PRINT);
        break;

    case 'get_config':
        /* GET PAGE COUNT */
        $query_select = $db_connect->query("SELECT SUM(case when page_type = 'vdp' then 1 else 0 end) as vdp, SUM(case when page_type = 'listing' then 1 else 0 end) as listing, SUM(case when page_type = 'others' then 1 else 0 end) as others FROM vs_config_pages WHERE dealership = '$DEALERSHIP';");
        $pagecount    = mysqli_fetch_assoc($query_select);

        /* GET VS CONFIG */
        $query_str    = "SELECT visual_data, min_price, max_price, vdp_regex, srp_regex FROM vs_config WHERE dealership = '$DEALERSHIP';";
        $result       = $db_connect->query($query_str);
        $fetch_result = mysqli_fetch_assoc($result);

        /* GENERATE VDP REGEX AND SRP REGEX */
        $knownVDP   = [];
        $knownSRP   = [];
        $regexQuery = $db_connect->query("SELECT url, page_type FROM vs_config_pages WHERE dealership = '$DEALERSHIP' AND (page_type = 'vdp' OR page_type = 'listing');");

        while ($vdp = mysqli_fetch_assoc($regexQuery)) {
            if ($vdp['page_type'] == 'vdp') {
                $knownVDP[] = $vdp['url'];
            } else {
                $knownSRP[] = $vdp['url'];
            }
        }

        $vdp_regex = generate_regex($knownVDP);
        $srp_regex = generate_regex($knownSRP);

        if ($fetch_result['vdp_regex'] != null && $fetch_result['vdp_regex'] != '') {
            $vdp_regex = $fetch_result['vdp_regex'];
        }

        if ($fetch_result['srp_regex'] != null && $fetch_result['srp_regex'] != '') {
            $srp_regex = $fetch_result['srp_regex'];
        }

        echo json_encode(['carConfig' => unserialize($fetch_result['visual_data']), 'pagecount' => $pagecount, 'min_price' => $fetch_result['min_price'], 'max_price' => $fetch_result['max_price'], 'vdp_regex' => $vdp_regex, 'srp_regex' => $srp_regex, 'success' => true, 'dealership' => $DEALERSHIP, 'action' => $action], JSON_PRETTY_PRINT);
        break;

    default:
        echo json_encode(['message' => 'No Such Action', 'success' => false, 'action' => 'error']);
        break;
}

$db_connect->close_connection();

/**
 * Removes an after hash array.
 *
 * @param      <type>  $urlArray  The url array
 *
 * @return     array   ( description_of_the_return_value )
 */
function removeAfterHashArray($urlArray)
{
    $returnUrls = [];

    for ($j = 0, $len = count($urlArray); $j < $len; $j++) {
        $url = explode("#", $urlArray[$j]);

        if (!in_array($url[0], $returnUrls)) {
            $returnUrls[] = $url[0];
        }
    }

    return $returnUrls;
}

//Need to process filter function according to required param method
/**
 * { function_description }
 *
 * @param      <type>   $url    The url
 *
 * @return     boolean  ( description_of_the_return_value )
 */
function filter_url($url, $dealer_name)
{
    $invalidExts             = ['pdf', 'jpg', 'png', 'jpeg', 'gif', 'csv'];
    $exclude_pre             = ['sms', 'tel', 'mai'];
    $excludeSessionIdDealers = ['reginarealestateshop'];

    if (in_array($dealer_name, $excludeSessionIdDealers)) {
        $url = filterUrlSession($url);
    }

    $extension = pathinfo($url, PATHINFO_EXTENSION);
    $pars_url  = parse_url($url, PHP_URL_PATH);

    if ((in_array($extension, $invalidExts)) || strlen($pars_url) < 2 || in_array(substr($url, 0, 3), $exclude_pre)) {
        return false;
    } else {
        return $url;
    }
}

/**
 * { function_description }
 *
 * @param      <type>  $url    The url
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function filterUrlSession($url)
{
    $url = explode('&', $url);

    if (count($url) > 2) {
        array_pop($url);
    }

    $url = implode('&', $url);

    return str_replace('amp;', '', $url);
}

/**
 * { function_description }
 *
 * @param      <type>  $data   The data
 *
 * @return     array   ( description_of_the_return_value )
 */
function filter_model_trim($data)
{
    $year  = isset($data['year']) ? $data['year'] : null;
    $make  = isset($data['make']) ? $data['make'] : null;
    $model = isset($data['model']) ? $data['model'] : null;
    $trim  = isset($data['trim']) ? $data['trim'] : null;

    if (strtolower($make) == 'holland') {
        $make = 'New Holland';
    }

    $return_data =
        [
        'year'  => $year,
        'make'  => $make,
        'model' => $model,
        'trim'  => $trim,
    ];

    $get_model  = DbConnect::get_instance()->query("SELECT DISTINCT(model_name) FROM advanced_car_data WHERE model_make_id = '$make'");
    $model_data = [];

    while ($record = mysqli_fetch_assoc($get_model)) {
        $model_data[] = $record['model_name'];
    }

    $model_split = explode(' ', $model);
    $model_str   = '';
    $final_model = $model;

    for ($i = 0; $i < count($model_split); $i++) {
        $model_str = !empty($model_str) ? ($model_str . ' ' . $model_split[$i]) : $model_split[$i];
        $model_str = strtolower($model_str);

        for ($j = 0; $j < count($model_data); $j++) {
            if (strtolower($model_data[$j]) == $model_str) {
                $final_model = $model_data[$j];
            }
        }
    }

    $trim                 = str_replace($final_model, '', $model);
    $return_data['model'] = $final_model;
    $return_data['trim']  = $trim;

    return $return_data;
}

/**
 * { function_description }
 *
 * @param      <type>         $data   The data
 *
 * @return     array|boolean  ( description_of_the_return_value )
 */
function filter_trim($data)
{
    $make  = isset($data['make']) ? (($data['make'] == 'n/a') ? $data['make'] : '') : '';
    $model = isset($data['model']) ? (($data['model'] == 'n/a') ? $data['model'] : '') : '';
    $trim  = isset($data['trim']) ? (($data['trim'] == 'n/a') ? $data['trim'] : '') : '';

    $get_trim  = DbConnect::get_instance()->query("SELECT DISTINCT(model_trim) FROM advanced_car_data WHERE model_make_id = '$make' AND model_name = '$model'");
    $trim_data = [];

    while ($record = mysqli_fetch_assoc($get_trim)) {
        $trim_data[] = $record['model_trim'];
    }

    $trim_split = explode(' ', $trim);
    $trim_str   = '';
    $final_trim = $trim;

    for ($i = 0; $i < count($trim_split); $i++) {
        $trim_str = !empty($trim_str) ? ($trim_str . ' ' . $trim_split[$i]) : $trim_split[$i];
        $trim_str = strtolower($trim_str);

        for ($j = 0; $j < count($trim_data); $j++) {
            if (strtolower($trim_data[$j]) == $trim_str) {
                $final_trim = $trim_data[$j];
            }
        }
    }

    return $final_trim;
}

/**
 * Converts a price to number.
 *
 * @param      <type>  $price  The price
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function priceToNumber($price)
{
    $pattern   = "/[0-9.,$]+/";
    $pattern2  = "/[^0-9.]+/";
    $remainder = preg_replace($pattern, "", $price);

    if ($remainder == "") {
        return preg_replace($pattern2, "", $price);
    }

    return $price;
}

/**
 * Generates the title using other fields.
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function generateTitle($scraped_data)
{
    $title = $scraped_data['stock_type'] . ' ' . $scraped_data['year'] . ' ' . $scraped_data['make'] . ' ' . $scraped_data['model'];

    if (isset($scraped_data['trim']) && $scraped_data['trim'] != '') {
        $title .= $scraped_data['trim'];
    }

    return trim($title);
}

/**
 * { function_description }
 *
 * @param      <type>   $carData  The car data
 *
 * @return     boolean  ( description_of_the_return_value )
 */
function mandatoryFieldsExists($carData)
{
    /* SET DELETED WHEN THESE ARE UNAVAILABLE */
    $carAttributes = ['make', 'model', 'all_images'];

    foreach ($carAttributes as $key => $value) {
        if (!$carData[$value] || $carData[$value] == '' || $carData[$value] == 'n/a') {
            return false;
        }
    }

    return true;
}

/**
 * { function_description }
 *
 * @param      <type>  $scraped_data  The scraped data
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function looksSold($scraped_data)
{
    if ($scraped_data['price'] == 'sold') {
        return true;
    }

    if (!(mandatoryFieldsExists($scraped_data))) {
        return true;
    }

    if (isset($scraped_data['deleted']) && $scraped_data['deleted'] == 1) {
        return true;
    }
}
