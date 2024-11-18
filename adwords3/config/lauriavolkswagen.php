<?php

global $CronConfigs;
$CronConfigs["lauriavolkswagen"] = array(
    "name" => "lauriavolkswagen",
    "email" => "regan@smedia.ca",
    "password" => "lauriavolkswagen",
    "log" => true,
	"banner" => array(
        "template" => "lauriavolkswagen",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
	"lead"  => array(
		'live'                  => true,
		'lead_type_'            => true,
		'lead_type_new'         => true,
		'lead_type_used'        => true,
		'bg_color'              => "#efefef",
		'text_color'            => "#404450",
		'border_color'          => "#e5e5e5",
		'button_color'          => array("#007db4", "#007db4"),
		'button_color_hover'    => array("#005a81", "#005a81"),
		'button_color_active'   => array("#005a81", "#005a81"),
		'button_text_color'     => "#ffffff",
		'response_email_subject'=> "$250 off coupon from Lauria Volkswagen",
		'response_email'        => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Lauria VW Team",
		'forward_to'            => array("murray.gentles@lauria.ca","marshal@smedia.ca"),
		'special_to'            => array('smedia@lauriavolkswagen.net'),
		'special_email'         =>  '<?xml version="1.0"?>
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
					<vendorname>Lauria Volkswagen</vendorname>
					<contact>
						<name part="full">Lauria Volkswagen</name>
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
		'respond_from'          => "offers@mail.smedia.ca",
		'forward_from'          => "offers@mail.smedia.ca",
		'thank_you'             => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
		'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
	),
);
