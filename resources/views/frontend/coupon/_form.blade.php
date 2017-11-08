
<div class="row">
    <div class="col-sm-12">
        <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="step1">
                        <h3>Coupon Details</h3>
                        <div class="row">
                                <div class="col-sm-5" style="text-align: center; height:500px;">
                                        <div id="preview-main">
                                            <img src="{{ \Config::get('app.url') . '/public/frontend/img/preview1.png' }}" width="250" alt="">
                                        </div>
                                        <div id="preview-in">
                                                <div class="logo"><img src="{{ \Config::get('app.url') . '/public/frontend/img/sample1.png' }}" width="70" alt=""></div>
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
                                               {{ Form::label('coupon_name', 'Coupon Name:') }}
                                               {{ Form::text('coupon_name', '', ['placeholder'=>'Enter Your Coupon Name','class'=>'form-control']) }}
                                              
                                        </div>
                                        <div class="form-group">
                                               {{ Form::label('coupon_detail', 'Description:') }}
                                               {{ Form::text('coupon_detail', '', ['placeholder'=>'Enter Your Description','class'=>'form-control']) }}
                                        </div>
                                         <div class="form-group">
                                               {{ Form::label('coupon_redeem_limit', 'Total Coupons:') }}
                                               {{ Form::text('coupon_redeem_limit', '', ['placeholder'=>'Enter Your Total Coupons','class'=>'form-control']) }}
                                        </div>
                                        <div class="form-group">
                                               {{ Form::label('coupon_end_date', 'Valid Until:') }}
                                               {{ Form::text('coupon_end_date', '', ['placeholder'=>'Enter Your Valid Until','class'=>'form-control datepicker']) }}
                                        </div>
                                         <div class="form-group">
                                               {{ Form::label('coupon_code', 'Coupon Code:') }}
                                               {{ Form::text('coupon_code', '', ['placeholder'=>'Enter Your Coupon Code','class'=>'form-control']) }}
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

       


