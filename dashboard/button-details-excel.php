<?php

//Create excel for export using php excel
error_reporting(E_ALL);
ini_set('display_errors', 1);

ini_set("include_path", '/home/spidri/php:' . ini_get("include_path"));

require_once 'vendor/php-excel/PHPExcel.php';
$spreadsheet = new PHPExcel();

//For Options tab
$spreadsheet->setActiveSheetIndex(0);

$style = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    )
);
$spreadsheet->getDefaultStyle()->applyFromArray($style);

$spreadsheet->getActiveSheet()->setTitle('Options');
$sheet1 = $spreadsheet->getActiveSheet();
//$spreadsheet->getActiveSheet()->getStyle('1:1')->getFont()->setName('Arial')->setSize(10)->setBold(true);
//$spreadsheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

$sheet1->getColumnDimension('A')->setAutoSize(true);
$sheet1->getColumnDimension('B')->setAutoSize(true);
$sheet1->getColumnDimension('C')->setAutoSize(true);
$sheet1->getColumnDimension('D')->setAutoSize(true);
$sheet1->getColumnDimension('E')->setAutoSize(true);
$sheet1->getColumnDimension('F')->setAutoSize(true);
$sheet1->getColumnDimension('G')->setAutoSize(true);
$sheet1->setCellValue('A1', 'Button option')->getStyle('A1')->getFont()->setBold(true);
$sheet1->setCellValue('B1', 'Option Group')->getStyle('B1')->getFont()->setBold(true);
$sheet1->setCellValue('C1', 'Viewed Count')->getStyle('C1')->getFont()->setBold(true);
$sheet1->setCellValue('D1', 'Clicked Count')->getStyle('D1')->getFont()->setBold(true);
$sheet1->setCellValue('E1', 'Fillup Count')->getStyle('E1')->getFont()->setBold(true);
$sheet1->setCellValue('F1', 'CR (clicked) %')->getStyle('F1')->getFont()->setBold(true);
$sheet1->setCellValue('G1', 'CR (fillup) %')->getStyle('G1')->getFont()->setBold(true);

$col = 'A';
$row = 2;
if (count($total_result_data) > 0) {
    foreach ($total_result_data as $item) {
        if ($item['total_viewed'] > 0) {
            $cr1 = @round($item['total_clicked'] / $item['total_viewed'], 4) * 100;
            $cr2 = @round($item['total_fillup'] / $item['total_form_viewed'], 4) * 100;
        } else {
            $cr1 = 0;
            $cr2 = 0;
        }

        $sheet1->setCellValue($col . $row, $item['option1']);
        $col++;
        $sheet1->setCellValue($col . $row, $item['option_group']);
        $col++;
        $sheet1->setCellValue($col . $row, $item['total_viewed']);
        $col++;
        $sheet1->setCellValue($col . $row, $item['total_clicked']);
        $col++;
        $sheet1->setCellValue($col . $row, $item['total_fillup']);
        $col++;
        $sheet1->setCellValue($col . $row, @number_format($cr1, 2));
        $col++;
        $sheet1->setCellValue($col . $row, @number_format($cr2, 2));
        $col++;

        $col = 'A';
        $row++;
    }
}


//For Buttons Tab
$spreadsheet->createSheet();
$spreadsheet->setActiveSheetIndex(1);
$spreadsheet->getActiveSheet()->setTitle('Buttons');
$sheet2 = $spreadsheet->getActiveSheet();
$sheet2->getDefaultColumnDimension()->setWidth(25);
$col = 'A';
$row = 1;



