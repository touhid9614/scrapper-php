<?php

require_once 'config.php';

require_once 'includes/loader.php';

require_once 'includes/crm-defaults.php';


session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

global $user;
$cron_name = filter_input(INPUT_GET, 'dealership');
if(!$cron_name) {
    $cron_name = $user['cron_name'];
}



include 'bolts/header.php'
?>

<div class="inner-wrapper">
    <?php
    $select = 'engaged-user';
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
                        <h2 class="panel-title">Predictor For: Barbermotors</h2>
                    </header>
                    <div class="panel-body">
                        <form method="GET" class="form-inline">
                            <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership">Dealership</label>
                            <select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="dealership" id="dealership" data-plugin-selectTwo>
                               <option value="barbermotors" selected >barbermotors</option>
                                <option value="pantictontoyota" >pantictontoyota</option>
                                 <option value="freefomford"  >freefomford</option>
                                 
                                   
                            </select>
                            <button class="btn btn-primary ml-md"> Submit </button>                             
                        </form>
                    </div>
                </section>
            </div>



            <div class="col-lg-12">
                <section class="panel">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-striped mb-none table-advanced">
                                    <thead>
                                        <tr>
                                          <th>Dealership</th>
                                          <th>URL</th>
                                          <th> Title </th>
                                          <th> Predictor</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                    </tbody>
                                </table>
                                
                                                             
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>

<?php
include 'bolts/footer.php';
?>