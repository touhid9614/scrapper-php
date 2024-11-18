<?php
global $scrapper_configs;
$scrapper_configs["georgedaycomau"] = array( 
	'entry_points' => array(
        'new' => 'https://www.georgeday.com.au/Stock/WSStockAngular/GetStockList',
        'used' => 'https://www.georgeday.com.au/Stock/WSStockAngular/GetStockList',
    ),
    'vdp_url_regex' => '/\/Detail\//i',
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
               // 'stock_type' => strtolower($obj->sale_class),
                'year' => $obj->ModelYear,
                'make' => $obj->Make,
                'model' => $obj->Model,
              //'trim' => $obj->trim,
                'body_style' => $obj->Variant,
                'price' => $obj->AskingPrice ,
                //'engine' => $obj->engine,
//                'transmission' => $obj->Transmission,
//                'kilometres' => $obj->Odometer,
//                'vin' => $obj->VIN,
//                'fuel_type' => $obj->fuel_type,
//                'drivetrain' => $obj->drive_train,
//                'msrp' => $obj->msrp,
                'url' => "https://www.georgeday.com.au/" .  $obj->UrlDetail,
               
//                'exterior_color' => $obj->exterior_color,
//                'interior_color' => $obj->interior_color,
                'all_images' => $obj->image->image_original,
                'title' => $obj->VehicleInfo,
            );

            $imgs=[];
            
            foreach($obj->StockImages as $key=>$value){
                    
                      $imgs[]="https:" . $value->Url;
  
            }
            $car_data['all_images']=implode("|",$imgs);

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    
);

 add_filter('filter_georgedaycomau_post_data', 'filter_georgedaycomau_post_data', 10, 2);
 function filter_georgedaycomau_post_data($post_data, $stock_type)
 {

     if ($stock_type == 'new') {
         $post_data = '{"Area":"Stock","FilterId":"9ca422886a","IsSEO":false,"StockFilter":{"WebsiteId":303,"PageNumber":1,"PageSize":73,"Branch":null,"Cylinders":null,"SoldDay":null,"Sleep":null,"Berth":null,"AuctionId":null,"IsLAMS":null,"IsSelectedAllVariant":null,"DealerNo":null,"State":null,"SearchText":null,"SearchType":"all","StockNumber":null,"Class":null,"Type":"NEW,DEMO","Keyword":"","Make":null,"Model":null,"Body":"1-axle,2-axle,","Variant":",camper,camper-trailer,caravan,motorhome,pop-top","Series":null,"FuelType":null,"Colour":null,"Transmission":null,"TransmissionType":null,"ReleaseStatus":null,"ANCAPSafetyRating":null,"GreenStarRating":null,"CaravanConcept":null,"SortBy":"stock_number","AuctionLoginOption":null,"SoldFilter":null,"YearFilter":null,"PriceFilter":{"PriceType":null,"PriceTypeEnum":null,"Min":null,"Max":185000,"Step":5000,"Ceil":null,"Floor":null},"PricePerWeekFilter":null,"ATMWeightFilter":{"Min":null,"Max":3500,"Step":1,"Ceil":null,"Floor":null},"BallWeightFilter":{"Min":null,"Max":274,"Step":1,"Ceil":null,"Floor":null},"LengthMetricFilter":{"Min":null,"Max":9,"Step":1,"Ceil":null,"Floor":null},"TareWeightFilter":{"Min":null,"Max":3010,"Step":1,"Ceil":null,"Floor":null},"TowLengthMetricFilter":null,"OdometerFilter":null,"EngineSizeLiter":null,"EngineSizeCCFilter":null,"DoorFilter":null,"SeatFilter":null,"SleepFilter":{"Min":null,"Max":0,"Step":1,"Ceil":null,"Floor":null},"PageSizes":null,"LengthFeetFilter":{"Min":0,"Max":30,"Step":3,"Ceil":null,"Floor":null}},"StockFilterSetup":{"WebsiteId":303,"PageNumber":1,"PageSize":12,"Branch":null,"Cylinders":null,"SoldDay":null,"Sleep":null,"Berth":null,"AuctionId":null,"IsLAMS":null,"IsSelectedAllVariant":null,"DealerNo":null,"State":null,"SearchText":null,"SearchType":"all","StockNumber":null,"Class":null,"Type":"NEW","Keyword":null,"Make":null,"Model":null,"Body":null,"Variant":"CARAVAN,MOTORHOME,CAMPER,POP TOP,CAMPER TRAILER,POPTOP,1800 TOURER C4 LTD,MK 11","Series":null,"FuelType":null,"Colour":null,"Transmission":null,"TransmissionType":null,"ReleaseStatus":null,"ANCAPSafetyRating":null,"GreenStarRating":null,"CaravanConcept":null,"SortBy":"make","AuctionLoginOption":null,"SoldFilter":null,"YearFilter":null,"PriceFilter":null,"PricePerWeekFilter":null,"ATMWeightFilter":null,"BallWeightFilter":null,"LengthMetricFilter":null,"TareWeightFilter":null,"TowLengthMetricFilter":null,"OdometerFilter":null,"EngineSizeLiter":null,"EngineSizeCCFilter":null,"DoorFilter":null,"SeatFilter":null,"SleepFilter":null,"PageSizes":null},"FilterOptions":{"Make":true,"Model":true,"YearFilter":true,"PriceFilter":true,"Body":true,"Variant":true,"Type":false,"Class":false,"ReleaseStatus":false,"AuctionLoginOption":false,"StockNumber":true,"SearchText":false,"Branch":false,"PricePerWeek":false,"EngineSizeCC":true},"ViewOption":{"WSStockSpec":{"MaxDisplayColumn":4,"WSStockSpecColumns":[{"FieldName":"Sleep","Label":"Sleeps","ClassName":"vehicleList-Sleeps","Value":null},{"FieldName":"Tare","Label":"Tare","ClassName":"vehicleList-Tare","Value":null},{"FieldName":"BallWeight","Label":"Ball Weight","ClassName":"vehicleList-Ball","Value":null},{"FieldName":"LengthMetric","Label":"Length","ClassName":"vehicleList-Length","Value":null},{"FieldName":"StockNumber","Label":"Stock#","ClassName":"vehicleList-Stock","Value":null}]},"WSStockFormSearch":{"TextTotalRecords":"vehicle"},"WSStockDetail":{"IsShowCreditOneFinance":false,"CalcRepayHTML":null},"LengthMetricFormat":{"HasMeter":false,"HasFeet":false,"HasInch":false,"FeatUnit":" ft","InchUnit":"\"","MeterUnit":" m"},"IntLengthMetricFormat":{"HasMeter":false,"HasFeet":false,"HasInch":false,"FeatUnit":" ft","InchUnit":"\"","MeterUnit":" m"},"MinHeightMetricFormat":{"HasMeter":false,"HasFeet":false,"HasInch":false,"FeatUnit":" ft","InchUnit":"\"","MeterUnit":" m"},"TowLengthMetricFormat":{"HasMeter":false,"HasFeet":false,"HasInch":false,"FeatUnit":" ft","InchUnit":"\"","MeterUnit":" m"},"IsStockAuction":null,"IsShowPricePerWeek":false,"IsShowBiggestSaving":false,"IsShowDownloadDoc":false,"IsShowbtnFloorplan":false,"IsShowWasPrice":false,"IsShowDealerState":false,"IsShowDealerSuburb":false,"IsShowSaleStatus":true,"CondLocationInBacket":null,"TextIconBasket":null,"ListViewNumber":10,"ListViewExtension":"Index","DetailViewNumber":12,"ThanksViewNumber":null,"FormSearchViewNumber":null,"IsAngularView":true},"Route":{"RoutePrefix":"caravans-in-stock","ActionList":"Index","ActionDetail":"Detail","ActionCheckoutThanks":null,"TemplateUrlList":null,"TemplateUrlDetail":null,"TermAndCondition":null,"IsFilterIdEndPoint":false,"Mode":0},"CalculateRepayment":{"LoanAmount":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"InterestRate":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"Deposit":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"Residual":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"LoanLengthOrPeriod":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"LoanTerm":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"IsCheckWithVehType":false,"FinanceFees":null}}';
     } elseif ($stock_type == 'used') {
         $post_data = '{"Area":"Stock","FilterId":"f44b1a2336","IsSEO":false,"StockFilter":{"WebsiteId":303,"PageNumber":1,"PageSize":29,"Branch":null,"Cylinders":null,"SoldDay":null,"Sleep":null,"Berth":null,"AuctionId":null,"IsLAMS":null,"IsSelectedAllVariant":null,"DealerNo":null,"State":null,"SearchText":null,"SearchType":"all","StockNumber":null,"Class":null,"Type":"USED","Keyword":"","Make":null,"Model":null,"Body":"1-axle,2-axle,","Variant":",1800-tourer-c4-ltd,camper,caravan,mk-11,motorhome,poptop","Series":null,"FuelType":null,"Colour":null,"Transmission":null,"TransmissionType":null,"ReleaseStatus":null,"ANCAPSafetyRating":null,"GreenStarRating":null,"CaravanConcept":null,"SortBy":"stock_number","AuctionLoginOption":null,"SoldFilter":null,"YearFilter":null,"PriceFilter":{"PriceType":null,"PriceTypeEnum":null,"Min":null,"Max":115000,"Step":5000,"Ceil":null,"Floor":null},"PricePerWeekFilter":null,"ATMWeightFilter":{"Min":null,"Max":4000,"Step":1,"Ceil":null,"Floor":null},"BallWeightFilter":{"Min":null,"Max":0,"Step":1,"Ceil":null,"Floor":null},"LengthMetricFilter":{"Min":null,"Max":1,"Step":1,"Ceil":null,"Floor":null},"TareWeightFilter":{"Min":null,"Max":3180,"Step":1,"Ceil":null,"Floor":null},"TowLengthMetricFilter":null,"OdometerFilter":null,"EngineSizeLiter":null,"EngineSizeCCFilter":null,"DoorFilter":null,"SeatFilter":null,"SleepFilter":{"Min":null,"Max":0,"Step":1,"Ceil":null,"Floor":null},"PageSizes":null,"LengthFeetFilter":{"Min":0,"Max":3,"Step":3,"Ceil":null,"Floor":null}},"StockFilterSetup":{"WebsiteId":303,"PageNumber":1,"PageSize":12,"Branch":null,"Cylinders":null,"SoldDay":null,"Sleep":null,"Berth":null,"AuctionId":null,"IsLAMS":null,"IsSelectedAllVariant":null,"DealerNo":null,"State":null,"SearchText":null,"SearchType":"all","StockNumber":null,"Class":null,"Type":"USED","Keyword":null,"Make":null,"Model":null,"Body":null,"Variant":"CARAVAN,MOTORHOME,CAMPER,POP TOP,CAMPER TRAILER,POPTOP,1800 TOURER C4 LTD,MK 11","Series":null,"FuelType":null,"Colour":null,"Transmission":null,"TransmissionType":null,"ReleaseStatus":null,"ANCAPSafetyRating":null,"GreenStarRating":null,"CaravanConcept":null,"SortBy":"make","AuctionLoginOption":null,"SoldFilter":null,"YearFilter":null,"PriceFilter":null,"PricePerWeekFilter":null,"ATMWeightFilter":null,"BallWeightFilter":null,"LengthMetricFilter":null,"TareWeightFilter":null,"TowLengthMetricFilter":null,"OdometerFilter":null,"EngineSizeLiter":null,"EngineSizeCCFilter":null,"DoorFilter":null,"SeatFilter":null,"SleepFilter":null,"PageSizes":null},"FilterOptions":{"Make":true,"Model":true,"YearFilter":true,"PriceFilter":true,"Body":true,"Variant":true,"Type":false,"Class":false,"ReleaseStatus":false,"AuctionLoginOption":false,"StockNumber":true,"SearchText":false,"Branch":false,"PricePerWeek":false,"EngineSizeCC":true},"ViewOption":{"WSStockSpec":{"MaxDisplayColumn":4,"WSStockSpecColumns":[{"FieldName":"Sleep","Label":"Sleeps","ClassName":"vehicleList-Sleeps","Value":null},{"FieldName":"Tare","Label":"Tare","ClassName":"vehicleList-Tare","Value":null},{"FieldName":"BallWeight","Label":"Ball Weight","ClassName":"vehicleList-Ball","Value":null},{"FieldName":"LengthMetric","Label":"Length","ClassName":"vehicleList-Length","Value":null},{"FieldName":"StockNumber","Label":"Stock#","ClassName":"vehicleList-Stock","Value":null}]},"WSStockFormSearch":{"TextTotalRecords":"vehicle"},"WSStockDetail":{"IsShowCreditOneFinance":false,"CalcRepayHTML":null},"LengthMetricFormat":{"HasMeter":false,"HasFeet":false,"HasInch":false,"FeatUnit":" ft","InchUnit":"\"","MeterUnit":" m"},"IntLengthMetricFormat":{"HasMeter":false,"HasFeet":false,"HasInch":false,"FeatUnit":" ft","InchUnit":"\"","MeterUnit":" m"},"MinHeightMetricFormat":{"HasMeter":false,"HasFeet":false,"HasInch":false,"FeatUnit":" ft","InchUnit":"\"","MeterUnit":" m"},"TowLengthMetricFormat":{"HasMeter":false,"HasFeet":false,"HasInch":false,"FeatUnit":" ft","InchUnit":"\"","MeterUnit":" m"},"IsStockAuction":null,"IsShowPricePerWeek":false,"IsShowBiggestSaving":false,"IsShowDownloadDoc":false,"IsShowbtnFloorplan":false,"IsShowWasPrice":false,"IsShowDealerState":false,"IsShowDealerSuburb":false,"IsShowSaleStatus":true,"CondLocationInBacket":null,"TextIconBasket":null,"ListViewNumber":10,"ListViewExtension":"Index","DetailViewNumber":12,"ThanksViewNumber":null,"FormSearchViewNumber":null,"IsAngularView":true},"Route":{"RoutePrefix":"caravans-in-stock","ActionList":"Index","ActionDetail":"Detail","ActionCheckoutThanks":null,"TemplateUrlList":null,"TemplateUrlDetail":null,"TermAndCondition":null,"IsFilterIdEndPoint":false,"Mode":0},"CalculateRepayment":{"LoanAmount":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"InterestRate":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"Deposit":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"Residual":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"LoanLengthOrPeriod":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"LoanTerm":{"Value":null,"Min":null,"Max":null,"Step":null,"Ceil":null,"Floor":null},"IsCheckWithVehType":false,"FinanceFees":null}}';
     }

     return $post_data;
 }
