<div id="dashboard" class="tab-pane fade in active">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 ">
                <div class="card card-dash1 row-md-5">
                    <div class="header head-coupons">
                        <div class="pull-left">
                            <h5>Coupons</h5>
                        </div>
                        <div class="chart-legend1 pull-right">
                            <span><i class="fa fa-circle"></i> Redeemed</span>
                            <span><i class="fa fa-circle"></i> Created</span>
                            <span><i class="fa fa-circle"></i> Active</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <div id="chartCoupons"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-8 col-lg-offset-0 col-md-offset-0 col-sm-offset-2">
                <div class="card card-dash1">
                    <div class="header head-coupons">
                        <h5>Total Coupons Redemption Rate</h5>
                    </div>
                    <div class="card-content" align="center">
                        <div id="charttotal" class="chart-circle" data-percent="0"> <span>0%</span></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row row-coupons">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="header head-coupons">
                        <h5>Redemption for ages:
                            <span class="age-right">&lt;18</span></h5>
                    </div>
                    <div class="card-content card-content1">
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="coupon-redemption1">0</p>
                            </div>
                            <div class="col-xs-6" align="right">
                                <div id="chartunder18" class="chart-circle1" data-percent="0"><span>0%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="header head-coupons">
                        <h5>Redemption for ages:
                            <span class="age-right">18-34</span></h5>
                    </div>
                    <div class="card-content card-content1">
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="coupon-redemption2">0</p>
                            </div>
                            <div class="col-xs-6" align="right">
                                <div id="chart18-34" class="chart-circle1" data-percent="0"><span>0%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="header head-coupons">
                        <h5>Redemption for ages:
                            <span class="age-right">35-50</span></h5>
                    </div>
                    <div class="card-content card-content1">
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="coupon-redemption3">0</p>
                            </div>
                            <div class="col-xs-6" align="right">
                                <div id="chart35-50" class="chart-circle1" data-percent="0"><span>0%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="header head-coupons">
                        <h5>Redemption for ages:
                            <span class="age-right">50&gt;</span></h5>
                    </div>
                    <div class="card-content card-content1">
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="coupon-redemption4">0</p>
                            </div>
                            <div class="col-xs-6" align="right">
                                <div id="chartabove50" class="chart-circle1" data-percent="0"><span>0%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header head-coupons">
                        <h5>Coupons Redeemed</h5>
                    </div>
                    <div class="card-content">
                        <div id="my-tab-content" class="tab-content">
                            <div class="tab-pane active" id="monthly">
                                <form class="form-inline pad-b pull-right mon-form">
                                    <div class="form-group">
                                        <label for="charty">Year:</label>
                                        {{ Form::select('select_year',$year,'',['id'=>'charty','class'=>'form-control'])}}

                                    </div>
                                </form>
                                <div id="chartMonthly"></div>
                            </div>
                            <div class="tab-pane" id="weekly">
                                <form class="form-inline pad-b pull-right mon-form">
                                    <div class="form-group">
                                        <label for="charty1">Year:</label>
                                        {{ Form::select('select_year',$year,'',['id'=>'charty1','class'=>'form-control'])}}

                                    </div>
                                    <div class="form-group">
                                        <label for="chartm1">Month:</label>
                                        {{ Form::selectMonth('month','',['id'=>'chartm1','class'=>'form-control']) }}
                                       
                                    </div>
                                </form>
                                <div id="chartWeekly"></div>
                            </div>
                        </div>
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul id="tabs" class="nav nav-tabs user-tabs" data-tabs="tabs">
                                    <li class="active"><a href="#monthly" data-toggle="tab">Monthly</a></li>
                                    <li id="weeklyChart"><a href="#weekly" data-toggle="tab">Weekly</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
