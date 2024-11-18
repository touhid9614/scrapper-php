<?php
    global $scrapper_configs;

    $scrapper_configs['thormotors'] = array(
        'entry_points' => array(
            'new'	=> 'http://www.thormotors.com/new-ford-orillia?Layout=List&ps=96',
            'used'      => 'http://www.thormotors.com/used-cars-orillia?Layout=List&ps=96'
        ),
        'vdp_url_regex'     => '/\/[0-9]{4}-[a-z]*-/i',
        'ty_url_regex'      => '/\/thank-you-/i',
        'use-proxy' => true,
        'details_start_tag' => '<div class="eziInvListView">',
        'details_end_tag'   => '<div class="eziPager">',
        'details_spliter'   => '<div class="eziVehicle eziVehicleList"',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #:[^<]*<\/span>\s*<span[^<>]*>(?<stock_number>[^<>]+)<\/span>/',
            'title'         => '/<h2 *class="eziVehicleName"[^>]*>(?<title>[^<]+)/',
            'year'          => '/<h2[^<>]*class="eziVehicleName"[^<>]*> *(?<year>[0-9]+)[^<>]+/',
            'make'          => '/<h2[^<>]*class="eziVehicleName"[^<>]*>[^a-zA-Z]+(?<make>[^ ]+)/',
            'model'         => '/<h2[^<>]*class="eziVehicleName"[^<>]*>[^a-zA-Z]+ +[a-zA-Z]+ +(?<model>[^<>]+) *</',
            'price'         => '/.+class="eziPriceValue"[^<>]*>(?<price>[^<>]+)/',
            'kilometres'    => '/class="eziOdometer"[^<>]*>(?<kilometres>[^<]+)/',
            'url'           => '/class="eziGetMoreInfo"[^>]*>[^<>]*<a[^<>a-zA-Z]*href="(?<url>[^"]+)"/' ,
            'engine'        => '/Engine[^<>]*<\/span>[^<>]*<span[^<>]*>(?<engine>[^<>]+)/',
            'transmission'  => '/Transmission[^<>]*<\/span>[^<>]*<span[^<>]*>(?<transmission>[^<>]+)/',
            'exterior_color'=> '/Exterior[^<>]*<\/span>[^<>]*<span[^<>]*>(?<exterior_color>[^<>]+)/',
            'interior_color'    => '/Interior[^<>]*<\/span>[^<>]*<span[^<>]*>(?<interior_color>[^<>]+)/',
        ),
        'data_capture_regx_full' => array(
        ),
        'next_page_regx'    => '/<a[^<>]*title="Next" *(?:data-href|href)="(?<next>[^"<>]+)"/',
        'images_regx'       => '/<li><img src="(?<img_url>[^"]+)" id="wows/'
    );
