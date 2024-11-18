<?php
require_once 'config.php';
require_once 'includes/loader.php';
//require_once 'includes/crm-defaults.php';

# ini_set('display_errors', 1);
# ini_set('display_startup_errors', 1);
# error_reporting(E_ALL);

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once 'configuration-manager/smart-offer-template.php';
require_once 'configuration-manager/config-processor.php';

global $config_templates, $user;

$cron_name = $user['cron_name'];

$cron_config = isset($CronConfigs[$cron_name])?$CronConfigs[$cron_name]:null;

if(!$cron_config) { die("Error: Unable to find configuration for $cron_name"); }

include 'bolts/header.php'
?>

<div class="inner-wrapper">

    <?php
    $select = 'config-ai-buttons';
    include 'bolts/sidebar.php'
    ?>

    <section role="main" class="content-body">
        <header class="page-header">

        </header>
        <div class="row">
            <div class="col-lg-12">
                <section class="panel panel-info">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title">AI Button Configuration :: <?= $cron_name ?></h2>
                    </header>
                    
                    <div id="config-manager" class="panel-body">
                        
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>
<?php
include 'bolts/footer.php';
?>
<script>
    (function($) {
        smedia_prepare_configuration($);
        sMedia.Configuration.init('#config-manager', <?= json_encode($config_template) ?>, <?= json_encode(array_remake($data)) ?>);
        /*
        sMedia.Configuration.rendered(function(){
            alert('Hello, render completed');
        });
        */
        sMedia.Configuration.render();
        //var control = new sMedia.Configuration.Types.string('banner[template]', {name : 'Template Directory'}, 'barbermotors');
        //alert(control.render());
    })(jQuery);
</script>