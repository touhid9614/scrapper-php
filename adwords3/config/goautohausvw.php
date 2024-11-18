<?php

global $CronConfigs;

$CronConfigs["goautohausvw"] = array(
  'name' => 'goautohausvw',
  'bid' => 3.0,
  'log' => true,
  'password' => 'goautohausvw',
  'bid_modifier' =>
  array(
    'after' => 45,
    'bid' => 1.5,
  ),
  'max_cost' => 0,
  'cost_distribution' =>
  array(
    'new' => 0,
    'used' => 0,
  ),
  'email' => 'regan@smedia.ca',
  'lead' =>
  array(
    'live' => true,
    'lead_type_' => true,
    'lead_type_new' => true,
    'lead_type_used' => true,
    'bg_color' => '#EFEFEF',
    'text_color' => '#404450',
    'border_color' => '#E5E5E5',
    'button_color' =>
    array(
       '#0072BC',
       '#0072BC',
    ),
    'button_color_hover' =>
    array(
       '#F26525',
       '#F26525',
    ),
    'button_color_active' =>
    array(
       '#F26525',
       '#F26525',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => 'Get $200 off coupon with purchase at Auto Haus VW',
    'response_email' => 'Hello [name],<p> Thank you for signing up for this offer! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Auto Haus VW Team',
    'forward_to' =>
    array(
       'marshal@smedia.ca',
    ),
    'special_to' =>
    array(
       'smedia@knightvw.net',
    ),
    'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Auto Haus VW"></id>
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
						<name part="full">Auto Haus VW</name>
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
    'respond_from' => 'offers@mail.smedia.ca',
    'forward_from' => 'offers@mail.smedia.ca',
    'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    'lead_in' =>
    array(
      'vdp' => '/inventory\\/(?:new|used)\\/[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
  'create' =>
  array(),
  'new_descs' =>
  array(
    
    array(
      'desc1' => '[year] [make] [model] ',
      'desc2' => 'only [Price]! Call Today',
    ),
    
    array(
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    
    array(
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model]',
    ),
    
    array(
      'desc1' => '[year] [make] [model] ',
      'desc2' => 'starting at *[biweekly] b/w',
    ),
  ),
  'used_descs' =>
  array(
    
    array(
      'desc1' => '[year] [make] [model] ',
      'desc2' => 'only [Price]! Call Today',
    ),
    
    array(
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    
    array(
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model]',
    ),
    
    array(
      'desc1' => '[year] [make] [model] ',
      'desc2' => 'starting at *[biweekly] b/w',
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
  'customer_id' => '940-201-6964',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'banner' =>
  array(
    'template' => 'goautohausvw',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more information.',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'fb_dynamiclead_description' => 'Are you still interested in [year] [make] [model]? Click below and fill in your information to get $500 off your purchase. A product specialist will get in touch to help.',
    'flash_style' => 'default',
    'border_color' => '#000',
    'styels' =>
    array(
      'new_display' => 'dynamic_banner',
      'used_display' => 'custom_banner',
      'new_retargeting' => 'dynamic_banner',
      'used_retargeting' => 'custom_banner',
      'new_combined' => 'dynamic_banner',
      'used_combined' => 'custom_banner',
    ),
    'font_color' => '#ffffff',
  ),
  'buttons_live' => true,
  'buttons' =>
  array(
    'request-information' =>
    array(
      'url-match' => '/\\/inventory\\/(?:new|used|certified)\\/[0-9]{4}-/i',
      'target' => NULL,
      'locations' =>
      array(
        'default' => NULL,
      ),
      'action-target' => 'a#accordion_one_button',
      'css-class' => 'a#accordion_one_button',
      'css-hover' => 'a#accordion_one_button:hover',
      'sizes' =>
      array(
        100 =>
        array(),
      ),
      'texts' =>
      array(
        'request-information' =>
        array(
          'target' => 'a#accordion_one_button',
          'values' =>
          array(
             'Get Current Market Price',
             'Get Special Price Today',
             'Get Your Exclusive Price',
             'Get Price Updates',
             'Get Local Pricing',
             'Get Best Price',
             'Get Internet Price',
             'Get Special Price!',
             'Ask Question',
             'More Info',
             'Learn More',
             'Ask More Info',
             'Ask an Expert',
             'Get More Details',
             'E-Price',
             'Get E-Price',
             'Exclusive Price',
             'Your Price',
          ),
        ),
      ),
      'styles' =>
      array(
        'orange' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#EC7733,#EC7733)',
            'border-color' => 'F06B20',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#D46B2F,#D46B2F)',
            'border-color' => 'CF540E',
          ),
        ),
        'red' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#C82D20,#C82D20)',
            'border-color' => 'E01212',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#AD281C,#AD281C)',
            'border-color' => 'C60C0D',
          ),
        ),
        'blue' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#0099DA,#0099DA)',
            'border-color' => 'E01212',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#0086BF,#0086BF)',
            'border-color' => 'C60C0D',
          ),
        ),
      ),
    ),
  ),
);
