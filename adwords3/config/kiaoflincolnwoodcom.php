<?php
global $CronConfigs;
$CronConfigs["kiaoflincolnwoodcom"] = array( 
	"name"  =>" kiaoflincolnwoodcom",
	"email" => "regan@smedia.ca",
	"password" =>" kiaoflincolnwoodcom",
	"log" => true,
	
	"lead"  => array(
	'live'                  => FALSE,
	'lead_type_'            => true,
	'lead_type_new'         => true,
	'lead_type_used'        => true,
	'bg_color'              => "#efefef",
	'text_color'            => "#404450",
	'border_color'          => "#e5e5e5",
	'button_color'          => array("#ba1828", "#ba1828"),
	'button_color_hover'    => array("#ff6171", "#ff6171"),
	'button_color_active'   => array("#620c14", "#620c14"),
	'button_text_color'     => "#ffffff",
	'response_email_subject'=> "Request a video tour from Kia of Licolnwood",
	'response_email'        => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Kia of Licolnwood Team",
	'forward_to'            => array("kiaoflincolnwood@s1.eautodealerhub.com","marshal@smedia.ca"),
	'respond_from'          => "offers@mail.smedia.ca",
	'forward_from'          => "offers@mail.smedia.ca",
	'thank_you'             => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
	),
);

