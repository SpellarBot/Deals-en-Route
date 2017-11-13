<div id="create2" class="tab-pane fade in">
        <div class="content content-create">
                <div class="container-fluid">
                        <div class="row">
                                <div class="col-md-12">
                                        <div class="card">
                                                <div class="content">
                                                        <div class="wizard">
                                                                <div class="wizard-inner">
                                                                        <div class="connecting-line"></div>
                                                                        <ul class="nav nav-tabs nav-tabs-step" role="tablist">
                                                                                <li role="presentation" class="active"> <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab"> <span class="round-tab"> 1 </span> </a> </li>
                                                                                <li role="presentation" class="disabled"> <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab"> <span class="round-tab"> 2 </span> </a> </li>
                                                                                <li role="presentation" class="disabled"> <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"> <span class="round-tab"> 3 </span> </a> </li>
                                                                        </ul>
                                                                </div>
                                                              
                                                                {{ Form::open([ 'id' => 'create-coupon','file'=>true]) }}
                                                                {{ csrf_field() }}
                                                                @include("frontend/coupon/_form",['vendor_detail'=>$vendor_detail])

                                                                {{ Form::close() }}

                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>



