<?php
global $scrapper_configs;
 $scrapper_configs["mercedes_benz_silverstarcafr"] = array( 
	 'entry_points' => array(
        'used' => 'https://www.mercedes-benz-silverstar.ca/fr/inventaire-occasion',
        'new'  => 'https://www.mercedes-benz-silverstar.ca/fr/inventaire-neuf',
    ),
    'url_resolve'       => array(
        'mercedes_benz_silverstarca'    => '/www.mercedes-benz-silverstar.ca\/en/i',
        'mercedes_benz_silverstarcafr'  => '/www.mercedes-benz-silverstar.ca\/fr/i',
    ),
    'vdp_url_regex' => '/\/fr\/(?:inventaire-occasion|catalogue-neuf)\//i',
    'ty_url_regex' => '/\/en\/thank-you/i',
    'use-proxy' => true,
    'picture_selectors' => ['div.slick-slide img'],
    'picture_nexts' => ['.widget-ninjabox__bxslider-controls--next'],
    'picture_prevs' => ['.widget-ninjabox__bxslider-controls--prev'],
    'details_start_tag' => '<div class="inventory-listing__vehicles',
    'details_end_tag' => '<ul class="pagination">',
    'details_spliter' => '<article class="inventory-list-layout',
    'data_capture_regx' => array(
        'vin' => '/de série[^>]+>\s*[^>]+>(?<vin>[^<]+)/',
        'title' => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))"/',
        'year' => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))"/',
        'make' => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))"/',
        'model' => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))"/',
        'price' => '/inventory-list-layout__preview-price-current[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>(?<price>[^\$]+)/',
        'url' => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))"/'
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/inventaire:[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
        'body_style' => '/Chassis:[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
        'engine' => '/Cylinders[^>]+>\s*[^>]+>(?<engine>[^(?:\&|<)]+)/',
        'transmission' => '/Transmission:<\/div>[^>]+\s*inventory-details__content-value">(?<transmission>[^<]+)/',
        'exterior_color' => '/Couleur ext.:[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Couleur int.:[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
        'kilometres'     => '/Kilometrage<\/span>[^>]+>(?<kilometres>[^K]+)/',
    ),
    'next_page_regx' => '/<a class="pagination__page-arrows-text " href="(?<next>[^"]+)"[^>]+>[^>]+>Suivant/',
    'images_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_mercedes_benz_silverstarcafr_field_images", "filter_mercedes_benz_silverstarcafr_field_images", 10, 2);
add_filter('filter_mercedes_benz_silverstarcafr_car_data', 'filter_mercedes_benz_silverstarcafr_car_data');


function filter_mercedes_benz_silverstarcafr_car_data($car_data) {
    //taking all cars except Corvette

    $car_data['kilometres'] = preg_replace('/[^0-9]/', '', $car_data['kilometres']);
    $car_data['price'] = preg_replace('/[^0-9]/', '', $car_data['price']);
    

    return $car_data;
}


function filter_mercedes_benz_silverstarcafr_field_images($im_urls, $car_data) {

    if (isset($car_data['url']) && $car_data['url']) {
        $id = explode("id", $car_data['url']);
        $api_url = "https://www.mercedes-benz-silverstar.ca/fr/inventaire/occasion/fragments/vehiclesByIds?view=ninjabox-gallery&vehicleId={$id[1]}";
        $response_data = HttpGet($api_url);
        $regex = '/<img src="(?<img_url>[^"]+)" alt=/';

        $matches = [];


        if (preg_match_all($regex, $response_data, $matches)) {

            foreach ($matches['img_url'] as $key => $value) {
                $im_urls[] = $value;
            }
        }
    }

    return array_filter($im_urls, function($im_url) {
        return !endsWith($im_url, 'no-photo1565034281032.jpg');
    });
}
