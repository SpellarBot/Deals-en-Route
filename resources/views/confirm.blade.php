@extends('layouts.password')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                 @if(Session::has('success'))
                  <div class="alert alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      {{ Session::get('success') }}
                  </div>  
                  @endif
                  @if(Session::has('error'))
                  <div class="alert alert-danger alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      {{ Session::get('error') }}
                  </div>  
                  @endif

            </div>
        </div>
    </div>
            
       
 @endsection