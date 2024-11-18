<?php

global $CronConfigs;
$CronConfigs["struthersbros"] = array(
    'password' => 'struthersbros',
    "email" => "regan@smedia.ca",
    'log' => true,
    'customer_id' => '121-607-6747',
    'max_cost' => 100,
    'cost_distribution' => array(
        'adwords' => 100,
    ),
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "struthersbros",
        'fb_aia_description'       => '[description]. Check out this [year] [make] [model] today! Click the \'Dealership Website\' link below for more information.', 
        "fb_description" => "Are you still interested in the [year] [make] [model]? Click for more info!",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today!",
        "flash_style" => "default",
        "border_color" => "#282828",
        "fb_style" => "facebook_new_ad",
        "font_color" => "#ffffff",
    ),
//    "lead" => array(
//        'live' => true,
//        /*
//        'lead_in' => [
//            'vdp' => '/\\/inventory\\/v1\\/Current\\/[^\\/]+\\/(?:ATVs|ATV|Side-x-Sides)\\/(?:ATV-Sport|UForce-Series|ATV-Sport|ZForce-Series)\\//i',
//        ], */
//        'lead_type_' => true,
//        'lead_type_new' => true,
//        'lead_type_used' => true,
//        'bg_color' => '#EFEFEF',
//        'text_color' => '#404450',
//        'border_color' => '#E5E5E5',
//        'button_color' => array(
//            '#1D1C1C',
//            '#1D1C1C',
//        ),
//        'button_color_hover' => array(
//            '#1F73AE',
//            '#1F73AE',
//        ),
//        'button_color_active' => array(
//            '#1F73AE',
//            '#1F73AE',
//        ),
//        'button_text_color' => "#fff",
//        'response_email_subject' => 'Claim $100 dollars worth of free accessories from Struthers Bros',
//        'response_email' => 'Hello [name],<p> Please print this off or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>Struthers Bros Team',
//        'forward_to' => array(
//            'sales@struthersbros.com',
//            'marshal@smedia.ca',
//        ),
//        'respond_from' => "offers@mail.smedia.ca",
//        'forward_from' => "offers@mail.smedia.ca",
//        'thank_you' => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
//    ),
    'mail_retargeting' => array(
        'enabled' => true,
        'client_id' => '17610',
        'promotion_text' => '',
        'promotion_color' => '#567DC0',
        'overlay_color' => '#FF8500',
        'overlay_text_colour' => '#FFFFFF',
        'price_color' => '#FF8500',
        'coupon_validity' => '7',
    ),
);