<?php

global $CronConfigs;

$CronConfigs["kindersleymainline"] = array (
  'name' => 'kindersleymainline',
  'log' => true,
  'bid' => 3.0,
  'bid_modifier' => 
  array (
    'after' => 45,
    'bid' => 1.5,
  ),
  'password' => 'kindersleymainline',
  'max_cost' => 0,
  'cost_distribution' => 
  array (
    'youtube' => 0,
    'used' => 0,
    'new' => 0,
  ),
  'bing_account_id' => 156002881,
  'email' => 'regan@smedia.ca',
  'lead' => 
  array (
    'live' => false,
    'lead_type_' => false,
    'lead_type_new' => false,
    'lead_type_used' => false,
    'bg_color' => '#EFEFEF',
    'text_color' => '#404450',
    'border_color' => '#E5E5E5',
    'button_color' => 
    array (
      0 => '#FAC703',
      1 => '#FAC703',
    ),
    'button_color_hover' => 
    array (
      0 => '#E1A504',
      1 => '#E1A504',
    ),
    'button_color_active' => 
    array (
      0 => '#E1A504',
      1 => '#E1A504',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => 'Get up to $10,000 Cash Back from Kindersley Mainline Motor Products Ltd',
    'response_email' => 'Hello [name],<p> Thank you for booking a test drive! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Kindersley Mainline Motor Products Ltd',
    'forward_to' => 
    array (
      0 => 'marshal@smedia.ca',
    ),
    'special_to' => 
    array (
      0 => 'smedia@kindersleymainline.ca',
    ),
    'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="Kindersley Mainline Motor Products Ltd"></id>
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
                                                <comments>[comments] Sent From: [url]</comments>
					</customer>
					<vendor>
						<contact>
							<name part="full">Kindersley Mainline Motor Products Ltd</name>
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
    'respond_from' => 'offers@mail.smedia.ca',
    'forward_from' => 'offers@mail.smedia.ca',
    'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
    'lead_in' => 
    array (
      'vdp' => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/',
      'service_regex' => '',
    ),
  ),
  'post_code' => 's0l 1s0',
  'create' => 
  array (
    'special_search' => false,
  ),
  'host_url' => 'https://www.kindersleymainline.net',
  'display_url' => 'www.kindersleymainline.net',
  'new_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model]',
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
      'desc2' => '[year] [make] [model]',
    ),
  ),
  'special_descs' => 
  array (
    0 => 
    array (
      'desc1' => 'Test Drive the [year]',
      'desc2' => '[make] [model] today.',
    ),
    1 => 
    array (
      'desc1' => 'Call us today about the ',
      'desc2' => '[year] [make] [model]',
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
  'customer_id' => '695-569-0465',
  'fb_brand' => '[year] [make] [model] - [body_style]',
  'banner' => 
  array (
    'template' => 'kindersleymainline',
    'g_description' => 'Are you still interested in the [year] [make] [model]? No-contact vehicle delivery available! Click for more information.',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? No-contact vehicle delivery available! Click for more information or call us at 306-242-0231.',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]. No-contact vehicle delivery available! Click for more information or call us at 306-242-0231.',
    'fb_dynamiclead_description' => 'You may not be ready to buy from us - but we want to keep you in the loop for when there are price drops on our inventory. Just click below, fill out your info and you will receive Price Updates!',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'old_price_new' => 'msrp',
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
  'vinnauto' => 
  array (
    'button_status' => false,
    'button_debug' => false,
    'dealership_id' => '57447d82-5b92-4181-9476-93417341de48',
    'VINN_SIGNING_SECRET' => 'adslfkjasldfjk',
    'button_position' => 'beforebegin',
    'button_container' => '#main > section > div.deck > section:nth-child(2) > div.deck > section:nth-child(2) > div.content > div.link',
    'button_code' => 'class="primary"',
    'button_text' => 'CHECKOUT',
  ),
  'form_live' => false,
  'buttons_live' => false,
);