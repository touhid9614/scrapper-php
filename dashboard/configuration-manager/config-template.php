<?php

/*
 * ..Root
 * ....Section
 * ......Fields/Subsection
 */

require_once __DIR__ . '/Parsedown.php';
/*
 * $Parsedown = new Parsedown();
 * echo $Parsedown->text('Hello _Parsedown_!');
 */

$config_template = [
    'general'       => [
        'name'          => 'General',
        'required'      => true,
        'fields'        => [
            'password'              => ['name'  => 'Password', 'type' => 'text'],
            'banner[template]'      => ['name'  => 'Template Directory', 'type' => 'text', "required" => true]
        ]
    ],
    'smart-offer'   => [
        'required'      => false,
        'name'      => 'Smart Offer',
        'fields'    => [
            'lead[live]'                    => ['name' => 'Is Live', 'type' => 'yesno'],
            'lead[lead_type_]'              => ['name' => 'Enable for All', 'type' => 'yesno'],
            'lead[lead_type_new]'           => ['name' => 'Enable for New', 'type' => 'yesno'],
            'lead[lead_type_used]'          => ['name' => 'Enable for Used', 'type' => 'yesno'],
            'lead[bg_color]'                => ['name' => 'Background Color', 'type' => 'color'],
            'lead[text_color]'              => ['name' => 'Text Color', 'type' => 'color'],
            'lead[border_color]'            => ['name' => 'Border Color', 'type' => 'color'],
            'lead[button_color]'            => ['name' => 'Button Color', 'type' => 'gradient'],
            'lead[button_color_hover]'      => ['name' => 'Button Color (Hover)', 'type' => 'gradient'],
            'lead[button_color_active]'     => ['name' => 'Button Color (Active)', 'type' => 'gradient'],
            'lead[button_text_color]'       => ['name' => 'Border Text Colour', 'type' => 'color'],
            'lead[response_email_subject]'  => ['name' => 'Response Text Subject', 'type' => 'text', "required" => true],
            'lead[response_email]'          => ['name' => 'Response Email', 'type' => 'textarea', "required" => true],
            'lead[forward_to]'              => ['name' => 'Forward To', 'type' => 'email', "required" => true, "container" => 'list'],
            'lead[enable_adf]'              => ['name' => 'Enable ADF to CRM', 'type' => 'checkbox', 'value' => 'yes', 'conditions' => [
                'yes' => ['lead[special_to]']
            ]],
            'lead[special_to]'              => ['name' => 'Special To', 'type' => 'email', "required" => true, "container" => 'list'],
            'lead[email_types]'             => ['name' => 'Email Types', 'type' => 'checklist', 'options' => ['html' => 'HTML', 'adf' => 'ADF XML']]
            /*
            'forward_to'            => array("avanvooren@chrisauffenberg.com", "AUFFENBERGOFCARBONDALE2032@ADFLEADS.COM", "marshal@smedia.ca"),
            'respond_from'          => "offers@smedia.ca",
            'forward_from'          => "offers@smedia.ca",
            'thank_you'             => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
            */
        ]
    ],
    'ai-buttons'    => [
        'required'      => false,
        'name'          => 'AI Buttons',
        'fields'        => [
            'buttons_live'                  => ['name' => 'Button Live', 'type' => 'yesno'],
            'button_text'                   => ['name' => 'Button Texts', 'type' => 'buttontext', 'container' => 'list'],
            'button_styles'                 => ['name' => 'Button Styles', 'type' => 'styleeditor', 'container' => 'list'],
        ]
    ]
];