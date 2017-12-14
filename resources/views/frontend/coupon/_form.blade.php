
<div class="row">
    <div class="col-sm-12">
        <div class="tab-content">
            <?php $coupon_id = isset($coupon) ? $coupon->coupon_id : ''; ?>
            {{ Form::hidden('steps', 1, ['class' => 'stepsincrement']) }}
            {{ Form::hidden('coupon_id',$coupon_id, ['class' => 'coupon_id']) }}

            {{ Form::hidden('validationcheck', 0, ['class' => 'validationcheck']) }}
            {{ Form::hidden('vendor_lat', $vendor_detail->vendor_lat, ['class' => 'vendor_lat']) }}
            {{ Form::hidden('vendor_long', $vendor_detail->vendor_long, ['class' => 'vendor_long']) }}
            {{ Form::hidden('coupon_start_date', old('coupon_start_date'), ['id' => 'couponstartdate']) }}
            {{ Form::hidden('couponenddate', isset($end_date_converted)?$end_date_converted:'', ['id' => 'couponenddate']) }}
            <div class="geofencing" style="display:none">{{ $user_access['geofencingtotal'] }}</div>

            <div class="tab-pane active" role="tabpanel" id="step1">
                <h3>Coupon Details</h3>
                <div class="row" >

                    <div class="col-sm-5" style="text-align: center; height:500px;">
                        <div id="preview-main">
                            <img src="{{ \Config::get('app.url') . '/public/frontend/img/preview1.png' }}" width="250" alt="">
                        </div>
                        <div id="preview-in" class="viewdata">

                            <div class="logo" ><img src="{{ $vendor_detail->vendor_logo}}" width="70" alt=""></div>

                            <div class="b-name">{{ $vendor_detail->vendor_name}}</div>
                            <div class="b-sub">{{ $vendor_detail->vendor_address}}</div>
                            <div class="coupon-name coupon_name"  >{{ !isset($coupon->coupon_name) ? 'COUPON NAME': $coupon->coupon_name }}</div>
                            <div class="coupon-desc coupon_detail" >{{ !isset($coupon->coupon_detail) ? 'Coupon description': $coupon->coupon_detail }} </div>
                            <div class="barcode"><img src="{{ \Config::get('app.url') . '/public/frontend/img/sample2.png' }}" width="47" alt=""></div>
                            <div class="red-code1" >Redemption Code</div>
                            <div class="red-code2 coupon_code" >{{ !isset($coupon->coupon_code) ? 'XXXXX': $coupon->coupon_code }} </div>
                            <div class="validity">Valid until <div class="coupon_end_date">{{ !isset($end_date_converted) ? 'XX XXX XXXX': Carbon\Carbon::parse($end_date_converted)->format(\Config::get('constants.DATE_FORMAT')) }}  </div></div>         
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('coupon_name', 'Coupon Name:') }}
                            {{ Form::text('coupon_name', old('coupon_name'), ['placeholder'=>'Enter Your Coupon Name','class'=>'form-control']) }}

                        </div>
                        <div class="form-group">
                            {{ Form::label('coupon_detail', 'Description:') }}
                            {{ Form::text('coupon_detail', old('coupon_detail'), ['placeholder'=>'Enter Your Description','class'=>'form-control']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('coupon_redeem_limit', 'Total Coupons:') }}
                            {{ Form::number('coupon_redeem_limit',old('coupon_redeem_limit'), ['placeholder'=>'Enter Your Total Coupons','class'=>'form-control','min'=>1,'id'=>'coupon_redeem_limit']) }}

                        </div>
                        <div class="form-group">
                            {{ Form::label('coupon_end_date', 'Valid Until:') }}
                            {{ Form::text('coupon_end_date',isset($end_date_converted)?Carbon\Carbon::parse($end_date_converted)->format(\Config::get('constants.DATE_FORMAT')):'', ['placeholder'=>'Enter Your Valid Until','class'=>'form-control datepicker']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('coupon_code', 'Coupon Code:') }}
                            {{ Form::text('coupon_code',old('coupon_code'), ['placeholder'=>'Enter Your Coupon Code','class'=>'form-control','id'=>'coupon_code']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('coupon_radius', 'Coupon Radius:') }} <br>
                            {{ Form::text('coupon_radius','', ['data-slider-id'=>'ex1Slider','data-slider-min'=>0,'data-slider-max'=>$user_access['geolocationtotal'],'data-slider-step'=>1,'data-slider-value'=>(isset($coupon))?$coupon->coupon_radius:"0",'id'=>'couponslider']) }}
                            <p> (in miles) </p>
                        </div>

                        <div class="form-group">
                            {{ Form::label('coupon_original_price', 'Original Price:') }}
                            {{ Form::text('coupon_original_price', old('coupon_original_price'), ['placeholder'=>'Enter Your Coupon Original Price ','class'=>'form-control','min'=>1,'id'=>'original_price']) }}

                        </div>
                        <div class="form-group">
                            {{ Form::label('coupon_discount', 'Discount Percentage:') }}
                            {{ Form::text('coupon_discounted_percent', old('coupon_discounted_percent'), ['placeholder'=>'Enter Your Discount in %','maxlength'=>'3','class'=>'form-control','min'=>1,'id'=>'percentage_price']) }} 
                            OR 
                            {{ Form::label('coupon_discount', 'Discount Price:') }}
                            {{ Form::text('coupon_discounted_price', old('coupon_discounted_price'), ['placeholder'=>'Enter Your Discount in $','class'=>'form-control','min'=>1,'id'=>'value_price']) }}

                        </div>

                        <div class=" form-group">
                            {{ Form::label('coupon_total_discount', 'Total Dicounted Price:') }}
                            {{ Form::text('coupon_total_discount', old('coupon_total_discount'), ['placeholder'=>'$','class'=>'form-control','readonly'=>true,'id'=>'final_value']) }}

                        </div>


                        @if(isset($coupon)) 

                        <div class="fileinput input-group fileinput-exists " data-provides="fileinput">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                <img src="{{$coupon->coupon_logo}}">
                            </div>
                            <div class="form-control" data-trigger="fileinput"><span class="fileinput-filename"></span></div>
                            <span class="input-group-addon btn btn-default btn-file">

                                <span class="fileinput-exists">Change
                                </span> 

                                <input value="" name="" type="hidden">{{ Form::file('coupon_logo',['id' => 'file1','accept'=>'image/*']) }}
                            </span>
                        </div>
                        @else
                        <div class="form-group couponlogo ">
                            {{ Form::label('coupon_logo', 'Coupon Image:') }}
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput"><span class="fileinput-filename"></span></div>
                                <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">Browse</span>
                                    <span class="fileinput-exists">Change
                                    </span> 

                                    {{ Form::file('coupon_logo',['id' => 'file1','accept'=>'image/*']) }}
                                </span>
                            </div>
                        </div>

                        @endif
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

                    <div class="col-sm-10 col-sm-offset-1 form-group"> <div id="info">{!! !isset($coupon->coupon_notification_sqfeet) ? '': '<label> Area Sqft Covered : </label>'.' '.number_format($coupon->coupon_notification_sqfeet,2).' ft²' !!} </div></div>
                    <div  class="col-sm-10 col-sm-offset-1" id="googlegeofencing" style="height: 400px;max-width: 980px;"></div> 

                </div>
                <div class="col-sm-10 col-sm-offset-1">

                    <ul class="list-inline pad-top" style="text-align: center">
                        <li class="pull-left">
                            <button type="button" class="btn btn-create prev-step">Previous</button>
                        </li>
                        @if(!isset($coupon)) 
                        <li>
                            <button type="button" id="resetfence" onclick="onClickEvent()" class="btn btn-create">Draw Fence</button>
                        </li>
                        @endif
                        <li class="pull-right">

                            <button type="button" class="btn btn-create next-step">Save and continue</button>
                        </li>
                    </ul>
                </div>
                {{ Form::hidden('coupon_notification_point',old('coupon_notification_point'), ['id' => 'coupon_notification_point']) }}

            </div>
            <div class="tab-pane" role="tabpanel" id="step3">
                <h3>Order Summary</h3>
                <div class="row">
                    <div class="col-sm-5" style="text-align: center; height:500px;">
                        <div id="preview-main1"><img src="{{ \Config::get('app.url') . '/public/frontend/img/preview1.png' }}" width="250" alt=""></div>
                        <div id="preview-in1">
                            <div class="logo" ><img src="{{ $vendor_detail->vendor_logo}}" width="70" alt=""></div>
                            <div class="b-name">{{ $vendor_detail->vendor_name}}</div>
                            <div class="b-sub">{{ $vendor_detail->vendor_address}}</div>
                            <div class="coupon-name coupon_name"  >{{ !isset($coupon->coupon_name) ? 'COUPON NAME': $coupon->coupon_name }}</div>
                            <div class="coupon-desc coupon_detail" >{{ !isset($coupon->coupon_detail) ? 'Coupon description': $coupon->coupon_detail }} </div>
                            <div class="barcode"><img src="{{ \Config::get('app.url') . '/public/frontend/img/sample2.png' }}" width="47" alt=""></div>
                            <div class="red-code1" >Redemption Code</div>
                            <div class="red-code2 coupon_code" >{{ !isset($coupon->coupon_code) ? 'XXXXX': $coupon->coupon_code }} </div>
                            <div class="validity">Valid until <div class="coupon_end_date">{{ !isset($end_date_converted) ? 'XX XXX XXXX': Carbon\Carbon::parse($end_date_converted)->format(\Config::get('constants.DATE_FORMAT')) }}  </div></div>         

                        </div>
                    </div>

                    <div class="col-sm-6" id="googelgeofencingshow" style="height: 481px;max-width: 980px; border-radius: 15px;border:2px solid #999;">

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <table class="table summary-table">
                            <tbody>
                                <tr>
                                    <td>Start Time:</td>

                                    <td class="coupon_start_date"> {{ isset($start_date_converted) ? Carbon\Carbon::parse($start_date_converted)->format(\Config::get('constants.DATE_FORMAT')) : Carbon\Carbon::parse($currenttime)->format(\Config::get('constants.DATE_FORMAT'))  }} <?php // echo date('g A, d M Y');  ?></td>
                                </tr>
                                <tr>
                                    <td>End Time:</td>
                                    <td class="coupon_end_date">{{ isset($coupon->coupon_end_date) ? Carbon\Carbon::parse($end_date_converted)->format(\Config::get('constants.DATE_FORMAT')): '' }}</td>
                                </tr>
                                <tr>
                                    <td>Area Covered(sq feet):</td>
                                    <td class="couponsqft">{{ !isset($coupon->coupon_notification_sqfeet) ? '': number_format($coupon->coupon_notification_sqfeet,2) }} ft² </td>
                                </tr>
                                {{ Form::hidden('coupon_notification_sqfeet', old('coupon_notification_sqfeet'), ['id' => 'coupon_notification_sqfeet']) }}

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total:</td>
                                    <td>$0</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1" align="left">

                        <div class="checkbox">

                            {{ Form::checkbox('agree', 'no',isset($coupon)?true:false,['id' => 'checkbox1']) }}

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




