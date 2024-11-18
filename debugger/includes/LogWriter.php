<?php

    class LogWriter implements ILogWriter 
    {
        public function Write(ILog $log) 
        {
            $type_str = '';

            switch($log->getType()) 
            {
                case DEBUG_LOG_INFO:
                    $type_str = 'info';
                break;

                case DEBUG_LOG_WARNING:
                    $type_str = 'warning';
                break;

                case DEBUG_LOG_ERROR:
                    $type_str = 'danger';
                break;
                
                case DEBUG_LOG_SUCCESS:
                    $type_str = 'success';
                break;
            }

            echo "<div class=\"alert alert-{$type_str}\"><strong>{$log->getTitle()}</strong><p>{$log->getMessage()}</p></div>";
        }
    }