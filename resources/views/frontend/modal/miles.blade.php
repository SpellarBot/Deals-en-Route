<div id="buyextramiles" class="modal fade" role="dialog">
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
                        <p class="package-addon1">Additional-Miles</p>
                        <p class="package-addon2">Additional-Miles - $4.99/mile</p>
                        <form class="additional_miles">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select class="form-control" name="extra_miles">
                                            <option value="">Select Miles</option>
                                            @for($i=1;$i<=100;$i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>

                                    </div>
                                </div>
                                <button type="submit" class="btn btn-pack btn-buy1">Buy</button>

                            </div>

                        </form>
                        <p class="package-addon3">Available Miles - {!! number_format($user_access['geolocationtotal']) !!} Miles</p>    
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>

    </div>
</div>