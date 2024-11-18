<?php
global $scrapper_configs;
$scrapper_configs["northstarfordsalescalgaryca"] = array(
    'entry_points'        => array(
        'used' => 'https://www.northstarfordsalescalgary.ca/queryInventory',
        'new'  => 'https://www.northstarfordsalescalgary.ca/queryInventory',
    ),
    'vdp_url_regex'       => '/\/(?:new|pre-owned|certified)\/[^\/]+\/[^\/]+\/[0-9]{4}-[^\.]+\.html/',

    'use-proxy'           => true,
    'next_method'         => 'POST',
    'content_type'        => 'application/json',

    'picture_selectors'   => ['.lSPager li img'],
    'picture_nexts'       => ['.right'],
    'picture_prevs'       => ['.left'],

    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            slecho($data);
            return [];
        }

        $to_return = [];

        foreach ($objects->hits->hits as $obj) {
            $obj     = $obj->_source;
            $w_regex = '/(?<weekly>\$[0-9,.]+)/';
            $weekly  = 0;
            $match   = [];

            if (preg_match($w_regex, $obj->source->feed->trim, $match)) {
                $weekly = numarifyPrice($match['weekly']);
            }

            $car_data = array(
                'stock_number'   => $obj->dealer->stock ? $obj->dealer->stock : $obj->_id,
                'vin'            => $obj->vin,
                'year'           => $obj->year,
                'make'           => $obj->make,
                'model'          => $obj->model,
                'drivetrain'     => $obj->filters->drivetrain,
                'trim'           => $obj->source->feed->trim,
                'body_style'     => $obj->color->exterior,
                'fuel_type'      => $obj->filters->fuel_type,
                'price'          => $obj->price->price == 0 ? $obj->price->msrp : $obj->price->price,
                'weekly'         => $weekly,
                'biweekly'       => $weekly * 2,
                'engine'         => $obj->filters->engine,
                'transmission'   => $obj->source->feed->transmissionType,
                'kilometres'     => $obj->mileage,
                'url'            => "https://www.northstarfordsalescalgary.ca/" . strtolower($obj->filters->condition) .
                '/' . strtolower($obj->make) . '/' . strtolower($obj->model) .
                '/' . strtolower($obj->year) . '-' . strtolower($obj->filters->exteriorColor) .
                '-' . strtolower($obj->filters->trim) . '-' . strtolower($obj->_id) . '.html',
                'exterior_color' => $obj->color->exteriorColor,
                'interior_color' => $obj->color->interiorColor,
                'options'        => isset($obj->source->feed->attributes->Options) ? $obj->source->feed->attributes->Options : [],
                'images'         => array_merge($obj->source->feed->images->uploaded, $obj->source->feed->images->managed, $obj->source->feed->images->managed_feed_image),
            );

            $retval = [];

            foreach ($car_data['images'] as $imgUrl) {
                $retval[] = str_replace('|', '%7C', str_replace('https://imgcdn0.searchoptics.com/s/crop_px/0,0,640,480-640/', '', $imgUrl));
            }

            $car_data['all_images'] = implode('|', $retval);

            $to_return[] = $car_data;
        }

        return $to_return;
    }
);

add_filter('filter_northstarfordsalescalgaryca_post_data', 'filter_northstarfordsalescalgaryca_post_data', 10, 2);

