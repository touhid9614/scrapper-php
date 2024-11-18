<?php
global $scrapper_configs;
$scrapper_configs["donnellymitsubishica"] = array( 
	 'entry_points' => array(
           'used' => 'https://donnellymitsubishi.ca/en/inventory/?type=used&pg=1',
           'new' => 'https://donnellymitsubishi.ca/en/inventory/?type=new&pg=1',
   
    ),
     
    'vdp_url_regex' => '/\/inventory\/[0-9]{4}-/i',
    'use-proxy' => true,
     'refine'=>false,
    'picture_selectors' => ['.inventory-image-thumb'],
    'picture_nexts' => ['.inventory-slick-next'],
    'picture_prevs' => ['.inventory-slick-prev'],
    'details_start_tag' => '<div class="col-md-8',
    'details_end_tag' => '<div class="modal fade"',
    'details_spliter' => '<div class="inventory-search-result-container',
    'data_capture_regx' => array(
        'stock_type' => '/class="inventory-type">(?<stock_type>[^<]+)/',
        'url' => '/class="inventory-type">(?:New|Certified|Used)<\/div><a class="inventory-title" href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'title' => '/class="inventory-type">(?:New|Certified|Used)<\/div><a class="inventory-title" href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'year' => '/class="inventory-type">(?:New|Certified|Used)<\/div><a class="inventory-title" href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'make' => '/class="inventory-type">(?:New|Certified|Used)<\/div><a class="inventory-title" href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'model' => '/class="inventory-type">(?:New|Certified|Used)<\/div><a class="inventory-title" href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'stock_number' => '/Stock Number:[^>]+>[^>]+>(?<stock_number>[^\s*]+)/',
        'price' => '/class="inventory-price-number">(?<price>\$[0-9,]+)/',
        'transmission' => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'kilometres' => '/Mileage:<\/div>\s*<div class=\'inventory-details-value\'>(?<kilometres>[^<]+)/'
    ),
    'data_capture_regx_full' => array(
        'make' => '/Make:<\/div>\s*<div class=\'inventory-details-value\'>(?<make>[^<]+)/',
        'model' => '/Model:<\/div>\s*<div class=\'inventory-details-value\'>(?<model>[^<]+)/',
        'trim' => '/Trim:<\/div>\s*<div class=\'inventory-details-value\'>(?<trim>[^<]+)/',
        'price' => '/Selling Price:<\/div>\s*[^>]+>(?<price>\$[0-9,]+)/',
        'interior_color' => '/Interior:<\/div>\s*<div class=\'inventory-details-value\'>(?<interior_color>[^<]+)/',
        'exterior_color' => '/Exterior:<\/div>\s*<div class=\'inventory-details-value\'>(?<exterior_color>[^<]+)/',
        'vin'            => '/VIN:<\/div>[^>]+>(?<vin>[^<]+)/',
        'body_style'     => '/Body Style:<\/div>[^>]+>(?<body_style>[^<]+)/',
        'kilometres'     => '/Mileage:<\/div>[^>]+>(?<kilometres>[^<]+)/',
       // 'engine'         => '/Transmission:<\/div>[^>]+>(?<engine>[^<]+)/',   
    ),
    'next_page_regx' => '/<button class="inventory-pager-link next" pagenum="(?<next>[^"]+)"/',
    'images_regx' => '/class="inventory-image-large"><img src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

 add_filter("filter_donnellymitsubishica_next_page", "filter_donnellymitsubishica_next_page",10,2);
  add_filter("filter_donnellymitsubishica_field_stock_type", "filter_donnellymitsubishica_field_stock_type");

    function filter_donnellymitsubishica_field_stock_type($stock_type) {
        return strtolower($stock_type);
    }

       function filter_donnellymitsubishica_next_page($next,$current_page) {
           
           slecho($current_page);
           slecho($next);
           
          $next=explode('/',$next);
           $index=count($next)-1;
           $next=($next[$index]);
           //$next++;
           $peg="pg=" . $next;
           $prev="pg=" . ($next-1);
           $url= str_replace($prev, $peg, $current_page);
           slecho("sgsgsdrgsr" . $url);
            return $url;
           
   }