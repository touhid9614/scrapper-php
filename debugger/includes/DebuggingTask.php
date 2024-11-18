<?php

    abstract class DebuggingTask implements IDebuggingTask 
    {
        protected $debugger, $logWriter, $context;
        
        abstract function Execute();

        function setDebugger(IDebugger $debugger) 
        {
            $this->debugger = $debugger;
        }

        function setLogWriter(ILogWriter $logWriter) 
        {
            $this->logWriter = $logWriter;
        }

        function setContext(Context $context) 
        {
            $this->context = $context;
        }
    }