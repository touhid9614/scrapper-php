<?php

global $CronConfigs;

$CronConfigs["provincialchrysler"] = array(
  'password' => 'provincialchrysler',
  'bid' => 3.0,
  'log' => true,
  'bid_modifier' =>
  array(
    'after' => 45,
    'bid' => 1.5,
  ),
  'email' => 'regan@smedia.ca',
  'lead' =>
  array(
    'live' => false,
    'lead_type_' => true,
    'lead_type_new' => true,
    'lead_type_used' => true,
    'bg_color' => '#efefef',
    'text_color' => '#404450',
    'border_color' => '#e5e5e5',
    'button_color' =>
    array(
      '#bd0000',
      '#800000',
    ),
    'button_color_hover' =>
    array(
      '#b00000',
      '#700000',
    ),
    'button_color_active' =>
    array(
      '#700000',
      '#b00000',
    ),
    'button_text_color' => '#ffffff',
    'response_email_subject' => 'Your offer from [dealership]',
    'response_email' => 'Hello [name],<p> Thanks for signing up for our offer Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Titan Auto Team',
    'forward_to' =>
    array(
      'internet@provincialchrysler.com',
      'rrobinet@provincialchrysler.com',
      'jskelton@provincialchrysler.com',
      'sprovost@provincialchrysler.com',
      '_lead.C5183@easydealmail.ca',
      'shuhan@smedia.ca',
    ),
    'respond_from' => 'offers@mail.smedia.ca',
    'forward_from' => 'offers@mail.smedia.ca',
    'forward_email_subject' => '#[monthly_count] Smedia Coupon Lead.',
    'special_type' => 'application/x-adf+xml',
    'special_to' =>
    array(
      '_lead.C5183@easydealmail.ca',
      'internet@provincialchrysler.com',
      'rrobinet@provincialchrysler.com',
      'jskelton@provincialchrysler.com',
      'sprovost@provincialchrysler.com',
      'shuhan@smedia.ca',
    ),
    'special_email' => '<?xml version="1.0" encoding="UTF-8"?>
                                    <?adf version="1.0"?>
                                    <adf>
                                        <prospect>
                                            <id sequence="[total_count]" source="Provincial Chrysler"></id>
                                            <requestdate>[fdt]</requestdate>
                                            <vehicle interest="buy" status="[stock_type]">
                                                <year>[year]</year>
                                                <make>[make]</make>
                                                <model>[model]</model>
                                                <stock>[stock_number]</stock>
                                            </vehicle>

                                           <customer>
                                               <contact>
                                                    <name part="full">[name]</name>
                                                    <email>[email]</email>
                                                    <phone>[phone]</phone>
                                                </contact>
                                           </customer>

                                            <vendor>
                                                <contact>
                                                    <name part="full">Provincial Chrysler</name>
                                                    <email>[dealer_email]</email>
                                                </contact>
                                            </vendor>
                                            <provider>
                                                <name part="full">sMedia</name>
                                                <url>https://smedia.ca</url>
                                                <email>offers@mail.smedia.ca</email>
                                                <phone>855-775-0062</phone>
                                            </provider>
                                        </prospect>
                                    </adf>',
    'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    'lead_in' =>
    array(
      'vdp' => '/\\.com\\/auto\\/(?:used|new)-/i',
      'service_regex' => '',
    ),
  ),
  'max_cost' => 0,
  'create' =>
  array(),
  'post_code' => 'N8W 5V9',
  'new_descs' =>
  array(
    
    array(
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    
    array(
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'used_descs' =>
  array(
    
    array(
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    
    array(
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'options_descs' =>
  array(
    
    array(
      'desc1' => 'Equipped with [option]',
      'desc2' => 'and [option]',
    ),
  ),
  'ymmcount_descs' =>
  array(
    
    array(
      'desc1' => 'We have [ymmcount] [make]',
      'desc2' => '[model] in stock',
    ),
  ),
  'customer_id' => '504-774-5373',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'banner' =>
  array(
    'template' => 'provincialchrysler',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]. Click for more information.',
    'flash_style' => 'default',
    'hst' => true,
    'border_color' => '#7e7e7e',
    'styels' =>
    array(
      'new_display' => 'custom_banner',
      'used_display' => 'custom_banner',
      'new_retargeting' => 'custom_banner',
      'used_retargeting' => 'custom_banner',
      'new_marketbuyers' => 'custom_banner',
      'used_marketbuyers' => 'custom_banner',
    ),
    'font_color' => '#ffffff',
  ),
  'phone_domelement' => 'document.getElementsByClassName("phone-large")[0]',
  'phone_regex' => '/[0-9]\\s\\([0-9]{3}\\)\\s[0-9]{3}\\-[0-9]{4}/',
  'new_phone' => '1-888-203-2095',
  'adf_to' =>
  array(
    'leads@provincialchrysler.com',
  ),
  'form_live' => true,
  'buttons_live' => true,
  'buttons' =>
  array(
    'test-drive' =>
    array(
      'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
      'target' => NULL,
      'locations' =>
      array(
        'default' => NULL,
      ),
      'action-target' => 'a[href*=schedule-form].btn',
      'css-class' => 'a[href*=schedule-form].btn',
      'css-hover' => 'a[href*=schedule-form].btn:hover',
      'button_action' =>
      array(
        'form',
        'test-drive',
      ),
      'sizes' =>
      array(
        10
        array(),
      ),
      'texts' =>
      array(
        'test-drive' =>
        array(
          'target' => 'a[href*=schedule-form].btn',
          'values' =>
          array(
            'Schedule My Visit',
            'Test Drive',
            'Request A Test Drive',
            'Want to Test Drive It?',
          ),
        ),
      ),
      'styles' =>
      array(
        'orange' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#D47000,#D47000)',
            'border-color' => 'D47000',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#CF540E,#CF540E)',
            'border-color' => 'CF540E',
          ),
        ),
        'red' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#C3002F,#C3002F)',
            'border-color' => 'C3002F',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#C60C0D,#C60C0D)',
            'border-color' => 'C60C0D',
          ),
        ),
        'green' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#389700,#389700)',
            'border-color' => '389700',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#359D22,#359D22)',
            'border-color' => '359D22',
          ),
        ),
        'blue' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#065F86,#065F86)',
            'border-color' => '065F86',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#188BB7,#188BB7)',
            'border-color' => '188BB7',
          ),
        ),
        'Platinum' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#B9B099,#B9B099)',
            'border-color' => '065F86',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#ABA085,#ABA085)',
            'border-color' => '188BB7',
          ),
        ),
        'Black' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#333333,#333333)',
            'border-color' => '065F86',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => '188BB7',
          ),
        ),
        'Cyan' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#00ABF1,#00ABF1)',
            'border-color' => '065F86',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#0093CF,#0093CF)',
            'border-color' => '188BB7',
          ),
        ),
      ),
    ),
    'request-information' =>
    array(
      'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
      'target' => NULL,
      'locations' =>
      array(
        'default' => NULL,
      ),
      'action-target' => '.btn.btn-default.mycars-btn.mycars-add-alert-btn.btn-no-decoration.medium',
      'css-class' => '.btn.btn-default.mycars-btn.mycars-add-alert-btn.btn-no-decoration.medium',
      'css-hover' => '.btn.btn-default.mycars-btn.mycars-add-alert-btn.btn-no-decoration.medium:hover',
      'button_action' =>
      array(
        'form',
        'e-price',
      ),
      'sizes' =>
      array(
        10
        array(),
      ),
      'texts' =>
      array(
        'request-information' =>
        array(
          'target' => '.btn.btn-default.mycars-btn.mycars-add-alert-btn.btn-no-decoration.medium',
          'values' =>
          array(
            'Get More Information',
            'Get More Info',
            'Ask a Question',
            'Learn More',
          ),
        ),
      ),
      'styles' =>
      array(
        'orange' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#D47000,#D47000)',
            'border-color' => 'D47000',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#CF540E,#CF540E)',
            'border-color' => 'CF540E',
            'color' => '#fff',
          ),
        ),
        'red' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#C3002F,#C3002F)',
            'border-color' => 'C3002F',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#C60C0D,#C60C0D)',
            'border-color' => 'C60C0D',
            'color' => '#fff',
          ),
        ),
        'green' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#389700,#389700)',
            'border-color' => '389700',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#359D22,#359D22)',
            'border-color' => '359D22',
            'color' => '#fff',
          ),
        ),
        'blue' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#065F86,#065F86)',
            'border-color' => '065F86',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#188BB7,#188BB7)',
            'border-color' => '188BB7',
            'color' => '#fff',
          ),
        ),
        'Platinum' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#B9B099,#B9B099)',
            'border-color' => '065F86',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#ABA085,#ABA085)',
            'border-color' => '188BB7',
            'color' => '#fff',
          ),
        ),
        'Black' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#333333,#333333)',
            'border-color' => '065F86',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#000000,#000000)',
            'border-color' => '188BB7',
            'color' => '#fff',
          ),
        ),
        'Cyan' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#00ABF1,#00ABF1)',
            'border-color' => '065F86',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#0093CF,#0093CF)',
            'border-color' => '188BB7',
            'color' => '#fff',
          ),
        ),
      ),
    ),
  ),
  'cost_distribution' =>
  array(
    'new' => 0,
    'used' => 0,
  ),
  'name' => 'provincialchrysler',
);