function filter_northstarfordsalescalgaryca_post_data($post_data, $stock_type)
{
    if ($stock_type == 'new') {
        $post_data = '{"size":1000,"from":0,"query":{"filtered":{"filter":{"bool":{"must":[{"not":{"term":{"administration.isSold":"1"}}},{"not":{"term":{"administration.isHideFromSite":"1"}}},{"bool":{"should":[{"bool":{"must":[{"term":{"dealer.export_id.lower":"new_b6292"}},{"term":{"dealer.dealership_feed_id.lower":"5228"}},{"term":{"filters.condition.lower":"new"}},{"bool":{"should":[{"range":{"filters.price.msrp":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyMsrp":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"new_b6392"}},{"term":{"dealer.dealership_feed_id.lower":"5264"}},{"term":{"filters.condition.lower":"new"}},{"bool":{"should":[{"range":{"filters.price.msrp":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyMsrp":{"gte":0}}}]}}]}}]}},{"bool":{"should":[{"bool":{"must":[{"term":{"filters.condition.lower":"new"}},{"term":{"filters.make.lower":"ford"}}]}},{"bool":{"must":[{"term":{"filters.condition.lower":"pre-owned"}}]}},{"bool":{"must":[{"term":{"filters.condition.lower":"certified"}}]}}]}},{"bool":{"should":[{"term":{"filters.condition.lower":"new"}}]}}]}},"query":{"bool":{"should":[{"match_all":{}},{"boosting":{"positive":{"range":{"msrp":{"gte":1}}},"negative":{"range":{"msrp":{"lt":1}}},"negative_boost":0.5}}]}}}},"aggregations":{"colors":{"terms":{"field":"filters.exteriorColor.lower","size":0,"order":{"_term":"asc"}}},"doors":{"terms":{"field":"filters.doors.lower","size":0,"order":{"_term":"asc"}}},"fuelType":{"terms":{"field":"filters.fuel_type.lower","size":0,"order":{"_term":"asc"}}},"makes":{"terms":{"field":"filters.make.lower","size":0,"order":{"_term":"asc"}}},"models":{"terms":{"field":"filters.model.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"rawModel":{"terms":{"field":"filters.model","size":0,"order":{"_term":"asc"}}},"byTrim":{"terms":{"field":"filters.trim.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"rawTrim":{"terms":{"field":"filters.trim","size":0,"order":{"_term":"asc"}}}}},"byMake":{"terms":{"field":"filters.make.lower","size":0,"order":{"_term":"asc"}}}}},"bodyStyles":{"terms":{"field":"filters.bodyStyle.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"SubbodyStyles":{"terms":{"field":"filters.sub_bodystyle.lower","size":0,"order":{"_term":"asc"}}}}},"minPrice":{"min":{"field":"filters.price.minPrice"}},"maxPrice":{"max":{"field":"filters.price.maxPrice"}},"monthlyMinPrice":{"min":{"field":"filters.price.monthlyMinPrice"}},"monthlyMaxPrice":{"max":{"field":"filters.price.monthlyMaxPrice"}},"priceBreakdown":{"filter":{"bool":{"must":[{"not":{"term":{"filters.price.maxPrice":0}}}]}},"aggregations":{"breakdown":{"histogram":{"field":"filters.price.maxPrice","interval":5000}}}},"monthlyPriceBreakdown":{"filter":{"bool":{"must":[{"not":{"term":{"filters.price.monthlyMaxPrice":0}}}]}},"aggregations":{"breakdown":{"histogram":{"field":"filters.price.monthlyMaxPrice","interval":100}}}},"mileageBreakdown":{"histogram":{"field":"filters.mileage","interval":15000}},"registrationBreakdown":{"date_histogram":{"field":"date.registrationDate","interval":"year","format":"yyyy","offset":"+350d"}},"minYear":{"min":{"field":"filters.year"}},"maxYear":{"max":{"field":"filters.year"}},"years":{"terms":{"field":"filters.year","size":0,"order":{"_term":"desc"}}},"conditions":{"terms":{"field":"filters.condition.lower"}},"maxMileage":{"max":{"field":"filters.mileage"}},"retailers":{"terms":{"field":"filters.dealer_map_key.lower","size":0}},"transmissions":{"terms":{"field":"filters.transmissionType.lower","size":0,"order":{"_term":"asc"}}},"engines":{"terms":{"field":"filters.engine.lower","size":0,"order":{"_term":"asc"}}},"packages":{"terms":{"field":"filters.packages.lower","size":0,"order":{"_term":"asc"}}},"Custom Field 1":{"terms":{"field":"filters.Custom Field 1.lower","size":0}},"Custom Field 2":{"terms":{"field":"filters.Custom Field 2.lower","size":0}},"Custom Field 3":{"terms":{"field":"filters.Custom Field 3.lower","size":0}},"Custom Field 4":{"terms":{"field":"filters.Custom Field 4.lower","size":0}},"Custom Field 5":{"terms":{"field":"filters.Custom Field 5.lower","size":0}},"Custom Field 6":{"terms":{"field":"filters.Custom Field 6.lower","size":0}},"Custom Field 7":{"terms":{"field":"filters.Custom Field 7.lower","size":0}},"Custom Field 8":{"terms":{"field":"filters.Custom Field 8.lower","size":0}},"Custom Field 9":{"terms":{"field":"filters.Custom Field 9.lower","size":0}},"Custom Field 10":{"terms":{"field":"filters.Custom Field 10.lower","size":0}}},"sort":["_score",{"msrp":{"order":"asc"}}]}';
    } elseif ($stock_type == 'used') {
        $post_data = '{"size":1000,"from":0,"query":{"filtered":{"filter":{"bool":{"must":[{"not":{"term":{"administration.isSold":"1"}}},{"not":{"term":{"administration.isHideFromSite":"1"}}},{"bool":{"should":[{"bool":{"must":[{"term":{"dealer.export_id.lower":"28420"}},{"term":{"dealer.dealership_feed_id.lower":"6708"}},{"term":{"filters.condition.lower":"pre-owned"}},{"bool":{"should":[{"range":{"filters.price.price":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyPrice":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"28420"}},{"term":{"dealer.dealership_feed_id.lower":"6708"}},{"term":{"filters.condition.lower":"certified"}},{"bool":{"should":[{"range":{"filters.price.price":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyPrice":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"28648"}},{"term":{"dealer.dealership_feed_id.lower":"10180"}},{"term":{"filters.condition.lower":"pre-owned"}},{"bool":{"should":[{"range":{"filters.price.price":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyPrice":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"28648"}},{"term":{"dealer.dealership_feed_id.lower":"10180"}},{"term":{"filters.condition.lower":"certified"}},{"bool":{"should":[{"range":{"filters.price.price":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyPrice":{"gte":0}}}]}}]}}]}},{"bool":{"should":[{"term":{"filters.condition.lower":"certified"}},{"term":{"filters.condition.lower":"pre-owned"}}]}}]}},"query":{"bool":{"should":[{"match_all":{}},{"boosting":{"positive":{"range":{"price":{"gte":1}}},"negative":{"range":{"price":{"lt":1}}},"negative_boost":0.5}}]}}}},"aggregations":{"colors":{"terms":{"field":"filters.exteriorColor.lower","size":0,"order":{"_term":"asc"}}},"doors":{"terms":{"field":"filters.doors.lower","size":0,"order":{"_term":"asc"}}},"fuelType":{"terms":{"field":"filters.fuel_type.lower","size":0,"order":{"_term":"asc"}}},"makes":{"terms":{"field":"filters.make.lower","size":0,"order":{"_term":"asc"}}},"models":{"terms":{"field":"filters.model.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"rawModel":{"terms":{"field":"filters.model","size":0,"order":{"_term":"asc"}}},"byTrim":{"terms":{"field":"filters.trim.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"rawTrim":{"terms":{"field":"filters.trim","size":0,"order":{"_term":"asc"}}}}},"byMake":{"terms":{"field":"filters.make.lower","size":0,"order":{"_term":"asc"}}}}},"bodyStyles":{"terms":{"field":"filters.bodyStyle.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"SubbodyStyles":{"terms":{"field":"filters.sub_bodystyle.lower","size":0,"order":{"_term":"asc"}}}}},"minPrice":{"min":{"field":"filters.price.minPrice"}},"maxPrice":{"max":{"field":"filters.price.maxPrice"}},"monthlyMinPrice":{"min":{"field":"filters.price.monthlyMinPrice"}},"monthlyMaxPrice":{"max":{"field":"filters.price.monthlyMaxPrice"}},"priceBreakdown":{"filter":{"bool":{"must":[{"not":{"term":{"filters.price.maxPrice":0}}}]}},"aggregations":{"breakdown":{"histogram":{"field":"filters.price.maxPrice","interval":5000}}}},"monthlyPriceBreakdown":{"filter":{"bool":{"must":[{"not":{"term":{"filters.price.monthlyMaxPrice":0}}}]}},"aggregations":{"breakdown":{"histogram":{"field":"filters.price.monthlyMaxPrice","interval":100}}}},"mileageBreakdown":{"histogram":{"field":"filters.mileage","interval":15000}},"registrationBreakdown":{"date_histogram":{"field":"date.registrationDate","interval":"year","format":"yyyy","offset":"+350d"}},"minYear":{"min":{"field":"filters.year"}},"maxYear":{"max":{"field":"filters.year"}},"years":{"terms":{"field":"filters.year","size":0,"order":{"_term":"desc"}}},"conditions":{"terms":{"field":"filters.condition.lower"}},"maxMileage":{"max":{"field":"filters.mileage"}},"retailers":{"terms":{"field":"filters.dealer_map_key.lower","size":0}},"transmissions":{"terms":{"field":"filters.transmissionType.lower","size":0,"order":{"_term":"asc"}}},"engines":{"terms":{"field":"filters.engine.lower","size":0,"order":{"_term":"asc"}}},"packages":{"terms":{"field":"filters.packages.lower","size":0,"order":{"_term":"asc"}}},"Custom Field 1":{"terms":{"field":"filters.Custom Field 1.lower","size":0}},"Custom Field 2":{"terms":{"field":"filters.Custom Field 2.lower","size":0}},"Custom Field 3":{"terms":{"field":"filters.Custom Field 3.lower","size":0}},"Custom Field 4":{"terms":{"field":"filters.Custom Field 4.lower","size":0}},"Custom Field 5":{"terms":{"field":"filters.Custom Field 5.lower","size":0}},"Custom Field 6":{"terms":{"field":"filters.Custom Field 6.lower","size":0}},"Custom Field 7":{"terms":{"field":"filters.Custom Field 7.lower","size":0}},"Custom Field 8":{"terms":{"field":"filters.Custom Field 8.lower","size":0}},"Custom Field 9":{"terms":{"field":"filters.Custom Field 9.lower","size":0}},"Custom Field 10":{"terms":{"field":"filters.Custom Field 10.lower","size":0}}},"sort":["_score",{"price":{"order":"asc"}}]}';
    }

    return $post_data;
}