<?php
global $CronConfigs;
$CronConfigs["lincolnofnormalcom"] = array( 
	"name"  =>" lincolnofnormalcom",
	"email" => "regan@smedia.ca",
	"password" =>" lincolnofnormalcom",
	"log" => true,
	
	"lead"  => array(
	'live'                  => false,
	'lead_type_'            => true,
	'lead_type_new'         => true,
	'lead_type_used'        => true,
	'bg_color'              => "#efefef",
	'text_color'            => "#404450",
	'border_color'          => "#e5e5e5",
	'button_color'          => array("#6f747d", "#6f747d"),
	'button_color_hover'    => array("#c5ccd9", "#c5ccd9"),
	'button_color_active'   => array("#2d2f33", "#2d2f33"),
	'button_text_color'     => "#ffffff",
	'response_email_subject'=> "Request a video tour from Lincoln of Normal",
	'response_email'        => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Lincoln of Normal Team",
	'forward_to'            => array("bloomingtonnormalautomall@s1.eautodealerhub.com","marshal@smedia.ca"),
	'respond_from'          => "offers@mail.smedia.ca",
	'forward_from'          => "offers@mail.smedia.ca",
	'thank_you'             => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
	),
);

