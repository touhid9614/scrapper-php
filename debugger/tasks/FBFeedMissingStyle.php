<?php
    
    class FBFeedMissingStyle extends DebuggingTask 
    {
        /*public function __construct()
        {
            global $CronConfigs, $scrapper_configs, $BannerConfigs;
        }*/

        /**
         * { Logs whether fb feed missing or not. }
         *
         * 1. Check if fb style is mentioned.
         * 2. If not mentioned facebook_new_ad is the default style.
         * 3. Check the banner style to make sure it has following definations ([600x315 | custom | custom1200] && [mobile | custom-mobile | custom-mobile1200] && 1080x1080).
         * 4. If any is missing return a warning.
         * 5. If all is missing return an error.
         * 
         * @return      Log
         */
        function Execute()
        {
            global $CronConfigs, $scrapper_configs, $BannerConfigs;

            $cron           = $this->context->cron_name;
            $cron_config    = $CronConfigs[$cron];

            $msg1 = $this->stylechecker('new');
            $msg2 = $this->stylechecker('used');
            
            if (!$msg1 && !$msg2)
            {
                $msg = "Style found for new and used vehicles and currently set to fb_new_rightsidebar";
                return new Log("FB Feed Style", $msg, DEBUG_LOG_SUCCESS);
            }
            else if (!$msg1 && $msg2 == 1)
            {
                $msg = "Style found for new vehicles but missing for some preowned vehicles and currently set to fb_new_rightsidebar";
                return new Log("FB Feed Style", $msg, DEBUG_LOG_WARNING);
            }
            else if (!$msg1 && $msg2 == 2)
            {
                $msg = "Style found for new vehicles but missing for preowned vehicles and currently set to fb_new_rightsidebar";
                return new Log("FB Feed Style", $msg, DEBUG_LOG_ERROR);
            }
            else if ($msg1 == 1 && !$msg2)
            {
                $msg = "Style found for preowned vehicles but missing for new vehicles and currently set to fb_new_rightsidebar";
                return new Log("FB Feed Style", $msg, DEBUG_LOG_WARNING);
            }
            else if ($msg1 == 1 && $msg2 == 1)
            {
                $msg = "Style found for some new vehicles and missing for preowned vehicles and currently set to fb_new_rightsidebar";
                return new Log("FB Feed Style", $msg, DEBUG_LOG_WARNING);
            }
            else if ($msg1 == 1 && $msg2 == 2)
            {
                $msg = "Style found for some new vehicles but missing for preowned vehicles and currently set to fb_new_rightsidebar";
                return new Log("FB Feed Style", $msg, DEBUG_LOG_ERROR);
            }
            else if ($msg1 == 2 && !$msg2)
            {
                $msg = "Style missing for new vehicles but found for preowned vehicles and currently set to fb_new_rightsidebar";
                return new Log("FB Feed Style", $msg, DEBUG_LOG_ERROR);
            }
            else if ($msg1 == 2 && $msg2 == 1)
            {
                $msg = "Style missing for new vehicles and missing for some preowned vehicles and currently set to fb_new_rightsidebar";
                return new Log("FB Feed Style", $msg, DEBUG_LOG_ERROR);
            }
            else
            {
                $msg = "Style missing for both new and preowned vehicles and currently set to fb_new_rightsidebar";
                return new Log("FB Feed Style", $msg, DEBUG_LOG_ERROR);
            }
        }


        /**
         * { Checks whether style is missing. }
         *
         * @param       string          $stock_type     The stock type
         *
         * @return      integer                         '0' if success, '1' if warning and '2' is error
         */
        function stylechecker($stock_type)
        {
            global $CronConfigs, $scrapper_configs, $BannerConfigs, $cron_config, $plain;

            $style = isset($cron_config['banner']['fb_style_' . $stock_type]) ? $cron_config['banner']['fb_style_' . $stock_type] : (isset($cron_config['banner']['fb_style']) ? $cron_config['banner']['fb_style'] : ($plain ? 'plainfbad' : 'facebook_new_ad'));

            $desktopStyleMissing = !$BannerConfigs[$style]['600x315'] && !$BannerConfigs[$style]['custom'] && !$BannerConfigs[$style]['custom'];
            $mobileStyleMissing = !$BannerConfigs[$style]['mobile'] && !$BannerConfigs[$style]['custom-mobile'] && !$BannerConfigs[$style]['custom-mobile1200'];
            $instagramStyleMissing = !$BannerConfigs[$style]['1080x1080'];

            if($desktopStyleMissing || $mobileStyleMissing || $instagramStyleMissing)
            {
                if ($desktopStyleMissing && $mobileStyleMissing && $instagramStyleMissing)
                {
                    return 2;
                    //return "Error: Style not found for " . $stock_type . " vehicles of " . $this->context->cron_name;
                }

                return 1;
                //return "Warning: Style not found for some " . $stock_type . " vehicles of " . $this->context->cron_name;
            }

            return 0;
            //return "Success: Style found for " . $stock_type . " vehicles of " . $this->context->cron_name;
        }
    }
