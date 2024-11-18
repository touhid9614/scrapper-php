<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$dealership   = filter_input(INPUT_GET, 'dealership');
$stock_number = filter_input(INPUT_GET, 'stock_number');

if (!$dealership || !$stock_number) {
    echo json_encode([
        'dealership'   => $dealership,
        'stock_number' => $stock_number,
        'success'      => false,
        'message'      => 'Missing required parameters',
    ]);
    exit();
}

$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3/";
$ext_dir     = "{$base_dir}/extensions/";
$tag_dir     = "{$base_dir}/tracking-tags/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'Google/Util.php';

$cron_config = key_exists($dealership, $CronConfigs) ? $CronConfigs[$dealership] : null;

if (!$cron_config) {
    echo json_encode([
        'dealership'   => $dealership,
        'stock_number' => $stock_number,
        'success'      => false,
        'message'      => 'Invalid dealership',
    ]);
    exit();
}

$mail_retargeting = key_exists('mail_retargeting', $cron_config) ? $cron_config['mail_retargeting'] : null;

if (!$mail_retargeting) {
    echo json_encode([
        'dealership'   => $dealership,
        'stock_number' => $stock_number,
        'success'      => false,
        'message'      => 'Mail retargeting isn\'t configured',
    ]);
    exit();
}

$db_connect            = new DbConnect($dealership);
$table                 = "{$dealership}_scrapped_data";
$mail_retargeting_data = [];

// Pull Logo, Front and Back Img
$template_directory = $adwords_dir . 'templates/' . $dealership . '/directmail';
$logo               = "$template_directory/logo.png";
$stock_type_query   = "";

$vehicle_query = "SELECT stock_type FROM {$table} WHERE stock_number = '" . $db_connect->real_escape_string_read($stock_number) . "' and deleted = 0;";
$resp          = $db_connect->query($vehicle_query);

if ($resp) {
    $stock_type = mysqli_fetch_assoc($resp)['stock_type'];

    if ($stock_type == 'new' && isset($mail_retargeting['new'])) {
        $mail_retargeting_data = $mail_retargeting['new'];
        $front_left            = "$template_directory/new_front_left.png";
        $back_left             = "$template_directory/new_back_left.png";
    } elseif ($stock_type == 'used' && isset($mail_retargeting['used'])) {
        $mail_retargeting_data = $mail_retargeting['used'];
        $front_left            = "$template_directory/used_front_left.png";
        $back_left             = "$template_directory/used_back_left.png";
    } else {
        $mail_retargeting_data = $mail_retargeting;
        $front_left            = "$template_directory/front_left.png";
        $back_left             = "$template_directory/back_left.png";
    }

    $stock_type_query                   = " AND stock_type ='{$stock_type}'";
    $mail_retargeting_data['enabled']   = $mail_retargeting['enabled'];
    $mail_retargeting_data['client_id'] = $mail_retargeting['client_id'];
}

$response = array_merge($mail_retargeting_data, [
    'dealership'   => $dealership,
    'stock_number' => $stock_number,
]);

if (file_exists($logo) && file_exists($front_left) && file_exists($back_left)) {
    $response['logo']         = "https://tm.smedia.ca/adwords3/templates/$dealership/directmail/" . basename($logo);
    $response['front_banner'] = "https://tm.smedia.ca/adwords3/templates/$dealership/directmail/" . basename($front_left);
    $response['back_banner']  = "https://tm.smedia.ca/adwords3/templates/$dealership/directmail/" . basename($back_left);
} else {
    echo json_encode([
        'dealership'   => $dealership,
        'stock_number' => $stock_number,
        'success'      => false,
        'message'      => 'Missing required files',
    ]);
    exit();
}

$fields         = "stock_number, year, make, model, price, all_images";
$vehicle1_query = "SELECT $fields FROM $table WHERE stock_number = '" . $db_connect->real_escape_string_read($stock_number) . "' and deleted = 0;";
$resp1          = $db_connect->query($vehicle1_query);

if ($resp1) {
    $vehicle1 = mysqli_fetch_array($resp1, MYSQLI_ASSOC);
    $images   = explode('|', $vehicle1['all_images']);

    // If price not present select next
    if (numarifyPrice($vehicle1['price']) <= 0) {
        echo json_encode([
            'dealership'   => $dealership,
            'stock_number' => $stock_number,
            'success'      => false,
            'message'      => 'Price requirement doesn\'t match',
        ]);
        exit();
    }

    // No image, select next
    if (!trim($images[0])) {
        echo json_encode([
            'dealership'   => $dealership,
            'stock_number' => $stock_number,
            'success'      => false,
            'message'      => 'Image requirement doesn\'t match',
        ]);
        exit();
    }

    // Make
    if (strlen($vehicle1['make']) > 16) {
        echo json_encode([
            'dealership'   => $dealership,
            'stock_number' => $stock_number,
            'success'      => false,
            'message'      => 'Make requirement doesn\'t match',
        ]);
        exit();
    }

    // Model
    if (strlen($vehicle1['model']) > 16) {
        echo json_encode([
            'dealership'   => $dealership,
            'stock_number' => $stock_number,
            'success'      => false,
            'message'      => 'Model requirement doesn\'t match',
        ]);
        exit();
    }

    // Stock number
    if (strlen($vehicle1['stock_number']) > 20) {
        echo json_encode([
            'dealership'   => $dealership,
            'stock_number' => $stock_number,
            'success'      => false,
            'message'      => 'Stock number requirement doesn\'t match',
        ]);
        exit();
    }

    $response['vehicles'][0] = $vehicle1;
    unset($response['vehicles'][0]['all_images']);
    $response['vehicles'][0]['image'] = $images[0];
    $price                            = butifyPrice($response['vehicles'][0]['price']);
    $response['vehicles'][0]['price'] = (stripos($price, ".") > 0 ? substr($price, 0, stripos($price, ".")) : $price);
}

$counter = 0;

while ($counter < 3) {
    $counter++; // Increase the counter on every attemp and don't cross 3 attemps
    $vehicle2_query = "SELECT $fields FROM $table WHERE stock_number <> '" . $db_connect->real_escape_string_read($stock_number) . "' and deleted = 0  $stock_type_query ORDER BY RAND() LIMIT 1;";
    $resp2          = $db_connect->query($vehicle2_query);

    if ($resp2) {
        $vehicle2 = mysqli_fetch_array($resp2, MYSQLI_ASSOC);
        $images   = explode('|', $vehicle2['all_images']);

        // If price not present select next
        if (numarifyPrice($vehicle2['price']) <= 0) {
            continue;
        }

        // No image, select next
        if (!trim($images[0])) {
            continue;
        }

        // Make
        if (strlen($vehicle2['make']) > 16) {
            continue;
        }

        // Model
        if (strlen($vehicle2['model']) > 16) {
            continue;
        }

        // Stock number
        if (strlen($vehicle2['stock_number']) > 20) {
            continue;
        }

        $response['vehicles'][1] = $vehicle2;
        unset($response['vehicles'][1]['all_images']);
        $response['vehicles'][1]['image'] = $images[0];
        $price                            = butifyPrice($response['vehicles'][1]['price']);
        $response['vehicles'][1]['price'] = (stripos($price, ".") > 0 ? substr($price, 0, stripos($price, ".")) : $price);
    }

    break;
}

if (count($response['vehicles']) < 2) {
    echo json_encode([
        'dealership'   => $dealership,
        'stock_number' => $stock_number,
        'success'      => false,
        'message'      => 'Unable to find appropriate 2nd vehicle after 3 attempts',
    ]);
    exit();
}

echo json_encode(array_merge($response, ['success' => true]));