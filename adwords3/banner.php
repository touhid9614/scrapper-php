<?php

    //die();

    $debug = filter_input(INPUT_GET, 'debug') == 'true';
    $sys_debug = filter_input(INPUT_GET, 'sys_debug') == '1';
    define('BANNER_DEBUG', $debug);
    $lang = filter_input(INPUT_GET, 'lang') ? filter_input(INPUT_GET, 'lang') : 'en';

    if (!defined('adlang')) 
    {
        define('adlang', $lang);
    }
    
//    ini_set('display_errors', 1);
//    ini_set("log_errors", 1);
//    error_reporting(E_ALL);
     
    //error_reporting(1);
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    require_once('utils.php');
    require_once('Google/Util.php');

    use sMedia\Core\Registry;
    use sMedia\Banner\BannerService;
    
    # Override banners cache directory
    Registry::set('cache_dir', dirname(__DIR__) . '/banner/');
    
    global $BannerConfigs;

    $template_name = filter_input(INPUT_GET, 'template');
    
    /*
     * @summary: Generates a banner based on the specified template and data
     *
     * REQUIRED PARAMETERS
     * @param template      : name of the template to be used (required)
     * @param config        : size configuration of the banner (required)
     * @param style         : style configuration defines the drawing style (required)
     * @param type          : if it is newdisplay, useddisplay, newretargeting or usedretargeting
     * @param title         : rawurlencoded value of title (optional)
     * @param make          : rawurlencoded value of make (optional)
     * @param model         : rawurlencoded value of model (optional)
     * @param price         : rawurlencoded value of price (optional)
     * @param year          : rawurlencoded value of desc1 (optional)
     * @param img1          : rawurlencoded value of img1 URL (optional)
     * @param img2          : rawurlencoded value of img2 URL (optional)
     * @param title_color   : rawurlencoded value of hex color code (optional)
     *********************************************************************/
    
    $style  = filter_input(INPUT_GET, 'style');
    $size   = filter_input(INPUT_GET, 'config');
    $type   = filter_input(INPUT_GET, 'type');
    $title  = filter_input(INPUT_GET, 'title');
    $year   = filter_input(INPUT_GET, 'year');
    $make   = filter_input(INPUT_GET, 'make');
    $model  = filter_input(INPUT_GET, 'model');
    
    if (!$size
        || !$style
        || !$type
        || !isset($BannerConfigs[$style])
        || !isset($BannerConfigs[$style][$size])
        || !$template_name
        || (!$make
        && !$model))
    {
        if (!array_key_exists($style, $BannerConfigs)) 
        { 
            bannerLog('Banner configuration does not support style: ' . $style, $template_name); 
        }

        if (!array_key_exists($size, $BannerConfigs[$style])) 
        { 
            bannerLog('Invalid resolution ' . $size . ' requested for banner-config/'. $style . '.php', $template_name); 
        }
        else 
        { 
            bannerLog('not enough parameters', $template_name); 
        }

        exit;
    }

    $bannerService = new BannerService( Registry::get('banner_s3'),
        Registry::get('cache_dir'),
        Registry::get('template_bucket'),
        Registry::get('banner_redis'),
        Registry::get('banner_prefix'),
        Registry::get('template_prefix'));

    $banner_params = filter_input_array(INPUT_GET);
    
    $imgdata = $bannerService->generateFromDescription($template_name, $banner_params);
    
    if ($imgdata) 
    {
        header('Content-type: image/png');
        echo $imgdata;
    }