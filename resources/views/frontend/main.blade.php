@extends('frontend.layouts.dashboard')
@section('title', 'Deals en Route|Index')
@section('content')

<div class="content">
        <div class="tab-content">
                <div id="dashboard" class="tab-pane fade in active">
                        <div class="container-fluid">
                                <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                                <div class="card card-dash1">
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
                                                                <div id="charttotal" class="chart-circle" data-percent="80">80%</div>
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
                                                                                <p class="coupon-redemption1">200</p>
                                                                        </div>
                                                                        <div class="col-xs-6" align="right">
                                                                                <div id="chartunder18" class="chart-circle1" data-percent="20">20%</div>
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
                                                                                <p class="coupon-redemption2">450</p>
                                                                        </div>
                                                                        <div class="col-xs-6" align="right">
                                                                                <div id="chart18-34" class="chart-circle1" data-percent="45">45%</div>
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
                                                                                <p class="coupon-redemption3">300</p>
                                                                        </div>
                                                                        <div class="col-xs-6" align="right">
                                                                                <div id="chart35-50" class="chart-circle1" data-percent="30">30%</div>
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
                                                                                <p class="coupon-redemption4">50</p>
                                                                        </div>
                                                                        <div class="col-xs-6" align="right">
                                                                                <div id="chartabove50" class="chart-circle1" data-percent="5">5%</div>
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
                                                                                                <select class="form-control" id="charty"> 
                                                                        <option>2017</option>
                                                                                                <option>2016</option>
                                                                                                <option>2015</option>
                                                                                                <option>2014</option>
                                                                                        </select>
                                                                                        </div>
                                                                                </form>
                                                                                <div id="chartMonthly"></div>
                                                                        </div>
                                                                        <div class="tab-pane" id="weekly">
                                                                                <form class="form-inline pad-b pull-right mon-form">
                                                                                        <div class="form-group">
                                                                                                <label for="charty1">Year:</label>
                                                                                                <select class="form-control" id="charty1"> 
                                                                        <option>2017</option>
                                                                                                <option>2016</option>
                                                                                                <option>2015</option>
                                                                                                <option>2014</option>
                                                                                        </select>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                                <label for="chartm1">Month:</label>
                                                                                                <select class="form-control" id="chartm1"> 
                                                                        <option>January</option>
                                                                                                <option>February</option>
                                                                                                <option>March</option>
                                                                                                <option>April</option>
                                                                                                <option>May</option>
                                                                                                <option>June</option>
                                                                                                <option>July</option>
                                                                                                <option>August</option>
                                                                                                <option>September</option>
                                                                                                <option>October</option>
                                                                                                <option>November</option>
                                                                                                <option>December</option>
                                                                                        </select>
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
                <div id="create" class="tab-pane fade in">
                        <div class="content content-create">
                                <div class="container-fluid">
                                        <div class="row">
                                                <div class="col-md-7">
                                                        <div class="card">
                                                                <div class="header">
                                                                        <h5 class="title" align="left" style="padding-top: 24px;">Created Coupons</h5>
                                                                </div>
                                                                <div class="content coupons-tab">
                                                                        <div class="row">
                                                                                <div class="card-content table-responsive">
                                                                                        <div class="toolbar">
                                                                                                <!--Here you can write extra buttons/actions for the toolbar-->
                                                                                        </div>
                                                                                        <table id="bootstrap-table2" class="table">
                                                                                                <thead>
                                                                                                        <tr>
                                                                                                                <th data-field="logo">Logo</th>
                                                                                                                <th data-field="name" data-sortable="true">Coupon Name</th>
                                                                                                                <th data-field="total" data-sortable="true">Created</th>
                                                                                                                <th data-field="coup-redeemed" data-sortable="true">Redeemed</th>
                                                                                                                <th data-field="coup-active" data-sortable="true">Active</th>
                                                                                                                <th data-field="actions" class="td-actions text-right" data-events="operateEvents" data-formatter="operateFormatter">Actions</th>
                                                                                                        </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                        <tr>
                                                                                                                <td><img src="img/sample1.png"></td>
                                                                                                                <td>Coupon name</td>
                                                                                                                <td>400</td>
                                                                                                                <td>140</td>
                                                                                                                <td>100</td>
                                                                                                                <td></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                                <td><img src="img/sample1.png"></td>
                                                                                                                <td>Coupon name</td>
                                                                                                                <td>400</td>
                                                                                                                <td>140</td>
                                                                                                                <td>100</td>
                                                                                                                <td></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                                <td><img src="img/sample1.png"></td>
                                                                                                                <td>Coupon name</td>
                                                                                                                <td>400</td>
                                                                                                                <td>140</td>
                                                                                                                <td>100</td>
                                                                                                                <td></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                                <td><img src="img/sample1.png"></td>
                                                                                                                <td>Coupon name</td>
                                                                                                                <td>400</td>
                                                                                                                <td>140</td>
                                                                                                                <td>100</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                                <td><img src="img/sample1.png"></td>
                                                                                                                <td>Coupon name</td>
                                                                                                                <td>400</td>
                                                                                                                <td>140</td>
                                                                                                                <td>100</td>
                                                                                                                <td></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                                <td><img src="img/sample1.png"></td>
                                                                                                                <td>Coupon name</td>
                                                                                                                <td>400</td>
                                                                                                                <td>140</td>
                                                                                                                <td>100</td>
                                                                                                                <td></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                                <td><img src="img/sample1.png"></td>
                                                                                                                <td>Coupon name</td>
                                                                                                                <td>400</td>
                                                                                                                <td>140</td>
                                                                                                                <td>100</td>
                                                                                                                <td></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                                <td><img src="img/sample1.png"></td>
                                                                                                                <td>Coupon name</td>
                                                                                                                <td>400</td>
                                                                                                                <td>140</td>
                                                                                                                <td>100</td>
                                                                                                                <td></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                                <td><img src="img/sample1.png"></td>
                                                                                                                <td>Coupon name</td>
                                                                                                                <td>400</td>
                                                                                                                <td>140</td>
                                                                                                                <td>100</td>
                                                                                                                <td></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                                <td><img src="img/sample1.png"></td>
                                                                                                                <td>Coupon name</td>
                                                                                                                <td>400</td>
                                                                                                                <td>140</td>
                                                                                                                <td>100</td>
                                                                                                                <td></td>
                                                                                                        </tr>
                                                                                                </tbody>
                                                                                        </table>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="col-md-5">
                                                        <div class="card">
                                                                <div class="header">
                                                                        <h4 class="title">Click Below to create your coupon</h4>
                                                                </div>
                                                                <div class="content">
                                                                        <div class="row create-img1" style="text-align: center;"> <img src="img/coupon.png" width="200" alt=""> </div>
                                                                        <div class="footer" style="text-align: center;">
                                                                                <div class="row create-btn1"> <a href="#create2" data-toggle="tab" class="btn btn-info btn-fill btn-wd btn-create">Create Now</a> </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>

                                        </div>
                                </div>
                        </div>
                </div>
                <div id="create2" class="tab-pane fade in">
                        <div class="content content-create">
                                <div class="container-fluid">
                                        <div class="row">
                                                <div class="col-md-12">
                                                        <div class="card">
                                                                <div class="content">
                                                                        <div class="wizard">
                                                                                <div class="wizard-inner">
                                                                                        <div class="connecting-line"></div>
                                                                                        <ul class="nav nav-tabs nav-tabs-step" role="tablist">
                                                                                                <li role="presentation" class="active"> <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab"> <span class="round-tab"> 1 </span> </a> </li>
                                                                                                <li role="presentation" class="disabled"> <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab"> <span class="round-tab"> 2 </span> </a> </li>
                                                                                                <li role="presentation" class="disabled"> <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"> <span class="round-tab"> 3 </span> </a> </li>
                                                                                        </ul>
                                                                                </div>
                                                                                <form>
                                                                                        <div class="row">
                                                                                                <div class="col-sm-12">
                                                                                                        <div class="tab-content">
                                                                                                                <div class="tab-pane active" role="tabpanel" id="step1">
                                                                                                                        <h3>Coupon Details</h3>
                                                                                                                        <div class="row">
                                                                                                                                <div class="col-sm-5" style="text-align: center; height:500px;">
                                                                                                                                        <div id="preview-main"><img src="img/preview1.png" width="250" alt=""></div>
                                                                                                                                        <div id="preview-in">
                                                                                                                                                <div class="logo"><img src="img/sample1.png" width="70" alt=""></div>
                                                                                                                                                <div class="b-name">Beef and Brew</div>
                                                                                                                                                <div class="b-sub">39, Castle Street, Geneva, NY 14456</div>
                                                                                                                                                <div class="coupon-name">COUPON NAME</div>
                                                                                                                                                <div class="coupon-desc">Coupon description</div>
                                                                                                                                                <div class="barcode"><img src="img/sample2.png" width="47" alt=""></div>
                                                                                                                                                <div class="red-code1">Redemption Code</div>
                                                                                                                                                <div class="red-code2">XXXXX</div>
                                                                                                                                                <div class="validity">Valid until XX XXX XXXX</div>
                                                                                                                                        </div>
                                                                                                                                </div>
                                                                                                                                <div class="col-sm-6">
                                                                                                                                        <div class="form-group">
                                                                                                                                                <label for="c-name">Coupon:</label>
                                                                                                                                                <input type="text" class="form-control" id="c-name" required>
                                                                                                                                        </div>
                                                                                                                                        <div class="form-group">
                                                                                                                                                <label for="descrip">Description:</label>
                                                                                                                                                <input type="text" class="form-control" id="descrip">
                                                                                                                                        </div>
                                                                                                                                        <div class="form-group">
                                                                                                                                                <label for="coupons">Total Coupons:</label>
                                                                                                                                                <input type="number" class="form-control" id="coupons" required>
                                                                                                                                        </div>
                                                                                                                                        <div class="form-group">
                                                                                                                                                <label for="valid2">Valid Until:</label>
                                                                                                                                                <input type="text" class="form-control datepicker" id="valid2">
                                                                                                                                        </div>
                                                                                                                                        <div class="form-group">
                                                                                                                                                <label>Coupon Code</label>
                                                                                                                                                <input type="number" class="form-control" required>
                                                                                                                                        </div>
                                                                                                                                        <div class="form-group">
                                                                                                                                                <label>Coupon Image</label>
                                                                                                                                                <fieldset>
                                                                                                                                                        <input type="file" name="file" id="file1" accept="image/*" />
                                                                                                                                                </fieldset>
                                                                                                                                        </div>
                                                                                                                                        <ul class="list-inline pull-right pad-top">
                                                                                                                                                <li>
                                                                                                                                                        <button type="button" class="btn btn-create next-step">Save and continue</button>
                                                                                                                                                </li>
                                                                                                                                        </ul>
                                                                                                                                </div>
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                                <div class="tab-pane" role="tabpanel" id="step2">
                                                                                                                        <h3>Geofence</h3>
                                                                                                                        <div class="row">
                                                                                                                                <div class="col-sm-10 col-sm-offset-1"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2470.917762770124!2d-74.01094649895528!3d40.70622394221145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a165bedccab%3A0x2cb2ddf003b5ae01!2sWall+St%2C+New+York%2C+NY%2C+USA!5e0!3m2!1sen!2sin!4v1506509334043" width="100%" height="500" frameborder="0" style="border:0; " allowfullscreen></iframe></div>
                                                                                                                        </div>
                                                                                                                        <div class="col-sm-10 col-sm-offset-1">
                                                                                                                                <ul class="list-inline pad-top">
                                                                                                                                        <li class="pull-left">
                                                                                                                                                <button type="button" class="btn btn-create prev-step">Previous</button>
                                                                                                                                        </li>
                                                                                                                                        <li class="pull-right">
                                                                                                                                                <button type="button" class="btn btn-create next-step">Save and continue</button>
                                                                                                                                        </li>
                                                                                                                                </ul>
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                                <div class="tab-pane" role="tabpanel" id="step3">
                                                                                                                        <h3>Order Summary</h3>
                                                                                                                        <div class="row">
                                                                                                                                <div class="col-sm-5" style="text-align: center; height:500px;">
                                                                                                                                        <div id="preview-main1"><img src="img/preview1.png" width="250" alt=""></div>
                                                                                                                                        <div id="preview-in1">
                                                                                                                                                <div class="logo"><img src="img/sample1.png" width="70" alt=""></div>
                                                                                                                                                <div class="b-name">Beef and Brew</div>
                                                                                                                                                <div class="b-sub">39, Castle Street, Geneva, NY 14456</div>
                                                                                                                                                <div class="coupon-name">COUPON NAME</div>
                                                                                                                                                <div class="coupon-desc">Coupon description</div>
                                                                                                                                                <div class="barcode"><img src="img/sample2.png" width="47" alt=""></div>
                                                                                                                                                <div class="red-code1">Redemption Code</div>
                                                                                                                                                <div class="red-code2">XXXXX</div>
                                                                                                                                                <div class="validity">Valid until XX XXX XXXX</div>
                                                                                                                                        </div>
                                                                                                                                </div>
                                                                                                                                <div class="col-sm-6">
                                                                                                                                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2470.917762770124!2d-74.01094649895528!3d40.70622394221145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a165bedccab%3A0x2cb2ddf003b5ae01!2sWall+St%2C+New+York%2C+NY%2C+USA!5e0!3m2!1sen!2sin!4v1506509334043" width="100%" height="481" frameborder="0" style="border-radius: 15px;border:2px solid #999;" allowfullscreen></iframe>
                                                                                                                                </div>
                                                                                                                        </div>
                                                                                                                        <div class="row">
                                                                                                                                <div class="col-sm-10 col-sm-offset-1">
                                                                                                                                        <table class="table summary-table">
                                                                                                                                                <tbody>
                                                                                                                                                        <tr>
                                                                                                                                                                <td>Start Time:</td>
                                                                                                                                                                <td>September 18, 2017 3:00 PM EDT</td>
                                                                                                                                                        </tr>
                                                                                                                                                        <tr>
                                                                                                                                                                <td>End Time:</td>
                                                                                                                                                                <td>September 19, 2017 3:00 PM EDT</td>
                                                                                                                                                        </tr>
                                                                                                                                                        <tr>
                                                                                                                                                                <td>Area Covered:</td>
                                                                                                                                                                <td>Wall Street, NY</td>
                                                                                                                                                        </tr>
                                                                                                                                                </tbody>
                                                                                                                                                <tfoot>
                                                                                                                                                        <tr>
                                                                                                                                                                <td>Total:</td>
                                                                                                                                                                <td>$50</td>
                                                                                                                                                        </tr>
                                                                                                                                                </tfoot>
                                                                                                                                        </table>
                                                                                                                                </div>
                                                                                                                        </div>
                                                                                                                        <div class="row">
                                                                                                                                <div class="col-sm-10 col-sm-offset-1" align="left">
                                                                                                                                        <div class="checkbox">
                                                                                                                                                <input id="checkbox1" type="checkbox">
                                                                                                                                                <label for="checkbox1"> I have read the <a href="#">Privacy Policy</a> and agree to the <a href="#">Terms of Service</a>. </label>
                                                                                                                                        </div>
                                                                                                                                        <ul class="list-inline pad-top">
                                                                                                                                                <li>
                                                                                                                                                        <button type="button" class="btn btn-create prev-step">Previous</button>
                                                                                                                                                </li>
                                                                                                                                                <li class="pull-right">
                                                                                                                                                        <button type="submit" class="btn btn-create">Submit</button>
                                                                                                                                                </li>
                                                                                                                                        </ul>
                                                                                                                                </div>
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                                <div class="clearfix"></div>
                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>
                                                                                </form>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
                <div id="settings" class="tab-pane fade in">
                        <div class="container-fluid">
                                <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="card">
                                                        <div class="header">
                                                                <h5 class="title">Company Details</h5>
                                                        </div>
                                                        <div class="content">
                                                                <div class="row">
                                                                        <div class="col-md-12">
                                                                                <form>
                                                                                        <div class="form-group">
                                                                                                <input type="text" placeholder="Business Name">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                                <input type="text" placeholder="Street Address">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                                <input type="text" placeholder="City/State">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                                <input type="text" placeholder="Zip">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                                <input type="tel" placeholder="Phone (x-xxx-xxx-xxxx)" pattern="^\d{1}-\d{3}-\d{3}-\d{4}$" maxlength="11" required>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                                <input type="email" placeholder="Email" required>
                                                                                        </div>
                                                                                        <fieldset>
                                                                                                <input type="file" name="file" id="file" accept="image/*" />
                                                                                        </fieldset>
                                                                                        <ul class="list-inline pad-top1 pull-right">
                                                                                                <li>
                                                                                                        <button type="submit" class="btn btn-create">Submit</button>
                                                                                                </li>
                                                                                        </ul>
                                                                                </form>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="card">
                                                        <div class="header">
                                                                <h5 class="title">Edit Credit/Debit Card Info</h5>
                                                        </div>
                                                        <div class="content">
                                                                <div class="row">
                                                                        <div class="col-md-12">
                                                                                <form>
                                                                                        <div class="form-group">
                                                                                                <div class="input-group"> <span class="input-group-addon"> <span class="type"></span> </span>
                                                                                                        <input class="cardNumber type" placeholder="Card Number" required/>
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                                <input type="text" placeholder="Card Holder Name">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                                <!-- <input type="text" placeholder="Expiration Date MM/YY" required> -->
                                                                                                <input class="expiry" placeholder="MM/YY" required />
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                                <!-- <input type="number" placeholder="CVV" required> -->
                                                                                                <input class="cvv" maxlength="4" placeholder="CVV" required />
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                                <input type="text" placeholder="Home">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                                <input type="text" placeholder="City">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                                <select class="form-control">
      <option>Country</option>
      <option value="United States">United States</option>
      <option value="United Kingdom">United Kingdom</option>
      <option value="India">India</option>
      <option value="Australia">Australia</option>
      <option value="Russia">Russia</option>
      <option value="New Zealand">New Zealand</option>
    </select>
                                                                                        </div>
                                                                                        <ul class="list-inline pad-top pull-right">
                                                                                                <li>
                                                                                                        <button type="submit" class="btn btn-create">Submit</button>
                                                                                                </li>
                                                                                        </ul>
                                                                                </form>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="card">
                                                        <div class="header">
                                                                <h5 class="title">Change Password</h5>
                                                        </div>
                                                        <div class="content">
                                                                <div class="row">
                                                                        <div class="col-md-12">
                                                                                <form>
                                                                                        <div class="form-group">
                                                                                                <input type="password" placeholder="Current Password">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                                <input type="password" placeholder="New Password">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                                <input type="password" placeholder="Re-Enter Password">
                                                                                        </div>
                                                                                        <ul class="list-inline pad-top pull-right">
                                                                                                <li>
                                                                                                        <button type="submit" class="btn btn-create">Submit</button>
                                                                                                </li>
                                                                                        </ul>
                                                                                </form>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
                <div id="contact" class="tab-pane fade in">
                        <div class="container-fluid">
                                <div class="row">
                                        <div class="col-md-12">
                                                <div class="card">
                                                        <div class="content">
                                                                <div class="row">
                                                                        <div class="col-md-7">
                                                                                <h5 class="title">Send us a Message</h5>
                                                                                <div class="row">
                                                                                        <div class="col-md-12">
                                                                                                <form>
                                                                                                        <div class="form-group">
                                                                                                                <label for="usr">Name:</label>
                                                                                                                <input type="text" class="form-control" id="usr">
                                                                                                        </div>
                                                                                                        <div class="form-group">
                                                                                                                <label for="email">Email:</label>
                                                                                                                <input type="email" class="form-control" id="email">
                                                                                                        </div>
                                                                                                        <div class="form-group">
                                                                                                                <label for="qry">Query:</label>
                                                                                                                <textarea class="form-control" id="qry" style="height:200px !important;"></textarea>
                                                                                                        </div>
                                                                                                        <ul class="list-inline pad-top">
                                                                                                                <li>
                                                                                                                        <button type="submit" class="btn btn-create">Submit</button>
                                                                                                                </li>
                                                                                                        </ul>
                                                                                                </form>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                                <h5 class="title">Contact Information</h5>
                                                                                <div class="row">
                                                                                        <div class="col-lg-12">
                                                                                                <ul class="table-contact">
                                                                                                        <li>
                                                                                                                <!-- <i class="fa fa-map-marker"></i> -->
                                                                                                                <span>35 Street Bellasis, Albani, NY, USA</span>
                                                                                                        </li>
                                                                                                        <li>
                                                                                                                <!-- <i class="fa fa-envelope"></i> -->
                                                                                                                <span><a href="mailto:abc@xyz.com" style="color: #252422;">abc@xyz.com</a></span>
                                                                                                        </li>
                                                                                                        <li>
                                                                                                                <!-- <i class="fa fa-mobile"></i> -->
                                                                                                                <span>+1 231 564 879</span>
                                                                                                        </li>
                                                                                                        <li>
                                                                                                                <div class="social-cont">
                                                                                                                        <div> <a target="_blank" href="#s"><i class="fa fa-facebook"></i> </a> </div>
                                                                                                                        <div> <a target="_blank" href="#"><i class="fa fa-linkedin"></i> </a> </div>
                                                                                                                        <div> <a target="_blank" href="#s"><i class="fa fa-twitter"></i> </a> </div>
                                                                                                                        <div> <a target="_blank" href="#"><i class="fa fa-instagram"></i> </a> </div>
                                                                                                                </div>
                                                                                                        </li>
                                                                                                </ul>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>
@endsection	