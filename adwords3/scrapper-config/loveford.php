<?php
global $scrapper_configs;
 $scrapper_configs["loveford"] = array( 
	   'entry_points' => array(
        'new' => 'https://www.loveford.com/searchnew.aspx',
        'used' => 'https://www.loveford.com/searchused.aspx'
    ),
    'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    'ty_url_regex' => '/\/thankyou.aspx/i',
     'refine'=>false,
    'picture_selectors' => ['.js-carousel__item'],
    'picture_nexts' => ['.carousel__control.carousel__control--next.js-carousel__control--next.js-carousel__control  span'],
    'picture_prevs' => ['.carousel__control.carousel__control--prev.js-carousel__control--prev.js-carousel__control span'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<footer',
    'details_spliter' => '<div id="srpRow',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:\s*<\/strong>(?<stock_number>[^<]+)<\/li>/',
        'title' => '/class="vehicleTitle margin-x">\s*<a href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
        'year' => '/class="vehicleTitle margin-x">\s*<a href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
        'make' => '/class="vehicleTitle margin-x">\s*<a href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
        'price' => '/(?:Love Ford Price|Love Ford Price:)\s*<\/span>[^>]+>(?<price>[$0-9,]+)/',
        'engine' => '/Engine: <\/strong>\s*(?<engine>[^<]+)/',
        'transmission' => '/Transmission: <\/strong>\s*(?<transmission>[^<]+)/',
        'exterior_color' => '/Ext. Color: <\/strong>\s*(?<exterior_color>[^<]+)/',
        'interior_color' => '/Int. Color: <\/strong>\s*(?<interior_color>[^<]+)/',
        'kilometres' => '/Mileage: <\/strong>\s*(?<kilometres>[^<]+)/',
        'url' => '/class="vehicleTitle margin-x">\s*<a href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
        'body_style' => '/Body Style: <\/strong>\s*(?<body_style>[^<]+)/'
    ),
    'data_capture_regx_full' => array(
        'make' => '/vehicleMake="(?<make>[^"]+)/',
        'model' => '/vehicleModel="(?<model>[^"]+)/',
        'trim' => '/vehicleTrim="(?<trim>[^"]+)/',
        'vin' => '/VIN:\s(?<vin>[^<]+)/'
    ),
    'next_page_regx' => '/<li\s*class="active[^>]+>[\s\S]+?<\/li>\s*<li\s*>\s*<a[\s\S]+?href="(?<next>[^"]+)"/',
    'images_regx' => '/<img src="(?<img_url>[^"]+)" alt/',
);

add_filter("filter_loveford_field_price", "filter_loveford_field_price", 10, 3);

function filter_loveford_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("Regex Selling Price: $price");
    }

    
    $msrp_regex = '/MSRP:\s*</span>[^>]+>(?<price>[$0-9,]+)/';

    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Sale Price: {$matches['price']}");
    }


    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
