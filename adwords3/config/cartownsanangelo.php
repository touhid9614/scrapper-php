<?php

global $CronConfigs;

$CronConfigs["cartownsanangelo"] = array(
  'name' => 'cartownsanangelo',
  'email' => 'regan@smedia.ca',
  'password' => 'cartownsanangelo',
  'log' => true,
  'lead' =>
  array(
    'live' => false,
    'lead_type_' => false,
    'lead_type_new' => false,
    'lead_type_used' => false,
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
       '#0C5D9C',
       '#0C5D9C',
    ),
    'button_color_hover' =>
    array(
       '#09395F',
       '#09395F',
    ),
    'button_color_active' =>
    array(
       '#09395F',
       '#09395F',
    ),
    'button_text_color' => '#FFFFFF',
    'response_email_subject' => '$200 off coupon from Car Town Hyundai',
    'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Car Town Hyundai Team',
    'forward_to' =>
    array(
       'marshal@smedia.ca',
    ),
    'special_to' =>
    array(
       'leads@cartownhyundai.motosnap.com',
    ),
    'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Car Town Hyundai"></id>
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
						<name part="full">Car Town Hyundai</name>
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
      'vdp' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-.*\\.htm/i',
      'service_regex' => '',
    ),
  ),
  'adf_to' =>
  array(
     'leads@cartownhyundai.motosnap.com',
  ),
  'form_live' => true,
  'buttons_live' => true,
  'buttons' =>
  array(
    'request-information' =>
    array(
      'url-match' => '/\\/(?:new|used)\\/[^/]+/[0-9]{4}-/i',
      'target' => NULL,
      'locations' =>
      array(
        'default' => NULL,
      ),
      'action-target' => 'ul.yui3-g.nav  li.ddc-span6 a.btn.btn-default.eprice.dialog.button',
      'css-class' => 'ul.yui3-g.nav  li.ddc-span6 a.btn.btn-default.eprice.dialog.button',
      'css-hover' => 'ul.yui3-g.nav  li.ddc-span6 a.btn.btn-default.eprice.dialog.button:hover',
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
          'target' => 'ul.yui3-g.nav  li.ddc-span6 a.btn.btn-default.eprice.dialog.button',
          'values' =>
          array(
             'Get More Information',
             'Ask for More Info',
             'Learn More',
             'More Info',
             'Ask a Question',
            5 => 'Let Our Experts Help',
            6 => 'Ask an Expert',
          ),
        ),
      ),
      'styles' =>
      array(
        'orange' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#C38820,#C38820)',
            'border-color' => 'C38820',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#A9761C,#A9761C)',
            'border-color' => 'A9761C',
          ),
        ),
        'red' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#C33320,#C33320)',
            'border-color' => 'C33320',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#A92C1C,#A92C1C)',
            'border-color' => 'A92C1C',
          ),
        ),
        'green' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#189138,#189138)',
            'border-color' => '189138',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#14782E,#14782E)',
            'border-color' => '14782E',
          ),
        ),
        'blue' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#1F4581,#1F4581)',
            'border-color' => '1F4581',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#193767,#193767)',
            'border-color' => '193767',
          ),
        ),
        'purple' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#BE29EC,#BE29EC)',
            'border-color' => 'BE29EC',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#951DBA,#951DBA)',
            'border-color' => '951DBA',
          ),
        ),
      ),
    ),
    'calculate-payment' =>
    array(
      'url-match' => '/\\/(?:new|used)\\/[^/]+/[0-9]{4}-/i',
      'target' => NULL,
      'locations' =>
      array(
        'default' => NULL,
      ),
      'action-target' => 'a.btn.btn-primary.btn-block.calculate',
      'css-class' => 'a.btn.btn-primary.btn-block.calculate',
      'css-hover' => 'a.btn.btn-primary.btn-block.calculate:hover',
      'button_action' =>
      array(
         'form',
         'finance',
      ),
      'sizes' =>
      array(
        100 =>
        array(),
      ),
      'texts' =>
      array(
        'financing' =>
        array(
          'target' => 'a.btn.btn-primary.btn-block.calculate',
          'values' =>
          array(
             'Special Finance Offers!',
             'Explore Payments',
             'Calculate Your Payments',
             'Estimate Payments',
          ),
        ),
      ),
      'styles' =>
      array(
        'orange' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#C38820,#C38820)',
            'border-color' => 'C38820',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#A9761C,#A9761C)',
            'border-color' => 'A9761C',
            'color' => '#fff',
          ),
        ),
        'red' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#C33320,#C33320)',
            'border-color' => 'C33320',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#A92C1C,#A92C1C)',
            'border-color' => 'A92C1C',
            'color' => '#fff',
          ),
        ),
        'green' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#189138,#189138)',
            'border-color' => '189138',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#14782E,#14782E)',
            'border-color' => '14782E',
            'color' => '#fff',
          ),
        ),
        'blue' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#1F4581,#1F4581)',
            'border-color' => '1F4581',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#193767,#193767)',
            'border-color' => '193767',
            'color' => '#fff',
          ),
        ),
        'purple' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#BE29EC,#BE29EC)',
            'border-color' => 'BE29EC',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#951DBA,#951DBA)',
            'border-color' => '951DBA',
            'color' => '#fff',
          ),
        ),
      ),
    ),
    'test-drive' =>
    array(
      'url-match' => '/\\/(?:new|used)\\/[^/]+/[0-9]{4}-/i',
      'target' => NULL,
      'locations' =>
      array(
        'default' => NULL,
      ),
      'action-target' => 'a.btn.btn-primary.btn-lg.dialog.btn-block',
      'css-class' => 'a.btn.btn-primary.btn-lg.dialog.btn-block',
      'css-hover' => 'a.btn.btn-primary.btn-lg.dialog.btn-block:hover',
      'button_action' =>
      array(
         'form',
         'test-drive',
      ),
      'sizes' =>
      array(
        100 =>
        array(),
      ),
      'texts' =>
      array(
        'test-drive' =>
        array(
          'target' => 'a.btn.btn-primary.btn-lg.dialog.btn-block',
          'values' =>
          array(
             'Schedule My Visit',
             'Test Drive',
             'Request A Test Drive',
             'Want to Test Drive It?',
          ),
        ),
      ),
      'styles' =>
      array(
        'orange' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#C38820,#C38820)',
            'border-color' => 'C38820',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#A9761C,#A9761C)',
            'border-color' => 'A9761C',
          ),
        ),
        'red' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#C33320,#C33320)',
            'border-color' => 'C33320',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#A92C1C,#A92C1C)',
            'border-color' => 'A92C1C',
          ),
        ),
        'green' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#189138,#189138)',
            'border-color' => '189138',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#14782E,#14782E)',
            'border-color' => '14782E',
          ),
        ),
        'blue' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#1F4581,#1F4581)',
            'border-color' => '1F4581',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#193767,#193767)',
            'border-color' => '193767',
          ),
        ),
        'purple' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#BE29EC,#BE29EC)',
            'border-color' => 'BE29EC',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#951DBA,#951DBA)',
            'border-color' => '951DBA',
          ),
        ),
      ),
    ),
    'financing' =>
    array(
      'url-match' => '/\\/(?:new|used)\\/[^/]+/[0-9]{4}-/i',
      'target' => NULL,
      'locations' =>
      array(
        'default' => NULL,
      ),
      'action-target' => 'a.btn.btn-default.btn-block',
      'css-class' => 'a.btn.btn-default.btn-block',
      'css-hover' => 'a.btn.btn-default.btn-block:hover',
      'button_action' =>
      array(
         'form',
         'finance',
      ),
      'sizes' =>
      array(
        100 => 
        array(),
      ),
      'texts' =>
      array(
        'financing' =>
        array(
          'target' => 'a.btn.btn-default.btn-block',
          'values' =>
          array(
             'No Hassle Financing',
             'Get Financed Today',
             'Financing Available',
             'Special Finance Offers',
             'Financing Options',
          ),
        ),
      ),
      'styles' =>
      array(
        'orange' =>
        array(
          'normal' =>
          array(
            'background' => '#c38820',
            'border-color' => '#000',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => '#a9761c',
            'border-color' => '#000',
            'color' => '#fff',
          ),
        ),
        'red' =>
        array(
          'normal' =>
          array(
            'background' => '#c33320',
            'border-color' => '#000',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => '#a92c1c',
            'border-color' => '#000',
            'color' => '#fff',
          ),
        ),
        'green' =>
        array(
          'normal' =>
          array(
            'background' => '#189138',
            'border-color' => '#000',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => '#14782e',
            'border-color' => '#000',
            'color' => '#fff',
          ),
        ),
        'blue' =>
        array(
          'normal' =>
          array(
            'background' => '#1f4581',
            'border-color' => '#000',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => '#193767',
            'border-color' => '#000',
            'color' => '#fff',
          ),
        ),
        'purple' =>
        array(
          'normal' =>
          array(
            'background' => '#be29ec',
            'border-color' => '#000',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => '#951dba',
            'border-color' => '#000',
            'color' => '#fff',
          ),
        ),
      ),
    ),
    'trade-in' =>
    array(
      'url-match' => '/\\/(?:new|used)\\/[^/]+/[0-9]{4}-/i',
      'target' => NULL,
      'locations' =>
      array(
        'default' => NULL,
      ),
      'action-target' => 'a[href*=trade-in].btn',
      'css-class' => 'a[href*=trade-in].btn',
      'css-hover' => 'a[href*=trade-in].btn:hover',
      'button_action' =>
      array(
         'form',
         'trade-in',
      ),
      'sizes' =>
      array(
        100 => 
        array(),
      ),
      'texts' =>
      array(
        'trade-in' =>
        array(
          'target' => 'a[href*=trade-in].btn',
          'values' =>
          array(
             'Get Trade-In Value',
             'Trade Offer',
             'What\'s Your Trade Worth?',
             'Value Your Trade',
             'We Want Your Car',
            5 => 'We\'ll Buy Your Car',
          ),
        ),
      ),
      'styles' =>
      array(
        'orange' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#C38820,#C38820)',
            'border-color' => 'C38820',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#A9761C,#A9761C)',
            'border-color' => 'A9761C',
            'color' => '#fff',
          ),
        ),
        'red' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#C33320,#C33320)',
            'border-color' => 'C33320',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#A92C1C,#A92C1C)',
            'border-color' => 'A92C1C',
            'color' => '#fff',
          ),
        ),
        'green' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#189138,#189138)',
            'border-color' => '189138',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#14782E,#14782E)',
            'border-color' => '14782E',
            'color' => '#fff',
          ),
        ),
        'blue' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#1F4581,#1F4581)',
            'border-color' => '1F4581',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#193767,#193767)',
            'border-color' => '193767',
            'color' => '#fff',
          ),
        ),
        'purple' =>
        array(
          'normal' =>
          array(
            'background' => 'linear-gradient(#BE29EC,#BE29EC)',
            'border-color' => 'BE29EC',
            'color' => '#fff',
          ),
          'hover' =>
          array(
            'background' => 'linear-gradient(#951DBA,#951DBA)',
            'border-color' => '951DBA',
            'color' => '#fff',
          ),
        ),
      ),
    ),
  ),
);
