<?php

function getClickCount(PDO $pdo, $view_id, $between = []) {
    $stmt  = $pdo->prepare("SELECT timestamp FROM events WHERE viewId = :view_id and action = 'Click';");
    $stmt->execute(['view_id' => $view_id]);
    
    $clicks = [];
    
    while($row = $stmt->fetch()) {
        $clicks[] = $row;
    }
    
    return $clicks;
}

function refactor_pageViews(PDO $pdo, $domains) {
    
    if(!is_array($domains)) { $domains = [ $domains ]; }
    
    $table_names = [];
    
    foreach($domains as $domain) {
        $table_name = str_replace('.', '_', $domain) . '_rv';

        # Check table
        $table_check_query = "CREATE TABLE IF NOT EXISTS $table_name (
                    viewId char(64) NOT NULL DEFAULT '',
                    domain char(255) NOT NULL DEFAULT '',
                    url VARCHAR(512) NOT NULL DEFAULT '',
                    timeOnPage int NOT NULL DEFAULT '0',
                    timestamp bigint(20) NOT NULL DEFAULT '0',
                    PRIMARY KEY (viewId)
                );";
        
        $pdo->exec($table_check_query);

        # Clear Table
        $pdo->exec("TRUNCATE TABLE $table_name;");
        
        $table_names[$domain] = $table_name;
    }
    
    # Start reading and start updating
    $start  = 0;
    $length = 1000;
    
    $total = 0;
    
    while(true) {
        $stmt  = $pdo->prepare("SELECT * FROM page_views limit :start, :length");
        $stmt->execute(['start' => $start, 'length' => $length]);
        
        $buffer = [];
        $count = 0;
        
        while($row = $stmt->fetch()) {
            
            $count++;
            
            if(!in_array($row['domain'], $domains)) { continue; } //Ignore anything except this domain
            
            $buffer[] = [
                'viewId'      => $row['viewId'],
                'domain'      => $row['domain'],
                'url'         => mild_url_encode($row['url']),
                'timeOnPage'  => $row['timeOnPage'],
                'timestamp'   => $row['timestamp']
            ];
        }
        
        foreach($buffer as $row) {
            try{
                $stmt  = $pdo->prepare("INSERT INTO {$table_names[$row['domain']]}(viewId, domain, url, timeOnPage, timestamp) VALUES (:viewId, :domain, :url, :timeOnPage, :timestamp)");
                $stmt->execute([
                    'viewId'      => $row['viewId'],
                    'domain'      => $row['domain'],
                    'url'         => $row['url'],
                    'timeOnPage'  => $row['timeOnPage'],
                    'timestamp'   => $row['timestamp']
                ]);
            } catch (\PDOException $e) {
                echo $e->getMessage() . PHP_EOL;
            }
        }
        
        $total += $count;
        $start += $length;
        
        echo "$total Rows processed" . PHP_EOL;
        
        //Break on the last page when buffer size is less than what it was supposed to read
        if($count < $length) {
            break;
        }
    }
}

/**
 * 
 * @param string    $url    The URL string to get the data for
 * @param array     $date   An array with structure ['prev', 'current', 'next']
 */
