<?php
    
    /**
     * { function_description }
     *
     * @param      <type>  $search_term  The search term
     * @param      <type>  $start        The start
     *
     * @return     array   ( description_of_the_return_value )
     */
    function searchBing($search_term, $start)
    {       
        $html = HttpGet("http://www.bing.com/search?q=" . urlencode($search_term)."&go=&qs=n&sk=&sc=8-20&first=$start&FORM=QBLH");

        $doc = new DOMDocument();
        @$doc->loadHtml($html);
        $x = new DOMXpath($doc);

        $output = array();

        $count_node = $x->query("//span[@class='sb_count']");

        if ($count_node->length > 0)
        {
            echo $count_node->item(0)->textContent . "<br/>\n";
        }
        
        // just grab the urls for now
        foreach ($x->query("//li[@class='b_algo']//h2//a") as $node)          
        {
            $output[] = $node->getAttribute("href");
        }
        
        if (count($output) == 0)
        {
            $nodes = $x->query("//div[@class='sc_captcha']");
            
            if ($nodes->length > 0)
            {
                echo "Captcha encountered. <br/>\n";
            }
        }
        
        return $output;
    }


    /**
     * { function_description }
     *
     * @param      <type>   $query   The query
     * @param      array    $result  The result
     * @param      integer  $page    The page
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    function process_bing_request($query, &$result, $page = 1)
    {
        global $bing_endpoint;
        
        $query = urlencode("'$query'");
        $skip  = ($page - 1) * 50;
        
        $url = "$bing_endpoint?Query=$query&" . '$format=json&$skip=' . $skip;
        
        $data = HttpGet($url);
        
        $json = json_decode($data);
        
        $result = array();
        
        foreach($json->d->results as $sr)
        {
            $result['r'][] = array(
                'id'    => $sr->ID,
                'url'   => $sr->Url
            );
        }
        
        $result['next'] = $json->d->__next;
        
        return count($result['r']);
    }
?>