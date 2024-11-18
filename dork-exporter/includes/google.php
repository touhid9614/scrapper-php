<?php
    
    /**
     * { function_description }
     *
     * @param      <type>   $search_string  The search string
     * @param      integer  $page           The page
     * @param      boolean  $has_more       Indicates if more
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    function google($search_string, $page, &$has_more)
    {
        if($search_string) {
            $search_string = urlencode($search_string);
        }
        
        $htmdata = load_cache($search_string, $page, 'ca');
        
        if (!$htmdata)
        {
            if ($page == 0)
            {
                $url = "https://www.google.com/search?q=$search_string&hl=en-US&ie=utf-8&as_qdr=all&aq=t&rls=org:mozilla:us:official&client=firefox&num=100&filter=0&gl=ca";
            }
            else
            {
                $num = $page * 100;
                $url = "https://www.google.com/search?q=$search_string&hl=en-US&ie=utf-8&as_qdr=all&aq=t&rls=org:mozilla:us:official&client=firefox&start=$num&num=100&filter=0&gl=ca";
            }
            
            $proxy_ip = null;
            $htmdata = get_data($url, $proxy_ip);
            $try = 1;
            
            while (!$htmdata && $try < 5) 
            {
                slecho("Retry attempt $try");
                $htmdata = get_data($url, $proxy_ip);
                $try++;
            }
            
            if ($htmdata)
            {
                store_cache($search_string, $page, 'ca', $htmdata);
            } 
            else 
            {
                slecho("Possible Network/Proxy error");
            }
            
            apply_delay();  //after each call delay here
        }
        
        $has_more = false;

        if (!$htmdata) 
        {
            return null;
        }
        
        return process_result($htmdata, $page, $has_more);
    }


    /**
     * { function_description }
     *
     * @param      <type>   $data      The data
     * @param      integer  $page      The page
     * @param      boolean  $has_more  Indicates if more
     *
     * @return     array    ( description_of_the_return_value )
     */
    function process_result($data, $page, &$has_more)
    {
        $results = array();
        //die($data);
        $html = new simple_html_dom();
        $html->load($data);
        /** @var $interest simple_html_dom_node */
        $interest = $html->find('div#ires ol div.g');
        slecho("Info: found interesting elements: ".count($interest));
        
        if(count($interest) == 0) 
        {
            slecho("Possible change in google website please fix.");

            die($data);
        }
        
        $interest_num = 0;

        foreach ($interest as $li)
        {
            $result = array('title'=>'undefined','host'=>'undefined','url'=>'undefined','type'=>'organic');
            $interest_num ++;
            $h3 = $li->find('h3.r',0);

            if (!$h3)
            {
                continue;
            }

            $a = $h3->find('a',0);

            if (!$a) 
            {
                continue;
            }

            $result['title'] = html_entity_decode($a->plaintext);
            $lnk = urldecode($a->href);

            if ($lnk)
            {
                $m = null;
                preg_match('/(ht[^&]*)/', $lnk, $m);

                if ($m && $m[1])
                {
                    $result['url']=$m[1];
                    $tmp=parse_url($m[1]);
                    $result['host']=$tmp['host'];
                }
                else
                {
                    if (strstr($result['title'],'News')) 
                    {
                        $result['type']='news';
                    }

                    if (strstr($result['title'],'Images')) 
                    {
                        $result['type']='images';
                    }
                }
            }

            $h3->clear();
            $a->clear();
            $li->clear();
            $results[]=$result;
        }

        $html->clear();

        // Analyze if more results are available (next page)
        $next = 0;

        if (strstr($data, "Next</a>"))
        {
            $next = 1;
        } 
        else
        {
            $needstart = ($page + 1) * 10;
            $findstr = "start=$needstart";

            if (strstr($data, $findstr))
            {
                $next = 1;
            }
        }

        if ($next)
        {
            $has_more = true;
        }
        else
        {
            $has_more = false;
        }

        return $results;
    }