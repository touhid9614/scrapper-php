<?php

global $CronConfigs;

$CronConfigs["georgianchevrolet"] = array (
  'bid' => 3.0,
  'password' => 'georgianchevrolet',
  'log' => true,
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'email' => 'regan@smedia.ca',
  'customer_id' => '479-206-4590',
  //'bing_account_id' => 156003034,
  'max_cost' => 500,
  'cost_distribution' => 
  array (
    'adwords' => 500,
  ),
  'create' => 
  array (
  ),
  'new_title2' => 'Get More Information',
  'used_title2' => 'Get More Information',
  'new_descs' => 
  array (
    0 => 
    array (
      'title2' => 'Get More Information',
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'title2' => 'Get More Information',
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model]',
    ),
  ),
  'used_descs' => 
  array (
    0 => 
    array (
      'title2' => 'Get More Information',
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'title2' => 'Get More Information',
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model]',
    ),
  ),
  'banner' => 
  array (
    'template' => 'georgianchevrolet',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information.',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info to get an additional $200 off your purchase PLUS any other GM Incentives you qualify for, and a product specialist will be in touch to aid in any questions.',
    'flash_style' => 'default',
    'hst' => true,
    'border_color' => '#282828',
    'styels' => 
    array (
      'new_display' => 'custom_banner',
      'used_display' => 'custom_banner',
      'new_retargeting' => 'custom_banner',
      'used_retargeting' => 'custom_banner',
      'new_marketbuyers' => 'custom_banner',
      'used_marketbuyers' => 'custom_banner',
    ),
    'font_color' => '#ffffff',
  ),
  // 'adf_to' => 
  // array (
  //   0 => 'leads@georgiancbg.ca',
  // ),
  // 'form_live' => true,
  // 'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
  // 'buttons_live' => true,
  // 'buttons' => 
  // array (
  //   'request-a-quote' => 
  //   array (
  //     'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-/i',
  //     'target' => NULL,
  //     'locations' => 
  //     array (
  //       'default' => NULL,
  //     ),
  //     'action-target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
  //     'css-class' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]',
  //     'css-hover' => 'a[name="a303d7ab-332d-4afe-9bab-91658fa4be0d"]:hover',
  //     'button_action' => 
  //     array (
  //       0 => 'form',
  //       1 => 'e-price',
  //     ),
  //     'sizes' => 
  //     array (
  //       100 => 
  //       array (
  //         'font-size' => '1.4rem',
  //       ),
  //     ),
  //     'texts' => 
  //     array (
  //       'request-a-quote' => 
  //       array (
  //         'target' => 'a[name=a303d7ab-332d-4afe-9bab-91658fa4be0d]',
  //         'values' => 
  //         array (
  //           0 => 'Get More Information',
  //           1 => 'Confirm Availability',
  //           2 => 'Find out More',
  //           3 => 'Get a Quote',
  //           4 => 'Confirm Availability',
  //           5 => 'Get Vehicle Details',
  //           6 => 'Ask us a Question',
  //           7 => 'Get more details',
  //           8 => 'Check Availability',
  //           9 => 'Get More Information',
  //         ),
  //       ),
  //     ),
  //     'styles' => 
  //     array (
  //       'green' => 
  //       array (
  //         'normal' => 
  //         array (
  //           'background' => 'linear-gradient(#1CB80C,#1CB80C)',
  //           'border-color' => '24EB0F',
  //           'color' => '#fff',
  //         ),
  //         'hover' => 
  //         array (
  //           'background' => 'linear-gradient(#10AB00,#10AB00)',
  //           'border-color' => '10AB00',
  //           'color' => '#fff',
  //         ),
  //       ),
  //       'blue' => 
  //       array (
  //         'normal' => 
  //         array (
  //           'background' => 'linear-gradient(#1A8CD8,#1A8CD8)',
  //           'border-color' => '1A8CD8',
  //           'color' => '#fff',
  //         ),
  //         'hover' => 
  //         array (
  //           'background' => 'linear-gradient(#0478C3,#0478C3)',
  //           'border-color' => '0478C3',
  //           'color' => '#fff',
  //         ),
  //       ),
  //       'orange' => 
  //       array (
  //         'normal' => 
  //         array (
  //           'background' => 'linear-gradient(#FF5F19,#FF5F19)',
  //           'border-color' => 'FF9611',
  //           'color' => '#fff',
  //         ),
  //         'hover' => 
  //         array (
  //           'background' => 'linear-gradient(#D17500,#D17500)',
  //           'border-color' => 'D17500',
  //           'color' => '#fff',
  //         ),
  //       ),
  //       'red' => 
  //       array (
  //         'normal' => 
  //         array (
  //           'background' => 'linear-gradient(#EB101A,#EB101A)',
  //           'border-color' => 'FD111C',
  //           'color' => '#fff',
  //         ),
  //         'hover' => 
  //         array (
  //           'background' => 'linear-gradient(#CE000A,#CE000A)',
  //           'border-color' => 'CE000A',
  //           'color' => '#fff',
  //         ),
  //       ),
  //     ),
  //   ),
  //   'test-drive' => 
  //   array (
  //     'url-match' => '/\\/VehicleDetails\\/(?:new|used|certified)-/i',
  //     'target' => NULL,
  //     'locations' => 
  //     array (
  //       'default' => NULL,
  //     ),
  //     'action-target' => 'a[name="a43fde86-2a68-4c95-8416-a15488307a7c"]',
  //     'css-class' => 'a[name="a43fde86-2a68-4c95-8416-a15488307a7c"]',
  //     'css-hover' => 'a[name="a43fde86-2a68-4c95-8416-a15488307a7c"]:hover',
  //     'button_action' => 
  //     array (
  //       0 => 'form',
  //       1 => 'test-drive',
  //     ),
  //     'sizes' => 
  //     array (
  //       100 => 
  //       array (
  //         'font-size' => '1.4rem',
  //       ),
  //     ),
  //     'texts' => 
  //     array (
  //       'test-drive' => 
  //       array (
  //         'target' => 'a[name="a43fde86-2a68-4c95-8416-a15488307a7c"]',
  //         'values' => 
  //         array (
  //           0 => 'Test Drive Today',
  //           1 => 'Book My Test Drive',
  //           2 => 'Schedule Your Test Drive',
  //           3 => 'Test Drive It!',
  //           4 => 'Book Your Test Drive',
  //         ),
  //       ),
  //     ),
  //     'styles' => 
  //     array (
  //       'red' => 
  //       array (
  //         'normal' => 
  //         array (
  //           'background' => 'linear-gradient(#EB101A,#EB101A)',
  //           'border-color' => 'FD111C',
  //           'color' => '#fff',
  //         ),
  //         'hover' => 
  //         array (
  //           'background' => 'linear-gradient(#CE000A,#CE000A)',
  //           'border-color' => 'CE000A',
  //           'color' => '#fff',
  //         ),
  //       ),
  //       'orange' => 
  //       array (
  //         'normal' => 
  //         array (
  //           'background' => 'linear-gradient(#FF5F19,#FF5F19)',
  //           'border-color' => 'FF9611',
  //           'color' => '#fff',
  //         ),
  //         'hover' => 
  //         array (
  //           'background' => 'linear-gradient(#D17500,#D17500)',
  //           'border-color' => 'D17500',
  //           'color' => '#fff',
  //         ),
  //       ),
  //       'green' => 
  //       array (
  //         'normal' => 
  //         array (
  //           'background' => 'linear-gradient(#1CB80C,#1CB80C)',
  //           'border-color' => '24EB0F',
  //           'color' => '#fff',
  //         ),
  //         'hover' => 
  //         array (
  //           'background' => 'linear-gradient(#10AB00,#10AB00)',
  //           'border-color' => '10AB00',
  //           'color' => '#fff',
  //         ),
  //       ),
  //       'blue' => 
  //       array (
  //         'normal' => 
  //         array (
  //           'background' => 'linear-gradient(#1A8CD8,#1A8CD8)',
  //           'border-color' => '1A8CD8',
  //           'color' => '#fff',
  //         ),
  //         'hover' => 
  //         array (
  //           'background' => 'linear-gradient(#0478C3,#0478C3)',
  //           'border-color' => '0478C3',
  //           'color' => '#fff',
  //         ),
  //       ),
  //     ),
  //   ),
  // ),
  'name' => 'georgianchevrolet',
);