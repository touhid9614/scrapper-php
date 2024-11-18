<?php

	global $scrapper_configs;
	$scrapper_configs["speedautogallery"] 	= array(
	    "entry_points" 						=> array(
	        'used' 							=> 'https://www.speedautogallery.com/cars-for-sale?PageSize=100'
	    ),
	    'use-proxy' 						=> true,
	    'vdp_url_regex' 					=> '/\/details\//i',
	    'picture_selectors' 				=> ['.carousel-inner.vehicle-img div img'],
	    'picture_nexts' 					=> ['.glyphicon-chevron-right'],
	    'picture_prevs' 					=> ['.glyphicon-chevron-left'],
	    'no_scrap' 							=> true
	);


	add_filter('filter_for_fb_speedautogallery', 'filter_for_fb_speedautogallery', 10, 1);

	function filter_for_fb_speedautogallery($car) 
	{
		$images = $car['images'];

		foreach ($images as $key => $value) 
		{
			if ($value == 'https://cdn09.carsforsale.com/images/sports_car_front_view-700.png')
			{
				unset($images[$key]);
			}
		}

		$car['images'] = $images;

	    return $car;
	}