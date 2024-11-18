<?php

global $scrapper_configs;

$scrapper_configs['jump'] = array(
    'entry_points' => array(
        'device' => array(
            'https://www.jump.ca/sasktel-apple-iphones/',
            'https://www.jump.ca/sasktel-smartphones/',
            'https://www.jump.ca/sasktel-cell-phones/',
            'https://www.jump.ca/sasktel-apple-ipads/',
           // 'https://www.jump.ca/sasktel-mobile-internet/',
        //'https://www.jump.ca/refurbished-phones/'
        ), /*
      'accessory' => array(
      'https://www.jump.ca/smart-home/',
      'https://www.jump.ca/cases-and-protection/',
      'https://www.jump.ca/chargers/',
      'https://www.jump.ca/headphones-and-speakers/',
      'https://www.jump.ca/batteries/',
      'https://www.jump.ca/wearables/',
      'https://www.jump.ca/data-and-memory/',
      'https://www.jump.ca/miscellaneous/'
      ) */
    ),
    'vdp_url_regex' => '/\/(?:[^\/]+\/m[0-9]+|fast-forward)\//i',
    'ty_url_regex' => '/\/thankYou.do/i',
    'ajax_url_match' => 'callback=secureLeadSubmission',
    'use-proxy' => true,
    'refine' => false,
    
    'picture_selectors' => ['.thumbnails-carousel-item'],
    'picture_nexts' => [''],
    'picture_prevs' => [''],
    
    'details_start_tag' => '<div class="col-xs-12 content-page-title">',
    'details_end_tag' => '<footer class="footer">',
    'details_spliter' => '<div class="product">',
    'data_capture_regx' => array(
        'make' => '/<span class="col-xs-12 no-padding product-manufacture">(?<make>[^<]+)/',
        'trim' => '/<a class="col-xs-12 no-padding product-model[^"]*"[^>]+>\s*(?<model>[^\n<]+)(?:\n\s*(?<trim>[^\n<]+))?/',
        'model' => '/<a class="col-xs-12 no-padding product-model[^"]*"[^>]+>\s*(?<model>[^\n<]+)/',
        'price' => '/<p class="product-price">\s*(?:From<br[^>]+>\s*)?<span\s*>(?<price>[\$0-9\.,]+)/',
        'url' => '/<a class="col-xs-12 no-padding product-model" href="(?<url>[^"]+)"/'
    ),
    'data_capture_regx_full' => array(
        #Display Size
        'body_style'        => '/<td class="specname">Display Size<\/td>\s*<td class="specvalue">(?<body_style>[^<]+)/',
        #OS Name
        'engine'            => '/<td class="specname">Operating System<\/td>\s*<td class="specvalue">(?<engine>[^<]+)/',
        #OS Version
        'transmission'      => '/<td class="specname">Operating System Version Number<\/td>\s*<td class="specvalue">(?<transmission>[^<]+)/',
        'trim'              => '/<div>\s*<button type="button" class="btn btn-sm btn-default  active" value="Built-in Storage - (?<trim>[^"]+)[^>]+>[^>]+>\s*<\/div>/'
    ),
    'next_page_regx' => '/<li class="active"><a\s*>[0-9]*<\/a><\/li>\s*<li><a href="(?<next>[^"]+)">/',
    'images_regx' => '/"Uri":\"(?<img_url>[^\"]+)/',
);

add_filter("filter_jump_field_images", "filter_jump_field_images", 10, 3);

function filter_jump_field_images($im_urls, $car_data, $page_html) {
    $images_regex = '/"image":\s\"(?<img_url>[^\"]+)/';
    $matches = [];

    if (preg_match_all($images_regex, $page_html, $matches)) {
        $new_imgs = $matches['img_url'];
        $im_urls = array_unique(array_merge($new_imgs, $im_urls));
    }

    return $im_urls;
}

add_filter("filter_jump_field_make", "filter_jump_field_text");
add_filter("filter_jump_field_model", "filter_jump_field_text");
add_filter("filter_jump_field_trim", "filter_jump_field_text");

function filter_jump_field_text($text) {
    return trim(str_replace('&quot;', '', $text));
}

add_filter('filter_style_jump', 'filter_style_jump', 10, 3);

