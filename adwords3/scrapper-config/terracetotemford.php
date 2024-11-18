<?php

global $scrapper_configs;

$scrapper_configs['terracetotemford'] = array(
    'entry_points' => array(
        'new' => 'https://www.terracetotemford.ca/queryInventory',
        'used' => 'https://www.terracetotemford.ca/queryInventory'
    ),
    'vdp_url_regex' => '/\/(?:new|pre-owned|used)\/[^\/]+\/[^\/]+\/[0-9]{4}-/',
//        'ajax_url_match'        => '/libs/formProcessor.html',
    'use-proxy' => false,
    'init_method' => 'POST',
    'next_method' => 'POST',
    'content_type' => 'application/json',
    'picture_selectors' => ['.lSPager.lSGallery  li img'],
    'picture_nexts' => ['.next'],
    'picture_prevs' => ['.prev'],
    'custom_data_capture' => function($url, $data) {

        $objects = json_decode($data);

        if (!$objects) {
            slecho($data);
            return array();
        }

        $to_return = array();

        foreach ($objects->hits->hits as $obj) {
            $obj = $obj->_source;

            $w_regex = '/(?<weekly>\$[0-9,.]+)/';
            $weekly = 0;

            $match = array();

            if (preg_match($w_regex, $obj->source->feed->trim, $match)) {
                $weekly = numarifyPrice($match['weekly']);
            }

            $car_data = array(
                'stock_number' => $obj->dealer->stock ? $obj->dealer->stock : $obj->_id,
                'year' => $obj->year,
                'vin' => $obj->vin,
                'make' => $obj->make,
                'model' => $obj->model,
                'trim' => $obj->source->feed->trim,
                'body_style' => $obj->source->feed->bodyStyle,
                'price' => ($obj->price->minPrice - $obj->feed->attributes->{'Incentive Cadeliveryallowance'})==0?"Please call":($obj->price->minPrice - $obj->feed->attributes->{'Incentive Cadeliveryallowance'}),
                'weekly' => $weekly,
                'biweekly' => $weekly * 2,
                'engine' => $obj->filters->engine,
                'transmission' => $obj->source->feed->transmissionType,
                'kilometres' => $obj->mileage,
                'url' => "http://terracetotemford.ca/" . strtolower($obj->filters->condition) .
                '/' . strtolower($obj->make) . '/' . strtolower($obj->model) .
                '/' . strtolower($obj->year) . '-' . strtolower($obj->filters->exteriorColor) .
                '-' . strtolower($obj->filters->trim) . '-' . strtolower($obj->_id) . '.html',
                'exterior_color' => $obj->color->exteriorColor=="  "?"other":$obj->color->exteriorColor,
                'interior_color' => $obj->color->interiorColor,
                'options' => isset($obj->source->feed->attributes->Options) ? $obj->source->feed->attributes->Options : array(),
                //   'images'            => array_merge($obj->source->feed->images->uploaded, $obj->source->feed->images->managed, $obj->source->feed->images->managed_feed_image)
                'images' => terracetotemford_image_pipe_filters(
                        array_merge($obj->source->feed->images->uploaded, $obj->source->feed->images->managed, $obj->source->feed->images->managed_feed_image)
                )
            );

            if (count($car_data['images']) < 3) {
                $car_data['images'] = array();
            }

            foreach ($car_data['images'] as $key => $val) {
                $car_data['images'][$key] = str_replace('|', '%7C', $val);

                if (preg_match("/Array/", $val)) {
                    $car_data['images'] = null;
                }
            }
            $car_data['all_images'] = implode('|', $car_data['images']);

            $to_return[] = $car_data;
        }

        return $to_return;
    }
);

add_filter('filter_terracetotemford_post_data', 'filter_terracetotemford_post_data', 10, 2);

