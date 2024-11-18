<?php

global $CronConfigs;

$CronConfigs["heningertoyota"] = array (
  'name' => 'heningertoyota',
  'email' => 'regan@smedia.ca',
  'password' => 'heningertoyota',
  'log' => true,
  'customer_id' => '894-164-5154',
  'max_cost' => 5640,
  'cost_distribution' => 
  array (
    'adwords' => 5640,
  ),
  'create' => 
  array (
  	"new_search" => yes,
  ),
  'new_descs' => 
  array (
    0 => 
    array (
      'title2' => 'It\'s Time to Toyota',
      'title3' => 'Calgary Toyota Dealer',
      'description' => 'Call us today about the [year] [make] [model]',
      'description2' => 'Build your Deal Online, it\'s Easy',
    ),
    1 => 
    array (
      'title2' => 'It\'s Time to Toyota',
      'title3' => 'Calgary Toyota Dealer',
      'description' => 'Call us today about the [year] [make] [model]',
      'description2' => 'Build your Deal Online, it\'s Easy',
    ),
  ),
  'used_descs' => 
  array (
    0 => 
    array (
      'title2' => 'It\'s Time to Toyota',
      'title3' => 'Calgary Toyota Dealer',
      'description' => 'Call us today about the [year] [make] [model]',
      'description2' => 'Build your Deal Online, it\'s Easy',
    ),
    1 => 
    array (
      'title2' => 'It\'s Time to Toyota',
      'title3' => 'Calgary Toyota Dealer',
      'description' => 'Call us today about the [year] [make] [model]',
      'description2' => 'Build your Deal Online, it\'s Easy',
    ),
  ),
  'banner' => 
  array (
    'template' => 'heningertoyota',
    'fb_description' => 'Experience the Heninger Toyota Difference for yourself. Are you still interested in the [year] [make] [model]? Click for more info!',
    'fb_lookalike_description' => 'Experience the Heninger Toyota Difference for yourself. Check out this [year] [make] [model] today! Click for more information.',
    'flash_style' => 'default',
    'styels' => 
    array (
      'new_display' => 'dynamic_banner',
      'used_display' => 'dynamic_banner',
      'new_retargeting' => 'dynamic_banner',
      'used_retargeting' => 'dynamic_banner',
      'new_marketbuyers' => 'dynamic_banner',
      'used_marketbuyers' => 'dynamic_banner',
    ),
    'border_color' => '#282828',
    'font_color' => '#ffffff',
  ),
  'lead' => 
  array (
    'live' => false,
    'lead_type_' => false,
    'lead_type_new' => false,
    'lead_type_used' => true,
    'lead_type_service' => false,
    'shown_cap' => false,
    'fillup_cap' => false,
    'session_close' => false,
    'device_type' => 
    array (
      'mobile' => false,
      'desktop' => false,
      'tablet' => false,
    ),
    'sent_client_email' => true,
    'offer_minimum_price' => 0,
    'offer_maximum_price' => 10000000,
    'bg_color' => '#EFEFEF',
    'text_color' => '#404450',
    'border_color' => '#E5E5E5',
    'button_color' => 
    array (
      0 => '#E30000',
      1 => '#E30000',
    ),
    'button_color_hover' => 
    array (
      0 => '#303030',
      1 => '#303030',
    ),
    'button_color_active' => 
    array (
      0 => '#303030',
      1 => '#303030',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '$500 off coupon from Heninger Toyota',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim. Please note offer is not valid with any previous purchase or quote.</p><br><img src="[image]"/><p><br><br>Heninger Toyota Team',
    'forward_to' => 
    array (
      0 => 'marshal@smedia.ca',
    ),
    'special_to' => 
    array (
      0 => 'heningertoyota_potratz@edrive-valet.com',
    ),
    'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="Heninger Toyota"></id>
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
							<name part="full">Heninger Toyota</name>
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
      'vdp' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
);
