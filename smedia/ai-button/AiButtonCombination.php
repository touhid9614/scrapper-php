<?php

/**
 * Created by PhpStorm.
 * User: Arif
 * Date: 10/2/2019
 * Time: 2:57 PM
 */


namespace sMedia\AiButton;

/**
 * Class AiButtonCombination
 *
 * @package sMedia\AiButton
 */
class AiButtonCombination
{
    /**
     * Dealership name
     *
     * @var string
     */
    public $dealership;

    /**
     * Dealership id
     *
     * @var int
     */
    public $dealership_id;

    /**
     * Algorithm name
     *
     * @var string
     */
    public $algorithm;

    /**
     * Button configuration
     *
     * @var array
     */
    public $config;

    /**
     * Button data [total_view, total_clicked, total_fill_up]
     *
     * @var array
     */
    public $data;

    /**
     * Button score
     *
     * @var array
     */
    public $score;

    /**
     * Button combination loaded from database
     *
     * @var array
     */
    public $combinations;

    /**
     * Combination which will be inserted into database
     *
     * @var array
     */
    public $newCombinations;

    /**
     * Combination will be deleted from database
     *
     * @var array
     */
    public $combinationToDelete;

    /**
     * Combination will be inserted from database
     *
     * @var array
     */
    public $combinationToInsert;

    /**
     * Combination table name
     *
     * @var string
     */
    public static $combinationTable = 'tbl_ai_button_combination';

    /**
     * AiButtonCombination constructor.
     *
     * @param string     $dealership
     * @param array      $config
     * @param \DbConnect $dbConnect             User read connection
     * @param string     $algorithm
     *
     */
    public function __construct($dealership, $config, $dbConnect, $algorithm = 'thompson_sampling')
    {
        $result = $dbConnect->query(sprintf("SELECT id FROM `dealerships` WHERE `dealership`='%s'", $dealership));

        if (mysqli_num_rows($result) < 1) {
            throw new AiButtonException("Dealership \"{$this->dealership}\" not found in database.", AiButtonException::DEALERSHIP_NOT_FOUND);
        }

        if (!is_array($config)) {
            throw new AiButtonException("Can't load configuration for dealership \"{$this->dealership}\".", AiButtonException::CONFIG_NOT_FOUND);
        }

        if (empty($algorithm)) {
            throw new AiButtonException("Algorithm is not defined", AiButtonException::ALGORITHM_IS_NOT_DEFINED);
        }

        $this->config = $config;
        $this->dealership_id = (int) mysqli_fetch_assoc($result)['id'];
        $this->dealership = $dealership;
        $this->algorithm = $algorithm;
        $this->combinations = [];
        $this->newCombinations = [];
        $this->combinationToDelete = [];
        $this->combinationToInsert = [];

        $this->loadCombination($dbConnect);
    }

