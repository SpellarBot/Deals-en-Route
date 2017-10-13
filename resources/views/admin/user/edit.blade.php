@extends('admin.layouts.app')
@section('title', 'SNS|Edit Contacts')
@section('content')   

<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Add Contacts <small></small></h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content add-new-reminder-box">
            <div class="">
 
                {!! Form::model($users, [
                    'method' => 'PATCH',
                    'route' => ['users.update', $users->id]
                ]) !!}
               
                {{ csrf_field() }}
                <!-- https://laracast.blogspot.in/2016/06/laravel-ajax-crud-search-sort-and.html  -->
                  @include("admin/user/_form")
                {{ Form::close() }}

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



