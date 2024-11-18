<?php
global $scrapper_configs;
$scrapper_configs["minilavalcom"] = array( 
	 'entry_points' => array(
        'new' => 'https://www.minilaval.com/en/shopping/inventory/GetSearchPage',
        'used' => 'https://www.minilaval.com/en/shopping/inventory/GetSearchPage'
    ),
    'vdp_url_regex' => '/\/detail\//',
    'use-proxy' => true,
    'refine' => false,
    'init_method' => 'POST',
    //'next_method' => 'POST',
    'content_type' => 'application/json',
    'custom_data_capture' => function ($url, $data) {

        $objects = json_decode($data);

        if (!$objects) {
            slecho($data);
            return array();
        }

        $to_return = array();

        foreach ($objects->VehiclesForThisPageList as $obj) {

           

            $car_data = array(
                'stock_number' => $obj->StockNumber ? $obj->StockNumber : $obj->VIN,
                'year' => $obj->ModelYear,
                'make' => "MINI",
                'model' => $obj->ModelDesc,
                'price' => $obj->InternetPrice,
                'transmission' => $obj->Transmission,
                'kilometres' => $obj->MileageInKilometers,
                'vin' => $obj->VIN,
                'url' => "https://www.minilaval.com/en/shopping/inventory/detail/" . $obj->VIN,
                'exterior_color' => $obj->ExteriorColor,
                'interior_color' => $obj->InteriorColor,
                'all_images' => implode("|", $obj->ProvidedPhotoUrlList),
            );


            $to_return[] = $car_data;
        }

        return $to_return;
    },
   // 'images_regx' => '/data-background="(?<img_url>[^"]+)"/'
);

add_filter('filter_minilavalcom_post_data', 'filter_minilavalcom_post_data', 10, 2);

function filter_minilavalcom_post_data($post_data, $stock_type)
{
    if ($stock_type == 'new') {
        $post_data = '{"Brand":"MINI","Status":"N","IncludeDemoVehicles":true,"IncludeVehiclesWithoutOffer":true,"Language":"en","page":1,"ProvinceCode":"","InternalRetailerIDs":["5102"],"ResultsPerPage":"999","SeriesID":"","ModelID":"","Transmission":"","ExteriorColorID":"","ModelYear_Minimum":2023,"ModelYear_Maximum":2024,"Kilometers_Minimum":0,"Kilometers_Maximum":90,"Price_Minimum":0,"Price_Maximum":64535,"SortMode":"PriceAscending","WithPhotosOnly":false,"OnlyDemoVehicles":false,"FeaturedStockNumberList":[]}';
    } elseif ($stock_type == 'used') {
        $post_data = '{"Brand":"MINI","Status":"P","IncludeDemoVehicles":true,"IncludeVehiclesWithoutOffer":true,"Language":"en","page":1,"ProvinceCode":"","InternalRetailerIDs":["5102"],"ResultsPerPage":"999","SeriesID":"","ModelID":"","Transmission":"","ExteriorColorID":"","ModelYear_Minimum":2012,"ModelYear_Maximum":2023,"Kilometers_Minimum":0,"Kilometers_Maximum":95047,"Price_Minimum":19609,"Price_Maximum":47509,"SortMode":"PriceAscending","WithPhotosOnly":false,"OnlyDemoVehicles":false,"IsCertifiedPreOwnedOnly":false,"FeaturedStockNumberList":[]}';
    }

    return $post_data;
}

