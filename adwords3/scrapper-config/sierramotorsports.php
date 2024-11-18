<?php
global $scrapper_configs;
$scrapper_configs["sierramotorsports"] = array(
    "entry_points" => array(
        'new'   => [
            #Honda
            'https://sierramotorsports.com/Showroom/New-Vehicles/Product-Model-Results/Honda',
            'https://sierramotorsports.com/Showroom/New-Vehicles/Product-Model-Results/Honda/2018',
            #Suzuki
            'https://sierramotorsports.com/Showroom/New-Vehicles/Product-Model-Results/Suzuki',
            'https://sierramotorsports.com/Showroom/New-Vehicles/Product-Model-Results/Suzuki/2018',
            #KTM
            'https://sierramotorsports.com/Showroom/New-Vehicles/Product-Model-Results/KTM',
            'https://sierramotorsports.com/Showroom/New-Vehicles/Product-Model-Results/KTM/2019',
            #Honda-Power-Equipment
            'https://sierramotorsports.com/Showroom/New-Vehicles/Product-Model-Results/Honda-Power-Equipment',
        ],
        'used'  => [
            # Intentionally inserted in the used category as the page layout for this page is similar
            # And we pick stock type explicitly in scrapper that's why stock type is overriden in data
            'https://sierramotorsports.com/Showroom/New-Non-Current-Inventory',
            'https://sierramotorsports.com/Showroom/Used-Inventory',
        ]
    ),
    #Any none car dealership shall have refine turned off
    'refine'    => false,
    'vdp_url_regex' => '/\/[A-Za-z]+-.*[0-9]{4}-Grass/i',
    'picture_selectors' => ['#slideshow-thumbnails .owl-stage-outer  div  div.owl-item'],
    'picture_nexts' => ['#slideshow-main  div.owl-nav  div.owl-next'],
    'picture_prevs' => ['#slideshow-main div.owl-nav div.owl-prev'],
    'new'   => [
        'details_start_tag' => '<div class="header-container">',
        'details_end_tag' => '<span class="dnn-module-actions">',
        'details_spliter' => '<article class="product">',
        'data_capture_regx' => array(
            'url'   => '/<div class="summary">\s*<header>\s*<a href="(?<url>[^"]+)/',
        ),
        'data_capture_regx_full' => array(
            'title'         => '/<div itemprop="name"><h1>(?<title>[^<]+)/',
            'year'          => '/<span class=\"spec-title\">Model Year<\/span><\/div>\s*<div class=\"col-xs-7 td\">\s*<span class="spec-info">\s*(?<year>[^\n<]+)/',
            'make'          => '/<span class=\"spec-title\">Manufacturer<\/span><\/div>\s*<div class=\"col-xs-7 td\">\s*<span class="spec-info">\s*(?<make>[^\n<]+)/',
            'model'         => '/<span class=\"spec-title\">Model<\/span><\/div>\s*<div class=\"col-xs-7 td\">\s*<span class="spec-info">\s*(?<model>[^\n<]+)/',
            'price'         => '/<h3 class="price">(?<price>\$[0-9,]+)/',
            'body_style'    => '/<span class=\"spec-title\">Category<\/span><\/div>\s*<div class=\"col-xs-7 td\">\s*<span class="spec-info">\s*(?<body_style>[^\n<]+)/',
            'exterior_color'=> '/<span class=\"spec-title\">Color<\/span><\/div>\s*<div class=\"col-xs-7 td\">\s*<span class="spec-info">\s*(?<exterior_color>[^\n<]+)/',
            'stock_type'    => '/<span class="condition">(?<stock_type>[^<]+)/'
        ),
        'images_regx' => '/<div class="item"><img src="(?<img_url>[^"]+)/',
    ],
    'used'  => [
        'details_start_tag' => '<div class="showroom-items">',
        'details_end_tag' => '<div class="breakpoint-detect-helper">',
        'details_spliter' => '<article class="product">',
        'data_capture_regx' => array(
            'url' => '/<header class=".*\s[^<]+<a href="(?<url>[^"]+)/',
        ),
        'data_capture_regx_full' => array(
            'title'         => '/<div itemprop="name"><h1>(?<title>[^<]+)/',
            'year'          => '/<span class=\"spec-title\">Model Year<\/span><\/div>\s*<div class=\"col-xs-7 td\">\s*<span class="spec-info">\s*(?<year>[^\n<]+)/',
            'make'          => '/<span class=\"spec-title\">Manufacturer<\/span><\/div>\s*<div class=\"col-xs-7 td\">\s*<span class="spec-info">\s*(?<make>[^\n<]+)/',
            'model'         => '/<span class=\"spec-title\">Model<\/span><\/div>\s*<div class=\"col-xs-7 td\">\s*<span class="spec-info">\s*(?<model>[^\n<]+)/',
            'price'         => '/<h3 class="price">(?<price>\$[0-9,]+)/',
            'body_style'    => '/<span class=\"spec-title\">Category<\/span><\/div>\s*<div class=\"col-xs-7 td\">\s*<span class="spec-info">\s*(?<body_style>[^\n<]+)/',
            'exterior_color'=> '/<span class=\"spec-title\">Color<\/span><\/div>\s*<div class=\"col-xs-7 td\">\s*<span class="spec-info">\s*(?<exterior_color>[^\n<]+)/',
            'stock_type'    => '/<span class="condition">(?<stock_type>[^<]+)/'
        ),
        'images_regx' => '/<div class="item"><img src="(?<img_url>[^"]+)/',
    ]
);

add_filter('filter_sierramotorsports_field_stock_type', 'filter_sierramotorsports_field_stock_type');

function filter_sierramotorsports_field_stock_type($stock_type)
{
    return strtolower(trim($stock_type));
}