function filter_terracetotemford_post_data($post_data, $stock_type) {
    if ($stock_type == 'new') {
        $post_data = '{"size":1000,"from":0,"query":{"filtered":{"filter":{"bool":{"must":[{"not":{"term":{"administration.isSold":"1"}}},{"not":{"term":{"administration.isHideFromSite":"1"}}},{"bool":{"should":[{"bool":{"must":[{"term":{"dealer.export_id.lower":"new_b7398"}},{"term":{"dealer.dealership_feed_id.lower":"5417"}},{"term":{"filters.condition.lower":"new"}},{"bool":{"should":[{"range":{"filters.price.msrp":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyMsrp":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"used_b7398"}},{"term":{"dealer.dealership_feed_id.lower":"5418"}},{"term":{"filters.condition.lower":"pre-owned"}},{"bool":{"should":[{"range":{"filters.price.price":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyPrice":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"certified_b7398"}},{"term":{"dealer.dealership_feed_id.lower":"5419"}},{"term":{"filters.condition.lower":"certified"}},{"bool":{"should":[{"range":{"filters.price.price":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyPrice":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"new_b7199"}},{"term":{"dealer.dealership_feed_id.lower":"5321"}},{"term":{"filters.condition.lower":"new"}},{"bool":{"should":[{"range":{"filters.price.msrp":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyMsrp":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"new_under_51k"}},{"term":{"dealer.dealership_feed_id.lower":"6730"}},{"term":{"filters.condition.lower":"new"}},{"bool":{"should":[{"range":{"filters.price.msrp":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyMsrp":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"used_b7199"}},{"term":{"dealer.dealership_feed_id.lower":"5322"}},{"term":{"filters.condition.lower":"pre-owned"}},{"bool":{"should":[{"range":{"filters.price.price":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyPrice":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"certified_b7199"}},{"term":{"dealer.dealership_feed_id.lower":"5323"}},{"term":{"filters.condition.lower":"certified"}},{"bool":{"should":[{"range":{"filters.price.price":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyPrice":{"gte":0}}}]}}]}}]}},{"bool":{"should":[{"bool":{"must":[{"term":{"filters.condition.lower":"new"}},{"term":{"filters.make.lower":"ford"}}]}},{"bool":{"must":[{"term":{"filters.condition.lower":"pre-owned"}}]}},{"bool":{"must":[{"term":{"filters.condition.lower":"certified"}}]}}]}},{"bool":{"should":[{"term":{"filters.condition.lower":"new"}}]}}]}},"query":{"bool":{"should":[{"match_all":{}},{"boosting":{"positive":{"range":{"msrp":{"gte":1}}},"negative":{"range":{"msrp":{"lt":1}}},"negative_boost":0.5}}]}}}},"aggregations":{"colors":{"terms":{"field":"filters.exteriorColor.lower","size":0,"order":{"_term":"asc"}}},"doors":{"terms":{"field":"filters.doors.lower","size":0,"order":{"_term":"asc"}}},"fuelType":{"terms":{"field":"filters.fuel_type.lower","size":0,"order":{"_term":"asc"}}},"makes":{"terms":{"field":"filters.make.lower","size":0,"order":{"_term":"asc"}}},"models":{"terms":{"field":"filters.model.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"rawModel":{"terms":{"field":"filters.model","size":0,"order":{"_term":"asc"}}},"byTrim":{"terms":{"field":"filters.trim.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"rawTrim":{"terms":{"field":"filters.trim","size":0,"order":{"_term":"asc"}}}}},"byMake":{"terms":{"field":"filters.make.lower","size":0,"order":{"_term":"asc"}}}}},"bodyStyles":{"terms":{"field":"filters.bodyStyle.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"SubbodyStyles":{"terms":{"field":"filters.sub_bodystyle.lower","size":0,"order":{"_term":"asc"}}}}},"minPrice":{"min":{"field":"filters.price.minPrice"}},"maxPrice":{"max":{"field":"filters.price.maxPrice"}},"monthlyMinPrice":{"min":{"field":"filters.price.monthlyMinPrice"}},"monthlyMaxPrice":{"max":{"field":"filters.price.monthlyMaxPrice"}},"priceBreakdown":{"filter":{"bool":{"must":[{"not":{"term":{"filters.price.maxPrice":0}}}]}},"aggregations":{"breakdown":{"histogram":{"field":"filters.price.maxPrice","interval":5000}}}},"monthlyPriceBreakdown":{"filter":{"bool":{"must":[{"not":{"term":{"filters.price.monthlyMaxPrice":0}}}]}},"aggregations":{"breakdown":{"histogram":{"field":"filters.price.monthlyMaxPrice","interval":100}}}},"mileageBreakdown":{"histogram":{"field":"filters.mileage","interval":15000}},"registrationBreakdown":{"date_histogram":{"field":"date.registrationDate","interval":"year","format":"yyyy","offset":"+218d"}},"minYear":{"min":{"field":"filters.year"}},"maxYear":{"max":{"field":"filters.year"}},"years":{"terms":{"field":"filters.year","size":0,"order":{"_term":"desc"}}},"conditions":{"terms":{"field":"filters.condition.lower"}},"maxMileage":{"max":{"field":"filters.mileage"}},"retailers":{"terms":{"field":"filters.dealer_map_key.lower","size":0}},"transmissions":{"terms":{"field":"filters.transmissionType.lower","size":0,"order":{"_term":"asc"}}},"engines":{"terms":{"field":"filters.engine.lower","size":0,"order":{"_term":"asc"}}},"packages":{"terms":{"field":"filters.packages.lower","size":0,"order":{"_term":"asc"}}},"Custom Field 1":{"terms":{"field":"filters.Custom Field 1.lower","size":0}},"Custom Field 2":{"terms":{"field":"filters.Custom Field 2.lower","size":0}},"Custom Field 3":{"terms":{"field":"filters.Custom Field 3.lower","size":0}},"Custom Field 4":{"terms":{"field":"filters.Custom Field 4.lower","size":0}},"Custom Field 5":{"terms":{"field":"filters.Custom Field 5.lower","size":0}},"Custom Field 6":{"terms":{"field":"filters.Custom Field 6.lower","size":0}},"Custom Field 7":{"terms":{"field":"filters.Custom Field 7.lower","size":0}},"Custom Field 8":{"terms":{"field":"filters.Custom Field 8.lower","size":0}},"Custom Field 9":{"terms":{"field":"filters.Custom Field 9.lower","size":0}},"Custom Field 10":{"terms":{"field":"filters.Custom Field 10.lower","size":0}}},"sort":["_score",{"msrp":{"order":"asc"}}]}';
    } elseif ($stock_type == 'used') {
        $post_data = '{"size":1000,"from":0,"query":{"filtered":{"filter":{"bool":{"must":[{"not":{"term":{"administration.isSold":"1"}}},{"not":{"term":{"administration.isHideFromSite":"1"}}},{"bool":{"should":[{"bool":{"must":[{"term":{"dealer.export_id.lower":"new_b7398"}},{"term":{"dealer.dealership_feed_id.lower":"5417"}},{"term":{"filters.condition.lower":"new"}},{"bool":{"should":[{"range":{"filters.price.msrp":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyMsrp":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"used_b7398"}},{"term":{"dealer.dealership_feed_id.lower":"5418"}},{"term":{"filters.condition.lower":"pre-owned"}},{"bool":{"should":[{"range":{"filters.price.price":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyPrice":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"certified_b7398"}},{"term":{"dealer.dealership_feed_id.lower":"5419"}},{"term":{"filters.condition.lower":"certified"}},{"bool":{"should":[{"range":{"filters.price.price":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyPrice":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"new_b7199"}},{"term":{"dealer.dealership_feed_id.lower":"5321"}},{"term":{"filters.condition.lower":"new"}},{"bool":{"should":[{"range":{"filters.price.msrp":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyMsrp":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"new_under_51k"}},{"term":{"dealer.dealership_feed_id.lower":"6730"}},{"term":{"filters.condition.lower":"new"}},{"bool":{"should":[{"range":{"filters.price.msrp":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyMsrp":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"used_b7199"}},{"term":{"dealer.dealership_feed_id.lower":"5322"}},{"term":{"filters.condition.lower":"pre-owned"}},{"bool":{"should":[{"range":{"filters.price.price":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyPrice":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"certified_b7199"}},{"term":{"dealer.dealership_feed_id.lower":"5323"}},{"term":{"filters.condition.lower":"certified"}},{"bool":{"should":[{"range":{"filters.price.price":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyPrice":{"gte":0}}}]}}]}}]}},{"bool":{"should":[{"term":{"filters.condition.lower":"certified"}},{"term":{"filters.condition.lower":"pre-owned"}}]}}]}},"query":{"bool":{"should":[{"match_all":{}},{"boosting":{"positive":{"range":{"price":{"gte":1}}},"negative":{"range":{"price":{"lt":1}}},"negative_boost":0.5}}]}}}},"aggregations":{"colors":{"terms":{"field":"filters.exteriorColor.lower","size":0,"order":{"_term":"asc"}}},"doors":{"terms":{"field":"filters.doors.lower","size":0,"order":{"_term":"asc"}}},"fuelType":{"terms":{"field":"filters.fuel_type.lower","size":0,"order":{"_term":"asc"}}},"makes":{"terms":{"field":"filters.make.lower","size":0,"order":{"_term":"asc"}}},"models":{"terms":{"field":"filters.model.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"rawModel":{"terms":{"field":"filters.model","size":0,"order":{"_term":"asc"}}},"byTrim":{"terms":{"field":"filters.trim.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"rawTrim":{"terms":{"field":"filters.trim","size":0,"order":{"_term":"asc"}}}}},"byMake":{"terms":{"field":"filters.make.lower","size":0,"order":{"_term":"asc"}}}}},"bodyStyles":{"terms":{"field":"filters.bodyStyle.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"SubbodyStyles":{"terms":{"field":"filters.sub_bodystyle.lower","size":0,"order":{"_term":"asc"}}}}},"minPrice":{"min":{"field":"filters.price.minPrice"}},"maxPrice":{"max":{"field":"filters.price.maxPrice"}},"monthlyMinPrice":{"min":{"field":"filters.price.monthlyMinPrice"}},"monthlyMaxPrice":{"max":{"field":"filters.price.monthlyMaxPrice"}},"priceBreakdown":{"filter":{"bool":{"must":[{"not":{"term":{"filters.price.maxPrice":0}}}]}},"aggregations":{"breakdown":{"histogram":{"field":"filters.price.maxPrice","interval":5000}}}},"monthlyPriceBreakdown":{"filter":{"bool":{"must":[{"not":{"term":{"filters.price.monthlyMaxPrice":0}}}]}},"aggregations":{"breakdown":{"histogram":{"field":"filters.price.monthlyMaxPrice","interval":100}}}},"mileageBreakdown":{"histogram":{"field":"filters.mileage","interval":15000}},"registrationBreakdown":{"date_histogram":{"field":"date.registrationDate","interval":"year","format":"yyyy","offset":"+69d"}},"minYear":{"min":{"field":"filters.year"}},"maxYear":{"max":{"field":"filters.year"}},"years":{"terms":{"field":"filters.year","size":0,"order":{"_term":"desc"}}},"conditions":{"terms":{"field":"filters.condition.lower"}},"maxMileage":{"max":{"field":"filters.mileage"}},"retailers":{"terms":{"field":"filters.dealer_map_key.lower","size":0}},"transmissions":{"terms":{"field":"filters.transmissionType.lower","size":0,"order":{"_term":"asc"}}},"engines":{"terms":{"field":"filters.engine.lower","size":0,"order":{"_term":"asc"}}},"packages":{"terms":{"field":"filters.packages.lower","size":0,"order":{"_term":"asc"}}},"Custom Field 1":{"terms":{"field":"filters.Custom Field 1.lower","size":0}},"Custom Field 2":{"terms":{"field":"filters.Custom Field 2.lower","size":0}},"Custom Field 3":{"terms":{"field":"filters.Custom Field 3.lower","size":0}},"Custom Field 4":{"terms":{"field":"filters.Custom Field 4.lower","size":0}},"Custom Field 5":{"terms":{"field":"filters.Custom Field 5.lower","size":0}},"Custom Field 6":{"terms":{"field":"filters.Custom Field 6.lower","size":0}},"Custom Field 7":{"terms":{"field":"filters.Custom Field 7.lower","size":0}},"Custom Field 8":{"terms":{"field":"filters.Custom Field 8.lower","size":0}},"Custom Field 9":{"terms":{"field":"filters.Custom Field 9.lower","size":0}},"Custom Field 10":{"terms":{"field":"filters.Custom Field 10.lower","size":0}}},"sort":["_score",{"price":{"order":"asc"}}]}';
    }
    return $post_data;
}

function terracetotemford_image_pipe_filters($im_urls) {
    $retval = array();

    foreach ($im_urls as $url) {
        $retval[] = str_replace(["|", "https://imgcdn0.searchoptics.com/s/crop_px/0,0,640,480-640/"], ["%7C", " "], $url);
    }

    return $retval;
}

 add_filter('filter_terracetotemford_car_data', 'filter_terracetotemford_car_data');
    
    function filter_terracetotemford_car_data($car_data) 
    {
        
       
        if($car_data['stock_number']==='40095A') 
        {
            slecho("Excluding car that has stock number 40095A ,{$car_data['url']}");
            return null;
        }
        return $car_data;
    }