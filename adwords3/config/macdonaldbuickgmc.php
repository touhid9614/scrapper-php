<?php

global $CronConfigs;

$CronConfigs["macdonaldbuickgmc"] = array (
  'budget' => 2.0,
  'password' => 'macdonaldbuickgmc',
  'post_code' => 'E2A 7K2',
  'email' => 'regan@smedia.ca',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'log' => true,
  'customer_id' => '305-941-8315',
  'max_cost' => 1700,
  'per_vehicle_max_cost' => 30,
  'cost_distribution' => 
  array (
    'adwords' => 1700,
  ),
  'create' => 
  array (
  ),
  'bing_account_id' => 2912426,
  'new_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model]',
    ),
  ),
  'used_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model]',
    ),
  ),
  'banner' => 
  array (
    'template' => 'macdonaldbuickgmc',
    'fb_description_new' => 'Still interested in this [year] [make] [model] [trim]? See it today at Atlantic Canada\'s Largest Dealer!',
    'fb_retargeting_description_used' => 'With over $6,000,000 in stock, we are Atlantic Canada\'s Used Truck, car and SUV Dealer! Still interested in this [year] [make] [model]? Click for more information.',
    'fb_lookalike_description_new' => 'Check out this [year] [make] [model] [trim] today at Atlantic Canada\'s Largest Buick Dealer!',
    'fb_lookalike_description_used' => 'With over $6,000,000 in stock, we are Atlantic Canada\'s Used Truck, car and SUV Dealer! Check out this [year] [make] [model] today!',
	'fb_description_certified' => 'THE GM CERTIFIED PRE-OWNED ADVANTAGE - Instead of worries you have peace of mind. Our certified vehicles come with a 150+ point inspection, a Manufacturer\'s Warranty, 24-hour Roadside Assistance and an Exchange Privilege. Shop the giant selection at MacDonald Buick GMC today!',
    //'fb_retargeting_description_cadillac' => 'Atlantic Canada\'s Largest Cadillac Dealer!',
    //'fb_lookalike_description_cadillac' => 'Atlantic Canada\'s Largest Cadillac Dealer!',
    'fb_dynamiclead_description' => 'Interested in purchasing a vehicle from us? Click below and fill in your information - a finance specialist will get in touch to answer your question.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'styels' => 
    array (
      'new_display' => 'dynamic_banner',
      'used_display' => 'dynamic_banner',
      'new_retargeting' => 'dynamic_banner',
      'used_retargeting' => 'dynamic_banner',
      'new_marketbuyers' => 'dynamic_banner',
      'used_marketbuyers' => 'dynamic_banner',
    ),
    'font_color' => '#ffffff',
  ),
  'adf_to' => 
  array (
    0 => 'macdonaldgmc@gmail.com',
  ),
  'lead_to' => 
  array (
    0 => 'macdonaldgmc@gmail.com',
    1 => 'pierre@macdonaldbuickgmc.com',
    2 => 'jennifer.keirstead@macdonaldbuickgmc.com',
  ),
  'form_live' => true,
  'buttons_live' => true,
  'buttons' => 
  array (
    'request-a-quote' => 
    array (
      'url-match' => '/\\/inventory\\/(?:new|used|certified)-[0-9]{4}/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => '.di-modal.main-cta.vdp-pricebox-cta-button',
      'css-class' => '.di-modal.main-cta.vdp-pricebox-cta-button',
      'css-hover' => '.di-modal.main-cta.vdp-pricebox-cta-button:hover',
      'button_action' => 
      array (
        0 => 'form',
        1 => 'e-price',
      ),
      'sizes' => 
      array (
        100 => 
        array (
        ),
      ),
      'texts' => 
      array (
        'request-a-quote' => 
        array (
          'target' => '.di-modal.main-cta.vdp-pricebox-cta-button',
          'values' => 
          array (
            0 => 'GET E-PRICE',
            1 => 'GET INTERNET PRICE',
            2 => 'GET OUR BEST PRICE',
            3 => 'GET SPECIAL PRICE',
            4 => 'Check Availability',
            5 => 'Get Special Price!',
            6 => 'SPECIAL PRICING!',
            7 => 'Confirm Availability',
            8 => 'Exclusive Price',
            9 => 'Get Exclusive Price',
            10 => 'Request Information',
            11 => 'Get Info',
            12 => 'Need help?',
            13 => 'Consultation',
            14 => 'E-Price!',
          ),
        ),
      ),
      'styles' => 
      array (
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#00A84E,#00A84E)',
            'border-color' => '00A84E',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#0C5B08,#0C5B08)',
            'border-color' => '0C5B08',
          ),
        ),
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#246491,#246491)',
            'border-color' => '246491',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#163E5B,#163E5B)',
            'border-color' => '163E5B',
          ),
        ),
        'Cyan' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#00ABF1,#00ABF1)',
            'border-color' => '00ABF1',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#0093CF,#0093CF)',
            'border-color' => '0093CF',
          ),
        ),
      ),
    ),
  ),
  'name' => 'macdonaldbuickgmc',
);