<?php
global $CronConfigs;
 $CronConfigs["indyhyundai"] = array( 
	"name"  =>" indyhyundai",
	"email" => "regan@smedia.ca",
	"password" =>" indyhyundai",
	'fb_brand'          => '[year] [make] [model] - [body_style]',	"log" => true ,
	
	"lead"  => array(
		'live'                  => false,
		'lead_type_'            => true,
		'lead_type_new'         => true,
		'lead_type_used'        => true,
		'bg_color'              => "#efefef",
		'text_color'            => "#404450",
		'border_color'          => "#e5e5e5",
		'button_color'          => array("#00acec", "#00acec"),
		'button_color_hover'    => array("#096283", "#096283"),
		'button_color_active'   => array("#096283", "#096283"),
		'button_text_color'     => "#ffffff",
		'response_email_subject'=> "$200 offer from Indy Hyundai",
		'response_email'        => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Indy Hyundai Team",
		'forward_to'            => array("dealership@dealership.com","marshal@smedia.ca"),
		'respond_from'          => "offers@mail.smedia.ca",
		'forward_from'          => "offers@mail.smedia.ca",
		'thank_you'             => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
	),
	
	"banner" => array(
        "template" => "indyhyundai",
			"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
			"fb_lookalike_description"	=> "Check out this [year] [make] [model]! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "ffffff",
    ),
);