foreach ($buttons as $button => $button_status) {
    $sheet2->setCellValue($col . $row, 'Button: ' . $button)->getStyle($col . $row)->getFont()->setBold(true);
    $col = 'A';
    $row++;

    $sheet2->setCellValue($col . $row, 'Combination')->getStyle($col . $row)->getFont()->setBold(true);
    $col++;
    $sheet2->setCellValue($col . $row, 'Views')->getStyle($col . $row)->getFont()->setBold(true);
    $col++;
    $sheet2->setCellValue($col . $row, 'CR (click) %')->getStyle($col . $row)->getFont()->setBold(true);
    $col++;
    $sheet2->setCellValue($col . $row, 'CR (fillup) %')->getStyle($col . $row)->getFont()->setBold(true);
    $col = 'A';
    $row++;

    $sheet2->setCellValue($col . $row, 'Baseline');
    $col++;
    $sheet2->setCellValue($col . $row, isset($button_status['baseline_view']) ? $button_status['baseline_view'] : '0');
    $col++;
    $sheet2->setCellValue($col . $row, isset($button_status['baseline_cr1']) ? @number_format($button_status['baseline_cr1'], 2) : '0.00');
    $col++;
    $sheet2->setCellValue($col . $row, isset($button_status['baseline_cr2']) ? @number_format($button_status['baseline_cr2'], 2) : '0.00');
    $col = 'A';
    $row++;

    $sheet2->setCellValue($col . $row, 'Endline');
    $col++;
    $sheet2->setCellValue($col . $row, isset($button_status['endline_view']) ? $button_status['endline_view'] : '0');
    $col++;
    $sheet2->setCellValue($col . $row, isset($button_status['endline_cr1']) ? @number_format($button_status['endline_cr1'], 2) : '0.00');
    $col++;
    $sheet2->setCellValue($col . $row, isset($button_status['endline_cr2']) ? @number_format($button_status['endline_cr2'], 2) : '0.00');
    $col = 'A';
    $row++;


    $baseline_cr1 = isset($button_status['baseline_cr1']) ? @number_format($button_status['baseline_cr1'], 2) : 0.00;
    $baseline_cr2 = isset($button_status['baseline_cr2']) ? @number_format($button_status['baseline_cr2'], 2) : 0.00;
    $endline_cr1 = isset($button_status['endline_cr1']) ? @number_format($button_status['endline_cr1'], 2) : 0.00;
    $endline_cr2 = isset($button_status['endline_cr2']) ? @number_format($button_status['endline_cr2'], 2) : 0.00;
    $sheet2->setCellValue($col . $row, 'Improvement');
    $col++;
    $sheet2->setCellValue($col . $row, '');
    $col++;
    $sheet2->setCellValue($col . $row, @number_format($endline_cr1 - $baseline_cr1, 2));
    $col++;
    $sheet2->setCellValue($col . $row, @number_format($endline_cr2 - $baseline_cr2, 2));
    $col = 'A';
    $row += 3;
}


//For Page Tab
$spreadsheet->createSheet();
$spreadsheet->setActiveSheetIndex(2);
$spreadsheet->getActiveSheet()->setTitle('Pages');
$sheet3 = $spreadsheet->getActiveSheet();
$sheet3->getColumnDimension('A')->setAutoSize(true);
$sheet3->getColumnDimension('B')->setAutoSize(true);
$sheet3->getColumnDimension('C')->setAutoSize(true);
$sheet3->getColumnDimension('D')->setAutoSize(true);
$sheet3->getColumnDimension('E')->setAutoSize(true);
$sheet3->setCellValue('A1', 'Page Type')->getStyle('A1')->getFont()->setBold(true);
$sheet3->setCellValue('B1', 'Conversion Type')->getStyle('B1')->getFont()->setBold(true);
$sheet3->setCellValue('C1', 'Page View')->getStyle('C1')->getFont()->setBold(true);
$sheet3->setCellValue('D1', 'Click CR')->getStyle('D1')->getFont()->setBold(true);
$sheet3->setCellValue('E1', 'Fill-up CR')->getStyle('E1')->getFont()->setBold(true);
$col = 'A';
$row = 2;
if (count($page_data) > 0) {
    // VDP
    $sheet3->setCellValue($col . $row, 'VDP');
    $col++;
    $sheet3->setCellValue($col . $row, 'Baseline');
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['vdp']['baseline']['view']);
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['vdp']['baseline']['click']);
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['vdp']['baseline']['fillup']);
    $col = 'A';
    $row++;

    $sheet3->setCellValue($col . $row, 'VDP');
    $col++;
    $sheet3->setCellValue($col . $row, 'Endline');
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['vdp']['endline']['view']);
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['vdp']['endline']['click']);
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['vdp']['endline']['fillup']);
    $col = 'A';
    $row++;

    //SRP
    $sheet3->setCellValue($col . $row, 'SRP');
    $col++;
    $sheet3->setCellValue($col . $row, 'Baseline');
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['srp']['baseline']['view']);
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['srp']['baseline']['click']);
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['srp']['baseline']['fillup']);
    $col = 'A';
    $row++;

    $sheet3->setCellValue($col . $row, 'SRP');
    $col++;
    $sheet3->setCellValue($col . $row, 'Endline');
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['srp']['endline']['view']);
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['srp']['endline']['click']);
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['srp']['endline']['fillup']);
    $col = 'A';
    $row++;
}

