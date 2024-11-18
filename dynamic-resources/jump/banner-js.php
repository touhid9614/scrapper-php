<?php

    header('Content-type: text/javascript; charset=UTF-8');
    //die('/*Banner expired*/');
    //if(time() > mktime(0,0,0,11,16,2017)) { die('/*Banner expired*/'); }
    
?>

var smedia_css = '.row.smedia-value-prop{padding-top:20px;padding-bottom:40px;text-align:center}.row.smedia-value-prop img{height:36px}.row.smedia-value-prop span{margin-left:20px;font-size:1.2em}',
    smedia_head = document.head || document.getElementsByTagName('head')[0],
    smedia_style = document.createElement('style');

smedia_style.type = 'text/css';
if (smedia_style.styleSheet){
  smedia_style.styleSheet.cssText = smedia_css;
} else {
  smedia_style.appendChild(document.createTextNode(smedia_css));
}

smedia_head.appendChild(smedia_style);

var smedia_elem = document.getElementsByClassName("navbar navbar-default navbar-static-top");
var smedia_div = document.createElement('div');
//#e03c47

var text_line = 'Summer sale! Discounts on the best phones, starting at $0.';
var url_text  = 'Shop now.';

smedia_div.innerHTML = '<div style="background-color: #e03c47; padding: 2px; text-align: center; color: white;"><!--img src="//tm.smedia.ca/assets/maple-leaf.png" style="width: 30px; display: inline-block;"--><p style="margin: 0px; line-height: 40px; display: inline-block; padding-left: 10px; padding-right: 10px; font-size: 1.3em; font-weight: 600;">' + text_line + ' <a style="margin: 0px; line-height: 40px; display: inline-block; color:white; text-decoration:underline;" href="/smartphone-sale/?utm_source=top_promo_banner">' + url_text + '</a></p><!--img src="//tm.smedia.ca/assets/maple-leaf.png" style="width: 30px; display: inline-block;"><p style="margin: 0px; line-height: 40px; display: inline-block; padding-left: 10px; ">In-store only.</p--></div>';
<?php if(time() < mktime(0,0,0,04,01,2020)) { #Until 1st April 2020 (until further notice) Disabled completely ?>
//smedia_elem[0].parentNode.insertBefore(smedia_div, smedia_elem[0]);
<?php } ?>

var accessoriesHTML = `
    <div class="col-sm-4">
      <img src="https://tm.smedia.ca/dynamic-resources/jump/jump-delivery.svg">
      <span><b>FAST FREE</b> SHIPPING</span>
    </div>
    <div class="col-sm-4">
      <img src="https://tm.smedia.ca/dynamic-resources/jump/jump-cart.svg">
      <span><b>BUY ONLINE.</b> PICKUP IN-STORE</span>
    </div>
    <div class="col-sm-4">
      <img src="https://tm.smedia.ca/dynamic-resources/jump/jump-currency.svg">
      <span><b>EASY</b> RETURNS</span>
    </div>
    &nbsp;
`;

var smedia_a_div = document.createElement('div');
smedia_a_div.innerHTML = accessoriesHTML;
smedia_a_div.className = "row smedia-value-prop";
var smedia_product_elem = document.getElementsByClassName("row product-detail-topInfo");
if(smedia_product_elem.length > 0) {
    smedia_product_elem[0].parentNode.insertBefore(smedia_a_div, smedia_product_elem[0]);
}
