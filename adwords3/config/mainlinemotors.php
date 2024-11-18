<?php

global $CronConfigs;
$CronConfigs["mainlinemotors"] = array(
    'name' => 'Main Line Motors',
    //'budget'    => 2.0,
    'log' => true,
    //'tag_debug' => true,
    'adgroup_version' => 'v5',
    'password' => 'mainlinemotors',
    'bid' => 3.0,
    'bid_modifier' => array(
        'after' => 45,
        //days
        'bid' => 1.5,
),
    'bing_account_id' => 156002884,
    'tag_debug' => false,
    'max_cost' => 2200,
    'cost_distribution' => array(
        'new' => 1000,
        'used' => 1200,
),
    'post_code' => 'S0L 2V0',
    "email" => "regan@smedia.ca",
    "lead" => array(
        'live' => false,
        'lead_type_' => false,
        'lead_type_new' => false,
        'lead_type_used' => false,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'device_type' => array(
            'mobile' => false,
            'desktop' => false,
            'tablet' => false,
),
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#015DAB',
            '#015DAB',
),
        'button_color_hover' => array(
            '#004D8E',
            '#004D8E',
),
        'button_color_active' => array(
            '#015DAB',
            '#015DAB',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => 'Win Free Fuel for A Year from Rosetown Mainline Motors',
        'response_email' => 'Hello [name],<p> Thanks for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Rosetown Mainline Team',
        'forward_to' => array(
            'smurdoch@rosetownmainline.net',
            'scottm@rosetownmainline.net',
            'kmenei@rosetownmainline.net',
            'kdukes@rosetownmainline.net',
            'marshal@smedia.ca',
            'cwagar@rosetownmainline.net',
),
        'special_to' => array(
            'smedia@rosetownmainlinemotor.net',
            'adf_to@smedia.ca',
            'tamissy13@gmail.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="sMedia Smart Offer"></id>
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
						<name part="full">Rosetown Mainline</name>
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
        'display_after' => 30000,
        'retarget_after' => 5000,
        'fb_retarget_after' => 5000,
        'adword_retarget_after' => 5000,
        'visit_count' => 0,
),
    "smart_ad_url" => "http://www.rosetownmainline.net/VehicleSearchResults?pageContext=VehicleSearch&search=preowned&bodyType=All&make=[make]&model=[model]&trim=All&minPrice=-2147483648&maxPrice=2147483647&minYear=[year]&maxYear=[year]&minMileage=-2147483648&maxMileage=2147483647&minMPG=-2147483648&maxMPG=2147483647",
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_display" => yes,
        "used_display" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
        "new_search_retargeting" => yes,
        "used_search_retargeting" => yes,
        "new_marketbuyers" => yes,
        "used_marketbuyers" => yes,
        "new_combined" => yes,
        "used_combined" => yes,
),
    "new_descs" => array(
        array(
            "desc1" => "King of Trucks. Call about",
            "desc2" => "the [year] [make] [model].",
),
        array(
            "desc1" => "King of Trucks. Test Drive",
            "desc2" => "The [make] [model]",
),
        array(
            "desc1" => "King of Trucks. Test Drive",
            "desc2" => "The [year] [make] [model]",
),
),
    "used_descs" => array(
        array(
            "desc1" => "King of Trucks. Call about",
            "desc2" => "the [year] [make] [model].",
),
        array(
            "desc1" => "King of Trucks. Test Drive",
            "desc2" => "The [make] [model]",
),
        array(
            "desc1" => "King of Trucks. Test Drive",
            "desc2" => "The [year] [make] [model]",
),
),
    "customer_id" => "300-354-9504",
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "mainlinemotors",
        //"fb_description_new" => "Are you still interested in the [year] [make] [model]? We guarantee to beat any other dealer's price quote by $1000 on the same vehicle! Click for more information.",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        /* lookalike */
        //"fb_lookalike_description_new" => "Test drive the [year] [make] [model]. We guarantee to beat any other dealer's price quote by $1000 on the same vehicle! Click for more information.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more info.",
        /* dynamiclead */
        //"fb_dynamiclead_description_new" => "Are you still interested in the [year] [make] [model]? We guarantee to beat any other dealer's price quote by $1000 on the same vehicle! Click below and fill in your information - a product specialist will get in touch to help.",
        "fb_dynamiclead_description" => "Are you still interested in the [year] [make] [model]? Click below and fill in your information - a product specialist will get in touch to help.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "old_price_new" => "msrp",
        "styels" => array(
            "new_display" => "custom_banner_black",
            "used_display" => "custom_banner_black",
            "new_retargeting" => "custom_banner_black",
            "used_retargeting" => "custom_banner_black",
            "new_marketbuyers" => "custom_banner_black",
            "used_marketbuyers" => "custom_banner_black",
),
        "font_color" => "#ffffff",
        "min_pics" => 2,
        'snapchat_image_index' => 0,
),
    'adf_to' => array(
        'smedia@rosetownmainlinemotor.net',
),
    'form_live' => true,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => true,
    'buttons' => [
        'request-a-quote-top' => [
            'url-match' => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.di-modal.main-cta.vdp-pricebox-cta-button',
            'css-class' => 'a.di-modal.main-cta.vdp-pricebox-cta-button',
            'css-hover' => 'a.di-modal.main-cta.vdp-pricebox-cta-button:hover',
            'button_action' => [
                'form',
                'e-price-phone_optional',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote-top' => [
                    'target' => 'a.di-modal.main-cta.vdp-pricebox-cta-button',
                    'values' => array(
                        'Check Availability',
                        'Get Special Price!',
                        'SPECIAL PRICING!',
                        'Get E Price Now!',
                        'Internet Price',
                        'Get your Price!',
                        'Get Internet Price Now!',
                        'Get Our Best Price',
                        'Best Price',
                        'Local Pricing',
                        'You are Eligible  for Special Pricing',
                        'Special Pricing!',
                        'Get More Information',
                        'Ask a Question',
                        'Get Active Market Price',
                        'Get Market Price',
                        'Market Pricing',
                        'Drive-Away Price',
                        'Check Availability',
                        'Exclusive Price',
                        'Consultation',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
],
        //        'request-a-quote-bottom' => [
        //            'url-match' => '/\\/VehicleDetails\\/(?:new|used)-[0-9]{4}-/i',
        //            'target' => null,
        //            //Don't move button
        //            'locations' => [
        //                'default' => null,
        //],
        //            'action-target' => 'a[name="0c82f979-f41f-496d-8d14-33d215fc6a6f"]',
        //            'css-class' => 'a[name="0c82f979-f41f-496d-8d14-33d215fc6a6f"]',
        //            'css-hover' => 'a[name="0c82f979-f41f-496d-8d14-33d215fc6a6f"]:hover',
        //            'button_action' => [
        //                'form',
        //                'e-price-phone_optional',
        //],
        //            'sizes' => [
        //                '100' => [],
        //],
        //            'texts' => [
        //                'request-a-quote-bottom' => [
        //                    'target' => 'a[name="0c82f979-f41f-496d-8d14-33d215fc6a6f"]',
        //                    'values' => array(
        //                        'Get E Price Now!',
        //                        'Internet Price',
        //                        'Get your Price!',
        //                        'Get Internet Price Now!',
        //                        'Get Our Best Price',
        //                        'Best Price',
        //                        'Local Pricing',
        //                        'You are Eligible  for Special Pricing',
        //                        'Special Pricing!',
        //                        'Get More Information',
        //                        'Ask a Question',
        //                        'Get Active Market Price',
        //                        'Get Market Price',
        //                        'Market Pricing',
        //                        'Drive-Away Price',
        //                        'Check Availability',
        //                        'Get Special Price!',
        //                        'SPECIAL PRICING!',
        //                        'Check Availability',
        //                        'Exclusive Price',
        //                        'Consultation',
        //),
        //],
        //],
        //            'styles' => array(
        //                'orange' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#F06B20,#F06B20)',
        //                        'border-color' => 'F06B20',
        //),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#CF540E,#CF540E)',
        //                        'border-color' => 'CF540E',
        //),
        //),
        //                'red' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#E01212,#E01212)',
        //                        'border-color' => 'E01212',
        //),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
        //                        'border-color' => 'C60C0D',
        //),
        //),
        //                'green' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#54B740,#54B740)',
        //                        'border-color' => '54B740',
        //),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#359D22,#359D22)',
        //                        'border-color' => '359D22',
        //),
        //),
        //                'blue' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
        //                        'border-color' => '1CA0D1',
        //),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#188BB7,#188BB7)',
        //                        'border-color' => '188BB7',
        //),
        //),
        //),
        //],
        'financing' => [
            'url-match' => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href="/finance/apply-for-financing/"]',
            'css-class' => 'a[href="/finance/apply-for-financing/"]',
            'css-hover' => 'a[href="/finance/apply-for-financing/"]:hover',
            //            'button_action' => [
            //                'form',
            //                'finance-phone_optional',
            //            ],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a[href="/finance/apply-for-financing/"]',
                    'values' => array(
                        'GET APPROVED',
                        'Special Finance Offers',
                        'Financing Available',
                        'Apply For Financing',
                        'Get Financed Today',
                        'No Hassle Financing',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href="/value-your-trade/"]',
            'css-class' => 'a[href="/value-your-trade/"]',
            'css-hover' => 'a[href="/value-your-trade/"]:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => 'a[href="/value-your-trade/"]',
                    'values' => array(
                        'What\'s Your Trade Worth?',
                        'Value Your Trade',
                        'We\'ll Buy Your Car',
                        'Trade-In Offer',
                        'Trade In Your Ride',
                        'We Want Your Car',
                        'Trade Offer',
                        'Trade-In Appraisal',
                        'Appraise Your Trade',
                        'Get Trade-In Value',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.vdp-component.vdp-cta-row div a:nth-of-type(1)',
            'css-class' => '.vdp-component.vdp-cta-row div a:nth-of-type(1)',
            'css-hover' => '.vdp-component.vdp-cta-row div a:nth-of-type(1):hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => '.vdp-component.vdp-cta-row div a:nth-of-type(1)',
                    'values' => array(
                        'Book Test Drive',
                        'Test Drive Now',
                        'Test Drive Today',
                        'Want To Test Drive?',
                        'Schedule Your Test Drive',
                        'Request A Test Drive',
                        'Schedule Your Visit',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
],
        'get-eprice' => [
            'url-match' => '/\\/inventory\\/(?:used|new|certified-used|certified)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.vdp-component.vdp-cta-row div a:nth-of-type(2)',
            'css-class' => '.vdp-component.vdp-cta-row div a:nth-of-type(2)',
            'css-hover' => '.vdp-component.vdp-cta-row div a:nth-of-type(2):hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'get-eprice' => [
                    'target' => '.vdp-component.vdp-cta-row div a:nth-of-type(2)',
                    'values' => array(
                        'Check Availability',
                        'Get Special Price!',
                        'SPECIAL PRICING!',
                        'Get E Price Now!',
                        'Internet Price',
                        'Get your Price!',
                        'Get Internet Price Now!',
                        'Get Our Best Price',
                        'Best Price',
                        'Local Pricing',
                        'You are Eligible  for Special Pricing',
                        'Special Pricing!',
                        'Get More Information',
                        'Ask a Question',
                        'Get Active Market Price',
                        'Get Market Price',
                        'Market Pricing',
                        'Drive-Away Price',
                        'Check Availability',
                        'Exclusive Price',
                        'Consultation',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
),
),
),
],
],
    'smart_banner' => array(
        'live' => null,
        'title' => 'Would you like to continue shopping for the ?',
),
    'lead_to' => array(
        'smurdoch@rosetownmainline.net',
),
    'vinnauto' => array(
        'button_status' => true,
        'button_debug' => true,
        'dealership_id' => '3be4ec8c-340d-4659-9718-d73c8902010c',
        'VINN_SIGNING_SECRET' => 'adslfkjasldfjk',
        'button_position' => 'beforebegin',
        'button_container' => '#main > section > div.deck > section:nth-child(2) > div.deck > section:nth-child(2) > div.content > div.link',
        'button_code' => 'class="primary"',
        'button_text' => 'CHECKOUT',
),
);