//For Analysis Tab
$spreadsheet->createSheet();
$spreadsheet->setActiveSheetIndex(3);
$spreadsheet->getActiveSheet()->setTitle('Analysis');
$sheet4 = $spreadsheet->getActiveSheet();
$sheet4->getColumnDimension('A')->setAutoSize(true);
$sheet4->getColumnDimension('B')->setAutoSize(true);
$sheet4->getColumnDimension('C')->setAutoSize(true);
$sheet4->getColumnDimension('D')->setAutoSize(true);
$sheet4->getColumnDimension('E')->setAutoSize(true);
$sheet4->getColumnDimension('F')->setAutoSize(true);
$sheet4->getColumnDimension('G')->setAutoSize(true);
$sheet4->getColumnDimension('H')->setAutoSize(true);
$sheet4->getColumnDimension('I')->setAutoSize(true);
$sheet4->setCellValue('A1', 'Button')->getStyle('A1')->getFont()->setBold(true);
$sheet4->setCellValue('B1', 'Projected Clicks (With 100% Baseline)')->getStyle('B1')->getFont()->setBold(true);
$sheet4->setCellValue('C1', 'Actual Clicks')->getStyle('C1')->getFont()->setBold(true);
$sheet4->setCellValue('D1', 'Click Improve')->getStyle('D1')->getFont()->setBold(true);
$sheet4->setCellValue('E1', 'Click Improve(%)')->getStyle('E1')->getFont()->setBold(true);
$sheet4->setCellValue('F1', 'Projected Fill-ups (With 100% Baseline)')->getStyle('F1')->getFont()->setBold(true);
$sheet4->setCellValue('G1', 'Actual Fill-ups')->getStyle('G1')->getFont()->setBold(true);
$sheet4->setCellValue('H1', 'Fill-ups Improve')->getStyle('H1')->getFont()->setBold(true);
$sheet4->setCellValue('I1', 'Fill-ups Improve(%)')->getStyle('I1')->getFont()->setBold(true);
$col = 'A';
$row = 2;

$total_pclicks = 0;
$total_aclicks = 0;
$total_pfillups = 0;
$total_afillups = 0;

