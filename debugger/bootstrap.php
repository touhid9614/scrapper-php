<?php

    require_once __DIR__ . '/constants.php';
    require_once dirname(__DIR__) . '/dashboard/config.php';
    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'db-config.php';
    require_once ADSYNCPATH . 'db_connect.php';
    //require_once ADSYNCPATH . 'tag_db_connect.php';
    require_once ADSYNCPATH . 'utils.php';

    spl_autoload_register(function ($class_name) 
    {

        $file_name = $class_name . '.php';

        $dirs = 
        [
            __DIR__ . '/includes/',
            __DIR__ . '/tasks/'
        ];

        foreach($dirs as $dir) 
        {
            if(file_exists($dir . $file_name)) 
            {
                include $dir . $file_name;
                break;
            }
        }
    });