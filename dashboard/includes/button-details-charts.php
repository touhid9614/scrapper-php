
<script type="text/javascript">
    $(document).ready(function () {

        var xAxisCat = JSON.parse('<?= $chartLabel; ?>');
        console.log("baselineViewedVdpData=" + JSON.parse('<?= $baselineViewedVdpData; ?>'));
        console.log("baselineViewedVdpData=" + JSON.parse('<?= $endlineViewedVdpData; ?>'));

        createLineBasicChart('details-chart-vdpcr1', 'VDP Clicked', '', 'Clicked(%)', xAxisCat, 'Baseline', JSON.parse('<?= $baselineCR1VdpData; ?>'), 'Endline', JSON.parse('<?= $endlineCR1VdpData; ?>'));
        createLineBasicChart('details-chart-vdpcr2', 'VDP Fill-Up', '', 'Fill-Up(%)', xAxisCat, 'Baseline', JSON.parse('<?= $baselineCR2VdpData; ?>'), 'Endline', JSON.parse('<?= $endlineCR2VdpData; ?>'));
        createLineBasicChart('details-chart-vdpviewed', 'VDP Viewed', '', 'Viewed', xAxisCat, 'Baseline', JSON.parse('<?= $baselineViewedVdpData; ?>'), 'Endline', JSON.parse('<?= $endlineViewedVdpData; ?>'));

        createLineBasicChart('details-chart-sipcr1', 'SRP Clicked', '', 'Clicked(%)', xAxisCat, 'Baseline', JSON.parse('<?= $baselineCR1SipData; ?>'), 'Endline', JSON.parse('<?= $endlineCR1SipData; ?>'));
        createLineBasicChart('details-chart-sipcr2', 'SRP Fill-Up', '', 'Fill-Up(%)', xAxisCat, 'Baseline', JSON.parse('<?= $baselineCR2SipData; ?>'), 'Endline', JSON.parse('<?= $endlineCR2SipData; ?>'));
        createLineBasicChart('details-chart-sipviewed', 'SRP Viewed', '', 'Viewed', xAxisCat, 'Baseline', JSON.parse('<?= $baselineViewedSipData; ?>'), 'Endline', JSON.parse('<?= $endlineViewedSipData; ?>'));


        function createLineBasicChart(div_id, title, subtitle, yAxisTitle, xAxisCat, seriesName1, seriesData1, seriesName2, seriesData2) {

            Highcharts.chart(div_id, {
                chart: {
                    backgroundColor: '#e7e8de'
                },
                title: {
                    text: title
                },
                subtitle: {
                    text: subtitle
                },
                yAxis: {
                    title: {
                        text: yAxisTitle
                    }
                },
                xAxis: {
                    categories: xAxisCat
                },
                legend: {
                    layout: 'horizontal',
                    backgroundColor: '#FFFFFF',
                    floating: true,
                    align: 'left',
                    x: 0,
                    verticalAlign: 'top',
                    y: 0
                },
                tooltip: {

                },
                series: [{
                        name: seriesName1,
                        data: seriesData1
                    }, {
                        name: seriesName2,
                        data: seriesData2
                    }],
                responsive: {
                    rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                }

            });
        }

    });



    $("#date_range").change(function () {
        if (this.value == "custom") {
            $("#custom_date_range").show();
        } else {
            $("#custom_date_range").hide();
        }
    });


</script>