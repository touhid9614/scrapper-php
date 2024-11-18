<?php


function get_all_dealer($dealership = null)
{
    $select_statement = "SELECT dealership,websites FROM dealerships WHERE (`status` = 'active'  OR `status` = 'trial' OR `status` = 'trial-setup')";
    if ($dealership) {
        $select_statement .= " AND `dealership` = '$dealership'";
    }
    $result = ConnectMysql::get_instance()->exeQuery($select_statement);
    $dealer = [];

    while ($details = $result->fetch()) {
        $dealership = $details[0];
        $domain_name = $details[1];
        $domain_regx = '/(?!:\/\/)(?<domain>(?:[a-zA-Z0-9-]+\.){0,5}[a-zA-Z0-9-][a-zA-Z0-9-]+\.[a-zA-Z]{2,64})/';
        $match = null;
        if (preg_match($domain_regx, $domain_name, $match)) {
            $website = $match['domain'];
            $dealer[$dealership] = $website;
        }
    }
    return $dealer;
}

function dealer_exist_in_table($table, $dealership)
{
    $select_statement = "SELECT * FROM $table WHERE dealership='{$dealership}'";
    return ConnectMysql::get_instance()->exeQuery($select_statement);
}

function get_all_page_view($domain_name, $dateCondition = '')
{
    if (empty($dateCondition)) {
        $select_statement = "select * from page_views where domain_name like '%$domain_name%'  ORDER BY id DESC";
    } else {
        $select_statement = "select * from page_views where domain_name like '%$domain_name%' AND last_updated  $dateCondition  ORDER BY id DESC";
    }

    $statement = ConnectRedShift::get_instance()->exeQuery($select_statement);

    $pageView = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $pageView[] = $row;
    }
    return $pageView;
}

function get_all_event($pageView)
{

    $select_statement = "select * from events where view_id like '$pageView'";
    $statement = ConnectRedShift::get_instance()->exeQuery($select_statement);

    $events = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $events[] = $row;
    }
    return $events;
}

function feature_list()
{
    return $selectedFeatures = [
        'page_view' => 'PageView',
        'time30s' => 'Time > 30 Seconds',
        'time60s' => 'Time > 60 Seconds',
        'time90s' => 'Time > 90 Seconds',
        'scroll25' => 'Scroll > 25',
        'scroll50' => 'Scroll > 50',
        'scroll75' => 'Scroll > 75',
        'scroll100' => 'Scroll 100',
        'button_click' => 'Button Click',
        'image_hovered' => 'Image Hovered',
        'image_clicked' => 'Image Clicked'
    ];
}

function feature_data()
{
    $featuresData = [];
    $selectedFeatures = feature_list();

    foreach ($selectedFeatures as $key => $value) {
        $featuresData[$key] = 0;
    }
    return $featuresData;
}

function prepare_feature_data($featuresData, $event_data)
{

    $action = trim($event_data['action_name']);
    $featuresData['page_view'] += 1;
    if ($action == 'TimeOnPage') {
        $timeonpage = $event_data['event_value'] / 1000;
        $featuresData['time30s'] += ($timeonpage >= 10) ? 1 : 0;
        $featuresData['time60s'] += ($timeonpage >= 20) ? 1 : 0;
        $featuresData['time90s'] += ($timeonpage >= 30) ? 1 : 0;
    } else if ($action == 'ScrollDepth') {
        $scrollpercentage = $event_data['event_value'];
        $featuresData['scroll25'] += ($scrollpercentage >= 25) ? 1 : 0;
        $featuresData['scroll50'] += ($scrollpercentage >= 50) ? 1 : 0;
        $featuresData['scroll75'] += ($scrollpercentage >= 75) ? 1 : 0;
        $featuresData['scroll100'] += ($scrollpercentage == 100) ? 1 : 0;
    } else if ($action == 'ButtonClick') {
        $featuresData['button_click'] += 1;
    } else if ($action == 'Hover') {
        $event_data = unserialize($event_data['event_data']);
        if (!empty($event_data ['Area'])) {
            $tag = isset($event_data['Tag']) ? $event_data['Tag'] : '';
            $width = isset($event_data['Area']['width']) ? $event_data['Area']['width'] : 0;
            $height = isset($event_data['Area']['height']) ? $event_data['Area']['height'] : 0;
            $featuresData['image_hovered'] += ($tag == 'IMG' && $width > 320 && $height > 240) ? 1 : 0;
        }
    } else if ($action == 'Click') {
        $event_data = unserialize($event_data['event_data']);
        if (!empty($event_data ['Area'])) {
            $tag = isset($event_data['Tag']) ? $event_data['Tag'] : '';
            $width = isset($event_data['Area']['width']) ? $event_data['Area']['width'] : 0;
            $height = isset($event_data['Area']['height']) ? $event_data['Area']['height'] : 0;
            $featuresData['image_clicked'] += ($tag == 'IMG' && $width > 320 && $height > 240) ? 1 : 0;
        }
    }
    return $featuresData;
}

function per_page_view($featuresData)
{
    $selectedFeatures = feature_list();
    if ($featuresData['page_view']) {
        $page_view = $featuresData['page_view'];
        foreach ($selectedFeatures as $key => $value) {
            $featuresData[$key] = ($featuresData[$key] / $page_view);
        }
        return $featuresData;
    } else {
        return [];
    }
}

function get_all_sold_car($dealership)
{
    $select_statement = "SELECT url, arrival_date, updated_at FROM {$dealership}_scrapped_data WHERE deleted='1'";
    $result = ConnectMysql::get_instance()->exeQuery($select_statement);

    $soldCarUrls = [];
    while ($car = $result->fetch()) {
        $soldCarUrls[$car['url']]['days'] = round(($car['updated_at'] - $car['arrival_date']) / (60 * 60 * 24));
    }

    return $soldCarUrls;
}

