<?php
    
    /**
     * { function_description }
     *
     * @param      boolean    $entry_url   The entry url
     * @param      DbConnect  $db_connect  The database connect
     */
    function scrap_from_autotrader($entry_url, DbConnect $db_connect)
    {
        global $site_rules, $autod_file;
        
        $total = 0;
        
        while($entry_url)
        {
            $data = scrap_url($entry_url);
            
            if ($data)
            {
                if (@$data->dealerships)    /*if($data && isset($data->dealerships))*/

                foreach ($data->dealerships as $dealership)
                {
                    if (@$dealership->company_name)
                    {
                        $total++;
                    }

                    if (@$dealership->dealer_website)
                    {
                        $host = $dealership->dealer_website;
                        slecho("$total. Dealer $dealership->company_name found with hostname $dealership->dealer_website");
                        $url = "http://$host";
                        $webdata = load_url_data($url);
                        
                        $rule_matched = false;
                
                        foreach($site_rules as $rule_name => $site_rule)
                        {
                            $dealership = process_site_host($host, $webdata, $rule_name, $site_rule, $rule_matched);

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
                    else
                    {
                        if (@$dealership->company_name)
                        {
                            $dealers = array();

                            if (file_exists($autod_file))
                            {
                                $dealers = file($autod_file, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
                            }
                            
                            if (array_search($dealership->company_name, $dealers) == FALSE)
                            {
                                slecho("$total. New dealer $data->company_name found but does not contain website info");
                                file_put_contents($autod_file, "$dealership->company_name\n", FILE_APPEND);
                            }
                            else
                            {
                                slecho("$total. Dealer $dealership->company_name found but does not contain website info");
                            }
                        }
                    }
                }
                
                $entry_url = @$data->next_page_url;

                if ($entry_url)
                {
                    $entry_url = str_replace('&amp;', '&', $entry_url);
                }
            }
            else
            {
                $entry_url = false;
            }
        }
    }
?>