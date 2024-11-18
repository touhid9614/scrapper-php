<?php
global $scrapper_configs;
$scrapper_configs["hendersonhdcom"] = array( 
	'entry_points' => array(
        // 'used' => 'https://www.hendersonhd.com/used-harley-motorcycles-for-sale-near-las-vegas-nevada-dealer--inventory?condition=pre-owned',
        'used' => 'https://www.hendersonhd.com/used-harley-motorcycles-for-sale-near-las-vegas-nevada-dealer--inventory?condition=pre-owned&sz=30',
        'new'  => 'https://www.hendersonhd.com/new-harley-motorcycles-for-sale-near-las-vegas-nevada-dealer--inventory?condition=new',
    ),
    'vdp_url_regex' => '/\/(?:New|Pre-owned)-Inventory-[0-9]{4}-/i',
    'use-proxy' => true,
    'refine'=>false,
    'picture_selectors' => ['.lS-image-wrapper'],
    'picture_nexts'     => ['.lSNext'],
    'picture_prevs'     => ['.lSPrev'],

    'details_start_tag'    => '<div class="v7list-results listview',
    'details_end_tag'   => '<div class="v7list-footer">',
    'details_spliter'   => '<li class="v7list-results__item"',

       'data_capture_regx' => array(
           'stock_number'      => '/title="Stock Number:[^>]+>(?<stock_number>[^<]+)/',
           // 'stock_type'        => '/Condition:\s*(?<stock_type>[^"]+)/',
           'year'              => '/vehicle-heading__year">(?<year>[0-9]{4})/',
           'make'              => '/vehicle-heading__name">(?<make>[^<]+)/',
           'model'             => '/vehicle-heading__model">(?<model>[^<]+)/',
           'url'               => '/<a class="vehicle-heading__link" href="(?<url>[^"]+)"/',
           'price'             => '/Our Price[^>]+>[^>]+>\s*(?<price>[$,0-9^<]+)/',
           'exterior_color'    => '/Color:[^>]+>(?<exterior_color>[^<]+)/',
           'fuel_type'         => '/Fuel Type:[^>]+>(?<fuel_type>[^<]+)/',
           'drivetrain'        => '/Vehicle Type:[^>]+>(?<drivetrain>[^<]+)/',
           'engine'            => '/Category:[^>]+>(?<engine>[^<]+)/',
           'body_style'        => '/Category:[^>]+>(?<body_style>[^<]+)/',
           'vin'               => '/Vin:\s*(?<vin>[^"]+)/',
       ),
       'data_capture_regx_full' => array(
           'kilometres'        => '/Odometer[^>]+>[^>]+>(?<kilometres>[0-9,^<]+)/',
       ),
       'next_page_regx'        => '/v7list-pagination__page">Page\s*(?<next>[^\s]+)\sof[^>]+>\s*[^>]+>[^>]+>[^"]+"[^"]+" aria-label="Next Page of Results" >/',
        'images_regx'           => '/lS-image-wrapper">\s*<img src="(?<img_url>[^"]+)/',
   );

add_filter("filter_hendersonhdcom_next_page", "filter_hendersonhdcom_next_page",10,2);
function filter_hendersonhdcom_next_page($next,$current_page) {          
        slecho($current_page);
        $next=explode('/',$next);
        $index=count($next)-1;
        $next=($next[$index]);
        $next++;
        $peg="pg=" . $next;
        $prev="pg=" . ($next-1);
        $url= str_replace($prev, $peg, $current_page);
        return $url; 
   }
add_filter("filter_hendersonhdcom_field_images", "filter_hendersonhdcom_field_images");
function filter_hendersonhdcom_field_images($im_urls) {
   $retval = [];
         foreach($im_urls as $img)
            {
                 $retval[] = str_replace(["&#x2F;","https:&#x2F;&#x2F;cdn.dealerspike.com&#x2F;","https://cdn.dealerspike.com/"], ["/","",""], $img);
            }
        return $retval;
}


   //  add_filter("filter_hendersonhdcom_field_images", "filter_hendersonhdcom_field_images");
   // function filter_hendersonhdcom_field_images($im_urls)
   //  {   
   //     if(count($im_urls) < 2) { return array(); }
   //      $im_urls=  array_map(function($im_url){

   //          $replace_urls = [
   //              'https://cdn.dealerspike.com/',
   //              // 'https://www.barneshdkamloops.com/',
   //              // 'https://www.barneshdvictoria.com/',
   //              // 'http://www.barneshdlangley.com/',
   //              // 'http://www.barneshdkamloops.com/',
   //              // 'http://www.barneshdvictoria.com/',
   //              // 'https://www.barneshdvictoria.com/',
   //              // 'https://www.barneshd.com/',
   //              // 'http://www.barneshd.com/',
   //          ];

   //          $im_url = str_replace($replace_urls, '', $im_url);

   //          $im_url = str_replace('&#x2F;', '/', $im_url);

   //          //slecho("After url: $im_url");

   //          return $im_url;
   //      }, $im_urls );

   //      $im_urls=  array_filter($im_urls,function($im_url){
   //          return !endsWith($im_url,"B8A958CC-6ED9-45D0-A90D-CAB5FFF2F166.jpg") ;
   //      } );

   //      $md5_of_no_car_images = [
   //          '9edde9ef06fffc5f71a19a6873bcbc72',
   //          'b3860e147aec6551f773720717aad325',
   //          '7a12296f2c626f7fce5a18c2c948ac55',
   //          '2c2c91b68e48c28c381dea4ddc73556e',
   //          'dcc9cd867cf4061beb4711ddfac093d7',
   //          'c0f8b00470008896ed72ca48765aee56',
   //          '2da615b7a5977c1f32e07dbff9b84657'
   //      ];

   //      $im_urls = array_filter($im_urls, function($image_url) use ($md5_of_no_car_images){
   //          $md5 = md5(file_get_contents($image_url));
   //          if(in_array($md5, $md5_of_no_car_images)){
   //              slecho("No car image: " . $image_url);
   //              return false;
   //          }
   //          return true;
   //      });
   //      return $im_urls;
   //  }

