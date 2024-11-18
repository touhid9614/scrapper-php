<?php
global $CronConfigs;
 $CronConfigs["suntanmarine"] = array( 
	"name"  =>" suntanmarine",
	"email" => "regan@smedia.ca",
	"password" =>" suntanmarine",
	"log" => true ,
	"banner" => array(
        "template" => "suntanmarine",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
		"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below and fill in your information. A product specialist will be in touch to answer any questions.",
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
		'button_color'          => array("#003882", "#003882"),
		'button_color_hover'    => array("#ffbf00", "#ffbf00"),
		'button_color_active'   => array("#ffbf00", "#ffbf00"),
		'button_text_color'     => "#ffffff",
		'response_email_subject'=> "Win a trip to Cuba",
		'response_email'        => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Suntan RV & Marine Team",
		'forward_to'            => array("bgreen@alexandriacc.ca","marshal@smedia.ca"),
		'respond_from'          => "offers@mail.smedia.ca",
		'forward_from'          => "offers@mail.smedia.ca",
		'thank_you'             => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
	),
);