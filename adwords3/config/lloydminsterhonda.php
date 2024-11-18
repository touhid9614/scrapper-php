<?php
global $CronConfigs;
 $CronConfigs["lloydminsterhonda"] = array( 
	"name"  =>" lloydminsterhonda",
	"email" => "regan@smedia.ca",
	"password" =>" lloydminsterhonda",
	"log" => true ,
	
	"banner" => array(
        "template" => "lloydminsterhonda",
		"fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
		"fb_lookalike_description"	=> "Check out this [year] [make] [model]! Click for more information.",
		//"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
    ),
	
	"lead"  => array(
	'live'                  => false,
	'lead_type_'            => true,
	'lead_type_new'         => true,
	'lead_type_used'        => true,
	'bg_color'              => "#efefef",
	'text_color'            => "#404450",
	'border_color'          => "#e5e5e5",
	'button_color'          => array("#e30000", "#e30000"),
	'button_color_hover'    => array("#570000", "#570000"),
	'button_color_active'   => array("#570000", "#570000"),
	'button_text_color'     => "#ffffff",
	'response_email_subject'=> "$200 coupon from Lloydminster Honda",
	'response_email'        => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Lloydminster Honda Team",
	'forward_to'            => array("travis@lloydminsterhonda.com","jon@lloydminsterhonda.ca","marshal@smedia.ca"),
	'respond_from'          => "offers@mail.smedia.ca",
	'forward_from'          => "offers@mail.smedia.ca",
	'thank_you'             => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
	),
);

