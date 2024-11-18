<?php

require_once 'config-template.php';

global $config_template;

$data = [
    'password'  => 'barbermotors*pass',
    'banner'    => [
        'template'  => 'barbermotors',
        "styels"            => array(
            "new_display"       => "dynamic_banner",
            "new_retargeting"   => "dynamic_banner",
            "new_marketbuyers"  => "dynamic_banner",
        )
    ],
    "lead"  => array(
        'live'                  => false,
        'lead_type_'            => true,
    ),
    'enable_smart-offer'    => 'yes'
];

function array_remake($data, $prefix = '') {
    $retval = [];
    
    foreach($data as $k => $v) {
        if($prefix) {
            $k = "{$prefix}[$k]";
        }
        
        $retval[$k] = $v;
        
        if(is_array($v)) {
            $retval = array_merge($retval, array_remake($v, $k));
        }
    }
    
    return $retval;
}

var_dump(array_remake($data));

?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>Configuration Manager Test</title>
    </head>
    <body>
        <div id="config-manager">
            Test
        </div>
        <script src="../assets/vendor/jquery/jquery.js"></script>
        <script src="app/js/config-manager.js"></script>
        <script>
            (function($) {
                smedia_prepare_configuration($);
                sMedia.Configuration.init('#config-manager', <?= json_encode($config_template) ?>, <?= json_encode(array_remake($data)) ?>);
                /*
                sMedia.Configuration.rendered(function(){
                    alert('Hello, render completed');
                });
                */
                sMedia.Configuration.render();
                //var control = new sMedia.Configuration.Types.string('banner[template]', {name : 'Template Directory'}, 'barbermotors');
                //alert(control.render());
            })(jQuery);
        </script>
    </body>
</html>