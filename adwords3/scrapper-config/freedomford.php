<?php
global $scrapper_configs;

$scrapper_configs['freedomford'] = array(
    'entry_points' => array('https://www.freedom-ford.com/cars-for-sale'),
    'vdp_url_regex' => '/\/details\/(?:new|used)-[0-9]{4}-/i',
    'picture_selectors' => ['.carousel-inner.vehicle-img div img'],
    'picture_nexts' => ['.glyphicon.glyphicon-chevron-right'],
    'picture_prevs' => ['.glyphicon.glyphicon-chevron-left'],
);


add_filter('filter_for_fb_freedomford', 'filter_for_fb_freedomford', 10, 1);

function filter_for_fb_freedomford($car) 
{
	$images = $car['images'];
	$invalids = 
	[
		'https://cdn09.carsforsale.com/images/sports_car_front_view-700.png',
		'https://cdn09.carsforsale.com/images/nophoto.png'
	];

	foreach ($images as $key => $value) 
	{
		if (in_array($value, $invalids))
		{
			unset($images[$key]);
		}
	}

	$car['images'] = $images;

    return $car;
}