<?php
global $scrapper_configs;
 $scrapper_configs["openroadinfiniti"] = array( 
	 'entry_points' => array(
            'used'   => 'https://openroadinfiniti.ca/views/ajax?_wrapper_format=drupal_ajax',
            'new'    => 'https://openroadinfiniti.ca/views/ajax?_wrapper_format=drupal_ajax',
            
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/(?:new|used)-cars/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thank-you-for-/i',
        'init_method'       => 'POST',
        'next_method'       => 'POST',
        'picture_selectors' => ['.owl-item'],
        'picture_nexts'     => ['.owl-next'],
        'picture_prevs'     => ['.owl-prev'],
        'details_spliter'   => 'class="c-listing__item l-grid__item js-dynamic-query',
        'data_capture_regx' => array(
              'stock_number'  => '/c-vehicle-teaser__stock">\s*(?<stock_number>[^\s]+)\s*<\/div/',
              'title'         => '/c-vehicle-teaser__title">\s*<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^<]+))/',
              'year'          => '/c-vehicle-teaser__title">\s*<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^<]+))/',
              'make'          => '/c-vehicle-teaser__title">\s*<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^<]+))/',
              'model'         => '/c-vehicle-teaser__title">\s*<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^<]+))/',
              'trim'          => '/subtitle">\s*(?<trim>[^<]+)/',
              'price'         => '/c-financial-value__amount" >(?<price>[0-9,]+)/',
              'url'           => '/c-vehicle-image__image">\s*<a href="(?<url>[^"]+)"/'
        ),
        'data_capture_regx_full' => array(
            'price'         => '/c-financial-value__amount" >(?<price>[0-9,]+)/',
            'vin'           => '/VIN:\s*(?<vin>[^<]+)/',
            
        ),
        
        'images_regx'       => '/c-carousel__slide is-loading">\s*<img data-srcset="(?<img_url>[^\?]+)/'
    );
    
    add_filter('filter_openroadinfiniti_post_data', 'filter_openroadinfiniti_post_data',10, 3);
    add_filter('filter_openroadinfiniti_data', 'filter_openroadinfiniti_data');
   
    
    function filter_openroadinfiniti_post_data($post_data, $stock_type, $data)
    {
           
        if($stock_type == 'used') {
          return "view_name=inventory&view_display_id=main&view_args=&view_path=%2Finventory&view_base_path=&view_dom_id=d12545b1785f4857ceed083f03e340f8cc4c2c6573aa40cc28ba75c8a31dded8&pager_element=1&f%5B0%5D=condition%3AUsed&f%5B1%5D=make%3AINFINITI&sort_by=created&sort_order=DESC&page=0%2C5&ajax_facets%5B%5D=condition&ajax_facets%5B%5D=year&ajax_facets%5B%5D=make&ajax_facets%5B%5D=model&ajax_facets%5B%5D=trim&ajax_facets%5B%5D=dealership&ajax_facets%5B%5D=vehicle_type&ajax_facets%5B%5D=drive&ajax_facets%5B%5D=transmission&ajax_facets%5B%5D=features&ajax_facets%5B%5D=color&ajax_facets%5B%5D=fuel_type&_drupal_ajax=1&ajax_page_state%5Btheme%5D=torque&ajax_page_state%5Btheme_token%5D=&ajax_page_state%5Blibraries%5D=big_pipe%2Fbig_pipe%2Ccore%2Fhtml5shiv%2Ccore%2Fpicturefill%2Cfacets%2Fdrupal.facets.views-ajax%2Cfacets_ajax_views%2Fajax-views%2Cflag%2Fflag.link%2Cflag%2Fflag.link_ajax%2Cmodal_paths%2Flink_builder%2Copenroad_inventory%2Fsaved_searches%2Copenroad_torque%2Ftorque.toolbar.icons%2Cparagraphs%2Fdrupal.paragraphs.unpublished%2Csystem%2Fbase%2Ctorque%2Fdomain.openroad_infiniti_langley%2Ctorque%2Fglobal%2Cviews%2Fviews.module%2Cviews_ajax_history%2Fhistory%2Cviews_infinite_scroll%2Fviews-infinite-scroll";
        }
        else{
             return "view_name=inventory&view_display_id=main&view_args=&view_path=%2Finventory&view_base_path=&view_dom_id=d12545b1785f4857ceed083f03e340f8cc4c2c6573aa40cc28ba75c8a31dded8&pager_element=1&f%5B0%5D=condition%3ANew&f%5B1%5D=make%3AINFINITI&sort_by=created&sort_order=DESC&page=0%2C5&ajax_facets%5B%5D=condition&ajax_facets%5B%5D=year&ajax_facets%5B%5D=make&ajax_facets%5B%5D=model&ajax_facets%5B%5D=trim&ajax_facets%5B%5D=dealership&ajax_facets%5B%5D=vehicle_type&ajax_facets%5B%5D=drive&ajax_facets%5B%5D=transmission&ajax_facets%5B%5D=features&ajax_facets%5B%5D=color&ajax_facets%5B%5D=fuel_type&_drupal_ajax=1&ajax_page_state%5Btheme%5D=torque&ajax_page_state%5Btheme_token%5D=&ajax_page_state%5Blibraries%5D=big_pipe%2Fbig_pipe%2Ccore%2Fhtml5shiv%2Ccore%2Fpicturefill%2Cfacets%2Fdrupal.facets.views-ajax%2Cfacets_ajax_views%2Fajax-views%2Cflag%2Fflag.link%2Cflag%2Fflag.link_ajax%2Cmodal_paths%2Flink_builder%2Copenroad_inventory%2Fsaved_searches%2Copenroad_torque%2Ftorque.toolbar.icons%2Cparagraphs%2Fdrupal.paragraphs.unpublished%2Csystem%2Fbase%2Ctorque%2Fdomain.openroad_infiniti_langley%2Ctorque%2Fglobal%2Cviews%2Fviews.module%2Cviews_ajax_history%2Fhistory%2Cviews_infinite_scroll%2Fviews-infinite-scroll";
        }
               
       
    }

    function filter_openroadinfiniti_data($data)
    {
        if($data)
        {
            if(isJSON($data)){
                slecho("data is in jSon format");
                $obj = json_decode($data);

                $data = "{$obj[1]->data}";
            }
            else { slecho("data is not in jSon format"); }
        }

        return $data;
    }
