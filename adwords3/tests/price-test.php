<?php

    function numarifyPrice($price)
    {
        global $argv;
        
        if(is_numeric($price)) { return $price; }
        
        $t = trim(str_replace('+HST&LSC', '', str_replace('$', '', $price)));
        $temp = preg_replace('/[^0-9\.]/', '', $t);

        $pattern = "/^[0-9\.]+$/";

        if(preg_match($pattern, $temp))
        {
            return floatval($temp);
        }
        if (isset($argv[2])) {
            //slecho ("ERROR in price: ", $price);
        }

        return -1;
    }
    
    function butifyPrice($price)
    {
        $french = defined('adlang') && adlang == 'fr';
        $fp = numarifyPrice($price);

        if($fp >= 0)
        {
//                $temp = $fp . "";
//                $sprice = "";
//                $count = 0;
//                for($i = strlen($temp) - 1; $i > -1; $i--)
//                {
//                    $sprice = $temp[$i] . $sprice;
//                    $count++;
//                    if($count % 3 == 0 && $i != 0) { $sprice = "," . $sprice; }
//                }
//
//                $price = $french? $sprice . "$" : "$" . $sprice;

            if(adlang == 'fr') {
                #setlocale(LC_MONETARY, 'fr_FR.UTF-8'); #Don't want that weird Euro representation
                setlocale(LC_MONETARY, 'en_US.UTF-8');
            } else {
                setlocale(LC_MONETARY, 'en_US.UTF-8');
            }

            $price = money_format('%.2n', $fp);

            if($fp > 2000) {
                $price = substr($price, 0, stripos($price, "."));
            }

            if(adlang == 'fr') {
                $price = substr($price, 1) . "$";
            }
        }
        else
        {
            return $french? "Prix ​​sur demande" : "Please Call";
        }

        return $price;
    }
    
    $price = '-1';
    
    echo $price . PHP_EOL; 
    echo numarifyPrice($price) . PHP_EOL;
    echo butifyPrice($price) . PHP_EOL;
    echo butifyPrice(numarifyPrice($price)) . PHP_EOL;
    