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
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">

		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/stylesheet.css">
		<link rel="stylesheet" type="text/css" href="css/autoplugin.css">

		<script src="js/jquery.min.js"></script>
		<script src="js/autoplugin.js"></script>
	</head>

    <body>
		<div id="wrapper">
			<div class="demo">
				<div class="control-group">
					<form form action="./selectdetail.php" method="post">
						<label for="select-beast"> Value Your Trade : </label>
						<select id="select-beast" required class="demo-default" placeholder="Enter Year, Make, Model" name="beast"></select>
						<br>
						<button type="submit" class="submit_btn"> Submit </button>
					</form>
				</div>

				<script>
					$('#select-beast').selectize(
					{
						create: false,

						sortField:
						{
							field: 'text',
							direction: 'asc'
						}
					});
				</script>

				<style type="text/css">
					.submit_btn 
					{
						border: none;
						padding: 16px 32px;
						text-align: center;
						text-decoration: none;
						display: inline-block;
						font-size: 16px;
						margin: 4px 2px;
						-webkit-transition-duration: 0.4s
						transition-duration: 0.4s;
						cursor: pointer;
						background-color: #008CBA;
						color: white;
						border-radius: 10px;
					}

					.submit_btn:hover
					{
						box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
					}
				</style>
			</div>
		</div>
	</body>
</html>
