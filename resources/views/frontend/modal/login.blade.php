<div id="login" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="errorpopup">
                
              <div class="alert-fade alert-success custom-alert"  style="display: none">
                <div class="alert  alert-success alert-dismissable" role="alert"  >
                    <!-- <button type="button" class="close " aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                    <div class="tick-mark-circle"></div>
                    <div class="alert-content">
                        <h3 class="success-text">Success</h3>
                        <div class="successmessage"> </div>
                    </div>
                    <button type="button" class="btn btn-success closepopup" aria-label="Close" aria-hidden="true">OK</button>
                </div>
            </div>
              
                <div class="alert-fade alert-danger custom-alert" style="display: none">
                <div class="alert alert-danger alert-dismissable" role="alert"  >
                    <!-- <button type="button" class="close " aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                    <div class="close-circle"></div>
                    <div class="alert-content">
                        <h3 class="success-text">Failed</h3>
                         <div class="errormessage"> </div>
                    </div>
                    <button type="button" class="btn btn-success closepopup" aria-label="Close" aria-hidden="true">OK</button>
                </div>
            </div>
            </div>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="modal-body">
                {{ Form::open(['route' => 'vendor.login', 'class' => 'form','id'=>'loginform']) }}
                {{ csrf_field() }}

                <div class="poplog">
                    <div class="popupbg">  <img src="<?php echo \Config::get('app.url') . '/public/frontend/img/4.png' ?>"></div>
                    <div class="signupDEtails">
                        <div class="col-sm-12">
                            <h4>Login Details</h4>
                            <div class="form-group">
                                {{ Form::text('email', '', ['placeholder'=>'Email','class'=>'form-control']) }}

                            </div>
                            <div class="form-group">
                                {{ Form::password('password', ['placeholder'=>'Password','class'=>'form-control']) }}

                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-priamry call-to-action">Login</button>
                            <h5 class="text-center">Forgot your password? <a href="#forgot-pass" data-toggle="modal" data-dismiss="modal">Click Here</a> </h5>
                            <h5 class="text-center">Don't have an account? <a href="#popup" data-toggle="modal" data-dismiss="modal" class="registerForm">Register Here</a> </h5>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@include('frontend/modal/forget')