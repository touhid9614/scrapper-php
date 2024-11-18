<?php

global $distances, $order_by_fields;

$order_by_fields = [
    ''                 => 'Order By',
    'rd.quality_score' => 'Quality Score',
    'year'             => 'Year',
    'make'             => 'Make',
    'rd.price'         => 'Price'
];

$order_dir_fields = [
    'DESC' => 'DESC',
    'ASC'  => 'ASC'
];

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

class InventorySearch
{
    private $db_connect, $cron_name, $cron_config;

    public function __construct(DbConnect $db_connect)
    {
        $this->db_connect  = $db_connect;
        $this->cron_name   = $db_connect->cron_name;
        $this->cron_config = $db_connect->cron_config;
    }

    public function get_years()
    {
        $query  = "SELECT year FROM {$this->cron_name}_scrapped_data WHERE stock_type = 'used' AND deleted = 0 ORDER BY year DESC;";
        $result = $this->db_connect->query($query);
        $years  = [];

        while ($row = mysqli_fetch_array($result)) {
            $years[$row['year']] = $row['year'];
        }

        mysqli_free_result($result);

        return $years;
    }

    public function get_makes()
    {
        $query  = "SELECT make FROM {$this->cron_name}_scrapped_data WHERE stock_type = 'used' AND deleted = 0 ORDER BY make ASC;";
        $result = $this->db_connect->query($query);
        $makes  = [];

        while ($row = mysqli_fetch_array($result)) {
            $makes[$row['make']] = $row['make'];
        }

        mysqli_free_result($result);

        return $makes;
    }

    public function get_models($make)
    {
        if (!$make) {
            return array();
        }

        $query  = "SELECT model FROM {$this->cron_name}_scrapped_data WHERE stock_type = 'used' AND make = '$make' AND deleted = 0 ORDER BY model ASC;";
        $result = $this->db_connect->query($query);
        $models = [];

        while ($row = mysqli_fetch_array($result)) {
            $models[$row['model']] = $row['model'];
        }

        mysqli_free_result($result);

        return $models;
    }

    public function calculate_points($rank_data)
    {
        # Baseline = Images + Description
        $car_rank = 15 + 100;
        # VDP TBD
        # r_rank += min($rank_data['image_count'] - $rank_data['avg_image_count'], 5);
        # Description
        $car_rank += max(min(round(($rank_data['desc_count'] - $rank_data['avg_desc_count']) / 10), 10), -10);
        # Price Rank TBD

        # Price
        $quality_score = $car_rank;
        if ($rank_data['price'] > 0) {
            $quality_score *= $rank_data['price'];
        }

        return $quality_score;
    }

    public function get_car_by_stock($stock_number)
    {
        $query = "SELECT {$this->cron_name}_scrapped_data.stock_number, stock_type, year, make, model, trim, all_images, {$this->cron_name}_scrapped_data.price, kilometres, description, arrival_date, url,
                    rd.price as price_value, image_count, desc_count, day_count, time_on_page, avg_image_count, avg_desc_count, avg_day_count, avg_time_on_page, quality_score
                    FROM {$this->cron_name}_scrapped_data
                    JOIN {$this->cron_name}_rank_data rd ON rd.stock_number = {$this->cron_name}_scrapped_data.stock_number
                    WHERE {$this->cron_name}_scrapped_data.stock_number = '$stock_number';";

        $result = $this->db_connect->query($query);
        $row = mysqli_fetch_array($result);
        mysqli_free_result($result);
        $car = [];

        if ($row) {
            $car = [
                "stock_number" => $row["stock_number"],
                "url"          => $row["url"],
                "stock_type"   => $row["stock_type"],
                "year"         => $row["year"],
                "make"         => $row["make"],
                "model"        => $row["model"],
                "trim"         => $row["trim"],
                "price"        => $row["price"],
                "kilometers"   => $row["kilometres"],
                "arrival_date" => $row["arrival_date"],
                "description"  => $row["description"],
                "images"       => explode('|', $row["all_images"]),
            ];

            $car['rank_data']['price']            = $row['price_value'];
            $car['rank_data']['image_count']      = $row['image_count'];
            $car['rank_data']['desc_count']       = $row['desc_count'];
            $car['rank_data']['time_on_page']     = $row['time_on_page'];
            $car['rank_data']['day_count']        = $row['day_count'];
            $car['rank_data']['avg_image_count']  = $row['avg_image_count'];
            $car['rank_data']['avg_desc_count']   = $row['avg_desc_count'];
            $car['rank_data']['avg_time_on_page'] = $row['avg_time_on_page'];
            $car['rank_data']['avg_day_count']    = $row['avg_day_count'];
            $car['rank_data']['quality_score']    = $row['quality_score'];
        }

        return $car;
    }

