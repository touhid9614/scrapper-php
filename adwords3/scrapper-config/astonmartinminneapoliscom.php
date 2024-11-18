<?php
global $scrapper_configs;
$scrapper_configs["astonmartinminneapoliscom"] = array( 
	  
   /* //https://app.asana.com/0/687248649257779/1179981231236928
    'entry_points' => array(
        'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/MP930.csv'
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['.arrow.single.next'],
    'picture_prevs' => ['.arrow.single.prev'],
    'refine' => false,
    'custom_data_capture' => function($url, $resp) {
        $vehicles = convert_CSV_to_JSON($resp);

        $result = [];

        foreach ($vehicles as $vehicle) {
            $car_data = [
                'stock_number' => $vehicle['Stock #'],
                'vin' => $vehicle['VIN'],
                'year' => $vehicle['Year'],
                'make' => $vehicle['Make'],
                'model' => $vehicle['Model'],
                'trim' => $vehicle['Series'],
                'drivetrain' => $vehicle['Drivetrain Desc'],
                'fuel_type' => $vehicle['Fuel'],
                'transmission' => $vehicle['Transmission'],
                'body_style' => $vehicle['Body'],
                'images' => explode('|', $vehicle['Photo Url List']),
                'all_images' => $vehicle['Photo Url List'],
                'price' => $vehicle['Price'] > 0 ? $vehicle['Price'] : $vehicle['MSRP'],
                'url' => $vehicle['Vehicle Detail Link'],
                'stock_type' => $vehicle['New/Used'] == 'N' ? "new" : 'used',
                'exterior_color' => $vehicle['Colour'],
                'interior_color' => $vehicle['Interior Color'],
                'engine' => $vehicle['Engine'],
                'description' => strip_tags($vehicle['Description']),
                'kilometres' => $vehicle['Odometer'],
            ];

  $images = [];
             $images = explode('|', $car_data['all_images']);
             if(count($images)<3)
                 {
                  //  slecho("total images:" . $car_data['all_images']);
                     $car_data['all_images']='';
                 }
     
            $result[] = $car_data;
        }

        return $result;
    }
    
    */
    
    'entry_points' => array(
          'used'   => 'https://sewjn80htn-3.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.6.0)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.2.2)&x-algolia-api-key=179608f32563367799314290254e3e44&x-algolia-application-id=SEWJN80HTN',
            'new'  =>   'https://sewjn80htn-2.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.6.0)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.2.2)&x-algolia-api-key=179608f32563367799314290254e3e44&x-algolia-application-id=SEWJN80HTN'
        ),
        'vdp_url_regex'         => '/\/inventory\/(?:new|used|certified)-[0-9]{4}-/',
        'use-proxy'         => true,
        'refine'            => false,
        'init_method'       => 'POST',
        'next_method'       => 'POST',
        'picture_selectors' => ['.carousel-indicators li'],
        'picture_nexts'     => [],
        'picture_prevs'     => [],
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
                // 'stock_type'        => $obj->type,
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
                'title'             => $obj->title_vrp,
            );
             if(strpos($car_data['url'],"certified")){
                $car_data['stock_type']="certified";
            }
            
            

            $to_return[] = $car_data;
        }

        return $to_return;
    },
            
     'images_regx'   => '/<div class="swiper-slide">\s*<img data-src="(?<img_url>[^"]+)/',
);
    
    add_filter('filter_astonmartinminneapoliscom_post_data', 'filter_astonmartinminneapoliscom_post_data', 10, 2);
add_filter("filter_astonmartinminneapoliscom_field_images", "filter_astonmartinminneapoliscom_field_images");
 function filter_astonmartinminneapoliscom_field_images($im_urls)
    {
     //https://app.asana.com/0/687248649257779/1178987395500170
        $im_urls=array_unique($im_urls);
        if(count($im_urls)>3)
        {
            return $im_urls;
            
        }
        else{
            return null;
        }
        
    }

function filter_astonmartinminneapoliscom_post_data($post_data, $stock_type)
{
    if($stock_type == 'new')
    {
    $post_data = '{"requests":[{"indexName":"astonmartinminneapolis_production_inventory_specials_oem_price","params":"maxValuesPerFacet=250&hitsPerPage=20&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22lightning.locations.meta_location%22%2C%22cpo_page%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3ANew%22%5D%5D"},{"indexName":"astonmartinminneapolis_production_inventory_specials_oem_price","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
            
    }
    elseif($stock_type == 'used')
    {
        $post_data = '{"requests":[{"indexName":"astonmartinminneapolis_production_inventory_specials_oem_price","params":"maxValuesPerFacet=250&hitsPerPage=60&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22lightning.locations.meta_location%22%2C%22cpo_page%22%2C%22title_vrp%22%2C%22ext_color%22%2C%22int_color%22%2C%22certified%22%2C%22lightning%22%2C%22location%22%2C%22drivetrain%22%2C%22int_options%22%2C%22ext_options%22%2C%22cylinders%22%2C%22vin%22%2C%22stock%22%2C%22msrp%22%2C%22our_price_label%22%2C%22finance_details%22%2C%22lease_details%22%2C%22thumbnail%22%2C%22link%22%2C%22objectID%22%2C%22algolia_sort_order%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3AUsed%22%2C%22type%3ACertified%20Used%22%5D%5D"},{"indexName":"astonmartinminneapolis_production_inventory_specials_oem_price","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    }

    return $post_data;
}

