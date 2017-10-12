@extends('admin.layouts.login')
@section('title', 'Deals en route|Login')
@section('content')

        @if ($message = Session::get('success'))

        <div class="alert alert-success" role="alert">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            {{ Session::get('success') }}

        </div>

        @endif


        @if ($message = Session::get('error'))

        <div class="alert alert-danger" role="alert">

            {{ Session::get('error') }}

        </div>

        @endif
<div class="ibox-content">
    <div>
        <h3 >Welcome to Deals en route admin panel </h1>
    </div>


    <form class="m-t" role="form" method="POST" action="{{ route('admin.login') }}">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('email')  ? ' has-error' : '' }}">

            {{ Form::text('email', old('email'), array('class' => 'form-control','placeholder'=>'email')) }}

            @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif

        </div>
        <div class="form-group{{ $errors->has('password')  ? ' has-error' : '' }}">

            {{ Form::password('password',  array('class' => 'form-control','placeholder'=>'password')) }}

            @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>



        {!! Form::submit('Login', ['class' => 'btn btn-primary block full-width m-b']) !!}


<!-- <a href="#">  <small>Forgot password?</small>  </a>-->

<!--  <p class="text-muted text-center">
         <small>Do not have an account?</small>
           </p>-->
        <!--    <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>-->
    </form>
</div>
<p class="m-t"> <small>SNS &copy; <?php echo date('Y'); ?></small> </p>

@endsection
