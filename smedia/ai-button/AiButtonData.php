<?php

/**
 * Created by PhpStorm.
 * User: Arif_local
 * Date: 10/6/2019
 * Time: 2:45 PM
 */

namespace sMedia\AiButton;

/**
 * Class AiButtonData
 *
 * This class contain toolset to update view, click, fill up and button score data
 *
 * @package sMedia\AiButton
 */
class AiButtonData
{
    /**
     * Name of the table where data will be saved
     *
     * @var string
     */

    public static $dataTable = 'tbl_ai_button_data';

    /**
     * To fill up reward will be multiply with this value
     *
     * @var int
     */
    private static $fillUpMultiplier = 10;

    /**
     * Increase button view data
     *
     * @param int        $combinationId
     * @param string     $stockType
     * @param \DbConnect $dbConnectRead         Use read connection
     * @param \DbConnect $dbConnectWrite        Use write connection
     * @param string     $algorithm             Algorithm name
     *
     * @return void
     */
    public static function increaseView($combinationId, $stockType, $dbConnectRead, $dbConnectWrite, $algorithm = 'thompson_sampling')
    {
        self::increase('view', $combinationId, $stockType, $dbConnectRead, $dbConnectWrite, $algorithm);
    }

    /**
     * Increase button click data
     *
     * @param int        $combinationId
     * @param string     $stockType
     * @param \DbConnect $dbConnectRead         Use read connection
     * @param \DbConnect $dbConnectWrite        Use write connection
     * @param string     $algorithm             Algorithm name
     *
     * @return void
     */
    public static function increaseClick($combinationId, $stockType, $dbConnectRead, $dbConnectWrite, $algorithm = 'thompson_sampling')
    {
        self::increase('click', $combinationId, $stockType, $dbConnectRead, $dbConnectWrite, $algorithm);
    }

    /**
     * Increase form fill up data
     *
     * @param int        $combinationId
     * @param string     $stockType
     * @param \DbConnect $dbConnectRead         Use read connection
     * @param \DbConnect $dbConnectWrite        Use write connection
     * @param string     $algorithm             Algorithm name
     *
     * @return void
     */
    public static function increaseFillUp($combinationId, $stockType, $dbConnectRead, $dbConnectWrite, $algorithm = 'thompson_sampling')
    {
        self::increase('fill_up', $combinationId, $stockType, $dbConnectRead, $dbConnectWrite, $algorithm);
    }

    /**
     * Increase view, click and fill up data
     *
     * @param string     $dataType
     * @param int        $combinationId
     * @param string     $stockType
     * @param \DbConnect $dbConnectRead         Use read connection
     * @param \DbConnect $dbConnectWrite        Use write connection
     * @param string     $algorithm             Algorithm name
     *
     * @return void
     */
    private static function increase($dataType, $combinationId, $stockType, $dbConnectRead, $dbConnectWrite, $algorithm = 'thompson_sampling')
    {
        $totalData = self::totalData($combinationId, $dbConnectRead, $algorithm);

        if (null == $totalData) {
            return;
        } else {
            $dbConnectWrite->query(sprintf("UPDATE %s SET total_{$dataType}=total_{$dataType}+1, total_score=total_click+total_fill_up*%u WHERE id=%u AND alg='%s'", AiButtonCombination::$combinationTable, self::$fillUpMultiplier, $combinationId, $algorithm));
        }

        $todaysData = self::todaysData($combinationId, $stockType, $dbConnectRead, $algorithm);

        if (null == $todaysData) {
            $dbConnectWrite->query(sprintf("INSERT INTO %s (combination_id, {$dataType}, stock_type, date, alg) VALUES (%u, 1, '%s', '%s', '%s')", self::$dataTable, $combinationId, $stockType,date('Y-m-d'), $algorithm));
        } else {
            $dbConnectWrite->query(sprintf("UPDATE %s SET $dataType=$dataType+1 WHERE combination_id=%u AND stock_type='%s' AND date='%s' AND alg='%s'", self::$dataTable, $combinationId, $stockType, $todaysData['date'], $algorithm));
        }
    }

    /**
     * Calculate total score of a combination
     *
     * @param array $data
     *
     * @return int
     */
    public static function calculateScore($data)
    {
        return $data['click'] + $data['fill_up'] * self::$fillUpMultiplier;
    }

    /**
     * Get today's data for given combination
     *
     * @param int        $combinationId
     * @param string     $stockType         Car stock type
     * @param \DbConnect $dbConnect         User read connection
     * @param string     $algorithm         Algorithm name
     *
     * @return array|null
     */
    public static function todaysData($combinationId, $stockType, $dbConnect, $algorithm = 'thompson_sampling')
    {
        $date = date('Y-m-d');
        $result = $dbConnect->query(sprintf("SELECT * FROM %s WHERE combination_id=%u AND stock_type='%s' AND date='%s' AND alg='%s'", self::$dataTable, $combinationId, $stockType, $date, $algorithm));

        if (mysqli_num_rows($result)) {
            $data = mysqli_fetch_assoc($result);
            return [
                'id'         => (int) $data['combination_id'],
                'view'       => (int) $data['view'],
                'click'      => (int) $data['click'],
                'fill_up'    => (int) $data['fill_up'],
                'date'       => $data['date'],
                'stock_type' => $data['stock_type'],
            ];
        } else {
            return null;
        }
    }

    /**
     * Get total view, click, fill up and score for given combination
     *
     * @param int        $combinationId
     * @param \DbConnect $dbConnect         Use read connection
     * @param string     $algorithm         Algorithm name
     *
     * @return array|null
     */
    public static function totalData($combinationId, $dbConnect, $algorithm = 'thompson_sampling')
    {
        $result = $dbConnect->query(sprintf("SELECT * FROM %s WHERE id=%u AND alg='%s'", AiButtonCombination::$combinationTable, $combinationId, $algorithm));

        if (mysqli_num_rows($result)) {
            $data = mysqli_fetch_assoc($result);
            return [
                'id'        => (int) $data['id'],
                'view'      => (int) $data['total_view'],
                'click'     => (int) $data['total_click'],
                'fill_up'   => (int) $data['total_fill_up'],
            ];
        } else {
            return null;
        }
    }
}
