<?php

class CarTracker
{
    private $monthDayMap = [
        'jan' => 31,
        'feb' => 28,
        'mar' => 31,
        'apr' => 30,
        'may' => 31,
        'jun' => 30,
        'jul' => 31,
        'aug' => 31,
        'sep' => 30,
        'oct' => 31,
        'nov' => 30,
        'dec' => 31,
    ];

    public function __construct()
    {
    }

    /**
     * Gets the sold car data set.
     *
     * @param      <type>  $cron_name   The cron name
     * @param      <type>  $sold_cars   The sold cars
     * @param      <type>  $vinset      The vinset
     * @param      <type>  $stkset      The stkset
     * @param      <type>  $urlset      The urlset
     * @param      <type>  $db_connect  The database connect
     */
    public function getSoldCarDataSet($cron_name, &$sold_cars, &$vinset, &$stkset, &$urlset, DbConnect &$db_connect)
    {
        $query = "SELECT svin, stock_number, vin, url, stock_type, year, make, model, title, arrival_date, deleted_at FROM {$cron_name}_scrapped_data WHERE deleted = true and deleted_at IS NOT NULL;";
        $fetch = $db_connect->query($query);

        while ($row = mysqli_fetch_assoc($fetch)) {
            $sold_cars[$row['svin']] = [
                'svin'         => $row['svin'],
                'stock_number' => $row['stock_number'],
                'vin'          => $row['vin'],
                'url'          => $row['url'],
                'stock_type'   => $row['stock_type'],
                'year'         => $row['year'],
                'make'         => $row['make'],
                'model'        => $row['model'],
                'title'        => $row['title'],
                'arrival_date' => $row['arrival_date'],
                'deleted_at'   => $row['deleted_at'],
            ];

            $vinset[$row['vin']]          = $row['svin'];
            $stkset[$row['stock_number']] = $row['svin'];
            $urlset[$row['url']]          = $row['svin'];
        }
    }

    /**
     * Determines if a car is re added.
     *
     * @param      <type>      $car_data         The car data
     * @param      <type>      $sold_cars        The sold cars
     * @param      <type>      $vinset           The vinset
     * @param      <type>      $stkset           The stkset
     * @param      <type>      $urlset           The urlset
     * @param      <type>      $required_params  The required parameters
     *
     * @return     array|bool  True if re added, False otherwise.
     */
    public function isReAdded($car_data, $sold_cars, $vinset, $stkset, $urlset, $required_params)
    {
        $stk = $car_data['stock_number'];
        $vin = $car_data['vin'];
        $url = $car_data['url'];

        $readded = false;

        if ($this->hasSameVIN($vin, $vinset)) {
            $readded      = true;
            $old_car_data = $sold_cars[$vinset[$vin]];
            $identifier   = 'vin';
        } else if ($this->hasSameStockNumber($stk, $stkset)) {
            $readded      = true;
            $old_car_data = $sold_cars[$stkset[$stk]];
            $identifier   = 'stock_number';
        } else if ($this->hasSameUrl($url, $urlset)) {
            $readded      = true;
            $old_car_data = $sold_cars[$urlset[$url]];
            $identifier   = 'url';
        } else if ($this->hasSameSVIN($url, array_keys($sold_cars), $required_params)) {
            $readded      = true;
            $old_car_data = $sold_cars[$urlset[$url]];
            $identifier   = 'svin';
        }

        if ($readded) {
            return ['old_car' => $old_car_data, 'identifier' => $identifier];
        }

        return false;
    }

    /**
     * Determines if same url.
     *
     * @param      <type>  $url     The url
     * @param      <type>  $urlset  The urlset
     *
     * @return     bool    True if same url, False otherwise.
     */
    public function hasSameUrl($url, $urlset)
    {
        return in_array($url, $urlset);
    }

