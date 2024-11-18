<?php

global $CronConfigs;

$CronConfigs["allstarford"] = array(
  'name' => 'allstarford',
  'email' => 'regan@smedia.ca',
  'password' => 'allstarford',
  'log' => true,
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
    'sent_client_email' => true,
    'offer_minimum_price' => 0,
    'offer_maximum_price' => 10000000,
    'bg_color' => '#EFEFEF',
    'text_color' => '#404450',
    'border_color' => '#E5E5E5',
    'button_color' =>
    array(
      '#006BB7',
      '#006BB7',
    ),
    'button_color_hover' =>
    array(
      '#000000',
      '#000000',
    ),
    'button_color_active' =>
    array(
      '#000000',
      '#000000',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '$500 off coupon from All Star Ford',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>All Star Ford Team',
    'forward_to' =>
    array(
      'marshal@smedia.ca',
    ),
    'special_to' =>
    array(
      'leads@allstarfamilyford.motosnap.com',
      'allstarfamilyford@allstarfamilyford.forddirectcrmpro.com',
    ),
    'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="All Star Ford"></id>
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
						<name part="full">All Star Ford</name>
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
      'vdp' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
      'service_regex' => '',
    ),
  ),
  'adf_to' =>
  array(
    '',
  ),
  'form_live' => false,
  'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
  'buttons_live' => false,
);
