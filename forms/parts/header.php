<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Fonts -->
<link href="//fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

<!-- CSS -->
<link rel="stylesheet" href="assets/js/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" href="assets/css/style_refresh.css">

<script>
    
<?php

    $dealership     = filter_input(INPUT_GET, 'dealership', FILTER_SANITIZE_STRING);
    
    $script_file    = dirname(__DIR__) . "/third-party-code/$dealership.js";

    $script_data    = null;

    if(file_exists($script_file)) {
        $script_data= file_get_contents($script_file);
    }

    if($script_data) { echo $script_data; } else { echo "//No script found for $script_file"; }
 ?>

</script>