foreach ($buttons as $button => $button_status) {
    if (!$button) {
        continue;
    }

    $baseline_views = isset($button_status['baseline_view']) ? $button_status['baseline_view'] : 0;
    $endline_view = isset($button_status['endline_view']) ? $button_status['endline_view'] : 0;
    $baseline_clicks = isset($button_status['baseline_clicks']) ? $button_status['baseline_clicks'] : 0;
    $baseline_views = $baseline_views ? $baseline_views : 1;


    $total_views = $baseline_views + $endline_view;
    $projected_clicks = floor((($baseline_clicks / $baseline_views) * $total_views));
    $actual_clicks = $button_status['baseline_clicks'] + $button_status['endline_clicks'];
    $projected_fillups = floor((($button_status['baseline_fillups'] / $baseline_views) * $total_views));
    $actual_fillups = $button_status['baseline_fillups'] + $button_status['endline_fillups'];

    $total_pclicks += $projected_clicks;
    $total_aclicks += $actual_clicks;
    $total_pfillups += $projected_fillups;
    $total_afillups += $actual_fillups;

    $click_improve = $actual_clicks - $projected_clicks;
    $click_improve_percent = $projected_clicks ? round((($click_improve / $projected_clicks) * 100), 2) : 0;
    $fillups_improve = $actual_fillups - $projected_fillups;
    $fillups_improve_percent = $projected_fillups ? round((($fillups_improve / $projected_fillups) * 100), 2) : 0;

    $sheet4->setCellValue($col . $row, $button);
    $col++;
    $sheet4->setCellValue($col . $row, $projected_clicks);
    $col++;
    $sheet4->setCellValue($col . $row, $actual_clicks);
    $col++;
    $sheet4->setCellValue($col . $row, $click_improve);
    $col++;
    $sheet4->setCellValue($col . $row, $click_improve_percent);
    $col++;
    $sheet4->setCellValue($col . $row, $projected_fillups);
    $col++;
    $sheet4->setCellValue($col . $row, $actual_fillups);
    $col++;
    $sheet4->setCellValue($col . $row, $fillups_improve);
    $col++;
    $sheet4->setCellValue($col . $row, $fillups_improve_percent);
    $col = 'A';
    $row++;
}

$tclick_improve = $total_aclicks - $total_pclicks;
$tclick_improve_percent = $total_pclicks ? @round((($tclick_improve / $total_pclicks) * 100), 2) : 0;
$tfillups_improve = $total_afillups - $total_pfillups;
$tfillups_improve_percent = $total_pfillups ? @round((($tfillups_improve / $total_pfillups) * 100), 2) : 0;

$sheet4->setCellValue($col . $row, 'Total')->getStyle($col . $row)->getFont()->setBold(true);
$col++;
$sheet4->setCellValue($col . $row, $total_pclicks)->getStyle($col . $row)->getFont()->setBold(true);
$col++;
$sheet4->setCellValue($col . $row, $total_aclicks)->getStyle($col . $row)->getFont()->setBold(true);
$col++;
$sheet4->setCellValue($col . $row, $tclick_improve)->getStyle($col . $row)->getFont()->setBold(true);
$col++;
$sheet4->setCellValue($col . $row, $tclick_improve_percent)->getStyle($col . $row)->getFont()->setBold(true);
$col++;
$sheet4->setCellValue($col . $row, $total_pfillups)->getStyle($col . $row)->getFont()->setBold(true);
$col++;
$sheet4->setCellValue($col . $row, $total_afillups)->getStyle($col . $row)->getFont()->setBold(true);
$col++;
$sheet4->setCellValue($col . $row, $tfillups_improve)->getStyle($col . $row)->getFont()->setBold(true);
$col++;
$sheet4->setCellValue($col . $row, $tfillups_improve_percent)->getStyle($col . $row)->getFont()->setBold(true);

//For Optimization Tab
$spreadsheet->createSheet();
$spreadsheet->setActiveSheetIndex(4);
$spreadsheet->getActiveSheet()->setTitle('Optimization');
$sheet5 = $spreadsheet->getActiveSheet();
$sheet5->getColumnDimension('A')->setAutoSize(true);
$sheet5->getColumnDimension('B')->setAutoSize(true);
$sheet5->setCellValue('A1', 'Option Group')->getStyle('A1')->getFont()->setBold(true);
$sheet5->setCellValue('B1', 'Button option')->getStyle('B1')->getFont()->setBold(true);
$col = 'A';
$row = 2;

if (count($opt_data)) {
    foreach ($opt_data as $group => $item) {
        $sheet5->setCellValue($col . $row, $group);
        $col++;
        $sheet5->setCellValue($col . $row, $item['option']);
        $col = 'A';
        $row++;
    }
}

$objWriter = PHPExcel_IOFactory::createWriter($spreadsheet, 'Excel2007');
$objWriter->save(ADSYNCPATH . 'caches/button-details.xlsx');

//var_dump(extension_loaded('zip'));
//exit;