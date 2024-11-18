<?php

global $scrapper_configs;
$scrapper_configs["capitalautoorg"] = array(
    'entry_points' => array(
        'used' => 'https://www.capitalauto.org/_api/wix-ecommerce-storefront-web/api',
        
    ),
    'vdp_url_regex' => '/\/product-page\/[0-9]{4}/',
    
    'use-proxy' => true,
    'content_type' => 'application/json',
    'init_method' => 'POST',
    'next_method' => 'POST',
    'additional_headers' => array(
        "X-ecom-instance" => "ktVR33l73VJgD-82uMEilvqEbSwA31g3Yg2xj7GfnZU.eyJpbnN0YW5jZUlkIjoiMWEyODkyNjEtNGYyMi00Y2YyLWI5ZDQtMWIzYmYxNGU4OTc4IiwiYXBwRGVmSWQiOiIxMzgwYjcwMy1jZTgxLWZmMDUtZjExNS0zOTU3MWQ5NGRmY2QiLCJtZXRhU2l0ZUlkIjoiMzY2ZDhjODAtMTBlMS00ZGJkLThlNmMtZTZjZDBmMzI2ZjQzIiwic2lnbkRhdGUiOiIyMDIwLTAyLTI3VDEwOjEwOjE0LjM4OVoiLCJkZW1vTW9kZSI6ZmFsc2UsImFpZCI6IjY5MGM3YTEzLWJkZDMtNGZhYi04OTM0LWNlMDZjODNhZmFjOCIsImJpVG9rZW4iOiIyYzQ1MWVlMS01ZmMzLTAxNGYtMzdiOC1mZGY2ZmU3Y2U2M2IiLCJzaXRlT3duZXJJZCI6IjA2NWRkMTJlLWNiZWYtNDllMi1iYmU3LTAzMjg5NDc5OTIyMyJ9",
        "Authorization"   => "ktVR33l73VJgD-82uMEilvqEbSwA31g3Yg2xj7GfnZU.eyJpbnN0YW5jZUlkIjoiMWEyODkyNjEtNGYyMi00Y2YyLWI5ZDQtMWIzYmYxNGU4OTc4IiwiYXBwRGVmSWQiOiIxMzgwYjcwMy1jZTgxLWZmMDUtZjExNS0zOTU3MWQ5NGRmY2QiLCJtZXRhU2l0ZUlkIjoiMzY2ZDhjODAtMTBlMS00ZGJkLThlNmMtZTZjZDBmMzI2ZjQzIiwic2lnbkRhdGUiOiIyMDIwLTAyLTI3VDEwOjEwOjE0LjM4OVoiLCJkZW1vTW9kZSI6ZmFsc2UsImFpZCI6IjY5MGM3YTEzLWJkZDMtNGZhYi04OTM0LWNlMDZjODNhZmFjOCIsImJpVG9rZW4iOiIyYzQ1MWVlMS01ZmMzLTAxNGYtMzdiOC1mZGY2ZmU3Y2U2M2IiLCJzaXRlT3duZXJJZCI6IjA2NWRkMTJlLWNiZWYtNDllMi1iYmU3LTAzMjg5NDc5OTIyMyJ9",
    ),
    'picture_selectors' => ['.thumbnails__single'],
    'picture_nexts' => ['button.modal-slideshow__next'],
    'picture_prevs' => ['button.modal-slideshow__prev'],
    'custom_data_capture' => function($url, $data) {
$objects = json_decode($data);

if (!$objects) {
    slecho($data);
    return array();
}


$to_return = array();


foreach ($objects->data->catalog->category->productsWithMetaData->list as $obj) {
    preg_match('/(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s(?<model>[^"]+)/', $obj->name, $matches);

    $retval = [];
    $car_data = array(
        'stock_number' => $obj->id ? $obj->id : $obj->id,
        'year' => $matches['year'],
        'make' => $matches['make'],
        'model' => $matches['model'],
        'price' => $obj->price,
        'transmission' => strip_tags($obj->additionalInfo[1]->description),
        'kilometres' => preg_replace('/[^0-9,]/', '', strip_tags($obj->additionalInfo[0]->description)),
        //'vin' => substr($obj->id,0,17),
        'vin' => substr($obj->id, -17),
        'url' => "https://www.capitalauto.org/product-page/" . $obj->urlPart,
        'exterior_color' => $obj->ribbon,
        'title' => $obj->name,
        'description' => strip_tags($obj->description)
    );
    foreach ($obj->media as $img) {
        $retval[] = "https://static.wixstatic.com/media/" . $img->url;
    }
    $car_data['all_images'] = implode("|", $retval);

    $to_return[] = $car_data;
}
return $to_return;
},
);

add_filter('filter_capitalautoorg_post_data', 'filter_capitalautoorg_post_data', 10, 2);

function filter_capitalautoorg_post_data($post_data, $stock_type) {

    if ($stock_type == 'used') {
        $post_data = '{"variables":{"mainCollectionId":"00000000-000000-000000-000000000001","offset":0,"limit":120,"sort":null,"filters":null},"query":"query getFilteredProducts($mainCollectionId: String!, $filters: ProductFilters, $sort: ProductSort, $offset: Int, $limit: Int) {\n  catalog {\n    category(categoryId: $mainCollectionId) {\n      numOfProducts\n      productsWithMetaData(filters: $filters, limit: $limit, sort: $sort, offset: $offset, onlyVisible: true) {\n        totalCount\n        list {\n           id options(limit: 1) { id } customTextFields(limit: 1) { title } productType ribbon price sku  description additionalInfo {description} comparePrice isInStock urlPart formattedComparePrice formattedPrice digitalProductFileItems {   fileType } name media {   url   } isManageProductItems isTrackingInventory inventory {   status   quantity }\n        }\n      }\n    }\n  }\n}\n","source":"WixStoresWebClient","operationName":"getFilteredProducts"}';
    }

    return $post_data;
}
