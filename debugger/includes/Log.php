<?php

    class Log implements ILog
    {
        private $type, $title, $message;
        
        function __construct($title, $message, $type = DEBUG_LOG_INFO) 
        {
            $this->type     = $type;
            $this->title    = $title;
            $this->message  = $message;
        }

        function getType() 
        {
            return $this->type;
        }

        function getTitle() 
        {
            return $this->title;
        }

        function getMessage() 
        {
            return $this->message;
        }

        function IsOk() 
        {
            return $this->type <= DEBUG_LOG_INFO;
        }
    }