<?php

    # Load all scrapper configs
    global $special_configs;

    $special_configs = array();

    if (is_dir(SCRPINC))
    {
        foreach(array_filter(glob(SCRPINC . '*.php'), 'is_file') as $file)
        {
            require_once $file;
        }
    }

    # Validate scrapper configs
    $keys = array_keys($special_configs);
    $keys_to_remove = array();

    for ($i = 0; $i < count($special_configs); $i++)
    {
        $special_config = $special_configs[$keys[$i]];
        
        if (!isset($special_config['type']) || !isset($special_config['url_identity']))
        {
            $keys_to_remove[] = $keys[$i];
        }
    }

    foreach($keys_to_remove as $key)
    {
        unset($special_configs[$key]);
    }
?>