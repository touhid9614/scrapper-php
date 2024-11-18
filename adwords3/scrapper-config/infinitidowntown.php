<?php
global $scrapper_configs;

$scrapper_configs["infinitidowntown"] = array( 
	"entry_points" => array(
	 	'new' => 'https://www.infinitidowntown.ca/New-Inventory',
	 	'used' => 'https://www.infinitidowntown.ca/Used-Inventory',
	),
	"vdp_url_regex" => "/\/(?:New-Inventory|Used-Inventory)\/[0-9]{4}-/",
	"no_scrap" => true,
	"use-proxy" => true,
);


add_filter('filter_for_fb_infinitidowntown', 'filter_for_fb_infinitidowntown', 10, 1);

function filter_for_fb_infinitidowntown($car) 
{
	$images = $car['images'];

	$invaild_images = ['https://www.infinitidowntown.ca/Content/Images/Common/General/VehNotAvail.jpg?siteUrl=www.infinitidowntown.ca'];

	foreach ($images as $key => $value) 
	{
		if (in_array($value, $invaild_images))
		{
			unset($images[$key]);
		}
	}

	$car['images'] = $images;

    return $car;
}