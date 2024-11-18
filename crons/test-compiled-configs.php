<?php

require dirname(__DIR__) . '/vendor/autoload.php';

define('yes', true);
define('no', false);

/**
 * Loads from regular configs.
 *
 * @param      string  $config_directory           The configuration directory
 * @param      string  $scrapper_config_directory  The scrapper configuration directory
 */
function load_from_regular_configs($config_directory, $scrapper_config_directory)
{
    // load configuration dynamically from $config_directory
    if (is_dir($config_directory)) {
        foreach (array_filter(glob($config_directory . '/*.php'), 'is_file') as $file) {
            require_once $file;
        }
    }

    $scrapper_configs = [];

    if (is_dir($scrapper_config_directory)) {
        foreach (array_filter(glob($scrapper_config_directory . '/*.php'), 'is_file') as $file) {
            require_once $file;
        }
    }
}

/**
 * Loads a from combined file.
 *
 * @param      <type>  $compiled_file  The compiled file
 * @param      <type>  $redis          The redis
 */
function load_from_combined_file($compiled_file, $redis)
{
    require_once $compiled_file;
}

/**
 * { function_description }
 *
 * @param      <type>  $config_directory           The configuration directory
 * @param      <type>  $scrapper_config_directory  The scrapper configuration directory
 * @param      <type>  $compiled_file              The compiled file
 * @param      <type>  $redis                      The redis
 */
function bench_mark($config_directory, $scrapper_config_directory, $compiled_file, $redis)
{
    $start = microtime(true);
    load_from_combined_file($compiled_file, $redis);
    $time_elapsed_secs = microtime(true) - $start;

    echo "Time taken: $time_elapsed_secs seconds" . PHP_EOL;
}

# General configurations
$config_directory          = dirname(__DIR__) . "/adwords3/config";
$scrapper_config_directory = dirname(__DIR__) . "/adwords3/scrapper-config";
$compiled_file             = dirname(__DIR__) . "/adwords3/caches/combined-configs.php";

global $CronConfigs, $scrapper_configs;

use Predis\Client as RedisClient;

$redis = new RedisClient();

bench_mark($config_directory, $scrapper_config_directory, $compiled_file, $redis);