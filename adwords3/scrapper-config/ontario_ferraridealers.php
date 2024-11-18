<?php
global $scrapper_configs;
 $scrapper_configs["ontario_ferraridealers"] = array( 
	   'entry_points' => array( 
            'used'   => 'https://ontario.ferraridealers.com/vdata',
          ),
        'vdp_url_regex'         => '/com\/en_us\/.*\/[0-9]{4}\//',
        'use-proxy'         => true,
        'refine'            => false,
        'init_method'       => 'POST',
        'next_method'       => 'POST',
        'picture_selectors' => ['.swiper-slide img'],
        'picture_nexts'     => ['.swiper-button-next'],
        'picture_prevs'     => ['.swiper-button-prev'],
        'content_type'      => 'application/x-www-form-urlencoded',
        'custom_data_capture'   => function($url, $data){
        $end_tag    = 'Internal Server Error';
        
        if(stripos($data, $end_tag)) {
               $data = substr($data, 0, stripos($data, $end_tag));
        }
        $objects = json_decode($data);

                
        if(!$objects) { slecho($data); return array(); }

                
        $to_return = array();

                
        
 foreach($objects->vehicles as $obj)
        {
     
           $car_data = array( 
                'year' => $obj->main_info->reg_year,
                'make' => $obj->main_info->make,
                'model' => $obj->main_info->model,
                'url' =>'https://ontario.ferraridealers.com/en_us/search-used-ferrari'. $obj->main_info->seo_url,
                'stock_number'=>$obj->main_info->main_info->stockno?$obj->main_info->main_info->stockno:$obj->ids->vin,
                'stock_type'=>$obj->main_info->main_info->stockno=='1'?'used':'new',
                'body_style'=>$obj->main_info->metabody_type,
                'exterior_color'=>$obj->translations->default->exterior,
                'interior_color'=>$obj->translations->default->interior,
                'transmission'=> $obj->translations->default->transmission,
                'kilometres'=> $obj->translations->default->odometer,
                'price'=> str_replace("CA", "", $obj->translations->default->price_formated), 
       
            );

            $to_return[] = $car_data;
        }

        return $to_return;
    },
            'images_regx'       => '/swiper-slide">\s*<img alt=".*"\s*title=".*"\s*data-src="(?<img_url>[^"]+)"/',
);
add_filter('filter_ontario_ferraridealers_post_data', 'filter_ontario_ferraridealers_post_data', 10, 2);

