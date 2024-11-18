<?php

global $CronConfigs;

$CronConfigs["macdonaldbuickgmc_fr"] = array(
  //'budget'    => 2.0,
  'bid'           => 3.0,
    'log'         => true,
  'password'  => 'macdonaldbuickgmc_fr',
    'post_code'     => 'E2A 7K2',
    'fb_brand'          => '[year] [make] [model] - [body_style]',
    "email"         => "regan@smedia.ca",
    "banner"        => array(
        "fb_title"      => "[year] [make] [model] [price]",        
        "template"          => "macdonaldbuickgmc_fr",
			'fb_description'    => 'Nous avons plus de 4,000,000$ en stock et nous sommes le plus grand concessionaire de véhicules d\'occasion des provinces atlantiques! Venez faire un essai routier aujourd\'hui! [year] [make] [model] 1 866-393-0045. Vivez la révolution maintenant.',
			"fb_lookalike_description" => "Faites un essai routier de la [year] [make] [model] aujourd’hui. Vivez la révolution maintenant.",
			//"fb_dynamiclead_description" => "Êtes-vous encore intéressé à la [year] [make] [model]? Cliqué en bas pour réclamer un coupon de $200 !!",
			"fb_dynamiclead_description" => "Êtes-vous intéressés à faire l'achat d'un véhicule chez nous?  Cliquez ci-dessous et entrez vos informations - Un spécialiste du financement vous contactera  pour répondre a vos questions.",
        "flash_style"       => "default",
        "border_color"    => "#282828",
        "styels"            => array(
            "new_display"   => "custom_banner",
            "used_display"  => "custom_banner",
            "new_retargeting"  => "custom_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers"   => "custom_banner",
            "used_marketbuyers"  => "custom_banner"
            ),
        "font_color"        => "#ffffff"
        ),
       
    );
