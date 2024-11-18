<?php

global $invalid_post_code, $location;

#makes
function get_makes($makes, DbConnect $db_connect)
{
    $query = "SELECT DISTINCT make from all_imported_scrapped_data ORDER BY make ASC;";

    $result = $db_connect->query($query);

    while ($row = mysql_fetch_array($result)) {
        if ($row['make'] == '' || $row['make'] == 'Other') {
            continue;
        }

        $makes[] = $row['make'];
    }

    return $makes;
}
add_filter('process_ajax_makes', 'get_makes', 10, 2);

#Models
function get_models($models, DbConnect $db_connect)
{
    $make = isset($_GET['make']) ? mysql_real_escape_string($_GET['make']) : null;
    if (!$make) {
        return $models;
    }

    $query = "SELECT DISTINCT model FROM all_imported_scrapped_data WHERE make = '$make' ORDER BY model ASC;";

    $result = $db_connect->query($query);

    while ($row = mysql_fetch_array($result)) {
        if ($row['model'] == '' || $row['model'] == 'Other') {
            continue;
        }

        $models[] = $row['model'];
    }

    return $models;
}
add_filter('process_ajax_models', 'get_models', 10, 2);

#Cars
function get_cars($cars, DbConnect $db_connect)
{
    global $make, $model, $max_year, $min_year, $range, $post_code, $color, $transmission, $max_price, $min_price, $max_kilometers, $min_kilometers, $search_new, $search_used, $search_private, $search_dealer, $page;
    global $invalid_post_code;

    $count = 10;
    $page  = intval($page);
    $start = ($page - 1) * $count;

    $where = create_where($make, $model, $max_year, $min_year, $range, $post_code, $color, $transmission, $max_price, $min_price, $max_kilometers, $min_kilometers, $search_new, $search_used, $search_private, $search_dealer);
    $query = "SELECT stock_number, year, make, model, trim, price, kilometres, all_images, url, arrival_date";

    if ($invalid_post_code == false) {
        $query .= ", " . get_distance_sql();
    }

    $query .= " FROM all_imported_scrapped_data WHERE ";
    $query .= $where;
    $query .= "ORDER BY ";

    if ($invalid_post_code == false) {
        $query .= "distance ASC ";
    } else {
        $query .= "arrival_date DESC ";
    }

    $query .= "LIMIT $start, $count";

    $cache_name = md5($query);

    $data = get_object_cache($cache_name);

    if ($data) {
        return $data;
    }

    $result = $db_connect->query($query);

    while ($row = mysql_fetch_array($result)) {
        $images = explode("|", $row["all_images"]);

        if ($images[0] == '') {
            $images = [];
        }

        $car_year  = $row["year"];
        $car_make  = $row["make"];
        $car_model = $row["model"];
        $car_trim  = $row["trim"];
        $car_price = $row["price"];

        if ($car_make == 'Other' || $car_model == 'Other') {
            continue;
        }

        $title = "$car_year $car_make $car_model";

        if ($car_trim) {
            $title .= " $car_trim";
        }

        $price_val = numarifyPrice($car_price);

        if ($price_val > 0) {
            $title .= " " . butifyPrice($price_val);
        }

        $kilometers = $row["kilometres"];

        $nk = numarifyKm($kilometers);

        if ($nk > 0) {
            $odometer = "Kilometers: $nk km";
        } else {
            $odometer = '';
        }

        $arrival_date = $row["arrival_date"];

        $days = floor((time() - $arrival_date) / (86400));

        if ($days > 0) {
            $day_text = "Days on Market: $days days";
        } else {
            $day_text = '';
        }

        if (isset($row['distance'])) {
            $distance      = round($row['distance'] * 1.60934, 2); // Mile ==> KM
            $distance_text = "Distance: about {$distance} km";
        } else {
            $distance_text = '';
        }

        $cars[] = array(
            "stock_number" => $row["stock_number"],
            "title"        => $title,
            "url"          => $row['url'],
            "odometer"     => $odometer,
            "image"        => count($images) > 0 ? $images[0] : '',
            "days"         => $day_text,
            "distance"     => $distance_text,
        );
    }

    $query = "SELECT count(stock_number) FROM all_imported_scrapped_data WHERE ";
    $query .= create_where($make, $model, $max_year, $min_year, $range, $post_code, $color, $transmission, $max_price, $min_price, $max_kilometers, $min_kilometers, $search_new, $search_used, $search_private, $search_dealer);

    $result = $db_connect->query($query);

    $count_obj = mysql_fetch_array($result);

    $pagination = get_pagination($page, $count_obj[0], $count);

    $data = array('cars' => $cars, 'count' => "About {$count_obj[0]} cars found", 'pagination' => $pagination);

    if ($invalid_post_code === true) {
        $data['count'] = "Invalid post code. About {$count_obj[0]} cars found, ignoring postcode.";
    }

    if ($invalid_post_code === false) {
        if ($range == '' || $range == '0') {
            $data['count'] = "About {$count_obj[0]} cars found nationwide.";
        } else {
            $data['count'] = "About {$count_obj[0]} cars found within {$range}km radius.";
        }
    }

    store_object_cache($cache_name, $data);

    return $data;
}
add_filter('process_ajax_cars', 'get_cars', 10, 2);

