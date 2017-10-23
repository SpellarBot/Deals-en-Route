@extends('admin.layouts.app')
@section('title', 'Deals en route|Edit Users')
@section('content')   
<div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Edit Users <small></small></h5>
            <div class="ibox-tools">
             
            </div>
        </div>
        <div class="ibox-content add-new-user-box">
            <div class="">
 
                {{ Form::model($users, [
                    'method' => 'PATCH',
                    'route' => ['users.update', $users->id],
                    'files'=> true
                ]) }}
               
                {{ csrf_field() }}
            
                  @include("admin/user/_form")
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