function filter_ontario_ferraridealers_post_data($post_data, $stock_type)
{
    if($stock_type == 'used')
    {
       $post_data = 'search=%7B%22sumname%22%3A%22filtered%22%2C%22return%22%3A%22list%22%2C%22vehicle_type%22%3A%5B%22used%22%5D%2C%22tree_type%22%3A%22cl_lp-mo_bo-lp%22%2C%22currency_locale%22%3A%22en_us%22%2C%22currency%22%3A%22CAD%22%2C%22distance_unit%22%3A%22km%22%2C%22lang%22%3A%22en_us%22%2C%22count_fields%22%3A%221%22%2C%22equipment_meta_uncombined%22%3A%221%22%2C%22translate_summary_make%22%3A%22ferrari%22%2C%22translate_summary_market%22%3A%22ferrari%22%2C%22translate_summary_locale%22%3A%22en_us%22%2C%22translate_summary_objects%22%3A%5B%22model_dynamic%22%2C%22body_type_dynamic%22%2C%22metacolour_dynamic%22%2C%22fuel_dynamic%22%2C%22transmission_dynamic%22%2C%22model_variant_dynamic%22%2C%22equipment_meta%22%2C%22model_year_dynamic%22%2C%22metabody_type_dynamic%22%5D%2C%22summary_fields_dynamic%22%3A%5B%22model%22%2C%22body_type%22%2C%22price%22%2C%22odometer%22%2C%22metacolour%22%2C%22fuel%22%2C%22transmission%22%2C%22year%22%2C%22ranges%22%2C%22model_variant%22%2C%22equipment_meta%22%2C%22model_year%22%2C%22metabody_type%22%5D%2C%22dealer_cms_id%22%3A%5B%2266247%22%5D%2C%22project%22%3A%7B%22ids.vin%22%3A%22%22%2C%22ids.oracle_id%22%3A%22%22%2C%22main_info.approved%22%3A%22%22%2C%22main_info.reg_year%22%3A%22%22%2C%22main_info.make%22%3A%22%22%2C%22main_info.sub_brand%22%3A%22%22%2C%22main_info.model%22%3A%22%22%2C%22main_info.metabody_type%22%3A%22%22%2C%22main_info.model_year%22%3A%22%22%2C%22translations.default.exterior%22%3A%22%22%2C%22main_info.used%22%3A%22%22%2C%22links.seo_url%22%3A%22%22%2C%22translations.default.title_short%22%3A%22%22%2C%22translations.default.title_long%22%3A%22%22%2C%22translations.default.colour_with_trim%22%3A%22%22%2C%22translations.default.price_formated%22%3A%22%22%2C%22translations.default.odometer%22%3A%22%22%2C%22translations.default.transmission%22%3A%22%22%2C%22translations.default.fuel_string%22%3A%22%22%2C%22main_info.stockno%22%3A%22%22%2C%22dealer.name%22%3A%22%22%2C%22dealer.phone%22%3A%22%22%2C%22images.count%22%3A%22%22%2C%22images.list_430.img_1%22%3A%22%22%2C%22images.list_282.img_1%22%3A%22%22%2C%22main_info.images.panoramic.interior%22%3A%22%22%2C%22main_info.images.panoramic.exterior%22%3A%22%22%2C%22translations.default.make%22%3A%22%22%2C%22translations.default.model%22%3A%22%22%2C%22translations.default.additional_options%22%3A%22%22%2C%22translations.default.package_names%22%3A%22%22%2C%22translations.default.price_changed%22%3A%22%22%2C%22translations.default.old_price%22%3A%22%22%2C%22translations.default.apr_disclaimer%22%3A%22%22%2C%22translations.default.apr_percentage%22%3A%22%22%2C%22translations.default.vdp_video_url%22%3A%22%22%2C%22finance.finance_available%22%3A%22%22%2C%22translations.default.interior%22%3A%22%22%2C%22translations.default.reg_initial%22%3A%22%22%2C%22translations.default.year_make_model%22%3A%22%22%2C%22translations.default.make_model_model_variant%22%3A%22%22%2C%22main_info.carfaxurl%22%3A%22%22%2C%22main_info.carfaxoneowner%22%3A%22%22%2C%22main_info.seo_url%22%3A%22%22%7D%2C%22order%22%3A%5B%22yeard%22%5D%2C%22hits%22%3A%7B%22to%22%3A40%7D%7D&totals_search=%7B%22sumname%22%3A%22unfiltered%22%2C%22return%22%3A%22count%22%2C%22vehicle_type%22%3A%5B%22used%22%5D%2C%22tree_type%22%3A%22cl_lp-mo_bo-lp%22%2C%22currency_locale%22%3A%22en_us%22%2C%22currency%22%3A%22CAD%22%2C%22distance_unit%22%3A%22km%22%2C%22lang%22%3A%22en_us%22%2C%22count_fields%22%3A%221%22%2C%22equipment_meta_uncombined%22%3A%221%22%2C%22translate_summary_make%22%3A%22ferrari%22%2C%22translate_summary_market%22%3A%22ferrari%22%2C%22translate_summary_locale%22%3A%22en_us%22%2C%22translate_summary_objects%22%3A%5B%22model_dynamic%22%2C%22body_type_dynamic%22%2C%22metacolour_dynamic%22%2C%22fuel_dynamic%22%2C%22transmission_dynamic%22%2C%22model_variant_dynamic%22%2C%22equipment_meta%22%2C%22model_year_dynamic%22%2C%22metabody_type_dynamic%22%5D%2C%22summary_fields_dynamic%22%3A%5B%22model%22%2C%22body_type%22%2C%22price%22%2C%22odometer%22%2C%22metacolour%22%2C%22fuel%22%2C%22transmission%22%2C%22year%22%2C%22ranges%22%2C%22model_variant%22%2C%22equipment_meta%22%2C%22model_year%22%2C%22metabody_type%22%5D%2C%22dealer_cms_id%22%3A%5B%2266247%22%5D%7D&timestamp=1572929632845';
    }

    return $post_data;
}

