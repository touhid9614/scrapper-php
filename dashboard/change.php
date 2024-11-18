<?php
    require_once 'config.php';
    require_once 'includes/loader.php';
    
    global $user;
?>
<?php include 'bolts/header.php' ?>

<div class="inner-wrapper">
    
    <?php $select = 'Change Budget'; include 'bolts/sidebar.php' ?>
    
    <script> var change_budget = true; </script>
    
    <section role="main" class="content-body">
        <header class="page-header">
            
        </header>
        <?php if($user['type'] == 'a') {?>
        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                        </div>
                        <h2 class="panel-title">Budget Settings</h2>
                        <p class="panel-subtitle">With budget distribution</p>
                    </header>

                    <div class="panel-body">
                        <form method="post" action="change-budget.php">
                            <input name="cron_name" type="hidden" value="<?php echo $user['cron_name'] ?>"/>
                            <table id="cost-distrib-table">
                                <tbody>
                                <tr>
                                    <td>Maximum Cost: </td>
                                    <td><input name="max_cost" value="<?php echo $user['cron_config']['max_cost']?>" type="text"/></td>
                                </tr>
                                <?php if(isset($user['cron_config']['cost_distribution'])){ foreach($user['cron_config']['cost_distribution'] as $name => $value){?>
                                <tr>
                                    <td><?php echo ucfirst($name) ?>: </td>
                                    <td><input name="cost_distribution[<?php echo $name ?>]" value="<?php echo $value?>" type="text"/></td>
                                </tr>
                                <?php }}?>
                                </tbody>
                            </table>
                            <input type="submit" value="Update">
                        </form>
                    </div>
                </section>
            </div>
        </div>
        <?php }?>
    </section>
</div>

<?php include 'bolts/footer.php' ?>