    /**
     * Determines if same stock number.
     *
     * @param      <type>  $stk     The stk
     * @param      <type>  $stkset  The stkset
     *
     * @return     bool    True if same stock number, False otherwise.
     */
    public function hasSameStockNumber($stk, $stkset)
    {
        return in_array($stk, $stkset);
    }

    /**
     * Determines if same vin.
     *
     * @param      <type>  $vin     The vin
     * @param      <type>  $vinset  The vinset
     *
     * @return     bool    True if same vin, False otherwise.
     */
    public function hasSameVIN($vin, $vinset)
    {
        return in_array($vin, $vinset);
    }

    /**
     * Determines if same svin.
     *
     * @param      <type>  $url              The url
     * @param      <type>  $svin_set         The svin set
     * @param      array   $required_params  The required parameters
     *
     * @return     bool    True if same svin, False otherwise.
     */
    public function hasSameSVIN($url, $svin_set, $required_params = [])
    {
        $svin = url_to_svin($url, $required_params);
        return in_array($svin, $svin_set);
    }

    /**
     * Gets the sale report by day.
     *
     * @param      <type>  $cron_name   The cron name
     * @param      <type>  $sale_date   The date in format '07-Nov-2020'
     * @param      <type>  $db_connect  The database connect instance
     *
     * @return     array   The sale report by day.
     */
    public function getSaleReportByDay($cron_name, $sale_date, DbConnect &$db_connect)
    {
        $start  = strtotime($sale_date);
        $end    = $start + 86400;
        $query  = "SELECT svin, stock_number, vin, url, stock_type, year, make, model, title, arrival_date, deleted_at FROM {$cron_name}_scrapped_data WHERE deleted = true AND deleted_at >= {$start} AND deleted_at < {$end};";
        $result = $db_connect->query($query);
        $out    = [];

        $newCount  = 0;
        $usedCount = 0;
        $invLenSum = 0;

        $dayBySale = [
            'sat' => 0,
            'sun' => 0,
            'mon' => 0,
            'tue' => 0,
            'wed' => 0,
            'thr' => 0,
            'fri' => 0,
        ];

        while ($row = mysqli_fetch_assoc($result)) {
            $inv_len  = ceil(($end - $row['arrival_date']) / 86400);
            $sale_day = strtolower(date('D', $row['deleted_at']));
            $dayBySale[$sale_day]++;

            if (strtolower($row['stock_type']) == 'new') {
                $newCount++;
            } else {
                $usedCount++;
            }

            $invLenSum += $inv_len;

            $out[$row['svin']] = [
                'stock_number'     => $row['stock_number'],
                'vin'              => $row['vin'],
                'url'              => $row['url'],
                'stock_type'       => $row['stock_type'],
                'year'             => $row['year'],
                'make'             => $row['make'],
                'model'            => $row['model'],
                'title'            => $row['title'],
                'arrival_date'     => date('d-M-Y', $row['arrival_date']),
                'sale_date'        => $sale_date,
                'sale_day'         => $sale_day,
                'inventory_period' => $inv_len,
            ];
        }

        $totalCars = count($out);

        return [
            'no_of_sale'     => $totalCars,
            'sale_period'    => $sale_date,
            'start_date'     => $sale_date,
            'end_date'       => $sale_date,
            'sale_length'    => 1,
            'avg_inv_period' => round(($invLenSum / $totalCars), 2),
            'sale_by_day'    => $dayBySale,
            'new_sale'       => $newCount,
            'used_sale'      => $usedCount,
            'sold_cars'      => $out,
        ];
    }

