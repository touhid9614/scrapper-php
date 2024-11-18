<?php

global $scrapper_configs;
$scrapper_configs["farmworld"] = array(
    'entry_points'        => array(
        'used' => array(
            'https://farmworld.ca/ironsearch/exports/equipments.json',
        ),
    ),
    'vdp_url_regex'       => '/\/(?:is-equipment-listings|used-equipment)\/view\/[0-9]{6,7}-/i',
    'srp_page_regex'      => '/\/is-equipment-listings/i',
    'use-proxy'           => true,
    'refine'              => false,
    'picture_selectors'   => ['.row.row-carousel-indicators div'],
    'picture_nexts'       => ['.right.carousel-control'],
    'picture_prevs'       => ['.left.carousel-control'],

    "custom_data_capture" => function ($url, $data) {
        // https://app.guidecx.com/app/projects/66c1ae75-5958-4ca5-9fcb-f4f6a0683d00/notes
        $resp_jd = json_decode($data, true);
        $cars    = [];

        // https://app.guidecx.com/app/tasks?edit-task=true&milestone-id=504ae507-54c5-4682-a928-2816fc28422e&task-id=f95cb46a-7575-4318-8685-53de1b75c63e&task-tab=details
        // https://app.guidecx.com/app/projects/c466933a-604f-4df0-bbef-da3ede86be84/notes
       // $need_catagory = ['Air Drill', 'Skid Steers', 'Air Tank/Cart', 'Field Cultivator', 'Harrow', 'Sprayer', 'Track Loaders','Baler/Round','Tractor','Bale Wrapper','Bale Mover','Combine','Rock Picker','Mower/Rotary Cutter','Snow Blower','Grain Auger','Header Combine','Grain Cart'];

        foreach ($resp_jd as $first) {
            $img_reg = '/:"(?<img_url>https:\/\/farmworld\.ca\/userdata\/ironsearch\/[^"]+)"/';
            $matches = [];

            preg_match_all($img_reg, $first['images'], $matches);

            // Main photo = 3 photos, secondary photo = 6 photos
            $im_url=[];
            foreach ($matches['img_url'] as $key=> $value){
               if($key%3==0){
                   $im_url[]=$value;
               }
            }
            if (count($im_url) < 4) {
                $im_url = [];
            }

            // Don't need the vehicles outside listed body styles
//            if (!in_array($first['type_full'], $need_catagory)) {
//                $first['advertised_price'] = 'Please Call';
//                $matches['img_url']        = [];
//            }

            $cars[] = [
                'stock_type'   => 'used',
                'vehicle_id'   => $first['id'],
                'year'         => $first['year'],
                'stock_number' => $first['stock_no'],
                'make'         => $first['make_full'],
                'model'        => $first['model_number'],
                'body_style'   => $first['type_full'],
                'currency'     => $first['currency'],
                'price'        => $first['advertised_price'],
                'all_images'   => implode("|", $im_url),
                'title'        => str_replace('model', $first['model_number'], $first['title']),
                'url'          => strtolower('https://farmworld.ca/is-equipment-listings/view/' . $first['iw_no'] . '-' . str_replace(' ', '-', $first['make_full']) . '-' . str_replace(' ', '-', $first['type_full']) . '-' . str_replace(' ', '-', $first['model_number'])),
                'city'         => strtolower(str_replace(" ", "_", $first['location'])),
                'description'  => $first['description'],
                'custom'       => $first['type_full'],
            ];

        }

        return $cars;
    },

    'description'         => '/<meta property="og:description" content="(?<description>[^"]+)/',
);
