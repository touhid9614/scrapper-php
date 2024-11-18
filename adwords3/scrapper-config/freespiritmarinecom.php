<?php
global $scrapper_configs;
$scrapper_configs["freespiritmarinecom"] = array( 
	'entry_points' => array(
        'used'  => 'https://www.freespiritmarine.com/sitemap.xml',
       ),
      'vdp_url_regex'       => '/\/inventory\//i',
      'use-proxy'           => true,
      'refine'             => false,
  
      "custom_data_capture" => function ($url, $data) {
          $site                 = "https://www.freespiritmarine.com/sitemap.xml";
          $vdp_url_regex        = '/\/inventory\//i';
          $images_regx          = '/srcset="\/\/(?<img_url>[^"]+)/i';
          $images_fallback_regx = '/<meta name="og:image" content="(?<img_url>[^"]+)"/i';
          $required_params      = [];
          $use_proxy            = true;
  
          $data_capture_regx_full = [
            //   'title'          => '/<meta name="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
              'stock_type'     => '/New\/Used[^>]+>[^>]+>(?<stock_type>[^<]+)/i',
              'year'           => '/og:title" content="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+)/i',
              'make'           => '/og:title" content="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+)/i',
              'model'          => '/og:title" content="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^"]+)/i',
              'vin'            => '/VIN[^>]+>[^>]+>(?<vin>[^<]+)/i',
              'stock_number'   => '/Stock #[^>]+>[^>]+>(?<stock_number>[^<]+)/i',
              'price'          => '/unitPrice">(?<price>[^<]+)/i',
              'body_style'     => '/bodyStyle:\s*\'(?<body_style>[^\']+)/i',
          ];
  
          $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy);
          $return_cars = [];
          $im_urls=[];
          foreach ($cars as $car) {
              $car['transmission'] = str_replace('\x2D', '', $car['transmission']);
  
              if (!$car['transmission']) {
                  $car['transmission'] = '';
              }
  
              if (strtolower($car['trim']) == 'for') {
                  $car['trim'] = '';
              }
              
              if (empty($car['year'])) {
                  continue;
              }
              
              $car['all_images'] = str_replace('https://www.freespiritmarine.com/inventory/', 'https://', $car['all_images']);
              
              $return_cars[] = $car;
          }
  
          return $return_cars;
      }
  );