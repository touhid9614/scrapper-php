<?php

global $CronConfigs;
$CronConfigs["sherwoodparkchev"] = array(
    'password' => 'sherwoodparkchev',
    "email" => "regan@smedia.ca",
    'log' => true,
    'tag_debug' => false,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "sherwoodparkchev",
        'fb_description' => "Are you still interested in the [year] [make] [model]? Click for more info!",
        //'fb_description_2019_camaro' => "Up to \$13,000 off MSRP all remaining 2019 Camaros only at Sherwood Park Chevrolet! Hurry before they go into storage for the Winter! Shop below.",
        //'fb_description_2019_corvette' => "Up to \$20,000 off MSRP off all remaining 2019 Corvettes at Sherwood Park Chevrolet! Hurry before they go into storage for the Winter! Shop below.",
        'fb_lookalike_description' => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to answer any questions.",
        "fb_marketplace_description" => "[description]",
        "old_price" => "msrp",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        'snapchat_image_index' => 0,
),
    "lead" => array(
        'live' => true,
        'lead_type_' => true,
        'lead_type_new' => true,
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
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#9C7E0F',
            '#9C7E0F',
),
        'button_color_hover' => array(
            '#282827',
            '#282827',
),
        'button_color_active' => array(
            '#282827',
            '#282827',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Schedule A Virtual Test Drive',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Sherwood Park Chevrolet Team',
        'forward_to' => array(
            'lbucket7969@sherwoodparkchevrolet.motosnap.com',
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@sherwoodparkchevrolet.motosnap.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="sMedia Coupon"></id>
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
						<name part="full">Sherwood Park Chevrolet</name>
						<email>[dealer_email]</email>
					</contact>
				</vendor>
				<provider>
					<name part="full">sMedia Coupon</name>
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
),
    'adf_to' => array(
        'leads@sherwoodparkchevrolet.motosnap.com',
),
    'lead_to' => array(
        'lbucket7969@sherwoodparkchevrolet.motosnap.com',
),
    'form_live' => true,
    'buttons_live' => true,
    'form_disclaimer' => '<h5 style="display: inline; font-weight: bold">Qualified customers will receive an additional</h5><h3 style="display: inline; font-weight: bold">&nbsp;$600 off&nbsp;</h3><h5 style="display: inline; font-weight: bold">this vehicle!*</h5><br><br> <h6>*A customer is qualified by submitting both a valid phone number & email address.</h6>',
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=eprice-form]',
            'css-class' => 'a[href*=eprice-form]',
            'css-hover' => 'a[href*=eprice-form]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[href*=eprice-form]',
                    'values' => array(
                        'Local Pricing',
                        'More Info',
                        'More Information!',
                        'Check Availability',
                        'Confirm Availability',
                        'SPECIAL PRICING!',
                        'Calculate Payments',
                        'Estimate Payments',
                        'Local Price',
                        'Get more info!',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1996E9,#1996E9)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9C7E0F,#9C7E0F)',
                        'border-color' => '359D22',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C18402,#C18402)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9C7E0F,#9C7E0F)',
                        'border-color' => '359D22',
),
),
                'black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#39393B,#39393B)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9C7E0F,#9C7E0F)',
                        'border-color' => '359D22',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B22,#F06B22)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3A8D40,#3A8D40)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9C7E0F,#9C7E0F)',
                        'border-color' => '359D22',
),
),
),
],
],
);