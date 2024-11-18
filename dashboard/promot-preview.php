<?php
    require_once 'config.php';
    require_once 'includes/loader.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'db_connect.php';
    
    global $CronConfigs;
?>
<?php include 'bolts/header.php' ?>

<div class="inner-wrapper">
    
    <?php $select = 'Promotion Checklist'; include 'bolts/sidebar.php' ?>
    
    <section role="main" class="content-body">
        <header class="page-header">
            
        </header>
        <div id="table_container" class="row">
            
            <table id="promot-checklist">
                <tr>
                    <th>Client</th>
                    <th>New Display</th>
                    <th>New Retargeting</th>
                    <th>New Marketbuyers</th>
                    <th>Used Display</th>
                    <th>Used Retargeting</th>
                    <th>Used Marketbuyers</th>
                </tr>
                
                <?php
                    $odd = true;
                    foreach($CronConfigs as $cron_name => $cron_config)
                    {
                        $key = @$cron_config['banner']['template'];
                        
                        $template_path = ADSYNCPATH . 'templates/' . $key . '/';

                        $newdis = $template_path . 'newdisplay/horizontal.png';
                        $newret = $template_path . 'newretargeting/horizontal.png';
                        $newmark = $template_path . 'newmarketbuyers/horizontal.png';
                        $useddis = $template_path . 'useddisplay/horizontal.png';
                        $usedret = $template_path . 'usedretargeting/horizontal.png';
                        $usedmark = $template_path . 'usedmarketbuyers/horizontal.png';

                        $newdisc = $template_path . 'newdisplay/468x60.png';
                        $newretc = $template_path . 'newretargeting/468x60.png';
                        $newmarkc = $template_path . 'newmarketbuyers/468x60.png';
                        $useddisc = $template_path . 'useddisplay/468x60.png';
                        $usedretc = $template_path . 'usedretargeting/468x60.png';
                        $usedmarkc = $template_path . 'usedmarketbuyers/468x60.png';
                        
                ?>
                <tr class="<?php echo $odd?'':'even' ?>">
                    <td><?php echo $cron_name ?></td>
                    <td><?php if(file_exists($newdis)){ ?>
                        <img src="../adwords3/templates/<?php echo $key ?>/newdisplay/horizontal.png"/>
                        <?php } else{ echo "Missing Quick Banner"; } ?>
                        <?php if(file_exists($newdisc)){ ?>
                        <img src="../adwords3/templates/<?php echo $key ?>/newdisplay/468x60.png"/>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if(file_exists($newret)){ ?>
                        <img src="../adwords3/templates/<?php echo $key ?>/newretargeting/horizontal.png"/>
                        <?php } else{ echo "Missing Quick Banner"; } ?>
                        <?php if(file_exists($newretc)){ ?>
                        <img src="../adwords3/templates/<?php echo $key ?>/newretargeting/468x60.png"/>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if(file_exists($newmark)){ ?>
                        <img src="../adwords3/templates/<?php echo $key ?>/newmarketbuyers/horizontal.png"/>
                        <?php } else{ echo "Missing Quick Banner"; } ?>
                        <?php if(file_exists($newmarkc)){ ?>
                        <img src="../adwords3/templates/<?php echo $key ?>/newmarketbuyers/468x60.png"/>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if(file_exists($useddis)){ ?>
                        <img src="../adwords3/templates/<?php echo $key ?>/useddisplay/horizontal.png"/>
                        <?php } else{ echo "Missing Quick Banner"; } ?>
                        <?php if(file_exists($useddisc)){ ?>
                        <img src="../adwords3/templates/<?php echo $key ?>/useddisplay/468x60.png"/>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if(file_exists($usedret)){ ?>
                        <img src="../adwords3/templates/<?php echo $key ?>/usedretargeting/horizontal.png"/>
                        <?php } else{ echo "Missing Quick Banner"; } ?>
                        <?php if(file_exists($usedretc)){ ?>
                        <img src="../adwords3/templates/<?php echo $key ?>/usedretargeting/468x60.png"/>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if(file_exists($usedmark)){ ?>
                        <img src="../adwords3/templates/<?php echo $key ?>/usedmarketbuyers/horizontal.png"/>
                        <?php } else{ echo "Missing Quick Banner"; } ?>
                        <?php if(file_exists($usedmarkc)){ ?>
                        <img src="../adwords3/templates/<?php echo $key ?>/usedmarketbuyers/468x60.png"/>
                        <?php } ?>
                    </td>
                </tr>
                <?php $odd = !$odd; }?>
            </table>
            
        </div>
    </section>
</div>

<?php include 'bolts/footer.php' ?>