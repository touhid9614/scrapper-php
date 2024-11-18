<?php
global $scrapper_configs;
$scrapper_configs["lesliemotorscom"] = array(
    'entry_points'           => array(
        'used' => 'https://lesliemotors.com/pre-owned-vehicles?resultsToLoad=200',
        'new'  => 'https://lesliemotors.com/new-vehicles/model/all?resultsToLoad=200',
    ),
     'srp_page_regex'          => '/\/(?:new-vehicles|pre-owned-vehicles)/i',
    'vdp_url_regex'          => '/\/[0-9]{4}-/i',
    'use-proxy'              => true,
    'refine'                  => false,
    'picture_selectors'      => ['.image-viewer__primary-image'],
    'picture_nexts'          => ['.mfp-arrow-right'],
    'picture_prevs'          => ['.mfp-arrow-left'],
    'details_start_tag'      => '<div class="vehicle-index grid-x grid-margin-x grid-margin-y small-up-1 medium-up-2 large-up-3">',
    'details_end_tag'        => '<div class="grid-x grid-margin-x grid-margin-y">',
    'details_spliter'        => 'See Vehicle Details</a>',

    'data_capture_regx'      => array(
        'url'          => '/<article class="vehicle-item[^>]+>\s*<a href="(?<url>[^"]+)/',
        'year'         => '/<h1 class="h4">\s*(?<year>[^\s*]+)/',
        'make'         => '/<h1 class="h4">.*\s*(?<make>[^\s*]+)/',
        'model'        => '/<h1 class="h4">.*\s*.*\s*(?<model>[^\n]+)/',
      //  'trim'         => '/<h1 class="h4">\s*(?<year>[^ ]+)\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*(?<trim>[^<]+)/',
        'price'        => '/<strong>Our Price:<\/strong>\s*(?<price>\$[0-9,]+)/',
        'kilometres'   => '/<strong>Odometer:<\/strong>\s*(?<kilometres>[^\s]+)/',
   
        'stock_number' => '/<small>#(?<stock_number>[^\<]+)/',

    ),
    'data_capture_regx_full' => array(
           'description'    => '/class="vehicle-description">\s*<[^>]+>(?<description>[^<]+)/',    
        'vin'            => '/<dt>VIN<\/dt><dd class="serial-number">(?<vin>[^<]+)/',
        'engine'         => '/<dt>Engine<\/dt>\s*<dd>(?<engine>[^\<]+)/',
        'transmission'   => '/<dt>Transmission<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
        'exterior_color' => '/<dt>Exterior<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/<dt>Interior<\/dt>\s*<dd>(?<interior_color>[^\<]+)/',
        'custom'         => '/This vehicle is being sold \“(?<custom>[^\,]+)/',
        
    ),

    // 'next_page_regx' => '/href="(?<next>[^"]+)"\s*rel="next"/',
    'images_regx'            => '/data-primary-srcset="(?<img_url>[^",\s*]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_lesliemotorscom_field_images", "filter_lesliemotorscom_field_images");
function filter_lesliemotorscom_field_images($im_urls)
{
    $retval = [];
    $illegal_array = ['Arriving-Soon.png', 'New-In-Stock-Picture.png','New-in-Stock'];

    foreach ($im_urls as $img) {
        if (!(strContains($img, "New-In-Stock-Picture") || strContains($img, "Arriving-Soon")||strContains($img, "New-in-Stock"))) {
            $img2      = trim(str_replace(["amp;", "800w"], ["", ""], $img));
            $img_parts = explode("?", $img2);
            $part1     = $img_parts[0];
            $part2     = $img_parts[1];
            //$retval[]  = $part1 . "?" . urlencode($part2);
            $ret = $part1 . "?" . $part2;
            
             $retval[] =str_replace('\/', '/', $ret);
        }
    }

    return $retval;
}

add_filter('filter_lesliemotorscom_car_data', 'filter_lesliemotorscom_car_data');
    
    function filter_lesliemotorscom_car_data($car_data) {
        
        $ignored_catagory = [
            '20ED452A'
            ,'20T600A'
            ,'20T729A'
            ,'MACHAN'
            ,'20346B'
            ,'20ED805B'
            ,'19ED405B'
            ,'20518B'
            ,'20R835A'
            ,'20ED803B'
            ];
        
            if (in_array($car_data['stock_number'], $ignored_catagory)) 
            {
                slecho("ignoring categories...{$car_data['stock_number']}");
                return [];
            }
            
            if (isset($car_data['custom'])) {
                 return null;
            }
            if ($car_data['custom'] == 'as-is') {
                return null;
            }
            return $car_data;
    }   
   
   