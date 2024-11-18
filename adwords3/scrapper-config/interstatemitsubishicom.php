<?php
global $scrapper_configs;
$scrapper_configs["interstatemitsubishicom"] = array( 
	"entry_points" => array(
		 'used' => 'https://interstatemitsubishi.com/inventory/used',
         'new' => array(
            'https://interstatemitsubishi.com/inventory/new/mitsubishi/mirage-g4?paymenttype=cash&years=2019',
            'https://interstatemitsubishi.com/inventory/new/mitsubishi/mirage?paymenttype=cash&years=2019',
            'https://interstatemitsubishi.com/inventory/new/mitsubishi/mirage?paymenttype=cash&years=2020',
            'https://interstatemitsubishi.com/inventory/new/mitsubishi/mirage-g4?paymenttype=cash&years=2020',
    'https://interstatemitsubishi.com/inventory/new/mitsubishi/outlander-sport?paymenttype=cash&years=2020',
        'https://interstatemitsubishi.com/inventory/new/mitsubishi/outlander?paymenttype=cash&years=2020',
        'https://interstatemitsubishi.com/inventory/new/mitsubishi/eclipse-cross?paymenttype=cash&years=2020',
        'https://interstatemitsubishi.com/inventory/new/mitsubishi/outlander-phev?paymenttype=cash&years=2020',
           
        ),
        
    ),
    'vdp_url_regex' => '/\/viewdetails\/(?:new|used)\//i',
    'use-proxy' => true,
    'refine'=>false,
    'picture_selectors' => ['.vehicle-img'],
    'picture_nexts' => ['.fa-chevron-right'],
    'picture_prevs' => ['.fa-chevron-left'],
    
    'details_start_tag' => '<div class="row mb-5 mt-2"',
    'details_end_tag' => 'class="mb-3 py-3 d-flex justify-content-end',
    'details_spliter' => '<div class="col-md-6 col-lg-6 col-xl-4 col-xxl-4 mb-4',
    
    'data_capture_regx' => array(
        'url'   => '/<div class="d-flex">\s*<a href="(?<url>[^"]+)" target/',
        'year'  => '/<div class="d-flex">\s*<a href=".*(?<year>[0-9]{4})-(?<make>[^-]+)-(?<model>[^-]+)/',
        'make'  => '/<div class="d-flex">\s*<a href=".*(?<year>[0-9]{4})-(?<make>[^-]+)-(?<model>[^-]+)/',
        'model' => '/<div class="d-flex">\s*<a href=".*(?<year>[0-9]{4})-(?<make>[^-]+)-(?<model>[^-]+)/',
        'price' => '/Your Price<\/div>[^>]+>(?<price>\$[0-9,]+)/',
        'kilometres' => '/Mileage:\s*(?<kilometres>[0-9,]+)/',
        'vin'   => '/VIN:\s*(?<vin>[^<]+)/',
        'stock_number' => '/Stock:\s*#(?<stock_number>[^<]+)/',
        
    ),
    'data_capture_regx_full' => array(
        
        'engine' => '/Engine:\s*(?<engine>[^\s]+)/',
        
        
        
    ),
    'next_page_regx' => '/class="page-link color-primar[^"]+"\s*href="(?<next>[^"]+)"\s*rel="next/',
    'images_regx' => '/<a itemprop="url" href="(?<img_url>[^"]+)/',
);

add_filter("filter_interstatemitsubishicom_field_images", "filter_interstatemitsubishicom_field_images",10,2);

function filter_interstatemitsubishicom_field_images($im_urls,$car_data) 
{
    if (isset($car_data['vin']) && $car_data['vin'])
    {   
        $api_url="https://interstatemitsubishi.com/Api/Inventory/getVehicleImages/?styleId=0&width=0&height=0&accountID=53268&vin={$car_data['vin']}";
        slecho("api url:" . $api_url);  
        $response_data = HttpGet($api_url);
              
        if ($response_data) 
        {
            $obj = json_decode($response_data);
            return  $obj;
            
        }
    }

    
}