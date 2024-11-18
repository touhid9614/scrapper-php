<?php
    require_once 'bootstrapper.php';

    global $connection;

    $db_connect->close_connection();
    $db_connect = new DbConnect('all_imported');

    $makes  = get_makes([], $db_connect);
    $models = [];

    if ($make) {
        $models = get_models($models, $db_connect);
    }

    $cars = get_cars([], $db_connect);
?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>sMedia Car Finder</title>
<link rel="stylesheet" type="text/css" href="assets/css/page.css?v=1.0">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<script type="text/javascript" src="assets/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.effect.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.effect-blind.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.effect-bounce.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.effect-clip.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.effect-drop.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.effect-explode.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.effect-fade.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.effect-fold.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.effect-highlight.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.effect-pulsate.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.effect-scale.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.effect-shake.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.effect-slide.min.js"></script>
<script type="text/javascript" src="assets/js/wb.rotate.min.js"></script>
<script type="text/javascript" src="assets/js/wwb10.min.js"></script>
<script type="text/javascript" src="assets/js/model-loader.js"></script>
<script type="text/javascript" src="assets/js/car-finder.js?v=1.0"></script>
</head>
<body>
<form id="filter-form" method="GET">
<div id="page1PageHeader1" style="position:absolute;overflow:hidden;text-align:center;left:0px;top:0px;width:100%;height:190px;z-index:-1;">
<div id="page1PageHeader1_Container" style="width:980px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
<div id="wb_indexShape1" style="position:absolute;left:780px;top:28px;width:202px;height:30px;z-index:0;">
<img src="assets/images/img0013.png" id="indexShape1" alt="" style="width:202px;height:30px;"></div>
<div id="wb_indexText2" style="position:absolute;left:803px;top:31px;width:156px;height:25px;text-align:center;z-index:1;">
<span style="color:#FFFFFF;font-family:'Roboto Light';font-size:19px;"><strong>SEARCH!</strong></span></div>
<div id="wb_indexImage1" style="position:absolute;left:0px;top:0px;width:200px;z-index:2;">
<img src="assets/images/logo.png" id="indexImage1" alt=""></div>
<div id="wb_indexShape10" style="position:absolute;left:780px;top:28px;width:202px;height:30px;z-index:3;">
<a href="./page1.html"><img src="assets/images/img0014.png" id="indexShape10" alt="" style="width:202px;height:30px;"></a></div>
</div>
</div>
<div id="container">
<div id="page1Layer1" style="position:absolute;text-align:center;left:607px;top:127px;width:286px;height:45px;z-index:43;">
<div id="page1Layer1_Container" style="width:286px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
<div id="wb_indexShape7" style="position:absolute;left:18px;top:15px;width:20px;height:10px;z-index:18;">
<img src="assets/images/img0007.png" id="indexShape7" alt="" style="width:20px;height:10px;"></div>
<div id="wb_page1Text9" style="position:absolute;left:38px;top:10px;width:240px;height:21px;text-align:center;z-index:19;">
<span style="color:#4486F8;font-family:'Roboto Light';font-size:16px;"><u>Show advanced search options</u></span></div>
<div id="wb_indexShape8" style="position:absolute;left:10px;top:8px;width:265px;height:31px;z-index:20;">
<a href="#" onclick="ShowObjectWithEffect('page1Layer2', 1, 'slideup', 300);Animate('page1PageHeader1', '', '', '', '300', '', 300, '');ShowObjectWithEffect('page1Layer1', 0, 'fade', 50);Animate('page1Layer3', '', '300', '', '', '', 300, '');return false;"><img src="assets/images/img0022.png" id="indexShape8" alt="" style="width:265px;height:31px;"></a></div>
</div>
</div>
<input name="max_year" type="text" value="<?php echo $max_year ?>" data-type="number" id="page1Combobox1" style="position:absolute;left:260px;top:134px;width:200px;height:30px;z-index:44;" placeholder=" Max. year">
<input name="min_year" type="text" value="<?php echo $min_year ?>" data-type="number" id="page1Combobox2" style="position:absolute;left:0px;top:134px;width:200px;height:30px;z-index:45;" placeholder=" Min. year">
<select name="model" size="1" id="page1Combobox3" style="position:absolute;left:780px;top:81px;width:200px;height:30px;z-index:46;">
<option value="" selected>Model (any)</option>
<?php foreach($models as $m): ?>
<option value="<?php echo $m ?>" <?php if($m == $model) {echo 'selected';}?>><?php echo $m ?></option>
<?php endforeach;?>
</select>
<select name="make" size="1" id="page1Combobox4" style="position:absolute;left:520px;top:81px;width:200px;height:30px;z-index:47;">
<option value="" selected>Make (any)</option>
<?php foreach($makes as $m): ?>
<option value="<?php echo strtolower($m) ?>" <?php if(strtolower($m) == $make) {echo 'selected';}?>><?php echo $m ?></option>
<?php endforeach;?>
</select>
<select name="range" size="1" id="page1Combobox5" style="position:absolute;left:260px;top:81px;width:200px;height:30px;z-index:48;">
<option value="" selected>Within radius of...</option>
<option value="25" <?php if($range == '25') {echo 'selected';} ?>>+ 25 km</option>
<option value="50" <?php if($range == '50') {echo 'selected';} ?>>+ 50km</option>
<option value="100" <?php if($range == '100') {echo 'selected';} ?>>+100 km</option>
<option value="150" <?php if($range == '150') {echo 'selected';} ?>>+ 150 km</option>
<option value="0" <?php if($range == '0') {echo 'selected';} ?>>Nation wide</option>
</select>
<input name="post_code" type="text" value="<?php echo $post_code ?>" id="page1Editbox1" style="position:absolute;left:0px;top:81px;width:198px;height:28px;line-height:28px;z-index:49;" placeholder=" Enter Postal Code">
<div id="wb_indexImage3" style="position:absolute;left:182px;top:86px;width:12px;height:21px;z-index:50;">
<img src="assets/images/locationandradius-01.png" id="indexImage3" alt=""></div>
<div id="wb_page1Shape8" style="position:absolute;left:225px;top:148px;width:10px;height:2px;z-index:51;">
<img src="assets/images/img0028.png" id="page1Shape8" alt="" style="width:10px;height:2px;"></div>
</div>
<div id="page1Layer2" style="position:absolute;text-align:center;visibility:hidden;left:0px;top:133px;width:100%;height:155px;z-index:43;">
<div id="page1Layer2_Container" style="width:980px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
<input name="min_price" type="text" value="<?php echo $min_price ?>" data-type="number" id="page1Editbox5" style="position:absolute;left:520px;top:0px;width:198px;height:30px;line-height:30px;z-index:21;" placeholder=" Min. price">
<div id="wb_page1Shape13" style="position:absolute;left:745px;top:15px;width:10px;height:2px;z-index:22;">
<img src="assets/images/img0030.png" id="page1Shape13" alt="" style="width:10px;height:2px;"></div>
<input name="max_price" type="text" value="<?php echo $max_price ?>" data-type="number" id="page1Editbox4" style="position:absolute;left:780px;top:0px;width:198px;height:30px;line-height:30px;z-index:23;" placeholder=" Max. price">
<select name="color" size="1" id="page1Combobox6" style="position:absolute;left:780px;top:54px;width:200px;height:32px;z-index:24;">
<option value="" selected>Exterior Color (any)</option>
<option value="white" <?php if($color == 'white') {echo 'selected';} ?>>White</option>
<option value="silver" <?php if($color == 'silver') {echo 'selected';} ?>>Silver</option>
<option value="black" <?php if($color == 'black') {echo 'selected';} ?>>Black</option>
<option value="gray" <?php if($color == 'gray') {echo 'selected';} ?>>Gray</option>
<option value="blue" <?php if($color == 'blue') {echo 'selected';} ?>>Blue</option>
<option value="red" <?php if($color == 'red') {echo 'selected';} ?>>Red</option>
<option value="brown" <?php if($color == 'brown') {echo 'selected';} ?>>Brown</option>
<option value="green" <?php if($color == 'green') {echo 'selected';} ?>>Green</option>
<option value="others" <?php if($color == 'others') {echo 'selected';} ?>>Others</option>
</select>
<div id="wb_page1Shape15" style="position:absolute;left:745px;top:69px;width:10px;height:2px;z-index:25;">
<img src="assets/images/img0034.png" id="page1Shape15" alt="" style="width:10px;height:2px;"></div>
<select name="transmission" size="1" id="page1Combobox7" style="position:absolute;left:520px;top:54px;width:200px;height:32px;z-index:26;">
<option value="" selected>Transmission (any)</option>
<option value="automatic" <?php if($transmission == 'automatic') {echo 'selected';} ?>>Automatic</option>
<option value="manual" <?php if($transmission == 'manual') {echo 'selected';} ?>>Manual</option>
</select>
<div id="wb_page1Text15" style="position:absolute;left:618px;top:115px;width:294px;height:21px;text-align:center;z-index:27;">
<span style="color:#4486F8;font-family:'Roboto Light';font-size:16px;"><u>Hide advanced search options</u></span></div>
<div id="wb_indexShape6" style="position:absolute;left:627px;top:120px;width:20px;height:10px;z-index:28;">
<img src="assets/images/img0032.png" id="indexShape6" alt="" style="width:20px;height:10px;"></div>
<div id="wb_indexShape9" style="position:absolute;left:617px;top:114px;width:265px;height:31px;z-index:29;">
<a href="#" onclick="ShowObjectWithEffect('page1Layer2', 0, 'slideup', 300);Animate('page1PageHeader1', '', '', '', '190', '', 300, '');ShowObjectWithEffect('page1Layer1', 1, 'fade', 300);Animate('page1Layer3', '', '190', '', '', '', 300, '');return false;"><img src="assets/images/img0033.png" id="indexShape9" alt="" style="width:265px;height:31px;"></a></div>
<div id="wb_page1Shape12" style="position:absolute;left:0px;top:109px;width:460px;height:32px;z-index:30;">
<img src="assets/images/img0029.png" id="page1Shape12" alt="" style="width:460px;height:32px;"></div>
<div id="wb_page1Text11" style="position:absolute;left:34px;top:115px;width:72px;height:21px;z-index:31;text-align:left;">
<span style="color:#696969;font-family:'Roboto Light';font-size:16px;">New</span></div>
<div id="wb_page1Text12" style="position:absolute;left:142px;top:115px;width:64px;height:21px;z-index:32;text-align:left;">
<span style="color:#696969;font-family:'Roboto Light';font-size:16px;">Used</span></div>
<div id="wb_page1Text13" style="position:absolute;left:373px;top:115px;width:70px;height:21px;text-align:right;z-index:33;">
<span style="color:#696969;font-family:'Roboto Light';font-size:16px;">Dealer</span></div>
<div id="wb_page1Text14" style="position:absolute;left:261px;top:115px;width:109px;height:21px;z-index:34;text-align:left;">
<span style="color:#696969;font-family:'Roboto Light';font-size:16px;">Private</span></div>
<input type="checkbox" id="page1Checkbox1" name="search_new" value="on" style="position:absolute;left:10px;top:115px;z-index:35;" <?php if($search_new) {echo 'checked';} ?>>
<input type="checkbox" id="page1Checkbox2" name="search_used" value="on" style="position:absolute;left:118px;top:115px;z-index:36;" <?php if($search_used) {echo 'checked';} ?>>
<input type="checkbox" id="page1Checkbox3" name="search_private" value="on" style="position:absolute;left:237px;top:115px;z-index:37;" <?php if($search_private) {echo 'checked';} ?>>
<input type="checkbox" id="indexCheckbox1" name="search_dealer" value="on" style="position:absolute;left:372px;top:115px;z-index:38;" <?php if($search_dealer) {echo 'checked';} ?>>
<div id="wb_page1Shape14" style="position:absolute;left:225px;top:69px;width:10px;height:2px;z-index:39;">
<img src="assets/images/img0031.png" id="page1Shape14" alt="" style="width:10px;height:2px;"></div>
<input name="min_kilometers" type="text" value="<?php echo $min_kilometers ?>" data-type="number" id="indexCombobox7" style="position:absolute;left:0px;top:54px;width:200px;height:30px;z-index:40;" placeholder=" Min. Kilometers">
<input name="max_kilometers" type="text" value="<?php echo $max_kilometers ?>" data-type="number" id="indexCombobox9" style="position:absolute;left:260px;top:54px;width:200px;height:30px;z-index:41;" placeholder=" Max. Kilometers">
</div>
</div>
</form>

