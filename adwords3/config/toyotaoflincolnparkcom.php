<?php
global $CronConfigs;
$CronConfigs["toyotaoflincolnparkcom"] = array( 
	"name"  =>" toyotaoflincolnparkcom",
	"email" => "regan@smedia.ca",
	"password" =>" toyotaoflincolnparkcom",
	"log" => true,
	
	"lead"  => array(
	'live'                  => false,
	'lead_type_'            => true,
	'lead_type_new'         => true,
	'lead_type_used'        => true,
	'bg_color'              => "#efefef",
	'text_color'            => "#404450",
	'border_color'          => "#e5e5e5",
	'button_color'          => array("#ed1b2f", "#ed1b2f"),
	'button_color_hover'    => array("#f36371", "#f36371"),
	'button_color_active'   => array("#8b101c", "#8b101c"),
	'button_text_color'     => "#ffffff",
	'response_email_subject'=> "Request Video Tour from Toyota of Lincoln Park",
	'response_email'        => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Toyota of Lincoln Park Team",
	'forward_to'            => array("toyotaoflincolnpark@s1.eautodealerhub.com","marshal@smedia.ca"),
	'respond_from'          => "offers@mail.smedia.ca",
	'forward_from'          => "offers@mail.smedia.ca",
	'thank_you'             => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
	),
);

