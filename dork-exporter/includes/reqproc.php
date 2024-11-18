<?php
    
    /**
     * { function_description }
     *
     * @param      <type>     $query       The query
     * @param      DbConnect  $db_connect  The database connect
     * @param      integer    $pages       The pages
     */
    function process_site_request($query, DbConnect $db_connect, $pages = 0)
    {
        global $site_rules;
        
        $total = 0;
        $has_more = true;
        $page = 0;

        slecho("Processing Dork Query <pre>$query</pre>");
        
        while ($has_more)
        {
            $result = google($query, $page, $has_more);
            $page++;
            
            if ($pages > 0 && $pages == $page) 
            {
                $has_more = false;
            }
            
            slecho("Page $page");

            foreach ($result as $r)
            {
                $total++;
                $host = $r['host'];
                slecho($total . '. ' . $host);
                
                $url = "http://$host";
                $data = load_url_data($url);

                if (!$data)
                {
                    slecho("Unable to load data form $url");

                    continue;
                }
                
                $rule_matched = false;
                
                foreach ($site_rules as $rule_name => $site_rule)
                {
                    $dealership = process_site_host($host, $data, $rule_name, $site_rule, $rule_matched);
                    
                    if ($rule_matched)
                    {
                        $db_connect->store_imported_dealership($dealership);
                        break;
                    }
                }
                
                if (!$rule_matched)
                {
                    $dealership['entry_points']     = array();
                    $dealership['rule_name']        = '';
                    $dealership['rule_matched']     = false;
                    $dealership['scrapper_name']    = '';
                    $dealership['scrapper_matched'] = false;
                    $dealership['address']          = '';
                    $db_connect->store_imported_dealership($dealership);
                }
            }
        }
    }


    /**
     * Loads an url data.
     *
     * @param      <type>   $url    The url
     * @param      integer  $days   The days
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    function load_url_data($url, $days = 2)
    {
        global $proxy_list;
        
        $data = get_url_cache($url, $days);
        
        if (!$data)
        {
            $data = HttpGet($url, $proxy_list);
            
            if ($data)
            {
                store_url_cache($url, $data);
            }
        }
        
        return $data;
    }


    /**
     * Gets the url cache.
     *
     * @param      <type>   $url    The url
     * @param      integer  $days   The days
     *
     * @return     <type>   The url cache.
     */
    function get_url_cache($url, $days)
    {
        $filename = get_url_cache_name($url);
        
        if (file_exists($filename))
        {
            $now = time();
            $ft = filemtime($filename);
            
            $diff = $now - $ft;
            //$hours = (int)($diff / (3600));
            
            if ($diff < (86400 * $days))  //two days cache
            {
                $data = file_get_contents($filename);
                $u_data = unserialize($data);
                //slecho("Info: Cache loaded for '$url'. File age: $hours hours");
                return $u_data;
            }
            else
            {
                return null;
            }
        }
        else
        {
            return null;
        }
    }


    /**
     * Stores an url cache.
     *
     * @param      <type>  $url    The url
     * @param      <type>  $data   The data
     */
    function store_url_cache($url, $data)
    {
        $filename = get_url_cache_name($url);
        
        $data = serialize($data);
        
        file_put_contents($filename, $data, LOCK_EX);
        //slecho("Info: Cache stored for '$url'.");
    }


    /**
     * Gets the url cache name.
     *
     * @param      <type>  $url    The url
     *
     * @return     string  The url cache name.
     */
    function get_url_cache_name($url)
    {
        global $cache_directory;
        
        $hash = md5($url);
        $file = "$cache_directory/$hash.cache";
        
        return $file;
    }


    /**
     * { function_description }
     *
     * @param      <type>   $host          The host
     * @param      <type>   $data          The data
     * @param      <type>   $rule_name     The rule name
     * @param      <type>   $site_rule     The site rule
     * @param      boolean  $rule_matched  The rule matched
     *
     * @return     array    ( description_of_the_return_value )
     */
    function process_site_host($host, $data, $rule_name, $site_rule, &$rule_matched)
    {    
        $rule_matched = true;
        $shut_down = false;
        
        foreach ($site_rule['match-rules'] as $rule)
        {
            if (!preg_match($rule, $data))
            {
                $rule_matched = false;
                slecho("Rule did not match: $rule_name");

                break;
            }
        }
        
        $address = '';
        $match = null;
        $address_graber = "${rule_name}_dealer_address";
        $scrapper_name = '';
        $scrapper_matched = false;
        $entry_points = array();
        
        if ($rule_matched)
        {
            if (function_exists($address_graber))
            {
                $address = call_user_func_array($address_graber, array($host, $data));
            }

            $entry_point = '';
            
            if (isset($site_rule['entry_points']))
            {
                foreach ($site_rule['entry_points'] as $stock_type => $entry_regexs)
                {
                    foreach ($entry_regexs as $regex)
                    {
                        if (preg_match($regex, $data, $match))
                        {
                            $entry_points[$stock_type][] = $match['url'];
                            $entry_point = $match['url'];
                        }
                    }
                }
            }
        
            if ($address)
            {
                $address = resolve_country($address, $shut_down);
            }
            
            if (isset($address['country']))
            {
                slecho('Country of Dealership: ' . $address['country']);
            }
            else
            {
                slecho('Unable to resolve country');
            }
            
            if ($entry_point)
            {
                $entry_url = urlCombine("http://$host/", $entry_point);
                $scrapper_name = resolve_scrapper_name($entry_url, $site_rule['scrapper'], $scrapper_matched);
            }
            
            slecho("Rules matched: $rule_name");
        }
        
        $dealership             = array(
            'host_name'         => $host,
            'entry_points'      => $entry_points,
            'rule_name'         => $rule_name,
            'rule_matched'      => $rule_matched,
            'scrapper_name'     => $scrapper_name,
            'scrapper_matched'  => $scrapper_matched,
            'address'           => $address
        );
        
        return $dealership;
    }


    /**
     * { function_description }
     *
     * @param      DbConnect  $db_connect  The database connect
     */
    function process_check_providers(DbConnect $db_connect)
    {
        global $site_rules;
        
        $total = 0;
        $start = 0;
        $count = 20;
        
        slecho('************************* Provider Checker *************************');
        
        $where = "rule_name = 'dealercom'";
        
        $dealerships = $db_connect->get_imported_dealerships($start, $count, $where);
        $read = count($dealerships);
        
        while ($read > 0)
        {
            foreach ($dealerships as $d)
            {
                $total++;
                $host = $d['host_name'];
                $url = "http://$host";
                slecho($total . '. ' . $host);
                $data = load_url_data($url);
                $rule_matched = false;

                foreach ($site_rules as $rule_name => $site_rule)
                {
                    $dealership = process_site_host($host, $data, $rule_name, $site_rule, $rule_matched);
                    
                    if ($rule_matched)
                    {
                        $db_connect->store_imported_dealership($dealership);

                        break;
                    }
                }
            }
            
            $start += $read;
            $dealerships = $db_connect->get_imported_dealerships($start, $count, $where);
            $read = count($dealerships);
        }
    }


    /**
     * { function_description }
     *
     * @param      <type>   $entry_point       The entry point
     * @param      <type>   $scrappers         The scrappers
     * @param      boolean  $scrapper_matched  The scrapper matched
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    function resolve_scrapper_name($entry_point, $scrappers, &$scrapper_matched)
    {
        if (!is_array($scrappers))
        {
            $scrapper_matched = true;
            
            return $scrappers;
        }
        
        $data = load_url_data($entry_point);
        
        foreach ($scrappers as $scrapper)
        {
            if (preg_match($scrapper['rule'], $data))
            {
                $scrapper_matched = true;

                return $scrapper['name'];
            }
        }
    }