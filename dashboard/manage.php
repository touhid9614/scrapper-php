<?php

    require_once 'config.php';
    require_once 'includes/loader.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'Google/Adwords.php';
    require_once ADSYNCPATH . 'Google/TokenHelper.php';
    require_once ADSYNCPATH . 'db_connect.php';
    
    global $user, $connection, $dealerships;
    
    if($user['type'] != 'a' && 
      !($user['role'] == scrubber    ||
        $user['role'] == closer      ||
        $user['role'] == adwords     ||
        $user['role'] == designer))
    {
        die('You are not allowed to login to management section');
    }
    
    $db_connect = new DbConnect('');
    
    $sortby = isset($_GET['sortby'])?$_GET['sortby']:'id';
    if($sortby != 'id' && $sortby != 'status')
    {
        $sortby = 'id';
    }
    
    $sortmode = isset($_GET['sortmode'])?$_GET['sortmode']:'d';
    if($sortmode != 'a' && $sortmode != 'd')
    {
        $sortmode = 'd';
    }
    
    if($sortmode == 'a')
    {
        $sortmode = 'asc';
    }
    elseif($sortmode == 'd')
    {
        $sortmode = 'desc';
    }
    
    $dealerships = $db_connect->get_dealerships($user['role'], $sortby, $sortmode);
    
    $db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);
    
    function print_header($field)
    {
        global $sortby, $sortmode;
        
        $name = ucfirst($field);
        
        if ($sortby == $field)
        {
            if ($sortmode == 'asc')
            {
                echo "<a href=\"?sortby=$field&sortmode=d\" style=\"color:#fff;\" title=\"Sort by $name\"><i class=\"fa fa-sort-desc\"></i> $name</a>";
            }
            elseif ($sortmode == 'desc')
            {
                echo "<a href=\"?sortby=$field&sortmode=a\" style=\"color:#fff;\" title=\"Sort by $name\"><i class=\"fa fa-sort-asc\"></i> $name</a>";
            }
        }
        else
        {
            echo "<a href=\"?sortby=$field&sortmode=d\" style=\"color:#fff;\" title=\"Sort by $name\"><i class=\"fa fa-sort\"></i> $name</a>";
        }
    }
    
    include 'bolts/header.php'
?>

<div class="inner-wrapper">
    
    <?php $select = 'Manage'; include 'bolts/sidebar.php' ?>
    
    <script> var manage = true; </script>
    
    <section role="main" class="content-body">
        <header class="page-header">
            
        </header>
        <!-- start: page -->
        <div class="row">

        <?php

         switch ($user['role'])
         {
             case scrubber:
                 include 'bolts/scrubber.php';
                 break;
             case closer:
                 include 'bolts/closer.php';
                 break;
             case adwords:
                 include 'bolts/adwords.php';
                 break;
             case designer:
                 include 'bolts/designer.php';
                 break;
         }

        ?>
            
	</div>
    </section>
</div>

<?php include 'bolts/footer.php' ?>