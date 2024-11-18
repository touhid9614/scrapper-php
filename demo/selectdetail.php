<?php
	$trade = $_POST["beast"];
?>

<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title> Trade Pending </title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<script src="js/jquery.min.js"></script>
	</head>

	<body>
		<div> Select more detail about your vehicle - <?php echo $trade; ?>:</div>
		<div id = "trimbtndiv"></div>
		<div id = "enginebtndiv"></div>
		<div id = "transbtndiv"></div>
		<div id = "finalcar"></div>

		<form id = "myform" method="post" action="./report.php">
			<input type="text" name="vin" value="" id = "vininput">
			<input type="text" name="heading" value="" id = "heading">
			<input type="text" name="price" value="" id = "price">
		</form>

		<script type="text/javascript">
			$(document).ready(function()
			{
				var cararray = [];
				var trim;
				var type;
				var latitude, longitude;

				$(document).on('click', '#finalcarbtn', function(e)
				{
					var heading = $(this).val();
					$("#heading").val(heading);

					for(i = 0, crlen = cararray.length; i < crlen; i++)
					{
						if(cararray[i]["heading"] == heading)
						{
							$("#vininput").val(cararray[i]["vin"]);
							$("#price").val(cararray[i]["price"]);

							break;
						}
					}

					$("#myform").submit();
				});


				$(document).on('click', '#transbtn', function(e)
				{
					var trans = $(this).val();
					var cararraytemp = [];
					var headingarray = [];

					if (trans != "NULL")
					{
						for(i = 0, crlen = cararray.length; i < crlen; i++)
						{
							if(cararray[i]["transmission"] == trans)
							{
								cararraytemp[cararraytemp.length] = cararray[i];
							}
						}

						cararray = cararraytemp;
					}

					for (i = 0, crlen = cararray.length; i < crlen; i ++)
					{
						headingarray[i] = cararray[i]["heading"];
					}

					var headingarray = headingarray.filter(function(item, pos, self) 
					{
						return self.indexOf(item) == pos;
					});

					$("#transbtndiv").hide();
					$("#finalcar").append("<div>Select your car</div>");

					for (i = 0, hrlen = headingarray.length; i < hrlen; i++)
					{
						if(cararray[i]["price"] != 0)
						{
							$("#finalcar").append('<input id = "finalcarbtn" style = "display:block; margin-top: 10px;" type="button" value="'+ headingarray[i] + '"/>');
						}
					}

					if (cararray.length == 1)
					{
						$("#finalcarbtn").click();
					}
				});


				$(document).on('click', '#enginebtn', function(e)
				{
					var transarray = [];
					engine = $(this).val();
					var cararraytemp = [];

					if (engine != "NULL")
					{
						for (i = 0, crlen = cararray.length; i < crlen; i++)
						{
							if(cararray[i]["engine"] == engine)
							{
								cararraytemp[cararraytemp.length] = cararray[i];
							}
						}

						cararray = cararraytemp;			
					}

					for (i = 0, crlen = cararray.length; i < crlen; i++)
					{
						if(cararray[i].hasOwnProperty("transmission"))
						{
							transarray[transarray.length] = cararray[i]["transmission"];
						}
					}

					var transarray = transarray.filter(function(item, pos, self) 
					{
						return self.indexOf(item) == pos;
					});

					$("#enginebtndiv").hide();
					$("#transbtndiv").append("<div>Select transmission</div>");

					var trlen = transarray.length;

					for (i = 0; i < trlen; i ++)
					{
						$("#transbtndiv").append('<input id = "transbtn" style = "display:block;margin-top: 10px;" type="button" value="' + transarray[i] + '"/>');
					}

					if (trlen == 1)
					{
						$("#transbtn").click();
					}

					if (trlen == 0)
					{
						$("#transbtndiv").append('<input id = "transbtn" style = "display:block;margin-top: 10px;" type="button" value="NULL"/>');
						$("#transbtn").click();
					}
				});


				$(document).on('click', '#trimbtn', function(e)
				{
					var enginearray = [];
					trim = $(this).val();
					var cararraytemp = [];

					if (trim != "NULL")
					{
						for (i = 0, crlen = cararray.length; i < crlen; i++)
						{
							if(cararray[i]["trim"] == trim)
							{
								cararraytemp[cararraytemp.length] = cararray[i];
							}
						}

						cararray = cararraytemp;
					}

					for (i = 0, crlen = cararray.length; i < crlen; i++)
					{
						if(cararray[i].hasOwnProperty("engine"))
						{
							enginearray[enginearray.length] = cararray[i]["engine"];
						}
					}

					var enginearray = enginearray.filter(function(item, pos, self) 
					{
						return self.indexOf(item) == pos;
					});

					$("#trimbtndiv").hide();
					$("#enginebtndiv").append("<div> Select body engine </div>");

					var engArry = enginearray.length;

					for (i = 0; i < engArry; i++)
					{
						$("#enginebtndiv").append('<input id = "enginebtn" style = "display:block;margin-top: 10px;" type="button" value="' + enginearray[i] + '"/>');
					}

					if (engArry == 1)
					{
						$("#enginebtn").click();
					}

					if (engArry == 0)
					{
						$("#enginebtndiv").append('<input id = "enginebtn" style = "display:block; margin-top: 10px;" type="button" value="NULL"/>');
						$("#enginebtn").click();
					}
				});


				$.ajax(
				{
				    type: 'post',
					url: 'http://tm-dev.smedia.ca/demo/ajax.php',

					data:
					{
						"action": "detail_search",
						"input": "<?php echo $trade ?>"
					},

					dataType: 'json',

					success:function(data)
					{
						cararray = data;
						console.log(data);
						
						var dtlen = data.length;

						if (!dtlen)
						{
							alert("there is no car");

							return;
						}

						var trimarray = [];
						var i, j;

						for(i = 0; i < dtlen; i ++)
						{
							if(cararray[i].hasOwnProperty("trim"))
							{
								trimarray[i] = data[i]["trim"];
							}
						}

						var trimarray = trimarray.filter(function(item, pos, self) 
						{
						    return self.indexOf(item) == pos;
						});

						$("#trimbtndiv").append("<div>Select Trim</div>");

						var tmArry = trimarray.length;

						for(i = 0; i < tmArry; i ++)
						{
							$("#trimbtndiv").append('<input id = "trimbtn" style = "display:block;margin-top: 10px;" type="button" value="' + trimarray[i] + '"/>');
						}

						if (tmArry)
						{
							$("#trimbtndiv").append('<input id = "trimbtn" style = "display:block;margin-top: 10px;" type="button" value="NULL"/>');
							$("#trimbtn").click();
						}

						if (tmArry)
						{
							$("#trimbtn").click();
						}
					},

					error:function(err)
					{
						console.log("Error");
					},
				});
			});
  		</script>

  		<style type="text/css">
  			#myform
  			{
  				display: none;
  			}
  		</style>
	</body>
</html>
