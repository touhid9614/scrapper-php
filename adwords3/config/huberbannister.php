<?php

global $CronConfigs;
$CronConfigs["huberbannister"] = array(
    'password' => 'huberbannister',
    "email" => "regan@smedia.ca",
    'log' => true,
    'customer_id' => '426-206-8061',
    'max_cost' => 600,
    'cost_distribution' => array(
        'adwords' => 600,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
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
            "desc2" => "[year] [make] [model]",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
),
    "banner" => array(
        "template" => "huberbannister",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
),
    /* smart offer */
    "lead" => array(
        'used' => array(
            'live' => false,
            'lead_type_' => true,
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
                '#132087',
                '#132087',
),
            'button_color_hover' => array(
                '#363636',
                '#363636',
),
            'button_color_active' => array(
                '#1A3972',
                '#1A3972',
),
            'button_text_color' => '#FFFFFF',
            'response_email_subject' => 'Get $200 OFF offer from Huber Bannister',
            'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Huber Bannister Team',
            'forward_to' => array(
                'sales@huberbannister.com',
                'marshal@smedia.ca',
),
            'special_to' => array(
                'sales@huberbannister.com',
),
            'special_email' => '<?xml version="1.0"?>
	<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Huber Bannister"></id>
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
					<name part="full">Huber Bannister</name>
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
            'lead_in' => array(
                'vdp' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
                'service' => '',
),
),
),
    /* dynamic social ads */
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'trade-in' => [
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(3) a.btn-incentives-new',
            'css-class' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(3) a.btn-incentives-new',
            'css-hover' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(3) a.btn-incentives-new:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(3) a.btn-incentives-new',
                    'values' => array(
                        'Get Trade-In Value',
                        'Trade Offer',
                        'What\'s Your Trade Worth?',
                        'Trade-In Appraisal',
                        'Appraise Your Trade',
                        'We Want Your Car',
                        'We\'ll Buy Your Car',
                        'Value Your Trade',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(4) a.btn-incentives-new',
            'css-class' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(4) a.btn-incentives-new',
            'css-hover' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(4) a.btn-incentives-new:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(4) a.btn-incentives-new',
                    'values' => array(
                        'Special Finance Offers!',
                        'Estimate Payments',
                        'Financing Options',
                        'Calculate my Payments',
                        'Payment options',
                        'Explore Payments',
                        'Financing Available',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(5) a.btn-incentives-new',
            'css-class' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(5) a.btn-incentives-new',
            'css-hover' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(5) a.btn-incentives-new:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'div.col-md-veh-details.col-sm-5 span:nth-of-type(5) a.btn-incentives-new',
                    'values' => array(
                        'Schedule My Visit',
                        'Test Drive',
                        'Request A Test Drive',
                        'Want to Test Drive It?',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
),
],
        'Used trade-in' => [
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(2) .btn-orange-vehicles1',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(2) .btn-orange-vehicles1',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(2) .btn-orange-vehicles1:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(2) .btn-orange-vehicles1',
                    'values' => array(
                        'Get Trade-In Value',
                        'Trade Offer',
                        'What\'s Your Trade Worth?',
                        'Trade-In Appraisal',
                        'Appraise Your Trade',
                        'We Want Your Car',
                        'We\'ll Buy Your Car',
                        'Value Your Trade',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
),
],
        'Used financing' => [
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) .btn-orange-vehicles1',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) .btn-orange-vehicles1',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) .btn-orange-vehicles1:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(1) .btn-orange-vehicles1',
                    'values' => array(
                        'Special Finance Offers!',
                        'Estimate Payments',
                        'Financing Options',
                        'Calculate my Payments',
                        'Payment options',
                        'Explore Payments',
                        'Financing Available',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
),
],
        'Used test-drive' => [
            'url-match' => '/\\/(?:new|certified|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(3) .btn-orange-vehicles1',
            'css-class' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(3) .btn-orange-vehicles1',
            'css-hover' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(3) .btn-orange-vehicles1:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'div.row.margin-buttons-used.buttons1 div:nth-of-type(3) .btn-orange-vehicles1',
                    'values' => array(
                        'Schedule My Visit',
                        'Test Drive',
                        'Request A Test Drive',
                        'Want to Test Drive It?',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
                        'color' => '#fff',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
                        'color' => '#fff',
),
),
),
],
],
);