    /**
     * Gets the sale report by week and month and year.
     *
     * @param      <type>  $cron_name   The cron name
     * @param      <type>  $week        The week No [1-5]
     * @param      <type>  $month       The month [in m or M format]
     * @param      <type>  $year        The year [4 digit year]
     * @param      <type>  $db_connect  The database connect
     *
     * @return     <type>  The sale report by week and month and year.
     */
    public function getSaleReportByWeekNoAndMonthAndYear($cron_name, $week_no, $month, $year, DbConnect &$db_connect)
    {
        if ($week_no < 1 || $week_no > 5) {
            return null;
        }

        if ($year < 1970 || $year > 2069) {
            return null;
        }

        $first_day_of_month = strtotime("01-{$month}-{$year}");
        $start              = $first_day_of_month + ($week_no - 1) * 7 * 86400;
        $monthCode          = strtolower(substr($month, 0, 3));
        $monthDays          = $this->monthDayMap[$monthCode];

        if ($week_no * 7 <= $monthDays) {
            $week_length = 7;
        } else {
            $week_length = $monthDays - ($week_no - 1) * 7;
        }

        $end = $start + $week_length * 86400;

        $query  = "SELECT svin, stock_number, vin, url, stock_type, year, make, model, title, arrival_date, deleted_at FROM {$cron_name}_scrapped_data WHERE deleted = true AND deleted_at >= {$start} AND deleted_at < {$end};";
        $result = $db_connect->query($query);
        $out    = [];

        $newCount  = 0;
        $usedCount = 0;
        $invLenSum = 0;

        $dayBySale = [
            'sat' => 0,
            'sun' => 0,
            'mon' => 0,
            'tue' => 0,
            'wed' => 0,
            'thr' => 0,
            'fri' => 0,
        ];

        while ($row = mysqli_fetch_assoc($result)) {
            $inv_len  = ceil((strtotime(date('d-M-Y', $row['deleted_at'])) - strtotime(date('d-M-Y', $row['arrival_date'])) + 86399) / 86400);
            $sale_day = strtolower(date('D', $row['deleted_at']));
            $dayBySale[$sale_day]++;

            if (strtolower($row['stock_type']) == 'new') {
                $newCount++;
            } else {
                $usedCount++;
            }

            $invLenSum += $inv_len;

            $out[$row['svin']] = [
                'stock_number'     => $row['stock_number'],
                'vin'              => $row['vin'],
                'url'              => $row['url'],
                'stock_type'       => $row['stock_type'],
                'year'             => $row['year'],
                'make'             => $row['make'],
                'model'            => $row['model'],
                'title'            => $row['title'],
                'arrival_date'     => date('d-M-Y', $row['arrival_date']),
                'sale_date'        => date('d-M-Y', $row['deleted_at']),
                'sale_day'         => $sale_day,
                'inventory_period' => ceil((strtotime(date('d-M-Y', $row['deleted_at'])) - strtotime(date('d-M-Y', $row['arrival_date'])) + 86399) / 86400),
            ];
        }

        $totalCars = count($out);

        return [
            'no_of_sale'     => $totalCars,
            'sale_period'    => $week_no . " no week of " . $month . "-" . $year,
            'start_date'     => date('d-M-Y', $start),
            'end_date'       => date('d-M-Y', $end - 1),
            'sale_length'    => $week_length,
            'avg_inv_period' => round(($invLenSum / $totalCars), 2),
            'sale_by_day'    => $dayBySale,
            'new_sale'       => $newCount,
            'used_sale'      => $usedCount,
            'sold_cars'      => $out,
        ];
    }

