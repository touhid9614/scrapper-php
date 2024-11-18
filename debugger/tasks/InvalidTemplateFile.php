<?php

    class InvalidTemplateFile extends DebuggingTask 
    {

        function Execute() 
        {
            //1. Iterate into template dealer directory recursively
            //2. Iterate every file/directory
            //3. If the file is not image, rather if it's directory then return nothing
            //4. if the file is image but not png then added error message into log 

            $cron_name = $this->context->cron_name;
            $template_base = dirname(dirname(__DIR__)) . '/adwords3/templates/' . $cron_name . '/';
            $it = new RecursiveDirectoryIterator($template_base);
            $msg = "";
            $error = false;

            foreach (new RecursiveIteratorIterator($it) as $file) 
            {
                if (exif_imagetype($file) != 3 && !is_dir($file))   // exif_imagetype return 3 if image type is png
                {  
                    $msg .= $file . " is not a valid file. <br>";
                    $error = true;
                }
            }

            if ($error)
            {
                return new Log('Invalid Template File', $msg, DEBUG_LOG_ERROR);
            }
            else
            {
                return new Log('Invalid Template File', $msg, DEBUG_LOG_SUCCESS);
            }
        }
    }
