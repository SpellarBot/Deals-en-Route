

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <div class="row">

                <div class="col-md-6 col-sm-4{{ $errors->has('vendor_name') ? ' has-error' : '' }}">
                    {{ Form::label('vendor_name', 'Vendor Name',['class'=>"control-label"]) }}
                    {{ Form::text('vendor_name', old('vendor_name'), ['class' => 'form-control','placeholder'=>'Enter Bussiness Name']) }}

                    @if ($errors->has('vendor_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('vendor_name') }}</strong>
                    </span>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6 col-sm-4{{ $errors->has('vendor_address') ? ' has-error' : '' }}">
                    {{ Form::label('vendor_address', 'Vendor Address',['class'=>"control-label"]) }}
                    {{ Form::textarea('vendor_address', old('vendor_address'),['class' => 'form-control','placeholder'=>'Enter Bussiness Address']) }}
                    @if ($errors->has('vendor_address'))
                    <span class="help-block">
                        <strong>{{ $errors->first('vendor_address') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6 col-sm-4{{ $errors->has('vendor_city') ? ' has-error' : '' }}">
                    {{ Form::label('vendor_city', 'Vendor City/State',['class'=>"control-label"]) }}
                    {{ Form::text('vendor_city', old('vendor_city'),['class' => 'form-control','placeholder'=>'Enter City/State']) }}
                    @if ($errors->has('vendor_city'))
                    <span class="help-block">
                        <strong>{{ $errors->first('vendor_city') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">

            <div class="row">

                <div class="col-md-6 col-sm-4{{ $errors->has('email') ? ' has-error' : '' }}">
                    {{ Form::label('email', 'Vendor Email',['class'=>"control-label"]) }}
                    {{ Form::text('email',null, ['class' => 'form-control','placeholder'=>'Enter Email']) }}

                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif

                </div>


            </div>
        </div>
    </div>
      @if(Route::getCurrentRoute()->getName()=='vendors.create')
 <div class="col-md-12">
        <div class="form-group">

             <div class="row">
                <div class="col-md-6 col-sm-4{{ $errors->has('password') ? ' has-error' : '' }}">
                    {{ Form::label('password', 'Password',['class'=>"control-label"]) }}
                   
                    {{ Form::input('password', 'password','',['class'=>"form-control",'placeholder'=>'Enter Password']) }}
                     
                   
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif

                </div>
            </div>

        </div>
    </div>
  @endif
    <div class="col-md-12">
        <div class="form-group">

            <div class="row">
                    
                <div class="col-md-6 col-sm-4{{ $errors->has('vendor_phone') ? ' has-error' : '' }}">
                    {{ Form::label('vendor_phone', 'Vendor Phone',['class'=>"control-label"]) }}
                    {{ Form::text('vendor_phone',null, ['class' => 'form-control',
                     'placeholder'=>'Enter Phone','data-mask'=>"9-999-999-9999"]) }}

                    @if ($errors->has('vendor_phone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('vendor_phone') }}</strong>
                    </span>
                    @endif

                </div>
            </div>

        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6 col-sm-4{{ $errors->has('vendor_logo') ? ' has-error' : '' }}">
                    {{ Form::label('vendor_logo', 'Vendor Logo',['class'=>"control-label"]) }}
                    {{ Form::file('vendor_logo',null, ['class' => 'form-control']) }}
                    <?php  if(Route::getCurrentRoute()->getName()!='vendors.create') { ?>
                           <img class="img-preview img-preview-sm" id="companyLogoPreview" src="{{$imagePath}}">
                    <?php } ?>
                    @if ($errors->has('vendor_logo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('vendor_logo') }}</strong>
                    </span>
                    @endif

                </div>


            </div>
        </div>
    </div>
    <div class="clearfix"> </div>
    
      <div class="col-md-12">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6 col-sm-4{{ $errors->has('vendor_category') ? ' has-error' : '' }}">
                    {{ Form::label('vendor_category', 'Vendor Category',['class'=>"control-label"]) }}
          
                    {{ Form::select('vendor_category[]',$categoryList,isset($users)?explode(',',$users->vendor_category):'',
                    ['multiple'=>'multiple','class'=>'form-control select2_vendor'])}}
        
                    @if ($errors->has('vendor_category'))
                    <span class="help-block">
                        <strong>{{ $errors->first('vendor_category') }}</strong>
                    </span>
                    @endif

                </div>
            </div>
        </div>
    </div>
    
        <div class="col-md-12">
        <div class="form-group">

            <div class="row">
                <div class="col-md-6 col-sm-4{{ $errors->has('vendor_zip') ? ' has-error' : '' }}">
                    {{ Form::label('vendor_zip', 'Vendor Zip Code',['class'=>"control-label"]) }}
                    {{ Form::text('vendor_zip',null, ['class' => 'form-control','placeholder'=>'Enter Zip']) }}

                    @if ($errors->has('vendor_zip'))
                    <span class="help-block">
                        <strong>{{ $errors->first('vendor_zip') }}</strong>
                    </span>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

<div class="clearfix">
    @if ($show == 1)
    {!! Form::submit('Save changes', ['class' => 'btn btn-primary pull-right btn-xs m-l-10']) !!}
    @endif
    <a class="btn btn-white pull-right btn-xs" href="{{{ URL::route('vendors.index') }}}">Cancel</a>

</div>
