@extends('admin.layouts.app')
@section('title', 'Deals en route|Add Users')
@section('content')   
  <div class="row">
<div class="col-lg-12">
  
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Add Contacts <small></small></h5>
           
        </div>
        <div class="ibox-content add-new-reminder-box">
            <div class="">

                {{ Form::open(['route' => 'users.store', 'id' => 'contact-form','files'=> true]) }}
                {{ csrf_field() }}
                 @include("admin/user/_form")
                <!-- https://laracast.blogspot.in/2016/06/laravel-ajax-crud-search-sort-and.html  -->
               
                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    var url = "{{ route('datatables.userdata') }}";
</script>
<script src="{{ asset('js/webjs/users.js') }}"></script>


@endsection



