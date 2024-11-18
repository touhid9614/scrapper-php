<?php
    require_once 'config.php';
    require_once 'includes/loader.php';
    
    $pages = 
    [
        'control'       => 'https://tm.smedia.ca/adwords3/control.php',
        'sold-ad-cleaner'    => 'https://tm.smedia.ca/adwords3/sold-ad-cleaner.php',
        'clear'         => 'https://tm.smedia.ca/dashboard/clear.php',
        'budgetchecker' => 'https://tm.smedia.ca/budgetchecker/',
        'carlisteditor' => 'https://tm.smedia.ca/adwords3/carlist-editor.php',
        'tagchecker'    => 'https://tm.smedia.ca/adwords3/tag-checker.php',
		'reports'       => 'https://tm.smedia.ca/dashboard/reports.php'
    ];
    
    $select = isset($_GET['page']) ? $_GET['page'] : '';
    
    if (!isset($pages[$select]))
    { 
        $select = 'budgetchecker';
    }
    
    $url = $pages[$select];

    include 'bolts/header.php'
?>

<div class="inner-wrapper">
<?php include 'bolts/sidebar.php' ?>
    
<?php 
    if ($select == 'control' || $select == 'tagchecker') 
    {
?>
    <script> var auto_adjust = true; </script>
<?php 
    }
?>
    
    <section role="main" class="content-body">
        <header class="page-header">
            
        </header>
        <div id="frame-holder" class="row">
            <iframe id="page-frame" src="<?= $url;?>"></iframe> 
        </div>
    </section>
</div>

<?php include 'bolts/footer.php' ?>
