<?php
    
    /**
     * Loads usages.
     *
     * @param      <type>  $usages_file  The usages file
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    function load_usages($usages_file)
    {
        if(file_exists($usages_file))
        {
            $data = file_get_contents($usages_file);
            $u_data = unserialize($data);
            return $u_data;
        }
        else
        {
            return array(
                'usages'        => array(),
                'bans'          => array(),
                'ip_index'      => 0
            );
        }
    }


    /**
     * Saves usages.
     *
     * @param      <type>  $ip_usages    The ip usages
     * @param      <type>  $usages_file  The usages file
     */
    function save_usages($ip_usages, $usages_file)
    {
        $data = serialize($ip_usages);
        file_put_contents($usages_file, $data, LOCK_EX);
    }


    /**
     * Stores a cache.
     *
     * @param      <type>  $search_string  The search string
     * @param      <type>  $page           The page
     * @param      <type>  $geo            The geo
     * @param      <type>  $data           The data
     */
    function store_cache($search_string, $page, $geo, $data)
    {
        $filename = get_cache_filename($search_string, $page, $geo);
        
        $data = serialize($data);
        
        file_put_contents($filename, $data, LOCK_EX);
        
        slecho("Info: Cache stored for '$search_string' page $page.");
    }


    /**
     * Loads a cache.
     *
     * @param      <type>  $search_string  The search string
     * @param      <type>  $page           The page
     * @param      <type>  $geo            The geo
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    function load_cache($search_string, $page, $geo)
    {
        $filename = get_cache_filename($search_string, $page, $geo);
        
        if(file_exists($filename))
        {
            $now = time();
            $ft = filemtime($filename);
            
            $diff = $now - $ft;
            $hours = (int)($diff / (3600));
            
            if ($diff < (1209600))  //60 * 60 * 24 * 7 * 2      // 2 weeks
            {
                $data = file_get_contents($filename);
                $u_data = unserialize($data);
                slecho("Info: Cache loaded for '$search_string' page $page. File age: $hours hours");
                
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
     * Gets the cache filename.
     *
     * @param      string  $search_string  The search string
     * @param      string  $page           The page
     * @param      <type>  $geo            The geo
     *
     * @return     string  The cache filename.
     */
    function get_cache_filename($search_string, $page, $geo)
    {
        global $cache_directory;
        
        $hash = md5($search_string . "." . $page . "." . $geo);
        $file = "$cache_directory/$hash.cache";
        
        return $file;
    }


    /**
     * Delay (sleep) based on the license size to allow optimal scraping
     *
     *Warning!
     * Do NOT change the delay to be shorter than the specified delay.
     * When scraping Google you should never do more than 20 requests per hour per IP address
     * The recommended value is 10, if you must go higher you can go up to 20 but I'd stay lower
     * This function will create a delay based on your total IP addresses.
     *
     * Together with the IP management functions this will ensure that your IPs stay healthy (no wrong rankings) and undetected (no virus warnings, blacklists, captchas)
     *
     * Multithreading:
     * When multithreading you need to multiply the delay time ($d) by the number of threads
     */
    function apply_delay()
    {
        global $proxies;
        
        $d = (3600000000 / (((float)count($proxies)) * 8)) + rand(4000, 100000);
        
        usleep($d);
    }


    /**
     * IP Shall not be used more than 10 times in an hour
     *
     * @param      <type>   $ip     { parameter_description }
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    function check_ip_usages($ip)
    {
        global $usages_file;
        
        $ip_usages = load_usages($usages_file);
        
        if(isset($ip_usages['bans'][$ip]))    #banned ip
        {
            return false;
        }

        if(!isset($ip_usages['usages'][$ip])) #new proxy
        {
            return true;
        }
        
        if(!isset($ip_usages['usages'][$ip]['requests']['google'][10]['ut']))#not used more than 20 times
        {
            return true;
        }
        
        $ut_10th    = $ip_usages['usages'][$ip]['requests']['google'][10]['ut'];
        $now        = time();
        
        if (($now - $ut_10th) > (60 * 60))
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    /**
     * { function_description }
     *
     * @param      <type>  $ip     { parameter_description }
     * @param      <type>  $index  The index
     */
    function mark_ip_usages($ip, $index)
    {
        global $usages_file;
        
        $ip_usages = load_usages($usages_file);
        
        $now = time();
        $queue_size = 20;
        
        $ip_usages['usages'][$ip]['last_ut'] = $now;
        if(!isset($ip_usages['usages'][$ip]['total'])) $ip_usages['usages'][$ip]['total'] = 0;
        $ip_usages['usages'][$ip]['total']++;
        
        #Shift FIFO queue
        for($i = $queue_size - 1; $i >= 1; $i--)
        {
            if(isset($ip_usages['usages'][$ip]['requests']['google'][$i]['ut']))
            {
                $ip_usages['usages'][$ip]['requests']['google'][$i + 1]['ut'] = $ip_usages['usages'][$ip]['requests']['google'][$i]['ut'];
            }
        }
        
        $ip_usages['usages'][$ip]['requests']['google'][1]['ut'] = $now;
        $ip_usages['ip_index'] = $index;
        
        save_usages($ip_usages, $usages_file);
    }


    /**
     * { function_description }
     *
     * @param      <type>  $ip     { parameter_description }
     */
    function mark_banned_ip($ip)
    {
        global $usages_file;
        
        $ip_usages = load_usages($usages_file);
        
        if(!isset($ip_usages['bans'][$ip]))
        {
            $ip_usages['bans'][$ip] = true;
            save_usages($ip_usages, $usages_file);
        }
    }


    /**
     * Creates a curl session.
     *
     * @param      <type>  $url    The url
     * @param      <type>  $proxy  The proxy
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    function create_curl_session($url, $proxy)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_COOKIE, '');           /* No cookie */
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $curl_proxy = $proxy['ip'] . ':' . $proxy['port'];
        curl_setopt($ch, CURLOPT_PROXY, $curl_proxy);
        $proxy_pwd  = $proxy['user'] . ':' . $proxy['pass'];
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_pwd);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        #for now we shall use only firefox user agent
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.0; en; rv:1.9.0.4) Gecko/2009011913 Firefox/3.0.6");
        curl_setopt($ch, CURLOPT_URL, $url);
        
        return $ch;
    }


    /**
     * Loads proxies.
     *
     * @return     array  ( description_of_the_return_value )
     */
    function load_proxies()
    {
        global $proxy_list, $usages_file;
        
        $ip_usages      = load_usages($usages_file);
        $all_proxies    = loadProxies($proxy_list);
        $proxies        = array();

        foreach($all_proxies as $proxy)
        {
            $parts = explode(':', $proxy);

            if(!isset($ip_usages['bans'][$parts[0]]))
            {
                $proxies[] = array(
                    'ip'    => $parts[0],
                    'port'  => $parts[1],
                    'user'  => $parts[2],
                    'pass'  => $parts[3]
                );
            }
        }
        
        slecho("Proxies loaded " . count($proxies));
        
        return $proxies;
    }


    /**
     * Gets the data.
     *
     * @param      <type>  $url       The url
     * @param      <type>  $proxy_ip  The proxy ip
     *
     * @return     <type>  The data.
     */
    function get_data($url, &$proxy_ip = null)
    {
        global $usages_file, $proxies;
        
        $ip_usages = load_usages($usages_file);
        
        $proxy = null;
        
        $ip_index = $ip_usages['ip_index'];

        if($ip_index >= count($proxies)) 
        {
            $ip_index = 0;
        }

        $current_ip_index = -1;
        
        for($i = $ip_index; $i < count($proxies); $i++)
        {
            $p = $proxies[$i];

            if(check_ip_usages($p['ip']))
            {
                $current_ip_index = $i;
                $proxy = $p;

                break;
            }
        }
        
        if(!$proxy)
        {
            for($i = 0; $i < count($proxies); $i++)
            {
                $p = $proxies[$i];

                if(check_ip_usages($p['ip']))
                {
                    $current_ip_index = $i;
                    $proxy = $p;

                    break;
                }
            }
        }
        
        if(!$proxy)
        {
            slecho('Info: No usable proxy is available at this moment');

            return null;
        }
        
        $proxy_ip = $proxy['ip'];
        mark_ip_usages($proxy['ip'], $i + 1);
        
        slecho("Requesting with proxy {$proxy['ip']}");
        $ch = create_curl_session($url, $proxy);
        
        $contents   = curl_exec($ch);
        $httpcode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if($httpcode > 400) 
        {
            if($contents && strstr($contents, "Our systems have detected unusual traffic from your computer network.")) 
            {
                unset($proxies[$current_ip_index]);
                $proxies = array_values($proxies);
                slecho("IP $proxy_ip is over used it shall not be used soon. Remaining proxy count " . count($proxies));
                mark_banned_ip($proxy['ip']);
            }

            return null;
        }

        if ($contents)
        {
            if(is_banned($contents))
            {
                unset($proxies[$current_ip_index]);
                $proxies = array_values($proxies);
                slecho("Proxy IP {$proxy_ip} is banned. Remaining proxy count " . count($proxies));
                mark_banned_ip($proxy['ip']);
                apply_delay();

                return get_data($url);
            }

            return $contents;
        }

        else return null;
    }


    /**
     * Determines if banned.
     *
     * @param      <type>   $htmdata  The htmdata
     *
     * @return     boolean  True if banned, False otherwise.
     */
    function is_banned($htmdata)
    {
        if(strstr($htmdata, "computer virus or spyware application"))
        {
            return true;
        }

        if(strstr($htmdata, "entire network is affected"))
        {
            return true;
        }

        if(strstr($htmdata, "http://www.download.com/Antivirus")) 
        {
            return true;
        }

        if(strstr($htmdata, "/images/yellow_warning.gif"))
        {
            return true;
        }

        return false;
    }