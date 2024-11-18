<?php

global $CronConfigs;
$CronConfigs["islandford"] = array(
    'password' => 'islandford',
    "email" => "regan@smedia.ca",
    'log' => true,
    'tag_debug' => false,
    "banner" => array(
        "template" => "islandford",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more information.",
        //"fb_lookalike_description"	=> "Check out this [year] [make] [model] today! Click for more information.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    "lead" => array(
        'live' => false,
        'lead_type_' => true,
        'lead_type_new' => true,
        'lead_type_used' => true,
        'shown_cap' => false,
        'fillup_cap' => false,
        'session_close' => false,
        'device_type' => array(
            'mobile' => true,
            'desktop' => true,
            'tablet' => true,
),
        'offer_minimum_price' => 0,
        'offer_maximum_price' => 10000000,
        'bg_color' => '#EFEFEF',
        'text_color' => '#404450',
        'border_color' => '#E5E5E5',
        'button_color' => array(
            '#3396CD',
            '#3396CD',
),
        'button_color_hover' => array(
            '#0F2B4E',
            '#0F2B4E',
),
        'button_color_active' => array(
            '#0F2B4E',
            '#0F2B4E',
),
        'button_text_color' => '#FFFFFF',
        'response_email_subject' => '$250 off coupon from Island Ford',
        'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Island Ford Team',
        'forward_to' => array(
            'marshal@smedia.ca',
),
        'special_to' => array(
            'leads@islandford.motosnap.com',
),
        'special_email' => '<?xml version="1.0"?>
		<?adf version="1.0"?>
		<adf>
			<prospect>
				<id sequence="[total_count]" source="sMedia Coupon"></id>
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
						<name part="full">Island Ford</name>
						<email>[dealer_email]</email>
					</contact>
				</vendor>
				<provider>
					<name part="full">sMedia Coupon</name>
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
    'adf_to' => array(
        'leads@islandford.motosnap.com',
        'shahadathossainece08@gmail.com',
),
    'lead_to' => array(
        'leads@islandford.motosnap.com',
        'shahadathossainece08@gmail.com',
),
    'star_to' => array(
        'leads@islandford.motosnap.com',
        'shahadathossainece08@gmail.com',
),
    'form_live' => true,
    'button_algorithm' => 'thompson_sampling|softmax|ucb-1|default',
    'buttons_live' => true,
    'buttons' => [
        'financing' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[data-target="vdp_button_widget-4-modal"]',
            'css-class' => '[data-target="vdp_button_widget-4-modal"]',
            'css-hover' => '[data-target="vdp_button_widget-4-modal"]:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => '[data-target="vdp_button_widget-4-modal"]',
                    'values' => array(
                        'Payment Calculation',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B51F1F,#B51F1F)',
                        'border-color' => 'B51F1F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9C1A1A,#9C1A1A)',
                        'border-color' => '9C1A1A',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#27AC94,#27AC94)',
                        'border-color' => '27AC94',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#21917D,#21917D)',
                        'border-color' => '21917D',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFB905,#FFB905)',
                        'border-color' => 'FFB905',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#E6A605,#E6A605)',
                        'border-color' => 'E6A605',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EE5E03,#EE5E03)',
                        'border-color' => 'EE5E03',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D45202,#D45202)',
                        'border-color' => 'D45202',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3496CD,#3496CD)',
                        'border-color' => '3496CD',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D81B3,#2D81B3)',
                        'border-color' => '2D81B3',
),
),
),
],
        'Used financing' => [
            'url-match' => '/\\/used\\/[^\\/]+\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[href*=financing].btn.btn-primary',
            'css-class' => 'a[href*=financing].btn.btn-primary',
            'css-hover' => 'a[href*=financing].btn.btn-primary:hover',
            'button_action' => [
                'form',
                'finance',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'financing' => [
                    'target' => 'a[href*=financing].btn.btn-primary',
                    'values' => array(
                        'Payment Calculation',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B51F1F,#B51F1F)',
                        'border-color' => 'B51F1F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9C1A1A,#9C1A1A)',
                        'border-color' => '9C1A1A',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#27AC94,#27AC94)',
                        'border-color' => '27AC94',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#21917D,#21917D)',
                        'border-color' => '21917D',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFB905,#FFB905)',
                        'border-color' => 'FFB905',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#E6A605,#E6A605)',
                        'border-color' => 'E6A605',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EE5E03,#EE5E03)',
                        'border-color' => 'EE5E03',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D45202,#D45202)',
                        'border-color' => 'D45202',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3496CD,#3496CD)',
                        'border-color' => '3496CD',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D81B3,#2D81B3)',
                        'border-color' => '2D81B3',
),
),
),
],
        'request-information' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '[data-target="vdp_button_widget-8-modal"]',
            'css-class' => '[data-target="vdp_button_widget-8-modal"]',
            'css-hover' => '[data-target="vdp_button_widget-8-modal"]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => '[data-target="vdp_button_widget-8-modal"]',
                    'values' => array(
                        'Get More Information',
                        'Ask A Question',
                        'Get More Details',
                        'Ask More Info',
                        'Learn More',
                        'Special Pricing',
                        'Best Price',
                        'Exclusive Price',
                        'Ask Us Anything!',
                        'More Info',
                        'Request Information',
                        'Request Info',
                        'Get Your Exclusive Price',
                        'Get Employee price!',
                        'Get Your Employee Price',
                        'Get Employee Pricing Now',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B51F1F,#B51F1F)',
                        'border-color' => 'B51F1F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9C1A1A,#9C1A1A)',
                        'border-color' => '9C1A1A',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#27AC94,#27AC94)',
                        'border-color' => '27AC94',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#21917D,#21917D)',
                        'border-color' => '21917D',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFB905,#FFB905)',
                        'border-color' => 'FFB905',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#E6A605,#E6A605)',
                        'border-color' => 'E6A605',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EE5E03,#EE5E03)',
                        'border-color' => 'EE5E03',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D45202,#D45202)',
                        'border-color' => 'D45202',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3496CD,#3496CD)',
                        'border-color' => '3496CD',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D81B3,#2D81B3)',
                        'border-color' => '2D81B3',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.vdp-button-widget a[href*=trade-in-form]',
            'css-class' => '.vdp-button-widget a[href*=trade-in-form]',
            'css-hover' => '.vdp-button-widget a[href*=trade-in-form]:hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => '.vdp-button-widget a[href*=trade-in-form]',
                    'values' => array(
                        'What\'s Your Trade Worth?',
                        'Trade Appraisal',
                        'Appraise Your Trade',
                        'Get Trade-In Value',
                        'Trade-In Appraisal',
                        'Appraise My Trade',
),
],
],
            'styles' => array(
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B51F1F,#B51F1F)',
                        'border-color' => 'B51F1F',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#9C1A1A,#9C1A1A)',
                        'border-color' => '9C1A1A',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#27AC94,#27AC94)',
                        'border-color' => '27AC94',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#21917D,#21917D)',
                        'border-color' => '21917D',
),
),
                'yellow' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#FFB905,#FFB905)',
                        'border-color' => 'FFB905',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#E6A605,#E6A605)',
                        'border-color' => 'E6A605',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#EE5E03,#EE5E03)',
                        'border-color' => 'EE5E03',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#D45202,#D45202)',
                        'border-color' => 'D45202',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#3496CD,#3496CD)',
                        'border-color' => '3496CD',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#2D81B3,#2D81B3)',
                        'border-color' => '2D81B3',
),
),
),
],
],
);