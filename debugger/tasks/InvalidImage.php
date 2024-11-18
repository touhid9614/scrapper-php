<?php

    class InvalidImage extends DebuggingTask 
    {

        function Execute() 
        {
            //1. Go into car table
            //2. Check every available car has image or not
            //3. Randomly check 3 car image valid or not
            //4. If car image not valid then return log 

            $cron_name = $this->context->cron_name;
            $query = DbConnect::get_instance()->query("SELECT all_images, url FROM {$cron_name}_scrapped_data WHERE deleted='0'");
            $car_data = [];
            $max_nocar = mysqli_num_rows($query);
            $msg = "";
            $error = false;

            while ($car = mysqli_fetch_assoc($query)) 
            {
                $car_data[] = $car;
            }

            //Generate three random car from these list of car
            $divide_by_three = intval($max_nocar / 3);
            $car1 = rand(0, $divide_by_three);
            $car2 = rand($divide_by_three, ($divide_by_three + $divide_by_three));
            $car3 = rand(($divide_by_three + $divide_by_three), ($max_nocar - 1));


            foreach ($car_data as $car) 
            {
                if (!filter_var(explode('|', $car['all_images'])[0], FILTER_VALIDATE_URL)) 
                {
                    echo $car['url'] . " Car don't have valid image.";
                }
            }
            
            // These three are generating errors
            // Notice: Undefined offset: 0 in C:\xampp\htdocs\smedia-inventory\debugger\tasks\InvalidImage.php on line 41,42,43
            $selectedCars[] = $car_data[$car1];
            $selectedCars[] = $car_data[$car2];
            $selectedCars[] = $car_data[$car3];

            foreach ($selectedCars as $car) 
            {
                $first_image = explode('|', $car['all_images'])[0];

                if (filter_var($first_image, FILTER_VALIDATE_URL)) 
                {          
                    if(!HttpGetImage($first_image)) 
                    {
                        $msg .= "Car:" . $car['url'] . " Image url " . $first_image . " is not valid <br/>";
                        $error = true;
                    }
                } 
                else 
                {
                    $msg .= "Car:" . $car['url'] . " Image url " . $first_image . " is not valid <br/>";
                    $error = true;
                }
            }

            if ($error)
            {
                return new Log('Invalid Image', $msg, DEBUG_LOG_ERROR);
            }
            else
            {
                return new Log('Invalid Image', "No invalid image found", DEBUG_LOG_SUCCESS);
            }
        }
    }
