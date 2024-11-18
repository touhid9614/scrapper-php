<?php

global $CronConfigs;

$CronConfigs["frederictonmitsubishi"] = array(
  'password' => 'frederictonmitsubishi',
  'email' => 'regan@smedia.ca',
  'log' => true,
  'adgroup_version' => 'v8',
  'fb_title' => '[year] [make] [model] [trim] [price]',
  'fb_brand' => '[year] [make] [model] - [trim]',
  'customer_id' => '388-803-1635',
  'max_cost' => 3900,
  'cost_distribution' =>
  array(
    'adwords' => 3900,
  ),
  'create' =>
  array(),
  'new_descs' =>
  array(
    0 =>
    array(
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 =>
    array(
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'used_descs' =>
  array(
    0 =>
    array(
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 =>
    array(
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model] today',
    ),
  ),
  'banner' =>
  array(
    'template' => 'frederictonmitsubishi',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'styels' =>
    array(
      'new_display' => 'dynamic_banner',
      'used_display' => 'dynamic_banner',
      'new_retargeting' => 'dynamic_banner',
      'used_retargeting' => 'dynamic_banner',
      'new_marketbuyers' => 'dynamic_banner',
      'used_marketbuyers' => 'dynamic_banner',
    ),
    'font_color' => '#ffffff',
  ),
  'lead' =>
  array(
    'live' => false,
    'lead_type_' => true,
    'lead_type_new' => false,
    'lead_type_used' => true,
    'bg_color' => '#EFEFEF',
    'text_color' => '#404450',
    'border_color' => '#E5E5E5',
    'button_color' =>
    array(
      0 => '#DD140D',
      1 => '#DD140D',
    ),
    'button_color_hover' =>
    array(
      0 => '#B7110B',
      1 => '#B7110B',
    ),
    'button_color_active' =>
    array(
      0 => '#333333',
      1 => '#333333',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '$200 Off Coupon from Fredericton Mitsubishi',
    'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Fredericton Mitsubishi Team',
    'forward_to' =>
    array(
      0 => 'paco@volvocarsnb.com',
      1 => 'lori@shiftautogroup.ca',
      2 => 'marshal@smedia.ca',
    ),
    'special_to' =>
    array(
      0 => 'webleads@FrederictonMitsubishi.dsmessage.com',
    ),
    'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="Fredericton Mitsubishi"></id>
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
							<name part="full">Fredericton Mitsubishi</name>
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
      'vdp' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
  'name' => 'frederictonmitsubishi',
);