function get_all_car($dealership)
{
    $select_statement = "SELECT url, arrival_date,deleted, updated_at FROM {$dealership}_scrapped_data";
    $result = ConnectMysql::get_instance()->exeQuery($select_statement);

    $allCarUrls = [];
    while ($car = $result->fetch()) {
        $allCarUrls[$car['url']]['days'] = round(($car['updated_at'] - $car['arrival_date']) / (60 * 60 * 24));
        $allCarUrls[$car['url']]['deleted'] = $car['deleted'] ? $car['deleted'] : 0;
    }

    return $allCarUrls;
}

function get_all_unsold_car($dealership)
{
    $select_statement = "SELECT url, arrival_date,deleted, updated_at FROM {$dealership}_scrapped_data WHERE deleted='0'";
    $result = ConnectMysql::get_instance()->exeQuery($select_statement);

    $unSoldCarUrls = [];
    while ($car = $result->fetch()) {
        $unSoldCarUrls[$car['url']]['days'] = round(($car['updated_at'] - $car['arrival_date']) / (60 * 60 * 24));
    }

    return $unSoldCarUrls;
}

function url_exit($allCarUrls, $url)
{
    foreach ($allCarUrls as $key_url => $car_val) {
        $url_replace = str_replace(array('http://www.', 'https://www.', 'http', 'https'), '', $key_url);
        if (strpos($url, $url_replace)) {
            return $key_url;
        }
    }

    return 0;
}

function url_exist_in_table($table, $dealership, $url)
{
    $select_statement = "SELECT * FROM $table WHERE dealership='{$dealership}' AND url = '{$url}'";
    return ConnectMysql::get_instance()->exeQuery($select_statement);
}

function feature_data_url($featuresData, $url)
{
    $selectedFeatures = feature_list();
    foreach ($selectedFeatures as $key => $value) {
        $featuresData[$url][$key] = 0;
    }
    return $featuresData;
}

function prepare_feature_data_url($featuresData, $event_data, $url)
{
    $action = trim($event_data['action_name']);
    $featuresData[$url]['page_view'] += 1;
    if ($action == 'TimeOnPage') {
        $timeonpage = $event_data['event_value'] / 1000;
        $featuresData[$url]['time30s'] += ($timeonpage >= 10) ? 1 : 0;
        $featuresData[$url]['time60s'] += ($timeonpage >= 20) ? 1 : 0;
        $featuresData[$url]['time90s'] += ($timeonpage >= 30) ? 1 : 0;
    } else if ($action == 'ScrollDepth') {
        $scrollpercentage = $event_data['event_value'];
        $featuresData[$url]['scroll25'] += ($scrollpercentage >= 25) ? 1 : 0;
        $featuresData[$url]['scroll50'] += ($scrollpercentage >= 50) ? 1 : 0;
        $featuresData[$url]['scroll75'] += ($scrollpercentage >= 75) ? 1 : 0;
        $featuresData[$url]['scroll100'] += ($scrollpercentage == 100) ? 1 : 0;
    } else if ($action == 'ButtonClick') {
        $featuresData[$url]['button_click'] += 1;
    } else if ($action == 'Hover') {
        $tag = isset($event_data['date']['Tag']) ? $event_data['date']['Tag'] : '';
        $width = isset($event_data['date']['Area']['width']) ? $event_data['date']['Area']['width'] : 0;
        $height = isset($event_data['date']['Area']['height']) ? $event_data['date']['Area']['height'] : 0;
        $featuresData[$url]['image_hovered'] += ($tag == 'IMG' && $width > 320 && $height > 240) ? 1 : 0;
    } else if ($action == 'Click') {
        $tag = isset($event_data['date']['Tag']) ? $event_data['date']['Tag'] : '';
        $width = isset($event_data['date']['Area']['width']) ? $event_data['date']['Area']['width'] : 0;
        $height = isset($event_data['date']['Area']['height']) ? $event_data['date']['Area']['height'] : 0;
        $featuresData[$url]['image_clicked'] += ($tag == 'IMG' && $width > 320 && $height > 240) ? 1 : 0;
    }
    return $featuresData;
}

function ignore_small_preview($featuresData)
{
    $featuresData = array_filter($featuresData, function ($feature) {
        return $feature['page_view'] > 1;
    });
    return $featuresData;
}

function pre_possess_feature_data($featuresData)
{
    $soldCarData = [];
    foreach ($featuresData as $url => $data) {
        foreach ($data as $key => $value) {
            $soldCarData[$key][] = $featuresData[$url][$key];
        }
    }
    return $soldCarData;
}

function cal_mean_sd($featuresData)
{
    $finalFeaturesData = [];
    if (count($featuresData)) {
        $standard_deviation = 0;
        foreach ($featuresData as $key => $value) {
            $finalFeaturesData['mean'][$key] = calc_mean($featuresData[$key], $standard_deviation);
            $finalFeaturesData['sd'][$key] = $standard_deviation;
        }
    }
    return $finalFeaturesData;
}

function get_file_by_pattern($pattern, $file_type = '*.php')
{
    $dir = dirname(dirname(__DIR__)) . "/adwords3/scrapper-config/";
    if (is_dir($dir)) {
        foreach (glob($dir . $file_type) as $file) {
            header('Content-Type: text/plain');
            $content = file_get_contents($file);
            header('Content-Type: text/html');

            if (preg_match("/$pattern/", $content)) {
                return $file;
            }
        }
    }

    return null;
}



