<body class="price-page">
     <header class="header">
		<div>
			<div class="header-logo">
				<a href="#" class="logo"> <img src="<?php echo \Config::get('app.url') . '/public/frontend/img/logo.png' ?>"</a>
			</div>
		</div>
	</header>
     <div id="loadingDiv"> <img src="<?php echo \Config::get('app.url') . '/public/frontend/img/489.gif' ?>" class="loading-gif"></div>
     
       
               <div class="errorpopup">
                  <div class="alert alert-success alert-dismissible" role="alert" style="display: none">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      {{ Session::get('success') }}
                  </div>  
                  
               
                  <div class="alert alert-danger alert-dismissible" role="alert" style="display: none">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      {{ Session::get('error') }}
                  </div>  
               </div>
   
	<section class="prices">
		<div class="container">
			<div class="row p-flex">
				<div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-3 cardm">
					<p class="head">GOLD</p>
					<p class="price"><sup>$</sup>149</p>
					<p class="price-pm">PER MONTH</p>
					<p class="deals">~ Create and Send Coupons
						<br><br> ~ Geolocation (Mile Radius 5-10 miles)
						<br><br> ~ Geofencing (2 events up to 20,00 sq. feet-leftover sq. feet doesn't roll over)
						<br><br> ~ Analytics ( Age + Gender + Coupon Views + Potential Customer Reach)
						<br><br> ~ 30 Deals/ Unlimited Deals
						<br><br> ~ Sticker for Store window (Deals en Route certified)</p>
					<p class="head2">Additional Packages</p>
					<p class="deals">Geolocation - $4.99/additional mile
						<br><br> Geo Fencing - $4.99/20,000 square feet</p>
					<p class="discl">*Coupons don't roll/carry over to next month
						<br><br> *Commission is equal to 30% of the face value discount the coupon provides. If this is less than $1.00, DER will receive $1.00</p>
					<button type="button" class="btn btn-want" value="gold">I want this one</button>
				</div>
				<div class="col-md-4 col-sm-6 cards cards2">
					<p class="head">SILVER</p>
					<p class="price"><sup>$</sup>99</p>
					<p class="price-pm">PER MONTH</p>
					<p class="deals">~ Create and Send Coupons
						<br><br> ~ Geolocation (Mile Radius 1-5 Miles)
						<br><br> ~ Analytics ( Age + Gender)
						<br><br> ~ 20 Deals / Unlimited Coupons
						<br><br> ~ Sticker for Store window (Deals en Route certified)</p>
					<p class="head2">Additional Packages</p>
					<p class="deals">Geolocation - $4.99/additional mile
						<br><br> Geo Fencing - $4.99/20,000 square feet</p>
					<p class="discl">*Coupons don't roll/carry over to next month
						<br><br> *Commission is equal to 30% of the face value discount the coupon provides. If this is less than $1.00, DER will receive $1.00</p>
					<button type="button" class="btn btn-want" value="silver">I want this one</button>
				</div>
				<div class="col-md-4 col-sm-6 cards cards1">
					<p class="head">BRONZE</p>
					<p class="price"><sup>$</sup>49</p>
					<p class="price-pm">PER MONTH</p>
					<p class="deals">~ Create and Send Coupons
						<br><br> ~ Geolocation (Mile Radius 0-1 Miles)
						<br><br> ~ 10 Deals / Unlimited Coupons
						<br><br> ~ Sticker for Store window (Deals en Route certified)</p>
					<p class="head2">Additional Packages</p>
					<p class="deals">Geolocation - $4.99/additional mile
						<br><br> Geo Fencing - $4.99/20,000 square feet</p>
					<p class="discl">*Coupons don't roll/carry over to next month
						<br><br> *Commission is equal to 30% of the face value discount the coupon provides. If this is less than $1.00, DER will receive $1.00</p>
					<button type="button" class="btn btn-want btn-want1" value="bronze">I want this one</button>
				</div>
			</div>
		</div>
	</section>


<script type="text/javascript">
     $('.btn-want').on('click', function (e) {
          e.preventDefault();
         $.ajax({
            url: "register/subcription",
            type: 'POST',
            data: {'plan_id':$(this).val(),'user_id':"<?php echo $user_id ?>"},
            success: function (data) {
             if(data.status==1){
              location.reload();
             }else{
             window.location.href = $('#hidAbsUrl').val();
            }
            },
             beforeSend: function () {
              $('#loadingDiv').show();
            },
            complete: function () {
             $('#loadingDiv').hide();
            },
            error: function (data) {
                 window.location.href = $('#hidAbsUrl').val();
            },
        
     });
    
    }); 
</script>   
        @if (Session::has('success'))
                <script type="text/javascript">
                     setFlashSuccessNotification();
                </script>
        @endif
          @if (Session::has('error'))   
                <script type="text/javascript">
                    setFlashErrorNotification();
                </script>
        @endif
</body>
</html>
