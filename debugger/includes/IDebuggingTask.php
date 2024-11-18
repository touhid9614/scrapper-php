<?php

	interface IDebuggingTask 
	{

	    function Execute();

	    function setDebugger(IDebugger $debugger);

	    function setLogWriter(ILogWriter $logWriter);

	    function setContext(Context $context);
	}