    /**
     * Gets the sale report by week no and year.
     *
     * @param      <type>  $cron_name   The cron name
     * @param      <type>  $week        The week no [1-53]
     * @param      <type>  $year        The year [4 digit year]
     * @param      <type>  $db_connect  The database connect
     *
     * @return     <type>  The sale report by week no and year.
     */
    public function getSaleReportByWeekNoAndYear($cron_name, $week_no, $year, DbConnect &$db_connect)
    {
        if ($week_no < 1 || $week_no > 53) {
            return null;
        }

        if ($year < 1970 || $year > 2069) {
            return null;
        }

        $first_day_of_year = strtotime("01-01-{$year}");
        $start             = $first_day_of_year + ($week_no - 1) * 7 * 86400;

        if ($this->isLeapYear($year)) {
            $yearDays = 366;
        } else {
            $yearDays = 365;
        }

        if ($week_no * 7 <= $yearDays) {
            $week_length = 7;
        } else {
            $week_length = $yearDays - ($week_no - 1) * 7;
        }

        $end = $start + $week_length * 86400;

        $query  = "SELECT svin, stock_number, vin, url, stock_type, year, make, model, title, arrival_date, deleted_at FROM {$cron_name}_scrapped_data WHERE deleted = true AND deleted_at >= {$start} AND deleted_at < {$end};";
        $result = $db_connect->query($query);
        $out    = [];

        $newCount  = 0;
        $usedCount = 0;
        $invLenSum = 0;

        $dayBySale = [
            'sat' => 0,
            'sun' => 0,
            'mon' => 0,
            'tue' => 0,
            'wed' => 0,
            'thr' => 0,
            'fri' => 0,
        ];

        while ($row = mysqli_fetch_assoc($result)) {
            $inv_len  = ceil((strtotime(date('d-M-Y', $row['deleted_at'])) - strtotime(date('d-M-Y', $row['arrival_date'])) + 86399) / 86400);
            $sale_day = strtolower(date('D', $row['deleted_at']));
            $dayBySale[$sale_day]++;

            if (strtolower($row['stock_type']) == 'new') {
                $newCount++;
            } else {
                $usedCount++;
            }

            $invLenSum += $inv_len;

            $out[$row['svin']] = [
                'stock_number'     => $row['stock_number'],
                'vin'              => $row['vin'],
                'url'              => $row['url'],
                'stock_type'       => $row['stock_type'],
                'year'             => $row['year'],
                'make'             => $row['make'],
                'model'            => $row['model'],
                'title'            => $row['title'],
                'arrival_date'     => date('d-M-Y', $row['arrival_date']),
                'sale_date'        => date('d-M-Y', $row['deleted_at']),
                'sale_day'         => $sale_day,
                'inventory_period' => ceil((strtotime(date('d-M-Y', $row['deleted_at'])) - strtotime(date('d-M-Y', $row['arrival_date'])) + 86399) / 86400),
            ];
        }

        $totalCars = count($out);

        return [
            'no_of_sale'     => $totalCars,
            'sale_period'    => $week_no . " no week of year " . $year,
            'start_date'     => date('d-M-Y', $start),
            'end_date'       => date('d-M-Y', $end - 1),
            'sale_length'    => $week_length,
            'avg_inv_period' => round(($invLenSum / $totalCars), 2),
            'sale_by_day'    => $dayBySale,
            'new_sale'       => $newCount,
            'used_sale'      => $usedCount,
            'sold_cars'      => $out,
        ];
    }

