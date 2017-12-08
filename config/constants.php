<?php

return [
    //message for api
    'APP_ERROR' => 'Something Went Wrong.Please Try Again Later.',
    'SUBSCRIPTION_ERROR' => 'Thank You! Please check your email to activate your account,Subscription not complete,Please try again!!',
    //user
    'USER_UPDATE' => 'User Updated Successfully.',
    'USER_EMAIL_VERIFICATION' => 'Thank You! Please check your email to activate your account.',
    'USER_LOGIN' => 'User login successfully',
    'USER_NOT_CONFIRMED' => 'You Have Not Confirmed Your Email Yet.Please Check Your Email.',
    'USER_UPDATE_PROFILE' => 'profile updated successfully',
    'USER_UPDATED_SUCCESSFULLY' => 'User Updated Successsfully.',
    'USER_UNAUTHENTICATED' => 'unauthenticated',
    'USER_DETAIL' => 'user detail',
    'DASHBOARD_DETAIL' => 'Dashboard detail',
    'REDEEM_COUPON_YEAR' => 'Monthly Redeem Coupon detail',
    'USER_CREATED' => 'User Created Successfully.',
    //email
    'EMAIL_VERIFIED' => 'You have successfully verified your account.',
    'EMAIL_CODE_EXPIRED' => 'Sorry code which you entered has expired.',
    'EMAIL_ALREADY_CONFIRMED' => 'You have already confirmed your email.',
    //vendor 
    'VENDOR_CREATED' => 'vendor created successfully',
    'VENDOR_UPDATED' => 'vendor updated successfully.',
    'CATEGORY_LIST' => 'category listed successfully.',
    'CATEGORY_SAVE' => 'saved category listed successfully',
    'NO_RECORDS' => 'no records found.',
    'COUPON_LIST' => 'coupon listed successfully,',
    'COUPON_DETAIL' => 'coupon detial.',
    'USER_LOGOUT_SUCCESS' => 'User logout successfully.',
    'NOT_AUTHORIZED' => 'you are not allowed to perform the action.',
    'USER_SELECT_PLAN' => 'You Have Not Selected Any Plan Yet.Please Select Anyone.',
    'USER_LOGIN_SUCCESS' => 'Logged In Successfully',
    'ALREADY_SUBCRIBE' => 'You Already Subscribe To The Plan.',
    'USER_PASSWORD_FETCH' => 'We Are Unable To Find Your E-Mail.',
    'USER_PASSWORD_RESET' => 'We have e-mailed you a Password Reset Link.Please Check Your Email.',
    'COUPON_ADD_FAV' => 'added coupon to favourtie successfully.',
    'COMMENT_UPDATE' => 'comment updated successfully.',
    'ADD_FB_FRIEND' => 'successfully added fb friend',
    'ACTIVITY_LIKE_SUCCESS' => 'activity liked successfully.',
    'ACTIVITY_LIST' => 'activity listed successfully.',
    'COMMENT_ADD' => 'comment added successfully.',
    'COUPON_UPDATE' => 'Coupon Updated Successfully.',
    'COMMENT_LIST' => 'comment listed successfully.',
    'COUPON_ADD_REDEEM' => 'coupon redeemed successfully,',
    'COUPON_DELETE' => 'coupon deleted successfully.',
    'COUPON_CREATE' => 'Coupon Added Successfully.',
    'EARTH_RADIUS' => 3959,
    'USER_DELETE' => 'sorry your account have been deleted by admin.please contact admin.',
    'USER_DEACTIVE' => 'sorry your account have been deactivated by admin.please contact admin.',
    'CONTACT_SUCCESS' => 'Mail Send Successfully.',
    //client mail
    'CLIENT_MAIL' => 'support@dealsenroute.com',
    //activity message
    'ACTVITY_CREATOR_MESSAGE_1' => '{{created_by}} shared {{coupon_name}} coupon with {{shared_name}}',
    'ACTVITY_CREATOR_MESSAGE' => '{{created_by}} shared {{coupon_name}} coupon with {{shared_name}} and {{count}} others',
    'ACTVITY_FRIEND_MESSAGE' => '{{created_by}} shared a {{coupon_name}} coupon with you ',
    'ACTVITY_FRIEND_REDEEM' => 'Your friend {{created_by}} has redeemed coupon {{coupon_name}}',
    'SHARE_ACTIVITY' => 'shared activity successfully.',
    //notification message
    //-- geo notification
    'NOTIFY_GEO' => [0 => "We have a, {{coupon_name}} at {{vendor_name}} just for you!",
        1 => 'You have to check out this deal from {{vendor_name}}.',
        2 => 'We think you’d like this deal from {{vendor_name}}.',
        3 => 'Looks like there is a popular deal at {{vendor_name}} and it is in one of your  favorite categories.',
        4 => ' Your friends have been redeeming this deal. Check to see what’s inside.',
        5 => 'This was the most popular deal in your area today, check it out.',
    ],
    //-- coupon expire in fav(favorites only, do not notify about coupons expiring that are not favorited)
    'NOTIFY_FAV_EXPIRE' => '{{coupon_name}} is about to expire at {{vendor_name}}! Don’t miss the chance to save.',
    //-- 5 coupons left in the deal (only notify if deal is in favorites)
    'NOTIFY_FAV_EXPIRE_5' => 'Hurry, there are only 5 coupons left for this deal!',
    //-- Coupon redemption:
    'NOTIFY_REDEEMPTION' => 'Successful redemption! Your wallet thanks you kindly!',
    //-- Coupon redemption failed:
    'NOTIFY_REDEEMPTION_FAILED' => 'Oh no! Something went wrong. Don’t worry we give second chances. Try again.',
    //-- You shared a Coupon:
    'NOTIFY_SHARE_COUPON' => 'Sharing is caring! Keep sharing to make your wallet and friends happy by helping them save!',
    //-- Friend shared coupon with you
    'NOTIFY_SHARED_COUPON' => '{{from_id}} shared a deal with you. Check out the deal to see what’s inside!',
    //user
    'USER_NOT_FOUND' => 'we could not find user with that email.',
    'TOKEN_EXPIRED' => 'your token has expired.',
    'USER_PASSWORD_SUCCESS' => 'password changed successfully,',
    'NOTI_SUCCESS' => 'notification read successfully.',
    'NOTI_LIST' => 'notification listed successfully.',
    //local path
    'IMAGE_PATH' => 'storage/app/public/',
    'PAGINATE' => 10,
    //notification
    //stripe keys
    'STRIPE_KEY' => 'pk_test_dvnwoMABEgschsRqPZRuGJrp',
    'STRIPE_SECRET' => 'sk_test_ZBNhTnKmE3hEkk26awNMDdcc',
    'STRIPE_VERSION' => '2017-08-15',
    'DATE_FORMAT' => 'n/j/y - g:00 A',
    'SETTINGS' => 'Settings Page Details!',
];




