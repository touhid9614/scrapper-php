<?php

global $scrapper_configs;

$scrapper_configs["echovalleygm"] = array(
    'entry_points'        => array(
        'used' => 'https://www.echovalleygm.com/used-vehicle-1-sitemap.xml',
    ),

    'vdp_url_regex'       => '/\/vehicles\/[0-9]+\//',
     'srp_page_regex'          => '/\/vehicles\//i',
    "use-proxy"           => false,
    'refine'              => false,

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.echovalleygm.com/used-vehicle-1-sitemap.xml";
        $another_site         = "https://www.echovalleygm.com/new-vehicle-1-sitemap.xml";
        $vdp_url_regex        = '/\/vehicles\/[0-9]+\//';
        $images_regx          = '//i';
        $images_fallback_regx = '//i';
        $required_params      = [];     // Mandatory url parameters
        $use_proxy            = false;   // Uses proxy to reach site
        $keymap               = null;   // Return the output data mapped against any car key
        $invalid_images       = [];     // List of image urls to be filtered out
        $use_custom_site      = true;   // Force crawler to use the given url as sitemap url

        // Modify car data if needed
        $annoy_func = function ($car_data) {
            $car_data['stock_type'] = strtolower($car_data['stock_type']);

            if($car_data['make'] == "" && $car_data['model'] == ""){
                $car_data = [];
            }
            
            $ignore_data=[
                '23000',
                //'62005',
            ];
            if (in_array($car_data['stock_number'], $ignore_data)) 
            {
                slecho("Excluding car that has  ,{$car_data['stock_number']}");
                return null;

            }

            //https://app.guidecx.com/app/projects/a754485e-2ba1-486b-b843-e35f62ea3f47/notes
            //making feed for the specific models
            if($car_data['stock_type'] == 'new' && $car_data['year'] == "2023" && $car_data['make'] == "GMC" && $car_data['model'] == "Sierra 1500" && $car_data['engine'] == "Turbocharged Gas I4 2.7L\/166"){
                $car_data['custom'] = 1;
                slecho("This is special Model for a feed");
            }
            

            $temp_data = HttpGet($car_data['url']);
            $images_regex = '/"image":"(?<img_url>[^"]+)/';
            $matches = [];
            
            $car_data['model']=ucwords(strtolower($car_data['model']));
            
            if(preg_match_all($images_regex, $temp_data, $matches))
            {
                $img_urls = [];
                $img_urls  =  $matches['img_url'];
                
                unset($img_urls[0]);
                unset($img_urls[1]);
                
                $img_urls=array_filter($img_urls, function($im_url){
                return !strpos($im_url,"srp-placeholder");
                
                });
                
                if(strpos($vehicle['WebsiteVDPURL'],"www.toyotabountiful.com")){
                 slecho("this vehicles is from www.toyotabountiful.com dealership");
                }
                
                $car_data['all_images'] = implode('|', $img_urls);
            }
            return $car_data;
        };

        $data_capture_regx_full = [
            'stock_type'     => '/\?sale_class\=(?<stock_type>[^"]+)"\s*\/>/i',
            'stock_number'   => '/"stock_number":"(?<stock_number>[^"]+)"\,"sty/',
            'vin'           => '/"vin":"(?<vin>[^"]+)"\,"a/',
            'year'           => '/"year":(?<year>[^\,]+)\,"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"\,"m/',
            'make'           => '/"year":(?<year>[^\,]+)\,"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"\,"m/',
            'model'          => '/"year":(?<year>[^\,]+)\,"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"\,"m/',
            'price'          => '/"final_price":(?<price>[^\,]+)/',
            'engine'         => '/"engine":"(?<engine>[^"]+)"\,"en/',
        ];

        $new_cars = sitemap_crawler($another_site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);
        $used_cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);
        return array_merge($new_cars, $used_cars);
    }
);