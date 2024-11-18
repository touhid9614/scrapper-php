<?php

$_GET['customer'] = 'marshal'; //To bypass customer reference

require_once    'popup_coupon_showup_db_connect.php';
require_once    'popup-coupon-train/som_model.php';

/*
 *  $ga_id: $smedia_id
 *  $url, 
 *  $car, 
 *  $last_shown: Unix timestamp, 0 for never
 *  $from_retargetting: True or false
 *
 *  return -1 or Delay in ms
 */

function shall_popup($smedia_id, $url, $car, $last_shown, $from_retargetting)
{
    $data_som = pcs_report_data_for_train(10000);
    // Save to db
    pcsdb_store_record($smedia_id, $url, $car, $last_shown, $from_retargetting);
    
    // Get Model
    if(count($data_som) == 0)
        return 30*1000;
        
    //tpcs_id	tpcs_smediaid	tpcs_url	tpcs_car	tpcs_last_shown	tpcs_from_retargetting	tpcs_delay	tpcs_fillup	tpcs_timestamp	
    //trs_id	trs_smediaid	trs_profileid	trs_ga_sessions	trs_ga_bounces	trs_ga_bounce_rate	trs_ga_session_duration	trs_ga_avg_session_duration	trs_ga_hits	trs_ga_pageviews	trs_ga_avg_time_on_page	trs_timestamp	
    //tret_id	tret_smediaid	tret_profileid	tret_ga_total_events	tret_ga_unique_events	tret_ga_event_value	tret_ga_avg_event_value	tret_ga_sessions_with_event	tret_ga_events_per_session_with_event	tret_timestamp	
    
    $num_keys = array(
        'tpcs_last_shown',
        'trs_ga_sessions',
        'trs_ga_bounces',
        'trs_ga_bounce_rate',
        'trs_ga_session_duration',
        'trs_ga_hits',
        'trs_ga_pageviews',
        'trs_ga_avg_time_on_page',
        'tret_ga_total_events',
        'tret_ga_unique_events',
        'tret_ga_event_value',
        'tret_ga_sessions_with_event',
        'tret_ga_events_per_session_with_event'
        );
    $no_num_keys = array(
        'tpcs_url',
        'tpcs_car',
        'tpcs_from_retargetting'
        );
    $som_model = new SOM_MODEL($data_som, $num_keys, $no_num_keys);
    $match_vec = $som->getBMU($input_vector);
    
    return @$match_vec['tpcs_delay'] ? ($match_vec['tpcs_delay'] > 30*1000 ? $match_vec['tpcs_delay'] : 30*1000) : 30*1000;
}

function popup_fillup($smedia_id)
{
    pcsdb_set_fillup($smedia_id);
}