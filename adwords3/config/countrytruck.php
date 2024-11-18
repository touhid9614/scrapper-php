<?php

global $CronConfigs;
$CronConfigs["countrytruck"] = array(
    "name" => " countrytruck",
    "email" => "regan@smedia.ca",
    "password" => " countrytruck",
    "log" => true,
    "banner" => array(
        "template" => "countrytruck",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Test drive the [year] [make] [model] today!",
        //"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to aid in any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#4a5c48',
            '#4a5c48',
),
        'button_color_hover' => array(
            '#000000',
            '#000000',
),
        'button_color_active' => array(
            '#000000',
            '#000000',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$300 OFF coupon from Country Truck & Auto',
        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Country Truck & Auto Team',
        'forward_to' => array(
            'brysonw@countrytruck.net',
            'marshal@smedia.ca',
),
        'special_to' => array(
            'dealer_countrytruckandauto@leads.dealrcloud.com',
),
        'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="Country Truck & Auto"></id>
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
							<name part="full">Country Truck & Auto</name>
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
),
    'adf_to' => array(
        'webteam@dealercarsearch.com',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'Listing Inquiry' => [
            'url-match' => '/newandusedcars.aspx/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=Inquiry]',
            'css-class' => 'a[href*=Inquiry]',
            'css-hover' => 'a[href*=Inquiry]:hover',
            //'button_action' => ['form','e-price'],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'Listing Inquiry' => [
                    'target' => 'a[href*=Inquiry]',
                    'values' => array(
                        'Send Inquiry',
                        'Inquire Now',
                        'Make An Inquiry',
                        'Submit An Inquiry',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D39324,#D39324)',
                        'border-color' => 'D39324',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B07818,#B07818)',
                        'border-color' => 'B07818',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D11203,#D11203)',
                        'border-color' => 'D11203',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BA0F01,#BA0F01)',
                        'border-color' => 'BA0F01',
),
),
                'Brown ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#A1705D,#A1705D)',
                        'border-color' => '7B5647',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '5B4034',
),
),
                'Purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6734BC,#6734BC)',
                        'border-color' => '6734BC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4E2690,#4E2690)',
                        'border-color' => '4E2690',
),
),
),
],
        'Listing financing' => [
            'url-match' => '/newandusedcars.aspx/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.hidden-sm a[href*=creditapp]',
            'css-class' => '.hidden-sm a[href*=creditapp]',
            'css-hover' => '.hidden-sm a[href*=creditapp]:hover',
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'Listing financing' => [
                    'target' => '.hidden-sm a[href*=creditapp]',
                    'values' => array(
                        'No hassle financing',
                        'Get Financed Today',
                        'Special Finance Offers!',
                        'Explore Payments',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D39324,#D39324)',
                        'border-color' => 'D39324',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B07818,#B07818)',
                        'border-color' => 'B07818',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D11203,#D11203)',
                        'border-color' => 'D11203',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BA0F01,#BA0F01)',
                        'border-color' => 'BA0F01',
),
),
                'Brown ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#A1705D,#A1705D)',
                        'border-color' => '7B5647',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '5B4034',
),
),
                'Purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6734BC,#6734BC)',
                        'border-color' => '6734BC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4E2690,#4E2690)',
                        'border-color' => '4E2690',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/[0-9]{4}-[^-]+-[^\\/]+\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.detailApplyOnlineLink.pull-right a',
            'css-class' => 'div.detailApplyOnlineLink.pull-right a',
            'css-hover' => 'div.detailApplyOnlineLink.pull-right a:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'div.detailApplyOnlineLink.pull-right a',
                    'values' => array(
                        'No hassle financing',
                        'Get Financed Today',
                        'Special Finance Offers!',
                        'Explore Payments',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D39324,#D39324)',
                        'border-color' => 'D39324',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B07818,#B07818)',
                        'border-color' => 'B07818',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D11203,#D11203)',
                        'border-color' => 'D11203',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BA0F01,#BA0F01)',
                        'border-color' => 'BA0F01',
                        'color' => '#fff',
),
),
                'Brown ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#A1705D,#A1705D)',
                        'border-color' => '7B5647',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '5B4034',
                        'color' => '#fff',
),
),
                'Purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6734BC,#6734BC)',
                        'border-color' => '6734BC',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4E2690,#4E2690)',
                        'border-color' => '4E2690',
                        'color' => '#fff',
),
),
),
],
        'Listing request-a-quote' => [
            'url-match' => '/newandusedcars.aspx/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.smsBtnList.btn',
            'css-class' => '.smsBtnList.btn',
            'css-hover' => '.smsBtnList.btn:hover',
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'Listing request-a-quote' => [
                    'target' => '.smsBtnList.btn',
                    'values' => array(
                        'Send Us A Text',
                        'Send SMS',
                        'Message Us',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D39324,#D39324)',
                        'border-color' => 'D39324',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B07818,#B07818)',
                        'border-color' => 'B07818',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D11203,#D11203)',
                        'border-color' => 'D11203',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BA0F01,#BA0F01)',
                        'border-color' => 'BA0F01',
),
),
                'Brown ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#A1705D,#A1705D)',
                        'border-color' => '7B5647',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '5B4034',
),
),
                'Purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6734BC,#6734BC)',
                        'border-color' => '6734BC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4E2690,#4E2690)',
                        'border-color' => '4E2690',
),
),
),
],
        'request-a-quote' => [
            'url-match' => '/\\/[0-9]{4}-[^-]+-[^\\/]+\\//i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.smsBtnDetail.btn',
            'css-class' => 'a.smsBtnDetail.btn',
            'css-hover' => 'a.smsBtnDetail.btn:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.smsBtnDetail.btn',
                    'values' => array(
                        'Send Us A Text',
                        'Send SMS',
                        'Message Us',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D39324,#D39324)',
                        'border-color' => 'D39324',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#B07818,#B07818)',
                        'border-color' => 'B07818',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#D11203,#D11203)',
                        'border-color' => 'D11203',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BA0F01,#BA0F01)',
                        'border-color' => 'BA0F01',
),
),
                'Brown ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#A1705D,#A1705D)',
                        'border-color' => '7B5647',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#5B4034,#5B4034)',
                        'border-color' => '5B4034',
),
),
                'Purple ' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6734BC,#6734BC)',
                        'border-color' => '6734BC',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#4E2690,#4E2690)',
                        'border-color' => '4E2690',
),
),
),
],
],
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17572',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
);