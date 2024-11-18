<?php

	require_once 'bootstrap.php';
	
	$logWriter 				= new LogWriter();
	$debugger				= new Debugger($logWriter);
	$FBFeedMissingStyle    	= new FBFeedMissingStyle();
	$FBFeedMissingTemplate 	= new FBFeedMissingTemplate();
	$InvalidImage 			= new InvalidImage();
	$InvalidTemplateFile 	= new InvalidTemplateFile();
	$PriceNotPicked        	= new PriceNotPicked();
	$SpecialCharacterCheck 	= new SpecialCharacterCheck();

	$debugger->Register($FBFeedMissingStyle);
	$debugger->Register($FBFeedMissingTemplate);
	$debugger->Register($InvalidImage);
	$debugger->Register($InvalidTemplateFile);
	$debugger->Register($PriceNotPicked);
	$debugger->Register($SpecialCharacterCheck);
	$debugger->Debug('acuracentre');
	$debugger->getResult();

?>

<!DOCTYPE html>
<html>
	<head>
	    <meta charset="utf-8" />
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <title> Page Title </title>
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <link rel="stylesheet" type="text/css" media="screen" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
	</head>
	<body>
		<?php echo $debugger->getResult(); ?>

	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
	</body>
</html>