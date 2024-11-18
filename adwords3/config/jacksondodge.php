<?php

global $CronConfigs;

$CronConfigs["jacksondodge"] = array (
  'name' => 'jacksondodge',
  'bid' => 3.0,
  'log' => true,
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'password' => 'jacksondodge',
  'bid_modifier' => 
  array (
    'after' => 45,
    'bid' => 1.5,
  ),
  'max_cost' => 1225,
  'cost_distribution' => 
  array (
    'adwords' => 1225,
  ),
  'email' => 'regan@smedia.ca',
  'bing_account_id' => 156002894,
  'lead' => 
  array (
    'live' => false,
    'lead_type_' => false,
    'lead_type_new' => false,
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
    'sent_client_email' => true,
    'offer_minimum_price' => 0,
    'offer_maximum_price' => 10000000,
    'bg_color' => '#EFEFEF',
    'text_color' => '#404450',
    'border_color' => '#E5E5E5',
    'button_color' => 
    array (
      0 => '#343434',
      1 => '#343434',
    ),
    'button_color_hover' => 
    array (
      0 => '#494949',
      1 => '#494949',
    ),
    'button_color_active' => 
    array (
      0 => '#343434',
      1 => '#343434',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => 'Get $200 off coupon from Jackson Dodge',
    'response_email' => 'Hello [name],<p> Thank you for signing up for this offer! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Jackson Dodge Team',
    'forward_to' => 
    array (
      0 => 'marshal@smedia.ca',
    ),
    'special_to' => 
    array (
      0 => 'leads@sales.jacksondodge.ca',
      1 => 'adf_to@smedia.ca',
    ),
    'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Jackson Dodge"></id>
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
						<name part="full">Jackson Dodge</name>
						<email>[dealer_email]</email>
					</contact>
				</vendor>
				<provider>
					<name part="full">sMedia</name>
					<url>http://smedia.ca</url>
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
    array (
      'vdp' => '/\\/(?:new|used|certified)\\/vehicle\\/[0-9]{4}-/i',
      'service_regex' => '',
    ),
    'custom_div' => '',
  ),
  'create' => 
  array (
  ),
  'post_code' => 't1b 4v2',
  'new_descs' => 
  array (
    0 => 
    array (
      'title3' => 'We are the Truck Guys',
      'desc1' => '[year] [make] [model] ',
      'desc2' => 'only [Price]! Call Today',
    ),
    1 => 
    array (
      'title3' => 'We are the Truck Guys',
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    2 => 
    array (
      'title3' => 'We are the Truck Guys',
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model]',
    ),
    3 => 
    array (
      'title3' => 'We are the Truck Guys',
      'desc1' => '[year] [make] [model] ',
      'desc2' => 'starting at *[biweekly] b/w',
    ),
  ),
  'used_descs' => 
  array (
    0 => 
    array (
      'title3' => 'We are the Truck Guys',
      'desc1' => '[year] [make] [model] ',
      'desc2' => 'only [Price]! Call Today',
    ),
    1 => 
    array (
      'title3' => 'We are the Truck Guys',
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    2 => 
    array (
      'title3' => 'We are the Truck Guys',
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model]',
    ),
    3 => 
    array (
      'title3' => 'We are the Truck Guys',
      'desc1' => '[year] [make] [model] ',
      'desc2' => 'starting at *[biweekly] b/w',
    ),
  ),
  'options_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Equipped with [option]',
      'desc2' => 'and [option]',
    ),
  ),
  'ymmcount_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'We have [ymmcount] [make]',
      'desc2' => '[model] in stock',
    ),
  ),
 // 'customer_id' => '253-319-6552',
  'banner' => 
  array (
    'template' => 'jacksondodge',
    'fb_description' => 'Are you still interested in the [year] [make] [model] - stock #: [stock_number]? At Jackson Dodge, we can deliver the vehicle you want right to you! *Conditions apply.',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! At Jackson Dodge, we can deliver the vehicle you want right to you! *Conditions apply. Stock #: [stock_number]',
    'fb_dynamiclead_description' => 'Are you still interested in the [year] [make] [model] - Stock #: [stock_number]? Click below and fill in your information to find out more about our special offer. A product specialist will be in touch to aid in any questions.',
    'fb_description_grand caravan' => 'The Grand Caravan Fairwell sale! Are you still interested in the [year] [make] [model] - stock #: [stock_number]? At Jackson Dodge, we can deliver the vehicle you want right to you! *Conditions apply.',
    'fb_lookalike_description_grand caravan' => 'The Grand Caravan Fairwell sale! Check out this [year] [make] [model] today! At Jackson Dodge, we can deliver the vehicle you want right to you! *Conditions apply. Stock #: [stock_number]',
    'fb_marketplace_description' => '[description]',
    'fb_marketplace_title' => '[year] [make] [model] [trim]',
    'flash_style' => 'default',
    'border_color' => '#000',
    'styels' => 
    array (
      'new_display' => 'custom_banner',
      'used_display' => 'custom_banner',
      'new_retargeting' => 'custom_banner',
      'used_retargeting' => 'custom_banner',
      'new_combined' => 'custom_banner',
      'used_combined' => 'custom_banner',
    ),
    'font_color' => '#ffffff',
  ),
  'adf_to' => 
  array (
    0 => 'leads@sales.jacksondodge.ca',
  ),
  'form_live' => false,
);