function get_distance_sql()
{
    global $location;

    $lat = $location->lat;
    $lng = $location->lng;

    $query = "3956 * 2 * ASIN(SQRT(POW(SIN((($lat) - abs(lat)) * pi()/180 / 2) ,2) + COS(($lat) * pi()/180) * COS(abs(lat) * pi()/180) * POW(SIN((($lng) - `long`) * pi()/180 / 2), 2))) AS distance";

    return $query;
}

function create_where($make, $model, $max_year, $min_year, $range, $post_code, $color, $transmission, $max_price, $min_price, $max_kilometers, $min_kilometers, $search_new, $search_used, $search_private, $search_dealer)
{
    global $invalid_post_code, $location;

    $where = '';

    if ($make) {
        $make  = mysql_real_escape_string($make);
        $where = "make='$make'";
    }

    if ($model) {
        $model = mysql_real_escape_string($model);
        if ($where != '') {
            $where .= ' AND ';
        }
        $where .= "model='$model'";
    }

    if ($max_year) {
        $max_year = intval($max_year);
        if ($where != '') {
            $where .= ' AND ';
        }
        $where .= "year <= $max_year";
    }

    if ($min_year) {
        $min_year = intval($min_year);
        if ($where != '') {
            $where .= ' AND ';
        }
        $where .= "year >= $min_year";
    }

    if ($color) {
        $color = mysql_real_escape_string($color);
        if ($where != '') {
            $where .= ' AND ';
        }
        if ($color != 'others') {
            $where .= "exterior_color like '%$color%'";
        } else {
            $where .= "exterior_color not like '%white%' and exterior_color not like '%silver%' and exterior_color not like '%black%' and exterior_color not like '%gray%' and exterior_color not like '%blue%' and exterior_color not like '%red%' and exterior_color not like '%brown%' and exterior_color not like '%green%'";
        }
    }

    if ($transmission) {
        $transmission = mysql_real_escape_string($transmission);
        if ($where != '') {
            $where .= ' AND ';
        }
        $where .= "transmission like '%$transmission%'";
    }

    if ($max_price) {
        $max_price = intval($max_price);
        if ($where != '') {
            $where .= ' AND ';
        }
        $where .= "price_value <= $max_price";
    }

    if ($min_price) {
        $min_price = intval($min_price);
        if ($where != '') {
            $where .= ' AND ';
        }
        $where .= "price_value >= $min_price";
    }

    if ($max_kilometers) {
        $max_kilometers = intval($max_kilometers);
        if ($where != '') {
            $where .= ' AND ';
        }
        $where .= "kilometres_value <= $max_kilometers";
    }

    if ($min_kilometers) {
        $min_kilometers = intval($min_kilometers);
        if ($where != '') {
            $where .= ' AND ';
        }
        $where .= "kilometres_value >= $min_kilometers";
    }

    if (($search_new || $search_used) && !($search_new && $search_used)) {
        if ($search_new) {
            if ($where != '') {
                $where .= ' AND ';
            }
            $where .= "stock_type = 'new'";
        }

        if ($search_used) {
            if ($where != '') {
                $where .= ' AND ';
            }
            $where .= "stock_type = 'used'";
        }
    }

    if (($search_private || $search_dealer) && !($search_private && $search_dealer)) {
        if ($search_private) {
            if ($where != '') {
                $where .= ' AND ';
            }
            $where .= "host = 'www.kijiji.ca'";
        }

        if ($search_dealer) {
            if ($where != '') {
                $where .= ' AND ';
            }
            $where .= "host <> 'www.kijiji.ca'";
        }
    }

    $invalid_post_code = -1;

    if ($post_code) {
        $geo = postcode_to_geo($post_code);

        if ($geo->status == 'OK') {
            $location = $geo->results[0]->geometry->location;

            $lat = $location->lat;
            $lng = $location->lng;

            $invalid_post_code = false;

            if ($range && $range > 0) {
                $radius = $range * 0.621371;

                if ($where != '') {
                    $where .= ' AND ';
                }

                // This really only approximates a distance between the central point and the car location which is a somewhat simpler calculation than the actual distance.
                // The actual distance would be based on the Haversine formula:
                // 60 * 1.1515 * rad2deg(acos(sin(deg2rad({$location['latitude']})) * sin(deg2rad(latitude)) +  cos(deg2rad({$location['latitude']})) * cos(deg2rad($latitude)) * cos(deg2rad({$location['longitude']} - longitude))))
                $where .= "(ABS($lng-`long`) * 69.1703234283616 * COS(lat*0.0174532925199433)) < $radius AND (69.047 * ABS($lat-lat)) < $radius";
            }
        } else {
            $invalid_post_code = true;
        }
    }

    if ($where != '') {
        $where .= ' ';
    } else {
        $where = '1 ';
    }

    return $where;
}

