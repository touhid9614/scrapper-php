<?php
global $scrapper_configs;
$scrapper_configs["superiorhyundaica"] = array( 
	   'entry_points' => array(
        'used' => 'https://www.superiorhyundai.ca/used/',
        'new' => 'https://www.superiorhyundai.ca/new/',
       
    ),
    'vdp_url_regex'     => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
     'srp_page_regex'     => '/\/(?:new|used)\//i',
        'use-proxy' => true,
        'refine' => false,
        'picture_selectors' => ['.thumb li'],
        'picture_nexts'     => ['li.next'],
        'picture_prevs'     => ['li.prev'],
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<footer class="opt-17 wp"',
        'details_spliter'   => '<div class="col-xs-12 col-sm-12 col-md-12"',
        'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        // 'stock_type' => '/"condition":"(?<stock_type>[^"]+)/',
        'year' => '/itemprop=\'releaseDate\' notranslate>(?<year>[0-9]{4})/',
        'make'           => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
        'model'          => '/itemprop=\'model\' notranslate><var>(?<model>[^\<]+)/',
        'trim' => '/"trim":"(?<trim>[^"]+)"/',
        'price' => '/itemprop="price" content="[^>]+>(?<price>\$[0-9,]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^\s*]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        'vin'       => '/VIN:[^>]+>[^>]+>(?<vin>[^<]+)/',

        ),
        'data_capture_regx_full' => array(        
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]+>\s*(?<kilometres>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>\s*(?<exterior_color>[^\<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin' => '/data-vin="(?<vin>[^"]+)/',
        'model' => '/\&model=(?<model>[^\&]+)/',
        'trim' => '/\&trim=(?<trim>[^\&]+)/',    
            'description' => '/<meta name="description" content="(?<description>[^<]+)"/',
        ) ,
        'next_page_regx'    => '/class="active"><a\s*href="">[^<]*<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/imgError\(this\)\;"\s*(?:data-src|src)="(?<img_url>[^"]+)/'
    );
    
  add_filter('filter_superiorhyundaica_car_data', 'filter_superiorhyundaica_car_data');
function filter_superiorhyundaica_car_data($car_data)
{
    
    if (isset($car_data['stock_number']))
    {
        if (startsWith($car_data['stock_number'], 'I') || endsWith($car_data['stock_number'], 'I'))
        {
            slecho("this stock number contains charcter I");
            return null;
        }
        
        if (($car_data['model']=='Sonata') )
        {
            slecho("this model contains charcter Sonata");
            return null;
        }
        
        if (($car_data['make']=='Harley-Davidson') )
        {
            slecho("this make  filter out Harley-Davidson");
            return null;
        }
    }
    slecho("this stock number does not contains charcter I");
    return $car_data;
}
add_filter("filter_superiorhyundaica_field_images", "filter_superiorhyundaica_field_images");
    
    function filter_superiorhyundaica_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'new_vehicles_images_coming.png');
        });
    }