<?php


/**
 * Resolves file url.
 *
 * @param      <type>  $file   The file
 */
function resolve_file_url($file)
{
    $file = str_replace('\\', '/', $file);

    if (startsWith($file, ABSPATH)) {
        $relative_path = substr($file, strlen(ABSPATH));
        $url = ABSURL . $relative_path;

        return $url;
    } else {
        return false;
    }
}


/**
 * Redirects to provided url.
 *
 * @param      <type>  $url    The url
 */
function redirect_to($url)
{
    header("Location: $url");

    die();
}


/**
 * Calculates the signature.
 *
 * @param      string  $user_id    The user identifier
 * @param      <type>  $user_type  The user type
 * @param      <type>  $password_hash   The password_hash
 *
 * @return     <type>  The signature.
 */
function compute_signature($user_id, $user_type, $password_hash)
{
    return hash_hmac('md5', $user_id . '-' . $user_type, $password_hash);
}


/**
 * Gets the analytics report.
 *
 * @param      Analytics  $analytics        The analytics
 * @param      <type>     $profileId        The profile identifier
 * @param      <type>     $startDate        The start date
 * @param      <type>     $endDate          The end date
 * @param      <type>     $metrics          The metrics
 * @param      <type>     $dimensions       The dimensions
 * @param      <type>     $filters          The filters
 * @param      integer    $cache_for_hours  The cache for hours
 *
 * @return     Analytics  The analytics report.
 */
function get_analytics_report(Analytics $analytics, $profileId, $startDate, $endDate, $metrics, $dimensions, $filters, $cache_for_hours = 24)
{
    $str_metrics = implode(',', $metrics);
    $str_dimensions = implode(',', $dimensions);
    $cache_name = md5("analytics_report_cache_{$profileId}_{$startDate}_{$endDate}_{$str_metrics}_{$str_dimensions}_{$filters}_v1") . ".analytics";

    $report = get_object_cache($cache_name, $cache_for_hours);

    if (!$report) {
        $report = $analytics->GetReport($profileId, $startDate, $endDate, $metrics, $dimensions, $filters);
        store_object_cache($cache_name, $report);
    }

    return $report;
}


/**
 * Gets the object cache.
 *
 * @param      <type>   $cache_name  The cache name
 * @param      integer  $hours       The hours
 *
 * @return     <type>   The object cache.
 */
function get_object_cache($cache_name, $hours = 24)
{
    $filename = CACHEDIR . $cache_name;

    if (!file_exists($filename)) {
        return null;
    }

    $now = time();
    $ft = filemtime($filename);

    $diff = $now - $ft;

    if ($diff < (3600 * $hours)) {
        $data = file_get_contents($filename);
        $u_data = unserialize($data);

        return $u_data;
    } else {
        return null;
    }
}


/**
 * Stores an object cache.
 *
 * @param      <type>  $cache_name  The cache name
 * @param      <type>  $data        The data
 */
function store_object_cache($cache_name, $data)
{
    $filename = CACHEDIR . $cache_name;

    $cdata = serialize($data);

    file_put_contents($filename, $cdata, LOCK_EX);
}


/**
 * Converts seconds into minute:second
 *
 * @param      integer  $second  The second
 *
 * @return     <type>   ( description_of_the_return_value )
 */
function seconds2minute_seconds($second)
{
    $minutes = floor($second / 60);
    $seconds = $second - ($minutes * 60);

    return str_pad($minutes, 2, "0", STR_PAD_LEFT) . ":" . str_pad($seconds, 2, "0", STR_PAD_LEFT);
}


/**
 * Splits urls in lines.
 *
 * @param      <type>  $url    The url
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function URLSplit($url)
{
    return str_replace("\n", '<br>', $url);
}


/**
 * Prints url in desired format
 *
 * @param      string  $url    The url
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function URLPrint($url)
{
    return (isset($url) ? (($url == '') ? 'Unavailable in DB' : URLSplit($url)) : 'N/A');
}


/**
 * Checks for empty or invalid
 *
 * @param      string  $data   The data
 *
 * @return     string  ( description_of_the_return_value )
 */
function checkAndSet($data)
{
    if ($data == '') {
        return 'N/A';
    } else {
        return (isset($data) ? $data : 'N/A');
    }
}

/**
 * @param   string  $url    Vdp Url
 * 
 * @return  string  ( hash value of vdp url extracting host and query params )
 */
function getUuidFromVdp($url)
{
    $url_parts = parse_url(urldecode($url));
    $path = $url_parts['path'];
    return hash("sha256", $path);
}
