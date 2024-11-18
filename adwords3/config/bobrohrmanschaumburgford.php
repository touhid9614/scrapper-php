<?php

global $CronConfigs;
$CronConfigs["bobrohrmanschaumburgford"] = array(
    'name' => 'bobrohrmanschaumburgford',
    'email' => 'regan@smedia.ca',
    'password' => 'bobrohrmanschaumburgford',
    'max_cost' => 1062,
    'cost_distribution' => array(
        'adwords' => 1062,
    ),
    'customer_id' => '609-509-5046',
    'combined_feed_mode' => true,
    'log' => true,
    'fb_title' => '[make] [model] [trim] [price]',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'banner' => array(
        'template' => 'bobrohrmanschaumburgford',
        'fb_description' => 'Are you still interested in the [year] [make] [model]? Click for more info.',
        'fb_aia_description' => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        'fb_lookalike_description' => 'Test drive the [year] [make] [model] today!',
        'flash_style' => 'default',
        'border_color' => '#282828',
        'font_color' => '#ffffff',
    ),
    'lead' => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'lead_type_service' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
        ),
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
             '#004582',
             '#004582',
        ),
        'button_color_hover' => array(
             '#003A71',
             '#003A71',
        ),
        'button_color_active' => array(
             '#003A71',
             '#003A71',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$300 Off coupon from BR Schaumburg Ford',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>BR Schaumburg Ford Team',
        'forward_to' => array(
             'marshal@smedia.ca',
        ),
        'special_to' => array(
             'leads@rohrmanford.com',
        ),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="BR Schaumburg Ford"></id>
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
						<name part="full">BR Schaumburg Ford</name>
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
        'lead_in' => array(
            'vdp' => '/\\/(?:new|used|certified)\\/[^\\/]+\\/[0-9]{4}-/i',
            'service_regex' => '',
        ),
    ),
);