    /**
     * Gets the sale report by month and year.
     *
     * @param      <type>  $cron_name   The cron name
     * @param      <type>  $month       The month [in m or M format]
     * @param      <type>  $year        The year [4 digit year]
     * @param      <type>  $db_connect  The database connect instance
     *
     * @return     array   The sale report by month and year.
     */
    public function getSaleReportByMonthAndYear($cron_name, $month, $year, DbConnect &$db_connect)
    {
        if ($year < 1970 || $year > 2069) {
            return null;
        }

        $start     = strtotime("01-{$month}-{$year}");
        $monthCode = strtolower(substr($month, 0, 3));
        $monthDays = $this->monthDayMap[$monthCode];

        if ($this->isLeapYear($year) && $monthCode == 'feb') {
            $monthDays++;
        }

        $end = $start + $monthDays * 86400;

        $query  = "SELECT svin, stock_number, vin, url, stock_type, year, make, model, title, arrival_date, deleted_at FROM {$cron_name}_scrapped_data WHERE deleted = true AND deleted_at >= {$start} AND deleted_at < {$end};";
        $result = $db_connect->query($query);
        $out    = [];

        $newCount  = 0;
        $usedCount = 0;
        $invLenSum = 0;

        $dayBySale = [
            'sat' => 0,
            'sun' => 0,
            'mon' => 0,
            'tue' => 0,
            'wed' => 0,
            'thr' => 0,
            'fri' => 0,
        ];

        while ($row = mysqli_fetch_assoc($result)) {
            $inv_len  = ceil((strtotime(date('d-M-Y', $row['deleted_at'])) - strtotime(date('d-M-Y', $row['arrival_date'])) + 86399) / 86400);
            $sale_day = strtolower(date('D', $row['deleted_at']));
            $dayBySale[$sale_day]++;

            if (strtolower($row['stock_type']) == 'new') {
                $newCount++;
            } else {
                $usedCount++;
            }

            $invLenSum += $inv_len;

            $out[$row['svin']] = [
                'stock_number'     => $row['stock_number'],
                'vin'              => $row['vin'],
                'url'              => $row['url'],
                'stock_type'       => $row['stock_type'],
                'year'             => $row['year'],
                'make'             => $row['make'],
                'model'            => $row['model'],
                'title'            => $row['title'],
                'arrival_date'     => date('d-M-Y', $row['arrival_date']),
                'sale_date'        => date('d-M-Y', $row['deleted_at']),
                'sale_day'         => $sale_day,
                'inventory_period' => ceil((strtotime(date('d-M-Y', $row['deleted_at'])) - strtotime(date('d-M-Y', $row['arrival_date'])) + 86399) / 86400),
            ];
        }

        $totalCars = count($out);

        return [
            'no_of_sale'     => $totalCars,
            'sale_period'    => $monthCode . "-" . $year,
            'start_date'     => date('d-M-Y', $start),
            'end_date'       => date('d-M-Y', $end - 1),
            'sale_length'    => $monthDays,
            'avg_inv_period' => round(($invLenSum / $totalCars), 2),
            'sale_by_day'    => $dayBySale,
            'new_sale'       => $newCount,
            'used_sale'      => $usedCount,
            'sold_cars'      => $out,
        ];
    }

    /**
     * Gets the sale report by year.
     *
     * @param      <type>     $cron_name   The cron name
     * @param      int        $year        The year [4 digit year]
     * @param      DbConnect  $db_connect  The database connect
     *
     * @return     <type>     The sale report by year.
     */
    public function getSaleReportByYear($cron_name, $year, DbConnect &$db_connect)
    {
        if ($year < 1970 || $year > 2069) {
            return null;
        }

        $start = strtotime("01-01-{$year}");

        if ($this->isLeapYear($year)) {
            $yearDays = 366;
        } else {
            $yearDays = 365;
        }

        $end = $start + $yearDays * 86400;

        $query  = "SELECT svin, stock_number, vin, url, stock_type, year, make, model, title, arrival_date, deleted_at FROM {$cron_name}_scrapped_data WHERE deleted = true AND deleted_at >= {$start} AND deleted_at < {$end};";
        $result = $db_connect->query($query);
        $out    = [];

        $newCount  = 0;
        $usedCount = 0;
        $invLenSum = 0;

        $dayBySale = [
            'sat' => 0,
            'sun' => 0,
            'mon' => 0,
            'tue' => 0,
            'wed' => 0,
            'thr' => 0,
            'fri' => 0,
        ];

        while ($row = mysqli_fetch_assoc($result)) {
            $inv_len  = ceil((strtotime(date('d-M-Y', $row['deleted_at'])) - strtotime(date('d-M-Y', $row['arrival_date'])) + 86399) / 86400);
            $sale_day = strtolower(date('D', $row['deleted_at']));
            $dayBySale[$sale_day]++;

            if (strtolower($row['stock_type']) == 'new') {
                $newCount++;
            } else {
                $usedCount++;
            }

            $invLenSum += $inv_len;

            $out[$row['svin']] = [
                'stock_number'     => $row['stock_number'],
                'vin'              => $row['vin'],
                'url'              => $row['url'],
                'stock_type'       => $row['stock_type'],
                'year'             => $row['year'],
                'make'             => $row['make'],
                'model'            => $row['model'],
                'title'            => $row['title'],
                'arrival_date'     => date('d-M-Y', $row['arrival_date']),
                'sale_date'        => date('d-M-Y', $row['deleted_at']),
                'sale_day'         => $sale_day,
                'inventory_period' => $inv_len,
            ];
        }

        $totalCars = count($out);

        return [
            'no_of_sale'     => $totalCars,
            'sale_period'    => "Entire year " . $year,
            'start_date'     => date('d-M-Y', $start),
            'end_date'       => date('d-M-Y', $end - 1),
            'sale_length'    => $yearDays,
            'avg_inv_period' => round(($invLenSum / $totalCars), 2),
            'sale_by_day'    => $dayBySale,
            'new_sale'       => $newCount,
            'used_sale'      => $usedCount,
            'sold_cars'      => $out,
        ];
    }

