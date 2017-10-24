@extends('admin.layouts.app')
@section('title', 'Deals en route|Add Vendors')
@section('content')   
  <div class="row">
<div class="col-lg-12">
  
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Add Contacts <small></small></h5>
           
        </div>
        <div class="ibox-content add-new-reminder-box">
            <div class="">

                {{ Form::open(['route' => 'vendors.store', 'id' => 'contact-form','files'=> true]) }}
                {{ csrf_field() }}
                 @include("admin/vendor/_form")
                             
                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    var url = "{{ route('datatables.vendordata') }}";
</script>
<script src="{{ asset('js/webjs/vendor.js') }}"></script>


@endsection



