<?php

global $CronConfigs;
$CronConfigs["streetvw"] = array(
    "name" => " streetvw",
    "email" => "regan@smedia.ca",
    "password" => " streetvw",
    "log" => true,
    "banner" => array(
        "template" => "streetvw",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'bg_color' => "#efefef",
        'text_color' => "#404450",
        'border_color' => "#e5e5e5",
        'button_color' => array(
            "#029ddd",
            "#029ddd",
),
        'button_color_hover' => array(
            "#0279aa",
            "#0279aa",
),
        'button_color_active' => array(
            "#0279aa",
            "#0279aa",
),
        'button_text_color' => "#ffffff",
        'response_email_subject' => "\$200 off coupon from Street Volkswagen",
        'response_email' => "Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>Street VW Team",
        'forward_to' => array(
            "marshal@smedia.ca",
),
        'special_to' => array(
            'streetvolkswagen@eleadtrack.net',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="Street Volkswagen"></id>
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
						<name part="full">Street Volkswagen</name>
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
        'respond_from' => "offers@mail.smedia.ca",
        'forward_from' => "offers@mail.smedia.ca",
        'thank_you' => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
),
    'adf_to' => array(
        'streetvolkswagen@eleadtrack.net',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        //check availablity//
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.button.cta-button[href*=gravity-form]',
            'css-class' => 'a.button.cta-button[href*=gravity-form]',
            'css-hover' => 'a.button.cta-button[href*=gravity-form]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a.button.cta-button[href*=gravity-form]',
                    'values' => array(
                        'Get Special Pricing',
                        'Special Price',
                        'Get e-price!',
                        'Get Price Updates',
                        'Get Current Market Price',
                        'Get More Details',
                        'Get Internet Price Now',
                        'Get A Quote',
                        'Inquire Now!',
                        'Confirm Availability',
),
],
],
            'styles' => array(
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#029DDD,#029DDD)',
                        'border-color' => '029DDD',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0485BB,#0485BB)',
                        'border-color' => '0485BB',
                        'text-align' => 'center',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FBA100,#FBA100)',
                        'border-color' => 'FBA100',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C88204,#C88204)',
                        'border-color' => 'C88204',
                        'text-align' => 'center',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2D4AA6,#2D4AA6)',
                        'border-color' => '2D4AA6',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#233A82,#233A82)',
                        'border-color' => '233A82',
                        'text-align' => 'center',
),
),
),
],
        //ask//
        'request-information' => [
            'url-match' => '/\\/inventory\\/(?:new|used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.ask-us-half',
            'css-class' => 'div.ask-us-half',
            'css-hover' => 'div.ask-us-half:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => 'div.ask-us-half',
                    'values' => array(
                        'Ask Question <i class="fa fa-heart-o"></i>',
                        'More Info <i class="fa fa-heart-o"></i>',
                        'Learn More <i class="fa fa-heart-o"></i>',
                        'Ask More Info <i class="fa fa-heart-o"></i>',
                        'Ask an Expert <i class="fa fa-heart-o"></i>',
                        'Get More Details <i class="fa fa-heart-o"></i>',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FBA100,#FBA100)',
                        'border-color' => 'FBA100',
                        'color' => '#fff',
                        'text-align' => 'center',
                        'display' => 'inline-block',
                        'padding' => '16px 30px',
                        'font-family' => 'vwfont,sans-serif',
                        'font-weight' => '700',
                        'font-size' => '14px',
                        'text-transform' => 'uppercase',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C88204,#C88204)',
                        'border-color' => 'C88204',
                        'color' => '#fff',
                        'text-align' => 'center',
                        'display' => 'inline-block',
                        'padding' => '16px 30px',
                        'font-family' => 'vwfont,sans-serif',
                        'font-weight' => '700',
                        'font-size' => '14px',
                        'text-transform' => 'uppercase',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#2D4AA6,#2D4AA6)',
                        'border-color' => '2D4AA6',
                        'color' => '#fff',
                        'text-align' => 'center',
                        'display' => 'inline-block',
                        'padding' => '16px 30px',
                        'font-family' => 'vwfont,sans-serif',
                        'font-weight' => '700',
                        'font-size' => '14px',
                        'text-transform' => 'uppercase',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#233A82,#233A82)',
                        'border-color' => '233A82',
                        'color' => '#fff',
                        'text-align' => 'center',
                        'display' => 'inline-block',
                        'padding' => '16px 30px',
                        'font-family' => 'vwfont,sans-serif',
                        'font-weight' => '700',
                        'font-size' => '14px',
                        'text-transform' => 'uppercase',
),
),
                'light-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#029DDD,#029DDD)',
                        'border-color' => '029DDD',
                        'color' => '#fff',
                        'text-align' => 'center',
                        'display' => 'inline-block',
                        'padding' => '16px 30px',
                        'font-family' => 'vwfont,sans-serif',
                        'font-weight' => '700',
                        'font-size' => '14px',
                        'text-transform' => 'uppercase',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0485BB,#0485BB)',
                        'border-color' => '0485BB',
                        'color' => '#fff',
                        'text-align' => 'center',
                        'display' => 'inline-block',
                        'padding' => '16px 30px',
                        'font-family' => 'vwfont,sans-serif',
                        'font-weight' => '700',
                        'font-size' => '14px',
                        'text-transform' => 'uppercase',
),
),
),
],
],
);