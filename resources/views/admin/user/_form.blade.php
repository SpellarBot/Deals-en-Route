 <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                
                                <div class="col-md-3 col-sm-3{{ $errors->has('salutation') ? ' has-error' : '' }}">
                                    {{ Form::label('salutation', 'Name') }}  
                                    {{ Form::select('salutation',array_merge([""=>'Please select salutation'],$salutation),null,['class'=>'form-control'])}}
                                    @if ($errors->has('salutation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('salutation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                
                                

                                <div class="col-md-3 col-sm-3{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                    {{ Form::label('firstname', 'First Name',['class'=>"control-label"]) }}
                                    {{ Form::text('firstname', old('firstname'), array('class' => 'form-control')) }}

                                    @if ($errors->has('firstname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                    @endif

                                </div>
                                <div class="col-md-3 col-sm-3{{ $errors->has('middlename') ? ' has-error' : '' }}">
                                    {{ Form::label('middlename', 'Middle Name',['class'=>"control-label"]) }}
                                    {{ Form::text('middlename', old('middlename'), array('class' => 'form-control')) }}

                                    @if ($errors->has('middlename'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('middlename') }}</strong>
                                    </span>
                                    @endif

                                </div>
                                <div class="col-md-3 col-sm-3{{ $errors->has('lastname') ? ' has-error' : '' }}">
                                    {{ Form::label('lastname', 'Last Name',['class'=>"control-label"]) }}
                                    {{ Form::text('lastname', old('lastname'),['class' => 'form-control']) }}
                                    @if ($errors->has('lastname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <div class="row">
                                <div class="col-md-4 col-sm-4{{ $errors->has('country_id') ? ' has-error' : '' }}">
                                    {{ Form::label('country_id', 'Country',['class'=>"control-label"]) }}  
                                    {{ Form::select('country_id',[""=>"Please select country code"]+$countrycode,null,['class'=>'form-control'])}}
                                    @if ($errors->has('country_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country_id') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="col-md-4 col-sm-4{{ $errors->has('phonenumber') ? ' has-error' : '' }}">
                                    {{ Form::label('phonenumber', 'Number',['class'=>"control-label"]) }}
                                    {{ Form::text('phonenumber', old('phonenumber'), ['class' => 'form-control','maxlength' => 20]) }}
                                    @if ($errors->has('phonenumber'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phonenumber') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-md-4 col-sm-4{{ $errors->has('phonetype') ? ' has-error' : '' }}">
                                    {{ Form::label('phonetype', 'Phone type') }}  
                                    {{ Form::select('phonetype',array_merge([''=>'Please enter phone type'],$phonetype),null,['class'=>'form-control'])}}
                                    @if ($errors->has('phonetype'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phonetype') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email Address</label>
                            <div class="row">

                                <div class="col-md-8 col-sm-8{{ $errors->has('email') ? ' has-error' : '' }}">
                                    {{ Form::label('email', 'Email',['class'=>"control-label"]) }}
                                    {{ Form::text('email',null, array('class' => 'form-control')) }}

                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif

                                </div>
                                <div class="col-md-4 col-sm-4{{ $errors->has('emailtype') ? ' has-error' : '' }}">
                                    {{ Form::label('emailtype', 'Email type') }}  
                                    {{ Form::select('emailtype',array_merge([''=>'Please select email type'],$emailtype),null,['class'=>'form-control'])}}
                                    @if ($errors->has('emailtype'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('emailtype') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                 
                    <div class="col-md-6 col-sm-6{{ $errors->has('dob') ? ' has-error' : '' }}">
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

                    <div class="col-md-6 col-sm-6{{ $errors->has('zipcode') ? ' has-error' : '' }}">
                        {{ Form::label('zipcode', 'Zip Code') }}  
                          {{ Form::text('zipcode', old('zipcode'), ['class' => 'form-control','maxlength' => 10]) }}
                        @if ($errors->has('zipcode'))
                        <span class="help-block">
                            <strong>{{ $errors->first('zipcode') }}</strong>
                        </span>
                        @endif
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12{{ $errors->has('notes') ? ' has-error' : '' }}">
                        <div class="form-group">          
                            {{ Form::label('notes', 'Notes') }} 
                            {{ Form::textarea('notes', null, ['class' => 'form-control contactnote']) }}

                            @if ($errors->has('notes'))
                            <span class="help-block">
                                <strong>{{ $errors->first('notes') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="clearfix">
                    {!! Form::submit('Save changes', ['class' => 'btn btn-primary pull-right btn-xs m-l-10']) !!}
                   <a class="btn btn-white pull-right btn-xs" href="{{{ URL::route('contacts.index') }}}">Cancel</a>

                </div>