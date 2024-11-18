<?php

function loadCarList()
{
    global $carlistdb_path, $carlist;

    $time  = microtime(true);
    $lines = file($carlistdb_path);

    for ($i = 1, $lineCount = count($lines); $i < $lineCount; $i++) {
        $line = $lines[$i];

        $year       = readNext($line, $line);
        $make       = readNext($line, $line);
        $model      = readNext($line, $line);
        $trim       = readNext($line, $line);
        $body_style = readNext($line, $line);

        if ($model == '') {
            $model = 'None';
        }

        if ($trim == '' || $trim == 'NoName') {
            $trim = 'None';
        }

        if ($body_style == '') {
            $body_style = 'None';
        }

        if ($model == 'None') {
            continue;
        }

        addToCarlist($carlist, $year, $make, $model, $trim, $body_style);
    }

    $endtime = microtime(true);
    $elapsed = round($endtime - $time, 2);

    slecho('Time taken to load carlist: ' . $elapsed . ' sec');
}

function addToCarlist(&$carlist, $year, $make, $model, $trim, $body_style)
{
    $smake = strtolower($make);

    if (!isset($carlist[$year])) {
        $carlist[$year] = [];
    }

    if (!isset($carlist[$year][$smake])) {
        $carlist[$year][$smake] = ['_name' => $make];
    }

    if (!isset($carlist[$year][$smake][$model])) {
        $carlist[$year][$smake][$model] = [];
    }

    if (!isset($carlist[$year][$smake][$model][$trim])) {
        $carlist[$year][$smake][$model][$trim] = [];
    }

    if (!in_array($body_style, $carlist[$year][$smake][$model][$trim])) {
        array_push($carlist[$year][$smake][$model][$trim], $body_style);
    }

    $all_year = 'all_years';

    if (!isset($carlist[$all_year])) {
        $carlist[$all_year] = [];
    }

    if (!isset($carlist[$all_year][$smake])) {
        $carlist[$all_year][$smake] = ['_name' => $make];
    }

    if (!isset($carlist[$all_year][$smake][$model])) {
        $carlist[$all_year][$smake][$model] = [];
    }

    if (!isset($carlist[$all_year][$smake][$model][$trim])) {
        $carlist[$all_year][$smake][$model][$trim] = [];
    }

    if (!in_array($body_style, $carlist[$all_year][$smake][$model][$trim])) {
        array_push($carlist[$all_year][$smake][$model][$trim], $body_style);
    }
}

function readNext($line, &$updated_line)
{
    if ($line[0] == '"') {
        $line = substr($line, 1);

        if (stripos($line, '",') !== false) {
            $toret    = substr($line, 0, stripos($line, '",'));
            $tmp_line = substr($line, stripos($line, '",'));
        } else {
            $toret    = substr($line, 0, stripos($line, '"'));
            $tmp_line = substr($line, stripos($line, '"'));
        }

        if (stripos($tmp_line, ',') >= 0) {
            $updated_line = substr($tmp_line, stripos($tmp_line, ',') + 1);
        } else {
            $updated_line = '';
        }
    } else {
        $toret = substr($line, 0, stripos($line, ','));
        if (stripos($line, ',') >= 0) {
            $updated_line = substr($line, stripos($line, ',') + 1);
        } else {
            $updated_line = '';
        }
    }

    $toret = str_replace('""', '"', $toret);

    return $toret;
}

function loadAdvancedCarList()
{
    global $adcarlist_path, $advanced_carlist, $carlist, $fuel_type_carlist;

    $time  = microtime(true);
    $lines = file($adcarlist_path);

    for ($i = 1, $lineCount = count($lines); $i < $lineCount; $i++) {
        $line = $lines[$i];

        $make           = readNext($line, $line);
        $model          = readNext($line, $line);
        $trim           = readNext($line, $line);
        $year           = readNext($line, $line);
        $body_style     = readNext($line, $line);
        $engine_size    = readNext($line, $line);
        $cylinder_count = readNext($line, $line);
        $engine_fuel    = readNext($line, $line);

        if ($model == '') {
            $model = 'None';
        }

        if ($trim == '' || $trim == 'NoName') {
            $trim = 'None';
        }

        if ($body_style == '') {
            $body_style = 'None';
        }

        if ($model == 'None') {
            continue;
        }

        $smake = strtolower($make);

        if (!isset($advanced_carlist[$year])) {
            $advanced_carlist[$year] = [];
        }

        if (!isset($advanced_carlist[$year][$smake])) {
            $advanced_carlist[$year][$smake] = ['_name' => $make];
        }

        if (!isset($advanced_carlist[$year][$smake][$model])) {
            $advanced_carlist[$year][$smake][$model] = [];
        }

        if (!isset($advanced_carlist[$year][$smake][$model][$trim])) {
            $advanced_carlist[$year][$smake][$model][$trim] = [
                'body_style'     => $body_style,
                'engine_size'    => $engine_size,
                'cylinder_count' => $cylinder_count,
            ];
        }

        if (!isset($fuel_type_carlist[$year])) {
            $fuel_type_carlist[$year] = [];
        }

        if (!isset($fuel_type_carlist[$year][$smake])) {
            $fuel_type_carlist[$year][$smake] = ['_name' => $make];
        }

        if (!isset($fuel_type_carlist[$year][$smake][$model])) {
            $fuel_type_carlist[$year][$smake][$model] = $engine_fuel;
        }

        addToCarlist($carlist, $year, $make, $model, $trim, $body_style);
    }

    $endtime = microtime(true);
    $elapsed = round($endtime - $time, 2);

    slecho('Time taken to load advanced carlist: ' . $elapsed . ' sec');
}