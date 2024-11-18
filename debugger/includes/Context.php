<?php

	class Context 
	{
	    public $cron_name, $cron_config, $scrapper_config;

	    public function __construct($cron_name) 
	    {

	        global $CronConfigs, $scrapper_configs;

	        $this->cron_name        = $cron_name;
	        $this->cron_config      = isset($CronConfigs[$cron_name])		? $CronConfigs[$cron_name] 		: null;
	        $this->scrapper_config  = isset($scrapper_configs[$cron_name])	? $scrapper_configs[$cron_name] : null;
	    }
	}