
<div class="row">
    <div class="col-sm-12">
        <div class="tab-content">
            {{ Form::hidden('steps', 1, ['class' => 'stepsincrement']) }}
            
            {{ Form::hidden('validationcheck', 0, ['class' => 'validationcheck']) }}
            {{ Form::hidden('vendor_lat', $vendor_detail->vendor_lat, ['class' => 'vendor_lat']) }}
            {{ Form::hidden('vendor_long', $vendor_detail->vendor_long, ['class' => 'vendor_long']) }}

               
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
                                        <div class="coupon-name coupon_name"  >COUPON NAME</div>
                                        <div class="coupon-desc coupon_detail" >Coupon description</div>
                                        <div class="barcode"><img src="{{ \Config::get('app.url') . '/public/frontend/img/sample2.png' }}" width="47" alt=""></div>
                                        <div class="red-code1" >Redemption Code</div>
                                        <div class="red-code2 coupon_code" >XXXXX</div>
                                        <div class="validity">Valid until <div class="coupon_end_date"> XX XXX XXXX </div></div>         
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
                                               {{ Form::number('coupon_redeem_limit', '', ['placeholder'=>'Enter Your Total Coupons','class'=>'form-control','min'=>1,'id'=>'coupon_redeem_limit']) }}
                                             
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
                                               {{ Form::label('coupon_radius', 'Coupon Radius:') }}
                                               {{ Form::number('coupon_radius', '', ['placeholder'=>'Enter Your Coupon Radius','class'=>'form-control','min'=>1,'maxlength'=>3,'id'=>'coupon_radius']) }}
                                                 <p> (in miles) </p>
                                         </div>
                  
                                        <div class="form-group">
                                               {{ Form::label('coupon_original_price', 'Original Price:') }}
                                               {{ Form::number('coupon_original_price', '', ['placeholder'=>'Enter Your Coupon Original Price ','class'=>'form-control','min'=>1,'id'=>'original_price']) }}
                                             
                                         </div>
                                        <div class="form-group">
                                               {{ Form::label('coupon_discount', 'Discount Percentage:') }}
                                               {{ Form::number('coupon_discounted_percent', '', ['placeholder'=>'Enter Your Discount in %','maxlength'=>2,'class'=>'form-control','min'=>1,'id'=>'percentage_price']) }} 
                                                OR 
                                               {{ Form::label('coupon_discount', 'Discount Price:') }}
                                               {{ Form::number('coupon_discounted_price', '', ['placeholder'=>'Enter Your Discount in $','class'=>'form-control','min'=>1,'id'=>'value_price']) }}
                                             
                                         </div>
                                    
                                         <div class=" form-group">
                                               {{ Form::label('coupon_discounted_price', 'Total Dicounted Price:') }}
                                               {{ Form::text('coupon_discount', '', ['placeholder'=>'$','class'=>'form-control','readonly'=>true,'id'=>'final_value']) }}
                                             
                                         </div>
                                    

                                        <div class="form-group couponlogo ">
                                                {{ Form::label('coupon_logo', 'Coupon Logo:') }}
                                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                <div class="form-control" data-trigger="fileinput"><span class="fileinput-filename"></span></div>
                                                <span class="input-group-addon btn btn-default btn-file">
                                                <span class="fileinput-new">Browse</span>
                                                <span class="fileinput-exists">Change</span> 
                                                
                                                {{ Form::file('coupon_logo',['id' => 'file1','accept'=>'image/*']) }}
                                                </span>
                                                </div>
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
                            <div class="col-sm-10 col-sm-offset-1 form-group"> <div id="info"></div></div>
                            <div  class="col-sm-10 col-sm-offset-1" id="googlegeofencing" style="height: 400px;max-width: 980px;"></div> 
                       
                        </div>
                        <div class="col-sm-10 col-sm-offset-1">
                             
                                <ul class="list-inline pad-top" style="text-align: center">
                                        <li class="pull-left">
                                                <button type="button" class="btn btn-create prev-step">Previous</button>
                                        </li>
                                        <li>
                                                <button type="button" id="resetfence" onclick="onClickEvent()" class="btn btn-create">Draw Fence</button>
                                        </li>
                                        <li class="pull-right">
                                          
                                                <button type="button" class="btn btn-create next-step">Save and continue</button>
                                        </li>
                                </ul>
                        </div>
                         {{ Form::hidden('coupon_notification_point', '', ['id' => 'coupon_notification_point']) }}

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
                                        <div class="coupon-name coupon_name"  >COUPON NAME</div>
                                        <div class="coupon-desc coupon_detail" >Coupon description</div>
                                        <div class="barcode"><img src="{{ \Config::get('app.url') . '/public/frontend/img/sample2.png' }}" width="47" alt=""></div>
                                        <div class="red-code1 " >Redemption Code</div>
                                        <div class="red-code2 coupon_code" >XXXXX</div>
                                        <div class="validity">Valid until <div class="coupon_end_date"> XX XXX XXXX </div></div>     
                                           
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
                                                                <td class="coupon_start_date"> <?php echo date('g A, d M Y'); ?></td>
                                                        </tr>
                                                        <tr>
                                                                <td>End Time:</td>
                                                                <td class="coupon_end_date"></td>
                                                        </tr>
                                                        <tr>
                                                                <td>Area Covered(sq feet):</td>
                                                                <td class="couponsqft"> </td>
                                                        </tr>
                                                        {{ Form::hidden('coupon_notification_sqfeet', '', ['id' => 'coupon_notification_sqfeet']) }}
=
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
                                        
                                       	{{ Form::checkbox('agree', 'no','',['id' => 'checkbox1']) }}
                                        
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

       