<input id="page_number" type="hidden" value="<?php echo $page; ?>"/>

<div id="page1Layer3" style="position:absolute;text-align:center;left:0px;top:190px;width:100%;z-index:42;">
<div id="page1Layer3_Container" style="width:980px;position:relative;margin-left:auto;margin-right:auto;text-align:left; border-top: 1px solid rgba(0, 0, 0, 0.1);">
<div class="car-container clearfix">
    <div class="result-count">
        <?php echo $cars['count'] ?>
    </div>
    <?php foreach($cars['cars'] as $car): ?>
    <div class="car">
        <div>
            <a class="title" href="<?php echo $car['url'] ?>"><?php echo $car['title'] ?></a>
        </div>
        <div class="content clearfix">
            <div class="image">
                <img src="<?php echo $car['image'] != ''? $car['image'] : 'assets-new/images/img0008.png' ?>" alt=""/>
            </div>
            <div class="details">
                <?php
                echo "<a href=\"{$car['url']}\">{$car['url']}</a>";
                if($car['odometer'])
                {
                    echo "<span class=\"odometer\">{$car['odometer']}</span>";
                }
                if($car['days'])
                {
                    echo "<span class=\"days\">{$car['days']}</span>";
                }
                if($car['distance'])
                {
                    echo "<span class=\"distance\">{$car['distance']}</span>";
                }
                ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php echo $cars['pagination']; ?>
</div>
<div id="ajax-loader"></div>
</div>
</div>

</body>
</html>
<?php
$db_connect->close_connection();