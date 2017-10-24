@extends('admin.layouts.app')

@section('content')

<div class="panel-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins m-0">
                <div class="ibox-title">
                    <h5>Reset Password<small></small></h5>
              
                </div>                            
                <div class="ibox-content">
             
 
                <div class="panel-body">
                      @if(Session::has('message'))
                      
                    <p class="alert alert-danger">
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                           {{ Session::get('message') }}</p>
                    @endif
                       {{ Form::model($users, [
                    'method' => 'PATCH',
                    'route' => ['admin.store', $users->id],
                    'class' => 'form-horizontal'
                ]) }}
                      
               <input type="hidden" name="id" value="{{  $users->id }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

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
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
 
@endsection