    /**
     * Load button combination from database
     *
     * @param \DbConnect $dbConnect             User read connection
     *
     * @return $this
     */
    public function loadCombination($dbConnect)
    {
        $result = $dbConnect->query(sprintf("SELECT * FROM %s WHERE `dealership_id`=%u AND `alg`='%s'", self::$combinationTable, $this->dealership_id, $this->algorithm));

        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->combinations[$row['button_type']][$row['id']] = $row['combination'];
                $this->data[$row['button_type']][$row['id']] = [
                    'total_view' => (int) $row['total_view'],
                    'total_click' => (int) $row['total_click'],
                    'total_fill_up' => (int) $row['total_fill_up'],
                    'total_score' => (int) $row['total_score']
                ];
            }
        }

        return $this;
    }

    /**
     * Generate button combinations
     *
     * @return $this
     */
    public function generateCombination()
    {
        foreach ($this->config as $name => $settings) {
            $this->newCombinations[$name][] = "baseline";
            foreach ($settings['locations'] as $location => $location_val) {
                foreach ($settings['sizes'] as $size => $size_val) {
                    foreach ($settings['styles'] as $style => $style_val) {
                        $texts = reset($settings['texts'])['values'];
                        foreach ($texts as $text) {
                            $this->newCombinations[$name][] = "[{$location}][{$size}][{$style}][{$text}]";
                        }
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Save button combination into database
     *
     * @param \DbConnect $dbConnectRead         Use read connection
     * @param \DbConnect $dbConnectWrite        Use write connection
     *
     * @return $this
     */
    public function saveCombination($dbConnectRead, $dbConnectWrite)
    {
        $this->findCombinationsToDelete();
        $this->findCombinationsToInsert();
        $this->deleteUnusedCombinations($dbConnectWrite);
        $this->insertNewCombinations($dbConnectWrite);

        // Reload combinations after saving
        $this->loadCombination($dbConnectRead);
        return $this;
    }

    /**
     * Delete unused combinations from database
     *
     * @param \DbConnect $dbConnect             Use write connection
     */
    private function deleteUnusedCombinations($dbConnect)
    {
        if (count($this->combinationToDelete)) {
            $to_del_ids = [];
            foreach ($this->combinationToDelete as $button => $combinations) {
                if (is_array($combinations) && count($combinations)) {
                    $to_del_ids = array_merge($to_del_ids, array_keys($combinations));
                }
            }

            if (count($to_del_ids)) {
                $dbConnect->query(sprintf("DELETE FROM %s WHERE id IN (%s) AND `alg`='%s'", self::$combinationTable, implode(',', $to_del_ids), $this->algorithm));
                $dbConnect->query(sprintf("DELETE FROM %s WHERE combination_id IN (%s) AND `alg`='%s'", AiButtonData::$dataTable, implode(',', $to_del_ids), $this->algorithm));
                $this->combinationToDelete = [];
            }
        }
    }

    /**
     * Insert new combinations into database
     *
     * @param \DbConnect $dbConnect         Use write connection
     */
    private function insertNewCombinations($dbConnect)
    {
        if (count($this->combinationToInsert)) {
            $button_combinations = [];
            foreach ($this->combinationToInsert as $button => $combinations) {
                if (is_array($combinations) && count($combinations)) {
                    foreach ($combinations as $combination) {
                        $combination = $dbConnect->real_escape_string($combination);
                        $button_combinations[] = "('{$combination}', '{$button}', '{$this->dealership_id}', '{$this->algorithm}')";
                    }
                }
            }

            if (count($button_combinations)) {
                $sql = sprintf("INSERT INTO %s (combination, button_type, dealership_id, alg) VALUES %s;", self::$combinationTable, implode(",", array_unique($button_combinations)));
                $dbConnect->query($sql);
                $this->combinationToInsert = [];
            }
        }
    }

    /**
     *  Find combinations which need to be deleted from database
     */
    private function findCombinationsToDelete()
    {
        foreach ($this->combinations as $button => $combinations) {
            if (!isset($this->newCombinations[$button])) {
                $this->combinationToDelete[$button] = $this->combinations[$button];
            } else {
                $this->combinationToDelete[$button] = array_diff($this->combinations[$button], $this->newCombinations[$button]);
            }
        }
    }

    /**
     * Find new combination which should be inserted into database
     */
    private function findCombinationsToInsert()
    {
        foreach ($this->newCombinations as $button => $combinations) {
            if (!isset($this->combinations[$button])) {
                $this->combinationToInsert[$button] = $this->newCombinations[$button];
            } else {
                $this->combinationToInsert[$button] = array_diff($this->newCombinations[$button], $this->combinations[$button]);
            }
        }
    }

    /**
     * Get data for different algorithm
     *
     * @return array|false
     */
    public function getData()
    {
        if ($this->algorithm == 'thompson_sampling') {
            return $this->thompsonSamplingData();
        } else if ($this->algorithm == 'softmax') {
            return $this->softmaxData();
        } else if ($this->algorithm == 'ucb-1') {
            return $this->ucb1Data();
        }

        return false;
    }

    /**
     * Return alpha and beta for Thompson Sampling
     *
     * @return array
     */
    public function thompsonSamplingData()
    {
        $ts_data = [];

        foreach ($this->data as $name => $combination_data) {
            foreach ($combination_data as $combination_id => $data) {
                if ($this->combinations[$name][$combination_id] == 'baseline') {
                    continue;
                }
                $ts_data[$name][$combination_id] = [
                    'a' => $data['total_score'],
                    'b' => ($data['total_view'] - $data['total_click'])
                ];
            }
        }

        return $ts_data;
    }

    /**
     * Return score for Softmax algorithm
     *
     * @return array
     */
    public function softmaxData()
    {
        $sm_data = [];

        foreach ($this->data as $name => $combination_data) {
            $sm_data[$name] = ['view' => 0, 'score' => []];
            foreach ($combination_data as $combination_id => $data) {
                if ($this->combinations[$name][$combination_id] == 'baseline') {
                    continue;
                }
                $sm_data[$name]['view'] += $data['total_view'];
                $sm_data[$name]['score'][$combination_id] = $data['total_score']/($data['total_view'] ? $data['total_view'] : 1);
            }
        }

        return $sm_data;
    }

    /**
     * Return score for UCB-1
     *
     * @return array
     */
    public function ucb1Data()
    {
        $ucb1_data = [];

        foreach ($this->data as $name => $combination_data) {
            $sm_data[$name] = ['view' => [], 'score' => [], 'total_view' => 0];
            foreach ($combination_data as $combination_id => $data) {
                if ($this->combinations[$name][$combination_id] == 'baseline') {
                    continue;
                }
                $ucb1_data[$name]['total_view'] += $data['total_view'];
                $ucb1_data[$name]['view'][$combination_id] = $data['total_view'];
                $ucb1_data[$name]['score'][$combination_id] = $data['total_score'];
            }
        }

        return $ucb1_data;
    }
}