    public function get_cars($year, $make, $model, $order_by, $order_dir, $page = 1, &$page_count = 0, $per_page = 10)
    {
        $start = ($page - 1) * $per_page;

        $cquery = "SELECT count(stock_number) as stock_count
                    FROM {$this->cron_name}_scrapped_data
                    WHERE stock_type = 'used' AND deleted = 0";

        $query = "SELECT {$this->cron_name}_scrapped_data.stock_number, stock_type, year, make, model, trim, all_images, {$this->cron_name}_scrapped_data.price, kilometres, description, arrival_date, url, rd.price as price_value, image_count, desc_count, day_count, time_on_page, avg_image_count, avg_desc_count, avg_day_count, avg_time_on_page, quality_score FROM {$this->cron_name}_scrapped_data OIN {$this->cron_name}_rank_data rd
            ON rd.stock_number = {$this->cron_name}_scrapped_data.stock_number WHERE stock_type =
            'used' AND deleted = 0";

        if ($year) {
            $query .= " AND year = '$year'";
            $cquery .= " AND year = '$year'";
        }

        if ($make) {
            $query .= " AND make = '$make'";
            $cquery .= " AND make = '$make'";
        }

        if ($model) {
            $query .= " AND model = '$model'";
            $cquery .= " AND model = '$model'";
        }

        if ($order_by) {
            $query .= " ORDER BY $order_by $order_dir";
        }

        $query .= " LIMIT $start, $per_page;";
        $cresult = $this->db_connect->query($cquery);
        $crow    = mysqli_fetch_array($cresult);

        if ($crow) {
            $page_count = ceil($crow['stock_count'] / $per_page);
        }

        mysqli_free_result($cresult);

        $result = $this->db_connect->query($query);

        $cars = array();

        while ($row = mysqli_fetch_array($result)) {
            $cars[$row['stock_number']] = [
                "stock_number" => $row["stock_number"],
                "url"          => $row["url"],
                "stock_type"   => $row["stock_type"],
                "year"         => $row["year"],
                "make"         => $row["make"],
                "model"        => $row["model"],
                "trim"         => $row["trim"],
                "price"        => $row["price"],
                "kilometers"   => $row["kilometres"],
                "arrival_date" => $row["arrival_date"],
                "description"  => $row["description"],
                "images"       => explode('|', $row["all_images"]),
            ];

            $cars[$row['stock_number']]['rank_data']['price']            = $row['price_value'];
            $cars[$row['stock_number']]['rank_data']['image_count']      = $row['image_count'];
            $cars[$row['stock_number']]['rank_data']['desc_count']       = $row['desc_count'];
            $cars[$row['stock_number']]['rank_data']['time_on_page']     = $row['time_on_page'];
            $cars[$row['stock_number']]['rank_data']['day_count']        = $row['day_count'];
            $cars[$row['stock_number']]['rank_data']['avg_image_count']  = $row['avg_image_count'];
            $cars[$row['stock_number']]['rank_data']['avg_desc_count']   = $row['avg_desc_count'];
            $cars[$row['stock_number']]['rank_data']['avg_time_on_page'] = $row['avg_time_on_page'];
            $cars[$row['stock_number']]['rank_data']['avg_day_count']    = $row['avg_day_count'];
            $cars[$row['stock_number']]['rank_data']['quality_score']    = $row['quality_score'];
        }

        mysqli_free_result($result);

        return $cars;
    }

    public function get_paged_similar_cars(&$car, $distance, $page = 1, &$page_count = 0, $per_page = 5, $is_exact = false, $expire_in = 48)
    {
        $similar_cars = $this->get_similar_cars($car, $distance, $is_exact, $expire_in);
        $count = count($similar_cars);
        $page_count = ceil($count / $per_page);
        $offset = ($page - 1) * $per_page;
        $similars = array_slice($similar_cars, $offset, $per_page, true);

        foreach ($similars as $stock_number => $similar) {
            $similars[$stock_number]['price'] = butifyPrice($similar['price']);
        }

        return $similars;
    }

    public function create_similar_car_cache($car)
    {
        $this->get_similar_cars($car, -1, false, 22);
        $this->get_similar_cars($car, -1, true, 22);
    }

