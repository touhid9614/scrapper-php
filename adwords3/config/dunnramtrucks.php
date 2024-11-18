<?php

global $CronConfigs;
$CronConfigs["dunnramtrucks"] = array(
    "name" => " dunnramtrucks",
    "email" => "regan@smedia.ca",
    "password" => " dunnramtrucks",
    "log" => true,
    "banner" => array(
        "template" => "dealership",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#D7353A',
            '#D7353A',
        ),
        'button_color_hover' => array(
            '#FDC915',
            '#FDC915',
        ),
        'button_color_active' => array(
            '#FDC915',
            '#FDC915',
        ),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Claim 2 FREE oil changes with purchase at Dunn Ram Trucks',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Dunn Ram Trucks Team',
        'forward_to' => array(
            'tylerdunn@dunnramtrucks.ca',
            'marshal@smedia.ca',
        ),
        'special_to' => array(
            'dunn.ram.trucks.leads@gmail.com',
        ),
        'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="Murray Dunn Chrysler Dodge Jeep Ram"></id>
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
                                                <comments>[comments] Sent From: [url]</comments>
					</customer>
					<vendor>
						<contact>
							<name part="full">Murray Dunn Chrysler Dodge Jeep Ram</name>
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
);