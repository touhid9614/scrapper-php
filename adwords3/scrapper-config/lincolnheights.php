<?php

    global $scrapper_configs;

    $scrapper_configs['lincolnheights'] = array(
        'entry_points' => array(
            'new'   => 'http://www.lincolnheights.com/queryInventory',
            'used'  => 'http://www.lincolnheights.com/queryInventory'
        ),
        'vdp_url_regex'         => '/\/(?:new|pre-owned)\/(?:[a-z0-9\-\s]*)\/(?:[a-z0-9\-\s]*)\/[0-9]{4}-.*.html/',
        'ajax_url_match'        => '/libs/formProcessor.html',
        'use-proxy'         => true,
        'refine'            => false,
        'next_method'       => 'POST',
        'picture_selectors' => ['.carousel-indicators li'],
        'picture_nexts'     => [],
        'picture_prevs'     => [],
        'content_type'      => 'application/json',
        'custom_data_capture'   => function($url, $data){
                
        $objects = json_decode($data);

                
        if(!$objects) { slecho($data); return array(); }

                
        $to_return = array();

                
        foreach($objects->hits->hits as $obj)
        {
            $obj = $obj->_source;

            $car_data = array(
                'stock_number'      => $obj->dealer->stock?$obj->dealer->stock:$obj->_id,
                'stock_type'        => (strtolower($obj->filters->condition)==='pre-owned')?'used':'',
                'year'              => $obj->year,
                'make'              => $obj->make,
                'model'             => $obj->model,
                'trim'              => $obj->source->feed->trim,
                'body_style'        => $obj->source->feed->bodyStyle,
                'price'             => $obj->price->minPrice - $obj->source->feed->attributes->{'Incentive Cadeliveryallowance'},
                'engine'            => $obj->filters->engine,
                'transmission'      => $obj->source->feed->transmissionType,
                'kilometres'        => $obj->mileage,
                'url'               => "http://www.lincolnheights.com/" . strtolower($obj->filters->condition) .
                                       '/' . strtolower($obj->make) . '/' . strtolower($obj->model) .
                                       '/' . strtolower($obj->year) . '-' . strtolower($obj->filters->exteriorColor) .
                                       '-' . strtolower($obj->filters->trim) . '-' . strtolower($obj->_id) . '.html',
                'exterior_color'    => $obj->color->exteriorColor,
                'interior_color'    => $obj->color->interiorColor,
                'options'           => isset($obj->source->feed->attributes->Options)?$obj->source->feed->attributes->Options:array(),
               // 'images'            => array_merge($obj->source->feed->images->uploaded, $obj->source->feed->images->managed, $obj->source->feed->images->managed_feed_image)
            );

            $temp_data = HttpGet($car_data['url']);

            $price_regex    = '/Dealer Price:<\/span><span class=\'fee-value\'>(?<price>[$0-9,]+)/';
            $images_regex   = '/<meta itemprop="image" content="(?<img_url>[^"]+)/';

            $matches = array();

            if(preg_match($price_regex, $temp_data, $matches)) {
                $car_data['price'] = $matches['price'];
            }
            
            if(preg_match_all($images_regex, $temp_data, $matches))
            {
                $car_data['images']     = $matches['img_url'];
                if(!empty($car_data['stock_type'])&&$car_data['stock_type']=='new')
                {
                    array_shift($car_data['images']);
                }
                
                foreach($car_data['images'] as $key => $val)
                {
                    $car_data['images'][$key] = str_replace('|', '%7C', $val);
                }
                $car_data['all_images'] = implode('|', $car_data['images']);
                
            }

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    //'images_regx' => '/<meta itemprop="image" content="(?<img_url>[^"]+)/'
);

add_filter('filter_for_fb_lincolnheights', 'filter_for_fb_lincolnheights');
add_filter('filter_lincolnheights_post_data', 'filter_lincolnheights_post_data', 10, 2);

function filter_lincolnheights_post_data($post_data, $stock_type)
{
    if($stock_type == 'new')
    {
        $post_data = '{"size":1000,"from":0,"query":{"filtered":{"filter":{"bool":{"must":[{"not":{"term":{"administration.isSold":"1"}}},{"bool":{"should":[{"bool":{"must":[{"term":{"dealer.export_id.lower":"new_a1090"}},{"term":{"dealer.dealership_feed_id.lower":"4241"}},{"term":{"filters.condition.lower":"new"}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"certified_a1090"}},{"term":{"dealer.dealership_feed_id.lower":"4243"}},{"term":{"filters.condition.lower":"certified"}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"1135"}},{"term":{"dealer.dealership_feed_id.lower":"6552"}},{"term":{"filters.condition.lower":"pre-owned"}}]}}]}},{"bool":{"should":[{"bool":{"must":[{"term":{"filters.condition.lower":"new"}},{"term":{"filters.make.lower":"ford"}}]}},{"bool":{"must":[{"term":{"filters.condition.lower":"pre-owned"}}]}},{"bool":{"must":[{"term":{"filters.condition.lower":"certified"}}]}}]}},{"bool":{"should":[{"term":{"filters.condition.lower":"new"}}]}}]}},"query":{"bool":{"should":[{"match_all":{}},{"boosting":{"positive":{"range":{"maxPrice":{"gte":1}}},"negative":{"range":{"maxPrice":{"lt":1}}},"negative_boost":0.5}}]}}}},"aggregations":{"colors":{"terms":{"field":"filters.exteriorColor.lower","include":".+","size":0,"order":{"_term":"asc"}}},"makes":{"terms":{"field":"filters.make.lower","include":".+","size":0,"order":{"_term":"asc"}}},"models":{"terms":{"field":"filters.model.lower","include":".+","size":0,"order":{"_term":"asc"}},"aggregations":{"rawModel":{"terms":{"field":"filters.model","include":".+","size":0,"order":{"_term":"asc"}}},"byTrim":{"terms":{"field":"filters.trim.lower","include":".+","size":0,"order":{"_term":"asc"}},"aggregations":{"rawTrim":{"terms":{"field":"filters.trim","include":".+","size":0,"order":{"_term":"asc"}}}}},"byMake":{"terms":{"field":"filters.make.lower","include":".+","size":0,"order":{"_term":"asc"}}}}},"bodyStyles":{"terms":{"field":"filters.bodyStyle.lower","include":".+","size":0,"order":{"_term":"asc"}},"aggregations":{"SubbodyStyles":{"terms":{"field":"filters.sub_bodystyle.lower","include":".+","size":0,"order":{"_term":"asc"}}}}},"minPrice":{"min":{"field":"filters.price.minPrice"}},"maxPrice":{"max":{"field":"filters.price.maxPrice"}},"priceBreakdown":{"filter":{"bool":{"must":[{"not":{"term":{"filters.price.maxPrice":0}}}]}},"aggregations":{"breakdown":{"histogram":{"field":"filters.price.maxPrice","interval":5000}}}},"mileageBreakdown":{"histogram":{"field":"filters.mileage","interval":15000}},"minYear":{"min":{"field":"filters.year"}},"maxYear":{"max":{"field":"filters.year"}},"years":{"terms":{"field":"filters.year","size":0,"order":{"_term":"desc"}}},"conditions":{"terms":{"field":"filters.condition.lower"}},"maxMileage":{"max":{"field":"filters.mileage"}},"retailers":{"terms":{"field":"filters.dealer_map_key.lower","include":".+","size":0}},"transmissions":{"terms":{"field":"filters.transmissionType.lower","include":".+","size":0,"order":{"_term":"asc"}}},"engines":{"terms":{"field":"filters.engine.lower","include":".+","size":0,"order":{"_term":"asc"}}},"packages":{"terms":{"field":"filters.packages.lower","size":0,"order":{"_term":"asc"}}},"Custom Field 1":{"terms":{"field":"filters.Custom Field 1.lower"}},"Custom Field 2":{"terms":{"field":"filters.Custom Field 2.lower"}},"Custom Field 3":{"terms":{"field":"filters.Custom Field 3.lower"}},"Custom Field 4":{"terms":{"field":"filters.Custom Field 4.lower"}},"Custom Field 5":{"terms":{"field":"filters.Custom Field 5.lower"}},"Custom Field 6":{"terms":{"field":"filters.Custom Field 6.lower"}},"Custom Field 7":{"terms":{"field":"filters.Custom Field 7.lower"}},"Custom Field 8":{"terms":{"field":"filters.Custom Field 8.lower"}},"Custom Field 9":{"terms":{"field":"filters.Custom Field 9.lower"}},"Custom Field 10":{"terms":{"field":"filters.Custom Field 10.lower"}}},"sort":["_score",{"maxPrice":{"order":"asc"}}]}';
    }
    elseif($stock_type == 'used')
    {
        $post_data = '{"size":1000,"from":0,"query":{"filtered":{"filter":{"bool":{"must":[{"not":{"term":{"administration.isSold":"1"}}},{"bool":{"should":[{"bool":{"must":[{"term":{"dealer.export_id.lower":"1135"}},{"term":{"dealer.dealership_feed_id.lower":"6552"}},{"term":{"filters.condition.lower":"pre-owned"}}]}}]}},{"bool":{"should":[{"term":{"filters.condition.lower":"certified"}},{"term":{"filters.condition.lower":"pre-owned"}}]}}]}},"query":{"bool":{"should":[{"match_all":{}},{"boosting":{"positive":{"range":{"maxPrice":{"gte":1}}},"negative":{"range":{"maxPrice":{"lt":1}}},"negative_boost":0.5}}]}}}},"aggregations":{"colors":{"terms":{"field":"filters.exteriorColor.lower","include":".+","size":0,"order":{"_term":"asc"}}},"makes":{"terms":{"field":"filters.make.lower","include":".+","size":0,"order":{"_term":"asc"}}},"models":{"terms":{"field":"filters.model.lower","include":".+","size":0,"order":{"_term":"asc"}},"aggregations":{"rawModel":{"terms":{"field":"filters.model","include":".+","size":0,"order":{"_term":"asc"}}},"byTrim":{"terms":{"field":"filters.trim.lower","include":".+","size":0,"order":{"_term":"asc"}},"aggregations":{"rawTrim":{"terms":{"field":"filters.trim","include":".+","size":0,"order":{"_term":"asc"}}}}},"byMake":{"terms":{"field":"filters.make.lower","include":".+","size":0,"order":{"_term":"asc"}}}}},"bodyStyles":{"terms":{"field":"filters.bodyStyle.lower","include":".+","size":0,"order":{"_term":"asc"}},"aggregations":{"SubbodyStyles":{"terms":{"field":"filters.sub_bodystyle.lower","include":".+","size":0,"order":{"_term":"asc"}}}}},"minPrice":{"min":{"field":"filters.price.minPrice"}},"maxPrice":{"max":{"field":"filters.price.maxPrice"}},"priceBreakdown":{"filter":{"bool":{"must":[{"not":{"term":{"filters.price.maxPrice":0}}}]}},"aggregations":{"breakdown":{"histogram":{"field":"filters.price.maxPrice","interval":5000}}}},"mileageBreakdown":{"histogram":{"field":"filters.mileage","interval":15000}},"minYear":{"min":{"field":"filters.year"}},"maxYear":{"max":{"field":"filters.year"}},"years":{"terms":{"field":"filters.year","size":0,"order":{"_term":"desc"}}},"conditions":{"terms":{"field":"filters.condition.lower"}},"maxMileage":{"max":{"field":"filters.mileage"}},"retailers":{"terms":{"field":"filters.dealer_map_key.lower","include":".+","size":0}},"transmissions":{"terms":{"field":"filters.transmissionType.lower","include":".+","size":0,"order":{"_term":"asc"}}},"engines":{"terms":{"field":"filters.engine.lower","include":".+","size":0,"order":{"_term":"asc"}}},"packages":{"terms":{"field":"filters.packages.lower","size":0,"order":{"_term":"asc"}}},"Custom Field 1":{"terms":{"field":"filters.Custom Field 1.lower"}},"Custom Field 2":{"terms":{"field":"filters.Custom Field 2.lower"}},"Custom Field 3":{"terms":{"field":"filters.Custom Field 3.lower"}},"Custom Field 4":{"terms":{"field":"filters.Custom Field 4.lower"}},"Custom Field 5":{"terms":{"field":"filters.Custom Field 5.lower"}},"Custom Field 6":{"terms":{"field":"filters.Custom Field 6.lower"}},"Custom Field 7":{"terms":{"field":"filters.Custom Field 7.lower"}},"Custom Field 8":{"terms":{"field":"filters.Custom Field 8.lower"}},"Custom Field 9":{"terms":{"field":"filters.Custom Field 9.lower"}},"Custom Field 10":{"terms":{"field":"filters.Custom Field 10.lower"}}},"sort":["_score",{"maxPrice":{"order":"asc"}}]}';
    }

    return $post_data;
}

function filter_for_fb_lincolnheights($car) {
    $regex = '/[0-9]{7}/';
    if(preg_match($regex, $car['stock_number'])) { return null; }
    return $car;
}