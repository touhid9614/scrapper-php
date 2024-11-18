<?php
global $scrapper_configs;
$scrapper_configs["kratzmanncomau"] = array( 
	'entry_points' => array(
        'used' => 'https://www.kratzmann.com.au/Stock/WSStockAngular/GetStockList',
        'new' => 'https://www.kratzmann.com.au/Stock/WSStockAngular/GetStockList',
    ),
    'vdp_url_regex' => '/\/(?:Details|detail)\/[^\/]+\/[^\/]+\/[0-9]{4}/i',
     'srp_page_regex'          => '/caravans-in-stock\?type\=(?:new|used)/i',
    'use-proxy' => true,
    'refine' => false,
    'content_type'      => 'application/json;charset=UTF-8',
    'init_method' => 'POST',
    'next_method' => 'POST',

    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);
        if (!$objects) {
            slecho($data);
            return array();
        }

        $to_return = array();

        foreach ($objects->StockList as $obj) {

            $car_data = array(
                'stock_number' => $obj->StockNumber ? $obj->StockNumber : $obj->VIN,
                'year' => $obj->ModelYear,
                'make' => $obj->Make,
                'model' => $obj->Model,
                'trim' => $obj->Variant . ' ' .  $obj->Series,
                'body_style' => $obj->Variant,
                'price' => $obj->AskingPrice ,
                'url' => "https://www.kratzmann.com.au/" .  $obj->UrlDetail,
                'all_images' => $obj->image->image_original,
                'title' => $obj->VehicleInfo,
                'stock_type' => strtolower($obj->Type),
            );

            $imgs=[];
            
            foreach($obj->StockImages as $key=>$value){
                    
                $imgs[]="https:" . $value->Url;
  
            }
            $car_data['all_images']=implode("|",$imgs);
            
            $response_data = HttpGet($car_data['url']);
            $year_regex = '/class="veh-year"[^>]+>[^>]+>Year[^>]+>[^>]+>[^>]+>(?<year>[^<]+)/';
            $matches = [];
            if(preg_match($year_regex, $response_data, $matches))
            {
                $car_data['year']=$matches['year'];
            }

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    
);

 add_filter('filter_kratzmanncomau_post_data', 'filter_kratzmanncomau_post_data', 10, 2);
 function filter_kratzmanncomau_post_data($post_data, $stock_type)
 {

     if ($stock_type == 'new') {
         $post_data = '{"Area":"Stock","FilterId":"eb9a19eb9a","IsSEO":false,"StockFilter":{"WebsiteId":250,"PageNumber":1,"PageSize":200,"Branch":null,"Cylinders":null,"SoldDay":null,"Sleep":null,"Berth":null,"AuctionId":null,"IsLAMS":null,"IsSelectedAllVariant":null,"DealerNo":null,"State":null,"SearchText":null,"SearchType":"veh_title_desc_sn","StockNumber":null,"Class":null,"Type":null,"Keyword":"","Make":null,"Model":null,"Body":"1-axle,2-axle,","Variant":",camper,camper-trailer,caravan,motorhome,pop-top","Series":null,"FuelType":null,"Colour":null,"Transmission":null,"TransmissionType":null,"ReleaseStatus":null,"ANCAPSafetyRating":null,"GreenStarRating":null,"CaravanConcept":null,"SortBy":"stock_number","AuctionLoginOption":null,"SoldFilter":null,"YearFilter":null,"PriceFilter":{"PriceType":null,"PriceTypeEnum":null,"Min":0,"Max":165000,"Step":5000,"Ceil":null,"Floor":null},"PricePerWeekFilter":null,"ATMWeightFilter":{"Min":0,"Max":3500,"Step":1,"Ceil":null,"Floor":null},"BallWeightFilter":{"Min":0,"Max":248,"Step":1,"Ceil":null,"Floor":null},"LengthMetricFilter":{"Min":0,"Max":1,"Step":1,"Ceil":null,"Floor":null},"TareWeightFilter":{"Min":0,"Max":3760,"Step":1,"Ceil":null,"Floor":null},"TowLengthMetricFilter":null,"OdometerFilter":null,"EngineSizeLiter":null,"EngineSizeCCFilter":null,"DoorFilter":null,"SeatFilter":null,"SleepFilter":{"Min":0,"Max":0,"Step":1,"Ceil":null,"Floor":null},"PageSizes":null,"LengthFeetFilter":{"Min":0,"Max":3,"Step":3,"Ceil":null,"Floor":null}},"StockFilterSetup":{"WebsiteId":250,"PageNumber":1,"PageSize":100,"Branch":null,"Cylinders":null,"SoldDay":null,"Sleep":null,"Berth":null,"AuctionId":null,"IsLAMS":null,"IsSelectedAllVariant":null,"DealerNo":null,"State":null,"SearchText":null,"SearchType":"all","StockNumber":null,"Class":null,"Type":null,"Keyword":null,"Make":null,"Model":null,"Body":null,"Variant":"CARAVAN,CAMPER,CAMPER TRAILER,MOTORHOMES,MOTORHOME,POPTOP,POP TOP,B-CLASS,CLASS B,499","Series":null,"FuelType":null,"Colour":null,"Transmission":null,"TransmissionType":null,"ReleaseStatus":null,"ANCAPSafetyRating":null,"GreenStarRating":null,"CaravanConcept":null,"SortBy":"make","AuctionLoginOption":null,"SoldFilter":null,"YearFilter":null,"PriceFilter":null,"PricePerWeekFilter":null,"ATMWeightFilter":null,"BallWeightFilter":null,"LengthMetricFilter":null,"TareWeightFilter":null,"TowLengthMetricFilter":null,"OdometerFilter":null,"EngineSizeLiter":null,"EngineSizeCCFilter":null,"DoorFilter":null,"SeatFilter":null,"SleepFilter":null,"PageSizes":null},"FilterOptions":{"Make":true,"Model":true,"YearFilter":true,"PriceFilter":true,"Body":true,"Variant":true,"Type":false,"Class":false,"ReleaseStatus":false,"AuctionLoginOption":false,"StockNumber":true,"SearchText":false,"Branch":false,"PricePerWeek":false,"EngineSizeCC":true},"ViewOption":{"WSStockSpec":{"MaxDisplayColumn":4,"WSStockSpecColumns":[{"FieldName":"Sleep","Label":"Sleeps","ClassName":"vehicleList-Sleeps","Value":null},{"FieldName":"Tare","Label":"Tare","ClassName":"vehicleList-Tare","Value":null},{"FieldName":"BallWeight","Label":"Ball Weight","ClassName":"vehicleList-Ball","Value":null},{"FieldName":"LengthMetric","Label":"Length","ClassName":"vehicleList-Length","Value":null},{"FieldName":"StockNumber","Label":"Stock#","ClassName":"vehicleList-Stock","Value":null}]},"WSStockFormSearch":{"TextTotalRecords":"vehicle"},"WSStockDetail":{"IsShowCreditOneFinance":false,"CalcRepayHTML":null},"LengthMetricFormat":{"HasMeter":false,"HasFeet":false,"HasInch":false,"FeatUnit":" ft","InchUnit":"\"","MeterUnit":" m"},"IntLengthMetricFormat":{"HasMeter":false,"HasFeet":false,"HasInch":false,"FeatUnit":" ft","InchUnit":"\"","MeterUnit":" m"},"MinHeightMetricFormat":{"HasMeter":false,"HasFeet":false,"HasInch":false,"FeatUnit":" ft","InchUnit":"\"","MeterUnit":" m"},"TowLengthMetricFormat":{"HasMeter":false,"HasFeet":false,"HasInch":false,"FeatUnit":" ft","InchUnit":"\"","MeterUnit":" m"},"IsStockAuction":null,"IsShowPricePerWeek":false,"IsShowBiggestSaving":false,"IsShowDownloadDoc":true,"IsShowbtnFloorplan":true,"IsShowWasPrice":false,"IsShowDealerState":false,"IsShowDealerSuburb":false,"IsShowSaleStatus":false,"CondLocationInBacket":null,"TextIconBasket":null,"ListViewNumber":12,"ListViewExtension":"Index","DetailViewNumber":12,"ThanksViewNumber":null,"FormSearchViewNumber":null,"IsAngularView":true},"Route":{"RoutePrefix":"caravans-in-stock","ActionList":"Index","ActionDetail":"Detail","ActionCheckoutThanks":null,"TemplateUrlList":null,"TemplateUrlDetail":null,"TermAndCondition":null,"IsFilterIdEndPoint":false,"Mode":0},"CalculateRepayment":{"LoanAmount":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"InterestRate":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"Deposit":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"Residual":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"LoanLengthOrPeriod":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"LoanTerm":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"IsCheckWithVehType":false,"FinanceFees":null}}';
     } elseif ($stock_type == 'used') {
         $post_data = '{"Area":"Stock","FilterId":"eb9a19eb9a","IsSEO":false,"StockFilter":{"WebsiteId":250,"PageNumber":1,"PageSize":150,"Branch":null,"Cylinders":null,"SoldDay":null,"Sleep":null,"Berth":null,"AuctionId":null,"IsLAMS":null,"IsSelectedAllVariant":null,"DealerNo":null,"State":null,"SearchText":null,"SearchType":"veh_title_desc_sn","StockNumber":null,"Class":null,"Type":"USED","Keyword":"","Make":null,"Model":null,"Body":"1-axle,2-axle,","Variant":",camper,camper-trailer,caravan,motorhome","Series":null,"FuelType":null,"Colour":null,"Transmission":null,"TransmissionType":null,"ReleaseStatus":null,"ANCAPSafetyRating":null,"GreenStarRating":null,"CaravanConcept":null,"SortBy":"stock_number","AuctionLoginOption":null,"SoldFilter":null,"YearFilter":null,"PriceFilter":{"PriceType":null,"PriceTypeEnum":null,"Min":0,"Max":165000,"Step":5000,"Ceil":null,"Floor":null},"PricePerWeekFilter":null,"ATMWeightFilter":{"Min":0,"Max":3500,"Step":1,"Ceil":null,"Floor":null},"BallWeightFilter":{"Min":0,"Max":248,"Step":1,"Ceil":null,"Floor":null},"LengthMetricFilter":{"Min":0,"Max":1,"Step":1,"Ceil":null,"Floor":null},"TareWeightFilter":{"Min":0,"Max":3760,"Step":1,"Ceil":null,"Floor":null},"TowLengthMetricFilter":null,"OdometerFilter":null,"EngineSizeLiter":null,"EngineSizeCCFilter":null,"DoorFilter":null,"SeatFilter":null,"SleepFilter":{"Min":0,"Max":0,"Step":1,"Ceil":null,"Floor":null},"PageSizes":null,"LengthFeetFilter":{"Min":0,"Max":3,"Step":3,"Ceil":null,"Floor":null}},"StockFilterSetup":{"WebsiteId":250,"PageNumber":1,"PageSize":100,"Branch":null,"Cylinders":null,"SoldDay":null,"Sleep":null,"Berth":null,"AuctionId":null,"IsLAMS":null,"IsSelectedAllVariant":null,"DealerNo":null,"State":null,"SearchText":null,"SearchType":"all","StockNumber":null,"Class":null,"Type":null,"Keyword":null,"Make":null,"Model":null,"Body":null,"Variant":"CARAVAN,CAMPER,CAMPER TRAILER,MOTORHOMES,MOTORHOME,POPTOP,POP TOP,B-CLASS,CLASS B,499","Series":null,"FuelType":null,"Colour":null,"Transmission":null,"TransmissionType":null,"ReleaseStatus":null,"ANCAPSafetyRating":null,"GreenStarRating":null,"CaravanConcept":null,"SortBy":"make","AuctionLoginOption":null,"SoldFilter":null,"YearFilter":null,"PriceFilter":null,"PricePerWeekFilter":null,"ATMWeightFilter":null,"BallWeightFilter":null,"LengthMetricFilter":null,"TareWeightFilter":null,"TowLengthMetricFilter":null,"OdometerFilter":null,"EngineSizeLiter":null,"EngineSizeCCFilter":null,"DoorFilter":null,"SeatFilter":null,"SleepFilter":null,"PageSizes":null},"FilterOptions":{"Make":true,"Model":true,"YearFilter":true,"PriceFilter":true,"Body":true,"Variant":true,"Type":false,"Class":false,"ReleaseStatus":false,"AuctionLoginOption":false,"StockNumber":true,"SearchText":false,"Branch":false,"PricePerWeek":false,"EngineSizeCC":true},"ViewOption":{"WSStockSpec":{"MaxDisplayColumn":4,"WSStockSpecColumns":[{"FieldName":"Sleep","Label":"Sleeps","ClassName":"vehicleList-Sleeps","Value":null},{"FieldName":"Tare","Label":"Tare","ClassName":"vehicleList-Tare","Value":null},{"FieldName":"BallWeight","Label":"Ball Weight","ClassName":"vehicleList-Ball","Value":null},{"FieldName":"LengthMetric","Label":"Length","ClassName":"vehicleList-Length","Value":null},{"FieldName":"StockNumber","Label":"Stock#","ClassName":"vehicleList-Stock","Value":null}]},"WSStockFormSearch":{"TextTotalRecords":"vehicle"},"WSStockDetail":{"IsShowCreditOneFinance":false,"CalcRepayHTML":null},"LengthMetricFormat":{"HasMeter":false,"HasFeet":false,"HasInch":false,"FeatUnit":" ft","InchUnit":"\"","MeterUnit":" m"},"IntLengthMetricFormat":{"HasMeter":false,"HasFeet":false,"HasInch":false,"FeatUnit":" ft","InchUnit":"\"","MeterUnit":" m"},"MinHeightMetricFormat":{"HasMeter":false,"HasFeet":false,"HasInch":false,"FeatUnit":" ft","InchUnit":"\"","MeterUnit":" m"},"TowLengthMetricFormat":{"HasMeter":false,"HasFeet":false,"HasInch":false,"FeatUnit":" ft","InchUnit":"\"","MeterUnit":" m"},"IsStockAuction":null,"IsShowPricePerWeek":false,"IsShowBiggestSaving":false,"IsShowDownloadDoc":true,"IsShowbtnFloorplan":true,"IsShowWasPrice":false,"IsShowDealerState":false,"IsShowDealerSuburb":false,"IsShowSaleStatus":false,"CondLocationInBacket":null,"TextIconBasket":null,"ListViewNumber":12,"ListViewExtension":"Index","DetailViewNumber":12,"ThanksViewNumber":null,"FormSearchViewNumber":null,"IsAngularView":true},"Route":{"RoutePrefix":"caravans-in-stock","ActionList":"Index","ActionDetail":"Detail","ActionCheckoutThanks":null,"TemplateUrlList":null,"TemplateUrlDetail":null,"TermAndCondition":null,"IsFilterIdEndPoint":false,"Mode":0},"CalculateRepayment":{"LoanAmount":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"InterestRate":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"Deposit":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"Residual":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"LoanLengthOrPeriod":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"LoanTerm":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"IsCheckWithVehType":false,"FinanceFees":null}}';
     }
     return $post_data;
 }

 
add_filter('filter_kratzmanncomau_car_data', 'filter_kratzmanncomau_car_data');

function filter_kratzmanncomau_car_data($car_data)
{
    if ($car_data['stock_type'] == 'demo') {
        $car_data['custom_1']     = "demo";
        $car_data['custom']     = "demo";
        
    } else {
        $car_data['custom_1'] = $car_data['stock_type'];
        $car_data['custom'] = $car_data['stock_type'];
    }

    return $car_data;
}

add_filter("filter_kratzmanncomau_field_images", "filter_kratzmanncomau_field_images");
    
function filter_kratzmanncomau_field_images($im_urls)
{
    slecho("Filtering Image Url");
    $filtered_im_url = str_replace("amp;","",$im_urls);
       
    return $filtered_im_url;
}