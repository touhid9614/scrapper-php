<?php

	interface IDebugger 
	{
	    function Register(IDebuggingTask $task);
	    
	    function Debug($cron_name);
	}