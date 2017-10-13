

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <div class="row">




                <div class="col-md-4 col-sm-4{{ $errors->has('first_name') ? ' has-error' : '' }}">
                    {{ Form::label('first_name', 'First Name',['class'=>"control-label"]) }}
                    {{ Form::text('first_name', old('first_name'), array('class' => 'form-control')) }}

                    @if ($errors->has('first_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                    @endif

                </div>

                <div class="col-md-4 col-sm-4{{ $errors->has('last_name') ? ' has-error' : '' }}">
                    {{ Form::label('last_name', 'Last Name',['class'=>"control-label"]) }}
                    {{ Form::text('last_name', old('last_name'),['class' => 'form-control']) }}
                    @if ($errors->has('last_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">

            <div class="row">

                <div class="col-md-4 col-sm-4{{ $errors->has('dob') ? ' has-error' : '' }}">
                    <div class="form-group">    
                        <label>DOB :</label>
                        <div id="input-group-datepicker" class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span> {{ Form::text('dob',old('dob'), ['class' => 'form-control']) }}
                            @if ($errors->has('dob'))
                            <span class="help-block">
                                <strong>{{ $errors->first('dob') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">

            <div class="row">

                <div class="col-md-4 col-sm-4{{ $errors->has('email') ? ' has-error' : '' }}">
                    {{ Form::label('email', 'Email',['class'=>"control-label"]) }}
                    {{ Form::text('email',null, ['class' => 'form-control']) }}

                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif

                </div>


            </div>
        </div>
    </div>
</div>

 <div class="col-md-12">
        <div class="form-group">

            <div class="row">


    <div class="col-md-4 col-sm-4{{ $errors->has('phone') ? ' has-error' : '' }}">
        {{ Form::label('phone', 'Phone',['class'=>"control-label"]) }}
        {{ Form::text('phone',null, ['class' => 'form-control']) }}

        @if ($errors->has('phone'))
        <span class="help-block">
            <strong>{{ $errors->first('phone') }}</strong>
        </span>
        @endif

    </div>
</div>

</div>
</div>
 <div class="col-md-12">
        <div class="form-group">

            <div class="row">

          

                <div class="col-md-4 col-sm-4{{ $errors->has('profile_pic') ? ' has-error' : '' }}">
                    {{ Form::label('profile_pic', 'Profile pic',['class'=>"control-label"]) }}
                    {{ Form::text('profile_pic',null, ['class' => 'form-control']) }}

                    @if ($errors->has('profile_pic'))
                    <span class="help-block">
                        <strong>{{ $errors->first('profile_pic') }}</strong>
                    </span>
                    @endif

                </div>


            </div>
        </div>
    </div>

<div class="clearfix">
    {!! Form::submit('Save changes', ['class' => 'btn btn-primary pull-right btn-xs m-l-10']) !!}
    <a class="btn btn-white pull-right btn-xs" href="{{{ URL::route('users.index') }}}">Cancel</a>

</div>
