<?php

global $CronConfigs;

$CronConfigs["minicalgaryca"] = array (
  'name' => 'minicalgaryca',
  'email' => 'regan@smedia.ca',
  'password' => 'minicalgaryca',
  'log' => true,
  'banner' => 
  array (
    'template' => 'minicalgaryca',
    'fb_title' => '[year] [make] [model] [price] +GST & LIC',
      'fb_aia_description'       => 'Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? You can buy a car from home. Learn more about our Dilawri Anywhere program.',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today. You can buy it from home. Learn more about our Dilawri Anywhere program.',
    'fb_dynamiclead_description' => 'Are you still interested in [Year] [Make] [Model]? Click below and fill in your information to get our best price.',
    'flash_style' => 'default',
    'fb_style' => 'northwestmini',
  ),
  'fillup_redirect_url' => 'https://www.minicalgary.ca/en/thank-you?formId=19',
  'buttons' => 
  array (
    'request-a-quote' => 
    array (
      'url-match' => '/\/(?:new|certified|used)-inventory\/[^\/]+\/[^\/]+\/[0-9]{4}/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'div.inventory-details-title__ctas.show-for-large a.link__alpha.link__alpha-primary',
      'css-class' => 'div.inventory-details-title__ctas.show-for-large a.link__alpha.link__alpha-primary',
      'css-hover' => 'div.inventory-details-title__ctas.show-for-large a.link__alpha.link__alpha-primary:hover',
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
          'target' => 'div.inventory-details-title__ctas.show-for-large a.link__alpha.link__alpha-primary',
          'values' => 
          array (
            0 => 'RESERVE NOW',
          ),
        ),
      ),
      'styles' => 
      array (
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#184D7F,#184D7F)',
            'border-color' => '184D7F',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#123E65,#123E65)',
            'border-color' => '123E65',
            'color' => '#fff',
          ),
        ),
        'red' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C21116,#C21116)',
            'border-color' => 'C21116',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
            'border-color' => '9D0A0E',
            'color' => '#fff',
          ),
        ),
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C47C18,#C47C18)',
            'border-color' => 'C47C18',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#A96B14,#A96B14)',
            'border-color' => 'A96B14',
            'color' => '#fff',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#31A413,#31A413)',
            'border-color' => '31A413',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#288A0F,#288A0F)',
            'border-color' => '288A0F',
            'color' => '#fff',
          ),
        ),
        'light-blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#0C9DDA,#0C9DDA)',
            'border-color' => '0C9DDA',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
        'grey' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#B4B4B4,#B4B4B4)',
            'border-color' => 'B4B4B4',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
        'black' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#111111,#111111)',
            'border-color' => '111111',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
      ),
    ),
    'next-step' => 
    array (
      'url-match' => '/\/(?:new|certified|used)-inventory\/[^\/]+\/[^\/]+\/[0-9]{4}/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a[data-open="getStarted-vdp"]',
      'css-class' => 'a[data-open="getStarted-vdp"]',
      'css-hover' => 'a[data-open="getStarted-vdp"]:hover',
      'sizes' => 
      array (
        100 => 
        array (
        ),
      ),
      'texts' => 
      array (
        'next-step' => 
        array (
          'target' => 'a[data-open="getStarted-vdp"]',
          'values' => 
          array (
            0 => 'NEXT STEPS',
          ),
        ),
      ),
      'styles' => 
      array (
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#184D7F,#184D7F)',
            'border-color' => '184D7F',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#123E65,#123E65)',
            'border-color' => '123E65',
            'color' => '#fff',
          ),
        ),
        'red' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C21116,#C21116)',
            'border-color' => 'C21116',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
            'border-color' => '9D0A0E',
            'color' => '#fff',
          ),
        ),
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C47C18,#C47C18)',
            'border-color' => 'C47C18',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#A96B14,#A96B14)',
            'border-color' => 'A96B14',
            'color' => '#fff',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#31A413,#31A413)',
            'border-color' => '31A413',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#288A0F,#288A0F)',
            'border-color' => '288A0F',
            'color' => '#fff',
          ),
        ),
        'light-blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#0C9DDA,#0C9DDA)',
            'border-color' => '0C9DDA',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
        'grey' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#B4B4B4,#B4B4B4)',
            'border-color' => 'B4B4B4',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
        'black' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#111111,#111111)',
            'border-color' => '111111',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
      ),
    ),
    'add-to-garage' => 
    array (
      'url-match' => '/\/(?:new|certified|used)-inventory\/[^\/]+\/[^\/]+\/[0-9]{4}/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a[data-theme-style="btnGhostSecondary"]',
      'css-class' => 'a[data-theme-style="btnGhostSecondary"]',
      'css-hover' => 'a[data-theme-style="btnGhostSecondary"]:hover',
      'sizes' => 
      array (
        100 => 
        array (
        ),
      ),
      'texts' => 
      array (
        'add-to-garage' => 
        array (
          'target' => 'a[data-theme-style="btnGhostSecondary"]',
          'values' => 
          array (
            0 => 'ADD TO MY GARAGE',
          ),
        ),
      ),
      'styles' => 
      array (
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#184D7F,#184D7F)',
            'border-color' => '184D7F',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#123E65,#123E65)',
            'border-color' => '123E65',
            'color' => '#fff',
          ),
        ),
        'red' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C21116,#C21116)',
            'border-color' => 'C21116',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
            'border-color' => '9D0A0E',
            'color' => '#fff',
          ),
        ),
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C47C18,#C47C18)',
            'border-color' => 'C47C18',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#A96B14,#A96B14)',
            'border-color' => 'A96B14',
            'color' => '#fff',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#31A413,#31A413)',
            'border-color' => '31A413',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#288A0F,#288A0F)',
            'border-color' => '288A0F',
            'color' => '#fff',
          ),
        ),
        'light-blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#0C9DDA,#0C9DDA)',
            'border-color' => '0C9DDA',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
        'grey' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#B4B4B4,#B4B4B4)',
            'border-color' => 'B4B4B4',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
        'black' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#111111,#111111)',
            'border-color' => '111111',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
      ),
    ),
    'request-information' => 
    array (
      'url-match' => '/\/(?:new|certified|used)-inventory\/[^\/]+\/[^\/]+\/[0-9]{4}/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a[href*="/en/form/contact-us"]',
      'css-class' => 'nothing',
      'css-hover' => 'nothing',
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
        'request-information' => 
        array (
          'target' => '#getStarted-vdp a[href*="/en/form/contact-us"] div div:nth-of-type(2)',
          'values' => 
          array (
            0 => 'Ask Question!',
            1 => 'More Info',
            2 => 'Learn More',
            3 => 'Ask More Info',
            4 => 'Ask an Expert',
            5 => 'Get More Details',
          ),
        ),
      ),
      'styles' => 
      array (
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#184D7F,#184D7F)',
            'border-color' => '184D7F',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#123E65,#123E65)',
            'color' => '#fff',
            'border-color' => '123E65',
          ),
        ),
        'red' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C21116,#C21116)',
            'border-color' => 'C21116',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
            'border-color' => '9D0A0E',
            'color' => '#fff',
          ),
        ),
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C47C18,#C47C18)',
            'border-color' => 'C47C18',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#A96B14,#A96B14)',
            'border-color' => 'A96B14',
            'color' => '#fff',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#31A413,#31A413)',
            'border-color' => '31A413',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#288A0F,#288A0F)',
            'border-color' => '288A0F',
            'color' => '#fff',
          ),
        ),
        'light-blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#0C9DDA,#0C9DDA)',
            'border-color' => '0C9DDA',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
        'grey' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#B4B4B4,#B4B4B4)',
            'border-color' => 'B4B4B4',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
        'black' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#111111,#111111)',
            'border-color' => '111111',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
      ),
    ),
    'test-drive' => 
    array (
      'url-match' => '/\/(?:new|certified|used)-inventory\/[^\/]+\/[^\/]+\/[0-9]{4}/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a[href*="/en/form/road-test"]',
      'css-class' => 'nothing',
      'css-hover' => 'nothing',
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
          'target' => '#getStarted-vdp a[href*="/en/form/road-test"] div div:nth-of-type(2)',
          'values' => 
          array (
            0 => 'Test drive',
            1 => 'Book Test Drive',
            2 => 'Schedule Test Drive',
            3 => 'Test Drive today',
          ),
        ),
      ),
      'styles' => 
      array (
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#184D7F,#184D7F)',
            'border-color' => '184D7F',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#123E65,#123E65)',
            'color' => '#fff',
            'border-color' => '123E65',
          ),
        ),
        'red' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C21116,#C21116)',
            'border-color' => 'C21116',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
            'border-color' => '9D0A0E',
            'color' => '#fff',
          ),
        ),
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C47C18,#C47C18)',
            'border-color' => 'C47C18',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#A96B14,#A96B14)',
            'border-color' => 'A96B14',
            'color' => '#fff',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#31A413,#31A413)',
            'border-color' => '31A413',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#288A0F,#288A0F)',
            'border-color' => '288A0F',
            'color' => '#fff',
          ),
        ),
        'light-blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#0C9DDA,#0C9DDA)',
            'border-color' => '0C9DDA',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
        'grey' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#B4B4B4,#B4B4B4)',
            'border-color' => 'B4B4B4',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
        'black' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#111111,#111111)',
            'border-color' => '111111',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
      ),
    ),
    'Used trade-in' => 
    array (
      'url-match' => '/\/(?:new|certified|used)-inventory\/[^\/]+\/[^\/]+\/[0-9]{4}/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a[href*="/en/form/trade-in-evaluation"]',
      'css-class' => 'nothing',
      'css-hover' => 'nothing',
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
          'target' => '#getStarted-vdp a[href*="/en/form/trade-in-evaluation"] div div:nth-of-type(2)',
          'values' => 
          array (
            0 => 'Get Trade-In Value',
            1 => 'Trade Offer',
            2 => 'What\'s Your Trade Worth?',
            3 => 'Trade-In Appraisal',
            4 => 'Appraise Your Trade',
            5 => 'We Want Your Car',
            6 => 'We\'ll Buy Your Car',
            7 => 'Evaluate Your Trade In',
          ),
        ),
      ),
      'styles' => 
      array (
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#184D7F,#184D7F)',
            'border-color' => '184D7F',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#123E65,#123E65)',
            'color' => '#fff',
            'border-color' => '123E65',
          ),
        ),
        'red' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C21116,#C21116)',
            'border-color' => 'C21116',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
            'border-color' => '9D0A0E',
            'color' => '#fff',
          ),
        ),
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C47C18,#C47C18)',
            'border-color' => 'C47C18',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#A96B14,#A96B14)',
            'border-color' => 'A96B14',
            'color' => '#fff',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#31A413,#31A413)',
            'border-color' => '31A413',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#288A0F,#288A0F)',
            'border-color' => '288A0F',
            'color' => '#fff',
          ),
        ),
        'light-blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#0C9DDA,#0C9DDA)',
            'border-color' => '0C9DDA',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
        'grey' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#B4B4B4,#B4B4B4)',
            'border-color' => 'B4B4B4',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
        'black' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#111111,#111111)',
            'border-color' => '111111',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
      ),
    ),
    'trade-in' => 
    array (
      'url-match' => '/\/(?:new|certified|used)-inventory\/[^\/]+\/[^\/]+\/[0-9]{4}/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a[href*="/en/form/new-inventory/tradein-appraisal"]',
      'css-class' => 'nothing',
      'css-hover' => 'nothing',
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
          'target' => '#getStarted-vdp a[href*="/en/form/new-inventory/tradein-appraisal"] div div:nth-of-type(2)',
          'values' => 
          array (
            0 => 'Get Trade-In Value',
            1 => 'Trade Offer',
            2 => 'What\'s Your Trade Worth?',
            3 => 'Trade-In Appraisal',
            4 => 'Appraise Your Trade',
            5 => 'We Want Your Car',
            6 => 'We\'ll Buy Your Car',
            7 => 'Evaluate Your Trade In',
          ),
        ),
      ),
      'styles' => 
      array (
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#184D7F,#184D7F)',
            'border-color' => '184D7F',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#123E65,#123E65)',
            'color' => '#fff',
            'border-color' => '123E65',
          ),
        ),
        'red' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C21116,#C21116)',
            'border-color' => 'C21116',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#9D0A0E,#9D0A0E)',
            'border-color' => '9D0A0E',
            'color' => '#fff',
          ),
        ),
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#C47C18,#C47C18)',
            'border-color' => 'C47C18',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#A96B14,#A96B14)',
            'border-color' => 'A96B14',
            'color' => '#fff',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#31A413,#31A413)',
            'border-color' => '31A413',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#288A0F,#288A0F)',
            'border-color' => '288A0F',
            'color' => '#fff',
          ),
        ),
        'light-blue' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#0C9DDA,#0C9DDA)',
            'border-color' => '0C9DDA',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
        'grey' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#B4B4B4,#B4B4B4)',
            'border-color' => 'B4B4B4',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
        'black' => 
        array (
          'normal' => 
          array (
            'background' => 'linear-gradient(#111111,#111111)',
            'border-color' => '111111',
            'color' => '#fff',
          ),
          'hover' => 
          array (
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#fff',
          ),
        ),
      ),
    ),
  ),
);
