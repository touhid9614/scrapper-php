<?php

    define('address',   1);
    define('latlng',    2);

    /**
     * { function_description }
     *
     * @param      <type>  $query  The query
     * @param      <type>  $type   The type
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    function geo_api_call($query, $type=address)
    {
        //global $google_api_key;
        
        $key = null;
        
        if ($type == address)
        {
            $key = 'address';
        }
        elseif ($type == latlng)
        {
            $key = 'latlng';
        }
        
        if (!$key) 
        {
            return null;
        }
        
        $query = urlencode($query);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?$key=$query&key=";
        $json = load_url_data($url, 365);
        
        if ($json)
        {
            return json_decode($json);
        }
        
        return null;
    }


    /**
     * { function_description }
     *
     * @param      <type>   $address    The address
     * @param      boolean  $shut_down  The shut down
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    function resolve_country($address, &$shut_down)
    {
        $shut_down = false;
        
        if (isset($address['country_code'])) 
        {
            return $address;
        }
        
        if (isset($address['lat']) && isset($address['long']))
        {
            $query = $address['lat'] . ',' . $address['long'];
            $type = latlng;
        }
        else
        {
            $query = '';
            
            if (isset($address['address_line1'])) 
            {
                $query .= $address['address_line1'];
            }

            if (isset($address['city']))
            {
                if ($query != '') 
                {
                    $query .= ', ';
                }

                $query .= $address['city'];
            }

            if (isset($address['state']))
            {
                if($query != '') 
                {
                    $query .= ', ';
                } 

                $query .= $address['state'];
            }

            if (isset($address['post_code']))
            {
                if ($query != '') 
                {
                    $query .= ' ';
                }

                $query .= $address['post_code'];
            }

            $type = address;
        }
        
        if ($query == '') 
        {
            return $address;
        }
        
        $response = geo_api_call($query, $type);
        
        if (!$response) 
        {
            return $address;
        }
        
        if ($response->status == 'OVER_QUERY_LIMIT' || $response->status == 'REQUEST_DENIED')
        {
            $shut_down = true;

            return $address;
        }
        
        if ($response->status != 'OK' || count($response->results) == 0) 
        {
            return $address;
        }
        
        $result = $response->results[0];

        foreach ($result->address_components as $comp)
        {
            if ($comp->types[0] == 'administrative_area_level_1')
            {
                $address['state'] = $comp->long_name;
                $address['state_code'] = $comp->short_name;
            }
            elseif ($comp->types[0] == 'country')
            {
                $address['country'] = $comp->long_name;
                $address['country_code'] = $comp->short_name;
            }
        }
        
        if (!isset($address['lat']))
        {
            $address['lat'] = $result->geometry->location->lat;
            $address['long'] = $result->geometry->location->lng;
        }
        
        return $address;
    }


    /**
     * { function_description }
     *
     * @param      DbConnect  $db_connect  The database connect
     */
    function process_geo_coding(DbConnect $db_connect)
    {
        $total = 0;
        $start = 0;
        $count = 20;
        
        slecho('************************* Geo Coding *************************');
        
        $dealerships = $db_connect->get_imported_dealerships($start, $count);
        $read = count($dealerships);
        
        $shut_down = false;
        
        while ($read > 0)
        {
            foreach ($dealerships as $dealership)
            {
                $total++;
                $host = $dealership['host_name'];
                slecho($total . '. ' . $host);
                
                if (!isset($dealership['address']['country_code']))
                {
                    $address = resolve_country($dealership['address'], $shut_down);
                    $dealership['address'] = $address;
                    $db_connect->store_imported_dealership($dealership);
                    usleep(200000); //sleep 0.2 seconds
                    if(isset($dealership['address']['country_code']))
                    {
                        slecho('>> Country data imported from google');
                    }
                }

                if (isset($dealership['address']['country_code']))
                {
                    slecho('Country of Dealership: ' . $dealership['address']['country']);
                }

                if ($shut_down)
                {
                    slecho('#API Access Denied');
                    
                    return;
                }
            }
            
            $start += $read;
            $dealerships = $db_connect->get_imported_dealerships($start, $count);
            $read = count($dealerships);
        }
    }
?>