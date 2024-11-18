<?php
    require_once 'bootstrapper.php';

    global $connection;
    
    $db_connect = new DbConnect('all_imported');
    $makes      = get_makes([], $db_connect);
?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>sMedia Car Finder</title>
<link rel="stylesheet" type="text/css" href="assets/css/index.css">
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
<script type="text/javascript" src="assets/js/wwb10.min.js"></script>
<script type="text/javascript" src="assets/js/model-loader.js"></script>
</head>
<body>
<form mathod="get" action="page.php">
<div id="container">
<div id="wb_indexShape7" style="position:absolute;left:365px;top:515px;width:20px;height:10px;z-index:20;">
<img src="assets/images/img0025.png" id="indexShape7" alt="" style="width:20px;height:10px;"></div>
<div id="wb_indexText6" style="position:absolute;left:351px;top:510px;width:305px;height:21px;text-align:center;z-index:21;">
<span style="color:#4486F8;font-family:'Roboto Light';font-size:16px;"><u>Show advanced search options</u></span></div>
<div id="wb_indexShape8" style="position:absolute;left:357px;top:508px;width:265px;height:31px;z-index:22;">
<a href="#" onclick="ShowObjectWithEffect('indexLayer1', 1, 'slideup', 500);return false;"><img src="assets/images/img0026.png" id="indexShape8" alt="" style="width:265px;height:31px;"></a></div>
<input name="max_year" type="text" data-type="number" id="indexCombobox6" style="position:absolute;left:523px;top:448px;width:305px;height:34px;z-index:23;" placeholder=" Max. year">
<input name="min_year" type="text" data-type="number" id="indexCombobox5" style="position:absolute;left:152px;top:448px;width:305px;height:34px;z-index:24;" placeholder=" Min. year">
<select name="model" size="1" id="indexCombobox2" style="position:absolute;left:523px;top:375px;width:305px;height:36px;z-index:25;">
<option value="" selected>Model (any)</option>
</select>
<select name="make" size="1" id="indexCombobox1" style="position:absolute;left:152px;top:375px;width:305px;height:36px;z-index:26;">
<option value="" selected>Make (any)</option>
<?php foreach($makes as $make): ?>
<option value="<?php echo strtolower($make) ?>"><?php echo $make ?></option>
<?php endforeach;?>
</select>
<select name="range" size="1" id="indexCombobox3" style="position:absolute;left:523px;top:302px;width:305px;height:36px;z-index:27;">
<option value="" selected>Within radius of...</option>
<option value="25">+ 25 km</option>
<option value="50">+ 50km</option>
<option value="100">+100 km</option>
<option value="150">+ 150 km</option>
<option value="0">Nation wide</option>
</select>
<input name="post_code" type="text" id="indexEditbox3" style="position:absolute;left:152px;top:302px;width:303px;height:34px;line-height:34px;z-index:28;" value="" placeholder=" Enter Postal Code">
<div id="wb_indexShape1" style="position:absolute;left:338px;top:231px;width:305px;height:42px;z-index:29;">
<img src="assets/images/img0001.png" id="indexShape1" alt="" style="width:305px;height:42px;"></div>
<div id="wb_indexText2" style="position:absolute;left:412px;top:240px;width:156px;height:25px;text-align:center;z-index:30;">
<span style="color:#FFFFFF;font-family:'Roboto Light';font-size:19px;"><strong>SEARCH!</strong></span></div>
<div id="wb_indexText7" style="position:absolute;left:162px;top:183px;width:656px;height:25px;text-align:center;z-index:31;">
<span style="color:#000000;font-family:'Roboto Light';font-size:19px;"><strong>Search from over 930 000 cars, New &amp; used for sale!</strong></span></div>
<div id="wb_indexImage3" style="position:absolute;left:437px;top:310px;width:12px;height:21px;z-index:32;">
<img src="assets/images/locationandradius-01.png" id="indexImage3" alt=""></div>
<div id="wb_indexShape2" style="position:absolute;left:483px;top:465px;width:15px;height:2px;z-index:33;">
<img src="assets/images/img0002.png" id="indexShape2" alt="" style="width:15px;height:2px;"></div>
<div id="indexLayer1" style="position:absolute;text-align:center;visibility:hidden;left:128px;top:486px;width:725px;height:366px;z-index:34;">
<div id="indexLayer1_Container" style="width:725px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
<div id="wb_indexShape5" style="position:absolute;left:24px;top:253px;width:676px;height:47px;z-index:0;">
<img src="assets/images/img0005.png" id="indexShape5" alt="" style="width:676px;height:47px;"></div>
<select name="color" size="1" id="indexCombobox8" style="position:absolute;left:395px;top:183px;width:305px;height:36px;z-index:1;">
<option value="" selected>Exterior Color (any)</option>
<option value="white">White</option>
<option value="silver">Silver</option>
<option value="black">Black</option>
<option value="gray">Gray</option>
<option value="blue">Blue</option>
<option value="red">Red</option>
<option value="brown">Brown</option>
<option value="green">Green</option>
<option value="others">Others</option>
</select>
<select name="transmission" size="1" id="indexCombobox4" style="position:absolute;left:24px;top:183px;width:305px;height:36px;z-index:2;">
<option value="" selected>Transmission (any)</option>
<option value="automatic">Automatic</option>
<option value="manual">Manual</option>
</select>
<input name="max_price" type="text" data-type="number" id="indexEditbox6" style="position:absolute;left:395px;top:37px;width:303px;height:34px;line-height:34px;z-index:3;" value="" placeholder=" Max. price">
<input name="min_price" type="text" data-type="number" id="indexEditbox7" style="position:absolute;left:24px;top:37px;width:303px;height:34px;line-height:34px;z-index:4;" value="" placeholder=" Min. price">
<div id="wb_indexText13" style="position:absolute;left:88px;top:262px;width:72px;height:28px;z-index:5;text-align:left;">
<span style="color:#696969;font-family:'Roboto Light';font-size:21px;">New</span></div>
<div id="wb_indexText14" style="position:absolute;left:256px;top:262px;width:64px;height:28px;z-index:6;text-align:left;">
<span style="color:#696969;font-family:'Roboto Light';font-size:21px;">Used</span></div>
<div id="wb_indexText17" style="position:absolute;left:590px;top:262px;width:70px;height:28px;text-align:right;z-index:7;">
<span style="color:#696969;font-family:'Roboto Light';font-size:21px;">Dealer</span></div>
<div id="wb_indexText18" style="position:absolute;left:425px;top:262px;width:109px;height:28px;z-index:8;text-align:left;">
<span style="color:#696969;font-family:'Roboto Light';font-size:21px;">Private</span></div>
<input type="checkbox" id="indexCheckbox2" name="search_new" value="on" style="position:absolute;left:64px;top:266px;z-index:9;">
<input type="checkbox" id="indexCheckbox3" name="search_used" value="on" style="position:absolute;left:232px;top:266px;z-index:10;">
<input type="checkbox" id="indexCheckbox4" name="search_private" value="on" style="position:absolute;left:401px;top:266px;z-index:11;">
<div id="wb_indexShape3" style="position:absolute;left:355px;top:54px;width:15px;height:2px;z-index:12;">
<img src="assets/images/img0003.png" id="indexShape3" alt="" style="width:15px;height:2px;"></div>
<div id="wb_indexShape4" style="position:absolute;left:355px;top:127px;width:15px;height:2px;z-index:13;">
<img src="assets/images/img0004.png" id="indexShape4" alt="" style="width:15px;height:2px;"></div>
<input type="checkbox" id="indexCheckbox1" name="search_dealer" value="on" style="position:absolute;left:576px;top:266px;z-index:14;">
<div id="wb_indexText1" style="position:absolute;left:233px;top:325px;width:294px;height:21px;text-align:center;z-index:15;">
<span style="color:#4486F8;font-family:'Roboto Light';font-size:16px;"><u>Hide advanced search options</u></span></div>
<div id="wb_indexShape6" style="position:absolute;left:242px;top:330px;width:20px;height:10px;z-index:16;">
<img src="assets/images/img0006.png" id="indexShape6" alt="" style="width:20px;height:10px;"></div>
<div id="wb_indexShape9" style="position:absolute;left:234px;top:320px;width:265px;height:31px;z-index:17;">
<a id="a_indexShape9" href="#"><img src="assets/images/img0027.png" id="indexShape9" alt="" style="width:265px;height:31px;"></a></div>
<input name="max_kilometers" type="text" data-type="number" id="indexCombobox9" style="position:absolute;left:395px;top:110px;width:305px;height:34px;z-index:18;" placeholder=" Max. Kilometers">
<input name="min_kilometers" type="text" data-type="number" id="indexCombobox7" style="position:absolute;left:24px;top:110px;width:305px;height:34px;z-index:19;" placeholder=" Min. Kilometers">
</div>
</div>
<div id="wb_indexImage1" style="position:absolute;left:365px;top:49px;width:250px;z-index:35;">
<img src="assets/images/logo.png" id="indexImage1" alt=""></div>
<div id="wb_indexShape10" style="position:absolute;left:338px;top:231px;width:305px;height:42px;z-index:36;">
<button type="submit" style="width:305px; height: 42px; color: #fff; background-color: #4486f8; line-height: 40px; font-size: 20px; cursor: pointer; border-style: none;">SEARCH!</button>
</div>
</div>
</form>
    <script>
        $(document).ready(function(){
            $('#a_indexShape9').click(function(){
                ShowObjectWithEffect('indexLayer1', 0, 'slideup', 500);
                return false;
            });
        });
    </script>
</body>
</html>
<?php
$db_connect->close_connection();