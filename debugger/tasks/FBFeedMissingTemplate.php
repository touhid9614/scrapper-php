<?php

    class FBFeedMissingTemplate extends DebuggingTask 
    {

        function Execute() 
        {
            //1. Need to pull all vehicles
            //2. Itegrate over each vehicles
            //3. Create a directory list to check
            //4. Check the style is being used and the file that is required for that template
            //5. Create a report (A line of text with all the useful information to debug the issue)
            //6. Return a Log with the report

            $cron_name = $this->context->cron_name;
            $msg = "";
            $error = false;

            $expected_files = 
            [
                '168x315.png',
                '356x630.png',
                '382x98.png',
                '336x630.png',
                '1200x315.png'
            ];

            $query = DbConnect::get_instance()->query("SELECT stock_type, certified, year, make, model, trim FROM {$cron_name}_scrapped_data WHERE deleted='0'");
            $car_data = [];

            while ($car = mysqli_fetch_assoc($query)) 
            {
                $car_data[] = $car;
            }

            if (count($car_data)) 
            {
                foreach ($car_data as $car) 
                {

                    $feed_type = 'retargeting';
                    $type = $car['stock_type'] . $feed_type;
                    $certified_dir = dirname(dirname(__DIR__)) . '/adwords3/templates/' . $cron_name . '/' . 'certified-' . $type . '/';
                    
                    if ($car['certified'] && is_dir($certified_dir)) 
                    {
                        $type = 'certified-' . $type;
                    }

                    $template_base = dirname(dirname(__DIR__)) . '/adwords3/templates/' . $cron_name . '/';
                    $template_dir = $template_base . $type . '/';
                    $lyear = strtolower($car['year']);
                    $lmake = strtolower($car['make']);
                    $lmodel = strtolower($car['model']);
                    $ltrim = strtolower($car['trim']);

                    $template_dirs = 
                    [
                        $template_dir . "{$lyear}_{$lmake}_{$lmodel}/",
                        $template_dir . "{$lmake}_{$lmodel}/",
                        $template_dir . "{$lyear}_{$lmake}/",
                        $template_dir . "{$lmake}/",
                        $template_dir . "{$lyear}/",
                        $template_dir,
                        $template_base . "all/{$lyear}_{$lmake}_{$lmodel}/",
                        $template_base . "all/{$lmake}_{$lmodel}/",
                        $template_base . "all/{$lyear}_{$lmake}/",
                        $template_base . "all/{$lmake}/",
                        $template_base . "all/{$lyear}/",
                        $template_base
                    ];

                    if ($ltrim) 
                    {
                        array_unshift($template_dirs, $template_dir . "{$lyear}_{$lmake}_{$lmodel}_{$ltrim}/");
                    }

                    foreach ($template_dirs as $dir) 
                    {
                        foreach ($expected_files as $file) 
                        {
                            $filename = $dir . $file;
                            if (file_exists($filename)) 
                            {
                                $msg .= $filename . '<br>';
                            } 
                            else 
                            {
                                $msg .= "Could not find $filename" . '<br>';
                                $error = true;
                            }
                        }
                    }
                }
            }

            if ($error)
            {
                return new Log('FB Feed Template', $msg, DEBUG_LOG_ERROR);
            }
            else
            {
                return new Log('FB Feed Template', $msg, DEBUG_LOG_SUCCESS);
            }
        }
    }