    /**
     * { function_description }
     *
     * @param      <type>     $cron_name   The cron name
     * @param      <type>     $start_date  The start date
     * @param      <type>     $end_date    The end date
     * @param      DbConnect  $db_connect  The database connect
     *
     * @return     array      ( description_of_the_return_value )
     */
    public function generateSaleReport($cron_name, $start_date, $end_date, DbConnect &$db_connect)
    {
        $start       = strtotime($start_date);
        $end         = strtotime($end_date) + 86400;
        $forteenTime = time() - 14 * 86400;

        $query  = "SELECT svin, stock_number, vin, url, stock_type, year, make, model, title, arrival_date, deleted_at FROM {$cron_name}_scrapped_data WHERE deleted = true AND deleted_at >= {$start} AND deleted_at < {$end};";
        $result = $db_connect->query($query);
        $out    = [];

        $newCount   = 0;
        $usedCount  = 0;
        $invLenSum  = 0;
        $forteenAgo = 0;

        $dayBySale = [
            'sat' => 0,
            'sun' => 0,
            'mon' => 0,
            'tue' => 0,
            'wed' => 0,
            'thr' => 0,
            'fri' => 0,
        ];

        while ($row = mysqli_fetch_assoc($result)) {
            $inv_len  = ceil((strtotime(date('d-M-Y', $row['deleted_at'])) - strtotime(date('d-M-Y', $row['arrival_date'])) + 86399) / 86400);
            $sale_day = strtolower(date('D', $row['deleted_at']));
            $dayBySale[$sale_day]++;

            if (strtolower($row['stock_type']) == 'new') {
                $newCount++;
            } else {
                $usedCount++;
            }

            if ($forteenTime > $row['deleted_at']) {
                $forteenAgo++;
            }

            $invLenSum += $inv_len;

            $out[$row['svin']] = [
                'stock_number'     => $row['stock_number'],
                'vin'              => $row['vin'],
                'url'              => $row['url'],
                'stock_type'       => $row['stock_type'],
                'year'             => $row['year'],
                'make'             => $row['make'],
                'model'            => $row['model'],
                'title'            => $row['title'],
                'arrival_date'     => date('d-M-Y', $row['arrival_date']),
                'sale_date'        => date('d-M-Y', $row['deleted_at']),
                'sale_day'         => $sale_day,
                'inventory_period' => $inv_len,
            ];
        }

        $totalCars = count($out);

        return [
            'no_of_sale'     => $totalCars,
            'sale_period'    => $start_date . " to " . $end_date,
            'start_date'     => $start_date,
            'end_date'       => $end_date,
            'sale_length'    => ceil(($end - $start - 1) / 86400),
            'avg_inv_period' => round(($invLenSum / $totalCars), 2),
            'sale_by_day'    => $dayBySale,
            'new_sale'       => $newCount,
            'used_sale'      => $usedCount,
            'forteen_ago'    => $forteenAgo,
            'sold_cars'      => $out,
        ];
    }

