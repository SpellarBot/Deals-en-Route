@extends('frontend.layouts.price')

@section('content')

<div class="container">
    <div class="row">


        <div class="errorpopup">
            @if(Session::has('success'))
            <div class="alert-fade alert-success custom-alert" >
                <div class="alert  alert-success alert-dismissable" role="alert"  >
                    <!-- <button type="button" class="close " aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                    <div class="tick-mark-circle"></div>
                    <div class="alert-content">
                        <h3 class="success-text">Success</h3>
                        {{ Session::get('success') }}
                    </div>
                    <button type="button" class="btn btn-success closepopup" aria-label="Close" aria-hidden="true">OK</button>
                </div>
            </div>
            @endif
       
        @if(Session::has('error'))
        <div class="alert-fade alert-danger custom-alert">
            <div class="alert alert-danger alert-dismissable" role="alert"  >
                <!-- <button type="button" class="close " aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                <div class="close-circle"></div>
                <div class="alert-content">
                    <h3 class="success-text">Failed</h3>
                    {{ Session::get('error') }}
                </div>
                <button type="button" class="btn btn-success closepopup" aria-label="Close" aria-hidden="true">OK</button>
            </div>
        </div>
        @endif
    </div>

</div>
</div>


@endsection