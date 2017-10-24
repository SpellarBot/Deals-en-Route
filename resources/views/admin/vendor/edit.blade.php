@extends('admin.layouts.app')
@section('title', 'Deals en route|Edit Vendors')
@section('content')   
<div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Edit Vendors <small></small></h5>
            <div class="ibox-tools">
             
            </div>
        </div>
        <div class="ibox-content add-new-user-box">
            <div class="">
 
                {{ Form::model($users, [
                    'method' => 'PATCH',
                    'route' => ['vendors.update', $users->id],
                    'files'=> true
                ]) }}
               
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



