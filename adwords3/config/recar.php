<?php

global $CronConfigs;
$CronConfigs["recar"] = array(
    'password' => 'recar2018',
    "email" => "regan@smedia.ca",
    'log' => true,
    'adgroup_version' => 'v8',
    'max_cost' => 0,
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_display" => yes,
        "used_display" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        "new_combined" => yes,
        "used_combined" => yes,
),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today",
),
),
    'customer_id' => '453-271-9472',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "recar",
        "fb_retargeting_description" => "Are you still interested in the [year] [make] [model]? Get our best price right off the bat!",
        "fb_lookalike_description" => "Shop this [year] [make] [model] from the comfort of your home!",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below and fill in your information to claim your \$50 gas card. A product specialist will get in touch to help.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
),
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'dropdown_values' => array(
            'webleads@recar.dsmessage.com' => 'Recar Fredericton',
            'webleads@recarsaintjohn.dsmessage.com' => 'ReCar Saint John',
),
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#19A4EC',
            '#19A4EC',
),
        'button_color_hover' => array(
            '#1490D0',
            '#1490D0',
),
        'button_color_active' => array(
            '#333333',
            '#333333',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Claim your $50 gas card from Recar Fredericton',
        'response_email' => 'Hello [name],
<p>We are please to extend to you this special coupon, should you decide to purchase your next vehicle through ReCar<br>
At ReCar we offer:<br><br>

12-MONTH GUARANTEE<br>
Regardless of the make and mileage, all ReCar Certified vehicles come with a twelve month warranty at absolutely no charge. This warranty applies even if your vehicle comes with a factory warranty!<br><br>

QUALITY GUARANTEED<br>
170 Step Mechanical and Cosmetic Inspection - Over 300% more detailed than a standard dealership motor vehicle inspection.<br><br>

FIXED, PRE-NEGOTIATED, NO HASSLE PRICING<br>
No more hassle. No more stress. Our best price right off the bat.<br><br>

7 DAY TEST-OWN<br>
Take your vehicle home to make sure that it fits your lifestyle and your needs. If for any reason it doesn\'t, you have seven days to come back and exchange it for another vehicle, no questions asked!<br><br>

NON COMMISSIONED VEHICLE ADVISORS<br>
Salaried Advisors means their goals and yours are exactly the same to make sure you get the vehicle that best fits your life and family at the best possible price.<br><br>

FAST, FLEXIBLE FINANCING - FOR EVERYONE<br>
We work with over 16 banks and financial institutions all across Canada; not only to get you the best possible rates, but also to provide you with the best possible terms, regardless of your credit situation.<br><br>

<p>ReCar Is built on the fundamental principles of integrity and treating people with respect. We are also a disruptor within the Auto Industry by offering our Guests Fixed, No-Haggle Pricing on all of our Certified Vehicles, as well as an environment where our Vehicle Advisors are Non-Commissioned Salaried Positions as opposed to straight commission like most automotive salespeople. Today\\’s auto buyer doesn\\’t want to have to come in and haggle and negotiate in order to get their “best deal”, nor do they want to be serviced by someone who is incentivized for selling them the car with the most mark-up as opposed to the best fit for them and their family.</p>

Welcome to the ReCar Revolution.<br><br>

<p>Thank you for the opportunity to earn your business, we look forward to meeting you soon.</p><br>
Sincerely:<br><br>
Recar Team<br>
www.Recar.ca<br><br>

*<i>Please print this off or show your sales professional this email on your phone to claim. Hurry though! This offer expires in 30 days!</i><br><br><img src="[image]"/><p><br><br>Recar Fredericton Team',
        'forward_to' => array(
            'paco@volvocarsnb.com',
            'lori@shiftautogroup.ca',
            'marshal@smedia.ca',
),
        'special_to' => array(
            'recarsjleads@gmail.com',
),
        'special_email' => '<?xml version="1.0"?>
			<?adf version="1.0"?>
			<adf>
				<prospect>
					<id sequence="[total_count]" source="Recar Fredericton"></id>
					<requestdate>[fdt]</requestdate>
					<vehicle interest="buy" status="[stock_type]">
						<year>[year]</year>
						<make>[make]</make>
						<model>[model]</model>
						<stock>[stock_number]</stock>
						<url>[url]</url>
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
							<name part="full">Recar Fredericton</name>
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
        'respond_from' => 'offers@mail.smedia.ca',
        'forward_from' => 'offers@mail.smedia.ca',
        'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
),
    'form_live' => false,
    'buttons_live' => false,
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'button.btn-orange-vehicles1.icon-youtube',
            'css-class' => 'button.btn-orange-vehicles1.icon-youtube',
            'css-hover' => 'button.btn-orange-vehicles1.icon-youtube:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'button.btn-orange-vehicles1.icon-youtube span',
                    'values' => array(
                        'Request A Quote',
                        'Internet Price',
                        'Get Internet Price Now!',
                        'Get Our Best Price',
                        'Best Price',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#188bb7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188bb7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
),
),
),
],
        'request-information' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'button#request-info',
            'css-class' => 'button#request-info',
            'css-hover' => 'button#request-info:hover',
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => 'button#request-info span',
                    'values' => array(
                        'Get More Information',
                        'Request Information',
                        'Contact Store',
                        'Book Test Drive',
                        'Get More Information',
                        'Ask a Question',
                        'Inquire Now',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#188bb7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188bb7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'button.btn-orange-vehicles1.icon-cta-icons-14',
            'css-class' => 'button.btn-orange-vehicles1.icon-cta-icons-14',
            'css-hover' => 'button.btn-orange-vehicles1.icon-cta-icons-14:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'button.btn-orange-vehicles1.icon-cta-icons-14 span',
                    'values' => array(
                        'Appraise my trade in',
                        'Value your trade',
                        'We want your car',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#188bb7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188bb7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
),
),
),
],
        'financing' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'button#apply-for-finance',
            'css-class' => 'button#apply-for-finance',
            'css-hover' => 'button#apply-for-finance:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'button#apply-for-finance span',
                    'values' => array(
                        'Apply for Financing',
                        'Financing Available',
                        'Explore Payments',
                        'TODAY\'S MARKET PRICE',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#188bb7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188bb7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/(?:new|used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.btn-orange-vehicles1.icon-Wheel',
            'css-class' => '.btn-orange-vehicles1.icon-Wheel',
            'css-hover' => '.btn-orange-vehicles1.icon-Wheel:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => '.btn-orange-vehicles1.icon-Wheel span',
                    'values' => array(
                        'Book Test Drive',
                        'Schedule Test Drive',
                        'Test Drive Now',
                        'TEST RIDE',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => '#f06b20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => '#cf540e',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => '#e01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => '#c60c0d',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '#54b740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '#359d22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '#188bb7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '#188bb7',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '#188bb7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '#1ca0d1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '#188bb7',
),
),
),
],
],
    'cost_distribution' => array(
        'used' => 5300,
),
);