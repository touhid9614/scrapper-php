<?php

	$vin = $_POST["vin"];
	$heading = $_POST["heading"];
	$price = $_POST["price"];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title> Trade Pending </title>
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
		<script src="js/jquery.min.js"></script>
		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>

		<script type="text/javascript">
			$(document).ready(function()
			{
				if (navigator.geolocation) 
				{
					navigator.geolocation.getCurrentPosition(function (pos) 
					{
						console.log(pos);
						var lat = pos.coords.latitude;
						var long = pos.coords.longitude;

						$.ajax(
						{
					    	type: 'post',
							url: 'http://tm-dev.smedia.ca/demo/ajax.php',

							data:
							{
								"action": "sale_search",
								"input": "<?php echo $vin ?>",
								"lat": lat,
								"long": long
							},

							dataType: 'json',

							success:function(data)
							{
								console.log(data);

								if (!data)
								{
									alert("there is no car");
									return;
								}

								$("#recentnumber").html(data["total_cars_sold_in_last_45_days"]);
								$("#actviecar").html(data["total_active_cars_for_ymmt"]);

								if(data["mds"] == null || !data.hasOwnProperty("min"))
								{
									$("#costdiv").hide();
								}

								$("#min_cost").html(data["min"]);
								$("#max_cost").html(data["max"]);
								console.log(data["min"]);
								console.log(data["max"]);
								var min = data["min"];
								var max = data["max"];
								console.log(min);
								console.log(max);

								Highcharts.chart('container', 
								{
									title: 
									{
									   text: 'Flowchart of your car'
									},

									xAxis: 
									{
									    min: -0.5,
									    max: 5.5
									},

									yAxis: 
									{
									    title: 
									    {
									      text: "Price"
									    },

									    labels: 
									    {
									        formatter: function() 
									        {
									            return this.value + '$';
									        }
									    },

									    min: min - 100
									},

									series: 
									[
										{
										    type: 'line',
										    name: 'Price Line',
										    shape: "square",
										    data: [[0 , min], [5, max]],

										    marker: 
										    {
										      	enabled: false
										    },

										    states: 
										    {
										      	hover: 
										      	{
										        	lineWidth: 0
										      	}
										    },

										    enableMouseTracking: false
										}, 

										{
										    type: 'scatter',
										    name: "<?php echo $heading; ?>",
										    data: [{x:3, y:<?php echo $price; ?>, marker: {symbol: 'url(1.png)'}}],

										    tooltip: 
										    {
										    	pointFormat: "{point.y}",
										    }
										},

										{
											type: 'scatter',
									    	name: 'cars',
									    	data: [[0, min],[5, max]],

									    	marker: 
									    	{
									      		fillColor: '#ff0000', 
									      		radius: 10
									    	},

									        tooltip: 
									        {
									     		pointFormat: "{point.y}",
									     	}
									    }
								    ]
								});
							},

							error:function(err)
							{
								console.log("Error");
							}
						});
		     		});
			    }
			});
	  	</script>
	</head>

	<body>
		<div> Name: <?php echo $heading; ?> </div>

		<div> 
			Total Active Cars: 
			<span id = "actviecar"> </span>
		</div>

		<div> 
			The number for sale or recently sold by Dealers within 1000 kilometers radius : 
			<span id="recentnumber"></span>
		</div>

		<div id = "costdiv"> 
			Value: 
			<span id="min_cost"></span> 
			to 
			<span id = "max_cost"></span>
		</div>

		<div id = "container"></div>

		<style type="text/css">
			#container
			{
				min-width: 310px; 
				height: 400px; 
				margin: 0 auto;
			}
		</style>
	</body>
</html>