    public function get_similar_cars(&$car, $distance, $is_exact = false, $expire_in = 48)
    {
        $range      = -1;
        $year       = $car['year'];
        $make       = $car['make'];
        $model      = $car['model'];
        $trim       = null;
        $stock_type = $car['stock_type'];

        $post_code = isset($this->cron_config['post_code']) ? $this->cron_config['post_code'] : 'none';
        $cache_name = md5("$year $make $model $stock_type $range of $post_code similar cache v2");

        if ($is_exact && isset($car['trim']) && $car['trim']) {
            $trim       = $car['trim'];
            $cache_name = md5("$year $make $model $trim $stock_type $range of $post_code similar cache v2");
        }

        slecho('Looking for similar cars into object cache');
        $similars = get_object_cache($cache_name, $expire_in);

        if (!$similars) {
            slecho('Loading similar cars from database');
            $similars = $this->get_imported_cars($year, $make, $model, $trim, $stock_type, null, $range);
            store_object_cache($cache_name, $similars);
        }

        $temps = [];

        foreach ($similars as $stock_number => $similar) {
            if ($distance <= 0) {
                $temps[$stock_number] = $similar;
                continue;
            }

            if (!isset($similar['distance'])) {
                $temps[$stock_number] = $similar;
                continue;
            }

            if ($similar['distance'] < $distance) {
                $temps[$stock_number] = $similar;
            }
        }

        $this->evaluate_car($car, $temps);

        return $temps;
    }

    public function evaluate_car(&$car, &$similars)
    {
        $stock_number = $car['stock_number'];

        $price_rank = array($stock_number => numarifyPrice($car['price']));
        $km_rank    = array($stock_number => numarifyKm($car['kilometers']));

        $now          = [];
        $large_number = 2147483647;

        $total_images       = count($car['images']);
        $total_descriptions = strlen((string) $car['description']);
        $total_days         = round(($now - $car['arrival_date']) / (86400));
        $total_count        = 1;
        $total              = 0;

        foreach ($similars as $sn => $sc) {
            $price_rank[$sn] = numarifyPrice($sc['price']);
            $km_rank[$sn]    = numarifyKm($sc['kilometers']);

            if ($price_rank[$sn] == 0 || $km_rank[$sn] == 0) {
                $price_rank[$sn] = $large_number;
                $km_rank[$sn]    = $large_number; //as used car, must have a km greater than 0
            } else {
                $total++;
            }

            $total_images += count($sc['images']);
            $total_descriptions += strlen((string) $sc['description']);
            $total_days += round(($now - $sc['arrival_date']) / (86400));
            $total_count++;
        }

        $avg_images = round($total_images / $total_count);
        $avg_desc   = round($total_descriptions / $total_count);
        $avg_days   = round($total_days / $total_count);

        $car['img']                       = count($car['images']) > 0 ? $this->get_thumb_url($car['images'][0]) : null;
        $car['status']['image_count']     = count($car['images']);
        $car['status']['desc_count']      = strlen((string) $car['description']);
        $car['status']['day_count']       = round(($now - $car['arrival_date']) / (86400));
        $car['status']['avg_image_count'] = $avg_images;
        $car['status']['avg_desc_count']  = $avg_desc;
        $car['status']['avg_day_count']   = $avg_days;
        $car['status']['total']           = $total;
        $car['status']['similar_count']   = $total_count;

        unset($car['images']);
        asort($price_rank, SORT_NUMERIC);
        asort($km_rank, SORT_NUMERIC);

        $rank = 1;

        foreach ($price_rank as $sn => $p) {
            if ($sn == $stock_number) {
                $car['status']['price_rank'] = $rank;
            } else {
                $similars[$sn]['status']['price_rank'] = $rank;
                $similars[$sn]['status']['total']      = $car['status']['total'];
                $similars[$sn]['img']                  = count($similars[$sn]['images']) > 0 ? $this->get_thumb_url($similars[$sn]['images'][0]) : null;
                unset($similars[$sn]['images']);
            }

            $rank++;
        }

        if (numarifyPrice($car['price']) == 0) {
            $car['status']['price_rank'] = 'n/a';
        }

        $temp_sorted = [];
        $rank = 1;

        foreach ($km_rank as $sn => $k) {
            if ($sn == $stock_number) {
                $car['status']['km_rank'] = $rank;
            } else {
                $similars[$sn]['status']['km_rank'] = $rank;
                $temp_sorted[$sn]                   = $similars[$sn];
            }
            $rank++;
        }

        if (numarifyKm($car['kilometers']) == 0) {
            $car['status']['km_rank'] = 'n/a';
        }

        $similars = $temp_sorted;
    }

