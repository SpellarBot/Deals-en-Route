<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                Deals en Route
            </div>
            <div class="modal-body">
                <div class="col-sm-12"><br>
                    <p>You have used all your available deals for the month for the package. 
                        Please <a  href="javascript:void(0)" class="tooltip-test" id="changepackage" title="Change Package">change package</a>
                        or <a href="javascript:void(0)" class="tooltip-test" id="buyadddeals" title="Buy Additonal">buy additional deals</a> 
                        to create new deals. </p>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>

    </div>
</div>

<div id="packageUpgrade" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                Deals en Route
            </div>
            <div class="modal-body">
                <div class="col-sm-12"><br>
                    <p>Please upgrade to <a  href="javascript:void(0)" class="tooltip-test" id="changepackage" title="Change Package"> {{ ($subscription['stripe_plan']=='bronze')?'Silver/Gold':'Gold'  }} plan </a> to see analytics. 
                    </p>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>

    </div>
</div>

