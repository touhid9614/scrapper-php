<?php

require_once __DIR__ . '/parser.php';

$templates_dir = __DIR__ . '/templates';

if(!$template) {
    die('Template isn\'t specified!!');
}

$template_base = "$templates_dir/$template";

if(!file_exists($template_base)) {
    die('Template doesn\'t exist!!');
}

if(!$side) {
    die('Side isn\'t specified!!');
}

$template_file = "$template_base/$side.html";

if(!file_exists($template_file)) {
    die("Template side doesn't exist!!");
}

$template_data = file_get_contents($template_file);

$pnames = [];

$data = preg_replace_callback(
    '/{{(?<pname>[^}]+)}}/',
    function ($matches) use ($params) {
        $pname = $matches['pname'];
        
        if(isset($params[$pname])) {
            return $params[$pname];
        }
        
        return '';
    },
    $template_data
);

?>
<?= $data ?>