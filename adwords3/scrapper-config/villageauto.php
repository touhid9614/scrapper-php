<?php
    global $scrapper_configs;

    $scrapper_configs['villageauto'] = array(
        'entry_points' => array(
            'used'  => 'http://www.villageauto.ca/used/dealer/Village+Auto/'
        ),
        'use-proxy' => true,
        'details_start_tag' => 'id="vehicleList"',
        'details_end_tag'   => '<!-- FOOTER START -->',
        'details_spliter'   => 'id="list-id-',
        'data_capture_regx' => array(
            'stock_number'  => '/class="table-col">Stock #:<\/td><td class="table-col-1" itemprop="sku">(?<stock_number>[^<]+)/',
            'year'          => '/<p class="vehicle-year-make-model" itemprop="name"><a.+?(?=href)href="(?<url>[^"]+)"><span itemprop=\'releaseDate\'>(?<year>[0-9]{4})<\/span> <span itemprop=\'manufacturer\'>(?<make>[^<]+)<\/span> <span itemprop=\'model\'>(?<model>[^<]+)/',
            'make'          => '/<p class="vehicle-year-make-model" itemprop="name"><a.+?(?=href)href="(?<url>[^"]+)"><span itemprop=\'releaseDate\'>(?<year>[0-9]{4})<\/span> <span itemprop=\'manufacturer\'>(?<make>[^<]+)<\/span> <span itemprop=\'model\'>(?<model>[^<]+)/',
            'model'         => '/<p class="vehicle-year-make-model" itemprop="name"><a.+?(?=href)href="(?<url>[^"]+)"><span itemprop=\'releaseDate\'>(?<year>[0-9]{4})<\/span> <span itemprop=\'manufacturer\'>(?<make>[^<]+)<\/span> <span itemprop=\'model\'>(?<model>[^<]+)/',
            'price'         => '/<span itemprop="price">(?<price>[^<]+)/',
            'body_style'    => '/itemprop="bodyType">(?<body_style>[^<]+)/',
            'engine'        => '/itemprop="vehicleEngine">(?<engine>[^N][^<]+)/',
            'transmission'  => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
            'exterior_color'=> '/itemprop="color">(?<exterior_color>[^<]+)/',
            'kilometres'    => '/itemprop="mileageFromOdometer"[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/<p class="vehicle-year-make-model" itemprop="name"><a.+?(?=href)href="(?<url>[^"]+)"><span itemprop=\'releaseDate\'>(?<year>[0-9]{4})<\/span> <span itemprop=\'manufacturer\'>(?<make>[^<]+)<\/span> <span itemprop=\'model\'>(?<model>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
        ),
        'images_regx'       => '/<img onerror="imgError\(this\);" src="(?<img_url>[^"]+)/',
        'next_page_regx'    => '/var nextPageUrl = "(?<next>[^"]+)/'
    );
