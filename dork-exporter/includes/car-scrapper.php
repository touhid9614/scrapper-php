<?php
    
    /**
     * { function_description }
     *
     * @param      <type>             $host              The host
     * @param      <type>             $dealership        The dealership
     * @param      <type>             $scrappers         The scrappers
     * @param      <type>             $project_configs   The project configs
     * @param      <type>             $proxy             The proxy
     * @param      ThreadedDbConnect  $db_connect        The database connect
     * @param      <type>             $carlist           The carlist
     * @param      <type>             $advanced_carlist  The advanced carlist
     */
    function ScrapCars($host, $dealership, $scrappers, $project_configs, $proxy, ThreadedDbConnect $db_connect, $carlist, $advanced_carlist)
    {   
        $entry_points   = $dealership['entry_points'];
        
        $url = "http://$host/";
        
        foreach($entry_points as $type => $points)
        {
            for($i = 0; $i < count($points); $i++)
            {
                $entry_points[$type][$i] = urlCombine($url, $points[$i]);
            }
        }

        $match              = null;
        $unique_car_urls    = array();
        $unique_list_urls   = array();
        $car_picked         = 0;
        $next_page_ok       = false;
        $other_regex_fail   = false;
        $website_fail       = false;
        $refine_fail        = false;
        
        foreach ($entry_points as $stock_type => $entry_point_array)
        {
            if (!is_array($entry_point_array)) 
            {
                $entry_point_array = array($entry_point_array);
            }
            
            if (count($entry_point_array) == 0) 
            { 
                continue; 
            }
            
            $scrapper_matched = false;
            
            $scrapper_name = resolve_scrapper_name_ft($entry_point_array[0], $scrappers, $scrapper_matched, $proxy);
            
            slecho("Scrapper Resolved: '$scrapper_name'");
            
            if (!$scrapper_matched) 
            { 
                continue; 
            }
            
            $project_config = isset($project_configs[$scrapper_name])?$project_configs[$scrapper_name]:null;
            
            if (!$project_config)
            { 
                continue; 
            }

            $parsing_config = $project_config;
            
            if (isset($parsing_config[$stock_type])) 
            {
                $parsing_config     = $project_config[$stock_type];
            }

            foreach ($entry_point_array as $entry_point) 
            {
                $details_start_tag      = isset($parsing_config['details_start_tag'])?$parsing_config['details_start_tag']:false;
                $details_end_tag        = isset($parsing_config['details_end_tag'])?$parsing_config['details_end_tag']:false;
                $details_spliter        = $parsing_config['details_spliter'];
                $data_capture_regx      = $parsing_config['data_capture_regx'];
                $must_contain_regx      = isset($parsing_config['must_contain_regx'])?$parsing_config['must_contain_regx']:false;
                $data_capture_regx_full = isset($parsing_config['data_capture_regx_full'])?$parsing_config['data_capture_regx_full']:false;
                $next_page_regx         = isset($parsing_config['next_page_regx'])?$parsing_config['next_page_regx']:false;
                $next_query_regx        = isset($parsing_config['next_query_regx'])?$parsing_config['next_query_regx']:false;
                $next_method            = isset($parsing_config['next_method'])?$parsing_config['next_method']:'GET';
                $next_processor         = function_exists($scrapper_name . '_next_processor')?$scrapper_name . '_next_processor':false;
                $images_regx            = $parsing_config['images_regx'];
                $images_fallback_regx   = isset($parsing_config['images_fallback_regx'])?$parsing_config['images_fallback_regx']:false;
                $images_proc            = function_exists($scrapper_name . '_images_proc')?$scrapper_name . '_images_proc':false;
                $auto_texts_regx        = isset($parsing_config['auto_texts_regx'])?$parsing_config['auto_texts_regx']:false;
                $number_of_retries      = isset($project_config['number_of_retries'])?$project_config['number_of_retries']:10;

                $options_start_tag      = isset($parsing_config['options_start_tag'])?$parsing_config['options_start_tag']:null;
                $options_end_tag        = isset($parsing_config['options_end_tag'])?$parsing_config['options_end_tag']:null;
                $options_regx           = isset($parsing_config['options_regx'])?$parsing_config['options_regx']:null;

                $url                    = $entry_point;
                $post_data              = apply_filters('filter_' . $scrapper_name . '_post_data', '', $stock_type, $host);
                $in_cookies             = '';
                $out_cookies            = '';
                $count = 0;

                while ($url) 
                {
                    $count++;

                    if ($next_method != 'POST') 
                    {
                        if (in_array($url, $unique_list_urls)) 
                        {
                            slecho('Notice: list page url already downloaded, skipping: ' . $url);
                            $url = false;

                            continue;
                        }

                        $data = HttpGet($url, $proxy, $random_proxy = true);

                        if ($data)
                        {
                            $unique_list_urls[] = $url;
                        }

                        slecho('--->' . $count . ': ' . $url);
                    } 
                    else 
                    {
                        if (in_array($url . '-POST-'.$post_data, $unique_list_urls)) 
                        {
                            slecho('Notice: list page url already downloaded (POST), skipping: ' . $url. '-POST-' .$post_data);
                            $url = false;

                            continue;
                        }

                        $data = HttpPost($url, $post_data, $in_cookies, $out_cookies, $proxy, $random_proxy = true);

                        if ($data)
                        {
                            $unique_list_urls[] = $url.'-POST-'.$post_data;
                        }

                        slecho('--->' . $count . ': ' . $url . '-POST-' . $post_data);

                        if ($out_cookies != '') 
                        {
                            $in_cookies = $out_cookies;
                        }
                    }
                    
                    /**
                     * No more than 50 requests per site per minute
                     */
                    $delay = rand(1200000, 1500000);
                    usleep($delay);
                    
                    if ($data) 
                    {
                        $all_capture_fields = array_fill_keys(
                            array_merge(
                                array_keys($data_capture_regx),
                                array_keys($data_capture_regx_full)
                            ),
                            false
                        );
                        
                        $temp = apply_filters('filter_' . $scrapper_name . '_data', $data);
                        
                        if ($details_start_tag)
                        {
                            $temp = substr($temp, stripos($temp, $details_start_tag));
                        }
                        
                        if ($details_end_tag)
                        {
                            $temp = substr($temp, 0, stripos($temp, $details_end_tag));
                        }

                        $spltd = explode($details_spliter, $temp);

                        slecho('DEBUG: ' . count($spltd) . ' pieces of information');
                        
                        foreach ($spltd as $str) 
                        {
                            if ($must_contain_regx) 
                            {
                                if (!preg_match($must_contain_regx, $str)) 
                                {
                                    slecho('Info: Car does not fulfill required criteria');

                                    continue;
                                }
                            }

                            $car_data = array();
                            
                            foreach ($data_capture_regx as $key => $regx) 
                            {
                                if (preg_match($regx, $str, $match)) 
                                {
                                    if (array_key_exists($key, $match)) 
                                    {
                                        $car_data[$key] = str_replace("\n", '', $match[$key]);
                                        $all_capture_fields[$key] = true;
                                    } 
                                    else 
                                    {
                                        slecho('Error - missing match for: ' . $key);
                                        slecho(print_r($match, true));
                                    }
                                } 
                                else 
                                {
                                    slecho('Error in regx:' . $key);
                                }
                            }

                            if (!array_key_exists('make', $car_data)) 
                            {
                                slecho('Notice: no make found initially');
                            } 
                            elseif (isset($parsing_config[$car_data['make']])) 
                            {
                                $make_capture_regx = $parsing_config[$car_data['make']];

                                foreach ($make_capture_regx as $key => $regx) 
                                {
                                    if (preg_match($regx, $str, $match)) 
                                    {
                                        $car_data[$key] = str_replace("\n", '', $match[$key]);
                                        $all_capture_fields[$key] = true;
                                    }
                                }
                            }

                            if ($auto_texts_regx) 
                            {
                                if (preg_match_all($auto_texts_regx, $str, $match)) 
                                {
                                    if (isset($match['auto_text'])) 
                                    {
                                        $auto_texts = implode('|', $match['auto_text']);
                                        $car_data['auto_texts'] = $auto_texts;
                                    } 
                                    else 
                                    {
                                        slecho("Error - missing match for auto_texts");
                                    }
                                } 
                                else 
                                {
                                    slecho("Error in regx: auto_texts");
                                }
                            }

                            if (!isset($car_data['url'])) 
                            {
                                slecho("URL Regex failed, can not procceed further");
                                $other_regex_fail |= true;  //URL regex probably failed and I can not store
                                continue;
                            }

                            $car_data['url'] = urlCombine($entry_point, $car_data['url']);
                            $car_data['stock_type'] = $stock_type;
        
                            if (in_array($car_data['url'], $unique_car_urls)) 
                            {
                                slecho('Notice: car url already downloaded : ' . $car_data['url']);
                                continue;
                            }

                            $unique_car_urls[]= $car_data['url'];
                            $temp = HttpGet($car_data['url'], $proxy, $random_proxy = true);

                            //start of scraping options
                            if ($options_start_tag && $options_end_tag && $options_regx)
                            {
                                $options_data_t = substr($temp, stripos($temp, $options_start_tag));
                                $options_data = substr($options_data_t, 0, stripos($options_data_t, $options_end_tag));

                                if ($options_data !== '')
                                {
                                    preg_match_all($options_regx, $options_data, $match);
                                    $options = $match['option'];

                                    if (is_array($options))
                                    {
                                        $car_data['options'] = json_encode($options);
                                    }
                                }
                            }
                            else
                            {
                                $car_data['options'] = '[]';
                            }
                            
                            //end of scraping options

                            if (preg_match_all($images_regx, $temp, $match)) 
                            {
                                //     slecho ('DEBUG: initial match for images regex:'. print_r($match, true));
                                if (isset($match['img_url'])) 
                                {
                                    slecho('DEBUG notice: entering image proc loop');
                                    $im_urls = array();

                                    for ($i = 0; $i < count($match['img_url']); $i++) 
                                    {
                                        $im_part = $match['img_url'][$i];

                                        if ($images_proc) 
                                        {
                                            $im_part = $images_proc($im_part);
                                        }

                                        $im_urls[$i] = urlCombine($car_data['url'], $im_part);
                                    }

                                    $image_urls = implode('|', $im_urls);
                                    $car_data['all_images'] = $image_urls;
                                }
                            } 
                            elseif ($images_fallback_regx && preg_match_all($images_fallback_regx, $temp, $match)) 
                            {
                                //slecho(print_r($match,true));
                                if (isset($match['img_url'])) 
                                {
                                    $im_urls = array();

                                    for ($i = 0; $i < count($match['img_url']); $i++) 
                                    {
                                        $im_part = $match['img_url'][$i];

                                        if ($images_proc) 
                                        {
                                            $im_part = $images_proc($im_part);
                                        }

                                        $im_urls[$i] = urlCombine($car_data['url'], $im_part);
                                    }

                                    $image_urls = implode('|', $im_urls);
                                    $car_data['all_images'] = $image_urls;
                                }
                            } 
                            else 
                            {
                                if (!strlen(trim($temp))) 
                                {
                                    slecho('DEBUG : empty page at ' .$car_data['url']);
                                    slecho('DEBUG : possible network error!');
                                } 
                                else 
                                {
                                    slecho('DEBUG: no images matched for ' . $car_data['url']);
                                    slecho('DEBUG: using regx: '. $images_regx);
                                    //$debfname = __DIR__ . '/imddebug_cache/'.md5($temp);
                                    //file_put_contents($debfname, $temp);
                                    //slecho('DEBUG: page dumped to '.$debfname);
                                }
                            }

                            if ($data_capture_regx_full) 
                            {
                                foreach ($data_capture_regx_full as $key => $regx) 
                                {
                                    if (preg_match($regx, $temp, $match)) 
                                    {
                                        if (array_key_exists($key, $match)) 
                                        {
                                            $car_data[$key] = str_replace("\n", '', $match[$key]);
                                            $all_capture_fields[$key] = true;
                                        } 
                                        else 
                                        {
                                            slecho("Error: missing match (full) for " . $key . "\n");
                                        }
                                    } 
                                    else 
                                    {
                                        slecho('Error in regx (full):' . $key . "\n");
                                    }
                                }
                            }

                            if (!isset($car_data['make']) || !isset($car_data['model'])) 
                            {
                                slecho("Info: Make or Model data could not be picked for Make '{$car_data['make']}' and Model '{$car_data['model']}' provider name $scrapper_name");
                                $other_regex_fail |= true;  //Posibly Make Model Regex Fail

                                continue;
                            }

                            if (!isset($car_data['price'])) 
                            {
                                $car_data['price'] = 'Please Call';
                            }

                            if (!isset($car_data['stock_number'])) 
                            {
                                $car_data['stock_number'] = md5($car_data['url']);
                            }

                            if (!isset($car_data['title'])) 
                            {
                                $car_data['title'] = $car_data['year'] . ' ' . $car_data['make'] . ' ' . $car_data['model'];
                            }

                            //exception?
                            ##############################################################################################
                            $car_data['title'] = preg_replace('/\b[Ff] ?- ?(?<m>[0-9]{3})\b/', 'F-$1', $car_data['title']);
                            slecho('DEBUG true field count');
                            $buffer = '';

                            foreach ($all_capture_fields as $key => $field) 
                            {
                                if ($field) 
                                {
                                    $buffer .= " %+$key% ";
                                } 
                                else 
                                {
                                    $buffer .= " %-$key% ";
                                }
                            }

                            slecho($buffer);

                            //Apply Smart Scrapper to car data
                            $refined = RefineCarData($car_data, $carlist, $advanced_carlist);

                            if (!$refined) 
                            {
                                $refine_fail |= true;
                                slecho("Refine failed!");

                                continue;
                            }

                            if (isset($car_data['stock_number']))
                            {
                                $car_picked++;
                                $car_data['stock_number'] = $car_data['stock_number'] . '_' . $host;
                                $car_data['host'] = $host;
                                $car_data['lat']  = $dealership['address']['lat'];
                                $car_data['long'] = $dealership['address']['long'];
                                slecho("Storing scrap data for car {$car_data['stock_number']}");
                                $db_connect->store_car_data($car_data);
                            }
                            else
                            {
                                $other_regex_fail |= true;  #This shall never occur as stock_number is set to md5 of URL if there is no stock number
                                slecho("Impossible");
                            }

                            //display data
                            foreach ($car_data as $key => $val) 
                            {
                                slecho($key . ": " . $val);
                            }
                        }

                        //get next url
                        if ($next_page_regx) 
                        {
                            if (preg_match($next_page_regx, $data, $match)) 
                            {
                                $url2 = urlCombine($entry_point, $match['next']);

                                if ($url == $url2) 
                                {
                                    slecho('Error next page: same url ' . $url);
                                    $url = false;
                                } 
                                else 
                                {
                                    $url = $url2;
                                    slecho('Notice next page: ' . $url);
                                }

                                $next_page_ok |= true;

                            } 
                            else 
                            {
                                $url = false;
                                slecho('Error next page - regular expression failed');
                            }
                        } 
                        elseif ($next_query_regx) 
                        {
                            if (preg_match($next_query_regx, $data, $match)) 
                            {
                                $param = $match['param'];
                                $value = $match['value'];
                                
                                $next_page_ok |= true;
                                
                                if ($next_processor) 
                                {
                                    $value = $next_processor($param, $value);
                                }

                                if ($value) 
                                {
                                    if ($next_method == 'GET') 
                                    {
                                        $url2 = urlCombine($entry_point, '?' . $param . '=' . $value);
                                    } 
                                    else 
                                    {
                                        $url2 = $entry_point;
                                        $cur_post_data = apply_filters('filter_' . $scrapper_name . '_post_data', $param . '=' . $value, $stock_type, $host);
                                    }

                                    if ($url == $url2) 
                                    {
                                        if ($next_method != 'POST') 
                                        {
                                            $url = false;
                                        } 
                                        else 
                                        {
                                            if ($cur_post_data && $cur_post_data != $post_data) 
                                            {
                                                $url = $url2;
                                                $post_data = $cur_post_data;
                                            } 
                                            else 
                                            {
                                                $url = false;
                                            }
                                        }
                                    } 
                                    else 
                                    {
                                        $url = $url2;
                                    }
                                } 
                                else 
                                {
                                    $url = false;
                                }
                            } 
                            else 
                            {
                                slecho('Error next page - POST regular expression failed');
                                $url = false;
                            }
                        } 
                        else 
                        {
                            $url = false;
                            $next_page_ok = true;
                        }
                    } 
                    else 
                    {
                        if ($number_of_retries == 0) 
                        {
                            $url = false;
                            slecho("ERROR: Unable to connect");
                            $website_fail = true;
                            
                            $db_connect->update_status($host, array(
                                'status'        => 'FAIL',
                                'car_picked'    => $car_picked,
                                'website_fail'  => $website_fail,
                                'next_fail'     => !$next_page_ok,
                                'other_fail'    => $other_regex_fail,
                                'refine_fail'   => $refine_fail
                            ));
                            #No need to send email now
                            //send_fatal_scrapper_issue_email("$host of $scrapper_name", $car_picked, $website_fail, !$next_page_ok, $other_regex_fail, $refine_fail);

                            return;
                        } 
                        else 
                        {
                            $number_of_retries--;
                            slecho("Unable to connect. Trying another proxy.");
                        }
                    }
                }

                slecho('DEBUG notice entry count end:' . $count);
            }
        }

        slecho('DEBUG notice total cars ' . count($unique_car_urls) . ', total list pages ' . count($unique_list_urls));

        if(!$website_fail && $car_picked > 0)
        {
            $db_connect->update_status($host, array(
                'status'        => 'SUCCESS',
                'car_picked'    => $car_picked,
                'website_fail'  => $website_fail,
                'next_fail'     => !$next_page_ok,
                'other_fail'    => $other_regex_fail,
                'refine_fail'   => $refine_fail
            ));
        }
        else
        {
            $db_connect->update_status($host, array(
                'status'        => 'FAIL',
                'car_picked'    => $car_picked,
                'website_fail'  => $website_fail,
                'next_fail'     => !$next_page_ok,
                'other_fail'    => $other_regex_fail,
                'refine_fail'   => $refine_fail
            ));
            #No need to send email now
            //send_fatal_scrapper_issue_email("$host of $scrapper_name", $car_picked, $website_fail, !$next_page_ok, $other_regex_fail, $refine_fail);
        }
    }


    /**
     * { function_description }
     *
     * @param      <type>   $entry_point       The entry point
     * @param      <type>   $scrappers         The scrappers
     * @param      boolean  $scrapper_matched  The scrapper matched
     * @param      <type>   $proxy             The proxy
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    function resolve_scrapper_name_ft($entry_point, $scrappers,  &$scrapper_matched, $proxy)
    {
        if(!is_array($scrappers))
        {
            $scrapper_matched = true;
            return $scrappers;
        }
        
        $data = load_url_data_ft($entry_point, $proxy);
        
        foreach($scrappers as $scrapper)
        {
            if(preg_match($scrapper['rule'], $data))
            {
                $scrapper_matched = true;
                return $scrapper['name'];
            }
        }
    }


    /**
     * Loads an url data ft.
     *
     * @param      <type>   $url         The url
     * @param      <type>   $proxy_list  The proxy list
     * @param      integer  $days        The days
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    function load_url_data_ft($url, $proxy_list, $days = 2)
    {
        $data = get_url_cache($url, $days);
        
        if(!$data)
        {
            $data = HttpGet($url, $proxy_list);
            
            if($data)
            {
                store_url_cache($url, $data);
            }
        }
        
        return $data;
    }


    /**
     * { item_description }
     */
    if (class_exists('Collectable'))
    {
        class AsyncScrapper extends Worker
        {
            public function __construct(ThreadedDbConnect $db_connect)
            {
                $this->db_connect = $db_connect;
            }
    	
            public function getDb()
            {
                return $this->db_connect;
            }
            
            protected $db_connect;	
        }
        
        class ScrapTask extends Collectable
        {
            private $host, $dealership, $scrappers, $project_configs, $proxy, $carlist, $advanced_carlist, $tolog, $log_dir;

            public function __construct($host, $dealership, $scrappers, $project_configs, $proxy, $carlist, $advanced_carlist, $tolog, $log_dir)
            {
                $this->host             = $host;
                $this->dealership       = $dealership;
                $this->scrappers        = $scrappers;
                $this->project_configs  = $project_configs;
                $this->proxy            = $proxy;
                $this->carlist          = $carlist;
                $this->advanced_carlist = $advanced_carlist;
                $this->tolog            = $tolog;
                $this->log_dir          = $log_dir;
            }

            public function run()
            {
                global $tolog, $worker_logfile, $argv;
                
                #force slecho to pass to logme
                $argv[2] = true;
                $tolog = $this->tolog;
                
                if ($this->tolog)
                {
                    $worker_log_dir = $this->log_dir . preg_replace('/[^a-zA-Z0-9\_\-]/', '', $this->host);

                    if (!is_dir($worker_log_dir))
                    { 
                        mkdir ($worker_log_dir);
                    }

                    $worker_logfile = $worker_log_dir .'/'. date('Y-m-d_H:i:s_') .substr((string)microtime(), 1, 8) . '.log';
                }
                
                $max_time = ini_get('max_execution_time'); 
                slecho('Max execution time: ' . $max_time);

                if ($max_time != 0)
                {
                    set_time_limit(0);
                    $new_max_time = ini_get('max_execution_time'); 
                    slecho('Changed Max execution time: ' . $new_max_time);
                }
                
                $db_connect = $this->worker->getDb();
                ScrapCars($this->host, $this->dealership, $this->scrappers, $this->project_configs, $this->proxy, $db_connect, $this->carlist, $this->advanced_carlist);
                $this->setGarbage();
            }
        }
    }


    /**
     * Class for threaded database connect.
     */
    class ThreadedDbConnect
    {
        public $con;
        public $mutex, $cron_name;

        public function __construct($cron_name, $connection, $mutex)
        {
            $this->cron_name = $cron_name;
            $this->con = $connection;
            $this->mutex = $mutex;
        }

        public function store_car_data($car)
        {
            if (!isset($car['stock_number'])) 
            {
                slecho("ERROR: There is no stock number present");
                return;
            }

            Mutex::lock($this->mutex);

            if ($this->con)
            {
                $check = "SELECT stock_number, price, price_history FROM "
                    . mysql_real_escape_string($this->cron_name . "_scrapped_data")
                    . " WHERE stock_number = '"
                    . mysql_real_escape_string($car['stock_number']) . "';";

                $result = $this->query($check);

                if (!$result) 
                {
                    slecho(mysql_error($this->con) . " for " . $this->cron_name . "_scrapped_data table");
                }

                $row = mysql_fetch_array($result);

                $store_query = '';

                if ($row)
                {
                    $price = $row['price'];
                    $price_history = $row['price_history']?unserialize($row['price_history']):array();

                    if ($price != $car['price'])
                    {
                        $price_history[time()] = $car['price'];
                    }

                    $store_query .= "UPDATE "
                        . mysql_real_escape_string($this->cron_name . "_scrapped_data")
                        . " SET price = '" . mysql_real_escape_string($car['price'])
                        . "', price_value = '" . mysql_real_escape_string(numarifyPrice($car['price']))
                        . "', price_history = '" . mysql_real_escape_string(serialize($price_history))
                        . "', all_images = '" . mysql_real_escape_string($car['all_images'])
                        . "', description = '" . mysql_real_escape_string(@$car['description'])
                        . "', url = '" . mysql_real_escape_string($car['url'])
                        . "', updated_at = " . mysql_real_escape_string(time())
                        . ", deleted = 0, auto_texts = '" . mysql_real_escape_string(@$car['auto_texts']) .
                        "'  WHERE stock_number = '" . mysql_real_escape_string($car['stock_number']) .
                        "' AND (price <> '" . mysql_real_escape_string($car['price']) .
                        "' OR all_images <> '" . mysql_real_escape_string($car['all_images']) .
                        "' OR description <> '" . mysql_real_escape_string(@$car['description']) .
                        "' OR auto_texts <> '" . mysql_real_escape_string(@$car['auto_texts']) .
                        "' OR url <> '" . mysql_real_escape_string($car['url']) .
                        "' OR deleted = 1);";
                } 
                else 
                {
                    $price_history = array(
                        time() => $car['price']
                    );

                    $store_query .= "INSERT INTO "
                        . mysql_real_escape_string($this->cron_name . "_scrapped_data")
                        . ' (options, stock_number, stock_type, title, year, make, model, trim, price, price_value, price_history, '
                        . 'body_style, engine, transmission, exterior_color, interior_color, '
                        . 'kilometres, kilometres_value, all_images, auto_texts, description, url, host, arrival_date, updated_at, handled_at, lat, `long`) VALUES (\''
                        . mysql_real_escape_string($car['options']) . "', '"
                        . mysql_real_escape_string($car['stock_number']) . "', '"
                        . mysql_real_escape_string($car['stock_type']) . "', '"
                        . mysql_real_escape_string($car['title']) . "', '"
                        . mysql_real_escape_string($car['year']) . "', '"
                        . mysql_real_escape_string($car['make']) . "', '"
                        . mysql_real_escape_string($car['model']) . "', '"
                        . mysql_real_escape_string($car['trim']) . "', '"
                        . mysql_real_escape_string($car['price']) . "', '"
                        . mysql_real_escape_string(numarifyPrice($car['price'])) . "', '"
                        . mysql_real_escape_string(serialize($price_history)) . "', '"
                        . mysql_real_escape_string(@$car['body_style']) . "', '"
                        . mysql_real_escape_string(@$car['engine']) . "', '"
                        . mysql_real_escape_string(@$car['transmission']) . "', '"
                        . mysql_real_escape_string(@$car['exterior_color']) . "', '"
                        . mysql_real_escape_string(@$car['interior_color']) . "', '"
                        . mysql_real_escape_string(@$car['kilometres']) . "', '"
                        . mysql_real_escape_string(numarifyKm(@$car['kilometres'])) . "', '"
                        . mysql_real_escape_string(@$car['all_images']) . "', '"
                        . mysql_real_escape_string(@$car['auto_texts']) . "', '"
                        . mysql_real_escape_string(@$car['description']) . "', '"
                        . mysql_real_escape_string($car['url']) . "', '"
                        . mysql_real_escape_string(@$car['host']) . "', " . time() . ", " . time() . ", 0,"
                        . mysql_real_escape_string(isset($car['lat'])?$car['lat']:0) . ", " . mysql_real_escape_string(isset($car['long'])?$car['long']:0) . ");";
                }

                $this->query($store_query);

                if (mysql_errno($this->con)) 
                {
                    slecho(mysql_error($this->con));
                    slecho("**Info: Query - " . $store_query);
                }
                else
                {
                    $type = '';

                    if(startsWith($store_query, 'INSERT'))
                    {
                        $type = 'inserted';
                    }
                    elseif(startsWith($store_query, 'UPDATE'))
                    {
                        $type = 'updated';
                    }

                    slecho("Recoder $type for car {$car['stock_number']}");
                }
            }

            Mutex::unlock($this->mutex);
        }


        /**
         * { function_description }
         *
         * @param      <type>  $host_name  The host name
         * @param      <type>  $status     The status
         */
        public function update_status($host_name, $status)
        {
            Mutex::lock($this->mutex);
            $status['updated-at'] = time();
            $statusd = serialize($status);

            $query = "UPDATE imported_dealerships SET status='" . mysql_real_escape_string($statusd, $this->con) . "'
                      WHERE host_name='" . mysql_real_escape_string($host_name) . "';";

            $this->query($query);

            if (mysql_errno($this->con)) 
            {
                slecho(mysql_error($this->con));
                slecho("**Info: Query - " . $query);
            }
            else
            {
                slecho("Dealership status updated, new status $statusd");
            }

            Mutex::unlock($this->mutex);
        }


        /**
         * { function_description }
         *
         * @param      <type>  $query  The query
         *
         * @return     <type>  ( description_of_the_return_value )
         */
        public function query($query)
        {
            if (!($result = mysql_query($query, $this->con)))
            {
                slecho('Database error: ' . $query);
                slecho(mysql_error($this->con));
            }

            return $result;
        }
    }