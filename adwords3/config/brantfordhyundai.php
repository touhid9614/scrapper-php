<?php

global $CronConfigs;

$CronConfigs["brantfordhyundai"] = array(
  'password' => 'brantfordhyundai',
  'email' => 'regan@smedia.ca',
  'log' => true,
  'customer_id' => '147-645-7535',
  'max_cost' => 500,
  'cost_distribution' =>
  array(
    'adwords' => 500,
  ),
  'create' =>
  array(),
  'new_descs' =>
  array(
    
    array(
      'description' => '[year] [make] [model] [price] In stock now!',
      'description2' => 'Click to view estimated payments and discounts!',
    ),
  ),
  'used_descs' =>
  array(
    
    array(
      'description' => '[year] [make] [model] [price] In stock now!',
      'description2' => 'Click to view estimated payments and discounts!',
    ),
  ),
  'lead' =>
  array(
    'live' => false,
    'lead_type_' => true,
    'lead_type_new' => true,
    'lead_type_used' => true,
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
       '#003768',
       '#003768',
    ),
    'button_color_hover' =>
    array(
       '#002443',
       '#002443',
    ),
    'button_color_active' =>
    array(
       '#1A3972',
       '#1A3972',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => 'Schedule Your At-Home Test Drive',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim. Please note offer is not valid with any previous purchase or quote.</p><br><img src="[image]"/><p><br><br>Brantford Hyundai Team',
    'forward_to' =>
    array(
       'jshoots@brantfordhyundai.ca',
       'jperritt@brantfordhyundai.ca',
       'marshal@smedia.ca',
    ),
    'special_to' =>
    array(
       'adfleads+2715@d2cmedia.ca',
    ),
    'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="sMedia Coupon"></id>
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
					<vendorname>Brantford Hyundai</vendorname>
					<contact>
						<name part="full">Brantford Hyundai</name>
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
    'lead_in' =>
    array(
      'vdp' => '/\\/(?:new|used)\\/.*[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'banner' =>
  array(
    'template' => 'brantfordhyundai',
    'fb_description' => 'Are you still interested in the [year] [make] [model] [trim]? Click below for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] [trim]! Click for more information.',
    'fb_dynamiclead_description_used' => 'Are you still interested in the [year] [make] [model] [trim]? Click below and fill in your information. A product specialist will be in touch to answer any question.',
    'flash_style' => 'default',
    'border_color' => '#282828',
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
  'name' => 'brantfordhyundai',
);
