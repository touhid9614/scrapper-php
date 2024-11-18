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
    
    global $user, $connection, $distances, $order_by_fields;
    
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
<?php

    $odd = !$odd; endforeach;