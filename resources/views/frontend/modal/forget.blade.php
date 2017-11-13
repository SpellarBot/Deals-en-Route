<div id="forgot-pass" class="modal fade" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="modal-body">
					 {{ Form::open(['class' => 'form','id'=>'forgetform']) }}
                                        {{ csrf_field() }}
						<div class="poplog">
							<div class="popupbg"><img src="<?php echo \Config::get('app.url')  . '/public/frontend/img/4.png'?>"></div>
							<div class="signupDEtails1">
								<div class="col-sm-12">
									<h4>Forgot Password</h4>
									<p>Please Enter your e-mail address and we will send you a password reset link.</p>
									<div class="form-group">
                                                                              {{ Form::text('email', '', ['placeholder'=>'Email','class'=>'form-control']) }}
								         	
									</div>
								</div>
								<div class="col-sm-12">
									<button type="submit" class="btn btn-priamry call-to-action">Submit</button>
								</div>
							</div>
						</div>
					 {{ Form::close() }}
				</div>
			</div>
		</div>
	</div>