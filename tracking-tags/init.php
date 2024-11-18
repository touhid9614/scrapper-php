<?php

/**
 * Check if `ref` paramter is set, don't use $_SERVER['HTTP_REFERER'] for URL
 * If not present reload tag with `ref` parameter.
 */
$_url = filter_input(INPUT_GET, 'ref'); //(isset($_GET['ref']) && $_GET['ref'])?$_GET['ref']:$_SERVER['HTTP_REFERER'];

if (!$_url) {
?>
	!function() {
		if (window.sMediaIncluded) {
			return;
		}

		window.sMediaIncluded = true;
		sfn="//tm.smedia.ca/analytics/script.js?ref=" + encodeURIComponent(location.href);
		sref=document.createElement('script');
		sref.setAttribute("type","text/javascript");
		sref.setAttribute("src", sfn);
		sref.setAttribute("async", "");
		document.getElementsByTagName("head")[0].appendChild(sref);
	}();
<?php
	exit;
}

if (!defined('smedia_tag')) {
	define('smedia_tag', true);
}

$tmp_path = dirname(dirname(__FILE__));

$abs_path = str_replace('\\', '/', $tmp_path);

if (!defined('TT_ABSPATH')) {
	define('TT_ABSPATH', $abs_path);
}

if (!defined('CACHEDIR')) {
	define('CACHEDIR', $abs_path . "/tag-cache/");
}

/** INITIATE AUTH SESSION DATA **/
$_GET['customer'] = 'marshal';

require_once    TT_ABSPATH . '/adwords3/cron_misc.php';
require_once    TT_ABSPATH . '/adwords3/utils.php';
require_once    TT_ABSPATH . '/adwords3/config.php';
require_once    TT_ABSPATH . '/dashboard/includes/functions.php';
require_once    TT_ABSPATH . '/adwords3/Google/Consts.php';
require_once    TT_ABSPATH . '/adwords3/Google/TokenHelper.php';
require_once    TT_ABSPATH . '/adwords3/Google/SessionManager.php';
require_once    TT_ABSPATH . '/adwords3/Google/Analytics.php';
require_once    TT_ABSPATH . '/tracking-tags/trackers.php';

$url = mild_url_encode($_url);

$ref_url    = $url;
$debug      = stripos($url, 'smedia_debug=true') > 0;
$mail_debug = stripos($url, 'mail_debug=true') > 0;

$template_regx  = '/utm_template=(?<template>[^&\\s#]+)/';
$directive_regx = '/#(?<directive>(?:newsearch|usedsearch|newdisplay|useddisplay|newretargeting|usedretargeting|newmarketbuyer|usedmarketbuyer|smedia\-custom))/';
$tags_regx      = '/#(?<tag>[a-zA-Z_\-0-9]+)/';

$match = array();

$template  = null;
$directive = null;
$tags      = null;

preg_match($template_regx, $url, $match);

if ($match && isset($match['template'])) {
	$template = $match['template'];
}

preg_match($directive_regx, $url, $match);

if ($match && isset($match['directive'])) {
	$directive = $match['directive'];
}

if (preg_match_all($tags_regx, $url, $match)) {
	$tags = $match['tag'];
}

$url = removeParams($url);

global $domain;

$domain = GetDomain($url);
