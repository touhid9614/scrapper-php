<?php

global $scrapper_configs;
$scrapper_configs["gvw"] = array(
    'entry_points' => array(
        'used' => 'https://www.gvw.ca/en/used-inventory?limit=124',
        'new' => 'https://www.gvw.ca/en/new-inventory?limit=124',
        
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/en\/(?:inventory\/)?(?:new|used)\/vehicle\//i',
    'ty_url_regex' => '/\/thank-you/i',
    'ajax_url_match' => '/confirm-availability/',
    'ajax_resp_match' => 'Thank You For Your Inquiry - MacDonald Auto Group',
    'picture_selectors' => ['.image-select li a', '#bxslider-pager a'],
    'picture_nexts' => ['', '#cboxNext'],
    'picture_prevs' => ['', '#cboxPrevious'],
    'details_start_tag' => '<section class="page-content__right">',
    'details_end_tag' => '<p class="inventory-listing__disclaimer',
    'details_spliter' => '<article class="inventory-list-layout-wrapper',
    // 'must_contain_regx' => '/Stock #:[^>]+>[^>]+>(?<stock_number>1-[0-9]*[aA])/',
    'data_capture_regx' => array(
        //  'stock_number'  => '/<span class="vehicle-stockno"\s*itemprop="sku">#(?<stock_number>[^<]+)/',
        'title' => '/preview-name" href="[^"]+" title="(?<title>(?<year>[^\s]+) (?<make>[^\s]+) (?<model>[^\s]+))/',
        'year' => '/preview-name" href="[^"]+" title="(?<title>(?<year>[^\s]+) (?<make>[^\s]+) (?<model>[^\s]+))/',
        'make' => '/preview-name" href="[^"]+" title="(?<title>(?<year>[^\s]+) (?<make>[^\s]+) (?<model>[^\s]+))/',
        'model' => '/preview-name" href="[^"]+" title="(?<title>(?<year>[^\s]+) (?<make>[^\s]+) (?<model>[^\s]+))/',
        'price' => '/vehicle__rebate" data-theme-style="utilBlackColor__color">\s*(?<price>[^<]+)/',
        'kilometres' => '/vehiclePreview_secondaryColor">(?<kilometres>[0-9 ,]+)\s*/',
        'url' => '/preview-name" href="(?<url>[^"]+)/'
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/Inventory #:<\/div>\s*[^>]+>(?<stock_number>[^<]+)/',
        // 'transmission'  => '/<span class="clutch">(?<transmission>[^<]+)/',
        'body_style' => '/Bodystyle:<\/div>\s*[^>]+>(?<body_style>[^<]+)/',
        'engine' => '/Cylinders:<\/div>\s*[^>]+>(?<engine>[^<]+)/',
        'exterior_color' => '/Ext\. Color:<\/div>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Int\. color:<\/div>\s*[^>]+>(?<interior_color>[^<]+)/',
    ),
    'next_page_regx' => '/pagination__page-button-text--selected"[^\n]+\s*[^\n]+\s*[^\n]+\s[^\n]+\s*<li[^>]+>\s.*href="(?<next>[^"]+)/',
    'images_regx' => '/<meta name="twitter:image" content="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta name="twitter:image" content="(?<img_url>[^"]+)"/',
);
 add_filter("filter_gvw_field_images", "filter_gvw_field_images",10,2);
 function filter_gvw_field_images($im_urls,$car_data)
    {

    if(isset($car_data['url']) && $car_data['url'])
    {
       $id=explode("/",$car_data['url']);
       $api_url="https://www.gvw.ca/en/inventory/" . $car_data['stock_type'] . "/fragments/vehiclesByIds?view=ninjabox-gallery&vehicleId={$id[count($id)-1]}";
       slecho("api url:" . $api_url);
       $response_data = HttpGet($api_url);
       $regex       =  '/<img src="(?<img_url>[^"]+)" alt=/';

        $matches = [];


        if(preg_match_all($regex, $response_data, $matches)) {

            foreach ($matches['img_url'] as $key => $value)
            {
               $im_urls[]=$value;
            }
            unset($im_urls[0]); 
             //return  $im_urls;

        }


    }
        return  $im_urls;
    }
