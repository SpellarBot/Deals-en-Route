@extends('admin.layouts.app')
@section('title', 'Deals en route|Setting')
@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Settings <small></small></h5>
            </div>
            <div class="ibox-content add-new-reminder-box">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-sm-4{{ $errors->has('profile_pic') ? ' has-error' : '' }}">
                                    {{ Form::label('company_logo', 'Company Logo',['class'=>"control-label"]) }}
                                    {{ Form::file('company_logo',null, ['class' => 'form-control']) }}
                                    <?php if (Route::getCurrentRoute()->getName() != 'users.create') { ?>
                                        <img class="img-preview img-preview-sm" id="companyLogoPreview" src="{{}}">
                                    <?php } ?>
                                    @if ($errors->has('company_logo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company_logo') }}</strong>
                                    </span>
                                    @endif

                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="clearfix"> </div>    
                </div>
            </div>
        </div>
    </div>
</div>




<div class="clearfix">

    {!! Form::submit('Save changes', ['class' => 'btn btn-primary pull-right btn-xs m-l-10']) !!}

    <a class="btn btn-white pull-right btn-xs" href="{{{ URL::route('users.index') }}}">Cancel</a>

</div>
@endsection
