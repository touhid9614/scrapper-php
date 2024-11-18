<?php

    define('lead_trackers', 'lead_trackers');
    
    $tmodes = array(
        'none'      => 'None',
        'onload'    => 'On Page Load',
        'ajax'      => 'Ajax'
    );
    
    global $argv;
    $argv['2'] = true;
    require_once 'config.php';
    require_once 'includes/loader.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'db_connect.php';
    
    function logme($data){unset($data);}
    
    global $user, $connection;
    
    $cron_name = $user['cron_name'];
    
    $db_connect = new DbConnect($cron_name);
    
    $db_connect->create_meta_table(lead_trackers);
    
    $lead_tracker = $db_connect->get_meta(lead_trackers, $cron_name);
    
    if(!$lead_tracker)
    {
        $lead_tracker = array();
    }
    
    $tracking_mode  = isset($lead_tracker['tmode'])?$lead_tracker['tmode']:'none';
    $url            = isset($lead_tracker['url'])?$lead_tracker['url']:'';
    $params         = isset($lead_tracker['params'])?$lead_tracker['params']:'';
    $resp           = isset($lead_tracker['resp'])?$lead_tracker['resp']:'';
    $tcode          = isset($lead_tracker['tcode'])?$lead_tracker['tcode']:'';
    
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tmode']))
    {
        $tracking_mode  = isset($_POST['tmode'])?$_POST['tmode']:'none';
        $url            = isset($_POST['url'])?$_POST['url']:'';
        $params         = isset($_POST['params'])?$_POST['params']:'';
        $resp           = isset($_POST['resp'])?$_POST['resp']:'';
        $tcode          = isset($_POST['tcode'])?$_POST['tcode']:'';
        
        $lead_tracker   = array(
            'tmode'     => $tracking_mode,
            'url'       => $url,
            'params'    => $params,
            'resp'      => $resp,
            'tcode'     => $tcode
        );
        
        $db_connect->update_meta(lead_trackers, $cron_name, $lead_tracker);
    }
?>
<?php include 'bolts/header.php' ?>
<div class="inner-wrapper">
    
    <?php $select = 'Lead Tracking'; include 'bolts/sidebar.php' ?>
    
     <section role="main" class="content-body">
        <header class="page-header">
            
        </header>
        <!-- start: website tag -->
        <div class="row">
            <div class="col-md-12">
                <form id="custom-lead-editor" class="form-horizontal" method="post">
                    <input name="dealership" value="<?php echo $cron_name ?>" type="hidden"/>
                    <section class="panel">
                        <header class="panel-heading">
                            <h2 class="panel-title">Track Custom Leads</h2>
                            <p class="panel-subtitle">Place configure how you want to track custom leads</p>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Tracking Mode: </label>
                                <div class="col-sm-6">
                                    <select name="tmode" class="form-control">
                                        <?php foreach ($tmodes as $k => $v): ?><option value="<?php echo $k ?>"<?php if($tracking_mode == $k) { echo ' selected'; } ?>><?php echo $v ?></option><?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Target URL: </label>
                                <div class="col-sm-6">
                                    <input name="url" type="text" class="form-control" value="<?php echo $url ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Parameters: </label>
                                <div class="col-sm-6">
                                    <input name="params" type="text" class="form-control" value="<?php echo $params ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Response Regex: </label>
                                <div class="col-sm-6">
                                    <input name="resp" type="text" class="form-control" value="<?php echo $resp ?>" placeholder="(Only for Ajax)"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Tracking Code: </label>
                                <div class="col-sm-6">
                                    <textarea name="tcode" rows="2" class="form-control"><?php echo $tcode ?></textarea>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer clearfix">
                            <div class="col-sm-10">
                                <button class="btn btn-primary pull-right">Update Tracking</button>
                            </div>
                        </footer>
                    </section>
                </form>
            </div>
	</div>
    </section>
</div>

<?php include 'bolts/footer.php' ?>
<?php $db_connect->close_connection();