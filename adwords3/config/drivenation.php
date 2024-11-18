<?php

global $CronConfigs;
$CronConfigs["drivenation"] = array(
    'password' => 'drivenation',
    "email" => "regan@smedia.ca",
    'log' => true,
    'form_live' => false,
    'buttons_live' => false,
    //touhid 16/06/2020
    //https://app.asana.com/0/687248649257779/1179662217268641
    'fb_title' => '[year] [make] [model] Our Price [price]. Click to get approved in 60 seconds.',
    // 'fb_title'     => year make model
    'buttons' => [
        'request-information' => [
            'url-match' => '/\\/(?:used)\\/vehicle\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => 'div.col-xs-12 button#request-info',
            'css-class' => 'div.col-xs-12 button#request-info',
            'css-hover' => 'div.col-xs-12 button#request-info:hover',
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'request-information' => [
                    'target' => 'div.col-xs-12 button#request-info span',
                    'values' => array(
                        'Get More Information',
                        'Request Information',
                        'Contact Us.',
                        'Contact Us',
                        'Contact Store',
                        'Book Test Drive',
                        'Get More Information',
                        'Ask a Question',
                        'Inquire Now',
                        'Let our Experts Help',
                        'Ask an Expert',
),
],
],
            'styles' => array(
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
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
),
),
),
],
        'trade-in' => [
            'url-match' => '/\\/vehicles\\/[0-9]{4}-/i',
            'target' => null,
            //Don't move button
            'locations' => [
                'default' => null,
],
            'action-target' => '.av_button_widget__container.av_button-widget--default a:nth-of-type(2)',
            'css-class' => '.av_button_widget__container.av_button-widget--default a:nth-of-type(2)',
            'css-hover' => '.av_button_widget__container.av_button-widget--default a:nth-of-type(2):hover',
            'button_action' => [
                'form',
                'trade-in',
],
            'sizes' => [
                '100' => [],
],
            'texts' => [
                'trade-in' => [
                    'target' => '.av_button_widget__container.av_button-widget--default a:nth-of-type(2)',
                    'values' => array(
                        'Appraise my trade in',
                        'Value your trade',
                        'What\'s your trade worth?',
                        'We want your car',
                        'WHAT\'S YOUR TRADE WORTH?',
                        'What is Your Trade Worth?',
                        'Trade Appraisal',
),
],
],
            'styles' => array(
                'orange' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#F06B20,#F06B20)',
                        'border-color' => 'F06B20',
                        'color' => '#fff',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#CF540E,#CF540E)',
                        'border-color' => 'CF540E',
                        'color' => '#fff',
                        'text-align' => 'center',
),
),
                'red' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#E01212,#E01212)',
                        'border-color' => 'E01212',
                        'color' => '#fff',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#C60C0D,#C60C0D)',
                        'border-color' => 'C60C0D',
                        'color' => '#fff',
                        'text-align' => 'center',
),
),
                'green' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#54B740,#54B740)',
                        'border-color' => '54B740',
                        'color' => '#fff',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#359D22,#359D22)',
                        'border-color' => '359D22',
                        'color' => '#fff',
                        'text-align' => 'center',
),
),
                'blue' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#1CA0D1,#1CA0D1)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#188BB7,#188BB7)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'text-align' => 'center',
),
),
                'Platinum' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#B9B099,#B9B099)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#ABA085,#ABA085)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'text-align' => 'center',
),
),
                'Black' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#333333,#333333)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#000000,#000000)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'text-align' => 'center',
),
),
                'Cyan' => array(
                    'normal' => array(
                        'background' => 'linear-gradient(#00ABF1,#00ABF1)',
                        'border-color' => '1CA0D1',
                        'color' => '#fff',
                        'text-align' => 'center',
),
                    'hover' => array(
                        'background' => 'linear-gradient(#0093CF,#0093CF)',
                        'border-color' => '188BB7',
                        'color' => '#fff',
                        'text-align' => 'center',
),
),
),
],
],
    'max_cost' => 1000,
    'cost_distribution' => [
        'adwords' => 1000.0,
],
    "create" => array(
        //  "new_search" => yes,
        "used_search" => yes,
        // "new_placement" => yes,
        "used_placement" => yes,
        // "new_display" => yes,
        "used_display" => yes,
        // "new_retargeting" => yes,
        "used_retargeting" => yes,
        // "new_marketbuyers" => no,
        "used_marketbuyers" => no,
        // "new_combined" => yes,
        "used_combined" => yes,
),
    'campaigns' => array(
        "used_search" => "drivenation_conquest_search",
        "used_placement" => "drivenation_conquest_placement",
        "used_display" => "drivenation_conquest_image",
        "used_retargeting" => "drivenation_conquest_remarketing",
        "used_marketbuyers" => "drivenation_conquest_marketbuyers",
        "used_combined" => "drivenation_conquest_combined",
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
    'customer_id' => '788-942-5719',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "drivenation",
        'fb_description' => "Are you still interested in the [year] [make] [model]? Click for more information.",
        "fb_style" => "drivenation",
        "fb_marketplace_title" => "[year] [make] [model] [trim] [price]",
        "fb_marketplace_description" => "[description]",
        //'fb_retargeting_description' => "Are you still interested in the [year] [make] [model]? 100% Approval Rates In Saskatchewan for all of March! *Conditions Apply.",
        "fb_lookalike_description" => "Check out this [year] [make] [model] today! Click for more information.",
        "fb_dynamiclead_description" => "Still interested in the [year] [make] [model]? Click below and fill in your information, and a product specialist will be in touch to answer any questions.",
        "flash_style" => "default",
        "border_color" => "#282828",
        "old_price" => "msrp",
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
        'new' => array(
            'live' => false,
            'lead_type_' => false,
            'lead_type_new' => false,
            'lead_type_used' => false,
            'lead_type_service' => true,
            'shown_cap' => false,
            'fillup_cap' => false,
            'session_close' => false,
            'device_type' => array(
                'mobile' => true,
                'desktop' => true,
                'tablet' => true,
),
            'sent_client_email' => false,
            'offer_minimum_price' => 0,
            'offer_maximum_price' => 10000000,
            'bg_color' => '#EFEFEF',
            'text_color' => '#404450',
            'border_color' => '#E5E5E5',
            'button_color' => array(
                '#FD8524',
                '#FD8524',
),
            'button_color_hover' => array(
                '#FF6900',
                '#FF6900',
),
            'button_color_active' => array(
                '#FF6900',
                '#FF6900',
),
            'button_text_color' => '#FFFFFF',
            'response_email_subject' => '$500 offer from DriveNation',
            'response_email' => 'Hello [name],<p> Thank you for signing up for our offer. Please print this off, or show your sales professional this email on your phone to claim.</p><br><img src="[image]"/><p><br><br>DriveNation Team',
            'forward_to' => array(
                'tamissy13@gmail.com',
                'marketing@drivenation.ca',
                'marshal@smedia.ca',
                'andrew.potter@drivenation.ca',
                'kyle.senger@ffun.com',
),
            'special_to' => array(
                'tamissy13@gmail.com',
                '',
),
            'special_email' => '',
            'display_after' => 5000,
            'retarget_after' => 5000,
            'fb_retarget_after' => 5000,
            'adword_retarget_after' => 5000,
            'visit_count' => 0,
            'video_smart_offer' => false,
            'video_smart_offer_form' => false,
            'video_url' => '',
            'video_title' => '',
            'video_description' => '',
            'lead_in' => array(
                'vdp' => '/\\/(?:new|used|all)\\/vehicle\\/[0-9]{4}-/i',
                'service' => '',
),
),
),
    'cities' => [
        'abbotsford' => [
            'address' => '32835 S Fraser Way',
            'city' => 'Abbotsford',
            'state' => 'British Columbia',
            'country_name' => 'Canada',
            'post_code' => 'V2S 2A6',
            'full_address' => '32835 S Fraser Way, Abbotsford, British Columbia, V2S 2A6',
            'phone' => '1-604-330-8263',
            'lat' => '49.0512595',
            'lng' => '-122.3140293',
],
        'prince_albert' => [
            'address' => '240 38 St East',
            'city' => 'Prince Albert',
            'state' => 'Saskatchewan',
            'country_name' => 'Canada',
            'post_code' => 'S6W 1A6',
            'full_address' => '240 38 St East, Prince Albert, Saskatchewan, S6W 1A6',
            'phone' => '1-306-700-3537',
            'lat' => '53.178999',
            'lng' => '-105.747791',
],
        'edmonton' => [
            'address' => '17250 Mayfield RD N.W',
            'city' => 'Edmonton',
            'state' => 'Alberta',
            'country_name' => 'Canada',
            'post_code' => 'T5S 1K6',
            'full_address' => '17250 Mayfield RD N.W., Edmonton, Alberta, T5S 1K6',
            'phone' => '1-587-400-2145',
            'lat' => '53.5422452',
            'lng' => '-113.6176757',
],
        'calgary' => [
            'address' => '204 Meridian Rd NE',
            'city' => 'Calgary',
            'state' => 'Alberta',
            'country_name' => 'Canada',
            'post_code' => 'T2A 2N6',
            'full_address' => '204 Meridian Rd NE, Calgary, Alberta, T2A 2N6',
            'phone' => '1-587-355-6435',
            'lat' => '51.0535319',
            'lng' => '-114.0002743',
],
        'regina' => [
            'address' => '1440 Albert Street',
            'city' => 'Regina',
            'state' => 'Saskatchewan',
            'country_name' => 'Canada',
            'post_code' => 'S4R 2R7',
            'full_address' => '1440 Albert Street, Regina, Saskatchewan, S4R 2R7',
            'phone' => '1-306-994-6045',
            'lat' => '50.455832',
            'lng' => '-104.6190736',
],
        'saskatoon_north' => [
            'address' => '806 Circle Drive',
            'city' => 'Saskatoon North',
            'state' => 'Saskatchewan',
            'country_name' => 'Canada',
            'post_code' => 'S7K 3T8',
            'full_address' => '806 Circle Drive, Saskatoon, Saskatchewan, S7K 3T8',
            'phone' => '1-306-700-5403',
            'lat' => '52.1583357',
            'lng' => '-106.6543874',
],
        'saskatoon_south' => [
            'address' => '1012 Central Ave',
            'city' => 'Saskatoon South',
            'state' => 'Saskatchewan',
            'country_name' => 'Canada',
            'post_code' => 'S7N 2G9',
            'full_address' => '1012 Central Ave, Saskatoon, Saskatchewan, S7N 2G9',
            'phone' => '1-306-700-5284',
            'lat' => '52.139256',
            'lng' => '-106.5991231',
],
],
);
add_filter('filter_keywords_drivenation', 'filter_keywords_drivenation', 10, 2);
function filter_keywords_drivenation($keywords, $car)
{
    $additional_keywords = [
        '[year] [make] [model]',
        '[year] [make]',
];
    foreach ($additional_keywords as $template) {
        $keyword = processTextTemplate($template, $car);
        $k1 = "\"{$keyword}\"";
        $k2 = "[{$keyword}]";
        slecho("Additional Keyword: {$k1}, {$k2}");
        $keywords[] = $k1;
        $keywords[] = $k2;
    }
    return $keywords;
}