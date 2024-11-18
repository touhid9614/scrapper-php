<?php 

    include 'includes/preview.php';
    include 'bolts/header.php';
    global $BannerConfigs, $SWFConfigs, $tabs, $cron_name, $cron_config, $good_car, $is_good, $select;
?>

<div class="inner-wrapper">
    
    <?php $select = 'Ad Preview'; include 'bolts/sidebar.php' ?>
    
    <script> var preview = true; </script>
    
    <section role="main" class="content-body">
        <header class="page-header">
        </header>
        
        <div class="row">
            <?php foreach ($tabs as $tab) { $website_banner_path = '../adwords3/templates/' . $cron_name . '/' . $tab['stock_type'] . $tab['t_directive'] . '/website_banner.png'; ?>
            <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                        </div>
                        <h2 class="panel-title"><?php echo ucwords($tab['stock_type'] . ' ' . $tab['directive']);?></h2>
                    </header>
                    <div class="panel-body">
                        <?php if(file_exists($website_banner_path)){?>
                        <h3>Website Banner</h3>
                        <div>
                            <img src="<?php echo $website_banner_path ?>"/>
                        </div>
                        <?php }?>
                        <h3>Banner Ads</h3>
                        <div class="banner-container-wrapper">
                        <?php
                            $car = $good_car;
                            
                            if($car)
                            {
                                $key        = $tab['stock_type'] . '_' . $tab['t_directive'];
                                $style_name = $cron_config['banner']['styels'][$key];
                                $style      = isset($BannerConfigs[$style_name])? $BannerConfigs[$style_name] : false;
                                
                                $car['stock_type'] = $tab['stock_type'];
                                
                                if($style)
                                {
                                    foreach($style as $config => $value)
                                    {
                                        $url    = getBannerURL($tab['t_directive'], $cron_config, $car, $config, $is_good);
                                        $wh     = explode('x', $config);
                                        $width  = $wh[0];
                                        $height = $wh[1];
                                        
                                        ?>
                        <div class="banner-container" style="width: <?php echo $width?>px;">
                            <h5><?php echo $config ?></h5>
                            <img src="<?php echo $url ?>" style="width: <?php echo $width?>px; height: <?php echo $height?>px"/>
                        </div>
                        <?php
                                    }
                                }
                                else
                                {
                                    echo 'no style named ' . $style_name;
                                }
                            }
                            else
                            {
                                echo 'no appropriate car for generating advertisement';
                            }
                        ?>
                    </div>
                    <?php if(/*isset($cron_config["banner"]["flash_style"]) && $car*/false){?>
                    <h3>Flash Ads</h3>
                    <div class="flash-container-wrapper">
                        <?php
                        if($car)
                        {
                            $style_name = $cron_config['banner']['flash_style'];
                            $style = isset($SWFConfigs[$style_name])? $SWFConfigs[$style_name] : false;
                            
                            if($style)
                            {
                                foreach($style as $config => $value)
                                {
                                    $url = getSwfURL($tab['t_directive'], $cron_config, $car, $config);
                                    
                                    $wh = explode('x', $config);
                                    
                                    $width = $wh[0];
                                    $height = $wh[1];
                                    
                                    if(!$url || $url == "") continue;
                                    ?>
                    <div class="flash-container" style="width: <?php echo $width?>px;">
                        <h5><?php echo $config ?></h5>
                        
                        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="<?php echo $width?>" height="<?php echo $height?>" id="<?php echo $config?>">
                        <param name="movie" value="<?php echo $url ?>"/>
                        <param name="quality" value="high"/>
                        <param name="bgcolor" value="#ffffff"/>
                        <embed src="<?php echo $url ?>" quality="high" bgcolor="#ffffff" width="<?php echo $width?>" height="<?php echo $height?>" type="application/x-shockwave-flash" pluginpage="http://www.macromedia.com/go/getflashplayer"></embed>
                        </object>
                        
                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                    <?php }?>
                    </div>
                </section>
            </div>
            <?php }?>
        </div>
    </section>
</div>

<?php include 'bolts/footer.php' ?>