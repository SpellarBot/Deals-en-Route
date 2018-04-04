@extends('frontend.layouts.price')

@section('content')
<div class="container">
    <div class="row">
        
        
        
         <div class="errorpopup">
                      
                  
                   @if(Session::has('message'))
                      <div class="alert-fade alert-danger custom-alert">
                <div class="alert alert-danger alert-dismissable" role="alert"  >
                    <!-- <button type="button" class="close " aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                    <div class="close-circle"></div>
                    <div class="alert-content">
                        <h3 class="success-text">Failed</h3>
                        {{ Session::get('message') }}
                    </div>
                    <button type="button" class="btn btn-success closepopup" aria-label="Close" aria-hidden="true">OK</button>
                </div>
            </div>
                  
                    @endif
                
     </div>  
        
      
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                      

                    <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                     

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" >

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

