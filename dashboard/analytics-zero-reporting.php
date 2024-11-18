<?php
    
    require_once 'config.php';
    require_once 'includes/loader.php';
    require_once 'includes/crm-defaults.php';

    session_start();

    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'db_connect.php';
    
    include 'bolts/header.php';
   
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'save-analytics-configure')) {
        $zero_analytics_email = trim(filter_input(INPUT_POST, 'zero_analytics_email'));
      //  echo $zero_analytics_email;
       // exit();
        $if_exist_query = DBConnect::get_instance()->query("SELECT * FROM configure_alert WHERE name='zero_analytics_email'");
        if (mysqli_num_rows($if_exist_query)) {
            DbConnect::get_instance()->query("UPDATE configure_alert SET value='$zero_analytics_email' WHERE name='zero_analytics_email'");
        } else {
            DbConnect::get_instance()->query("INSERT INTO configure_alert(name, value) VALUES('zero_analytics_email', '$zero_analytics_email')");
        }
    }

    $data_query = DBConnect::get_instance()->query("SELECT name, value FROM configure_alert WHERE name='zero_analytics_email'");
    if (mysqli_num_rows($data_query)) {
        $zero_analytics_email = mysqli_fetch_assoc($data_query)['value'];
    } else {
        $zero_analytics_email = "";
    }
    
     
?>


<div class="inner-wrapper">
    <?php
        $select = 'analytics-zero-reporting';
        include 'bolts/sidebar.php'
    ?>

    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="panel-title">Add Email To Get Alert of Analytics Zero Reporting</h2>
        </header>

        <div class="panel-body">
            <div class="row">
                <div class="col-lg-10 col-md-12">
                    <form method="POST" class="form-horizontal form-bordered">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Enter Email Seperated by Comma  </label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" cols="15" rows="6" name="zero_analytics_email" required><?= $zero_analytics_email ?></textarea>                                   
                                    </div>
                                </div>                                             
                                <div class="form-group">
                                    <button name="btn" value="save-analytics-configure"  class="btn btn-primary pull-right">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
    include 'bolts/footer.php';
