@extends('admin.layouts.app')
@section('title', 'Deals en route|Users')
@section('content')   

<div class="panel-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins m-0">
                <div class="ibox-title">
                    <h5>Users<small></small></h5>
              
                </div>                            
                <div class="ibox-content">
                   
                            <div class="">
                                
                                <a href="{{ URL::to('admin/users/create') }}" class="btn btn-primary btn-s"><i class="fa fa-plus" aria-hidden="true"></i> Add New User</a>
                            </div>
                       
         
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive contacts-table">
                                <table class="table table-striped table-bordered table-hover" id="usertemplate">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Email</th>
                                            <th>Full Name</th>
                                            <th>Dob</th>
                                            <th >Edit</th>
                                            <th>Active</th>
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


