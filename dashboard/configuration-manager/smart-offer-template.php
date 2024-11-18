<?php

$config_templates['smart_offer'] = [
    'required'      => false,
    'name'      => 'Smart Offer',
    'fields'    => [
        'lead[live]'                    => ['name' => 'Is Live', 'type' => 'yesno'],
        
        'lead[lead_in]'                 => ['name' => 'Lead Pages', 'type' => 'textpair', 'required' => true, "container" => 'list'],
        
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
            'yes' => ['lead[special_to]', 'lead[special_email]']
        ]],
        'lead[special_to]'              => ['name' => 'ADF To', 'type' => 'email', "required" => true, "container" => 'list'],
        'lead[special_email]'           => ['name' => 'ADF Email', 'type' => 'textarea', "required" => true]
    ]
];

$config_templates['smart_offer_single'] = [
    'required'      => false,
    'name'      => 'Smart Offer',
    'fields'    => [
        'live'                    => ['name' => 'Is Live', 'type' => 'yesno'],
        'bg_color'                => ['name' => 'Background Color', 'type' => 'color'],
        'text_color'              => ['name' => 'Text Color', 'type' => 'color'],
        'border_color'            => ['name' => 'Border Color', 'type' => 'color'],
        'button_color'            => ['name' => 'Button Color', 'type' => 'gradient'],
        'button_color_hover'      => ['name' => 'Button Color (Hover)', 'type' => 'gradient'],
        'button_color_active'     => ['name' => 'Button Color (Active)', 'type' => 'gradient'],
        'button_text_color'       => ['name' => 'Border Text Colour', 'type' => 'color'],
        'response_email_subject'  => ['name' => 'Response Text Subject', 'type' => 'text', "required" => true],
        'response_email'          => ['name' => 'Response Email', 'type' => 'textarea', "required" => true],
        'forward_to'              => ['name' => 'Forward To', 'type' => 'email', "required" => true, "container" => 'list'],
        'enable_adf'              => ['name' => 'Enable ADF to CRM', 'type' => 'checkbox', 'value' => 'yes', 'conditions' => [
            'yes' => ['special_to', 'special_email']
        ]],
        'special_to'              => ['name' => 'ADF To', 'type' => 'email', "required" => true, "container" => 'list'],
        'special_email'           => ['name' => 'ADF Email', 'type' => 'textarea', "required" => true]
    ]
];