<?php

global $CronConfigs;
$CronConfigs["lombardtoyota"] = array(
    "name" => " lombardtoyota",
    "email" => "regan@smedia.ca",
    "password" => " lombardtoyota",
    "log" => true,
    "banner" => array(
        "template" => "lombardtoyota",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Check out this [year] [make] [model]! Click below and fill in your info - a product specialist will be in touch to answer any questions.",
        "fb_marketplace_description" => "[description]",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    /*    "lead" => array(
                  'live' => false,
                  'lead_type_' => false,
                  'lead_type_new' => false,
                  'lead_type_used' => false,
                  'bg_color' => '#EFEFEF',
                  'text_color' => '#404450',
                  'border_color' => '#E5E5E5',
                  'button_color' => array(
                      '#D81921',
                      '#D81921',
          ),
                  'button_color_hover' => array(
                      '#323234',
                      '#323234',
          ),
                  'button_color_active' => array(
                      '#323234',
                      '#323234',
          ),
                  'button_text_color' => '#FFFFFF',
                  'response_email_subject' => '$200 off coupon from Lombard Toyota',
                  'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Lombard Toyota Team',
                  'forward_to' => array(
                      'lomtoyota@gmail.com',
                      'marshal@smedia.ca',
          ),
                  'special_to' => array(
                      'webleads@lombardtoyota.com',
          ),
                  'special_email' => '<?xml version="1.0"?>
          		<?adf version="1.0"?>
          		<adf>
          			<prospect>
          				<id sequence="[total_count]" source="Lombard Toyota"></id>
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
          						<name part="full">Lombard Toyota</name>
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
                  'display_after' => 30000,
                  'retarget_after' => 5000,
                  'fb_retarget_after' => 5000,
                  'adword_retarget_after' => 5000,
                  'visit_count' => 0,
          ),*/
    'adf_to' => 'webleads@lombardtoyota.com',
    'lomtoyota@gmail.com',
    'buttons_live' => true,
    'form_live' => true,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div#region_4  div:nth-of-type(2) div.preview_eprice_btn_container div.get-e-price',
            'css-class' => 'div#region_4  div:nth-of-type(2) div.preview_eprice_btn_container div.get-e-price',
            'css-hover' => 'div#region_4  div:nth-of-type(2) div.preview_eprice_btn_container div.get-e-price:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'div#region_4  div:nth-of-type(2) div.preview_eprice_btn_container div.get-e-price',
                    'values' => array(
                        'Get VIP Price',
                        'Get Internet Price',
                        'Get Your Best Price',
                        'Get The Right Price',
                        'Get Today\'s Price',
                        'Request a Quote',
                        'Get a Quote',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EB0A1E,#EB0A1E)',
                        'border-color' => 'EB0A1E',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BE0B1B,#BE0B1B)',
                        'border-color' => 'BE0B1B',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#44619D,#44619D)',
                        'border-color' => '44619D',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#374E7E,#374E7E)',
                        'border-color' => '374E7E',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DE820E,#DE820E)',
                        'border-color' => 'DE820E',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C4730C,#C4730C)',
                        'border-color' => 'C4730C',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6CADDE,#6CADDE)',
                        'border-color' => '6CADDE',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#588DB4,#588DB4)',
                        'border-color' => '588DB4',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div#region_4  div:nth-of-type(3) div.preview_eprice_btn_container div.get-e-price',
            'css-class' => 'div#region_4  div:nth-of-type(3) div.preview_eprice_btn_container div.get-e-price',
            'css-hover' => 'div#region_4  div:nth-of-type(3) div.preview_eprice_btn_container div.get-e-price:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'div#region_4  div:nth-of-type(3) div.preview_eprice_btn_container div.get-e-price',
                    'values' => array(
                        'Get Special Pricing',
                        'Get More Details',
                        'More Info',
                        'Special Price',
                        'Ask an Expert!',
                        'Ask a Question!',
                        'Get e-Price!',
                        'Get Your Price!',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EB0A1E,#EB0A1E)',
                        'border-color' => 'EB0A1E',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BE0B1B,#BE0B1B)',
                        'border-color' => 'BE0B1B',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#44619D,#44619D)',
                        'border-color' => '44619D',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#374E7E,#374E7E)',
                        'border-color' => '374E7E',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DE820E,#DE820E)',
                        'border-color' => 'DE820E',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C4730C,#C4730C)',
                        'border-color' => 'C4730C',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6CADDE,#6CADDE)',
                        'border-color' => '6CADDE',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#588DB4,#588DB4)',
                        'border-color' => '588DB4',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
),
),
),
],
        'confirm-availability' => [
            'url-match' => '/\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.multi_cta_wrapper div:nth-of-type(3) a',
            'css-class' => 'div.multi_cta_wrapper div:nth-of-type(3) a',
            'css-hover' => 'div.multi_cta_wrapper div:nth-of-type(3) a:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'confirm-availability' => [
                    'target' => 'div.multi_cta_wrapper div:nth-of-type(3) a',
                    'values' => array(
                        'Check Availability',
                        'Ask For Availability',
                        'Get Availability',
                        'Ask for Availability',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EB0A1E,#EB0A1E)',
                        'border-color' => 'EB0A1E',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BE0B1B,#BE0B1B)',
                        'border-color' => 'BE0B1B',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#44619D,#44619D)',
                        'border-color' => '44619D',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#374E7E,#374E7E)',
                        'border-color' => '374E7E',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DE820E,#DE820E)',
                        'border-color' => 'DE820E',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C4730C,#C4730C)',
                        'border-color' => 'C4730C',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6CADDE,#6CADDE)',
                        'border-color' => '6CADDE',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#588DB4,#588DB4)',
                        'border-color' => '588DB4',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
),
),
),
],
        'request-information' => [
            'url-match' => '/\\/(?:new|used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.multi_cta_wrapper div:nth-of-type(2) a',
            'css-class' => 'div.multi_cta_wrapper div:nth-of-type(2) a',
            'css-hover' => 'div.multi_cta_wrapper div:nth-of-type(2) a:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => 'div.multi_cta_wrapper div:nth-of-type(2) a',
                    'values' => array(
                        'Get More Information',
                        'Ask for More Info',
                        'Learn More',
                        'More Info',
                        'Ask a Question',
                        'Let Our Experts Help',
                        'Ask an Expert',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EB0A1E,#EB0A1E)',
                        'border-color' => 'EB0A1E',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#BE0B1B,#BE0B1B)',
                        'border-color' => 'BE0B1B',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#44619D,#44619D)',
                        'border-color' => '44619D',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#374E7E,#374E7E)',
                        'border-color' => '374E7E',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#DE820E,#DE820E)',
                        'border-color' => 'DE820E',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C4730C,#C4730C)',
                        'border-color' => 'C4730C',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#6CADDE,#6CADDE)',
                        'border-color' => '6CADDE',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#588DB4,#588DB4)',
                        'border-color' => '588DB4',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189138,#189138)',
                        'border-color' => '189138',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '14782E',
),
),
),
],
],
    'lead' => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
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
        'text_color' => '#FFFFFF',
        'border_color' => '#FFFFFF',
        'button_color' => array(
            '#FFFFFF',
            '#FFFFFF',
),
        'button_color_hover' => array(
            '#FFFFFF',
            '#FFFFFF',
),
        'button_color_active' => array(
            '#FFFFFF',
            '#FFFFFF',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '',
        'response_email' => '',
        'forward_to' => array(
            '',
),
        'special_to' => array(
            '',
),
        'special_email' => '',
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
),
);