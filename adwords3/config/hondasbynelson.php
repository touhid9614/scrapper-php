<?php

global $CronConfigs;

$CronConfigs["hondasbynelson"] = array (
  'password' => 'hondasbynelson',
  'email' => 'regan@smedia.ca',
  'log' => true,
  'no_adv' => true,
  'max_cost' => 5700,
  'bing_account_id' => 156003421,
  'bing_create' => 
  array (
    'new_search' => true,
  ),
  'cost_distribution' => 
  array (
    'adwords' => 5700,
  ),
  'create' => 
  array (
  ),
  'new_descs' => 
  array (
    0 => 
    array (
      'title2' => 'Create Your Deal Online',
      'title3' => 'Nelson Honda',
      'description' => 'Get pricing, specs & financing info on the new [year] [make] [model]',
      'description2' => 'Shop online & create your deal from home',
    ),
    1 => 
    array (
      'title2' => 'Create Your Deal Online',
      'title3' => 'Nelson Honda',
      'description' => 'Get pricing, specs & financing info on the new [year] [make] [model]',
      'description2' => 'Shop online & create your deal from home',
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
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'customer_id' => '914-422-2701',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'banner' => 
  array (
    'template' => 'hondasbynelson',
    'fb_description' => '[year] [make] [model] - Contact us today!',
    'old_price_new' => 'msrp',
    'styels' => 
    array (
      'new_display' => 'dynamic_banner',
      'used_display' => 'dynamic_banner',
      'new_retargeting' => 'dynamic_banner',
      'used_retargeting' => 'dynamic_banner',
      'new_marketbuyers' => 'dynamic_banner',
      'used_marketbuyers' => 'dynamic_banner',
    ),
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'adf_to' => 
  array (
    0 => 'leads@hondasbynelson.net',
  ),
  'form_live' => true,
  'buttons_live' => true,
  'buttons' => 
  array (
    'request-a-quote' => 
    array (
      'url-match' => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
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
            0 => 'Local Pricing',
            1 => 'Best Price',
            2 => 'Get Current Market Price',
            3 => 'Get Details',
            4 => 'Get Internet Price Now',
            5 => 'Get e-price',
            6 => 'Get your Price!',
            7 => 'Confirm Availability',
            8 => 'Get Your Exclusive Price',
          ),
        ),
      ),
      'styles' => 
      array (
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C1801E,#C1801E)',
            'border-color' => 'F06B20',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => 'CF540E',
          ),
        ),
        'red' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#B81D33,#B81D33)',
            'border-color' => 'E01212',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => 'C60C0D',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#3BA41A,#3BA41A)',
            'border-color' => '54B740',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => '359D22',
          ),
        ),
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#1C4C7E,#1C4C7E)',
            'border-color' => '1CA0D1',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => '188BB7',
          ),
        ),
      ),
    ),
    'financing' => 
    array (
      'url-match' => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a.main-cta.vdp-pricebox-cta-button[href*="/get-pre-approved/"]',
      'css-class' => 'a.main-cta.vdp-pricebox-cta-button[href*="/get-pre-approved/"]',
      'css-hover' => 'a.main-cta.vdp-pricebox-cta-button[href*="/get-pre-approved/"]:hover',
      'button_action' => 
      array (
        0 => 'form',
        1 => 'finance',
      ),
      'sizes' => 
      array (
        100 => 
        array (
        ),
      ),
      'texts' => 
      array (
        'financing' => 
        array (
          'target' => 'a.main-cta.vdp-pricebox-cta-button[href*="/get-pre-approved/"]',
          'values' => 
          array (
            0 => 'Get Pre-Approved',
            1 => 'Get Prequalified for Credit',
            2 => 'Financing Available',
            3 => 'No Hassle Financing',
            4 => 'Get Financed Today',
          ),
        ),
      ),
      'styles' => 
      array (
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C1801E,#C1801E)',
            'border-color' => 'F06B20',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => 'CF540E',
            'color' => '#fff',
          ),
        ),
        'red' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#B81D33,#B81D33)',
            'border-color' => 'E01212',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => 'C60C0D',
            'color' => '#fff',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#3BA41A,#3BA41A)',
            'border-color' => '54B740',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => '359D22',
            'color' => '#fff',
          ),
        ),
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#1C4C7E,#1C4C7E)',
            'border-color' => '1CA0D1',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => '188BB7',
            'color' => '#fff',
          ),
        ),
      ),
    ),
    'trade-in' => 
    array (
      'url-match' => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a[href*=trade].btn',
      'css-class' => 'a[href*=trade].btn',
      'css-hover' => 'a[href*=trade].btn:hover',
      'button_action' => 
      array (
        0 => 'form',
        1 => 'trade-in',
      ),
      'sizes' => 
      array (
        100 => 
        array (
        ),
      ),
      'texts' => 
      array (
        'trade-in' => 
        array (
          'target' => 'a[href*=trade].btn',
          'values' => 
          array (
            0 => 'Trade Offer',
            1 => 'What is Your Trade Worth?',
            2 => 'Appraise My Trade',
            3 => 'Value Your Trade',
            4 => 'We Want Your Trade',
          ),
        ),
      ),
      'styles' => 
      array (
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C1801E,#C1801E)',
            'border-color' => 'F06B20',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => 'CF540E',
          ),
        ),
        'red' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#B81D33,#B81D33)',
            'border-color' => 'E01212',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => 'C60C0D',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#3BA41A,#3BA41A)',
            'border-color' => '54B740',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => '359D22',
          ),
        ),
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#1C4C7E,#1C4C7E)',
            'border-color' => '1CA0D1',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => '188BB7',
          ),
        ),
      ),
    ),
    'test-drive' => 
    array (
      'url-match' => '/\\/inventory\\/(?:new|used)-[0-9]{4}-/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a.button.secondary-button.block.di-modal[href*="#modal__gform_7"]',
      'css-class' => 'a.button.secondary-button.block.di-modal[href*="#modal__gform_7"]',
      'css-hover' => 'a.button.secondary-button.block.di-modal[href*="#modal__gform_7"]:hover',
      'button_action' => 
      array (
        0 => 'form',
        1 => 'test-drive',
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
          'target' => 'a.button.secondary-button.block.di-modal[href*="#modal__gform_7"]',
          'values' => 
          array (
            0 => 'Book a Test Drive',
            1 => 'Request Test Drive',
            2 => 'Test Drive Now',
            3 => 'Test Drive Today',
            4 => 'Want to Test Drive?',
            5 => 'Schedule My Visit',
          ),
        ),
      ),
      'styles' => 
      array (
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C1801E,#C1801E)',
            'border-color' => 'F06B20',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => 'CF540E',
          ),
        ),
        'red' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#B81D33,#B81D33)',
            'border-color' => 'E01212',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => 'C60C0D',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#3BA41A,#3BA41A)',
            'border-color' => '54B740',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => '359D22',
          ),
        ),
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#1C4C7E,#1C4C7E)',
            'border-color' => '1CA0D1',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => '188BB7',
          ),
        ),
      ),
    ),
  ),
  'mail_retargeting' => 
  array (
    'enabled' => true,
    'client_id' => '17550',
    'promotion_text' => '$25 VISA GIFT CARD',
    'promotion_color' => '#567DC0',
    'overlay_color' => '#077DBE',
    'overlay_text_colour' => '#FFFFFF',
    'price_color' => '#077DBE',
    'coupon_validity' => '60',
  ),
  'name' => 'hondasbynelson',
);