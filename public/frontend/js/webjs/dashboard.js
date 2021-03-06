var redeem_weekly = '';
var redeem_monthly = '';
var monthlabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
var weekslabels = ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'];
var bar1='';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    if (localStorage.getItem("Redeemstatus"))
    {

        setDashboardNotification(JSON.parse(localStorage.getItem("Redeemstatus")));
        localStorage.clear();
    }

    var TodayDate = new Date();
    $('#chartm1').val(TodayDate.getMonth() + 1);
    $('#charty1,#charty').val(TodayDate.getFullYear());
    // <--=============================Line Chart=============================-->

    var dataMonthly = {
        labels: monthlabels,
        series: []
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
            onlyInteger: true,
            offset: 40,
        },
        low: 0,
        high: 'auto',
        height: "320px"
    };
    redeem_monthly = Chartist.Line('#chartMonthly', dataMonthly, optionsMonthly);



    var dataWeekly = {
        labels: '',
        series: []
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
            onlyInteger: true,
            offset: 40,
        },
        low: 0,
        high: 'auto',
    };
    redeem_weekly = Chartist.Line('#chartWeekly', dataWeekly, optionsWeekly);
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
    $('#chartmale').easyPieChart({
        lineWidth: 4,
        size: 70,
        scaleColor: false,
        trackColor: 'rgba(70,185,109,.25)',
        barColor: '#4fa8de',
        animate: ({
            duration: 5000,
            enabled: true
        })

    });
    $('#chartfemale').easyPieChart({
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
        lineWidth: 7,
        size: 130,
        scaleColor: false,
        trackColor: 'rgba(70,85,109,.25)',
        barColor: '#46b96d',
        animate: ({
            duration: 5000,
            enabled: true
        })

    });
    $('#geofencingtotal').easyPieChart({
        lineWidth: 7,
        size: 130,
        scaleColor: false,
        trackColor: 'rgba(70,85,109,.25)',
        barColor: '#46b96d',
        animate: ({
            duration: 5000,
            enabled: true
        })

    });

    $('#dealtotal').easyPieChart({
        lineWidth: 7,
        size: 130,
        scaleColor: false,
        trackColor: 'rgba(70,85,109,.25)',
        barColor: '#46b96d',
        animate: ({
            duration: 5000,
            enabled: true
        })

    });
    $('#geolocationtotal').easyPieChart({
        lineWidth: 7,
        size: 130,
        scaleColor: false,
        trackColor: 'rgba(70,85,109,.25)',
        barColor: '#46b96d',
        animate: ({
            duration: 5000,
            enabled: true
        })

    });
    $.ajax({
        url: "vendor/dashboard",
        success: function (data) {

            var total_redeem_monthly = [];
            var total_coupon_monthly = [];
            var total_active_coupon_monthly = [];
            var total_redeem_weekly = [];
            var total_coupon_reedemed = data.data.total_coupon_reedemed;
            var redeem_by_18_below_per = data.data.redeem_by_18_below_per;
            var redeem_by_18_below = data.data.redeem_by_18_below;
            var redeem_by_18_34_per = data.data.redeem_by_18_34_per;
            var redeem_by_18_34 = data.data.redeem_by_18_34;
            var redeem_by_35_50_per = data.data.redeem_by_35_50_per;
            var redeem_by_35_50 = data.data.redeem_by_35_50;
            var redeem_by_above_50_per = data.data.redeem_by_above_50_per;
            var redeem_by_above_50 = data.data.redeem_by_above_50;
            var deals_left = data.data.deals_left;
            var deals_percent = data.data.deals_percent;
            var redeem_by_male=data.data.redeem_by_male;
            var redeem_by_female=data.data.redeem_by_female;
            var redeem_by_male_total=data.data.redeem_by_male_total;
            var redeem_by_female_total=data.data.redeem_by_female_total;
            var additionalgeofencing=data.data.total_additional_fencing_left;
            var additionalgeofencing_percent=data.data.total_additional_fencing_left_per;
             var additionalgeolocation=data.data.total_additional_location_left;
            var additionalgeolocation_percent=data.data.total_additional_location_left_per;
            // <!--=============================Bar Chart=============================-->
            // total redeeem monthly 
            $.each(data.data.total_redeem_monthly, function (index, value) {
                total_redeem_monthly.push(value);
            });
            $.each(data.data.total_coupon_monthly, function (index, value) {
                total_coupon_monthly.push(value);
            });
            $.each(data.data.total_active_coupon_monthly, function (index, value) {
                total_active_coupon_monthly.push(value);
            });
            $.each(data.data.total_redeem_weekly, function (index, value) {
                total_redeem_weekly.push(value);
            });
            var output = [total_redeem_monthly, total_coupon_monthly, total_active_coupon_monthly];
            var data = {
                labels: monthlabels,
                series: output
            };
            var options = {
                seriesBarDistance: 15,
                axisX: {
                    showGrid: false
                },
                axisY: {
                    onlyInteger: true,
                },
                height: "160px",
                low: 0,
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
            bar1 = Chartist.Bar('#chartCoupons', data, options, responsiveOptions);

            // <!--================Redeemption Pie Chart=============================-->
            //total coupon redeemed
            $('#charttotal').data('easyPieChart').update(total_coupon_reedemed);
            $('span', $('#charttotal')).text(total_coupon_reedemed + "%");
            //remaining deals in package
            $('#dealtotal').data('easyPieChart').update(deals_percent);
            $('span', $('#dealtotal')).text(deals_left);
            // <!--================Other Pie Chart=============================-->
            // less than 18
            $('#chartunder18').data('easyPieChart').update(redeem_by_18_below_per);
            $('span', $('#chartunder18')).text(redeem_by_18_below_per + "%");
            $('.coupon-redemption1').text(redeem_by_18_below);
            // between 18-34
            $('#chart18-34').data('easyPieChart').update(redeem_by_18_34_per);
            $('span', $('#chart18-34')).text(redeem_by_18_34_per + "%");
            $('.coupon-redemption2').text(redeem_by_18_34);
            // between 18-34
            $('#chart35-50').data('easyPieChart').update(redeem_by_35_50_per);
            $('span', $('#chart35-50')).text(redeem_by_35_50_per + "%");
            $('.coupon-redemption3').text(redeem_by_35_50);
            // above 50
            $('#chartabove50').data('easyPieChart').update(redeem_by_above_50_per);
            $('span', $('#chartabove50')).text(redeem_by_above_50_per + "%");
            
            // male 
             $('#chartmale').data('easyPieChart').update(redeem_by_male);
            $('span', $('#chartmale')).text(redeem_by_male + "%");
            $('.coupon-redemption5').text(redeem_by_male_total);
            // female 
             $('#chartfemale').data('easyPieChart').update(redeem_by_female);
            $('span', $('#chartfemale')).text(redeem_by_female + "%");
            $('.coupon-redemption6').text(redeem_by_female_total);
            
            //geofencing 
           $('#geofencingtotal').data('easyPieChart').update(additionalgeofencing_percent);
            $('span', $('#geofencingtotal')).text(Number(additionalgeofencing).toFixed(2));
            
            //geolocation 
           $('#geolocationtotal').data('easyPieChart').update(additionalgeolocation_percent);
            $('span', $('#geolocationtotal')).text(additionalgeolocation);
            
            $('.coupon-redemption4').text(redeem_by_above_50);
            redeem_monthly.update({labels: monthlabels, series: [total_redeem_monthly]})
            redeem_weekly.update({labels: weekslabels, series: [total_redeem_weekly]})



        },
        error: function (xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
           // console.log(err);
        }
    });


    $('a[data-toggle="tab"]').on('shown.bs.tab', function (event) {

        redeem_monthly.update();
        redeem_weekly.update();
        bar1.update();

    });
    $('#charty').change(function () {
        var value = $(this).val();
        $.ajax({
            url: "vendor/dashboard",
            data: {'year': value},
            success: function (data) {
                total_redeem_monthly = [];
                $.each(data.data.total_redeem_monthly, function (index, value) {
                    total_redeem_monthly.push(value);
                });
                redeem_monthly.update({labels: monthlabels, series: [total_redeem_monthly]});
            },
            error: function (xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err);
            }
        });
    });
    $('#charty1,#chartm1').change(function () {
        var yearvalue = $('#charty1').val();
        var monthvalue = $('#chartm1').val();
        $.ajax({
            url: "vendor/dashboard",
            data: {'year': yearvalue, 'month': monthvalue},
            success: function (data) {
                total_redeem_weekly = [];
                $.each(data.data.total_redeem_weekly, function (index, value) {
                    total_redeem_weekly.push(value);
                });
                redeem_weekly.update({labels: weekslabels, series: [total_redeem_weekly]});
            },
            error: function (xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err);
            }
        });
    });
});

