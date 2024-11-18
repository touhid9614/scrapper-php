<?php

global $CronConfigs;

$CronConfigs["foundationsquamishchrysler"] = array(
  'name' => 'foundationsquamishchrysler',
  'email' => 'regan@smedia.ca',
  'password' => 'foundationsquamishchrysler',
  'no_adv' => true,
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'log' => true,
  'banner' =>
  array(
    'template' => 'foundationsquamishchrysler',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'lead' =>
  array(
    'live' => false,
    'lead_type_' => false,
    'lead_type_new' => false,
    'lead_type_used' => false,
    'lead_type_service' => false,
    'shown_cap' => false,
    'fillup_cap' => false,
    'session_close' => false,
    'device_type' =>
    array(
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
    array(
       '#1E4387',
       '#1E4387',
    ),
    'button_color_hover' =>
    array(
       '#1A3972',
       '#1A3972',
    ),
    'button_color_active' =>
    array(
       '#1A3972',
       '#1A3972',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => 'Request a Video Walk-Around of your vehicle of interest',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Foundation Squamish Chrysler Team',
    'forward_to' =>
    array(
       'adamm@foundationauto.com',
       'marshal@smedia.ca',
    ),
    'special_to' =>
    array(
       'leads@foundationsquamish.net',
    ),
    'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Foundation Squamish Chrysler"></id>
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
						<name part="full">Foundation Squamish Chrysler</name>
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
    array(
      'vdp' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
  'lead_to' =>
  array(
     'adamm@foundationauto.com',
     'anthonym@foundationsquamish.com',
     'sales@foundationsquamish.com',
     'daveb@foundationsquamish.com',
  ),
  'form_live' => true,
  'buttons_live' => true,
  'buttons' =>
  array(
    'request-a-quote' =>
    array(
      'url-match' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
      'target' => NULL,
      'locations' =>
      array(
        'default' => NULL,
      ),
      'action-target' => 'a[href*=eprice-form]',
      'css-class' => 'a[href*=eprice-form]',
      'css-hover' => 'a[href*=eprice-form]:hover',
      'button_action' =>
      array(
         'form',
         'e-price',
      ),
      'sizes' =>
      array(
        100 =>
        array(),
      ),
      'texts' =>
      array(
        'request-a-quote' =>
        array(
          'target' => 'a[href*=eprice-form]',
          'values' =>
          array(
             'Get Internet Price',
             'Get Our Best Price',
             'Get Sale Price',
             'Current Market Price',
            'Today\'s Market Price',
            'Get Special Price',
            'Request a Quote',
             'Get a Quote',
            'Inquire Now',
            'Inquire Today',
          ),
        ),
      ),
      'styles' =>
      array(
        'red' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#BF0E0D,#BF0E0D)',
            'border-color' => 'BF0E0D',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#ECF3FA,#ECF3FA)',
            'border-color' => 'D1E2F3',
            'color' => ' #0D65BF',
          ),
        ),
        'green' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#65BF0D,#65BF0D)',
            'border-color' => '65BF0D',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#ECF3FA,#ECF3FA)',
            'border-color' => 'D1E2F3',
            'color' => ' #0D65BF',
          ),
        ),
        'Cyan' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#08A8A9,#08A8A9)',
            'border-color' => '08A8A9',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#ECF3FA,#ECF3FA)',
            'border-color' => 'D1E2F3',
            'color' => ' #0D65BF',
          ),
        ),
        'blue' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#0D65BF,#0D65BF)',
            'border-color' => '0D65BF',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#ECF3FA,#ECF3FA)',
            'border-color' => 'D1E2F3',
            'color' => ' #0D65BF',
          ),
        ),
        'yellow' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#BF670D,#BF670D)',
            'border-color' => 'BF670D',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#ECF3FA,#ECF3FA)',
            'border-color' => 'D1E2F3',
            'color' => ' #0D65BF',
          ),
        ),
      ),
    ),
  ),
);
