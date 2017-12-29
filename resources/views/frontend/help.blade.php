@extends('frontend.layouts.login')
@section('title', 'Deals en Route|Help')
@section('content')

<style type="text/css">
 
 h4{
  font-weight: bold;
 }
 h2{
  color: #395999;
 }

</style>
<header class="staticpage">
		<div class="container">
			<div class="header">
				<div class="row">
					<div class="col-xs-4">
						<a href="{{ route('vendorindex')}}" class="logo">
							<img src="<?php echo \Config::get('app.url') . '/public/frontend/img/logo.png' ?>">
						</a>
					</div>
					<div class="col-xs-8 text-right">
						<h2>FAQs</h2>
					</div>
				</div>
			</div>
		</div>
	</header>

	<section class="staticmain">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					
					<h2 style="margin-bottom: 20px;">User</h2>

					<h4>Q: How do I find more information about a deal?</h4>
					<p>A: You will find deals in the Deals en Route application that are tailored to your preferences and location. All you have to do is go about your day and we do the work for you.</p>

					<h4>Q: Why didn’t my promo code work?</h4>
					<p>A: The coupon may have been expired or there may not have been any coupons left in the deal. It could also be that either the business or user (you) had internet connectivity issues which didn’t allow the deal to be processed properly. If problem persists, please email <a href="mailto:support@dealsenroute.com">support@dealsenroute.com</a></p>

					<h4>Q: Application keeps crashing?</h4>
					<p>A: If you come across this problem please contact our technical support team that will be happy to assist you and solve this problem for you at <a href="mailto:support@dealsenroute.com">support@dealsenroute.com</a></p>

					<h4>Q: Suggestions to make your experience better?</h4>
					<p>A: We are always open to enhancing customer experience, so if you have any ideas, questions or suggestion please feel free to send us a message at <a href="mailto:support@dealsenroute.com">support@dealsenroute.com</a></p>

					<h4>Q: I can’t share my coupon with a friend?e</h4>
					<p>A: It may be that your friend is not on Deals en Route app yet, make sure you are friends them on whatever method you used to sign up (Facebook, Twitter, Gmail) as we use those sites to send out invitations to them so they can download the app and start using the coupon you shared with them. When you click share you will be able to search for your friend in the app or scroll through your list of friends and send them either an invite for the app or share the coupon with them if they are already a Deals en Route user.</p>

					<h4>Q: I am having problems with signing up or experiencing other issues:</h4>
					<p>A: Please contact our customer support specialists who will gladly help you resolve your issue. Please contact us at <a href="mailto:support@dealsenroute.com">support@dealsenroute.com</a></p>
	
					
					<h2 style="margin-bottom: 20px;">Business</h2>

					<h4>Q: Can I get a refund?</h4>
					<p>A: As mentioned in the Terms & Condition we review refunds as case by case. Our goal is to provide 100% customer satisfaction. Please submit any questions you may have to <a href="mailto:support@dealsenroute.com">support@dealsenroute.com</a> and we will work with you to resolve the problem you may be encountering.</p>

					<h4>Q: Credit card failed or invalid at sign up or monthly renewal?</h4>
					<p>A: No worries, this could happen to anyone. Please check your internet connection or contact your bank to see if they could see anything on their end for declined transaction. If the problem persists, please contact us as <a href="mailto:support@dealsenroute.com">support@dealsenroute.com</a>.</p>

					<h4>Q: Cancelling subscription, Upgrading, Downgrading?</h4>
					<p>A: In order to upgrade, downgrade or cancel monthly subscription plan you will have to navigate to the settings tab under your profile after you log in and you will be able to make adjustments there. Remember, if you choose to change your plan whether it’s cancelling, upgrading or downgrading your plan your deals will be lost and will not carry over to the next month. It is suggested that you wait until the end of the month to make changes to your plan to allow for most efficient use of your package.</p>

					<h4>Q: Will I have to manually pay, and what happens after my one month trial expires.</h4>
					<p>A: Once you sign up for the free trial, thereafter you will be charged on a monthly basis automatically. If you wish not to use our service after signup, you will need to manually cancel your plan under settings or contact us in advance to cancel it for you. There will be no refunds offered for failed cancellations after free trial expiration.</p>

					<h4>Q: Additional Features (geolocation, geofencing, deals)</h4>
					<p>A: Additional Features purchased within a plan will not carry over to next month so please make sure to use your features accordingly.</p>

					<h4>Q: Suggestions to make your experience better?</h4>
					<p>A: We are always open to enhancing customer experience, so if you have any ideas, questions or suggestion please feel free to send us a message at <a href="mailto:support@dealsenroute.com">support@dealsenroute.com</a></p>

					<h4>Q: How long can I set my deals for:</h4>
					<p>A: Longest period you can have a deal running for is 30 days.</p>

					<h4>Q: Why can’t I have unlimited deals?</h4>
					<p>A: Through numerous surveys and interviews we had with customers/users we have found that sending copious amounts of notifications to a user may annoy them which would lead to deletion of the app which would not only hurt Deals en Route but your business as well. Therefore in order to find a balance we have limited the number of deals businesses can send out by different tiered packages. Don’t worry you can have unlimited coupons in a deal.</p>

					<h4>Q: What is the difference between a deal and a coupon?</h4>
					<p>A: The number of deals are limited based on the plan you have selected. A deal would be one single deal that the user would see however within a deal you have the option to select how many coupons you want a certain deal to have. For example: You could have a deal for pizza, and within that deal you could have 150 available coupons, once you had 150 redemptions then that deal will no longer be available as all the coupons will be used up.</p>

					<h4>Q: I am having problems with signing up or creating deals or any other issues:</h4>
					<p>A: Please contact our customer support specialists who will gladly help you resolve your issue. Please contact us at <a href="mailto:support@dealsenroute.com">support@dealsenroute.com</a></p>
				</div>
			</div>
		</div>
	</section>

@endsection