    public function generateMonthlySaleCalenderReport($cron_name, $month, $year, DbConnect &$db_connect)
    {
        $numberDays = date('t', mktime(0, 0, 0, $month, 1, $year));
        $monthData  = [];

        for ($day = 1; $day <= $numberDays; $day++) {
            $monthData[$day] = [
                'new'   => 0,
                'used'  => 0,
                'total' => 0,
            ];
        }

        $start = strtotime("01-{$month}-{$year}");
        $end   = strtotime("{$numberDays}-{$month}-{$year}") + 86400;

        $query  = "SELECT stock_type, deleted_at FROM {$cron_name}_scrapped_data WHERE deleted = true AND deleted_at >= {$start} AND deleted_at < {$end} ORDER BY deleted_at ASC;";
        $result = $db_connect->query($query);

        while ($row = mysqli_fetch_assoc($result)) {
            $sale_day   = (int) (date('d-M-Y', $row['deleted_at']));
            $stock_type = (strtolower($row['stock_type']) == 'new') ? 'new' : 'used';
            $monthData[$sale_day][$stock_type]++;
            $monthData[$sale_day]['total']++;
        }

        return $monthData;
    }

    /**
     * Gets the average sale per day.
     *
     * @param      <type>     $cron_name   The cron name
     * @param      <type>     $year        The year [4 digit year]
     * @param      DbConnect  $db_connect  The database connect
     *
     * @return     <type>     The average sale per day.
     */
    public function getAverageSalePerDayByYear($cron_name, $year, DbConnect &$db_connect)
    {
        if ($year < 1970 || $year > 2069) {
            return null;
        }

        $start = strtotime("01-01-{$year}");

        if ($this->isLeapYear($year)) {
            $yearDays = 366;
        } else {
            $yearDays = 365;
        }

        $end         = $start + $yearDays * 86400;
        $sale_report = $this->generateSaleReport($cron_name, "01-01-{$year}", "31-12-{$year}", $db_connect);
        $average     = $sale_report['sold_cars'] / $sale_report['sale_length'];

        return $average;
    }

    /**
     * Gets the average sale per day by month and year.
     *
     * @param      <type>     $cron_name   The cron name
     * @param      <type>     $month       The month [in m or M format]
     * @param      <type>     $year        The year [4 digit year]
     * @param      DbConnect  $db_connect  The database connect
     *
     * @return     <type>     The average sale per day by month and year.
     */
    public function getAverageSalePerDayByMonthAndYear($cron_name, $month, $year, DbConnect &$db_connect)
    {
        if ($year < 1970 || $year > 2069) {
            return null;
        }

        $start     = strtotime("01-{$month}-{$year}");
        $monthCode = strtolower(substr($month, 0, 3));
        $monthDays = $this->monthDayMap[$monthCode];

        if ($this->isLeapYear($year) && $monthCode == 'feb') {
            $monthDays++;
        }

        $end         = $start + $monthDays * 86400;
        $sale_report = $this->generateSaleReport($cron_name, "01-{$month}-{$year}", "{$monthDays}-{$month}-{$year}", $db_connect);
        $average     = $sale_report['sold_cars'] / $sale_report['sale_length'];

        return $average;
    }

    /**
     * Gets the average sale per day by week and month and year.
     *
     * @param      <type>     $cron_name   The cron name
     * @param      <type>     $week_no     The week no [1-5]
     * @param      <type>     $month       The month [in m or M format]
     * @param      <type>     $year        The year [4 digit year]
     * @param      DbConnect  $db_connect  The database connect
     *
     * @return     <type>     The average sale per day by week and month and year.
     */
    public function getAverageSalePerDayByWeekAndMonthAndYear($cron_name, $week_no, $month, $year, DbConnect &$db_connect)
    {
        return null;
    }

    /**
     * Gets the average sale per day by week and year.
     *
     * @param      <type>     $cron_name   The cron name
     * @param      <type>     $week_no     The week no [1-53]
     * @param      <type>     $year        The year [4 digit year]
     * @param      DbConnect  $db_connect  The database connect
     *
     * @return     <type>     The average sale per day by week and year.
     */
    public function getAverageSalePerDayByWeekAndYear($cron_name, $week_no, $year, DbConnect &$db_connect)
    {
        return null;
    }

