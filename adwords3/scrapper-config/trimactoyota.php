<?php
    global $scrapper_configs;
    $scrapper_configs['trimactoyota'] = array(
        'entry_points'        => array(
            'used' => 'https://trimactoyota.ca/used-inventory/',
        ),
         'srp_page_regex'      => '/\/(?:new|used|certified)-inventory\//i',
        'vdp_url_regex'       => '/\/inventory\/[0-9]{4}-.*\/[0-9]{4,17}/i',
        'use-proxy'           => true,
    
        "custom_data_capture" => function ($url, $data) {
            $site                 = "https://trimactoyota.ca/inventory-sitemap.xml";
            $vdp_url_regex        = '/\/inventory\//i';
            $images_regx          = '/<img\s*class="image"\s*data\-loop="[^"]+"\s*src="data[^"]+"\s*alt="[^"]+"\s*data\-lazy\-src="(?<img_url>[^"]+)/i';
            $images_fallback_regx = '/<meta name="og:image" content="(?<img_url>[^"]+)"/i';
            $required_params      = [];
            $use_proxy            = true;
            $invalid_images       = [];
    
            $annoy_func = function ($car) {
                 
                $ignore_data=[
                    'RA068',
                    'RA056',
                    'TU611',
                    'PR603',
                    
                    'RA038',
                    'RA605',
                    'TU605',
                    'RA070',
                    
                    'C0917',
                    'TA624',
                    'RT605',
                    'CO917',
                ];
    
            if (in_array($car['stock_number'], $ignore_data)) 
            {
                slecho("Excluding car that has  ,{$car['stock_number']}");
                 return null;

            }
                
                return $car;
            };
    
            $data_capture_regx_full = [
                'stock_type'     => '/data-status="(?<stock_type>[^"]+)/i',
                'stock_number'   => '/Stock #[^>]+>[^>]+>(?<stock_number>[^<]+)/',
                'vin'            => '/VIN[^>]+>[^=]+\="feature\-[^>]+>(?<vin>[^<]+)/',
                'year'           => '/itemprop="releaseDate">(?<year>[^<]+)/',
                'make'           => '/itemprop="brand">(?<make>[^<]+)/',
                'model'          => '/itemprop="model">(?<model>[^<]+)/',
                'price'          => '/final-price" >(?<price>[^<]+)/',
                'kilometres'        =>'/"miles":"(?<kilometres>[^"]+)/',
                'transmission'   => '/"transmission":"(?<transmission>[^"]+))/',
            ];
    
            $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);
    
            return $cars;
        }
    );
    
    add_filter('filter_for_fb_trimactoyota', 'filter_for_fb_trimactoyota', 10, 2);

function filter_for_fb_trimactoyota($car_data, $feed_type)
{   
    
    $images = explode('|', $car_data['all_images']);
    if (count($images) <= 2) {
        return null;
    }
    
    if($car_data['stock_number']=='TA626' ||$car_data['stock_number']=='HI613'){
        return null;
    }

    
    return $car_data;
}
