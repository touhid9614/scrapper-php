<?php

global $CronConfigs;
$CronConfigs["gslgmcity"] = array(
    'password' => 'gslgmcity',
    "email" => "regan@smedia.ca",
    'log' => true,
    'fb_brand' => '[year] [make] [model] - [body_style]',
    'customer_id' => '937-085-7047',
    'max_cost' => 0,
    'cost_distribution' => array(
        'new' => 0,
        'used' => 0,
        'service' => 0,
        'youtube' => 0,
),
    "create" => array(
        "new_search" => yes,
        "used_search" => yes,
        "new_placement" => yes,
        "used_placement" => yes,
        "new_retargeting" => yes,
        "used_retargeting" => yes,
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
            "desc2" => "[year] [make] [model]",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model]",
),
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
            "#fac703",
            "#fac703",
),
        'button_color_hover' => array(
            "#e1a504",
            "#e1a504",
),
        'button_color_active' => array(
            "#e1a504",
            "#e1a504",
),
        'button_text_color' => "#ffffff",
        'response_email_subject' => "Get \$200 off with this offer from GSL City GM ",
        'response_email' => "Hello [name],<p> Thank you for booking a test drive! Please print this off or show your sales professional this email on your phone to claim.</p><br><img src=\"[image]\"/><p><br><br>GSL City GM ",
        'forward_to' => array(
            "webleads@gslgmc.com",
            "marshal@smedia.ca",
),
        'respond_from' => "offers@mail.smedia.ca",
        'forward_from' => "offers@mail.smedia.ca",
        'thank_you' => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
),
    "banner" => array(
        "template" => "gslgmcity",
        "old_price" => "msrp",
        "fb_description" => "Are you still interested in the [year] [make] [model]? Check out our great selection of inventory!",
        "fb_lookalike_description" => "Check out this [year] [make] [model]! Click for more information.",
        //"fb_retargeting_description" => "Are you still interested in the [year] [make] [model]? GSL Employee Pricing Event. All new vehicles have dropped Summer Clearance Pricing. Only at GSL! Shop below. ",
        //"fb_lookalike_description" => "Check out this [year] [make] [model]! GSL Employee Pricing Event. All new vehicles have dropped Summer Clearance Pricing. Only at GSL! Shop below. ",
        "fb_dynamiclead_description" => "Are you still interested in [Year] [Make] [Model]? Click below and fill in your information to get our best price.",
        'fb_retargeting_description_certified' => "Are you still interested in this [year] [make] [model]? Our certified pre-owned Cadillac inventory comes with exclusive lowered interest rates and a strict certification process you can trust! Shop below.",
        'fb_lookalike_description_certified' => "Check out this [year] [make] [model] today. Our certified pre-owned Cadillac inventory comes with exclusive lowered interest rates and a strict certification process you can trust! Shop below.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "font_color" => "#ffffff",
        "styels" => array(
            "new_display" => "custom_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "custom_banner",
            "used_marketbuyers" => "custom_banner",
),
),
    'adf_to' => array(
        'smedia@gslchevroletcadillac.net',
),
    'form_live' => true,
    'buttons_live' => true,
    'buttons' => [
        //        'test-drive' => [
        //            'url-match' => '/\/inventory\/(?:New|Certified|Used)-[0-9]{4}-/i',
        //            'target' => null,
        //            //Don't move button
        //            'locations' => [
        //                'default' => null,
        //            ],
        //            'action-target' => 'div.link a[href*="ScheduleTestDriveForm"]',
        //            'css-class' => 'div.link a[href*="ScheduleTestDriveForm"]',
        //            'css-hover' => 'div.link a[href*="ScheduleTestDriveForm"]:hover',
        //            'button_action' => [
        //                'form',
        //                'test-drive',
        //            ],
        //            'sizes' => [
        //                '100' => [],
        //            ],
        //            'texts' => [
        //                'test-drive' => [
        //                    'target' => 'div.link a[href*="ScheduleTestDriveForm"]',
        //                    'values' => array(
        //                        'Want To Test Drive?',
        //                        'Test Drive at Work!',
        //                        'Test Drive at Home!',
        //                        'At Home Test Ride!',
        //                        'At Work Test Ride!',
        //                        'Bring me the ride!',
        //                        'Request A Test Drive',
        //                        'Book a Test Drive',
        //                    ),
        //                ],
        //            ],
        //            'styles' => array(
        //                'orange' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#CC7500,#CC7500)',
        //                        'border-color' => '#cc7500',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#CF540E,#CF540E)',
        //                        'border-color' => '#cf540e',
        //                    ),
        //                ),
        //                'Cyan' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
        //                        'border-color' => '#094e83',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#0093CF,#0093CF)',
        //                        'border-color' => '#188bb7',
        //                    ),
        //                ),
        //                'royal-blue' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#4169E1,#4169E1)',
        //                        'border-color' => '#094e83',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#000000,#000000)',
        //                        'border-color' => '#188bb7',
        //                    ),
        //                ),
        //                'Platinum' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#B9B099,#B9B099)',
        //                        'border-color' => '#1ca0d1',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#ABA085,#ABA085)',
        //                        'border-color' => '#188bb7',
        //                    ),
        //                ),
        //                'red' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#E01212,#E01212)',
        //                        'border-color' => '#e01212',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
        //                        'border-color' => '#c60c0d',
        //                    ),
        //                ),
        //                'green' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#54B740,#54B740)',
        //                        'border-color' => '#54b740',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#359D22,#359D22)',
        //                        'border-color' => '#359d22',
        //                    ),
        //                ),
        //                'blue' => array(
        //                    'normal' => array(
        //                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
        //                        'border-color' => '#1ca0d1',
        //                    ),
        //                    'hover' => array(
        //                        'background' => 'linear-gradient(#188BB7,#188BB7)',
        //                        'border-color' => '#188bb7',
        //                    ),
        //                ),
        //            ),
        //        ],
        'request-a-quote' => [
            'url-match' => '/\\/inventory\\/(?:New|Certified|Used)-[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.w-100.btn.btn-primary.btn-block.leadForm--submit',
            'css-class' => '.w-100.btn.btn-primary.btn-block.leadForm--submit',
            'css-hover' => '.w-100.btn.btn-primary.btn-block.leadForm--submit:hover',
            'button_action' => [
                'form',
                'e-price',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-a-quote' => [
                    'target' => '.w-100.btn.btn-primary.btn-block.leadForm--submit',
                    'values' => array(
                        'Get E Price Now!',
                        'Get your Price!',
                        'Get Internet Price Now!',
                        'Get Our Best Price',
                        'Best Price',
                        'Special Pricing!',
                        'Get Special Price!',
                        'SPECIAL PRICING!',
                        'Get Internet Price!',
                        'Get Special Price Today',
                        'Today\'s Quote!',
                        'You are Eligible for Special Pricing',
                        'Exclusive Pricing',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#CC7500,#CC7500)',
                        'border-color' => 'CC7500',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
                'royal-blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#4169E1,#4169E1)',
                        'border-color' => '094E83',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
),
),
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
);
add_filter('filter_gslgmcity_fb_description', 'filter_gslgmcity_fb_description', 10, 3);
function filter_gslgmcity_fb_description($description, $car, $feed_type)
{
    if ($car['certified']) {
        if ($feed_type == 'retargeting') {
            $description_template = "Are you still interested in this [year] [make] [model]? Our certified pre-owned Cadillac inventory comes with exclusive lowered interest rates and a strict certification process you can trust! Shop below.";
        } elseif ($feed_type == 'lookalike') {
            $description_template = "Check out this [year] [make] [model] today. Our certified pre-owned Cadillac inventory comes with exclusive lowered interest rates and a strict certification process you can trust! Shop below.";
        } else {
            $description_template = "Are you still interested in this [year] [make] [model]? Our certified pre-owned Cadillac inventory comes with exclusive lowered interest rates and a strict certification process you can trust! Shop below.";
        }
        $description = processTextTemplate($description_template, $car, true);
    }
    return $description;
}