function prepareData(PDO $pdo, $vehicle, $date) {
    
    $url = $vehicle['url'];
    
    if($vehicle['sold'] && $vehicle['sold_on'] < $date['current']) {
        return null;    //If vehicle was sold by this point, Ignore the vehicle from this data point
    }
    
    $resp_data = [
        'url'               => $url,
        'stock'             => $vehicle['stock'],
        //Vehicle Stats (Until current date)
        'uPageviews'        => 0,
        'pageviews'         => 0,
        'total_time'        => 0,
        'engaged'           => 0,
        'clicks'            => 0,
        //Vehicle Stats for last 7 Days (Before current date)
        'uPageviews7'       => 0,
        'pageviews7'        => 0,
        'total_time7'       => 0,
        'engaged7'          => 0,
        'clicks7'           => 0,
        //Vehicle Attributes
        'year'              => 0,
        'make'              => 0,
        'model'             => 0,
        'price'             => 0,
        //Result
        'sold'              => 0
    ];
    
    //Step 1: Unique Users Until Current Date
    $query_unique = "select count(distinct userId) as unique_users from page_views where timestamp < :until AND url like :url";
    
    $stmt1  = $pdo->prepare($query_unique);
    $stmt1->execute(['until' => ($date['current'] * 1000), 'url' => "$url%"]);
    $unique_row1 = $stmt1->fetch();
    
    if($unique_row1) {
        $resp_data['uPageviews'] = $unique_row1['unique_users'];
    }
    
    //Step 2: Unique Users Until Current Date Since Previous Day
    $query_unique .= " AND timestamp > :since";
            
    $stmt2  = $pdo->prepare($query_unique);
    $stmt2->execute(['until' => ($date['current'] * 1000), 'url' => "$url%", 'since' => ($date['prev'] * 1000)]);
    $unique_row2 = $stmt2->fetch();
    
    if($unique_row2) {
        $resp_data['uPageviews7'] = $unique_row2['unique_users'];
    }
    
    //Step 3: Page Views, Total Time, Engaged Users Until Current Date
    $query_engaged = "select timeOnPage from page_views where timestamp < :until AND url like :url";
    $stmt3  = $pdo->prepare($query_engaged);
    $stmt3->execute(['until' => ($date['current'] * 1000), 'url' => "$url%"]);

    while($row = $stmt3->fetch()) {
        $resp_data['pageviews']++;
        $resp_data['total_time'] += min([$row['timeOnPage'], 300000])/1000; //Cap to 5 minutes
        if($row['timeOnPage'] > 30000) {
            $resp_data['engaged']++;
        }
    }
    
    //Step 4: Page Views, Total Time, Engaged Users Until Current Date Since Previous Day
    $query_engaged .= " AND timestamp > :since";
    $stmt4  = $pdo->prepare($query_engaged);
    $stmt4->execute(['until' => ($date['current'] * 1000), 'url' => "$url%", 'since' => ($date['prev'] * 1000)]);

    while($row = $stmt4->fetch()) {
        $resp_data['pageviews7']++;
        $resp_data['total_time7'] += min([$row['timeOnPage'], 300000])/1000; //Cap to 5 minutes
        if($row['timeOnPage'] > 30000) {
            $resp_data['engaged7']++;
        }
    }
    
    //Step 5: Clicks Until Current Date
    $query_clicks = "select sum(accumulated_clicks.value) as clicks from page_views RIGHT JOIN accumulated_clicks ON page_views.viewId = accumulated_clicks.viewId where timestamp < :until AND url like :url";
    $stmt5  = $pdo->prepare($query_clicks);
    $stmt5->execute(['until' => ($date['current'] * 1000), 'url' => "$url%"]);
    $clicks_row1 = $stmt5->fetch();
    
    if($clicks_row1) {
        $resp_data['clicks'] = $clicks_row1['clicks'];
    }
    
    //Step 6: Clicks Until Current Date Since Previous Day
    $query_clicks .= " AND timestamp > :since";
    $stmt6  = $pdo->prepare($query_clicks);
    $stmt6->execute(['until' => ($date['current'] * 1000), 'url' => "$url%", 'since' => ($date['prev'] * 1000)]);
    $clicks_row2 = $stmt6->fetch();
    
    if($clicks_row2) {
        $resp_data['clicks7'] = $clicks_row2['clicks'];
    }
    
    //Step: 7 Prepare Vehicle Attributes
    $resp_data['year']  = intval($vehicle['year']);
    $resp_data['make']  = makeToKey($vehicle['make']);
    $resp_data['model'] = modelToKey($vehicle['model']);
    $resp_data['price'] = numarifyPrice($vehicle['price']);
    
    //Step: 8 Sold
    if($vehicle['sold'] && $vehicle['sold_on'] < $date['next']) {
        $resp_data['sold'] = 1;
    }
    
    return $resp_data;
}

function makeToKey($make) {
    return keyInFile($make, MAKE_DATA_FILE);
}

function modelToKey($model) {
    return keyInFile($model, MODEL_DATA_FILE);
}

function keyInFile($key, $file) {
    $lstr = strtolower($key);
    $obj = file_exists($file)?unserialize(file_get_contents($file)):['_map' => [], '_rev_map' => []];
    
    if(array_key_exists($lstr, $obj['_map'])) {
        return $obj['_map'][$lstr];
    }
    
    $value = random_int(1000, 9999);
    
    while(array_key_exists($value, $obj['_rev_map'])) {
        $value = random_int(1000, 9999);
    }
    
    $obj['_rev_map'][$value] = $lstr;
    $obj['_map'][$lstr] = $value;
    
    file_put_contents($file, serialize($obj));
}

function csv_write_line($file, $data) {
    
    $str = '';
    
    foreach($data as $val) {
        if($str) {
            $str .= ',';
        }
        
        if(stripos($val, ',') === FALSE) {
            $str .= $val;
        } else {
            $str .= "\"$val\"";
        }
    }
    
    file_put_contents($file, "$str\n", FILE_APPEND);
}