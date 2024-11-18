<?php

global $CronConfigs;

$CronConfigs["danmurphyford"] = array(
  'bid' => 3.0,
  'password' => 'danmurphyford',
  'post_code' => 'L2R5L3',
  'log' => true,
  'email' => 'regan@smedia.ca',
  'banner' =>
  array(
    'template' => 'danmurphyford',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]! Click for more information.',
    'flash_style' => 'default',
    'hst' => true,
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
       '#2C5F9D',
       '#2C5F9D',
    ),
    'button_color_hover' =>
    array(
       '#0A1C31',
       '#0A1C31',
    ),
    'button_color_active' =>
    array(
       '#0A1C31',
       '#0A1C31',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '$200 off coupon from Dan Murphy Ford',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Dan Murphy Ford Team',
    'forward_to' =>
    array(
       'marshal@smedia.ca',
    ),
    'special_to' =>
    array(
       'webleads@danmurphyford.com',
    ),
    'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Dan Murphy Ford"></id>
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
						<name part="full">Dan Murphy Ford</name>
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
    'display_after' => 30000,
    'retarget_after' => 5000,
    'fb_retarget_after' => 5000,
    'adword_retarget_after' => 5000,
    'visit_count' => 0,
    'lead_in' =>
    array(
      'vdp' => '/\\/view\\/(?:new|used)-/',
      'service_regex' => '',
    ),
  ),
  'name' => 'danmurphyford',
);
