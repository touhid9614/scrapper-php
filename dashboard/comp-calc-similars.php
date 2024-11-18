<?php
    global $argv;
    $argv['2'] = true;
    require_once 'config.php';
    require_once 'includes/loader.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'db_connect.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once 'includes/search-inventory.php';
    
    function logme($data){}
    
    global $user, $connection, $distances;
    
    $stock_number   = isset($_GET['stock_number'])?$_GET['stock_number']:null;
    $distance       = isset($_GET['distance'])?$_GET['distance']:'25';
    $exact          = isset($_GET['exact'])?$_GET['exact'] == 'true':false;
    $page           = isset($_GET['page'])?intval($_GET['page']):1;
    
    $query_str = "dealership={$user['cron_name']}";
    
    if($stock_number)
    {
        $query_str .= "&stock_number=$stock_number";
    }
    if($exact)
    {
        $query_str .= "&exact=true";
    }
    if($distance)
    {
        $query_str .= "&distance=$distance";
    }
    
    if(!$stock_number)
    {
        header("Location: comp-calc.php?$query_str");
        die();
    }
    
    
    $db_connect = new DbConnect($user['cron_name']);
    $search     = new InventorySearch($db_connect);
    
    $page_count = 0;
    
    $car = $search->get_car_by_stock($stock_number);
    
    if(!$car)
    {
        header("Location: comp-calc.php?$query_str");
        die();
    }
    
    $similars = $search->get_paged_similar_cars($car, $distance, $page, $page_count, 10, $exact);
    
    $price_class = 'green';
    if($car['status']['price_rank'] > round($car['status']['total'] * 0.80) + 1 || numarifyPrice($car['price']) == 0 ) { $price_class = 'red'; }

    $km_class = 'green';
    if($car['status']['km_rank'] > round($car['status']['total'] * 0.80) + 1 || numarifyKm($car['kilometers']) == 0) { $km_class = 'red'; }
?>
<?php include 'bolts/header.php' ?>

<div class="inner-wrapper">
    
    <?php $select = 'Search Inventory'; include 'bolts/sidebar.php' ?>
    
    <section role="main" class="content-body">
        <header class="page-header">
            
        </header>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <section class="panel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>Similar To: <?php echo "{$car['year']} {$car['make']} {$car['model']}"; if($exact){ echo " {$car['trim']}"; } ?></h4>
                                <div class="row search-results">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="title"></th>
                                                <th class="image"></th>
                                                <th><div class="price"></div><span>Price</span></th>
                                                <th><div class="price-rank"></div><span>Price Rank</span></th>
                                                <th><div class="km-rank"></div><span>KM Rank</span></th>
                                            </tr>
                                        </thead>
                                        <tbody id="similar-result-body">
                                            <tr class="<?php echo 'odd'; ?>">
                                                <td class="title">
                                                    <a href="<?php echo $car['url'] ?>" target="_blank">
                                                    <span><?php echo "{$car['year']} {$car['make']} {$car['model']}"; if($exact){ echo " {$car['trim']}"; } ?></span>
                                                    <span><?php echo "#{$car['stock_number']}" ?></span>
                                                    </a>
                                                </td>
                                                <td class="image">
                                                    <?php if($car['img']) : ?>
                                                    <a href="<?php echo $car['url'] ?>" target="_blank">
                                                    <img src="<?php echo $car['img']; ?>" alt=""/>
                                                    </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td><span class="<?php echo $price_class ?>"><?php echo $car['price'] ?></span></td>
                                                <td><span><?php if($car['status']['price_rank'] != 'n/a') : ?><span class="<?php echo $price_class ?>"><?php echo $car['status']['price_rank'] ?></span>/<?php echo $car['status']['total'] + 1 ?><?php else: ?>n/a<?php endif; ?></span></td>
                                                <td><span><?php if($car['status']['km_rank'] != 'n/a') : ?><span class="<?php echo $km_class ?>"><?php echo $car['status']['km_rank'] ?></span>/<?php echo $car['status']['total'] + 1 ?><?php else: ?>n/a<?php endif; ?></span></td>
                                            </tr>
                                            <?php
                                                
                                                $odd = false;
                                                foreach($similars as $stock_number => $similar) :
                                                    $price_class = 'green';
                                                    if($similar['status']['price_rank'] > round($similar['status']['total'] * 0.80) + 1 || numarifyPrice($similar['price']) == 0 ) { $price_class = 'red'; }

                                                    $km_class = 'green';
                                                    if($similar['status']['km_rank'] > round($similar['status']['total'] * 0.80) + 1 || numarifyKm($similar['kilometers']) == 0) { $km_class = 'red'; }
                                            ?>
                                            <tr class="<?php if($odd) echo 'odd'; else echo 'even'; ?>">
                                                <td class="title">
                                                    <a href="<?php echo $similar['url'] ?>" target="_blank">
                                                    <span><?php echo "{$similar['year']} {$similar['make']} {$similar['model']}"; if($exact){ echo " {$similar['trim']}"; } ?></span>
                                                    <span><?php echo "#$stock_number" ?></span>
                                                    </a>
                                                </td>
                                                <td class="image">
                                                    <?php if($similar['img']) : ?>
                                                    <a href="<?php echo $similar['url'] ?>" target="_blank">
                                                    <img src="<?php echo $similar['img']; ?>" alt=""/>
                                                    </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td><span class="<?php echo $price_class ?>"><?php echo $similar['price'] ?></span></td>
                                                <td><span><?php if($similar['status']['price_rank'] != 'n/a') : ?><span class="<?php echo $price_class ?>"><?php echo $similar['status']['price_rank'] ?></span>/<?php echo $similar['status']['total'] + 1 ?><?php else: ?>n/a<?php endif; ?></span></td>
                                                <td><span><?php if($similar['status']['km_rank'] != 'n/a') : ?><span class="<?php echo $km_class ?>"><?php echo $similar['status']['km_rank'] ?></span>/<?php echo $similar['status']['total'] + 1 ?><?php else: ?>n/a<?php endif; ?></span></td>
                                            </tr>
                                            <?php $odd = !$odd; endforeach; ?>
                                        </tbody>
                                    </table>
                                    <div class="animation_image">
                                        
                                    </div>
                                    <?php if(count($similars) == 0): ?>
                                    <div class="no-match">
                                        No Similar Vehicles
                                    </div>
                                    <?php else: ?>
                                    <div class="pagging inpage">
                                        
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="row pagination">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
	</div>
        
    </section>
</div>

<script>
    var current_page    = <?php echo $page ?>;
    var query_str       = "<?php echo $query_str; ?>";
    var page_count      = <?php echo $page_count ?>;
</script>

<?php include 'bolts/footer.php' ?>
<?php $db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);