@extends('layouts.app')
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
 
                {!! Form::model($contact, [
                    'method' => 'PATCH',
                    'route' => ['contacts.update', $contact->cardcode]
                ]) !!}
               
                {{ csrf_field() }}
                <!-- https://laracast.blogspot.in/2016/06/laravel-ajax-crud-search-sort-and.html  -->
                  @include("contacts/_form")
                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    var url = "{{ route('datatables.data') }}";
</script>
<script src="{{ asset('js/webjs/contacts.js') }}"> </script>

@endsection



