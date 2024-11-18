<?php

global $CronConfigs;

$CronConfigs["brodheadsvillechevy"] = array(
  'name' => 'brodheadsvillechevy',
  'email' => 'regan@smedia.ca',
  'password' => 'brodheadsvillechevy',
  'log' => true,
  'banner' =>
  array(
    'template' => 'brodheadsvillechevy',
    'fb_description' => 'Are you still interested in the [year] [make] [model]? Shop Online and Take Delivery at Home!',
    'fb_lookalike_description' => 'Check out this [year] [make] [model]. Shop Online and Take Delivery at Home!',
    'flash_style' => 'default',
    'border_color' => '#282828',
    'font_color' => '#ffffff',
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
       '#0054AC',
       '#0054AC',
    ),
    'button_color_hover' =>
    array(
       '#2C2C2C',
       '#2C2C2C',
    ),
    'button_color_active' =>
    array(
       '#2C2C2C',
       '#2C2C2C',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '$200 off coupon from Brodheadsville Chevrolet',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Brodheadsville Chevrolet Team',
    'forward_to' =>
    array(
       'marshal@smedia.ca',
    ),
    'special_to' =>
    array(
       'sales@brodheadsvillechevrolet.edealerhub.com',
    ),
    'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Brodheadsville Chevrolet"></id>
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
						<name part="full">Brodheadsville Chevrolet</name>
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
      'vdp' => '/\\/VehicleDetails\\/(?:new|used|certified)-[0-9]{4}-\\S+/i',
      'service_regex' => '',
    ),
  ),
  'adf_to' =>
  array(
     'sales@brodheadsvillechevrolet.edealerhub.com',
  ),
  'form_live' => true,
  'buttons_live' => true,
  'buttons' =>
  array(
    'request-a-quote' =>
    array(
      'url-match' => '/\\/VehicleDetails\\/(?:new|used)-[0-9]{4}/i',
      'target' => NULL,
      'locations' =>
      array(
        'default' => NULL,
      ),
      'action-target' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
      'css-class' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
      'css-hover' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]:hover',
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
          'target' => '[name="826ed42f-1e2d-4e5f-8663-2a25ab94bbd4"]',
          'values' =>
          array(
             'Get a Quote',
             'Request a Quote',
             'Inquire Today',
             'Inquire Now',
             'Get ePrice',
             'Get Internet Price',
             'Get Sale Price',
             'Get Our Best Price',
          ),
        ),
      ),
      'styles' =>
      array(
        'orange' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#E6A42D,#E6A42D)',
            'border-color' => 'F06B20',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#C78D25,#C78D25)',
            'border-color' => 'CF540E',
          ),
        ),
        'red' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#97140C,#97140C)',
            'border-color' => 'E01212',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#7E110A,#7E110A)',
            'border-color' => 'C60C0D',
          ),
        ),
        'blue' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#0669B2,#0669B2)',
            'border-color' => 'E01212',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#055895,#055895)',
            'border-color' => 'C60C0D',
          ),
        ),
        'grey' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#676B70,#676B70)',
            'border-color' => 'E01212',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#4D5054,#4D5054)',
            'border-color' => 'C60C0D',
          ),
        ),
      ),
    ),
    'request-information' =>
    array(
      'url-match' => '/\\/VehicleDetails\\/(?:new|used)-[0-9]{4}/i',
      'target' => NULL,
      'locations' =>
      array(
        'default' => NULL,
      ),
      'action-target' => '[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
      'css-class' => '[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
      'css-hover' => '[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]:hover',
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
          'target' => '[name="b3dc64a6-f84e-4046-8dec-adaa957a198d"]',
          'values' =>
          array(
             'Get Price Alerts',
             'Watch Price',
             'Watch This Price',
             'Follow Price',
             'Follow This Price',
             'Track Price',
             'Track This Price',
          ),
        ),
      ),
      'styles' =>
      array(
        'orange' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#E6A42D,#E6A42D)',
            'border-color' => 'F06B20',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#C78D25,#C78D25)',
            'border-color' => 'CF540E',
          ),
        ),
        'red' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#97140C,#97140C)',
            'border-color' => 'E01212',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#7E110A,#7E110A)',
            'border-color' => 'C60C0D',
          ),
        ),
        'blue' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#0669B2,#0669B2)',
            'border-color' => 'E01212',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#055895,#055895)',
            'border-color' => 'C60C0D',
          ),
        ),
        'grey' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#676B70,#676B70)',
            'border-color' => 'E01212',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#4D5054,#4D5054)',
            'border-color' => 'C60C0D',
          ),
        ),
      ),
    ),
  ),
  'max_cost' => 0,
  'cost_distribution' =>
  array(
    'dynamic' => 0,
  ),
);
