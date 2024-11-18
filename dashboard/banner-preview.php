<?php
    require_once 'config.php';
    require_once 'includes/loader.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'db_connect.php';
    require_once 'includes/banner-preview.php';
    
    global $CronConfigs;
?>
<?php include 'bolts/header.php' ?>

<div class="inner-wrapper">
    
    <?php $select = 'Banner Checklist'; include 'bolts/sidebar.php' ?>
    
    <section role="main" class="content-body">
        <header class="page-header">
            
        </header>
        <div id="table_container" class="row">
            
            <table id="promot-checklist">
                <tr>
                    <th>Client</th>
                    <th>New</th>
                    <th>Used</th>
                </tr>
                
                <?php
                    $odd = true;
                    foreach($CronConfigs as $cron_name => $cron_config)
                    {
                        $key = @$cron_config['banner']['template'];
                        
                        $tabs = array();
                        $good_new_car = null;
                        $good_used_car = null;
                        
                        resolve_cars($cron_name, $cron_config, $tabs, $good_new_car, $good_used_car);
                        
                        $template_path = ADSYNCPATH . 'templates/' . $key . '/';
                        
                        $new320x50 = $template_path . 'newdisplay/320x50.png';
                        $used320x50 = $template_path . 'useddisplay/320x50.png';
                        $new468x60 = $template_path . 'newdisplay/468x60.png';
                        $used468x60 = $template_path . 'useddisplay/468x60.png';
                        
                        $new_config = '320x50';
                        $used_config = '320x50';
                        
                        $new_directive = 'display';
                        $used_directive = 'display';
                        
                        if(@$cron_config['banner']['styels']['new_' . $new_directive] == 'custom_banner' && !file_exists($new320x50))
                        {
                            if(file_exists($new468x60))
                            {
                                $new_config = '468x60';
                            }
                            else
                            {
                                $new_config = null;
                            }
                        }
                        if(@$cron_config['banner']['styels']['used_' . $used_directive] == 'custom_banner' && !file_exists($used320x50))
                        {
                            if(file_exists($used468x60))
                            {
                                $used_config = '468x60';
                            }
                            else
                            {
                                $used_config = null;
                            }
                        }
                        
                        if($good_new_car)
                        {
                            $new_image_url = get_banner_url($good_new_car, $new_config, $key, $cron_config, $new_directive);
                        }
                        else
                        {
                            $new_image_url = null;
                        }
                        
                        if($good_used_car)
                        {
                            $used_image_url = get_banner_url($good_used_car, $used_config, $key, $cron_config, $used_directive);
                        }
                        else
                        {
                            $used_image_url = null;
                        }
                        
                        if(!$new_config) $new_image_url = null;
                        if(!$used_config) $used_image_url = null;
                ?>
                <tr class="<?php echo $odd?'':'even' ?>">
                    <td><?php echo $cron_name ?></td>
                    <td><?php if($new_image_url){ ?>
                        <img src="<?php echo $new_image_url ?>" style="width: 320px; height: 50px;"/>
                        <?php }?>
                    </td>
                    <td><?php if($used_image_url){ ?>
                        <img src="<?php echo $used_image_url ?>" style="width: 320px; height: 50px;"/>
                        <?php }?>
                    </td>
                </tr>
                <?php $odd = !$odd; }?>
            </table>
            
        </div>
    </section>
</div>

<?php include 'bolts/footer.php' ?>