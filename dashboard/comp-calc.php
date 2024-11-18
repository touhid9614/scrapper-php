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
    
    global $user, $connection, $distances, $order_by_fields, $order_dir_fields;
    
    $year       = isset($_GET['year'])?$_GET['year']:null;
    $make       = isset($_GET['make'])?$_GET['make']:null;
    $model      = isset($_GET['model'])?$_GET['model']:null;
    $distance   = isset($_GET['distance'])?$_GET['distance']:'25';
    $exact      = isset($_GET['exact'])?$_GET['exact'] == 'true':false;
    $changed    = isset($_GET['changed'])?$_GET['changed']:null;
    $page       = isset($_GET['page'])?intval($_GET['page']):1;
    $order_by   = filter_input(INPUT_GET, 'orderby');
    $order_dir  = filter_input(INPUT_GET, 'orderdir');
    
    if(!isset($order_by_fields[$order_by]))
    {
        $order_by = '';
    }
        
    $db_connect = new DbConnect($user['cron_name']);
    $search     = new InventorySearch($db_connect);
    
    $years  = $search->get_years();
    $makes  = $search->get_makes();
    $models = $search->get_models($make);
    
    if($changed == 'make')
    {
        $model = null;
    }
    
    $page_count = 0;
    
    $cars = $search->get_cars($year, $make, $model, $order_by, $order_dir, $page, $page_count);
    
    $query_str = "dealership={$user['cron_name']}";
    
    if($year)
    {
        $query_str .= "&year=$year";
    }
    if($make)
    {
        $query_str .= "&make=$make";
    }
    if($model)
    {
        $query_str .= "&model=$model";
    }
    if($order_by)
    {
        $query_str .= "&orderby=$order_by";
    }
    if($order_dir)
    {
        $query_str .= "&orderdir=$order_dir";
    }
    if($distance)
    {
        $query_str .= "&distance=$distance";
    }
    if($exact)
    {
        $query_str .= "&exact=true";
    }
    if($changed)
    {
        $query_str .= "&changed=$changed";
    }
    
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
                                <h4>Search Inventory (<?php if($exact) { echo "Exact Match"; } else { echo "Broad Match"; } ?>)</h4>
                                <div class="row filters">
                                    <form id="filter-form" method="get">
                                        <input type="hidden" name="dealership" value="<?php echo $user['cron_name'] ?>"/>
                                        <input type="hidden" name="exact" value="<?php echo $exact?'true':'false' ?>"/>
                                        <input type="hidden" name="changed" value=""/>
                                        <div class="filter-single col-lg-2">
                                            <label>
                                                <select name="year" class="filter-select">
                                                    <option value="" selected>Year</option>
                                                    <?php foreach($years as $k => $v) :?>
                                                    <option value="<?php echo $k ?>"<?php if($k == $year) echo ' selected'; ?>><?php echo $v ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </label>
                                        </div>
                                        <div class="filter-single col-lg-2">
                                            <label>
                                                <select name="make" class="filter-select">
                                                    <option value="" selected>Make</option>
                                                    <?php foreach($makes as $k => $v) :?>
                                                    <option value="<?php echo $k ?>"<?php if($k == $make) echo ' selected'; ?>><?php echo $v ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </label>
                                        </div>
                                        <div class="filter-single col-lg-2">
                                            <label>
                                                <select name="model" class="filter-select">
                                                    <option value="" selected>Model</option>
                                                    <?php foreach($models as $k => $v) :?>
                                                    <option value="<?php echo $k ?>"<?php if($k == $model) echo ' selected'; ?>><?php echo $v ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </label>
                                        </div>
                                        <div class="filter-single col-lg-3">
                                            <label>
                                                <select name="distance" class="filter-select">
                                                    <!--option value="" selected>Radius</option-->
                                                    <?php foreach($distances as $k => $v) :?>
                                                    <option value="<?php echo $k ?>"<?php if($k == $distance) echo ' selected'; ?>><?php echo $v ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </label>
                                        </div>
                                        <div class="filter-single col-lg-2">
                                            <label>
                                                <select name="orderby" class="filter-select">
                                                    <?php foreach($order_by_fields as $k => $v) :?>
                                                    <option value="<?php echo $k ?>"<?php if($k == $order_by) echo ' selected'; ?>><?php echo $v ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </label>
                                        </div>
                                        <div class="filter-single col-lg-1">
                                            <label>
                                                <select name="orderdir" class="filter-select">
                                                    <?php foreach($order_dir_fields as $k => $v) :?>
                                                    <option value="<?php echo $k ?>"<?php if($k == $order_dir) echo ' selected'; ?>><?php echo $v ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </label>
                                        </div>
                                    </form>
                                </div>
                                <div class="row search-results">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="title"></th>
                                                <th class="image"></th>
                                                <!--th><div class="days"></div><span>Day's in Inventory</span></th-->
                                                <th><div class="images"></div><span>Your Images</span></th>
                                                <!--th><div class="description"></div><span>Description</span></th-->
                                                <th><div class="vdp"></div><span>Time on VDP</span></th>
                                                <th><div class="price"></div><span>Your Price</span></th>
                                                <th><div class="price-rank"></div><span>Price Rank</span></th>
                                                <th><div class="km-rank"></div><span>KM Rank</span></th>
                                                <th><span>Similar Vehicles</span></th>
                                            </tr>
                                        </thead>
                                        <tbody id="search-result-body">
                                            <?php
                                                
                                                $odd = true;
                                                
                                                foreach($cars as $stock_number => $car) : 
                                                    $similars = $search->get_similar_cars($car, $distance, $exact);

                                                    $image_count_class = 'green';
                                                    if($car['status']['image_count'] <= ($car['status']['avg_image_count'] * 0.80)) { $image_count_class = 'red'; }

                                                    $desc_count_class = 'green';
                                                    if($car['status']['desc_count'] <= ($car['status']['avg_desc_count'] * 0.80)) { $desc_count_class = 'red'; }

                                                    $time_on_vdp_class = 'green';
                                                    if($car['rank_data']['time_on_page'] <= ($car['rank_data']['avg_time_on_page'] * 0.80)) { $time_on_vdp_class = 'red'; }

                                                    $price_class = 'green';
                                                    if($car['status']['price_rank'] > round($car['status']['total'] * 0.80) + 1 || numarifyPrice($car['price']) == 0 ) { $price_class = 'red'; }

                                                    $km_class = 'green';
                                                    if($car['status']['km_rank'] > round($car['status']['total'] * 0.80) + 1 || numarifyKm($car['kilometers']) == 0) { $km_class = 'red'; }

                                            ?>      
                                            <tr class="<?php if($odd) echo 'odd'; else echo 'even'; ?>" car-id="<?php echo $stock_number; ?>">
                                                <td class="title">
                                                    <a href="<?php echo $car['url'] ?>" target="_blank">
                                                    <span><?php echo "{$car['year']} {$car['make']} {$car['model']}"; if($exact){ echo " {$car['trim']}"; } ?></span>
                                                    <span><?php echo "#$stock_number" ?></span>
                                                    </a>
                                                </td>
                                                <td class="image">
                                                    <?php if($car['img']) : ?>
                                                    <a href="<?php echo $car['url'] ?>" target="_blank">
                                                    <img src="<?php echo $car['img']; ?>" alt=""/>
                                                    </a>
                                                    <?php endif; ?>
                                                </td>
                                                <!--td><span><span class="green">< ?php echo $car['status']['day_count'] ?></span>/< ?php echo $car['status']['avg_day_count'] ?></span></td-->
                                                <td><span><span class="<?php echo $image_count_class ?>"><?php echo $car['status']['image_count'] ?></span>/<?php echo $car['status']['avg_image_count'] ?></span></td>
                                                <!--td><span><span class="< ?php echo $desc_count_class ?>">< ?php echo $car['status']['desc_count'] ?></span>/< ?php echo $car['status']['avg_desc_count'] ?></span></td-->
                                                <td><span><?php if($car['rank_data']['avg_time_on_page'] > 0): ?><span class="<?php echo $time_on_vdp_class ?>"><?php echo seconds2minute_seconds($car['rank_data']['time_on_page']) ?></span>/<?php echo seconds2minute_seconds($car['rank_data']['avg_time_on_page']) ?><?php else: ?>N/A<?php endif; ?></span></td>
                                                <td><span class="<?php echo $price_class ?>"><?php echo $car['price'] ?></span></td>
                                                <td><span><?php if($car['status']['price_rank'] != 'n/a') : ?><span class="<?php echo $price_class ?>"><?php echo $car['status']['price_rank'] ?></span>/<?php echo $car['status']['total'] + 1 ?><?php else: ?>n/a<?php endif; ?></span></td>
                                                <td><span><?php if($car['status']['km_rank'] != 'n/a') : ?><span class="<?php echo $km_class ?>"><?php echo $car['status']['km_rank'] ?></span>/<?php echo $car['status']['total'] + 1 ?><?php else: ?>n/a<?php endif; ?></span></td>
                                                <td class="similar">
                                                    <a href="comp-calc-similars.php?dealership=<?php echo $user['cron_name']?>&stock_number=<?php echo $stock_number ?>&distance=<?php echo $distance ?><?php if($exact) { echo "&exact=true"; }?>" target="_blank">
                                                    <span><?php echo $car['status']['similar_count'] ?></span>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php $odd = !$odd; endforeach; ?>
                                        </tbody>
                                    </table>
                                    <div class="animation_image">
                                        
                                    </div>
                                    <?php if(count($cars) == 0): ?>
                                    <div class="no-match">
                                        No Match Found
                                    </div>
                                    <?php else: ?>
                                    <div class="pagging inpage">
                                        
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="row pagination">
                                    <?php //for($i = 1; $i <= $page_count; $i++) : ?>
                                    <!--a href="<?php //echo "?$query_str&page=$i" ?>" class="<?php //if($page == $i) { echo 'active'; } ?>"><?php //echo $i ?></a-->
                                    <?php //endfor; ?>
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

<div id="similar-vehicles" class="modal">
    <div class="modal-content modal-80">
        <section class="panel">
            <div class="panel-body">
                <div class="search-results">
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
                        <tbody id="similar-container">
                            
                        </tbody>
                    </table>
                </div>
                <div class="loading-anim">
                    
                </div>
                <div id="page-container" class="row pagination">
                    
                </div>
            </div>
        </section>
    </div>
</div>

<?php include 'bolts/footer.php' ?>
<?php $db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION); ?>