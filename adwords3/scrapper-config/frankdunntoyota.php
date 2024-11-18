<?php

global $scrapper_configs;

$scrapper_configs['frankdunntoyota'] = array(
//    'entry_points'           => array(
//       'new' => 'http://www.princealberttoyota.ca/inventory/new?type=new&order_by=show_price&order=asc&page=1',
//    ),
//    'vdp_url_regex'        => '/\/inventory\/(?:new|used)\/[^\/]+\/[0-9]{4}\//i',
//
//    'picture_selectors'    => ['.scroll-content-item'],
//    'picture_nexts'        => ['.bx-next'],
//    'picture_prevs'        => ['.bx-prev'],
//
//    "use-proxy"            => true,
//
//    "custom_data_capture"  => function ($url, $data) {
//        $site                 = "http://www.princealberttoyota.ca/sitemap.xml";
//        $vdp_url_regex        = '/\/inventory\/(?:new|used)\/[^\/]+\/[0-9]{4}\//i';
//        $images_regx          = '/<a itemprop="url" href="(?<img_url>[^"]+)/i';
//        $images_fallback_regx = '/<meta property="og:image"\s*content="(?<img_url>[^"]+)"/i';
//        $required_params      = [];     // Mandatory url parameters
//        $use_proxy            = true;   // Uses proxy to reach site
//        $keymap               = null;   // Return the output data mapped against any car key
//        $invalid_images       = [];     // List of image urls to be filtered out
//        $use_custom_site      = true;   // Force crawler to use the given url as sitemap url
//
//    
//   
//        $data_capture_regx_full = [
//          
//            'stock_type'        => '/<li class="specs">\s*[^>]+>\s*Type[^>]+>\s*[^>]+>(?<stock_type>[^<]+)/',
//            'vin'            => '/<li class="specs">\s*[^>]+>\s*VIN[^>]+>\s*[^>]+>(?<vin>[^<]+)/i',
//            'transmission'   => '/<li class="specs">\s*[^>]+>\s*Transmission[^>]+>\s*[^>]+>(?<trasmission>[^<]+)/i',   
//             'exterior_color' => '/<li class="specs">\s*[^>]+>\s*Exterior Color[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/i',
//             'interior_color' => '/<li class="specs">\s*[^>]+>\s*Interior Color[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
//             'engine'         => '/ <li class="specs">\s*[^>]+>\s*Engine[^>]+>\s*[^>]+>(?<engine>[^<]+)/',
//           'drivetrain'     => '/<li class="specs">\s*[^>]+>\s*Drive Type[^>]+>\s*[^>]+>(?<drivetrain>[^<]+)/',
//           'body_style'     => '/<li class="specs">\s*[^>]+>\s*Body Style[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
//           'fuel_type'      => '/<li class="specs">\s*[^>]+>\s*Fuel Type[^>]+>\s*[^>]+>(?<fuel_type>[^<]+)/',
//            'year'           => '/id="vehicle_year" value="(?<year>[^"]+)/i',
//            'make'           => '/id="vehicle_make" value="(?<make>[^"]+)/i',
//            'model'          => '/id="vehicle_model" value="(?<model>[^"]+)/i',
//            'price'          => '/id="vehicle_price" value="(?<price>[^"]+)/i',
//            'stock_number'   => '/Stock#<\/span>(?<stock_number>[^<]+)/i',
//            'kilometres'     => '/Mileage:<\/span>(?<kilometres>[^\n]+)/',
//            'description'    => '/<meta property="og:description" content="(?<description>[^"]+)/',
//
//            
//            
//        ];
//
//        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy);
//        return $cars;
//
//    },
//
//   
//);
    'entry_points' => array(
   'new' => 'https://yl5afxm3dw-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=59d32b7b5842f84284e044c7ca465498&x-algolia-application-id=YL5AFXM3DW',
   'used' => 'https://yl5afxm3dw-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=59d32b7b5842f84284e044c7ca465498&x-algolia-application-id=YL5AFXM3DW',
    ),
 'vdp_url_regex'         => '/\/inventory\/(?:used|new|certified-used|certified)-[0-9]{4}-/',
        'use-proxy'         => true,
        'refine'            => false,
        'init_method'       => 'POST',
        'next_method'       => 'POST',
        'picture_selectors' => ['.swiper-slide'],
        'picture_nexts'     => ['.swiper-slide-next'],
        'picture_prevs'     => ['.swiper-slide-prev'],
        'content_type'      => 'application/json',
        'custom_data_capture'   => function($url, $data){
                
        $objects = json_decode($data);

                
        if(!$objects) { slecho($data); return array(); }

                
        $to_return = array();

                
        
 foreach($objects->results[0]->hits as $obj)
        {
            //$obj = $obj->_source;

            $car_data = array(
                'stock_number'      => $obj->stock?$obj->stock:$obj->vin,
                'stock_type'        => $obj->type =='Used'?'used':'new',
                'year'              => $obj->year,
                'make'              => $obj->make,
                'model'             => $obj->model,
                'trim'              => $obj->trim,
                'body_style'        => $obj->body,
                'price'             => $obj->our_price,
                'engine'            => $obj->engine_description,
                'transmission'      => $obj->transmission_description,
                'kilometres'        => $obj->miles,
                'vin'               => $obj->vin,
                'fuel_type'         => $obj->fueltype,
                'drivetrain'        => $obj->drivetrain,
                'msrp'              => $obj->msrp,
                'url'               => $obj->link,
                'exterior_color'    => $obj->ext_color,
                'interior_color'    => $obj->int_color,
                'all_images'        => $obj->thumbnail,
              //  'title'             => $obj->title_vrp,
            );

            

            $to_return[] = $car_data;
        }

        return $to_return;
    },
      'images_regx' => '/swiper-lazy"\s*data-background="(?<img_url>[^"]+)"/'
);

add_filter('filter_frankdunntoyota_post_data', 'filter_frankdunntoyota_post_data', 10, 2);
function filter_frankdunntoyota_post_data($post_data, $stock_type)
{
    if($stock_type == 'new')
    {
        $post_data = '{"requests":[{"indexName":"princealberttoyota_production_inventory","params":"maxValuesPerFacet=250&hitsPerPage=1000&page=0&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22lightning.locations.meta_location%22%2C%22model_code%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3ANew%22%5D%5D"},{"indexName":"princealberttoyota_production_inventory","params":"maxValuesPerFacet=250&hitsPerPage=1000&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
            }
    elseif($stock_type == 'used')
    {
    $post_data = '{"requests":[{"indexName":"princealberttoyota_production_inventory","params":"maxValuesPerFacet=250&hitsPerPage=1000&page=0&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22lightning.locations.meta_location%22%2C%22model_code%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3AUsed%22%2C%22type%3ACertified%20Used%22%5D%5D"},{"indexName":"princealberttoyota_production_inventory","params":"maxValuesPerFacet=250&hitsPerPage=1000&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    }
    return $post_data;
}
