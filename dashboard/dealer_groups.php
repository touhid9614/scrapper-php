<?php

	error_reporting(E_ERROR | E_PARSE);

    require_once 'config.php';
    require_once 'includes/loader.php';
    session_start();

    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'db_connect.php';

    global $user;

    include 'bolts/header.php';
?>

<div class="inner-wrapper">

<?php
    $select = 'dealer_groups';
    include 'bolts/sidebar.php';
?>
    <section role="main" class="content-body">
        <header class="page-header">
			<h2> Dealership Groups </h2>
		</header>
		
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <section class="panel">
                    <div class="panel-body">
                        
                    </div>
                </section>
            </div>
        </div>
	</section>
</div>

<?php
    include 'bolts/footer.php';