// update contact submit
$(document).on("submit", "#sendcontact", function (event) {
    event.preventDefault();
    formData = $(this).serialize();

    $.ajax({
        url: $('#hidAbsUrl').val() + "/vendor/contact",
        type: 'POST',
        data: formData,
        success: function (data) {
            $('#loadingDiv').hide();
            setDashboardNotification(data);
            $('#sendcontact')[0].reset();
        },
        beforeSend: function () {
            $('#loadingDiv').show();
        },
        complete: function () {
            $('#loadingDiv').hide();
        },
        error: function (data) {
            $(".form-group").removeClass('has-error');
            $(".checkbox").removeClass('has-error');
            $(".help-block").html('');

            if (data.responseJSON.errors != '') {
                $.each(data.responseJSON.errors, function (key, value) {

                    $("input[name=" + key + "],textarea[name=" + key + "]").parent().addClass('has-error');
                    $("input[name=" + key + "],textarea[name=" + key + "]").parent().append('<span class="help-block"> <strong>' + value[0] + '</strong> </span>'); //showing only the first error.

                });
            }
        }


    });

});
$(document).on("keypress", "#coupon_reddem", function (event) {

   
     if(event.which == 13) {
          event.preventDefault();
       $('.redeemnow').trigger('click');
     }
});
// update contact submit
$(document).on("click", ".redeemnow", function (event) {
    event.preventDefault();
    formData = $('#redeemcoupon').serialize();

    $.ajax({
        url: $('#hidAbsUrl').val() + "/vendor/couponredeem",
        type: 'POST',
        data: formData,
        success: function (data) {
            $(".form-group").removeClass('has-error');
            $(".help-block").html('');
            $('#loadingDiv').hide();
            $('#redeemcoupon')[0].reset();

            if (data.status == 0) {
                setDashboardNotification(data);
            } else {
                localStorage.setItem("Redeemstatus", JSON.stringify(data))
                location.reload(true);
            }

        },
        beforeSend: function () {
            $('#loadingDiv').show();
        },
        complete: function () {
            $('#loadingDiv').hide();
        },
        error: function (data) {

            $(".form-group").removeClass('has-error');
            $(".help-block").html('');

            if (data.responseJSON.errors != '') {
                $.each(data.responseJSON.errors, function (key, value) {

                    $("input[name=" + key + "],textarea[name=" + key + "]").parent().addClass('has-error');
                    $("input[name=" + key + "],textarea[name=" + key + "]").parent().append('<span class="help-block"> <strong>' + value[0] + '</strong> </span>'); //showing only the first error.

                });
            }
        }


    });

});
