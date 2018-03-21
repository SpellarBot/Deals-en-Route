<div id="popup" class="modal fade signup-page" role="dialog">       
    <div class="modal-dialog modal-lg">
        <div class="modal-content signup-form-wrapper">
            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <div class="modal-body">

                {{ Form::open(['route' => 'users.store', 'class' => 'form','files'=> true,'id'=>'signupform']) }}
                {{ csrf_field() }}
                <input type="hidden" name="full_address" id="full_address">
                <input type="hidden" name="vendor_long">
                <div class="poplog">
                    <div class="popupbg">
                        <a href="#"><img src="<?php echo \Config::get('app.url') . '/public/frontend/img/logo2.png' ?>" alt="" class="signup-logo"></a>
                        <img src="<?php echo \Config::get('app.url') . '/public/frontend/img/IPhoneX.png' ?>" alt="" class="iphonex">
                        <a href="#"><img src="<?php echo \Config::get('app.url') . '/public/frontend/img/app-store-logo.png' ?>" alt="" class="app-store-logo"></a>
                    </div>

                    <div class="signupDEtails">

                        <div class="errorpopup">
                            <div class="alert alert-success alert-dismissible" role="alert" style="display: none">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <div class="successmessage"> </div>
                            </div>  
                            <div class="alert alert-danger alert-dismissible" role="alert" style="display: none">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <div class="errormessage"> </div>
                            </div>  


                        </div>
                        <div class="col-sm-6">

                            <h4>Sign Up Details</h4>
                            <div class="form-group">
                              {{ Form::select('vendor_category',[''=>'Select Category']+$signup_category_images,'',
                                ['class'=>'form-control selectinput','id'=>'vendorcategory'])
                                }}
                           
                                <input name="browser" class="inputtext" style="display:none;" disabled="disabled">
                            </div>

                            <div class="form-group">
                                {{ Form::text('vendor_name', '', ['placeholder'=>'Business Name','class'=>'form-control','id'=>'vendorname']) }}
                            </div>


                            <div class="form-group">

                                {{ Form::text('vendor_address', '', ['placeholder'=>'Street Address','class'=>'form-control','id'=>'autocomplete1']) }}
                            </div>

                            <div class="form-group">
                                 {{ Form::select('vendor_country',[''=>'Select Country']+$country_list,'',['class'=>'form-control selectinput','id'=>'country']) }}
                            </div>

                            <div class="form-group">
                                {{ Form::text('vendor_city', '', ['placeholder'=>'City','class'=>'form-control','id'=>'locality']) }}

                            </div>

                            <div class="form-group">
                                {{ Form::text('vendor_state', '', ['placeholder'=>'State','class'=>'form-control','id'=>'administrative_area_level_1']) }}

                            </div>

                            <div class="form-group">
                                {{ Form::text('vendor_zip', '', ['placeholder'=>'Zip','maxlength'=>'10','class'=>'form-control','id'=>'postal_code']) }}

                            </div>

                            <div class="form-group">
                                {{ Form::text('vendor_phone',null, ['placeholder'=>'Phone (xxx-xxx-xxxx)','data-mask'=>"999-999-9999",'maxlength'=>'11','class'=>'form-control']) }}      
                            </div>

                            <div class="form-group">
                                {{ Form::text('email', '', ['placeholder'=>'Email','class'=>'form-control']) }}

                            </div>
                            <div class="form-group">
                                {{ Form::password('password', ['placeholder'=>'Password','class'=>'form-control']) }}

                            </div>
                            <div class="form-group">
                                {{ Form::password('confirm_password',  ['placeholder'=>'Confirm Password','class'=>'form-control']) }}
                            </div>
                            <div class="form-group vendorlogo">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput"><span class="fileinput-filename"></span></div>
                                    <span class="input-group-addon btn btn-default btn-file">
                                        <span class="fileinput-new">Browse</span>
                                        <span class="fileinput-exists">Change</span> 
                                        {{ Form::file('vendor_logo',['id' => 'vendorlogo','accept'=>'image/*']) }}
                                    </span>
                                </div>

                            </div>

                        </div>
                        <div class="col-sm-6">
                            <h4>Credit/Debit Card Info</h4>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="type"></span>
                                    </span>
                                    <input class="cardNumber type" placeholder="Card Number" name="card_no"/>


                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::text('card_holder_name', '', ['placeholder'=>'Card Holder Name','class'=>'form-control']) }}

                            </div>
                            <div class="form-group">
                                    <!-- <input type="text" name="" placeholder="Expiration Date MM/YY" required> -->
                                {{ Form::text('card_expiry', '', ['placeholder'=>'MM/YY','class'=>'expiry form-control']) }}

                            </div>
                            <div class="form-group">
                                    <!-- <input type="number" name="" placeholder="CVV" required> -->
                                {{ Form::text('card_cvv', '', ['placeholder'=>'CVV','class'=>'form-control cardCvv','maxlength'=>"4"]) }}

                            </div>
                            <h4>Billing Details <span>{{ Form::checkbox('check-address', 'yes','',['id' => 'check-address']) }}(Same As Business Address)</span></h4>
                            <div id="billingdetails">

                                <div class="form-group">
                                    {{ Form::text('billing_businessname', '', ['placeholder'=>'Business Name','class'=>'form-control']) }}

                                </div>

                                <div class="form-group">
                                    {{ Form::text('billing_home', '', ['placeholder'=>'Street Address','class'=>'form-control']) }}

                                </div>
                                <div class="form-group">
                                    {{ Form::text('billing_city', '', ['placeholder'=>'City','class'=>'form-control']) }}

                                </div>
                                <div class="form-group">
                                    {{ Form::text('billing_state', '', ['placeholder'=>'State','class'=>'form-control']) }}

                                </div>

                                <div class="form-group">
                                    {{ Form::text('billing_zip', '', ['placeholder'=>'Zip','maxlength'=>'10','class'=>'form-control']) }}

                                </div>
                                <div class="form-group">
                                    {{ Form::select('billing_country',[''=>'Select Country'],'',['class'=>'form-control selectinput']) }}
                                </div>
                            </div>     
                        </div>
                        <div class="col-sm-12">
                            <h5>Congratulations! One more step to pushing your business to new heights! You have a 30-day free trial — Way less than what you spend on a current advertising methods collectively!</h5>
                        </div>
                        <div class="col-sm-6">
                            {{ Form::checkbox('agree', 'no') }}
                            I agree with <a href="#">Terms and Conditions</a>
                        </div>
                        <div class="col-sm-6">

                            <button type="submit" class="btn btn-priamry call-to-action">Sign Up</button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>


