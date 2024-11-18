<?php

	class PriceNotPicked extends DebuggingTask 
	{
		public $min_price, $max_price;

	    function Execute() 
	    {
	    	$cron 					= $this->context->cron_name;
	    	$table 					= $cron . '_scrapped_data';
	    	$query 					= "SELECT url, price from $table where deleted = 0";
	    	$result 				= DbConnect::get_instance()->query($query);
	    	$data   				= [];
	    	$priceQuery 			= "SELECT min_price, max_price from vs_config where dealership = '$cron'";
	    	$priceResult 			= DbConnect::get_instance()->query($priceQuery);
	    	$msg 					= "URL 														PRICE <br>";
	    	$error 					= false;

	    	if($priceOutput			= mysqli_fetch_assoc($priceResult))
	    	{
	    		$this->min_price 	= $priceOutput['min_price'];
	    		$this->max_price 	= $priceOutput['max_price'];
	    	}
	    	else
	    	{
	    		$this->min_price 	= 1000.00;
	    		$this->max_price 	= 1000000.00;
	    	}
	    	
	    	while ($row 			= mysqli_fetch_assoc($result)) 
		    {
		    	$data[$row['url']] 	= $row['price'];
		        
		        if (!$this->isValidPrice($row['price']))
		        {
		        	$msg 			.= str_pad($row['url'], 100, " ") . "		" . str_pad($row['price'], 15, " ") . "<br>";
		        	$error 			= true;
		        }
		    }

	        if ($error)
            {
                return new Log("Price Check", $msg, DEBUG_LOG_ERROR);
            }
            else
            {
                return new Log("Price Check", $msg, DEBUG_LOG_SUCCESS);
            }
	    }

	    function isValidPrice($price)
	    {
	    	if (!$price)	return false;

	    	$price = strtolower($price);

    		if ($price == 'please call' || $price == 'call for price' || $price == 'request a quote') return false;

    		$price = str_replace('$', '', $price);
    		$price = str_replace(',', '', $price);

    		if ($price < $this->min_price || $price > $this->max_price)	return false;

	    	return preg_match("/^[0-9]+(\.[0-9]{2})?$/", $price);
	    }
	}