function get_pagination($page, $items, $count)
{
    $pages = ceil($items / $count);

    $min = $page - 10;
    $max = $page + 10;

    $first = max(array($min, 1));
    $last  = min(array($max, $pages));

    $html = "<div class=\"pagination\">\n";

    if ($page > 1) {
        $html .= "<a href=\"" . get_page_url($page - 1) . "\"><i class=\"fa fa-chevron-left\"></i></a>";
    }

    for ($i = $first; $i <= $last; $i++) {
        if ($i == $page) {
            $html .= "<span>$i</span>";
        } else {
            $html .= "<a href=\"" . get_page_url($i) . "\">$i</a>";
        }
    }

    if ($page < $pages) {
        $html .= "<a href=\"" . get_page_url($page + 1) . "\"><i class=\"fa fa-chevron-right\"></i></a>";
    }

    $html .= "</div>\n";

    return $html;
}

function get_page_url($page)
{
    global $make, $model, $max_year, $min_year, $range, $post_code, $color, $transmission, $max_price, $min_price, $max_kilometers, $min_kilometers, $search_new, $search_used, $search_private, $search_dealer;

    $is_search_new     = $search_new ? 'on' : '';
    $is_search_used    = $search_used ? 'on' : '';
    $is_search_private = $search_private ? 'on' : '';
    $is_search_dealer  = $search_dealer ? 'on' : '';

    return "?max_year=$max_year&min_year=$min_year&model=$model&make=$make&range=$range&post_code=$post_code&color=$color&transmission=$transmission&max_price=$max_price&min_price=$min_price&search_new=$is_search_new&search_used=$is_search_used&search_private=$is_search_private&search_dealer=$is_search_dealer&max_kilometers=$max_kilometers&min_kilometers=$min_kilometers&page=$page";
}

function get_object_cache($cache_name, $hours = 24)
{
    $filename = CACHEDIR . $cache_name;

    if (file_exists($filename)) {
        $now = time();
        $ft  = filemtime($filename);

        $diff = $now - $ft;

        if ($diff < (3600 * $hours)) {
            $data   = file_get_contents($filename);
            $u_data = unserialize($data);
            return $u_data;
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function store_object_cache($cache_name, $data)
{
    $filename = CACHEDIR . $cache_name;

    $data = serialize($data);

    file_put_contents($filename, $data, LOCK_EX);
}

function postcode_to_geo($post_code)
{
    $query = urlencode($post_code);

    $url = "https://maps.googleapis.com/maps/api/geocode/json?components=postal_code:$query&key=";

    $json = load_url_with_cache($url, 365);

    if ($json) {
        return json_decode($json);
    }

    return null;
}

function load_url_with_cache($url, $days = 2)
{
    global $proxy_list;

    $cache_name = md5($url);

    $data = get_object_cache($cache_name, 24 * $days);

    if (!$data) {
        $data = HttpGet($url, $proxy_list);

        if ($data) {
            store_object_cache($cache_name, $data);
        }
    }

    return $data;
}
