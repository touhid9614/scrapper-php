<?php
	$action = $_POST["action"];
	$input = $_POST["input"];

	$api_key = '3RSaa6tgQqYileDbEL5wRJpWBYqgpQbT';

	$items = getItems($action, $input, $api_key);

	exit(json_encode($items));
	function curlFunc($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: marketcheck-prod.apigee.net'));
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
		
		$output = curl_exec($ch);
		curl_close ($ch);
		return $output;
	}
	function getItems($action, $input, $api_key){
		if($action == "auto_search")
		{
			$url = "http://api.marketcheck.com/v1/search/auto-complete?api_key=$api_key&field=ymm&input=".$input;
			$output = curlFunc($url);
			$outitems = array();
			if($output){
				$output = json_decode($output, true);
				if($output && isset($output["terms"])){
					$outitems = $output["terms"];
					if(count($outitems) > 10){
						$outitems = array_slice($outitems, 0, 10);
					}
				}
			}
			return $outitems;
		}
		if($action == "detail_search")
		{
			$pieces = explode(" ", $input);
			$url = "http://api.marketcheck.com/v1/search?api_key=$api_key&year=".$pieces[0]."&make=".$pieces[1]."&model=".$pieces[2]."&start=0&rows=20";
			$output = curlFunc($url);
			if($output)
			{
				$output = json_decode($output, true);
				$output = $output["listings"];
				//var_dump($output);
				$outitems = array();
				for($i = 0; $i < count($output); $i ++)
				{
					if(array_key_exists("trim", $output[$i]["build"]))
						$outitems[$i]["trim"] = $output[$i]["build"]["trim"];
					if(array_key_exists("engine", $output[$i]["build"]))
						$outitems[$i]["engine"] = $output[$i]["build"]["engine"];
					if(array_key_exists("transmission", $output[$i]["build"]))
						$outitems[$i]["transmission"] = $output[$i]["build"]["transmission"];
					if(array_key_exists("price", $output[$i]))
						$outitems[$i]["price"] = $output[$i]["price"];
					else
						$outitems[$i]["price"] = 0;
					$outitems[$i]["vin"] = $output[$i]["vin"];
					$outitems[$i]["heading"] = $output[$i]["heading"];
				}
			 }
			return $outitems;
		}
		if($action == "sale_search")
		{
			$lat = $_POST["lat"];
			$long = $_POST["long"];
			$url = "http://api.marketcheck.com/v1/mds?api_key=$api_key&vin=".$input."&latitude=".$lat."&longitude=".$long."&radius=1000&exact=true&debug=1";
			$output = curlFunc($url);
			$output = json_decode($output, true);
			if($output["total_active_cars_for_ymmt"] == NULL) return 0;
			$str = $output["year"]."|".$output["make"]."|".$output["model"]."|".$output["trim"];
			$url = "http://api.marketcheck.com/v1/sales?api_key=$api_key&ymmt=".$str;
			$output1 = curlFunc($url);
			$output1 = json_decode($output1, true);
			if(isset($output1["price_stats"]))
			{
				$output["min"] = $output1["price_stats"]["min"];
				$output["max"] = $output1["price_stats"]["max"];
			}
			return $output;
		}
	}
?>