    /**
     * Gets the average sale per week.
     *
     * @param      <type>  $cron_name  The cron name
     *
     * @return     <type>  The average sale per week.
     */
    public function getAverageSalePerWeekByYear($cron_name, $year, DbConnect &$db_connect)
    {
        return null;
    }

    public function getAverageSalePerWeekByMonthAndYear($cron_name, $month, $year, DbConnect &$db_connect)
    {
        return null;
    }

    /**
     * Gets the average sale per month.
     *
     * @param      <type>  $cron_name  The cron name
     *
     * @return     <type>  The average sale per month.
     */
    public function getAverageSalePerMonthByYear($cron_name, $year, DbConnect &$db_connect)
    {
        return null;
    }

    public function getAverageSalePerYear($cron_name, DbConnect &$db_connect)
    {
        return null;
    }

    public function getAverageSaleByPeriod($cron_name, $start_date, $end_date, DbConnect &$db_connect)
    {
        $sale_report = $this->generateSaleReport($cron_name, $start_date, $end_date, $db_connect);
        $average     = $sale_report['sold_cars'] / $sale_report['sale_length'];

        return $average;
    }

    /**
     * Gets the inventory history.
     *
     * @param      <type>  $car_data  The car data
     *
     * @return     <type>  The inventory history.
     */
    public function getInventoryHistory($car_data)
    {
        return null;
    }

    public function generateDistribution($sold_cars)
    {
        return null;
    }

    /**
     * Determines whether the specified year is leap year.
     *
     * @param      int   $year   The year
     *
     * @return     bool  True if the specified year is leap year, False otherwise.
     */
    public function isLeapYear($year)
    {
        if ($year % 4 == 0) {
            if ($year % 100 == 0) {
                if ($year % 400 == 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function generateReAddReport($cron_name, DbConnect &$db_connect)
    {
        $res = $db_connect->query("SELECT * FROM {$cron_name}_cartrack_data;");
        $out = [];

        while ($row = mysqli_fetch_assoc($res)) {
            $out[$row['svin']] = [
                'svin'                  => $row['svin'],
                'current_svin'          => $row['current_svin'],
                'current_url'           => $row['current_url'],
                'previous_url'          => $row['previous_url'],
                'current_stock_number'  => $row['current_stock_number'],
                'previous_stock_number' => $row['previous_stock_number'],
                'current_vin'           => $row['current_vin'],
                'previous_vin'          => $row['previous_vin'],
                'stock_type'            => $row['stock_type'],
                'year'                  => $row['year'],
                'make'                  => $row['make'],
                'model'                 => $row['model'],
                'title'                 => $row['title'],
                'readded_by'            => $row['readded_by'],
                'readded_at'            => $row['readded_at'],
                'arrival_date'          => $row['arrival_date'],
                'deleted_at'            => $row['deleted_at'],
                'active'                => $row['active'],
                'add_delete_history'    => unserialize($row['add_delete_history']),
            ];
        }

        return $out;
    }

    public function generateReAddOverview($cron_names, DbConnect &$db_connect)
    {
        $out = [];

        foreach ($cron_names as $cron) {
            $res = $db_connect->query("SELECT count(svin) AS total, stock_type FROM {$cron}_cartrack_data GROUP BY stock_type;");

            $cron_details = [
                'new'       => 0,
                'used'      => 0,
                'certified' => 0,
                'total'     => 0,
            ];

            $sum = 0;

            while ($row = mysqli_fetch_assoc($res)) {
                if (strContains(strtolower($row['stock_type']), 'certified')) {
                    $row['stock_type'] = 'certified';
                }

                $cron_details[strtolower($row['stock_type'])] = $row['total'];
                $sum += $row['total'];
            }

            $cron_details['total'] = $sum;

            $out[$cron] = $cron_details;
        }

        return $out;
    }
}