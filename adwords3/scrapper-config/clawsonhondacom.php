<?php
global $scrapper_configs;
$scrapper_configs["clawsonhondacom"] = array( 
	 'entry_points' => array(
              'used'  => 'https://kh283dnhyf-3.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.4.0)%3B%20Browser%20(lite)&x-algolia-api-key=fea66231fa39a1c8326ac94f0252a75c&x-algolia-application-id=KH283DNHYF',
        'new'   => 'https://kh283dnhyf-1.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.4.0)%3B%20Browser%20(lite)&x-algolia-api-key=fea66231fa39a1c8326ac94f0252a75c&x-algolia-application-id=KH283DNHYF',
          ),
        'vdp_url_regex'         => '/\/search\/(?:used|new|certified-used|certified)\/[^\/]+\//',
        'srp_page_regex'      => '/\/search\/\?(?:used|new)/',
        'use-proxy'         => true,
        'refine'            => false,
        'init_method'       => 'POST',
        'next_method'       => 'POST',
        'picture_selectors' => ['.owl-item'],
        'picture_nexts'     => ['.owl-next'],
        'picture_prevs'     => ['owl-prev'],
        'content_type'      => 'application/json',
        'custom_data_capture'   => function($url, $data){
                
        $objects = json_decode($data);

                
        if(!$objects) { slecho($data); return array(); }

                
        $to_return = array();

                
        
 foreach($objects->results[0]->hits as $obj)
        {
           

            $car_data = array(
                'stock_number'      => $obj->stock_number,
                'stock_type'        => $obj->new =='true'?'new':'used',
                'year'              => $obj->year,
                'make'              => $obj->make,
                'model'             => $obj->model,
                'trim'              => $obj->trim,
                'body_style'        => $obj->body,
                'price'             => $obj->price,
                'engine'            => $obj->engine,
                'transmission'      => $obj->transmission_description,
                'kilometres'        => $obj->miles,
                'vin'               => $obj->vin,
                'fuel_type'         => $obj->fuel,
                'drivetrain'        => $obj->drivetrain_description,
                //'msrp'              => $obj->msrp,
               'url'            => "https://www.clawsonhonda.com/search/".strtolower($obj->new =='true'?'new':'used')."/".$obj->vin,
                'exterior_color'    => $obj->color,
                'interior_color'    => $obj->colour,
                'all_images'        => $obj->photos,
              
            );

            

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx' => '/<div class="vehicle-image-bg swiper-lazy" data-background="(?<img_url>[^"]+)/'
);

add_filter('filter_clawsonhondacom_post_data', 'filter_clawsonhondacom_post_data', 10, 2);

function filter_clawsonhondacom_post_data($post_data, $stock_type)
{
    if($stock_type == 'new')
    {
        $post_data = '{"requests":[{"indexName":"clawson_search_production","params":"hitsPerPage=1000&maxValuesPerFacet=50&query=&page=0&facets=%5B%22price%22%2C%22year%22%2C%22mileage%22%2C%22highway_mpg%22%2C%22city_mpg%22%2C%22new%22%2C%22certified%22%2C%22make%22%2C%22model%22%2C%22trim%22%2C%22body%22%2C%22fuel%22%2C%22feature_list%22%2C%22drivetrain_description%22%2C%22cylinders%22%2C%22door_count%22%2C%22transmission%22%2C%22engine%22%2C%22color%22%5D&tagFilters=&facetFilters=%5B%5B%22new%3Atrue%22%5D%5D"},{"indexName":"clawson_search_production","params":"hitsPerPage=1000&maxValuesPerFacet=50&query=&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=%5B%22new%22%5D"}]}';
    }
    elseif($stock_type == 'used')
    {
        $post_data = '{"requests":[{"indexName":"clawson_search_production","params":"query=&page=0&highlightPreTag=__ais-highlight__&highlightPostTag=__%2Fais-highlight__&hitsPerPage=1000&maxValuesPerFacet=50&facets=%5B%22price%22%2C%22year%22%2C%22mileage%22%2C%22highway_mpg%22%2C%22city_mpg%22%2C%22new%22%2C%22make%22%2C%22model%22%2C%22trim%22%2C%22body%22%2C%22fuel%22%2C%22drivetrain_description%22%2C%22cylinders%22%2C%22door_count%22%2C%22transmission%22%2C%22engine%22%2C%22color%22%2C%22certified%22%2C%22feature_list%22%5D&tagFilters=&facetFilters=%5B%5B%22new%3Afalse%22%5D%5D"},{"indexName":"clawson_search_production","params":"query=&page=0&highlightPreTag=__ais-highlight__&highlightPostTag=__%2Fais-highlight__&hitsPerPage=1000&maxValuesPerFacet=50&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=%5B%22new%22%5D"}]}';
    }

    return $post_data;
}