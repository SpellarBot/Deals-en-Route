<div id="buygeofencearea" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                Deals en Route
            </div>
            <div class="modal-body">
                <div class="col-sm-12"><br>
                    <h5 class="package-title">Additional Items:</h5>
                    <div class="package-add">
                        <p class="package-addon1">Geo-Fencing</p>
                        <p class="package-addon2">Geo-Fencing - $4.99/20,000 sq.ft.</p>
                        <form class="additional_fencing_coupon">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select class="form-control" name="extra_fensing_area" id="extra_fence">
                                            <option value="">Select Fencing</option>
                                            <option value="20000">20,000</option>
                                            <option value="40000">40,000</option>
                                            <option value="60000">60,000</option>
                                            <option value="80000">80,000</option>
                                            <option value="100000">1,00,000</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-pack btn-buy1">Buy</button>

                            </div>

                        </form>
                        <p class="package-addon3">Available geo fencing - {!! number_format($total_geofencing,2) !!} sq.ft</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>

    </div>
</div>