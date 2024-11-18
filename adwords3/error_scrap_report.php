<?php

$dirlist = glob('ng_logs/*', GLOB_ONLYDIR);

$order = 'url|body_style|engine|exterior_color|interior_color|kilometres|make|model|price|stock_number|title|year|trim|transmission';
$order = explode('|', $order);
if (!array_key_exists('count', $_GET)) {
    $logfile_count = 5;
} else {
    $logfile_count = $logfile_count = preg_replace('/[^0-9]/', '', $_GET['count']);
}

echo <<<eoinfo
Estimated error rates for scrapper, lower is better, columns containing "_"
do not have data, either because of no expression, deeper errors, or no errors at all<br />
For Unique URLs column, higher is better but data is not valid unless ?count=1
as parameter, that makes it read just one log file, the default is last 5 log files per dealership<br />
Data is based upon last $logfile_count complete log files for each dealership<br />
<table><tr><th>dealership</th>
eoinfo;

foreach ($order as $element) {
    echo '<th>', str_replace('_', ' ', $element), '</th>';
}

echo <<<eoheader
<th>Total cars</th>
<th>Total list pages</th>
<th>Invalid price errors</th>
<th>File Too Large</th>
<th>Image scrap error</th>
<th>Invalid Image</th>
<th>AdWords invalid id</th>
<th>AdWords operation not permitted</th></tr>
eoheader;

foreach ($dirlist as $dir) {
    $dealership = explode('/', $dir);
    $dealership = $dealership[1];
    echo "<tr><td>$dealership</td>";

    $dir    = escapeshellarg($dir);
    $prefix = "find $dir -mtime -1 -size +10k -iname '*.log' | sort | tail -n ";
    $prefix .= $logfile_count + 1;
    $prefix .= "|head -n $logfile_count | xargs cat |";

    $internalcount = `$prefix grep 'DEBUG notice total cars'`;
    preg_match_all('@\s(?<cars>[0-9]+),.+?(?<pages>[0-9]+)@', $internalcount, $out);
    $total_cars       = array_sum($out['cars']);
    $total_list_pages = array_sum($out['pages']);
    $data             = `$prefix egrep -io 'regx.+$|url:' | sort | uniq -c`;
    $data             = explode("\n", $data);
    $count_r          = [];

    foreach ($data as $line) {
        $counts = explode(' ', trim($line));
        if (!array_key_exists('1', $counts)) {
            continue;
        }

        $count_r[$counts[1]] = $counts[0];
    }
    $unique_url_count = `$prefix egrep -i '^url:'| sort | uniq -c|wc -l`;
    $percentage_r     = [];

    $invalid_price_count       = `$prefix grep 'Smart URL skips cars with invalid price'| wc -l`;
    $invalid_image_count       = `$prefix grep 'Invalid Image'| wc -l`;
    $invalid_image_parse_count = `$prefix grep 'no images matched for'| wc -l`;
    $invalid_id_count          = `$prefix grep INVALID_ID| wc -l`;
    $op_np_count               = `$prefix grep OPERATION_NOT| wc -l`;
    $too_large_count           = `$prefix grep TOO_LARGE | wc -l`;

    foreach ($count_r as $key => $count) {
        if ($key == 'url:') {
            continue;
        }

        if ($total_cars > 0) {
            $perc = round($count * 100 / $total_cars);
            //if($perc > 100) $perc = 100;
            $percentage_r[$key] = $perc . '%';
        } else {
            $perc = '???';
        }
    }

    $good_counts = [];
    $bad_counts  = [];
    preg_match_all('@\%([\+\-][^\%]+)\%@', `$prefix grep -o '%[+-].\+%'`, $match);
    //    print_r($match);
    foreach ($match[1] as $plusminus) {
        $count_field = substr($plusminus, 1);
        if ($plusminus[0] == '+') {
            $good_counts[$count_field]++;
        } else {
            $bad_counts[$count_field]++;
        }
    }
    //    print_r($good_counts);
    //    print_r($bad_counts);

    foreach ($order as $element) {
        echo '<td>';

        $total_count = $bad_counts[$element] + $good_counts[$element];
        if (0 == $total_count) {
            echo '_';
        } else {
            //            echo  $bad_counts[$element]. '/' . $good_counts[$element] . ' ';
            if (!$printme = $bad_counts[$element] * 100 / $total_count) {
                if ($total_count) {
                    echo 'ok';
                } else {
                    echo '???';
                }
            } else {
                echo '<strong>' . round($printme) . '%' . '</strong>';
            }
        }
        /*
        if(array_key_exists('regx:'.$element, $percentage_r))
        echo '<td>' , $percentage_r['regx:'.$element] , '</td>';
        else
        echo '<td>_</td>';
         */

        echo '</td>';
    }

    echo '<td>'
        . $total_cars . '</td><td>'
        . $total_list_pages . '</td><td>'
        . $invalid_price_count . '</td><td>'
        . $too_large_count . '</td><td>'
        . $invalid_image_parse_count . '</td><td>'
        . $invalid_image_count . '</td><td>'
        . $invalid_id_count . '</td><td>'
        . $op_np_count . '</td>';

    echo '</tr>';
}

echo '</table>';
