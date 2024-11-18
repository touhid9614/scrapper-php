<?php

global $CronConfigs;

$CronConfigs["bobschwartzchryslerdodgejeep"] = array (
  'password' => 'bobschwartzchryslerdodgejeep',
  'email' => 'regan@smedia.ca',
  'log' => true,
  'max_cost' => 1200.0,
  'cost_distribution' => 
  array (
    'adwords' => 1200,
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
      'desc2' => '[year] [make] [model] today',
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
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'lead' => 
  array (
    'live' => false,
    'lead_type_' => true,
    'lead_type_new' => true,
    'lead_type_used' => true,
    'bg_color' => '#efefef',
    'text_color' => '#404450',
    'border_color' => '#e5e5e5',
    'button_color' => 
    array (
       '#fac703',
       '#fac703',
    ),
    'button_color_hover' => 
    array (
       '#e1a504',
       '#e1a504',
    ),
    'button_color_active' => 
    array (
       '#e1a504',
       '#e1a504',
    ),
    'button_text_color' => '#ffffff',
    'response_email_subject' => 'Get an extra $500 for your trade from Bob Schwartz Chrysler Dodge',
    'response_email' => 'Hello [name],<p> Thank you for booking a test drive! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Bob Schwartz Chrysler Dodge',
    'forward_to' => 
    array (
       'leads@bobschwartzcdj.motosnap.com',
       'sarahpayne@bobschwatzcdj.com',
       'marshal@smedia.ca',
    ),
    'respond_from' => 'offers@mail.smedia.ca',
    'forward_from' => 'offers@mail.smedia.ca',
    'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    'lead_in' => 
    array (
      'vdp' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
  'customer_id' => '652-735-5986',
  'banner' => 
  array (
    'template' => 'bobschwartzchryslerdodgejeep',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click below for more info!',
    'flash_style' => 'default',
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
  'lead_to' => 
  array (
     'sarahpayne@schwartzcdj.com',
  ),
  'adf_to' => 
  array (
     'leads@bobschwartzcdj.motosnap.com',
  ),
  'form_live' => true,
  'buttons_live' => true,
  'buttons' => 
  array (
    'request-a-quote' => 
    array (
      'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a.btn.eprice.dialog.epriceLink',
      'css-class' => 'a.btn.eprice.dialog.epriceLink',
      'css-hover' => 'a.btn.eprice.dialog.epriceLink:hover',
      'button_action' => 
      array (
         'form',
         'e-price',
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
          'target' => 'a.btn.eprice.dialog.epriceLink',
          'values' => 
          array (
             'Request A Quote',
             'Get E Price Now!',
             'Internet Price',
             'Get your Price!',
             'E- Price',
             'Get Internet Price Now!',
             'Get Our Best Price',
             'Best Price',
             'Local Pricing',
             'Special Pricing!',
             'Get Active Market Price',
             'Get Market Price',
             'Market Pricing',
          ),
        ),
      ),
      'styles' => 
      array (
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'none',
            'background-color' => '#f06b20',
            'border-color' => '#f06b20',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
          'hover' => 
          array (
            'background' => 'none',
            'background-color' => '#cf540e',
            'border-color' => '#cf540e',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
        ),
        'red' => 
        array (
          'normal' => 
          array (
            'background' => 'none',
            'background-color' => '#e01212',
            'border-color' => '#e01212',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
          'hover' => 
          array (
            'background' => 'none',
            'background-color' => '#c60c0d',
            'border-color' => '#c60c0d',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'none',
            'background-color' => '#54b740',
            'border-color' => '#54b740',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
          'hover' => 
          array (
            'background' => 'none',
            'background-color' => '#359d22',
            'border-color' => '#359d22',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
        ),
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'none',
            'background-color' => '#1ca0d1',
            'border-color' => '#1ca0d1',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
          'hover' => 
          array (
            'background' => 'none',
            'background-color' => '#188bb7',
            'border-color' => '#188bb7',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
        ),
      ),
    ),
    'request-information' => 
    array (
      'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a.btn.price-btn.btn-block.priceButton-1',
      'css-class' => 'a.btn.price-btn.btn-block.priceButton-1',
      'css-hover' => 'a.btn.price-btn.btn-block.priceButton-1:hover',
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
          'target' => 'a.btn.price-btn.btn-block.priceButton-1',
          'values' => 
          array (
             'Get More Information',
             'Request Information',
             'Contact Us.',
             'Contact Us',
             'Contact Store',
             'Book Test Drive',
             'Get More Information',
             'Ask a Question',
             'Inquire Now',
          ),
        ),
      ),
      'styles' => 
      array (
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'none',
            'background-color' => '#f06b20',
            'border-color' => '#f06b20',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
          'hover' => 
          array (
            'background' => 'none',
            'background-color' => '#cf540e',
            'border-color' => '#cf540e',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
        ),
        'red' => 
        array (
          'normal' => 
          array (
            'background' => 'none',
            'background-color' => '#e01212',
            'border-color' => '#e01212',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
          'hover' => 
          array (
            'background' => 'none',
            'background-color' => '#c60c0d',
            'border-color' => '#c60c0d',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'none',
            'background-color' => '#54b740',
            'border-color' => '#54b740',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
          'hover' => 
          array (
            'background' => 'none',
            'background-color' => '#359d22',
            'border-color' => '#359d22',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
        ),
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'none',
            'background-color' => '#1ca0d1',
            'border-color' => '#1ca0d1',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
          'hover' => 
          array (
            'background' => 'none',
            'background-color' => '#188bb7',
            'border-color' => '#188bb7',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
        ),
      ),
    ),
    'financing' => 
    array (
      'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
      'target' => NULL,
      'locations' => 
      array (
        'default' => NULL,
      ),
      'action-target' => 'a.btn.price-btn.btn-block.priceButton-2',
      'css-class' => 'a.btn.price-btn.btn-block.priceButton-2',
      'css-hover' => 'a.btn.price-btn.btn-block.priceButton-2:hover',
      'button_action' => 
      array (
         'form',
         'finance',
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
          'target' => 'a.btn.price-btn.btn-block.priceButton-2',
          'values' => 
          array (
             'No Hassle Financing',
             'Financing Available',
             'Get Financed Today',
             'Explore Payments',
             'Get Pre-Approved',
          ),
        ),
      ),
      'styles' => 
      array (
        'orange' => 
        array (
          'normal' => 
          array (
            'background' => 'none',
            'background-color' => '#f06b20',
            'border-color' => '#f06b20',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
          'hover' => 
          array (
            'background' => 'none',
            'background-color' => '#cf540e',
            'border-color' => '#cf540e',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
        ),
        'red' => 
        array (
          'normal' => 
          array (
            'background' => 'none',
            'background-color' => '#e01212',
            'border-color' => '#e01212',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
          'hover' => 
          array (
            'background' => 'none',
            'background-color' => '#c60c0d',
            'border-color' => '#c60c0d',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
        ),
        'green' => 
        array (
          'normal' => 
          array (
            'background' => 'none',
            'background-color' => '#54b740',
            'border-color' => '#54b740',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
          'hover' => 
          array (
            'background' => 'none',
            'background-color' => '#359d22',
            'border-color' => '#359d22',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
        ),
        'blue' => 
        array (
          'normal' => 
          array (
            'background' => 'none',
            'background-color' => '#1ca0d1',
            'border-color' => '#1ca0d1',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
          'hover' => 
          array (
            'background' => 'none',
            'background-color' => '#188bb7',
            'border-color' => '#188bb7',
            'color' => '#fff',
            'display' => 'block',
            'float' => 'none',
            'font-family' => 'Raleway, arial, sans-serif',
            'font-size' => '14px',
            'font-weight' => '700',
            'line-height' => '17px',
            'margin' => '10px 0 0',
            'padding' => '9px 10px',
            'position' => 'relative',
            'text-align' => 'center',
            'text-decoration' => 'none',
          ),
        ),
      ),
    ),
  ),
  'name' => 'bobschwartzchryslerdodgejeep',
);