    public function url2host($url)
    {
        $regex = '/https?:\/\/(?:www.)?(?<url>[^\/]+)/';

        if (preg_match($regex, $url, $matches)) {
            return $matches['url'];
        }

        return null;
    }

    public function get_imported_cars($year, $make, $model, $trim, $stock_type, $ignore_host, $range)
    {
        $post_code = isset($this->cron_config['post_code']) ? $this->cron_config['post_code'] : null;
        $where = $this->create_where($make, $model, $trim, $year, $stock_type, $ignore_host, $post_code, $range);
        $query = "SELECT stock_number, stock_type, year, make, model, trim, all_images, price, kilometres, description, arrival_date, url";

        if ($post_code) {
            $geo = $this->postcode_to_geo($post_code);

            if ($geo->status == 'OK') {
                $location = $geo->results[0]->geometry->location;

                $lat = $location->lat;
                $lng = $location->lng;
                $query .= ", 3956 * 2 * ASIN(SQRT(POW(SIN((($lat) - abs(lat)) * pi()/180 / 2) ,2) + COS(($lat) * pi()/180) * COS(abs(lat) * pi()/180) * POW(SIN((($lng) - `long`) * pi()/180 / 2), 2))) AS distance";
            }
        }

        $query .= " FROM all_imported_scrapped_data";
        $query .= " WHERE deleted = 0 AND $where";
        $result = $this->db_connect->query($query);

        $cars  = [];
        $check = [];

        while ($row = mysqli_fetch_array($result)) {
            $sns = explode('_', $row['stock_number']);
            $asn = "{$sns[0]} {$row["year"]} {$row["make"]} {$row["model"]} {$row["price"]}";

            if (in_array($asn, $check)) {
                continue;
            }

            $check[] = $asn;

            $cars[$row['stock_number']] = [
                "stock_number" => $row["stock_number"],
                "url"          => $row["url"],
                "stock_type"   => $row["stock_type"],
                "year"         => $row["year"],
                "make"         => $row["make"],
                "model"        => $row["model"],
                "trim"         => $row["trim"],
                "price"        => $row["price"],
                "kilometers"   => $row["kilometres"],
                "arrival_date" => $row["arrival_date"],
                "description"  => $row["description"],
                "images"       => explode('|', $row["all_images"]),
                "distance"     => isset($row['distance']) ? $row['distance'] : null
            ];
        }

        mysqli_free_result($result);

        return $cars;
    }

    public function create_where($make, $model, $trim, $year, $stock_type, $ignore_host, $post_code, $range)
    {
        $where = '';

        if ($make) {
            $make  = $this->db_connect->real_escape_string_read($make);
            $where = "make='$make'";
        }

        if ($model) {
            $model = $this->db_connect->real_escape_string_read($model);
            if ($where != '') {
                $where .= ' AND ';
            }
            $where .= "model='$model'";
        }

        if ($trim) {
            $trim = $this->db_connect->real_escape_string_read($trim);
            if ($where != '') {
                $where .= ' AND ';
            }
            $where .= "trim='$trim'";
        }

        if ($year) {
            if ($where != '') {
                $where .= ' AND ';
            }
            $where .= "year = $year";
        }

        if ($stock_type) {
            if ($where != '') {
                $where .= ' AND ';
            }
            $where .= "stock_type = '$stock_type'";
        }

        if ($ignore_host) {
            if ($where != '') {
                $where .= ' AND ';
            }
            $where .= "host <> '$ignore_host'";
        }

        if ($post_code && $range && $range > 0) {
            $geo = $this->postcode_to_geo($post_code);

            if ($geo->status == 'OK') {
                $location = $geo->results[0]->geometry->location;

                $lat = $location->lat;
                $lng = $location->lng;

                if ($where != '') {
                    $where .= ' AND ';
                }

                $radius = $range * 0.621371;
                // This really only approximates a distance between the central point and the car location which is a somewhat simpler calculation than the actual distance.
                // The actual distance would be based on the Haversine formula:
                // 60 * 1.1515 * rad2deg(acos(sin(deg2rad({$location['latitude']})) * sin(deg2rad(latitude)) +  cos(deg2rad({$location['latitude']})) * cos(deg2rad($latitude)) * cos(deg2rad({$location['longitude']} - longitude))))
                $where .= "(ABS($lng-`long`) * 69.1703234283616 * COS(lat*0.0174532925199433)) < $radius AND (69.047 * ABS($lat-lat)) < $radius";
            }
        }

        if ($where != '') {
            $where .= ' ';
        } else {
            $where = '1 ';
        }

        return $where;
    }

