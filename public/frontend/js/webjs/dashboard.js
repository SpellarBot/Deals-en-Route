/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
  
    
        // <--=============================Line Chart=============================-->
 
         
                var dataWeekly = {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'],
                    series: [
                        [25, 50, 100, 80, 75]
                    ]
                };
                var optionsWeekly = {
                    showPoint: true,
                    lineSmooth: true,
                    height: "320px",
                    axisX: {
                        showGrid: false,
                        showLabel: true
                    },
                    axisY: {
                        offset: 40,
                    },
                    low: 0,
                    high: 'auto',
                    height: "320px"
                };
                var line2 = Chartist.Line('#chartWeekly', dataWeekly, optionsWeekly);

                var dataMonthly = {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    series: [
                        [10, 40, 100, 80, 75, 90, 10, 40, 100, 80, 75, 105]
                    ]
                };
                var optionsMonthly = {
                    showPoint: true,
                    lineSmooth: true,
                    height: "320px",
                    axisX: {
                        showGrid: false,
                        showLabel: true
                    },
                    axisY: {
                        offset: 40,
                    },
                    low: 0,
                    high: 'auto',
                    height: "320px"
                };

                var line1 = Chartist.Line('#chartMonthly', dataMonthly, optionsMonthly);

                $('a[data-toggle="tab"]').on('shown.bs.tab', function (event) {
                    line1.update();
                    line2.update();
                });
           


        // <!--=============================Pie Chart=============================-->

            $('#chartunder18').easyPieChart({
                lineWidth: 4,
                size: 70,
                scaleColor: false,
                trackColor: 'rgba(57,89,153,.25)',
                barColor: '#395999',
                animate: ({
                    duration: 5000,
                    enabled: true
                })

            });

            $('#chart18-34').easyPieChart({
                lineWidth: 4,
                size: 70,
                scaleColor: false,
                trackColor: 'rgba(244,235,102,.25)',
                barColor: '#f4eb66',
                animate: ({
                    duration: 5000,
                    enabled: true
                })

            });

            $('#chart35-50').easyPieChart({
                lineWidth: 4,
                size: 70,
                scaleColor: false,
                trackColor: 'rgba(70,185,109,.25)',
                barColor: '#46b96d',
                animate: ({
                    duration: 5000,
                    enabled: true
                })

            });

            $('#chartabove50').easyPieChart({
                lineWidth: 4,
                size: 70,
                scaleColor: false,
                trackColor: 'rgba(79,168,222,.25)',
                barColor: '#4fa8de',
                animate: ({
                    duration: 5000,
                    enabled: true
                })

            });

            $('#charttotal').easyPieChart({
                lineWidth: 12,
                size: 200,
                scaleColor: false,
                trackColor: 'rgba(70,85,109,.25)',
                barColor: '#46b96d',
                animate: ({
                    duration: 5000,
                    enabled: true
                })

            });

        

        // <!--=============================Bar Chart=============================-->
        $.ajax({ 
        url: "vendor/dashboard",
        success: function(data){
        console.log(data.data.total_redeem_monthly);
     var player = [];
			var score = [];

			for(var i in data.data.total_redeem_monthly) {
		
				score.push(data.data.total_redeem_monthly.score);
			}
                        
           var data = { 
               labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
           series:[score]
            };            
           var data1 = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                series: [
                    [5, 120, 120, 120, 120, 120, 120, 120, 120, 120, 120, 120],
                    [5, 320, 350, 300, 250, 325, 320, 350, 300, 250, 350, 250],
                    [240, 240, 240, 240, 240, 240, 240, 240, 240, 240, 240, 240]
                ],
            };

            var options = {
                seriesBarDistance: 15,
                axisX: {
                    showGrid: false
                },
                height: "250px"
            };

            var responsiveOptions = [
                ['screen and (max-width: 767px)', {
                        seriesBarDistance: 8,
                        axisX: {
                            labelInterpolationFnc: function (value) {
                                return value[0];
                            }
                        }
                    }]
            ];

            var bar1 = Chartist.Bar('#chartCoupons', data, options, responsiveOptions);
            
        },
        error: function(xhr, status, error){
            var err = eval("(" + xhr.responseText + ")");
            console.log(err);
        }
    });
            
            

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (event) {
                bar1.update();
            });


});

