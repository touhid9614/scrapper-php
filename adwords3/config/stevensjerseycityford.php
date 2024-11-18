<?php

global $CronConfigs;
$CronConfigs["stevensjerseycityford"] = array(
    'password' => 'stevensjerseycityford',
    "email" => "regan@smedia.ca",
    'log' => true,
    'fb_title' => '[year] [make] [model] [body_style] [price]',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'max_cost' => 500,
    'cost_distribution' => array(
        'adwords' => 500,
),
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
    'customer_id' => '884-482-3396',
    "banner" => array(
        "template" => "stevensjerseycityford",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        //			"fb_dynamiclead_description"	=> "Are you still interested in the [year] [make] [model]? Click below, fill in your info, and a product specialist will be in touch to aid in any questions.",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "dynamic_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "dynamic_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "dynamic_banner",
),
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
),
    /*    "lead" => array(
              'live' => true,
              'lead_type_' => true,
              'lead_type_new' => true,
              'lead_type_used' => true,
              'bg_color' => '#EFEFEF',
              'text_color' => '#404450',
              'border_color' => '#E5E5E5',
              'button_color' => array(
                  '#1393D2',
                  '#1393D2',
              ),
              'button_color_hover' => array(
                  '#0F70AF',
                  '#0F70AF',
              ),
              'button_color_active' => array(
                  '#0F70AF',
                  '#0F70AF',
              ),
              'button_text_color' => '#FFFFFF',
              'response_email_subject' => '$250 OFF coupon from Steven\'s Jersey City Ford',
              'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Steven\'s Jersey City Ford Team',
              'forward_to' => array(
                  'fordofjersey@gmail.com',
                  'marshal@smedia.ca',
                  'emil@smedia.ca',
                  'kblanchette@jerseyford.com',
              ),
              'respond_from' => 'offers@mail.smedia.ca',
              'forward_from' => 'offers@mail.smedia.ca',
              'thank_you' => '<h1 style="margin: 100px 27px; text-align: center;">Thank you</h1>',
          ),*/
    'adf_to' => array(
        'jerseyford@fordbdc.com',
        'fordofjersey@gmail.com',
),
    'form_live' => false,
    'buttons_live' => false,
    'lead_from' => array(
        'joran@smedia.ca',
),
    //   'forward_from'          => "joran@smedia.ca",
    'buttons' => [
        'request-a-quote' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}/i',
            'target' => null,
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[data-href*=eprice-form]',
            'css-class' => 'a[data-href*=eprice-form]',
            'css-hover' => 'a[data-href*=eprice-form]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => 'a[data-href*=eprice-form]',
                    'values' => array(
                        'Check Availability',
                        'Confirm Availability',
                        'Get Availability',
                        'Ask for Availability',
                        'Get More Info',
                        'Request More Info',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '0075C9',
                        'color' => '#fff ',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '0066AF',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E43C25,#E43C25)',
                        'border-color' => 'D21815',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'B81512',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'FC5F19',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'E25516',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189238,#189238)',
                        'border-color' => '96960F',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '7C7C0C',
                        'color' => '#fff',
),
),
),
],
        'test-drive' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[data-href*=schedule-form]',
            'css-class' => 'a[data-href*=schedule-form]',
            'css-hover' => 'a[data-href*=schedule-form]:hover',
            'button_action' => [
                'form',
                'test-drive',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'test-drive' => [
                    'target' => 'a[data-href*=schedule-form]',
                    'values' => array(
                        'Request a Test Drive',
                        'Schedule a Test Drive',
                        'Book a Test Drive',
                        'Want to Test Drive?',
                        'Test Drive Now',
                        'Test Drive Today',
                        'Schedule My Visit',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '0075C9',
                        'color' => '#fff ',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '0066AF',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E43C25,#E43C25)',
                        'border-color' => 'D21815',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'B81512',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'FC5F19',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'E25516',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189238,#189238)',
                        'border-color' => '96960F',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '7C7C0C',
                        'color' => '#fff',
),
),
),
],
        'request-information' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a[data-href*=lead-form]',
            'css-class' => 'a[data-href*=lead-form]',
            'css-hover' => 'a[data-href*=lead-form]:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => 'a[data-href*=lead-form]',
                    'values' => array(
                        'Get More Info',
                        'Request Info',
                        'Request Information',
                        'Send Request',
                        'Learn More',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '0075C9',
                        'color' => '#fff ',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '0066AF',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E43C25,#E43C25)',
                        'border-color' => 'D21815',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'B81512',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'FC5F19',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'E25516',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189238,#189238)',
                        'border-color' => '96960F',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '7C7C0C',
                        'color' => '#fff',
),
),
),
],
        'text-us' => [
            'url-match' => '/\\/(?:new|used)\\/[^\\/]+\\/[0-9]{4}/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'a.btn.btn-default.ui-button.sms-button.ui-button-text-only',
            'css-class' => 'a.btn.btn-default.ui-button.sms-button.ui-button-text-only',
            'css-hover' => 'a.btn.btn-default.ui-button.sms-button.ui-button-text-only:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'text-us' => [
                    'target' => 'a.btn.btn-default.ui-button.sms-button.ui-button-text-only',
                    'values' => array(
                        'Send Us A Text',
                        'Send SMS',
                        'Message Us',
),
],
],
            'styles' => array(
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1F4581,#1F4581)',
                        'border-color' => '0075C9',
                        'color' => '#fff ',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#193767,#193767)',
                        'border-color' => '0066AF',
                        'color' => '#fff',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E43C25,#E43C25)',
                        'border-color' => 'D21815',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A92C1C,#A92C1C)',
                        'border-color' => 'B81512',
                        'color' => '#fff',
),
),
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#C38820,#C38820)',
                        'border-color' => 'FC5F19',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#A9761C,#A9761C)',
                        'border-color' => 'E25516',
                        'color' => '#fff',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#189238,#189238)',
                        'border-color' => '96960F',
                        'color' => '#fff',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#14782E,#14782E)',
                        'border-color' => '7C7C0C',
                        'color' => '#fff',
),
),
),
],
],
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17609',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
),
);