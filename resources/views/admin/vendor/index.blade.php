@extends('admin.layouts.app')
@section('title', 'Deals en route|Vendors')
@section('content')   

<div class="panel-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins m-0">
                <div class="ibox-title">
                    <h5>Vendors<small></small></h5>
              
                </div>                            
                <div class="ibox-content">
                   
                            <div class="">
                                
                                <a href="{{ URL::to('admin/vendors/create') }}" class="btn btn-primary btn-s"><i class="fa fa-plus" aria-hidden="true"></i> Add New Vendor</a>
                            </div>
                       
         
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive contacts-table">
                                <table class="table table-striped table-bordered table-hover" id="vendortemplate">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Email</th>
                                            <th>Vendor Name</th>
                                            <th>Vendor Phone</th>
                                             <th><center> Action </center></th>
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
    var url = "{{ route('datatables.vendordata') }}";
</script>
<script src="{{ asset('backend/js/webjs/vendor.js') }}"></script>

@endsection


