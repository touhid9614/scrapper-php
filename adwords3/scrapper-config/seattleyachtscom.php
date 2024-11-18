<?php
global $scrapper_configs;
 $scrapper_configs["seattleyachtscom"] = array( 
	 'entry_points' => array(
            'used'   => 'https://5g2ejzroxz-3.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20vanilla%20JavaScript%20(lite)%203.27.0%3Binstantsearch.js%202.8.0%3BJS%20Helper%202.26.0&x-algolia-application-id=5G2EJZROXZ&x-algolia-api-key=b9dc372e30aae81540c73d06a3cb94b9',
           // 'new'  =>   'https://sewjn80htn-dsn.algolia.net/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20vanilla%20JavaScript%203.31.0%3BJS%20Helper%202.26.1&x-algolia-application-id=SEWJN80HTN&x-algolia-api-key=179608f32563367799314290254e3e44'
        ),
        'vdp_url_regex'         => '/inventory\/[0-9]{4}-/',
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
                'stock_number'      => $obj->VesselID?$obj->VesselID:$obj->objectID,
                //'stock_type'        => $obj->type,
                'year'              => $obj->ModelYear,
                'make'              => $obj->Builder,
                'model'             => $obj->Model?$obj->Model:$obj->Boatname,
                'trim'              => $obj->MainCategory,
                'body_style'        => $obj->vesselType,
                'price'             => $obj->AskingPriceUSDFormatted,
                'engine'            => $obj->EngineModel,
                'transmission'      => $obj->CruiseSpeedKnots,
                'kilometres'        => $obj->miles,
                'vin'               => $obj->objectID,
                'fuel_type'         => $obj->FuelType,
                'drivetrain'        => $obj->feedSource,
                //'msrp'              => $obj->msrp,
                'url'               => $obj->ycSeoUrl,
                'exterior_color'    => $obj->BeamFeet,
                //'interior_color'    => $obj->int_color,
                'all_images'        => $obj->yPhotoSmall,
               // 'title'             => $obj->title_vrp,
            );

            

            $to_return[] = $car_data;
        }

        return $to_return;
    },
          //    'next_page_regx' => '//',   
         'images_regx' => '/<img class="rsImg" src="(?<img_url>[^"]+)/'
);
add_filter('filter_seattleyachtscom_post_data', 'filter_seattleyachtscom_post_data', 10, 2);

function filter_seattleyachtscom_post_data($post_data, $stock_type)
{
    if($stock_type == 'new')
    {
        $post_data = '{"requests":[{"indexName":"cuttercdjrofpearlcity_production_inventory_specials_oem_price","params":"query=&hitsPerPage=1000&page=0&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22lightning.locations.meta_location%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3ANew%22%5D%5D"},{"indexName":"cuttercdjrofpearlcity_production_inventory_specials_oem_price","params":"query=&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    }
    elseif($stock_type == 'used')
    {
        $post_data = '{"requests":[{"indexName":"allyachts_length_desc","params":"query=&hitsPerPage=5000&maxValuesPerFacet=300&page=0&attributesToRetrieve=%5B%22*%22%5D&facets=%5B%22*%22%2C%22isInventory%22%2C%22calc_FT%22%2C%22AskingPriceUSD%22%2C%22ModelYear%22%2C%22Builder%22%2C%22MainCategory%22%2C%22State%22%2C%22Condition%22%5D&tagFilters="}]}'; }

    return $post_data;
}

