<?php
global $CronConfigs;
 $CronConfigs["plainviewcdjr"] = array( 
	"name"  =>" plainviewcdjr",
	"email" => "regan@smedia.ca",
	"password" =>" plainviewcdjr",
	"log" => true ,
	
	"lead"  => array(
	'live'                  => false,
	'lead_type_'            => true,
	'lead_type_new'         => true,
	'lead_type_used'        => true,
	'bg_color'              => "#efefef",
	'text_color'            => "#404450",
	'border_color'          => "#e5e5e5",
	'button_color'          => array("#1a75dd", "#1a75dd"),
	'button_color_hover'    => array("#11427a", "#11427a"),
	'button_color_active'   => array("#11427a", "#11427a"),
	'button_text_color'     => "#ffffff",
	'response_email_subject'=> "$200 off coupon from Plainview CJDR",
	'response_email'        => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Plainview CJDR Team",
	'forward_to'            => array("marshal@smedia.ca"),
	'special_to'            => array('paul.lamonica@autoinc.com'),
	'special_email'         =>  '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Plainview CJDR"></id>
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
					<contact>
						<name part="full">Plainview CJDR</name>
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
	),
);

