<?php
    require_once 'config.php';
    require_once 'includes/loader.php';
    
    session_start();
    
    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'utils.php';
    
    global $CronConfigs, $scrapper_configs, $user;
    
    $tag_state_dir = dirname(ABSPATH) . '/tag-state/';

    if (!file_exists($tag_state_dir)) 
    {
        if (!mkdir($tag_state_dir)) 
        {
            echo "\n//Unable to create tag state directory\n";
        }
    }
    
    include 'bolts/header.php'
?>

<div class="inner-wrapper">
    
    <?php 
        $select = 'crm-inactive';  
        include 'bolts/sidebar.php' 
    ?>
    
    <section role="main" class="content-body">
        <header class="page-header"></header>
        <div class="row">
            <div class="col-lg-12">
                
            </div>
        </div>
    </section>
</div>

<?php include 'bolts/footer.php';