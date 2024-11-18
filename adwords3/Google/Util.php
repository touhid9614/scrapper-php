<?php

require_once 'Types.php';

/**
 * Loads a configuration.
 *
 * @param      <type>  $set_path  The set path
 *
 * @return     Config  ( description_of_the_return_value )
 */
function LoadConfig($set_path,$sys_debug = false)
{
    if (!file_exists($set_path)) {
        return new Config();
    }

    $fh         = fopen($set_path, 'r');
    $stringData = fread($fh, filesize($set_path));
    fclose($fh);

	if($sys_debug){
		slecho("ERROR: Config data file found::  $stringData");
	}

    return unserialize($stringData);
}

/**
 * Saves a configuration.
 *
 * @param      <type>  $settings  The settings
 * @param      <type>  $set_path  The set path
 */
function SaveConfig($settings, $set_path)
{
    $stringData = serialize($settings);

    $fh = fopen($set_path, 'w') or die("can't open file " . $set_path);
    fwrite($fh, $stringData);
    fclose($fh);
}

$log_path = 'data/log.txt';

/**
 * Reads a log.
 *
 * @return     string  ( description_of_the_return_value )
 */
function ReadLog()
{
    global $log_path;

    if (!file_exists($log_path)) {
        return '';
    }

    $fh         = fopen($log_path, 'r');
    $stringData = fread($fh, filesize($log_path));
    fclose($fh);

    return $stringData;
}

/**
 * Adds a 2 log.
 *
 * @param      string  $message  The message
 */
function Add2Log($message)
{
    global $log_path;

    slecho($message);

    $message = date("[d/m/Y G:i:s a (e)] ") . $message . "\n";

    $fh = fopen($log_path, 'a') or die("can't open file");
    fwrite($fh, $message);
    fclose($fh);
}

/**
 * Determines whether the specified text is currency.
 *
 * @param      <type>  $text   The text
 *
 * @return     <type>  True if the specified text is currency, False otherwise.
 */
function IsCurrency($text)
{
    return preg_match("/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/", $text);
}

/**
 * Calculates the by weekly.
 *
 * @param      integer  $totalPrice    The total price
 * @param      integer  $tax           The tax
 * @param      integer  $deposit       The deposit
 * @param      integer  $interestRate  The interest rate
 * @param      integer  $months        The months
 * @param      integer  $fee           The fee
 *
 * @return     integer  The by weekly.
 */
function calculateByWeekly($totalPrice, $tax, $deposit, $interestRate, $months, $fee)
{
    $totalPrice = ($totalPrice + $fee) * (1 + $tax);
    $numberOfPayments = ($months / 12) * 26;
    $murrayNumerator = ($totalPrice - $deposit) * ($interestRate / 26) * pow((1 + $interestRate / 26), $numberOfPayments);
    $murrayDenominator = pow((1 + $interestRate / 26), $numberOfPayments) - 1;
    $murrayBiweeklyPayments = $murrayNumerator / $murrayDenominator;

    return $murrayBiweeklyPayments;
}

/**
 * Gets the base url.
 *
 * @return     string  The base url.
 */
function GetBaseURL()
{
    $pageURL = 'http';

    if (@$_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }

    $pageURL .= "://";

    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }

    if (stripos($pageURL, '?')) {
        $pageURL = substr($pageURL, 0, stripos($pageURL, '?'));
    }

    // at this moment this will point to the request base directory
    if (strripos($pageURL, '/') != count($pageURL) - 1) {
        $pageURL = substr($pageURL, 0, strripos($pageURL, '/') + 1);
    }

    return $pageURL;
}

/**
 * Gets the old price.
 *
 * @param      array    $prices  The prices
 * @param      integer  $index   The index
 *
 * @return     boolean  The old price.
 */
function getOldPrice(array $prices, $index = 2)
{
    if (sizeof($prices) < $index) {
        return false;
    }

    $ret_index = sizeof($prices) - $index;
    $i         = 0;

    foreach ($prices as $key => $val) {
        if ($i == $ret_index) {
            return $val;
        }

        $i++;
    }
}
