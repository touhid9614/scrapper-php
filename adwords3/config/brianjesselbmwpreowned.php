<?php

global $CronConfigs;

$CronConfigs["brianjesselbmwpreowned"] = array(
  'name' => 'brianjesselbmwpreowned',
  'email' => 'regan@smedia.ca',
  'password' => 'brianjesselbmwpreowned',
  'log' => true,
  'lead' =>
  array(
    'live' => false,
    'lead_type_' => true,
    'lead_type_new' => true,
    'lead_type_used' => true,
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
       '#4BAEE1',
       '#4BAEE1',
    ),
    'button_color_hover' =>
    array(
       '#2C617C',
       '#2C617C',
    ),
    'button_color_active' =>
    array(
       '#2C617C',
       '#2C617C',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '$250 off coupon from Brian Jessel Preowned',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Brian Jessel Preowned Team',
    'forward_to' =>
    array(
       'marshal@smedia.ca',
    ),
    'special_to' =>
    array(
       'albuttons-smedia@brianjesselbmwpreowned.net',
    ),
    'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Brian Jessel Preowned"></id>
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
						<name part="full">Brian Jessel Preowned</name>
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
      'vdp' => '/\\/vehicles\\/[0-9]{4}\\//',
      'service_regex' => '',
    ),
  ),
  'adf_to' =>
  array(
     'albuttons-smedia@brianjesselbmwpreowned.net',
  ),
  'form_live' => true,
  'buttons_live' => true,
  'buttons' =>
  array(
    'request-information' =>
    array(
      'url-match' => '/\\/vehicles\\/[0-9]{4}\\//i',
      'target' => NULL,
      'locations' =>
      array(
        'default' => NULL,
      ),
      'action-target' => 'div.button-group a',
      'css-class' => 'div.button-group a',
      'css-hover' => 'div.button-group a:hover',
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
        'request-information' =>
        array(
          'target' => 'div.button-group a',
          'values' =>
          array(
             'Ask a Question',
             'Ask Our Experts',
             'Get More Details',
          ),
        ),
      ),
      'styles' =>
      array(
        'blue' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#1C69D4,#1C69D4)',
            'border-color' => '1C69D4',
            'color' => '#FFFFFF',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#0653B6,#0653B6)',
            'border-color' => '0653B6',
            'color' => '#FFFFFF',
          ),
        ),
      ),
    ),
  ),
);
