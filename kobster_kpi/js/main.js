CanvasJS.addColorSet("revenueChartColors", [
    //colorSet Array
    "#18ADED",
    "#F56F27",
    "#69CBC4",
    "#db1c11",
    "#9ca8a6",
    "#202436"       
    ]
);

function ticker() {
    $('#clock').html(moment().format('H:mm:ss A, MMMM D, YYYY'));
}
$(document).ready(function(){
    setTimeout(function(){ location.reload(); }, 100000);
    setInterval(ticker, 1000);
});

window.onload = function () {
    var dataPoints_chart1 = [];
    var dataPoints_chart2 = [];
    var dataPoints_chart3 = [];
    var dataPoints_chart4 = [];
    var dataPoints_chart5 = [];
    var dataPoints_chart6 = [];
    var dataPoints_chart7 = [];
    var totalValue = 0;
    $.getJSON("kpi_data.php?type=1", function(data) {  
        dataPoints_chart1.push({ label: data[0][0]['mon'], y: parseInt(data[0][0]['revenue']), indexLabel:"₹ "+CanvasJS.formatNumber((data[0][0]['revenue']), "#,##,###"), indexLabelFontFamily: "Inter UI", indexLabelFontColor: "#cccccc", indexLabelFontSize: 32});
        dataPoints_chart1.push({ label: data[0][1]['mon'], y: parseInt(data[0][1]['revenue']), indexLabel:"₹ "+CanvasJS.formatNumber((data[0][1]['revenue']), "#,##,###"), indexLabelFontFamily: "Inter UI", indexLabelFontColor: "#cccccc", indexLabelFontSize: 32});
        
        //fc revenue
        $.each(data[1], function(key, value){
            dataPoints_chart2.push({label: value['fc_name'], y: parseInt(value['revenue'])});
        });
        
        //rm revenue
        $.each(data[2], function(key, value){
            dataPoints_chart3.push({label: value['firstname'], y: parseInt(value['rm_revenue'])});
        });
        
        $.each(data[3], function(key, value) {
            totalValue += parseFloat(value['kam_revenue']);
        });
        
        $.each(data[3], function(key, value){
            dataPoints_chart7.push({label: value['firstname'], y: parseFloat(value['kam_revenue']), s: Math.round(parseFloat(value['kam_revenue']) / totalValue * 100)});
        });
        
        $.each(data[4], function(key, value){
            dataPoints_chart4.push({label: value['name'], y: parseInt(value['total_sales'])});
        });
        
        $.each(data[5], function(key, value){
            dataPoints_chart5.push({label: parseInt(value['achieved']), y: parseInt(value['target'])});
        });

        $.each(data[6], function(key, value){
            dataPoints_chart6.push({name: value['cat_name']+" ( ₹ "+CanvasJS.formatNumber((value['total_sales']), "#,##,###")+" )", y: parseInt(value['total_sales'])});
        });
        
        
        var chart1 = new CanvasJS.Chart("totalRevenueChart", {
            animationEnabled: true,
            colorSet: "revenueChartColors",
            title: {
                text: "Monthly Revenue",
                fontFamily: "Inter UI",
                fontSize: 22,
                fontWeight: 'normal',
                fontColor: '#555555'
            },
            axisX: {
                interval: 1,
                labelFontFamily: "Inter UI",
                labelFontSize: 16,
                gridThickness: 0,
                tickLength: 5,
                lineThickness: 1,
                valueFormatString: "#,##,###"
            },
            axisY: {
                title: "₹ RUPEES",
                titleFontFamily: "Inter UI",
                titleFontSize: 16,
                labelFontFamily: "Inter UI",
                labelFontSize: 16,
                gridThickness: 0,
                tickLength: 5,
                lineThickness: 1,
                labelAngle: 135
            },
            dataPointMinWidth: 60,
            dataPointMaxWidth: 90,
            data: [{
                type: "bar",
                yValueFormatString: "#,##,###",
                //indexLabelPlacement: "inside",
                dataPoints: dataPoints_chart1,
            }]
        });
        
        var chart2 = new CanvasJS.Chart("fcRevenue", {
            animationEnabled: true,
            colorSet: "revenueChartColors",
            title: {
                text: "FC Revenue",
                fontFamily: "Inter UI",
                fontSize: 22,
                fontWeight: 'normal',
                fontColor: '#555555'
            },
            axisX: {
                interval: 1,
                labelFontFamily: "Inter UI",
                labelFontSize: 16,
                gridThickness: 0,
                //tickLength: 0,
                lineThickness: 0,
                
            },
            axisY: {
                // title: "₹",
                // labelFontFamily: "Inter UI",
                // labelFontSize: 8,
                gridThickness: 0,
                tickLength: 0,
                lineThickness: 0,
                labelFormatter: function(){
                    return " ";
                }
            },
            data: [{        
                type: "column",  
                indexLabel: "₹ {y}",
                yValueFormatString: "#,##,###",
                indexLabelPlacement: "outside",  
                indexLabelOrientation: "horizontal",
                indexLabelFontFamily: "Inter UI",
                indexLabelFontSize: 12,
                dataPoints: dataPoints_chart2,
            }]
        });
        
        var chart3 = new CanvasJS.Chart("topCustomerRevenue", {
        animationEnabled: true,
        colorSet: "revenueChartColors",
        title: {
            text: "Top Customers Revenue",
            fontFamily: "Inter UI",
            fontSize: 22,
            fontWeight: 'normal',
            fontColor: '#555555'
        },
        axisX: {
            interval: 1,
            labelFontFamily: "Inter UI",
            labelFontSize: 12,
            gridThickness: 0,
            //tickLength: 0,
            lineThickness: 0,
            
        },
        axisY: {
            // title: "₹",
            // labelFontFamily: "Inter UI",
            // labelFontSize: 8,
            gridThickness: 0,
            tickLength: 0,
            lineThickness: 0,
            labelFormatter: function(){
                return " ";
            }
        },
        data: [{        
            type: "column",  
            indexLabel: "₹ {y}",
            yValueFormatString: "#,##,###",
            indexLabelPlacement: "outside",  
            indexLabelOrientation: "horizontal",
            indexLabelFontFamily: "Inter UI",
            indexLabelFontSize: 12,
            dataPoints: dataPoints_chart4
        }]
    });
    
        var chart4 = new CanvasJS.Chart("categoryRevenue", {
            animationEnabled: true,
            colorSet: "revenueChartColors",
            title: {
                text: "Top Categories Revenue",
                fontFamily: "Inter UI",
                fontSize: 22,
                fontWeight: 'normal',
                fontColor: '#555555'
            },
            legend: {
                verticalAlign: "center",
                horizontalAlign: "right",
                fontFamily: "Inter UI",
                fontSize: 13,
                //dockInsidePlotArea: true
            },
            axisX: {
                interval: 1,
                labelFontFamily: "Inter UI",
                labelFontSize: 12,
                gridThickness: 0,
                //tickLength: 0,
                lineThickness: 0,
                
            },
            axisY: {
                // title: "₹",
                // labelFontFamily: "Inter UI",
                // labelFontSize: 8,
                gridThickness: 0,
                tickLength: 0,
                lineThickness: 0,
                labelFormatter: function(){
                    return " ";
                }
            },
            data: [ 
                { 
                    type: "pie",
                    showInLegend: true,
                    // legendText: "{label}",
                    // indexLabel: "{y}%",
                    yValueFormatString: "#,##,###",
                    dataPoints: dataPoints_chart6,
                } 
            ] 
            
        });
    
        var chart5 = new CanvasJS.Chart("rmRevenue", {
            // animationEnabled: true,
            // colorSet: "revenueChartColors",
            // title: {
            //     text: "RM Revenue",
            //     fontFamily: "Inter UI",
            //     fontSize: 22,
            //     fontWeight: 'normal',
            //     fontColor: '#555555'
            // },
            // legend: {
            //     verticalAlign: "center",
            //     horizontalAlign: "right",
            //     fontFamily: "Inter UI",
            //     fontSize: 13,
            //     //dockInsidePlotArea: true
            // },
            // axisX: {
            //     interval: 1,
            //     labelFontFamily: "Inter UI",
            //     labelFontSize: 12,
            //     gridThickness: 0,
            //     //tickLength: 0,
            //     lineThickness: 0,
                
            // },
            // axisY: {
            //     // title: "₹",
            //     // labelFontFamily: "Inter UI",
            //     // labelFontSize: 8,
            //     gridThickness: 0,
            //     tickLength: 0,
            //     lineThickness: 0,
            //     labelFormatter: function(){
            //         return " ";
            //     }
            // },
            // data: [{
            //     type: "doughnut",
            //     //showInLegend: true,
            //     startAngle: 60,
            //     //indexLabelPlacement: "inside",
            //     //indexLabel: "{label}",
            //     indexLabelFontSize: 0,
            //     dataPoints: dataPoints_chart3
            // }]

            animationEnabled: true,
            colorSet: "revenueChartColors",
            title: {
                text: "RM Revenue",
                fontFamily: "Inter UI",
                fontSize: 22,
                fontWeight: 'normal',
                fontColor: '#555555'
            },
            axisX: {
                interval: 1,
                labelFontFamily: "Inter UI",
                labelFontSize: 16,
                gridThickness: 0,
                //tickLength: 0,
                lineThickness: 0,
                
            },
            axisY: {
                // title: "₹",
                // labelFontFamily: "Inter UI",
                // labelFontSize: 8,
                gridThickness: 0,
                tickLength: 0,
                lineThickness: 0,
                labelFormatter: function(){
                    return " ";
                }
            },
            data: [{        
                type: "column",  
                indexLabel: "₹ {y}",
                yValueFormatString: "#,##,###",
                indexLabelPlacement: "outside",  
                indexLabelOrientation: "horizontal",
                indexLabelFontFamily: "Inter UI",
                indexLabelFontSize: 12,
                dataPoints: dataPoints_chart3,
            }]
            
        });
    
        var chart6 = new CanvasJS.Chart("kamRevenue", {
            // animationEnabled: true,
            // colorSet: "revenueChartColors",
            // title: {
            //     text: "KAM Revenue",
            //     fontFamily: "Inter UI",
            //     fontSize: 22,
            //     fontWeight: 'normal',
            //     fontColor: '#555555'
            // },
            // legend: {
            //     verticalAlign: "center",
            //     horizontalAlign: "right",
            //     fontFamily: "Inter UI",
            //     fontSize: 13,
            //     //dockInsidePlotArea: true
            // },
            // axisX: {
            //     interval: 1,
            //     labelFontFamily: "Inter UI",
            //     labelFontSize: 12,
            //     gridThickness: 0,
            //     //tickLength: 0,
            //     lineThickness: 0,
                
            // },
            // axisY: {
            //     // title: "₹",
            //     // labelFontFamily: "Inter UI",
            //     // labelFontSize: 8,
            //     gridThickness: 0,
            //     tickLength: 0,
            //     lineThickness: 0,
            //     labelFormatter: function(){
            //         return " ";
            //     }
            // },
            // data: [ 
            //     { 
            //         type: "pie",
            //         showInLegend: true,
            //         //indexLabel: "{name} - {y}%",
            //         dataPoints: dataPoints_chart7
            //     } 
            // ]
            
            animationEnabled: true,
            colorSet: "revenueChartColors",
            title: {
                text: "KAM Revenue",
                fontFamily: "Inter UI",
                fontSize: 22,
                fontWeight: 'normal',
                fontColor: '#555555'
            },
            axisX: {
                interval: 1,
                labelFontFamily: "Inter UI",
                labelFontSize: 16,
                gridThickness: 0,
                //tickLength: 0,
                lineThickness: 0,
                
            },
            axisY: {
                // title: "₹",
                // labelFontFamily: "Inter UI",
                // labelFontSize: 8,
                gridThickness: 0,
                tickLength: 0,
                lineThickness: 0,
                labelFormatter: function(){
                    return " ";
                }
            },
            data: [{        
                type: "column",  
                indexLabel: "{s}%",
                yValueFormatString: "#,##,###",
                indexLabelPlacement: "outside",  
                indexLabelOrientation: "horizontal",
                indexLabelFontFamily: "Inter UI",
                indexLabelFontSize: 12,
                dataPoints: dataPoints_chart7,
            }]
            
        });
    chart1.render();
    chart2.render();
    chart3.render();
    chart4.render();
    chart5.render();
    chart6.render();
        
    });
    
    $.getJSON("kpi_data.php?type=2", function(data) {  
        $('#active_companies').html(data[0][0]['companies_count']);
        $('#active_customer').html(data[1][0]['user_count']);
        $('#new_customers').html(data[2][0]['new_customer']);
        
        $('#adt').html(data[3][0]['adt_hours']);
        
        $('#adt_1_name').html(data[4][0]['fc_name']);
        $('#adt_1').html(data[4][0]['adt_hours']);
        
        $('#adt_2_name').html(data[4][1]['fc_name']);
        $('#adt_2').html(data[4][1]['adt_hours']);
        
        $('#adt_3_name').html(data[4][2]['fc_name']);
        $('#adt_3').html(data[4][2]['adt_hours']);
        
        $('#adt_4_name').html(data[4][3]['fc_name']);
        $('#adt_4').html(data[4][3]['adt_hours']);
        
        $('#adt_5_name').html(data[4][4]['fc_name']);
        $('#adt_5').html(data[4][4]['adt_hours']);
        
        $('#ord_pending_count_ops').html(data[5][0]['pending_ops']);
        $('#ord_pending_count_scn').html(data[6][0]['pending_cat']);
        $('#ord_pending_count_fin').html(data[7][0]['pending_finance']);
        $('#ord_pending_count_rm').html(data[8][0]['pending_rm']);
        $('#tot_ord_pending_count').html(parseInt(data[5][0]['pending_ops'])+parseInt(data[6][0]['pending_cat'])+parseInt(data[7][0]['pending_finance'])+parseInt(data[8][0]['pending_rm']));
        
        $('#dso').html(data[9][0]['dso']);
        $('#fin_receivables').html(data[10][0]['total_receivables']);
        $('#fin_payables').html(data[11][0]['total_payables']);
    });
    $.getJSON("kpi_data.php?type=3", function(data) {
        $('#active_products').html(data[0][0]['active_products']);
        $('#active_brands').html(data[1][0]['active_brands']);
        $('#oos').html(data[2][0]['total_oos']);
        $('#new_vendors').html(data[5][0]['new_vendors']);
        $('#total_vendors').html(data[3][0]['total_vendors']);
        $('#active_vendors').html(data[4][0]['current_vendors']);
        $('#achieved').html(data[6][0]['achieved']);
        $('#target').html(data[6][0]['target']);
        var percentage = ((parseInt(data[6][0]['achieved'].replace(/,/gi,''))/parseInt(data[6][0]['target'].replace(/,/gi,''))) * 100).toFixed(2);
        $('#revenuePercent').html(percentage);
        $('#progressBar').css(
            'width', (percentage + "%")
        );
    });
}