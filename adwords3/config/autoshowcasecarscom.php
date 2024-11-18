<?php
global $CronConfigs;
$CronConfigs["autoshowcasecarscom"] = array( 
	"name"  =>" autoshowcasecarscom",
	"email" => "regan@smedia.ca",
	"password" =>" autoshowcasecarscom",
	"log" => true,
	
	"banner" => array(
        "template" => "autoshowcasecarscom",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff"
    ),
	
	"lead"  => array(
		'live'                  => false,
		'lead_type_'            => true,
		'lead_type_new'         => true,
		'lead_type_used'        => true,
		'bg_color'              => "#efefef",
		'text_color'            => "#404450",
		'border_color'          => "#e5e5e5",
		'button_color'          => array("#0d65bf", "#0d65bf"),
		'button_color_hover'    => array("#000000", "#000000"),
		'button_color_active'   => array("#000000", "#000000"),
		'button_text_color'     => "#ffffff",
		'response_email_subject'=> "Request Video Walk-Around of Vehicle",
		'response_email'        => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Auto Showcase Motors Team",
		'forward_to'            => array("marshal@smedia.ca"),
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

