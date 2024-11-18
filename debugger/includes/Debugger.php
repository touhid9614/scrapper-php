<?php

    class Debugger implements IDebugger
    {
        private $logWriter, $debuggingTasks, $debugOutput;
        public $context;

        public function __construct(ILogWriter $logWriter)
        {
            $this->logWriter      = $logWriter;
            $this->debuggingTasks = [];
            $this->debugOutput    = [];
        }

        public function Register(IDebuggingTask $task)
        {
            if (!$task || !($task instanceof IDebuggingTask)) 
            {
                return;
            }

            $task->setDebugger($this);
            $task->setLogWriter($this->logWriter);

            $this->debuggingTasks[] = $task;
        }

        public function Debug($cron_name)
        {
            $this->context = new Context($cron_name);

            foreach ($this->debuggingTasks as $task) 
            {
                $task->setContext($this->context);

                $log = $task->Execute();

                if (!($log instanceof ILog)) 
                {
                    continue;
                }

                $this->debugOutput[] = $log;
            }
        }

        public function getResult()
        {
            ob_start();

            foreach ($this->debugOutput as $log) 
            {
                $this->logWriter->Write($log);
            }

            return ob_get_clean();
        }
    }
