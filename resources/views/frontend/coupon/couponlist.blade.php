<div id="create" class="tab-pane fade in">
    <div class="content content-create">
        <div class="container-fluid">
                <div class="row">
                        <div class="col-md-7">
                                <div class="card">
                                        <div class="header">
                                                <h5 class="title" align="left" style="padding-top: 24px;">Created Coupons</h5>
                                        </div>
                                        <div class="content coupons-tab">
                                                <div class="row">
                                                        <div class="card-content table-responsive">
                                                                <div class="toolbar">
                                                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                                                </div>
                                                                <table id="bootstrap-table2" class="table">
                                                                        <thead>
                                                                                <tr>
                                                                                        <th data-field="logo">Logo</th>
                                                                                        <th data-field="name" data-sortable="true">Coupon Name</th>
                                                                                        <th data-field="total" data-sortable="true">Created</th>
                                                                                        <th data-field="coup-redeemed" data-sortable="true">Redeemed</th>
                                                                                        <th data-field="coup-active" data-sortable="true">Active</th>
                                                                                        <th data-field="actions" class="td-actions text-right" data-events="operateEvents" data-formatter="operateFormatter">Actions</th>
                                                                                </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                     
                                                                       @foreach ($coupon_lists as $coupon_list)
                                                                       <tr id="{{$coupon_list->coupon_id }}">
                                                                                    <td><img src="{{$coupon_list->coupon_logo }}" ></td>
                                                                                        <td> {{ $coupon_list->coupon_name }}</td>
                                                                                        <td>{{ $coupon_list->coupon_redeem_limit }}</td>
                                                                                        <td>{{ $coupon_list->coupon_total_redeem }}</td>
                                                                                        <td>{{ $coupon_list->coupon_redeem_limit-$coupon_list->coupon_total_redeem }}</td>
                                                                                        <td></td>
                                                                                </tr>
                                                                           @endforeach
                                                                        </tbody>
                                                                </table>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                        <div class="col-md-5">
                                <div class="card">
                                        <div class="header">
                                                <h4 class="title">Click Below to create your coupon</h4>
                                        </div>
                                        <div class="content">
                                                <div class="row create-img1" style="text-align: center;"> <img src="{{ \Config::get('app.url') . '/public/frontend/img/coupon.png' }}" width="200" alt=""> </div>
                                                <div class="footer" style="text-align: center;">
                                                        <div class="row create-btn1"> <a href="#create2" data-toggle="tab" class="btn btn-info btn-fill btn-wd btn-create">Create Now</a> </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
    </div>
</div>



