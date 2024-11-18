<?php

    $logdirs = array(
        __DIR__ . "/logs/",
        __DIR__ . "/ng_logs/"
    );

    foreach($logdirs as $logdir)
    {
        foreach(array_filter(glob($logdir . '/*/*.log'), 'is_file') as $file)
        {
            unlink($file);
        }
    }

    foreach($logdirs as $logdir)
    {
        foreach(glob($logdir . '/*') as $dir)
        {
            rmdir($dir);
        }
    }