function filter_style_jump($style, $car, $source) {

    global $BannerConfigs;

    $json_file = dirname(__DIR__) . "/client-data/jump/jump.json";

    $data = json_decode(file_get_contents($json_file));
    if (startsWith($car['model'], 'iPhone 6s')) {
        $style = 'jump_apple_6s';
    }

    if (startsWith($car['model'], 'iPhone 7')) {
        $style = 'jump_apple_7';
    }

    if (startsWith($car['model'], 'iPhone 7 Plus')) {
        $style = 'jump_apple_7_plus';
    }

    if (startsWith($car['model'], 'iPhone 8')) {
        $style = 'jump_apple_8';
    }

    if (startsWith($car['model'], 'iPhone 8 Plus')) {
        $style = 'jump_apple_8_plus';
    }

    if (startsWith($car['model'], 'iPhone X')) {
        $style = 'jump_apple_x';
    }

    if (startsWith($car['make'], 'Samsung ') || startsWith($car['model'], 'Galaxy ')) {
        $style = 'jump_samsung_a';
    }
    
   /* if (($car['model']=='Galaxy S9 64 GB')) {
        $style = 'jump_samsung_galaxy_s9';
    }*/
    
    if ($source == 'fb_style') {
        if (startsWith($car['model'], 'iPhone XR')) {
            $style = 'jump_apple_xr';
        }
        if (startsWith($car['model'], 'iPhone XS')) {
            $style = 'jump_apple_xs';
        }
        if (startsWith($car['model'], 'iPhone XS Max')) {
            $style = 'jump_apple_xsmax';
        }
    
        #Support circle on all andorid phones
        if(strtolower(trim($car['engine'])) == 'android') {
            $style = 'jump_samsung_a';
        }
    }

    /* else
      {
      $style = 'jump_other_a';
      } */

    if (array_key_exists($car['url'], $data) && array_key_exists("{$style}_sale", $BannerConfigs)) {
        $style = "{$style}_sale";
    }

    return $style;
}

function get_jump_csv_data() {
    global $jump_data;

    if ($jump_data) {
        return $jump_data;
    }

    $csv_file = dirname(__DIR__) . "/client-data/jump/jump-sales-list.csv";

    $data = csv_real_decode(file_get_contents($csv_file));

    $jump_data = [];

    foreach ($data as $single) {
        $jump_data[md5($single['url'])] = $single['price'];
    }

    return $jump_data;
}

add_filter('jump_post_process_car_data', 'jump_post_process_car_data');

function jump_post_process_car_data($car) {

    $car['trim'] = trim($car['trim']);

    if ($car['trim']) {
        $car['model'] = trim(str_replace($car['trim'], '', $car['model']));
        $car['model'] = trim("{$car['model']} {$car['trim']}");
    }

    if ($car['make'] == 'Apple') {
        $car['make'] = '';
    }

    /*
      $data = get_jump_csv_data();
      $hash = md5($car['url']);

      if(isset($data[$hash]) && numarifyPrice($data[$hash]) == numarifyPrice($car['price'])) {
      $car['price'] = butifyPrice(numarifyPrice($car['price']) + 1);
      }
     * 
     */

    return $car;
}

/*
  add_action('jump_finalize_script', 'jump_finalize_script', 10, 2);
  function jump_finalize_script($car, $page_type) {

  $json_file= dirname(__DIR__) . "/client-data/jump/jump.json";

  $data = (array)json_decode(file_get_contents($json_file));

  if($page_type == 'vdp' && array_key_exists($car['url'], $data) && $data[$car['url']]->reg) {
  if($car['model'] == 'iPhone 8') {
  //echo "\n$($('.product-detail-contract-price')[1]).append('<span style=\"display: block; color:red; text-decoration: line-through;\">{$data[$car['url']]->reg}</span>');\n";
  } else {
  echo "\n$('.product-detail-contract-price').first().append('<span style=\"display: block; color:red; text-decoration: line-through;\">{$data[$car['url']]->reg}</span>');\n";
  }
  }
  }
 * 
 */

//add_action("initialize_jump_scrap", "initialize_jump_scrap");
function initialize_jump_scrap() {
    $json_file = dirname(__DIR__) . "/client-data/jump/jump.json";

    $data = [];

    $url = 'https://www.jump.ca/smartphone-sale/';

    $html = HttpGet($url);

    $regex = '/<a href="(?<url>[^\"]+)".+?<br\s*\/>\s*<span class="saleprice"><strong>(?<sale>[0-9\.\$]+).+?<br\s*\/>\s*(?:<span>Reg: (?<reg>[0-9\.\$]+))?/';

    $split_by = '<div class="prodbox">';

    $spltd = explode($split_by, $html);

    foreach ($spltd as $str) {
        if (preg_match($regex, $str, $match)) {
            $data[$match['url']] = [
                'sale' => $match['sale'],
                'reg' => isset($match['reg']) ? $match['reg'] : false
            ];
        }
    }

    file_put_contents($json_file, json_encode($data));
}
