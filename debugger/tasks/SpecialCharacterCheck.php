<?php
	
	// Ads may only contain alphanumeric characters, punctuation, and spaces. Symbols like <, ~, = etc are not allowed.
	// Additionally, text that's in all-caps will be flagged, depending on the circumstance.
	
	class SpecialCharacterCheck extends DebuggingTask 
	{
	   	function Execute() 
	    {
	    	global $BannerConfigs, $CronConfigs;

	    	$cron 		= $this->context->cron_name;
	    	$blackList 	= getBlackList();
	    	$data  		= [];
	    	$testThese  = [];
	    	$message 	= "URL 												<br>";
	    	$warn 		= false;
	    	$error 		= false;
	    	$table 		= $cron . '_scrapped_data';
	    	$query 		= "SELECT url, year, make, model, body_style, price from $table where deleted = 0";
	    	$result 	= DbConnect::get_instance()->query($query);
	    	$whiteRegex = '/[a-zA-Z0-9$\[\],.%-@!? ]+/';

	    	while ($row = mysqli_fetch_assoc($result))
		    {
		    	$data[$row['url']]	= 
		    	[
		    		'year' 			=> trim($row['year']),
		    		'make' 			=> trim($row['make']),
		    		'model' 		=> trim($row['model']),
		    		'body_style' 	=> trim($row['body_style']),
		    		'price' 		=> trim($row['price'])
		    	];

		    	$testThese[$row['url']] = 
		    	[
		    		'fb_brand' => '[' . trim($row['year']) . '] [' . trim($row['make']) . '] [' . trim($row['model']) . '] - [' . trim($row['body_style']) . ']',
		    		'fb_description' => "Are you still interested in the [" . trim($row['year']) . "] [" . trim($row['make']) . "] [" . trim($row['model']) . "]? Click for more info.",
		    		'fb_lookalike_description' => "Test drive the [" . trim($row['year']) . "] [" . trim($row['make']) . "] [" . trim($row['model']) . "] today.",
		    		'fb_dynamiclead_description_new' => "Interested in the [" . trim($row['year']) . "] [" . trim($row['make']) . "] [" . trim($row['model']) . "]? Click below and fill in your information to take it for a test drive.",
		    		'fb_dynamiclead_description_used' => "Still interested in the [" . trim($row['year']) . "] [" . trim($row['make']) . "] [" . trim($row['model']) . "]? Click below and fill in your information to get $1,000 OFF any pre-owned vehicles!"
		    	];
		    }
		    
		    foreach ($testThese as $url => $urlArray) 
		    {
		    	$char = array_unique(array_merge(
		    		str_split($urlArray['fb_brand']), 
		    		str_split($urlArray['fb_description']), 
		    		str_split($urlArray['fb_lookalike_description']), 
		    		str_split($urlArray['fb_dynamiclead_description_new']), 
		    		str_split($urlArray['fb_dynamiclead_description_used']),
		    		str_split($data[$url]['price'])));
		    	
		    	$char = array_filter(str_split(preg_replace($whiteRegex, '', join("",$char))));
				
				if (sizeof($char))
				{
					foreach ($char as $ch)
					{
						if (in_array($ch, $blackList))
						{
							$message .= $url . "	conatins black listed character (" . $ch . ") in facebook description. <br.";
							$error = true;
						}
						else
						{
							$message .= $url . "	contains confusing character (" . $ch . ") which is absent in both white list and black list. <br>";
							$warn = true;
						}
					}
				}
		    }

		    if (!$error && !$warn)
		    {
		    	return new Log("Special Character Check", "No invalid fb character found.", DEBUG_LOG_SUCCESS);
		    }
		    else
		    {
		    	if ($error)
		    	{
		    		return new Log("Special Character Check", $message, DEBUG_LOG_ERROR);
		    	}
		    	else
		    	{
		    		return new Log("Special Character Check", $message, DEBUG_LOG_WARNING);
		    	}
		    }
	    }
	}