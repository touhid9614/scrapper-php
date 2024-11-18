<?php
    require_once 'config.php';
    require_once 'includes/loader.php';
    require_once 'includes/crm-defaults.php';

    session_start();

    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'db_connect.php';


    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $domain_name = trim(filter_input(INPUT_POST, 'domain_name'));
        $dealer_name = strtolower(trim(filter_input(INPUT_POST, 'dealer_name')));
        DbConnect::get_instance()->update_meta('dealer_domain', GetDomain($domain_name), $dealer_name);

        /*
         * Log added start
         */
        DbConnect::store_log($user_id, $user['type'], 'Add Custom Dealership', 'Add custom Dealership where domain name- ' . $domain_name . ' and dealer name- ' . $dealer_name, $dealer_name );
        /*
         * Log added end
         */
    }

    include 'bolts/header.php';
?>


<div class="inner-wrapper">

    <?php
        $select = 'custom-dealer';
        include 'bolts/sidebar.php'
    ?>

    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="panel-title"> Register Custom Dealer </h2>
        </header>

        <div class="panel-body">
            <div class="row">
                <div class="col-lg-10 col-md-12">
                    <form method="POST" class="form-horizontal form-bordered">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Domain Name </label>
                                    <div class="col-sm-9">
                                        <input name="domain_name" class="form-control" type="text" value="" placeholder="www.example.com" data-current_value='' required=""/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Dealership Name </label>
                                    <div class="col-sm-9">                                      
                                        <input name="dealer_name" class="form-control" type="text" value="" placeholder="example" data-current_value='' required=""/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button name="btn" value="custom-dealer" class="btn btn-primary pull-right"> Submit </button>
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