    public function postcode_to_geo($post_code)
    {
        slecho("Resolving geo for postcode $post_code");

        $query = urlencode($post_code);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?components=postal_code:$query&key=";
        $json = $this->load_url_with_cache($url, 365);

        if ($json) {
            return json_decode($json);
        }

        return null;
    }

    public function load_url_with_cache($url, $days = 2)
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

    public function check_distance_cache($post_code, $expires_in = 48)
    {
        if (!$post_code) {
            // slecho('No postcode provided');
            return;
        }

        $now             = time();
        $last_cache_time = $this->db_connect->get_meta('cache_time', $post_code);
        $elapsed = $now - $last_cache_time;

        if ($elapsed < $expires_in * 3600) {
            return; // cache ok
        }

        $geo = $this->postcode_to_geo($post_code);

        if ($geo->status != 'OK') {
            // slecho('Unable to resolve postcode');
            return;
        }

        $location = $geo->results[0]->geometry->location;

        $lat = $location->lat;
        $lng = $location->lng;

        $query = "SELECT `host_name`, 3956 * 2 * ASIN(SQRT(POW(SIN((($lat) - abs(lat)) * pi()/180 / 2) ,2) + COS(($lat) * pi()/180) * COS(abs(lat) * pi()/180) * POW(SIN((($lng) - `long`) * pi()/180 / 2), 2))) AS distance FROM imported_dealerships where address like '%\"country_code\";s:2:\"CA\";%'";

        $result = $this->db_connect->query($query);

        if (!$result) {
            // slecho('Database Error');
            // slecho(mysqli_error($this->db_connect->con));
            return;
        }

        $data = [];

        // slecho("Preaparing distance cache for '$post_code'");

        while ($row = mysqli_fetch_array($result)) {
            $data[$row['host_name']] = $row['distance'];
            // slecho("Distance of {$row['host_name']} is {$row['distance']}");
        }

        mysqli_free_result($result);

        foreach ($data as $host_name => $distance) {
            $old = $this->get_distance($post_code, $host_name);

            if ($old === false) {
                $query = "INSERT INTO distance_cache (post_code, `host`, distance) VALUES ('$post_code', '$host_name', $distance);";
            } else {
                $query = "UPDATE distance_cache SET distacne = $distance WHERE post_code = '$post_code' AND `host` = '$host_name';";
            }

            $this->db_connect->query($query);
        }

        $this->db_connect->update_meta('cache_time', $post_code, time());
    }

    public function get_distance($post_code, $host_name)
    {
        $query = "SELECT distance FROM distance_cache WHERE post_code = '$post_code' AND `host` = '$host_name';";
        $result = $this->db_connect->query($query);

        if ($result) {
            $row = mysqli_fetch_array($result);

            if ($row) {
                return $row['distance'];
            }
        }

        mysqli_free_result($result);

        return false;
    }

    public function get_thumb_url($url, $width = 150, $hours = 24)
    {
        $cache_name = md5("$url $width") . '.png';
        $filename   = IMGCACHEDIR . $cache_name;

        if (function_exists('resolve_file_url')) {
            $target = resolve_file_url($filename);
        } else {
            $target = null; // just bypass this to fix scrapper issue
        }

        if (file_exists($filename)) {
            $now = time();
            $ft  = filemtime($filename);

            $diff = $now - $ft;

            if ($diff < (3600 * $hours)) {
                return $target;
            }
        }

        $data = $this->load_url_with_cache($url, 1);

        if (!$data) {
            file_put_contents($filename, '');
            return $target;
        }

        try {
            $img = @imagecreatefromstring($data);
        } catch (Exception $ex) {
            file_put_contents($filename, '');
            return $target;
        }

        if (!$img) {
            file_put_contents($filename, '');
            return $target;
        }

        $sw = imagesx($img);
        $sh = imagesy($img);

        $height = round(($sh / $sw) * $width);

        $image = imagecreatetruecolor($width, $height);
        imageantialias($image, true);

        imagecopyresampled($image, $img, 0, 0, 0, 0, $width, $height, $sw, $sh);

        ob_start();
        imagepng($image);
        $imagedata = ob_get_contents(); // read from buffer
        ob_end_clean(); // delete buffer
        imagedestroy($img);
        imagedestroy($image);
        file_put_contents($filename, $imagedata);

        return $target;
    }
}