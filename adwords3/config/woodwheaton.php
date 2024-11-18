<?php

global $CronConfigs;
$CronConfigs["woodwheaton"] = array(
    "name" => " woodwheaton",
    "email" => "regan@smedia.ca",
    "password" => " woodwheaton",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "log" => true,
    'max_cost' => 2850,
    'cost_distribution' => array(
        'adwords' => 2850,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_display" => yes,
        "used_display" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes,
),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    "customer_id" => "870-626-4076",
    "banner" => array(
        "template" => "woodwheaton",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
         'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.',
        "fb_retargeting_description_2019_canyon" => "Are you still interested in the [year] [make] [model]? Limited Time Employee Pricing Available on any in-stock 2019 GMC Canyon! *Restrictions Apply. Shop below.",
        "fb_retargeting_description_2019_camaro" => "Are you still interested in the [year] [make] [model]? Limited Time Employee Pricing Available on any in-stock 2019 Chevrolet Camaro! *Restrictions Apply. Shop below.",
        "fb_retargeting_description_2019_corvette" => "Are you still interested in the [year] [make] [model]? Limited Time Employee Pricing Available on any in-stock 2019 Chevrolet Corvette! *Restrictions Apply. Shop below.",
        /*end-of-special-caption*/
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        /*special-caption-for-camaro-canyon-corvette-lookalike*/
        "fb_lookalike_description_2019_canyon" => "Check out this [year] [make] [model] today. Limited Time Employee Pricing Available on any in-stock 2019 GMC Canyon! *Restrictions Apply. Shop below.",
        "fb_lookalike_description_2019_camaro" => "Check out this [year] [make] [model] today. Limited Time Employee Pricing Available on any in-stock 2019 Chevrolet Camaro! *Restrictions Apply. Shop below.",
        "fb_lookalike_description_2019_corvette" => "Check out this [year] [make] [model] today. Limited Time Employee Pricing Available on any in-stock 2019 Chevrolet Corvette! *Restrictions Apply. Shop below.",
        /*end-of-special-caption*/
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
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
            '#056ABD',
            '#056ABD',
),
        'button_color_hover' => array(
            '#1A3972',
            '#1A3972',
),
        'button_color_active' => array(
            '#1A3972',
            '#1A3972',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Get $250 gas card from Wood Wheaton GM',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Wood Wheaton GM Team',
        'forward_to' => array(
            'leads@woodwheaton.com',
            'dwillimont@woodwheaton.com',
            'paige.hamilton@woodwheaton.com',
            'matthewwakeham@woodwheaton.com',
            'mark.chester@woodwheaton.com',
            'ryan.cunningham@woodwheaton.com',
            'art.alido@woodwheaton.com',
            'colton.lockhard@woodwheaton.com',
            'marshal@smedia.ca',
),
        'special_to' => array(
            'woodwheatonchev@newsales.leads.cmdlr.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Wood Wheaton GM"></id>
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
					<vendorname>Wood Wheaton GM</vendorname>
					<contact>
						<name part="full">Wood Wheaton GM</name>
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
        'display_after' => 15000,
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
            'vdp' => '/\\/(?:new|used|certified|wholesale-new|exotic-new)\\/[^\\/]+\\/[0-9]{4}-/i',
            'service' => '',
),
),
);