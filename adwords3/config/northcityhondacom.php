<?php
global $CronConfigs;
$CronConfigs["northcityhondacom"] = array( 
	"name"  =>" northcityhondacom",
	"email" => "regan@smedia.ca",
	"password" =>" northcityhondacom",
	"log" => true,
	
	"lead"  => array(
	'live'                  => false,
	'lead_type_'            => true,
	'lead_type_new'         => true,
	'lead_type_used'        => true,
	'bg_color'              => "#efefef",
	'text_color'            => "#404450",
	'border_color'          => "#e5e5e5",
	'button_color'          => array("#027fca", "#027fca"),
	'button_color_hover'    => array("#62b1e1", "#62b1e1"),
	'button_color_active'   => array("#034b77", "#034b77"),
	'button_text_color'     => "#ffffff",
	'response_email_subject'=> "Request a video tour from North City Honda",
	'response_email'        => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>North City Honda Team",
	'forward_to'            => array("northcityhonda@s1.eautodealerhub.com","marshal@smedia.ca"),
	'respond_from'          => "offers@mail.smedia.ca",
	'forward_from'          => "offers@mail.smedia.ca",
	'thank_you'             => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
	),
);
