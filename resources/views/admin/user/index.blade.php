@extends('admin.layouts.app')
@section('title', 'Deals en route|Users')
@section('content')   


@section('title', 'SNS|Templates')

<div class="panel-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins m-0">
                <div class="ibox-title">
                    <h5>Templates<small></small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>                            
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="">
                                <a href="#" class="btn btn-primary pull-right btn-xs refreshstable"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                <a href="{{ URL::to('users/create') }}" class="btn btn-primary pull-right m-r-10 btn-xs"><i class="fa fa-plus" aria-hidden="true"></i> Add New User</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive contacts-table">
                                <table class="table table-striped table-bordered table-hover" id="usertemplate">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Email</th>
                                            <th>First Name</th>
                                            <th >Last Name</th>
                                            <th>Dob</th>
                                            <th >Edit</th>
                                            <th>Remove</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
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


