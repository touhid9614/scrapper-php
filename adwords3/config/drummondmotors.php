<?php

global $CronConfigs;

$CronConfigs["drummondmotors"] = array (
  'name' => 'drummondmotors',
  'email' => 'regan@smedia.ca',
  'password' => 'drummondmotors',
  'log' => true,
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'bing_account_id' => 156002954,
  'customer_id' => '217-956-5962',
  'max_cost' => 0,
  'cost_distribution' => 
  array (
    'adwords' => 0,
  ),
  'create' => 
  array (
  ),
  'new_descs' => 
  array (
     
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
     
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model]',
    ),
  ),
  'used_descs' => 
  array (
     
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
     
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model]',
    ),
  ),
  'banner' => 
  array (
    'template' => 'drummondmotors',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.',
    'flash_style' => 'default',
    'styels' => 
    array (
      'new_display' => 'dynamic_banner',
      'used_display' => 'dynamic_banner',
      'new_retargeting' => 'dynamic_banner',
      'used_retargeting' => 'dynamic_banner',
      'new_marketbuyers' => 'dynamic_banner',
      'used_marketbuyers' => 'dynamic_banner',
    ),
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'lead' => 
  array (
    'service' => 
    array (
      'live' => false,
      'lead_type_' => false,
      'lead_type_new' => false,
      'lead_type_used' => false,
      'lead_type_service' => true,
      'shown_cap' => false,
      'fillup_cap' => false,
      'session_close' => false,
      'device_type' => 
      array (
        'mobile' => true,
        'desktop' => true,
        'tablet' => true,
      ),
      'offer_minimum_price' => 0,
      'offer_maximum_price' => 10000000,
      'bg_color' => '#EFEFEF',
      'text_color' => '#404450',
      'border_color' => '#E5E5E5',
      'button_color' => 
      array (
         '#CD9834',
         '#CD9834',
      ),
      'button_color_hover' => 
      array (
         '#1A1A1A',
         '#1A1A1A',
      ),
      'button_color_active' => 
      array (
         '#FFFFFF',
         '#FFFFFF',
      ),
      'button_text_color' => '#FFFFFF',
      'response_email_subject' => 'Get $150 Instant Discount from Scott Drummond Motors',
      'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Scott Drummond Motors Ltd. Team',
      'forward_to' => 
      array (
         'charlene@drummondmotors.ca
mel.armitage@drummondmotors.ca
marshal@smedia.ca',
      ),
      'special_to' => 
      array (
         'leads@drummondmotors.ca',
      ),
      'special_email' => '',
      'display_after' => 15000,
      'retarget_after' => 5000,
      'fb_retarget_after' => 5000,
      'adword_retarget_after' => 5000,
      'visit_count' => 0,
      'video_smart_offer' => false,
      'video_smart_offer_form' => false,
      'video_url' => '',
      'video_title' => '',
      'video_description' => '',
      'lead_in' => 
      array (
        'vdp' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
        'service_regex' => '/\\/service/i',
      ),
    ),
    'new' => 
    array (
      'live' => false,
      'lead_type_' => true,
      'lead_type_new' => true,
      'lead_type_used' => false,
      'lead_type_service' => false,
      'shown_cap' => false,
      'fillup_cap' => false,
      'session_close' => false,
      'device_type' => 
      array (
        'mobile' => true,
        'desktop' => true,
        'tablet' => true,
      ),
      'offer_minimum_price' => 0,
      'offer_maximum_price' => 10000000,
      'bg_color' => '#EFEFEF',
      'text_color' => '#404450',
      'border_color' => '#E5E5E5',
      'button_color' => 
      array (
         '#CD9834',
         '#CD9834',
      ),
      'button_color_hover' => 
      array (
         '#1A1A1A',
         '#1A1A1A',
      ),
      'button_color_active' => 
      array (
         '#1A1A1A',
         '#1A1A1A',
      ),
      'button_text_color' => '#FFFFFF',
      'response_email_subject' => 'At Scott Drummond, We Bring The Experience To You!',
      'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Scott Drummond Motors Ltd. Team',
      'forward_to' => 
      array (
         'charlene@drummondmotors.ca
mel.armitage@drummondmotors.ca
marshal@smedia.ca',
      ),
      'special_to' => 
      array (
         'leads@drummondmotors.ca',
      ),
      'special_email' => '',
      'display_after' => 30000,
      'retarget_after' => 5000,
      'fb_retarget_after' => 5000,
      'adword_retarget_after' => 5000,
      'visit_count' => 0,
      'video_smart_offer' => false,
      'video_smart_offer_form' => false,
      'video_url' => '',
      'video_title' => '',
      'video_description' => '',
      'lead_in' => 
      array (
        'vdp' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
        'service_regex' => '',
      ),
    ),
    'used' => 
    array (
      'live' => false,
      'lead_type_' => true,
      'lead_type_new' => false,
      'lead_type_used' => true,
      'lead_type_service' => false,
      'shown_cap' => false,
      'fillup_cap' => false,
      'session_close' => false,
      'device_type' => 
      array (
        'mobile' => true,
        'desktop' => true,
        'tablet' => true,
      ),
      'offer_minimum_price' => 0,
      'offer_maximum_price' => 10000000,
      'bg_color' => '#EFEFEF',
      'text_color' => '#404450',
      'border_color' => '#E5E5E5',
      'button_color' => 
      array (
         '#CD9834',
         '#CD9834',
      ),
      'button_color_hover' => 
      array (
         '#1A1A1A',
         '#1A1A1A',
      ),
      'button_color_active' => 
      array (
         '#1A1A1A',
         '#1A1A1A',
      ),
      'button_text_color' => '#FFFFFF',
      'response_email_subject' => 'At Scott Drummond, We Bring The Experience To You!',
      'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Scott Drummond Motors Ltd. Team',
      'forward_to' => 
      array (
         'charlene@drummondmotors.ca
mel.armitage@drummondmotors.ca
marshal@smedia.ca',
      ),
      'special_to' => 
      array (
         'leads@drummondmotors.ca',
      ),
      'special_email' => '',
      'display_after' => 30000,
      'retarget_after' => 5000,
      'fb_retarget_after' => 5000,
      'adword_retarget_after' => 5000,
      'visit_count' => 0,
      'video_smart_offer' => false,
      'video_smart_offer_form' => false,
      'video_url' => '',
      'video_title' => '',
      'video_description' => '',
      'lead_in' => 
      array (
        'vdp' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
        'service_regex' => '',
      ),
    ),
  ),
  'lead_to' => 
  array (
     'leads@drummondmotors.ca',
     'karl.schulz@drummondmotors.ca',
  ),
  'form_live' => true,
  'buttons_live' => true,
  'buttons' => 
  array (
    'Used test-drive' => 
    array (
      'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => '.row.margin-buttons-used.buttons1 div:nth-of-type(3) button',
      'css-class' => '.row.margin-buttons-used.buttons1 div:nth-of-type(3) button',
      'css-hover' => '.row.margin-buttons-used.buttons1 div:nth-of-type(3) button:hover',
      'button_action' => 
      array (
         'form',
         'test-drive',
      ),
      'sizes' => 
      array (
        100 => 
        array (
        ),
      ),
      'texts' => 
      array (
        'test-drive' => 
        array (
          'target' => '.row.margin-buttons-used.buttons1 div:nth-of-type(3) button',
          'values' => 
          array (
             'Schedule a Test Drive',
             'Test Drive Today',
             'Test Drive Now',
             'Want to Test Drive?',
             'Request a Test Drive',
          ),
        ),
      ),
      'styles' => 
      array (
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#FE7C42,#FE7C42)',
            'border-color' => 'F06B20',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#DC6B39,#DC6B39)',
            'border-color' => 'CF540E',
          ),
        ),
        'red' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#E01212,#E01212)',
            'border-color' => 'E01212',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#7A100A,#7A100A)',
            'border-color' => 'C60C0D',
          ),
        ),
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#3E5C78,#3E5C78)',
            'border-color' => '1CA0D1',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#2D4358,#2D4358)',
            'border-color' => '188BB7',
          ),
        ),
        'pink' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#0C3D92,#0C3D92)',
            'border-color' => '1CA0D1',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#083075,#083075)',
            'border-color' => '188BB7',
          ),
        ),
      ),
    ),
    'test-drive' => 
    array (
      'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => '[onclick*=BookATestDrive]',
      'css-class' => '[onclick*=BookATestDrive]',
      'css-hover' => '[onclick*=BookATestDrive]:hover',
      'button_action' => 
      array (
         'form',
         'test-drive',
      ),
      'sizes' => 
      array (
        100 => 
        array (
        ),
      ),
      'texts' => 
      array (
        'test-drive' => 
        array (
          'target' => '[onclick*=BookATestDrive]',
          'values' => 
          array (
             'Schedule a Test Drive',
             'Test Drive Today',
             'Test Drive Now',
             'Want to Test Drive?',
             'Request a Test Drive',
          ),
        ),
      ),
      'styles' => 
      array (
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#FE7C42,#FE7C42)',
            'border-color' => '#f06b20',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#DC6B39,#DC6B39)',
            'border-color' => '#cf540e',
          ),
        ),
        'red' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#E01212,#E01212)',
            'border-color' => '#e01212',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#7A100A,#7A100A)',
            'border-color' => '#c60c0d',
          ),
        ),
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#3E5C78,#3E5C78)',
            'border-color' => '#1ca0d1',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#2D4358,#2D4358)',
            'border-color' => '#188bb7',
          ),
        ),
        'pink' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#0C3D92,#0C3D92)',
            'border-color' => '#1ca0d1',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#083075,#083075)',
            'border-color' => '#188bb7',
          ),
        ),
      ),
    ),
  ),
);