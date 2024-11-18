<?php

require_once 'bootstrapper.php';

global $connection;

$entry_urls = array(
	'http://www.kijiji.ca/b-cars-trucks/manitoba/c174l9006?for-sale-by=ownr',
	'http://www.kijiji.ca/b-cars-trucks/new-brunswick/c174l9005?for-sale-by=ownr',
	'http://www.kijiji.ca/b-cars-trucks/newfoundland/c174l9008?for-sale-by=ownr',
	'http://www.kijiji.ca/b-cars-trucks/nova-scotia/c174l9002?for-sale-by=ownr',
	'http://www.kijiji.ca/b-cars-trucks/ontario/c174l9004?for-sale-by=ownr',
	'http://www.kijiji.ca/b-cars-trucks/prince-edward-island/c174l9011?for-sale-by=ownr',
	'http://www.kijiji.ca/b-autos-camions/quebec/c174l9001?for-sale-by=ownr',
	'http://www.kijiji.ca/b-cars-trucks/saskatchewan/c174l9009?for-sale-by=ownr',
	'http://www.kijiji.ca/b-cars-trucks/territories/c174l9010?for-sale-by=ownr',
	'http://www.kijiji.ca/b-cars-trucks/alberta/c174l9003?for-sale-by=ownr',
	'http://www.kijiji.ca/b-cars-trucks/british-columbia/c174l9007?for-sale-by=ownr'
);

$db_connect = new DbConnect('all_imported');

foreach ($entry_urls as $entry_url) {
	$url = $entry_url;

	while ($url) {
		slecho("Scrapping from $url");
		$list = scrap_url($url);

		if ($list) {
			foreach ($list->cars as $car) {
				if (!isset($car->car_url)) {
					continue;
				}

				$car_url = $car->car_url;
				slecho("Scrapping from $car_url");
				$car_data = scrap_url($car_url);

				if (!$car_data) {
					continue;
				}

				if (!isset($car_data->year) || !isset($car_data->make) || !isset($car_data->model)) {
					continue;
				}

				slecho("Storing car data from $car_url");

				$acar_data          =  array(
					'stock_number'  => "{$car_data->stock_number}_www.kijiji.ca",
					'options'       => '',
					'stock_type'    => 'used',
					'title'         => "{$car_data->year} {$car_data->make} {$car_data->model}",
					'year'          => $car_data->year,
					'make'          => $car_data->make,
					'model'         => $car_data->model,
					'trim'          => isset($car_data->trim) ? $car_data->trim : '',
					'price'         => $car_data->price,
					'body_style'    => isset($car_data->body_style) ? $car_data->body_style : '',
					'engine'        => isset($car_data->engine) ? $car_data->engine : '',
					'transmission'  => isset($car_data->transmission) ? $car_data->transmission : '',
					'exterior_color' => isset($car_data->exterior_color) ? $car_data->exterior_color : '',
					'interior_color' => '',
					'kilometres'    => isset($car_data->kilometres) ? $car_data->kilometres : '',
					'all_images'    => isset($car_data->all_images) ? (is_array($car_data->all_images) ? implode('|', $car_data->all_images) : $car_data->all_images) : '',
					'auto_texts'    => '',
					'description'   => isset($car_data->description) ? $car_data->description : '',
					'url'           => $car_data->_url,
					'host'          => 'www.kijiji.ca',
					'lat'           => $car_data->lat,
					'long'          => $car_data->long,
					'arrival_date'  => $car_data->arrival_date
				);

				$db_connect->store_byowner_car_data($acar_data);
			}

			$url = isset($list->next_page_url) ? $list->next_page_url : null;
		} else {
			$url = null;
		}
	}
}

$db_connect->close_connection();

slecho('************************************ THE END ************************************');
